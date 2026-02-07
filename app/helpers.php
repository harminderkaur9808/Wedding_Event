<?php

if (!function_exists('secure_media_url')) {
    /**
     * URL for storage files that require login. Use instead of asset('storage/...').
     * Returns null if path is empty.
     */
    function secure_media_url(?string $path): ?string
    {
        $path = $path ? ltrim($path, '/\\') : null;
        if ($path === null || $path === '') {
            return null;
        }
        return route('media.serve', ['path' => $path]);
    }
}
