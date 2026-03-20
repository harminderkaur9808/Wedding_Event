<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserMedia;
use App\Models\GalleryDisplayOrder;
use App\Models\PictureVideoCategory;

class PicturesVideosController extends Controller
{
    /**
     * Show pictures and videos gallery
     */
    public function index()
    {
        $categories = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('picture_video_categories')) {
            $categories = PictureVideoCategory::orderBy('sort_order')->get();
        }
        if ($categories->isEmpty()) {
            $categories = $this->getDefaultCategories();
        }
        return view('pages.pictures_videos.index', ['categories' => $categories]);
    }

    /**
     * Default categories when picture_video_categories table is not yet migrated.
     */
    private function getDefaultCategories(): \Illuminate\Support\Collection
    {
        return collect([
            (object)['slug' => 'roka', 'name' => 'ROKA', 'sort_order' => 1, 'image_path' => 'Roka_image.png'],
            (object)['slug' => 'pre_shagun', 'name' => 'Pre-Shagun pictures', 'sort_order' => 2, 'image_path' => 'Pre_shagun_image.png'],
            (object)['slug' => 'shagun', 'name' => 'SHAGUN', 'sort_order' => 3, 'image_path' => 'Shagun_image.png'],
            (object)['slug' => 'vatna', 'name' => 'VATNA', 'sort_order' => 4, 'image_path' => 'Vatna_images.png'],
            (object)['slug' => 'sangeet', 'name' => 'SANGEET IN PHOENIX', 'sort_order' => 5, 'image_path' => 'Sangeet_in_Phoenix.png'],
            (object)['slug' => 'mehndi', 'name' => 'MEHNDI', 'sort_order' => 6, 'image_path' => 'Mehndi_wedding.png'],
            (object)['slug' => 'jaggo', 'name' => 'JAGGO AND GIDDHA', 'sort_order' => 7, 'image_path' => 'Jaggo_and_Giddha.png'],
            (object)['slug' => 'sehra', 'name' => 'SEHRA BANDHI AND SURMA', 'sort_order' => 8, 'image_path' => 'Sehra_bandhi_and_Surma.png'],
            (object)['slug' => 'barat', 'name' => 'BARAT AND MILNI', 'sort_order' => 9, 'image_path' => 'Barat_and_Milni.png'],
            (object)['slug' => 'wedding', 'name' => 'WEDDING', 'sort_order' => 10, 'image_path' => 'Wedding_img.png'],
        ]);
    }

    /**
     * Show category gallery (e.g., Roka, Shagun, etc.)
     */
    public function showCategory($category, Request $request)
    {
        $type = $request->get('type', 'images'); // 'images' or 'videos'
        $category = strtolower($category);
        
        // Only show images/videos if user is logged in
        $items = [];
        
        if (Auth::check()) {
            // Get all uploaded media from database for this category (newest first by updated_at)
            $allUserMedia = UserMedia::where('category', $category)->orderByDesc('updated_at')->get();

            foreach ($allUserMedia as $userMedia) {
                if ($type === 'images' && $userMedia->images && is_array($userMedia->images)) {
                    // preserve_keys=true keeps original DB-array index so download_url resolves to the CORRECT file
                    $imagesList = array_reverse($userMedia->images, true);
                    foreach ($imagesList as $originalIndex => $imagePath) {
                        $storagePath = 'user_media/' . ltrim($imagePath, '/\\');
                        if (Storage::disk('public')->exists($storagePath)) {
                            $items[] = [
                                'id'              => 'media_' . $userMedia->id . '_img_' . $originalIndex,
                                'url'             => Storage::disk('public')->url($storagePath),
                                'title'           => 'Uploaded Image',
                                'is_user_media'   => true,
                                'user_id'         => $userMedia->user_id,
                                'is_current_user' => $userMedia->user_id === Auth::id(),
                                'sort_ts'         => $this->getSortTimestampFromFilename($imagePath, $userMedia->updated_at),
                                // originalIndex = position in the DB array → downloadMedia fetches the right file
                                'download_url'    => route('pictures_videos.download', ['mediaId' => $userMedia->id, 'type' => 'image', 'index' => $originalIndex]),
                            ];
                        }
                    }
                } elseif ($type === 'videos' && $userMedia->videos && is_array($userMedia->videos)) {
                    $videosList = array_reverse($userMedia->videos, true);
                    foreach ($videosList as $originalIndex => $videoPath) {
                        $storagePath = 'user_media/' . ltrim($videoPath, '/\\');
                        if (Storage::disk('public')->exists($storagePath)) {
                            $items[] = [
                                'id'              => 'media_' . $userMedia->id . '_vid_' . $originalIndex,
                                'url'             => Storage::disk('public')->url($storagePath),
                                'title'           => 'Uploaded Video',
                                'is_user_media'   => true,
                                'is_video'        => true,
                                'user_id'         => $userMedia->user_id,
                                'is_current_user' => $userMedia->user_id === Auth::id(),
                                'sort_ts'         => $this->getSortTimestampFromFilename($videoPath, $userMedia->updated_at),
                                'download_url'    => route('pictures_videos.download', ['mediaId' => $userMedia->id, 'type' => 'video', 'index' => $originalIndex]),
                            ];
                        }
                    }
                }
            }
        }

        // Sort all items by upload time (newest first)
        usort($items, function ($a, $b) {
            return ($b['sort_ts'] ?? 0) <=> ($a['sort_ts'] ?? 0);
        });

        // Apply admin-saved display order if set (admin drag-and-drop order)
        $savedOrder = GalleryDisplayOrder::where('category', $category)->where('type', $type)->first();
        if ($savedOrder && !empty($savedOrder->order)) {
            $orderIds = $savedOrder->order;
            $byId = [];
            foreach ($items as $item) {
                $byId[$item['id']] = $item;
            }
            $ordered = [];
            foreach ($orderIds as $id) {
                if (isset($byId[$id])) {
                    $ordered[] = $byId[$id];
                    unset($byId[$id]);
                }
            }
            // Items not in the saved order are newly uploaded — put them FIRST (newest at top)
            // $items is already sorted newest-first by sort_ts so $byId remainders are newest-first
            $newItems = [];
            foreach ($items as $item) {
                if (isset($byId[$item['id']])) {
                    $newItems[] = $item;
                }
            }
            $items = array_merge($newItems, $ordered);
        }

        // Set title by position (1, 2, 3...) and remove sort_ts
        $items = array_values(array_map(function ($item, $index) {
            unset($item['sort_ts']);
            $item['title'] = ($item['is_video'] ?? false) ? 'Uploaded Video ' . ($index + 1) : 'Uploaded Image ' . ($index + 1);
            return $item;
        }, $items, array_keys($items)));
        
        // Category names mapping (include Pre-Shagun)
        $categoryNames = [
            'roka' => 'Roka',
            'pre_shagun' => 'Pre-Shagun pictures',
            'shagun' => 'Shagun',
            'vatna' => 'Vatna',
            'sangeet' => 'Sangeet in Phoenix',
            'mehndi' => 'Mehndi',
            'jaggo' => 'Jaggo and Giddha',
            'sehra' => 'Sehra Bandhi and Surma',
            'barat' => 'Barat and Milni',
            'wedding' => 'Wedding'
        ];
        
        $categoryName = $categoryNames[$category] ?? ucfirst(str_replace('_', ' ', $category));
        
        $user = Auth::user();
        $canReorder = $user && $user->isAdmin();

        return view('pages.pictures_videos.category', [
            'category' => $category,
            'categoryName' => $categoryName,
            'type' => $type,
            'items' => $items,
            'canReorder' => $canReorder,
        ]);
    }

    /**
     * Update gallery display order (admin only). Saves the order of images/videos for drag-and-drop.
     */
    public function updateGalleryOrder(Request $request, $category)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Access denied. Admin only.'], 403);
        }

        $category = strtolower($category);
        $type = $request->input('type', 'images');
        if (!in_array($type, ['images', 'videos'], true)) {
            return response()->json(['success' => false, 'message' => 'Invalid type.'], 422);
        }

        $order = $request->input('order');
        if (!is_array($order)) {
            return response()->json(['success' => false, 'message' => 'Order must be an array of item ids.'], 422);
        }

        // Sanitize: only allow strings that look like our item ids (media_123_img_0 or media_123_vid_0)
        $order = array_values(array_filter(array_map(function ($id) {
            return is_string($id) && preg_match('/^media_\d+_(img|vid)_\d+$/', $id) ? $id : null;
        }, $order)));

        GalleryDisplayOrder::updateOrCreate(
            ['category' => $category, 'type' => $type],
            ['order' => $order]
        );

        return response()->json(['success' => true, 'message' => 'Order saved.']);
    }

    /**
     * Get sort timestamp from filename (format: 1234567890_userId_uniqid.ext) or fallback to model date.
     */
    private function getSortTimestampFromFilename(string $filename, $fallbackDate): int
    {
        $base = basename($filename);
        if (preg_match('/^(\d+)_/', $base, $m)) {
            return (int) $m[1];
        }
        return $fallbackDate ? (int) \Carbon\Carbon::parse($fallbackDate)->timestamp : 0;
    }

    /**
     * Upload media for a category.
     * Images: saves original to user_media_originals/ and a compressed JPEG to user_media/ for display.
     * Videos: saved as-is to user_media/.
     */
    public function uploadMedia(Request $request, $category)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to upload media.');
        }

        $user = Auth::user();

        $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20 MB max per image
            'videos.*' => 'nullable|mimes:mp4,avi,mov,wmv,flv,webm|max:204800',   // 200 MB max per video
        ]);

        $userMedia = UserMedia::firstOrNew([
            'user_id'  => $user->id,
            'category' => strtolower($category),
        ]);

        $userMedia->email = $user->email;
        $userMedia->role  = $user->role;

        $images = $userMedia->images ?? [];
        $videos = $userMedia->videos ?? [];

        // Ensure storage directories exist
        Storage::disk('public')->makeDirectory('user_media');
        Storage::disk('public')->makeDirectory('user_media_originals');

        // Handle image uploads — save original + compressed display copy
        if ($request->hasFile('images')) {
            // Use millisecond-precision base timestamp so each file in the same batch
            // gets a unique, ordered sort_ts even when uploaded within the same second.
            $batchMs = (int) (microtime(true) * 1000);
            foreach ($request->file('images') as $loopIdx => $image) {
                $base    = ($batchMs + $loopIdx) . '_' . $user->id . '_' . uniqid();
                $origExt = strtolower($image->getClientOriginalExtension() ?: 'jpg');
                $origName    = $base . '.' . $origExt;   // e.g. 17000000_1_abc.png
                $displayName = $base . '.jpg';            // e.g. 17000000_1_abc.jpg  (always JPEG for display)

                // 1. Save untouched original for download
                $image->storeAs('user_media_originals', $origName, 'public');

                // 2. Compress to JPEG for fast gallery display
                $origFullPath    = Storage::disk('public')->path('user_media_originals/' . $origName);
                $displayFullPath = Storage::disk('public')->path('user_media/' . $displayName);

                $ok = $this->compressImageToJpeg($origFullPath, $displayFullPath);
                if (! $ok) {
                    // GD unavailable or unreadable — copy original as fallback
                    copy($origFullPath, $displayFullPath);
                }

                $images[] = $displayName;
            }
        }

        // Handle video uploads — saved as-is, no originals folder needed
        if ($request->hasFile('videos')) {
            $videoBatchMs = (int) (microtime(true) * 1000);
            foreach ($request->file('videos') as $loopIdx => $video) {
                $videoName = ($videoBatchMs + $loopIdx) . '_' . $user->id . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                $video->storeAs('user_media', $videoName, 'public');
                $videos[] = $videoName;
            }
        }

        $userMedia->images = $images;
        $userMedia->videos = $videos;
        $userMedia->save();

        $type = $request->get('type', 'images');
        return redirect()->route('pictures_videos.category', ['category' => $category, 'type' => $type])
            ->with('success', 'Media uploaded successfully!');
    }

    /**
     * Compress an image to JPEG targeting ≤ 500 KB using PHP GD.
     * Iteratively reduces quality (82 → 25) then scales dimensions (×0.72 each pass) until target is met.
     * Returns true on success, false if GD is unavailable or the source cannot be decoded.
     */
    private function compressImageToJpeg(string $sourcePath, string $destPath, int $targetBytes = 500 * 1024): bool
    {
        if (! extension_loaded('gd')) {
            return false;
        }

        $mime = @mime_content_type($sourcePath);
        $img  = match (true) {
            in_array($mime, ['image/jpeg', 'image/jpg'], true) => @imagecreatefromjpeg($sourcePath),
            $mime === 'image/png'  => @imagecreatefrompng($sourcePath),
            $mime === 'image/gif'  => @imagecreatefromgif($sourcePath),
            $mime === 'image/webp' && function_exists('imagecreatefromwebp') => @imagecreatefromwebp($sourcePath),
            default => null,
        };

        if (! $img) {
            return false;
        }

        // Flatten transparency onto a white background (PNG/GIF → JPEG loses alpha otherwise)
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

            // Reduce quality first; once at floor, shrink dimensions
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

    /**
     * Find the original (uncompressed) file path for a display filename.
     * The display file is always .jpg; the original may have been .png, .gif, .webp, etc.
     */
    private function findOriginalPath(string $displayFilename): ?string
    {
        $base = pathinfo($displayFilename, PATHINFO_FILENAME);
        foreach (['jpg', 'jpeg', 'png', 'gif', 'webp'] as $ext) {
            $try = 'user_media_originals/' . $base . '.' . $ext;
            if (Storage::disk('public')->exists($try)) {
                return $try;
            }
        }
        return null;
    }

    /**
     * Serve a single image or video inline (auth required via route middleware).
     * Used for gallery display so image/video URLs cannot be viewed without login.
     */
    public function serveMedia($mediaId, $type, $index)
    {
        $userMedia = UserMedia::findOrFail($mediaId);
        $index = (int) $index;

        if ($type === 'image') {
            $files = $userMedia->images ?? [];
            if (!isset($files[$index])) {
                abort(404);
            }
            $path = 'user_media/' . ltrim($files[$index], '/\\');
        } else {
            $files = $userMedia->videos ?? [];
            if (!isset($files[$index])) {
                abort(404);
            }
            $path = 'user_media/' . ltrim($files[$index], '/\\');
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);
        $mime     = \Illuminate\Support\Facades\File::mimeType($fullPath);
        $filename = basename($path);
        $mtime    = filemtime($fullPath);
        $etag     = '"' . md5($path . $mtime) . '"';

        $ifNoneMatch    = request()->header('If-None-Match');
        $ifModifiedSince = request()->header('If-Modified-Since');
        $lastModified   = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
        if ($ifNoneMatch === $etag || ($ifModifiedSince && strtotime($ifModifiedSince) >= $mtime)) {
            return response('', 304);
        }

        return response()->file($fullPath, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control'       => 'private, max-age=86400, must-revalidate',
            'ETag'                => $etag,
            'Last-Modified'       => $lastModified,
        ]);
    }

    /**
     * Download a single image or video (auth required).
     * Images: serves the original uncompressed file from user_media_originals/ if available,
     * falling back to the display copy in user_media/.
     * Videos: served directly from user_media/.
     */
    public function downloadMedia($mediaId, $type, $index)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to download media.');
        }

        $userMedia = UserMedia::findOrFail($mediaId);
        $index = (int) $index;

        if ($type === 'image') {
            $files = $userMedia->images ?? [];
            if (! isset($files[$index])) {
                abort(404);
            }
            $displayFilename = ltrim($files[$index], '/\\');
            // Prefer original (uncompressed); fall back to display copy
            $origPath = $this->findOriginalPath($displayFilename);
            $path     = $origPath ?? 'user_media/' . $displayFilename;
        } else {
            $files = $userMedia->videos ?? [];
            if (! isset($files[$index])) {
                abort(404);
            }
            $path = 'user_media/' . ltrim($files[$index], '/\\');
        }

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $filename = basename($path);
        return Storage::disk('public')->download($path, $filename, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

}
