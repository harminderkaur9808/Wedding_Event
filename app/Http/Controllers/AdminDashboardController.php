<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserApprovalMail;
use App\Mail\UserRejectionMail;
use App\Mail\AccountCreatedByAdminMail;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ensure user is admin
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $tab = $request->get('tab', 'my-account'); // Default to 'my-account'

        if ($tab === 'all-users') {
            $users = User::orderBy('created_at', 'desc')->paginate(10);
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'users' => $users,
                'activeTab' => 'all-users'
            ]);
        }

        if ($tab === 'media-files') {
            return $this->mediaFiles($request);
        }

        return view('AdminArea.AdminDashboard', [
            'user' => $user,
            'activeTab' => 'my-account'
        ]);
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Ensure user is admin
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
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

        return redirect()->route('admin.dashboard', ['tab' => 'my-account'])->with('success', 'Profile updated successfully!');
    }

    /**
     * Approve a user
     */
    public function approveUser($id)
    {
        $admin = Auth::user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $user = User::findOrFail($id);
        
        // Don't allow approving admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Admin users are automatically approved.');
        }

        // Don't change password - keep the original one from signup
        $user->is_approved = true;
        $user->save();

        // Send approval email without password (user already received it in welcome email)
        try {
            Mail::to($user->email)->send(new UserApprovalMail($user, null));
        } catch (\Exception $e) {
            \Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard', ['tab' => 'all-users'])
            ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' has been approved successfully! An approval email has been sent.');
    }

    /**
     * Reject/Unapprove a user
     */
    public function rejectUser($id)
    {
        $admin = Auth::user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $user = User::findOrFail($id);
        
        // Don't allow rejecting admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot reject admin users.');
        }

        $user->is_approved = false;
        $user->save();

        // Send rejection email
        try {
            Mail::to($user->email)->send(new UserRejectionMail($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard', ['tab' => 'all-users'])
            ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' has been rejected. An email notification has been sent.');
    }

    /**
     * Show all media files
     */
    public function mediaFiles(Request $request)
    {
        $admin = Auth::user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Get filter parameters - default to admin's own profile
        $requestUserId = $request->get('user_id');
        $selectedUserId = $requestUserId !== null ? $requestUserId : $admin->id;
        
        // Get all categories for dropdown (filter by selected user)
        $categoryQuery = UserMedia::query();
        if ($selectedUserId !== 'all') {
            $categoryQuery->where('user_id', $selectedUserId);
        }
        $categories = $categoryQuery->distinct()->pluck('category')->filter()->sort()->values();
        
        // Set default category to first category if available
        $defaultCategory = $categories->isNotEmpty() ? $categories->first() : 'all';
        $selectedCategory = $request->get('category', $defaultCategory);

        // Get all media files grouped by user and category
        $allMedia = UserMedia::with('user')->orderBy('created_at', 'desc')->get();
        
        // Get all users who have uploaded media for dropdown
        $userIds = $allMedia->pluck('user_id')->unique()->filter()->values();
        $usersWithMedia = $userIds->isNotEmpty() 
            ? User::whereIn('id', $userIds)
                ->orderBy('is_admin', 'desc')
                ->orderBy('first_name')
                ->get()
            : collect();
        
        // Organize media by user
        $mediaByUser = [];
        foreach ($allMedia as $media) {
            $userId = $media->user_id;
            
            // Filter by user if selected (default is admin's own profile)
            if ($selectedUserId !== 'all' && $userId != $selectedUserId) {
                continue;
            }
            
            $userName = $media->user ? $media->user->first_name . ' ' . $media->user->last_name : 'Unknown User';
            $userEmail = $media->email;
            
            // Filter by category if selected (default is first category)
            if ($selectedCategory !== 'all' && $media->category !== $selectedCategory) {
                continue;
            }
            
            if (!isset($mediaByUser[$userId])) {
                $mediaByUser[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_email' => $userEmail,
                    'is_admin' => $media->user && $media->user->isAdmin(),
                    'categories' => []
                ];
            }
            
            // Add images
            if ($media->images && is_array($media->images)) {
                foreach ($media->images as $index => $imagePath) {
                    if (Storage::disk('public')->exists('user_media/' . $imagePath)) {
                        $mediaByUser[$userId]['categories'][$media->category]['images'][] = [
                            'id' => $media->id,
                            'path' => $imagePath,
                            'url' => asset('storage/user_media/' . $imagePath),
                            'category' => $media->category,
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
            
            // Add videos
            if ($media->videos && is_array($media->videos)) {
                foreach ($media->videos as $index => $videoPath) {
                    if (Storage::disk('public')->exists('user_media/' . $videoPath)) {
                        $mediaByUser[$userId]['categories'][$media->category]['videos'][] = [
                            'id' => $media->id,
                            'path' => $videoPath,
                            'url' => asset('storage/user_media/' . $videoPath),
                            'category' => $media->category,
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
        }

        // Sort: Admin users first, then regular users
        uasort($mediaByUser, function($a, $b) {
            if ($a['is_admin'] && !$b['is_admin']) {
                return -1; // Admin comes first
            }
            if (!$a['is_admin'] && $b['is_admin']) {
                return 1; // Regular user comes after
            }
            return strcmp($a['user_name'], $b['user_name']); // Alphabetical for same type
        });

        return view('AdminArea.AdminDashboard', [
            'user' => $admin,
            'activeTab' => 'media-files',
            'mediaByUser' => $mediaByUser,
            'usersWithMedia' => $usersWithMedia,
            'categories' => $categories,
            'selectedUserId' => $selectedUserId,
            'selectedCategory' => $selectedCategory
        ]);
    }

    /**
     * Create a new user (Admin only)
     */
    public function createUser(Request $request)
    {
        $admin = Auth::user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'family_relation' => 'required|string|max:255',
            'role' => 'nullable|string|in:user,admin',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()
                ->with('error', 'Please fix the errors below.')
                ->with('open_add_user_modal', true);
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->family_relation = $request->family_relation;
        // DB enum is 'simpleuser' | 'admin'; form sends 'user' | 'admin'
        $user->role = ($request->role === 'admin') ? 'admin' : 'simpleuser';
        $user->is_admin = ($request->role === 'admin');
        $user->is_approved = true; // Admin-created users are always auto-approved and get credentials email
        $user->status = 'active';
        $user->save();

        // Send credentials email to the new user (different template for admin-created accounts)
        try {
            Mail::to($user->email)->send(new AccountCreatedByAdminMail($user, $request->password));
        } catch (\Exception $e) {
            \Log::error('Failed to send credentials email to new user: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard', ['tab' => 'all-users'])
            ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' has been created successfully! Credentials have been sent to their email.');
    }

    /**
     * Delete a media file
     */
    public function deleteMedia(Request $request)
    {
        $admin = Auth::user();
        
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'media_id' => 'required|exists:user_media,id',
            'file_path' => 'required|string',
            'file_type' => 'required|in:image,video'
        ]);

        $userMedia = UserMedia::findOrFail($request->media_id);
        
        // Remove file from storage
        if (Storage::disk('public')->exists('user_media/' . $request->file_path)) {
            Storage::disk('public')->delete('user_media/' . $request->file_path);
        }

        // Remove from array
        if ($request->file_type === 'image' && $userMedia->images) {
            $images = $userMedia->images;
            $key = array_search($request->file_path, $images);
            if ($key !== false) {
                unset($images[$key]);
                $userMedia->images = array_values($images); // Re-index array
            }
        } elseif ($request->file_type === 'video' && $userMedia->videos) {
            $videos = $userMedia->videos;
            $key = array_search($request->file_path, $videos);
            if ($key !== false) {
                unset($videos[$key]);
                $userMedia->videos = array_values($videos); // Re-index array
            }
        }

        // If no more media, delete the record
        $hasImages = $userMedia->images && count($userMedia->images) > 0;
        $hasVideos = $userMedia->videos && count($userMedia->videos) > 0;
        
        if (!$hasImages && !$hasVideos) {
            $userMedia->delete();
        } else {
            $userMedia->save();
        }

        return redirect()->route('admin.dashboard', ['tab' => 'media-files'])
            ->with('success', 'Media file deleted successfully!');
    }
}
