@extends('layouts.app')

@section('title', 'Edit User - Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="admin-dashboard-container">
    <div class="admin-dashboard-left-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_Left_side.png') }}" alt="Left Frame" class="admin-dashboard-frame-img">
    </div>
    <div class="admin-dashboard-right-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_right_side.png') }}" alt="Right Frame" class="admin-dashboard-frame-img">
    </div>

    <div class="container admin-dashboard-wrapper">
        @if(session('success'))
            <div class="admin-dashboard-alert admin-dashboard-alert-success">
                <svg class="admin-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="admin-dashboard-alert admin-dashboard-alert-error">
                <svg class="admin-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="admin-dashboard-layout">
            <div class="admin-dashboard-sidebar">
                <div class="admin-dashboard-tabs">
                    <a href="{{ route('admin.dashboard', ['tab' => 'my-account']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>My Account</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'all-users']) }}" class="admin-dashboard-tab active">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>All Users</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'page-sections']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Home Page Sections</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'local-attractions']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 1 1 18 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Local Attractions</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'book-appointments', 'section' => 'hair']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Book your appointments</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'media-files']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 16L8.586 11.414C9.367 10.633 10.633 10.633 11.414 11.414L16 16M14 14L15.586 12.414C16.367 11.633 17.633 11.633 18.414 12.414L22 16M2 20H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="2" y="4" width="20" height="4" rx="1" stroke="currentColor" stroke-width="2"/></svg>
                        <span>Media Files</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'notes']) }}" class="admin-dashboard-tab">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Notes</span>
                    </a>
                </div>
            </div>

            <div class="admin-dashboard-content">
                <div class="admin-dashboard-tab-content admin-notes-form-tab">
                    <div class="admin-notes-form-header">
                        <h1 class="admin-notes-form-title">Edit User: {{ $editUser->first_name }} {{ $editUser->last_name }}</h1>
                        <a href="{{ route('admin.dashboard', ['tab' => 'all-users']) }}" class="admin-dashboard-btn admin-dashboard-btn-secondary admin-notes-back-btn">Back to All Users</a>
                    </div>

                    <form method="POST" action="{{ route('admin.users.update', $editUser->id) }}" class="admin-notes-form">
                        @csrf
                        @method('PUT')
                        <div class="admin-notes-form-grid">
                            <div class="admin-notes-form-group">
                                <label for="first_name" class="admin-notes-form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="admin-notes-form-input" value="{{ old('first_name', $editUser->first_name) }}" required maxlength="100">
                                @error('first_name')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="admin-notes-form-group">
                                <label for="last_name" class="admin-notes-form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="admin-notes-form-input" value="{{ old('last_name', $editUser->last_name) }}" required maxlength="100">
                                @error('last_name')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="email" class="admin-notes-form-label">Email</label>
                            <input type="email" id="email" name="email" class="admin-notes-form-input" value="{{ old('email', $editUser->email) }}" required>
                            @error('email')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="phone" class="admin-notes-form-label">Phone #</label>
                            <input type="tel" id="phone" name="phone" class="admin-notes-form-input" value="{{ old('phone', $editUser->phone) }}" placeholder="e.g. (760) 123-4567" maxlength="32">
                            @error('phone')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="family_relation" class="admin-notes-form-label">Family Relation</label>
                            <select id="family_relation" name="family_relation" class="admin-notes-form-input">
                                <option value="">Choose</option>
                                <option value="father" {{ old('family_relation', $editUser->family_relation) == 'father' ? 'selected' : '' }}>Father</option>
                                <option value="mother" {{ old('family_relation', $editUser->family_relation) == 'mother' ? 'selected' : '' }}>Mother</option>
                                <option value="brother" {{ old('family_relation', $editUser->family_relation) == 'brother' ? 'selected' : '' }}>Brother</option>
                                <option value="sister" {{ old('family_relation', $editUser->family_relation) == 'sister' ? 'selected' : '' }}>Sister</option>
                                <option value="uncle" {{ old('family_relation', $editUser->family_relation) == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                <option value="aunt" {{ old('family_relation', $editUser->family_relation) == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                <option value="cousin" {{ old('family_relation', $editUser->family_relation) == 'cousin' ? 'selected' : '' }}>Cousin</option>
                                <option value="grandfather" {{ old('family_relation', $editUser->family_relation) == 'grandfather' ? 'selected' : '' }}>Grandfather</option>
                                <option value="grandmother" {{ old('family_relation', $editUser->family_relation) == 'grandmother' ? 'selected' : '' }}>Grandmother</option>
                                <option value="nephew" {{ old('family_relation', $editUser->family_relation) == 'nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="niece" {{ old('family_relation', $editUser->family_relation) == 'niece' ? 'selected' : '' }}>Niece</option>
                                <option value="brother_in_law" {{ old('family_relation', $editUser->family_relation) == 'brother_in_law' ? 'selected' : '' }}>Brother-in-law</option>
                                <option value="sister_in_law" {{ old('family_relation', $editUser->family_relation) == 'sister_in_law' ? 'selected' : '' }}>Sister-in-law</option>
                                <option value="father_in_law" {{ old('family_relation', $editUser->family_relation) == 'father_in_law' ? 'selected' : '' }}>Father-in-law</option>
                                <option value="mother_in_law" {{ old('family_relation', $editUser->family_relation) == 'mother_in_law' ? 'selected' : '' }}>Mother-in-law</option>
                                <option value="friend" {{ old('family_relation', $editUser->family_relation) == 'friend' ? 'selected' : '' }}>Friend</option>
                                <option value="other" {{ old('family_relation', $editUser->family_relation) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('family_relation')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="password" class="admin-notes-form-label">New password</label>
                            <input type="password" id="password" name="password" class="admin-notes-form-input" placeholder="Leave blank to keep current password" autocomplete="new-password">
                            @error('password')<span class="admin-notes-form-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="password_confirmation" class="admin-notes-form-label">Confirm password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="admin-notes-form-input" placeholder="Confirm new password" autocomplete="new-password">
                        </div>
                        <div class="admin-notes-form-group">
                            <label for="status" class="admin-notes-form-label">Status</label>
                            <select id="status" name="status" class="admin-notes-form-input">
                                <option value="active" {{ old('status', $editUser->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $editUser->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @if($editUser->isAdmin())
                        <div class="admin-notes-form-group">
                            <label for="role" class="admin-notes-form-label">Role</label>
                            <select id="role" name="role" class="admin-notes-form-input">
                                <option value="admin" {{ old('role', $editUser->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role', $editUser->role) === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        @endif
                        <div class="admin-notes-form-actions">
                            <button type="submit" class="admin-dashboard-btn admin-dashboard-btn-primary">Save Changes</button>
                            <a href="{{ route('admin.dashboard', ['tab' => 'all-users']) }}" class="admin-dashboard-btn admin-dashboard-btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
