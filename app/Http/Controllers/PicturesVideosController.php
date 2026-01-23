<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserMedia;

class PicturesVideosController extends Controller
{
    /**
     * Show pictures and videos gallery
     */
    public function index()
    {
        return view('pages.pictures_videos.index');
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
            // Get all uploaded media from database for this category (from all users and admins)
            $allUserMedia = UserMedia::where('category', $category)->get();
            
            foreach ($allUserMedia as $userMedia) {
                if ($type === 'images' && $userMedia->images && is_array($userMedia->images)) {
                    foreach ($userMedia->images as $index => $imagePath) {
                        // Check if file exists before adding
                        if (Storage::disk('public')->exists('user_media/' . $imagePath)) {
                            $items[] = [
                                'id' => 'media_' . $userMedia->id . '_img_' . $index,
                                'url' => asset('storage/user_media/' . $imagePath),
                                'title' => 'Uploaded Image ' . ($index + 1),
                                'is_user_media' => true,
                                'user_id' => $userMedia->user_id,
                                'is_current_user' => $userMedia->user_id === Auth::id()
                            ];
                        }
                    }
                } elseif ($type === 'videos' && $userMedia->videos && is_array($userMedia->videos)) {
                    foreach ($userMedia->videos as $index => $videoPath) {
                        // Check if file exists before adding
                        if (Storage::disk('public')->exists('user_media/' . $videoPath)) {
                            $items[] = [
                                'id' => 'media_' . $userMedia->id . '_vid_' . $index,
                                'url' => asset('storage/user_media/' . $videoPath),
                                'title' => 'Uploaded Video ' . ($index + 1),
                                'is_user_media' => true,
                                'is_video' => true,
                                'user_id' => $userMedia->user_id,
                                'is_current_user' => $userMedia->user_id === Auth::id()
                            ];
                        }
                    }
                }
            }
        }
        
        // Category names mapping
        $categoryNames = [
            'roka' => 'Roka',
            'shagun' => 'Shagun',
            'vatna' => 'Vatna',
            'sangeet' => 'Sangeet in Phoenix',
            'mehndi' => 'Mehndi',
            'jaggo' => 'Jaggo and Giddha',
            'sehra' => 'Sehra Bandhi and Surma',
            'barat' => 'Barat and Milni',
            'wedding' => 'Wedding'
        ];
        
        $categoryName = $categoryNames[$category] ?? ucfirst($category);
        
        return view('pages.pictures_videos.category', [
            'category' => $category,
            'categoryName' => $categoryName,
            'type' => $type,
            'items' => $items
        ]);
    }

    /**
     * Upload media for a category
     */
    public function uploadMedia(Request $request, $category)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to upload media.');
        }

        $user = Auth::user();
        
        $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'videos.*' => 'nullable|mimes:mp4,avi,mov,wmv,flv,webm|max:51200', // 50MB max
        ]);

        // Get or create user media record for this category
        $userMedia = UserMedia::firstOrNew([
            'user_id' => $user->id,
            'category' => strtolower($category),
        ]);

        // Auto-fill email and role from user
        $userMedia->email = $user->email;
        $userMedia->role = $user->role;
        
        // Initialize arrays if they don't exist
        $images = $userMedia->images ?? [];
        $videos = $userMedia->videos ?? [];

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $user->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('user_media', $imageName, 'public');
                $images[] = $imageName;
            }
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoName = time() . '_' . $user->id . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
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

}
