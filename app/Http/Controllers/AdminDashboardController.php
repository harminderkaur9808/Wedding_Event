<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMedia;
use App\Models\PageSection;
use Carbon\Carbon;
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

        if ($tab === 'page-sections') {
            $pageSectionsError = null;
            try {
                $this->ensurePageSectionsExist();
                $pageSections = PageSection::orderBy('sort_order')->get();
            } catch (\Throwable $e) {
                \Log::error('Page sections load failed: ' . $e->getMessage());
                $pageSections = collect();
                $pageSectionsError = 'Database table may be missing. Run: php artisan migrate';
            }
            // First section (Hero) commented out for now – exclude from dropdown and forms
            $pageSections = $pageSections->filter(fn ($s) => $s->slug !== 'hero')->values();
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'pageSections' => $pageSections,
                'pageSectionsError' => $pageSectionsError,
                'activeTab' => 'page-sections',
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
     * All gallery categories (same as gallery-section / Pictures and Videos)
     */
    private static function getAllCategories(): array
    {
        return [
            'roka' => 'Roka',
            'shagun' => 'Shagun',
            'vatna' => 'Vatna',
            'sangeet' => 'Sangeet',
            'mehndi' => 'Mehndi',
            'jaggo' => 'Jaggo and Giddha',
            'sehra' => 'Sehra Bandhi and Surma',
            'barat' => 'Barat and Milni',
            'wedding' => 'Wedding',
        ];
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

        $allCategories = self::getAllCategories();

        // Get filter parameters
        $selectedUserId = $request->get('user_id', 'all');
        $selectedCategory = $request->get('category', 'all');

        // Get all media files
        $allMedia = UserMedia::with('user')->orderBy('created_at', 'desc')->get();

        // Count media per user (total images + videos, all categories)
        $userMediaCounts = [];
        foreach ($allMedia as $media) {
            $uid = $media->user_id;
            if (!isset($userMediaCounts[$uid])) {
                $userMediaCounts[$uid] = 0;
            }
            $userMediaCounts[$uid] += count($media->images ?? []) + count($media->videos ?? []);
        }

        // Count media per category (optionally filtered by selected user)
        $categoryCounts = array_fill_keys(array_keys($allCategories), 0);
        foreach ($allMedia as $media) {
            if ($selectedUserId !== 'all' && (string) $media->user_id !== (string) $selectedUserId) {
                continue;
            }
            $cat = $media->category;
            if (isset($categoryCounts[$cat])) {
                $categoryCounts[$cat] += count($media->images ?? []) + count($media->videos ?? []);
            }
        }

        // Build categories with count for dropdown (all categories, show count)
        $categoriesWithCount = [];
        foreach ($allCategories as $slug => $label) {
            $categoriesWithCount[] = [
                'value' => $slug,
                'label' => $label,
                'count' => $categoryCounts[$slug] ?? 0,
            ];
        }

        // Users who have uploaded media (for dropdown)
        $userIds = $allMedia->pluck('user_id')->unique()->filter()->values();
        $usersWithMedia = $userIds->isNotEmpty()
            ? User::whereIn('id', $userIds)
                ->orderBy('is_admin', 'desc')
                ->orderBy('first_name')
                ->get()
            : collect();

        // Organize media by user (filter by selected user and category)
        $mediaByUser = [];
        foreach ($allMedia as $media) {
            $userId = $media->user_id;

            if ($selectedUserId !== 'all' && (string) $userId !== (string) $selectedUserId) {
                continue;
            }

            if ($selectedCategory !== 'all' && $media->category !== $selectedCategory) {
                continue;
            }

            $userName = $media->user ? $media->user->first_name . ' ' . $media->user->last_name : 'Unknown User';
            $userEmail = $media->email;

            if (!isset($mediaByUser[$userId])) {
                $mediaByUser[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_email' => $userEmail,
                    'is_admin' => $media->user && $media->user->isAdmin(),
                    'categories' => []
                ];
            }

            if ($media->images && is_array($media->images)) {
                foreach ($media->images as $index => $imagePath) {
                    $path = is_string($imagePath) ? $imagePath : ($imagePath['path'] ?? $imagePath);
                    if (Storage::disk('public')->exists('user_media/' . $path)) {
                        $mediaByUser[$userId]['categories'][$media->category]['images'][] = [
                            'id' => $media->id,
                            'path' => $path,
                            'url' => asset('storage/user_media/' . $path),
                            'category' => $media->category,
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }

            if ($media->videos && is_array($media->videos)) {
                foreach ($media->videos as $index => $videoPath) {
                    $path = is_string($videoPath) ? $videoPath : ($videoPath['path'] ?? $videoPath);
                    if (Storage::disk('public')->exists('user_media/' . $path)) {
                        $mediaByUser[$userId]['categories'][$media->category]['videos'][] = [
                            'id' => $media->id,
                            'path' => $path,
                            'url' => asset('storage/user_media/' . $path),
                            'category' => $media->category,
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
        }

        uasort($mediaByUser, function ($a, $b) {
            if ($a['is_admin'] && !$b['is_admin']) return -1;
            if (!$a['is_admin'] && $b['is_admin']) return 1;
            return strcmp($a['user_name'], $b['user_name']);
        });

        return view('AdminArea.AdminDashboard', [
            'user' => $admin,
            'activeTab' => 'media-files',
            'mediaByUser' => $mediaByUser,
            'usersWithMedia' => $usersWithMedia,
            'userMediaCounts' => $userMediaCounts,
            'categoriesWithCount' => $categoriesWithCount,
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

    /**
     * Download a media file (admin only). Query: path (relative to user_media/), type=image|video.
     */
    public function downloadMedia(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $path = $request->query('path');
        $type = $request->query('type', 'image');
        if (!in_array($type, ['image', 'video'], true) || empty($path)) {
            abort(400, 'Invalid request.');
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');
        if (strpos($path, '..') !== false || strpos($path, 'user_media/') === 0) {
            $path = preg_replace('#^user_media/#', '', $path);
        }
        $fullPath = 'user_media/' . $path;

        if (!Storage::disk('public')->exists($fullPath)) {
            abort(404, 'File not found.');
        }

        $filename = basename($path);
        return Storage::disk('public')->download($fullPath, $filename, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Update a page section (homepage content)
     */
    public function updatePageSection(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'slug' => 'required|string|exists:page_sections,slug',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'event_date' => 'nullable|date',
            // Image uploads commented out for now
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            // 'groom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            // 'bride_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $section = PageSection::where('slug', $request->slug)->firstOrFail();
        $section->title = $request->input('title') ?: null;
        $section->subtitle = $request->input('subtitle') ?: null;
        $section->short_description = $request->input('short_description') ?: null;
        $section->event_date = $request->filled('event_date') ? \Carbon\Carbon::parse($request->event_date) : null;

        $extra = $section->extra ?? [];
        if ($request->has('extra') && is_array($request->extra)) {
            foreach ($request->extra as $key => $value) {
                // Keep image keys when image upload is commented out (don't overwrite with form data)
                if (!in_array($key, ['image', 'groom_image', 'bride_image'], true)) {
                    $extra[$key] = $value === null || $value === '' ? null : $value;
                }
            }
        }

        // Image uploads commented out for now
        // $storageDir = 'page_sections';
        // if ($request->hasFile('image')) {
        //     if (!empty($extra['image']) && Storage::disk('public')->exists($extra['image'])) {
        //         Storage::disk('public')->delete($extra['image']);
        //     }
        //     $path = $request->file('image')->store($storageDir, 'public');
        //     $extra['image'] = $path;
        // }
        // if ($request->hasFile('groom_image')) {
        //     if (!empty($extra['groom_image']) && Storage::disk('public')->exists($extra['groom_image'])) {
        //         Storage::disk('public')->delete($extra['groom_image']);
        //     }
        //     $path = $request->file('groom_image')->store($storageDir, 'public');
        //     $extra['groom_image'] = $path;
        // }
        // if ($request->hasFile('bride_image')) {
        //     if (!empty($extra['bride_image']) && Storage::disk('public')->exists($extra['bride_image'])) {
        //         Storage::disk('public')->delete($extra['bride_image']);
        //     }
        //     $path = $request->file('bride_image')->store($storageDir, 'public');
        //     $extra['bride_image'] = $path;
        // }

        $section->extra = array_filter($extra, fn ($v) => $v !== null && $v !== '');
        $section->save();

        return redirect()->route('admin.dashboard', ['tab' => 'page-sections'])
            ->with('success', 'Section "' . str_replace('_', ' ', $section->slug) . '" updated successfully!');
    }

    /**
     * Ensure page_sections table has default sections (so admin form always shows).
     * Creates them in DB when empty; safe to call every time.
     */
    private function ensurePageSectionsExist(): void
    {
        if (PageSection::count() > 0) {
            return;
        }

        $sections = [
            ['slug' => 'hero', 'title' => null, 'subtitle' => null, 'short_description' => null, 'event_date' => null, 'extra' => null, 'sort_order' => 1],
            ['slug' => 'our_story', 'title' => 'Our Story', 'subtitle' => 'Bride & Groom', 'short_description' => null, 'event_date' => null, 'extra' => ['groom_name' => 'Vickram', 'groom_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.', 'bride_name' => 'Nisha', 'bride_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been.'], 'sort_order' => 2],
            ['slug' => 'wedding_day', 'title' => 'Date We Getting Married', 'subtitle' => 'Wedding Day', 'short_description' => null, 'event_date' => Carbon::parse('2026-12-31 12:00:00'), 'extra' => null, 'sort_order' => 3],
            ['slug' => 'fourth', 'title' => 'Shagun', 'subtitle' => 'With Blessings', 'short_description' => 'We inviting you and your family on', 'event_date' => null, 'extra' => ['dress_code' => 'Traditional Outfits', 'date' => '2/21/2026', 'time' => '9 am - 12 pm', 'venue' => 'Phoenix AZ'], 'sort_order' => 4],
            ['slug' => 'fifth', 'title' => 'Vatna', 'subtitle' => 'Sacred Ritual', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2/25/2026', 'date_display' => '25 Feb 2026', 'time' => '9 am - 12 pm', 'venue' => 'Phoenix AZ', 'dress_code' => 'Casual Indian Orange Yellow, Green Colors'], 'sort_order' => 5],
            ['slug' => 'sixth', 'title' => 'Mehndi', 'subtitle' => 'Colorful Vibes', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-25-2026', 'time' => '4 - 7 pm', 'venue' => 'Ramit and Maninder Residence', 'dress_code' => 'Casual Indian Orange Yellow, Green Colors', 'address' => '20865 N. 109th Place, Scottsdale AZ'], 'sort_order' => 6],
            ['slug' => 'seventh', 'title' => 'Sangeet Night', 'subtitle' => 'Musical Vibes', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-26-2026', 'time' => '6pm - midnight', 'venue' => 'Jasmine and Mannttej Residence', 'dress_code' => 'Indian. Outside venue. Be warm and comfortable', 'address' => '4608 W El Cortez Pl, Phoenix AZ 85083', 'entertainment_mc' => 'MC: Jastej Sra'], 'sort_order' => 7],
            ['slug' => 'ninth', 'title' => "Jaggo, Gidha and\nBhangra Night", 'subtitle' => 'Full Magic', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-31-2026', 'time' => '6 pm to midnight', 'venue' => 'Park Hyatt Aviara Resort-760-448-1234', 'dress_code' => 'Indian Traditional Outfits', 'address' => '7100 Aviara Resort Drive, Carlsbad CA 92011', 'entertainment_mc' => 'MC: Herman Kahlon', 'performance_text' => 'Giddha by family members'], 'sort_order' => 8],
            ['slug' => 'tenth', 'title' => 'Sehra & Surma Ceremony', 'subtitle' => 'Cultural Elegance', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '12-31-2026', 'turban_tying' => 'At 7 am', 'venue' => 'Hopitality Room', 'barat_leaves' => 'Indian Traditional Outfits'], 'sort_order' => 9],
            ['slug' => 'eleventh', 'title' => 'Wedding', 'subtitle' => 'Sacred Union', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '12-31-2026', 'time' => '9 am-12 pm', 'venue' => 'Ramit and Maninder Residence', 'dress_code' => 'Indian Traditional Outfits', 'dress_code_subtext' => 'Men: Red Turbans Head Covers  Women: Any Color', 'address' => '20865 N 109th Place Scottsdale AZ'], 'sort_order' => 10],
        ];

        foreach ($sections as $data) {
            PageSection::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
