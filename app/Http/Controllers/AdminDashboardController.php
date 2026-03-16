<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMedia;
use App\Models\PageSection;
use App\Models\BookAppointmentEntry;
use App\Models\LocalAttraction;
use App\Models\Note;
use App\Models\TravelAccommodationEntry;
use App\Models\TravelAccommodationNote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
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
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'pageSections' => $pageSections,
                'pageSectionsError' => $pageSectionsError,
                'activeTab' => 'page-sections',
            ]);
        }

        if ($tab === 'local-attractions') {
            $attractionsError = null;
            try {
                $attractions = LocalAttraction::orderBy('sort_order')->orderBy('id')->get();
            } catch (\Throwable $e) {
                \Log::error('Local attractions load failed: ' . $e->getMessage());
                $attractions = collect();
                $attractionsError = 'Database table may be missing. Run: php artisan migrate';
            }
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'activeTab' => 'local-attractions',
                'localAttractions' => $attractions,
                'localAttractionsError' => $attractionsError,
            ]);
        }

        if ($tab === 'media-files') {
            return $this->mediaFiles($request);
        }

        if ($tab === 'notes') {
            $notes = Note::where('user_id', $user->id)
                ->orWhereHas('sharedWith', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                })
                ->with(['user:id,first_name,last_name,email,profile_image', 'sharedWith:id,first_name,last_name,email,profile_image'])
                ->orderBy('updated_at', 'desc')
                ->get();
            $adminUsers = User::where('id', '!=', $user->id)->where(function ($q) {
                $q->where('is_admin', true)->orWhere('role', 'admin');
            })->orderBy('first_name')->get(['id', 'first_name', 'last_name', 'email']);
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'activeTab' => 'notes',
                'notes' => $notes,
                'adminUsers' => $adminUsers,
            ]);
        }

        if ($tab === 'travel-accommodation') {
            $travelError = null;
            $accommodationError = null;
            $travelNote = null;
            $accommodationNote = null;
            try {
                $travelEntries = TravelAccommodationEntry::where('type', TravelAccommodationEntry::TYPE_TRAVEL)
                    ->orderBy('sort_order')->orderBy('id')->get();
                $accommodationEntries = TravelAccommodationEntry::where('type', TravelAccommodationEntry::TYPE_ACCOMMODATION)
                    ->orderBy('sort_order')->orderBy('id')->get();
                if (\Illuminate\Support\Facades\Schema::hasTable('travel_accommodation_notes')) {
                    $travelNote = TravelAccommodationNote::where('type', TravelAccommodationNote::TYPE_TRAVEL)->first();
                    $accommodationNote = TravelAccommodationNote::where('type', TravelAccommodationNote::TYPE_ACCOMMODATION)->first();
                }
            } catch (\Throwable $e) {
                \Log::error('Travel & Accommodation load failed: ' . $e->getMessage());
                $travelEntries = collect();
                $accommodationEntries = collect();
                $travelError = $accommodationError = 'Database table may be missing. Run: php artisan migrate';
            }
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'activeTab' => 'travel-accommodation',
                'travelEntries' => $travelEntries,
                'accommodationEntries' => $accommodationEntries,
                'travelNote' => $travelNote,
                'accommodationNote' => $accommodationNote,
                'travelError' => $travelError,
                'accommodationError' => $accommodationError,
            ]);
        }

        if ($tab === 'book-appointments') {
            $section = $request->get('section', 'hair');
            if (!array_key_exists($section, BookAppointmentEntry::SECTIONS)) {
                $section = 'hair';
            }
            $entries = BookAppointmentEntry::where('section', $section)->orderBy('sort_order')->get();
            return view('AdminArea.AdminDashboard', [
                'user' => $user,
                'activeTab' => 'book-appointments',
                'bookAppointmentSection' => $section,
                'bookAppointmentEntries' => $entries,
                'bookAppointmentSections' => BookAppointmentEntry::SECTIONS,
            ]);
        }

        return view('AdminArea.AdminDashboard', [
            'user' => $user,
            'activeTab' => 'my-account'
        ]);
    }

    /**
     * Create a new Local Attraction entry (admin only).
     */
    public function storeLocalAttraction(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $maxOrder = LocalAttraction::max('sort_order') ?? -1;
        LocalAttraction::create([
            'sort_order' => (int) $maxOrder + 1,
            'is_active' => true,
            'title' => '',
            'description' => '',
            'address' => '',
            'distance' => '',
            'map_url' => '',
            'website' => '',
            'phone' => '',
            'note_to_guests' => '',
            'image_path' => null,
            'image_position' => ((($maxOrder + 1) % 2) === 0) ? 'left' : 'right',
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'local-attractions'])
            ->with('success', 'Local attraction added. You can now edit and save.');
    }

    /**
     * Update a Local Attraction entry (admin only).
     */
    public function updateLocalAttraction(Request $request, $id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $attraction = LocalAttraction::findOrFail($id);

        $request->validate([
            'sort_order' => 'nullable|integer|min:0|max:255',
            'is_active' => 'nullable|in:0,1',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'distance' => 'nullable|string|max:255',
            'map_url' => 'nullable|string|max:2048',
            'website' => 'nullable|string|max:2048',
            'phone' => 'nullable|string|max:100',
            'note_to_guests' => 'nullable|string|max:2000',
            'image_position' => 'required|in:left,right',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_image' => 'nullable|in:1',
        ]);

        // Remove image if requested
        if ($request->filled('remove_image') && $attraction->image_path) {
            if (Storage::disk('public')->exists($attraction->image_path)) {
                Storage::disk('public')->delete($attraction->image_path);
            }
            $attraction->image_path = null;
        }

        // Upload / replace image
        if ($request->hasFile('image')) {
            if ($attraction->image_path && Storage::disk('public')->exists($attraction->image_path)) {
                Storage::disk('public')->delete($attraction->image_path);
            }
            $path = $request->file('image')->store('local_attractions', 'public');
            $attraction->image_path = $path;
        }

        $attraction->sort_order = (int) ($request->input('sort_order', $attraction->sort_order ?? 0));
        $attraction->is_active = (bool) $request->input('is_active', 0) ? true : false;
        $attraction->title = $request->input('title') ?? '';
        $attraction->description = $request->input('description') ?? '';
        $attraction->address = $request->input('address') ?? '';
        $attraction->distance = $request->input('distance') ?? '';
        $attraction->map_url = $request->input('map_url') ?? '';
        $attraction->website = $request->input('website') ?? '';
        $attraction->phone = $request->input('phone') ?? '';
        $attraction->note_to_guests = $request->input('note_to_guests') ?? '';
        $attraction->image_position = $request->input('image_position', 'left');
        $attraction->save();

        return redirect()->route('admin.dashboard', ['tab' => 'local-attractions'])
            ->with('success', 'Local attraction updated.');
    }

    /**
     * Delete a Local Attraction entry (admin only).
     */
    public function destroyLocalAttraction($id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $attraction = LocalAttraction::findOrFail($id);
        if ($attraction->image_path && Storage::disk('public')->exists($attraction->image_path)) {
            Storage::disk('public')->delete($attraction->image_path);
        }
        $attraction->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'local-attractions'])
            ->with('success', 'Local attraction deleted.');
    }

    /**
     * Store a new Travel or Accommodation entry (admin only).
     */
    public function storeTravelAccommodation(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $type = $request->input('type', TravelAccommodationEntry::TYPE_TRAVEL);
        if (!in_array($type, [TravelAccommodationEntry::TYPE_TRAVEL, TravelAccommodationEntry::TYPE_ACCOMMODATION], true)) {
            $type = TravelAccommodationEntry::TYPE_TRAVEL;
        }

        $maxOrder = TravelAccommodationEntry::where('type', $type)->max('sort_order') ?? -1;
        TravelAccommodationEntry::create([
            'type' => $type,
            'sort_order' => (int) $maxOrder + 1,
            'name' => '',
            'address' => '',
            'phone' => '',
            'website' => '',
            'website_label' => '',
            'map_url' => '',
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'travel-accommodation'])
            ->with('success', ($type === TravelAccommodationEntry::TYPE_ACCOMMODATION ? 'Accommodation' : 'Travel') . ' entry added. You can now edit and save.');
    }

    /**
     * Update a Travel or Accommodation entry (admin only).
     */
    public function updateTravelAccommodation(Request $request, $id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $entry = TravelAccommodationEntry::findOrFail($id);

        $request->validate([
            'sort_order' => 'nullable|integer|min:0|max:255',
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:2048',
            'website_label' => 'nullable|string|max:255',
            'map_url' => 'nullable|string|max:2048',
        ]);

        $entry->sort_order = (int) ($request->input('sort_order', $entry->sort_order ?? 0));
        $entry->name = $request->input('name') ?? '';
        $entry->address = $request->input('address') ?? '';
        $entry->phone = $request->input('phone') ?? '';
        $entry->website = $request->input('website') ?? '';
        $entry->website_label = $request->input('website_label') ?? '';
        $entry->map_url = $request->input('map_url') ?? '';
        $entry->save();

        return redirect()->route('admin.dashboard', ['tab' => 'travel-accommodation'])
            ->with('success', 'Entry updated.');
    }

    /**
     * Delete a Travel or Accommodation entry (admin only).
     */
    public function destroyTravelAccommodation($id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        TravelAccommodationEntry::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'travel-accommodation'])
            ->with('success', 'Entry deleted.');
    }

    /**
     * Save the single Travel or Accommodation note (one note per section). Admin only. Uses updateOrCreate by type.
     */
    public function saveTravelAccommodationNote(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $type = $request->input('type');
        if (!in_array($type, [TravelAccommodationNote::TYPE_TRAVEL, TravelAccommodationNote::TYPE_ACCOMMODATION], true)) {
            return redirect()->route('admin.dashboard', ['tab' => 'travel-accommodation'])->with('error', 'Invalid note type.');
        }

        $request->validate(['description' => 'nullable|string|max:5000']);

        TravelAccommodationNote::updateOrCreate(
            ['type' => $type],
            ['description' => $request->input('description') ?? '', 'sort_order' => 0]
        );

        return redirect()->route('admin.dashboard', ['tab' => 'travel-accommodation'])
            ->with('success', ($type === TravelAccommodationNote::TYPE_ACCOMMODATION ? 'Accommodation' : 'Travel') . ' note saved.');
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
     * Update only the profile image (used when cropping in modal – direct save).
     */
    public function updateProfileImage(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
            }
            return redirect()->route('login')->with('error', 'Access denied.');
        }

        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($user->profile_image && Storage::disk('public')->exists('profile_images/' . $user->profile_image)) {
            Storage::disk('public')->delete('profile_images/' . $user->profile_image);
        }

        $image = $request->file('profile_image');
        $imageName = time() . '_' . $user->id . '.' . $image->getClientOriginalExtension();
        $image->storeAs('profile_images', $imageName, 'public');
        $user->profile_image = $imageName;
        $user->save();

        $url = secure_media_url('profile_images/' . $imageName);

        return response()->json([
            'success' => true,
            'profile_image' => $imageName,
            'url' => $url,
        ]);
    }

    /**
     * Show create note page (admin only).
     */
    public function createNotePage()
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $adminUsers = User::where('id', '!=', $user->id)
            ->where(function ($q) {
                $q->where('is_admin', true)->orWhere('role', 'admin');
            })
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'email']);
        return view('AdminArea.notes.form', [
            'user' => $user,
            'note' => null,
            'adminUsers' => $adminUsers,
            'tagOptions' => Note::notificationTagOptions(),
        ]);
    }

    /**
     * Show edit note page (creator only).
     */
    public function editNotePage($id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $note = Note::findOrFail($id);
        $canEdit = $note->user_id === $user->id || $note->sharedWith()->where('users.id', $user->id)->exists();
        if (!$canEdit) {
            return redirect()->route('admin.dashboard', ['tab' => 'notes'])->with('error', 'You do not have permission to edit this note.');
        }
        $adminUsers = User::where('id', '!=', $user->id)
            ->where(function ($q) {
                $q->where('is_admin', true)->orWhere('role', 'admin');
            })
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'email']);
        $note->load('sharedWith');
        return view('AdminArea.notes.form', [
            'user' => $user,
            'note' => $note,
            'adminUsers' => $adminUsers,
            'tagOptions' => Note::notificationTagOptions(),
        ]);
    }

    /**
     * Store a new note (admin only). Optionally share with selected admins and tags.
     */
    public function storeNote(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $validTags = array_keys(Note::notificationTagOptions());
        $request->validate([
            'content' => 'nullable|string|max:10000',
            'share_with' => 'nullable|array',
            'share_with.*' => 'integer|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|in:' . implode(',', $validTags),
        ]);
        $content = $request->content ?? '';
        $title = $content !== '' ? Str::limit(preg_replace('/\s+/', ' ', strip_tags($content)), 50) : 'Note';
        $tags = $request->tags ?? [];
        $note = Note::create([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content,
            'tags' => array_values(array_unique($tags)),
        ]);
        $shareWith = $request->share_with ?? [];
        $adminIds = User::whereIn('id', $shareWith)
            ->where(function ($q) {
                $q->where('is_admin', true)->orWhere('role', 'admin');
            })
            ->pluck('id')
            ->toArray();
        $note->sharedWith()->sync($adminIds);
        return redirect()->route('admin.dashboard', ['tab' => 'notes'])->with('success', 'Note created successfully.');
    }

    /**
     * Update a note (creator only). Optionally update shared-with admins.
     */
    public function updateNote(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $note = Note::findOrFail($id);
        $canEdit = $note->user_id === $user->id || $note->sharedWith()->where('users.id', $user->id)->exists();
        if (!$canEdit) {
            return back()->with('error', 'You do not have permission to edit this note.');
        }
        $validTags = array_keys(Note::notificationTagOptions());
        $request->validate([
            'content' => 'nullable|string|max:10000',
            'share_with' => 'nullable|array',
            'share_with.*' => 'integer|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|in:' . implode(',', $validTags),
        ]);
        $content = $request->content ?? '';
        $note->title = $content !== '' ? Str::limit(preg_replace('/\s+/', ' ', strip_tags($content)), 50) : 'Note';
        $note->content = $content;
        $note->tags = array_values(array_unique($request->tags ?? []));
        $note->save();
        $shareWith = $request->share_with ?? [];
        $adminIds = User::whereIn('id', $shareWith)
            ->where(function ($q) {
                $q->where('is_admin', true)->orWhere('role', 'admin');
            })
            ->pluck('id')
            ->toArray();
        $note->sharedWith()->sync($adminIds);
        return redirect()->route('admin.dashboard', ['tab' => 'notes'])->with('success', 'Note updated successfully.');
    }

    /**
     * Delete a note (creator only).
     */
    public function destroyNote($id)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $note = Note::findOrFail($id);
        $canDelete = $note->user_id === $user->id || $note->sharedWith()->where('users.id', $user->id)->exists();
        if (!$canDelete) {
            return back()->with('error', 'You do not have permission to delete this note.');
        }
        $note->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'notes'])->with('success', 'Note deleted.');
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
            ->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' has been blocked. An email notification has been sent.');
    }

    /**
     * Show edit user form (admin editing another user's profile).
     */
    public function editUserPage($id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $editUser = User::findOrFail($id);
        return view('AdminArea.edit_user', [
            'user' => $admin,
            'editUser' => $editUser,
        ]);
    }

    /**
     * Update a user's profile (admin).
     */
    public function updateUser(Request $request, $id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $editUser = User::findOrFail($id);

        $familyRelationOptions = 'father,mother,brother,sister,uncle,aunt,cousin,grandfather,grandmother,nephew,niece,brother_in_law,sister_in_law,father_in_law,mother_in_law,friend,other';
        $rules = [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:32',
            'family_relation' => 'nullable|string|in:' . $familyRelationOptions,
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'nullable|string|in:active,inactive',
        ];
        if ($editUser->isAdmin()) {
            $rules['role'] = 'nullable|string|in:admin,user';
        }
        $request->validate($rules);

        $editUser->first_name = $request->first_name;
        $editUser->last_name = $request->last_name;
        $editUser->email = $request->email;
        $editUser->phone = $request->phone ?: null;
        $editUser->family_relation = $request->family_relation ?: null;
        $editUser->status = $request->status ?: 'active';
        if ($request->filled('password')) {
            $editUser->password = Hash::make($request->password);
        }
        if ($editUser->isAdmin() && $request->has('role')) {
            $editUser->role = $request->role;
            $editUser->is_admin = ($request->role === 'admin');
        }
        $editUser->save();

        return redirect()->route('admin.dashboard', ['tab' => 'all-users'])
            ->with('success', 'User ' . $editUser->first_name . ' ' . $editUser->last_name . ' has been updated.');
    }

    /**
     * Delete a user (admin). Cannot delete self or the last admin.
     */
    public function destroyUser($id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $user = User::findOrFail($id);

        if ($user->id === $admin->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        if ($user->isAdmin()) {
            $adminCount = User::where('is_admin', true)->orWhere('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last admin.');
            }
        }

        $name = $user->first_name . ' ' . $user->last_name;
        $user->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'all-users'])
            ->with('success', 'User ' . $name . ' has been deleted.');
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

        // When a category is selected: show all media for that category from all users (no user-wise grouping)
        $showAllByCategory = $selectedCategory !== 'all';

        // Organize media by user (filter by selected user and category)
        $mediaByUser = [];
        foreach ($allMedia as $media) {
            $userId = $media->user_id;

            // If a category is picked, ignore user filter and show all users' media for that category
            if (!$showAllByCategory && $selectedUserId !== 'all' && (string) $userId !== (string) $selectedUserId) {
                continue;
            }

            if ($selectedCategory !== 'all' && $media->category !== $selectedCategory) {
                continue;
            }

            $userName = $media->user ? $media->user->first_name . ' ' . $media->user->last_name : 'Unknown User';
            $userEmail = $media->email;

            if ($showAllByCategory) {
                // Single aggregated block for this category (key used only for structure)
                $userId = '_all_';
                $userName = 'All Users';
                $userEmail = '';
            }

            if (!isset($mediaByUser[$userId])) {
                $mediaByUser[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_email' => $userEmail,
                    'is_admin' => $showAllByCategory ? false : ($media->user && $media->user->isAdmin()),
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
                            'url' => secure_media_url('user_media/' . $path),
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
                            'url' => secure_media_url('user_media/' . $path),
                            'category' => $media->category,
                            'uploaded_at' => $media->created_at
                        ];
                    }
                }
            }
        }

        if (!$showAllByCategory) {
            uasort($mediaByUser, function ($a, $b) {
                if ($a['is_admin'] && !$b['is_admin']) return -1;
                if (!$a['is_admin'] && $b['is_admin']) return 1;
                return strcmp($a['user_name'], $b['user_name']);
            });
        }

        // When showing by category, user filter is ignored; keep dropdown in sync
        $selectedUserIdForView = $showAllByCategory ? 'all' : $selectedUserId;

        return view('AdminArea.AdminDashboard', [
            'user' => $admin,
            'activeTab' => 'media-files',
            'mediaByUser' => $mediaByUser,
            'usersWithMedia' => $usersWithMedia,
            'userMediaCounts' => $userMediaCounts,
            'categoriesWithCount' => $categoriesWithCount,
            'selectedUserId' => $selectedUserIdForView,
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
            'phone' => 'nullable|string|max:32',
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
        $user->phone = $request->phone ?: null;
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

        $rules = [
            'slug' => 'required|string|exists:page_sections,slug',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'event_date' => 'nullable|date',
        ];
        if ($request->slug === 'hero') {
            $rules['hero_slider_1'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $rules['hero_slider_2'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $rules['hero_slider_3'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }
        if (in_array($request->slug, ['fourth', 'fifth', 'sixth', 'seventh', 'ninth', 'tenth', 'eleventh', 'twelfth', 'thirteenth'], true)) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }
        $request->validate($rules);

        $section = PageSection::where('slug', $request->slug)->firstOrFail();
        $section->title = $request->input('title') ?: null;
        $section->subtitle = $request->input('subtitle') ?: null;
        $section->short_description = $request->input('short_description') ?: null;
        $section->event_date = $request->filled('event_date') ? \Carbon\Carbon::parse($request->event_date) : null;
        if (Schema::hasColumn($section->getTable(), 'is_visible')) {
            $section->is_visible = $request->boolean('is_visible');
        }

        $extra = $section->extra ?? [];
        if ($request->has('extra') && is_array($request->extra)) {
            foreach ($request->extra as $key => $value) {
                if (!in_array($key, ['image', 'groom_image', 'bride_image', 'slider_1', 'slider_2', 'slider_3'], true)) {
                    $extra[$key] = $value === null || $value === '' ? null : $value;
                }
            }
        }

        // Hero section: three slider images + optional remove
        if ($section->slug === 'hero') {
            $storageDir = 'page_sections/hero';
            foreach ([1 => 'slider_1', 2 => 'slider_2', 3 => 'slider_3'] as $num => $extraKey) {
                $removeKey = 'hero_remove_slider_' . $num;
                $fileKey = 'hero_slider_' . $num;
                if ($request->filled($removeKey)) {
                    if (!empty($extra[$extraKey]) && Storage::disk('public')->exists($extra[$extraKey])) {
                        Storage::disk('public')->delete($extra[$extraKey]);
                    }
                    $extra[$extraKey] = null;
                }
                if ($request->hasFile($fileKey)) {
                    if (!empty($extra[$extraKey]) && Storage::disk('public')->exists($extra[$extraKey])) {
                        Storage::disk('public')->delete($extra[$extraKey]);
                    }
                    $path = $request->file($fileKey)->store($storageDir, 'public');
                    $extra[$extraKey] = $path;
                }
            }
        }

        // Section image for fourth, fifth, sixth, seventh, ninth, tenth, eleventh, twelfth, thirteenth
        if (in_array($section->slug, ['fourth', 'fifth', 'sixth', 'seventh', 'ninth', 'tenth', 'eleventh', 'twelfth', 'thirteenth'], true) && $request->hasFile('image')) {
            $storageDir = 'page_sections/' . $section->slug;
            if (!empty($extra['image']) && Storage::disk('public')->exists($extra['image'])) {
                Storage::disk('public')->delete($extra['image']);
            }
            $extra['image'] = $request->file('image')->store($storageDir, 'public');
        }

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
            ['slug' => 'wedding_day', 'title' => 'Date We Getting Married', 'subtitle' => 'Wedding Day', 'short_description' => null, 'event_date' => Carbon::parse('2027-01-01 12:00:00'), 'extra' => null, 'sort_order' => 3],
            ['slug' => 'fourth', 'title' => 'Shagun', 'subtitle' => 'With Blessings', 'short_description' => 'We inviting you and your family on', 'event_date' => null, 'extra' => ['dress_code' => 'Traditional Outfits', 'date' => '2/21/2026', 'time' => '9 am - 12 pm', 'venue' => 'Phoenix AZ'], 'sort_order' => 4],
            ['slug' => 'fifth', 'title' => 'Vatna', 'subtitle' => 'Sacred Ritual', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2/25/2026', 'date_display' => '25 Feb 2026', 'time' => '9 am - 12 pm', 'venue' => 'Phoenix AZ', 'dress_code' => 'Casual Indian Orange Yellow, Green Colors', 'address' => 'Phoenix AZ'], 'sort_order' => 5],
            ['slug' => 'sixth', 'title' => 'Mehndi', 'subtitle' => 'Colorful Vibes', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-25-2026', 'time' => '4 - 7 pm', 'venue' => 'Ramit and Maninder Residence', 'dress_code' => 'Casual Indian Orange Yellow, Green Colors', 'address' => '20865 N. 109th Place, Scottsdale AZ'], 'sort_order' => 6],
            ['slug' => 'seventh', 'title' => 'Sangeet Night', 'subtitle' => 'Musical Vibes', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-26-2026', 'time' => '6pm - midnight', 'venue' => 'Jasmine and Mannttej Residence', 'dress_code' => 'Indian. Outside venue. Be warm and comfortable', 'address' => '4608 W El Cortez Pl, Phoenix AZ 85083', 'entertainment_mc' => 'MC: Jastej Sra'], 'sort_order' => 7],
            ['slug' => 'ninth', 'title' => "Jaggo, Gidha and\nBhangra Night", 'subtitle' => 'Full Magic', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '2-31-2026', 'time' => '6 pm to midnight', 'venue' => 'Park Hyatt Aviara Resort-760-448-1234', 'dress_code' => 'Indian Traditional Outfits', 'address' => '7100 Aviara Resort Drive, Carlsbad CA 92011', 'entertainment_mc' => 'MC: Herman Kahlon', 'performance_text' => 'Giddha by family members'], 'sort_order' => 8],
            ['slug' => 'tenth', 'title' => 'Sehra & Surma Ceremony', 'subtitle' => 'Cultural Elegance', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '01-01-2027', 'time' => '7 am onwards', 'turban_tying' => 'At 7 am', 'venue' => 'Hopitality Room', 'barat_leaves' => 'Indian Traditional Outfits'], 'sort_order' => 9],
            ['slug' => 'eleventh', 'title' => 'Wedding', 'subtitle' => 'Sacred Union', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '01-01-2027', 'time' => '9 am-12 pm', 'venue' => 'Ramit and Maninder Residence', 'dress_code' => 'Indian Traditional Outfits', 'dress_code_men' => 'Red Turbans Head Covers', 'dress_code_women' => 'Any Color', 'address' => '20865 N 109th Place Scottsdale AZ'], 'sort_order' => 10],
            ['slug' => 'twelfth', 'title' => 'Reception', 'subtitle' => 'Celebration', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '1/2/2027', 'venue' => 'Park Hyatt Aviara Resort-760-448-1234', 'address' => '7100 Aviara Resort Drive, Carlsbad CA 92011', 'time' => '6 pm onwards', 'dress_code' => 'Indian traditional outfits', 'dress_code_subtext' => 'Men: Formals. Women: any color'], 'sort_order' => 11],
            ['slug' => 'thirteenth', 'title' => 'Custom sec1', 'subtitle' => 'Sacred Union', 'short_description' => null, 'event_date' => null, 'extra' => ['date' => '01-01-2027', 'time' => '9 am-12 pm', 'venue' => 'Ramit and Maninder Residence', 'dress_code' => 'Indian Traditional Outfits', 'dress_code_men' => 'Red Turbans Head Covers', 'dress_code_women' => 'Any Color', 'address' => '20865 N 109th Place Scottsdale AZ'], 'sort_order' => 12, 'is_visible' => false],
        ];

        foreach ($sections as $data) {
            PageSection::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }

    /**
     * Store a new Book Appointment entry (up to 6 per section).
     */
    public function storeBookAppointmentEntry(Request $request)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $request->validate([
            'section' => 'required|string|in:hair,makeup,nails,spa',
        ]);
        $count = BookAppointmentEntry::where('section', $request->section)->count();
        if ($count >= 6) {
            return redirect()->route('admin.dashboard', ['tab' => 'book-appointments', 'section' => $request->section])
                ->with('error', 'Maximum 6 entries per section.');
        }
        $maxOrder = BookAppointmentEntry::where('section', $request->section)->max('sort_order') ?? -1;
        BookAppointmentEntry::create([
            'section' => $request->section,
            'sort_order' => $maxOrder + 1,
            'store_name' => '',
            'instruction' => 'Call at least one month ahead and book your appointments.',
            'address' => '',
            'phone_number' => '',
            'distance' => '',
            'website' => '',
            'map_url' => '',
            'services' => '',
        ]);
        return redirect()->route('admin.dashboard', ['tab' => 'book-appointments', 'section' => $request->section])
            ->with('success', 'Entry added. You can now edit and save.');
    }

    /**
     * Update a Book Appointment entry.
     */
    public function updateBookAppointmentEntry(Request $request, $id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $entry = BookAppointmentEntry::findOrFail($id);
        $request->validate([
            'sort_order' => 'nullable|integer|min:0|max:255',
            'store_name' => 'nullable|string|max:255',
            'instruction' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:32',
            'distance' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:2048',
            'map_url' => 'nullable|string|max:2048',
            'services' => 'nullable|string|max:500',
        ]);
        $entry->update($request->only(['sort_order', 'store_name', 'instruction', 'address', 'phone_number', 'distance', 'website', 'map_url', 'services']));
        return redirect()->route('admin.dashboard', ['tab' => 'book-appointments', 'section' => $entry->section])
            ->with('success', 'Entry updated.');
    }

    /**
     * Delete a Book Appointment entry.
     */
    public function destroyBookAppointmentEntry($id)
    {
        $admin = Auth::user();
        if (!$admin || !$admin->isAdmin()) {
            return redirect()->route('login')->with('error', 'Access denied.');
        }
        $entry = BookAppointmentEntry::findOrFail($id);
        $section = $entry->section;
        $entry->delete();
        return redirect()->route('admin.dashboard', ['tab' => 'book-appointments', 'section' => $section])
            ->with('success', 'Entry deleted.');
    }
}
