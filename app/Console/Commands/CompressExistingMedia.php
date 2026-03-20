<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CompressExistingMedia extends Command
{
    protected $signature   = 'media:compress-existing
                              {--dry-run : Preview what would happen without making changes}
                              {--force   : Re-compress even if an original already exists}';

    protected $description = 'Compress all existing images in user_media/, saving originals to user_media_originals/.';

    private const IMAGE_EXTS   = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private const TARGET_BYTES = 500 * 1024; // 500 KB

    public function handle(): int
    {
        $disk   = Storage::disk('public');
        $dryRun = $this->option('dry-run');
        $force  = $this->option('force');

        if (! $dryRun) {
            $disk->makeDirectory('user_media');
            $disk->makeDirectory('user_media_originals');
        }

        $files = collect($disk->files('user_media'))
            ->filter(fn ($f) => in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), self::IMAGE_EXTS))
            ->values();

        if ($files->isEmpty()) {
            $this->info('No images found in user_media/.');
            return 0;
        }

        $this->info("Found {$files->count()} image(s) in user_media/.");
        if ($dryRun) {
            $this->warn('DRY RUN — no files will be changed.');
        }

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $stats = ['compressed' => 0, 'skipped' => 0, 'failed' => 0];

        foreach ($files as $file) {
            $basename = basename($file);
            $base     = pathinfo($basename, PATHINFO_FILENAME);

            // Skip if already processed (original exists) unless --force
            if (! $force && $this->originalExists($disk, $base)) {
                $stats['skipped']++;
                $bar->advance();
                continue;
            }

            $srcPath  = $disk->path('user_media/' . $basename);
            $origDest = $disk->path('user_media_originals/' . $basename);

            if ($dryRun) {
                $sizeBefore = round(filesize($srcPath) / 1024);
                $this->newLine();
                $this->line("  [DRY] {$basename} ({$sizeBefore} KB) → would compress");
                $stats['compressed']++;
                $bar->advance();
                continue;
            }

            // 1. Copy untouched original
            copy($srcPath, $origDest);

            // 2. Compress in-place (overwrite user_media/ with compressed content, keep filename)
            $ok = $this->compressImageToJpeg($srcPath, $srcPath, self::TARGET_BYTES);

            if ($ok) {
                $sizeAfter = round(filesize($srcPath) / 1024);
                $this->newLine();
                $this->line("  <info>✓</info> {$basename} → {$sizeAfter} KB");
                $stats['compressed']++;
            } else {
                // GD failed — remove the broken dest if any, leave original intact
                $this->newLine();
                $this->warn("  ✗ {$basename} — GD could not process; skipped.");
                // Restore from what we just copied
                copy($origDest, $srcPath);
                $stats['failed']++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info(sprintf(
            'Done — Compressed: %d | Already done (skipped): %d | Failed: %d',
            $stats['compressed'],
            $stats['skipped'],
            $stats['failed']
        ));

        return 0;
    }

    /**
     * Check whether any original already exists for a given base filename.
     */
    private function originalExists(\Illuminate\Contracts\Filesystem\Filesystem $disk, string $base): bool
    {
        foreach (self::IMAGE_EXTS as $ext) {
            if ($disk->exists('user_media_originals/' . $base . '.' . $ext)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Compress an image file to JPEG targeting ≤ $targetBytes using PHP GD.
     * Iteratively reduces JPEG quality then scales dimensions until the target is met.
     * Returns true on success, false if GD is unavailable or the source cannot be decoded.
     */
    private function compressImageToJpeg(string $sourcePath, string $destPath, int $targetBytes): bool
    {
        if (! extension_loaded('gd')) {
            return false;
        }

        $mime = @mime_content_type($sourcePath);

        $img = match (true) {
            in_array($mime, ['image/jpeg', 'image/jpg'], true)                        => @imagecreatefromjpeg($sourcePath),
            $mime === 'image/png'                                                      => @imagecreatefrompng($sourcePath),
            $mime === 'image/gif'                                                      => @imagecreatefromgif($sourcePath),
            $mime === 'image/webp' && function_exists('imagecreatefromwebp')           => @imagecreatefromwebp($sourcePath),
            default                                                                    => null,
        };

        if (! $img) {
            return false;
        }

        // Flatten any transparency onto white (PNG/GIF → JPEG)
        $origW = imagesx($img);
        $origH = imagesy($img);
        $flat  = imagecreatetruecolor($origW, $origH);
        $white = imagecolorallocate($flat, 255, 255, 255);
        imagefill($flat, 0, 0, $white);
        imagecopy($flat, $img, 0, 0, 0, 0, $origW, $origH);
        imagedestroy($img);
        $img = $flat;

        $scale    = 1.0;
        $quality  = 82;
        $attempts = 0;

        while ($attempts < 20) {
            $attempts++;
            $sw = max(1, (int) round($origW * $scale));
            $sh = max(1, (int) round($origH * $scale));

            if ($scale < 1.0) {
                $work = imagecreatetruecolor($sw, $sh);
                imagecopyresampled($work, $img, 0, 0, 0, 0, $sw, $sh, $origW, $origH);
            } else {
                $work = $img;
            }

            ob_start();
            imagejpeg($work, null, $quality);
            $buffer = ob_get_clean();

            if ($scale < 1.0) {
                imagedestroy($work);
            }

            if (strlen($buffer) <= $targetBytes || $attempts >= 20) {
                file_put_contents($destPath, $buffer);
                imagedestroy($img);
                return true;
            }

            if ($quality > 25) {
                $quality -= 10;
            } else {
                $scale   *= 0.72;
                $quality  = 72;
            }
        }

        imagedestroy($img);
        return false;
    }
}
