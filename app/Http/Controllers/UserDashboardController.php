<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\UserMedia;

class UserDashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access your dashboard.');
        }

        $tab = $request->get('tab', 'my-account'); // Default to 'my-account'

        if ($tab === 'media-files') {
            return $this->userMediaFiles($request);
        }

        return view('AdminArea.UserDashboard', [
            'user' => $user,
            'activeTab' => 'my-account'
        ]);
    }

    /**
     * Show user's media files
     */
    public function userMediaFiles(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access your dashboard.');
        }

        // Get filter parameter
        $selectedCategory = $request->get('category', 'all');

        // Get all media files for this user only
        $allMedia = UserMedia::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        // Get all categories for this user for dropdown
        $categories = UserMedia::where('user_id', $user->id)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();
        
        // Set default category to first category if available
        $defaultCategory = $categories->isNotEmpty() ? $categories->first() : 'all';
        $selectedCategory = $request->get('category', $defaultCategory);
        
        // Organize media by category
        $mediaByCategory = [];
        foreach ($allMedia as $media) {
            // Filter by category if selected
            if ($selectedCategory !== 'all' && $media->category !== $selectedCategory) {
                continue;
            }
            
            $category = $media->category;
            
            if (!isset($mediaByCategory[$category])) {
                $mediaByCategory[$category] = [
                    'category' => $category,
                    'images' => [],
                    'videos' => []
                ];
            }
            
            // Add images
            if ($media->images && is_array($media->images)) {
                foreach ($media->images as $index => $imagePath) {
                    if (Storage::disk('public')->exists('user_media/' . $imagePath)) {
                        $mediaByCategory[$category]['images'][] = [
                            'id' => $media->id,
                            'path' => $imagePath,
                            'url' => asset('storage/user_media/' . $imagePath),
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
            
            // Add videos
            if ($media->videos && is_array($media->videos)) {
                foreach ($media->videos as $index => $videoPath) {
                    if (Storage::disk('public')->exists('user_media/' . $videoPath)) {
                        $mediaByCategory[$category]['videos'][] = [
                            'id' => $media->id,
                            'path' => $videoPath,
                            'url' => asset('storage/user_media/' . $videoPath),
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
        }

        return view('AdminArea.UserDashboard', [
            'user' => $user,
            'activeTab' => 'media-files',
            'mediaByCategory' => $mediaByCategory,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access your dashboard.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists('profile_images/' . $user->profile_image)) {
                Storage::disk('public')->delete('profile_images/' . $user->profile_image);
            }

            // Store new image
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $user->id . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageName, 'public');
            $user->profile_image = $imageName;
        }

        $user->save();

        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
    }
}
