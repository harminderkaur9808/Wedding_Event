<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProtectedMediaController extends Controller
{
    /**
     * Serve a file from storage (public disk) only when the user is logged in.
     * Used for profile images, page section images, local attractions, etc.
     * Route is protected by auth middleware.
     */
    public function serve(Request $request)
    {
        $path = $request->query('path');
        if (!$path || !is_string($path)) {
            abort(404);
        }

        // Path must be relative; no directory traversal
        $path = ltrim($path, '/\\');
        if (preg_match('#(^\.\.|/\.\.|\\\\\.\.)#', $path)) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($path);
        $mime     = \Illuminate\Support\Facades\File::mimeType($fullPath);
        $filename = basename($path);
        $mtime    = filemtime($fullPath);
        $etag     = '"' . md5($path . $mtime) . '"';

        // Return 304 Not Modified if browser already has this version cached
        $ifNoneMatch   = request()->header('If-None-Match');
        $ifModifiedSince = request()->header('If-Modified-Since');
        $lastModified  = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
        if ($ifNoneMatch === $etag || ($ifModifiedSince && strtotime($ifModifiedSince) >= $mtime)) {
            return response('', 304);
        }

        return response()->file($fullPath, [
            'Content-Type'     => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control'    => 'private, max-age=86400, must-revalidate',
            'ETag'             => $etag,
            'Last-Modified'    => $lastModified,
        ]);
    }
}
