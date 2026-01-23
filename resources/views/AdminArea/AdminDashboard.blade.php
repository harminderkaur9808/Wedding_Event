@extends('layouts.app')

@section('title', 'Admin Dashboard - Wedding Event')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="admin-dashboard-container">
    <!-- Left Decorative Frame -->
    <div class="admin-dashboard-left-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_Left_side.png') }}" alt="Left Frame" class="admin-dashboard-frame-img">
    </div>

    <!-- Right Decorative Frame -->
    <div class="admin-dashboard-right-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_right_side.png') }}" alt="Right Frame" class="admin-dashboard-frame-img">
    </div>

    <div class="container admin-dashboard-wrapper">
        <!-- Success Message -->
        @if(session('success'))
            <div class="admin-dashboard-alert admin-dashboard-alert-success">
                <svg class="admin-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="admin-dashboard-alert admin-dashboard-alert-error">
                <svg class="admin-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Two Column Layout -->
        <div class="admin-dashboard-layout">
            <!-- Left Sidebar - Tabs -->
            <div class="admin-dashboard-sidebar">
                <div class="admin-dashboard-tabs">
                    <a href="{{ route('admin.dashboard', ['tab' => 'my-account']) }}" class="admin-dashboard-tab {{ ($activeTab ?? 'my-account') === 'my-account' ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>My Account</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'all-users']) }}" class="admin-dashboard-tab {{ ($activeTab ?? 'my-account') === 'all-users' ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>All Users</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'media-files']) }}" class="admin-dashboard-tab {{ ($activeTab ?? 'my-account') === 'media-files' ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8.586 11.414C9.367 10.633 10.633 10.633 11.414 11.414L16 16M14 14L15.586 12.414C16.367 11.633 17.633 11.633 18.414 12.414L22 16M2 20H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="2" y="4" width="20" height="4" rx="1" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <span>Media Files</span>
                    </a>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="admin-dashboard-content">
                @if(($activeTab ?? 'my-account') === 'my-account')
                    <!-- My Account Tab Content -->
                    <div class="admin-dashboard-tab-content">
                        <!-- Title Section -->
                        <div class="admin-dashboard-title-section">
                            <div class="admin-dashboard-decorative-top">
                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <!-- Decorative SVG Design - Just above My Account -->
                            <div class="admin-dashboard-decorative-svg">
                                <img src="{{ asset('Images/AdminAssets/paneltxtframeuper.svg') }}" alt="Decorative Design" class="admin-dashboard-svg-design">
                            </div>
                            <h1 class="admin-dashboard-title">My Account</h1>
                        </div>

                        <!-- Profile Picture Section -->
                        <div class="admin-dashboard-profile-section">
                            <div class="admin-dashboard-profile-picture">
                                <div class="admin-dashboard-profile-circle">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile Picture" class="admin-dashboard-profile-img">
                                    @else
                                        <span class="admin-dashboard-profile-initials">{{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <label for="profile_image_form" class="admin-dashboard-upload-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Upload new picture
                            </label>
                        </div>

                        <!-- Profile Form -->
                        <div class="admin-dashboard-form-section">
                            <form class="admin-dashboard-form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="profile-update-form">
                                @csrf
                                <input type="file" id="profile_image_form" name="profile_image" accept="image/*" style="display: none;" onchange="previewProfileImage(this)">
                                @error('profile_image')
                                    <div class="admin-dashboard-form-group">
                                        <span class="admin-dashboard-error-message">{{ $message }}</span>
                                    </div>
                                @enderror

                                <!-- First Name -->
                                <div class="admin-dashboard-form-group">
                                    <label for="first_name" class="admin-dashboard-label">First name <span class="admin-dashboard-required">*</span></label>
                                    <input type="text" id="first_name" name="first_name" class="admin-dashboard-input @error('first_name') admin-dashboard-input-error @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <span class="admin-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="admin-dashboard-form-group">
                                    <label for="last_name" class="admin-dashboard-label">Last name <span class="admin-dashboard-required">*</span></label>
                                    <input type="text" id="last_name" name="last_name" class="admin-dashboard-input @error('last_name') admin-dashboard-input-error @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <span class="admin-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="admin-dashboard-form-group">
                                    <label for="email" class="admin-dashboard-label">Email <span class="admin-dashboard-required">*</span></label>
                                    <input type="email" id="email" name="email" class="admin-dashboard-input @error('email') admin-dashboard-input-error @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="admin-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Change Password -->
                                <div class="admin-dashboard-form-group">
                                    <label for="password" class="admin-dashboard-label">Change password</label>
                                    <div class="admin-dashboard-password-wrapper">
                                        <input type="password" id="password" name="password" class="admin-dashboard-input @error('password') admin-dashboard-input-error @enderror" placeholder="Enter new password (optional)">
                                        <span class="admin-dashboard-password-toggle" onclick="togglePassword('password')">
                                            <svg class="admin-dashboard-eye-icon admin-dashboard-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <svg class="admin-dashboard-eye-icon admin-dashboard-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="admin-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="admin-dashboard-form-group">
                                    <label for="password_confirmation" class="admin-dashboard-label">Confirm password</label>
                                    <div class="admin-dashboard-password-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="admin-dashboard-input" placeholder="Confirm new password">
                                        <span class="admin-dashboard-password-toggle" onclick="togglePassword('password_confirmation')">
                                            <svg class="admin-dashboard-eye-icon admin-dashboard-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <svg class="admin-dashboard-eye-icon admin-dashboard-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="admin-dashboard-actions">
                                    <button type="submit" class="admin-dashboard-btn admin-dashboard-btn-primary">Update my profile</button>
                                </div>
                            </form>
                            
                            <!-- Logout Form (Outside profile form to avoid nesting) -->
                            <div class="admin-dashboard-actions" style="margin-top: 15px;">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline-block; width: 100%;">
                                    @csrf
                                    <button type="submit" class="admin-dashboard-btn admin-dashboard-btn-secondary" style="width: 100%;">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif(($activeTab ?? 'my-account') === 'all-users')
                    <!-- All Users Tab Content -->
                    <div class="admin-dashboard-tab-content">
                        <!-- Title Section -->
                        <div class="admin-dashboard-title-section">
                            <div class="admin-dashboard-decorative-top">
                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="admin-dashboard-decorative-svg">
                                <img src="{{ asset('Images/AdminAssets/paneltxtframeuper.svg') }}" alt="Decorative Design" class="admin-dashboard-svg-design">
                            </div>
                            <h1 class="admin-dashboard-title">All Users</h1>
                        </div>

                        <!-- Users Table -->
                        <div class="admin-dashboard-users-section">
                            <div class="admin-dashboard-users-table-wrapper">
                                <table class="admin-dashboard-users-table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Family Relation</th>
                                            <th>Status</th>
                                            <th>Approval</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users ?? [] as $userItem)
                                            <tr>
                                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <div class="admin-dashboard-user-info">
                                                        @if($userItem->profile_image)
                                                            <img src="{{ asset('storage/profile_images/' . $userItem->profile_image) }}" alt="{{ $userItem->first_name }}" class="admin-dashboard-user-avatar">
                                                        @else
                                                            <div class="admin-dashboard-user-avatar-initials">{{ strtoupper(substr($userItem->first_name, 0, 1) . substr($userItem->last_name, 0, 1)) }}</div>
                                                        @endif
                                                        <span>{{ $userItem->first_name }} {{ $userItem->last_name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $userItem->email }}</td>
                                                <td>
                                                    <span class="admin-dashboard-role-badge {{ $userItem->isAdmin() ? 'role-admin' : 'role-user' }}">
                                                        {{ $userItem->isAdmin() ? 'Admin' : 'User' }}
                                                    </span>
                                                </td>
                                                <td>{{ $userItem->family_relation ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="admin-dashboard-status-badge status-{{ $userItem->status ?? 'active' }}">
                                                        {{ ucfirst($userItem->status ?? 'active') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($userItem->isAdmin())
                                                        <span class="admin-dashboard-approval-badge approved">Auto Approved</span>
                                                    @elseif($userItem->is_approved)
                                                        <span class="admin-dashboard-approval-badge approved">Approved</span>
                                                    @else
                                                        <span class="admin-dashboard-approval-badge pending">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!$userItem->isAdmin())
                                                        @if($userItem->is_approved)
                                                            <form action="{{ route('admin.users.reject', $userItem->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="admin-dashboard-action-btn reject-btn" onclick="return confirm('Are you sure you want to reject this user?')">
                                                                    Reject
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.users.approve', $userItem->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="admin-dashboard-action-btn approve-btn">
                                                                    Approve
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <span class="admin-dashboard-action-btn disabled">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="admin-dashboard-empty-state">No users found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if(isset($users) && $users->hasPages())
                                <div class="admin-dashboard-pagination">
                                    <div class="admin-dashboard-pagination-info">
                                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                                    </div>
                                    <div class="admin-dashboard-pagination-links">
                                        {{ $users->appends(['tab' => 'all-users'])->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif(($activeTab ?? 'my-account') === 'media-files')
                    <!-- Media Files Tab Content -->
                    <div class="admin-dashboard-tab-content">
                        <!-- Title Section -->
                        <div class="admin-dashboard-title-section">
                            <div class="admin-dashboard-decorative-top">
                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="admin-dashboard-decorative-svg">
                                <img src="{{ asset('Images/AdminAssets/paneltxtframeuper.svg') }}" alt="Decorative Design" class="admin-dashboard-svg-design">
                            </div>
                            <h1 class="admin-dashboard-title">Media Files</h1>
                        </div>

                        <!-- Filter Section -->
                        <div class="admin-dashboard-media-filters">
                            <div class="admin-dashboard-filter-group">
                                <label for="userFilter" class="admin-dashboard-filter-label">Filter by User:</label>
                                <select id="userFilter" class="admin-dashboard-filter-select" onchange="filterMedia()">
                                    <option value="all">All Users</option>
                                    @foreach($usersWithMedia ?? [] as $user)
                                        <option value="{{ $user->id }}" {{ (isset($selectedUserId) && $selectedUserId == $user->id) || (!isset($selectedUserId) && $user->id == Auth::id()) ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }} {{ $user->isAdmin() ? '(Admin)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="admin-dashboard-filter-group">
                                <label for="categoryFilter" class="admin-dashboard-filter-label">Filter by Category:</label>
                                <select id="categoryFilter" class="admin-dashboard-filter-select" onchange="filterMedia()">
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category }}" {{ ($selectedCategory ?? ($categories->first() ?? 'all')) === $category ? 'selected' : '' }}>
                                            {{ ucfirst($category) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Media Files Section -->
                        <div class="admin-dashboard-media-section">
                            @forelse($mediaByUser ?? [] as $userId => $userMedia)
                                <div class="admin-dashboard-media-user-card">
                                    <div class="admin-dashboard-media-user-header">
                                        <div class="admin-dashboard-media-user-info">
                                            <h3 class="admin-dashboard-media-user-name">
                                                {{ $userMedia['user_name'] }}
                                                @if($userMedia['is_admin'])
                                                    <span class="admin-dashboard-media-badge">Admin</span>
                                                @endif
                                            </h3>
                                            <p class="admin-dashboard-media-user-email">{{ $userMedia['user_email'] }}</p>
                                        </div>
                                    </div>

                                    <div class="admin-dashboard-media-categories">
                                        @foreach($userMedia['categories'] ?? [] as $category => $media)
                                            <div class="admin-dashboard-media-category">
                                                <h4 class="admin-dashboard-media-category-title">{{ ucfirst($category) }}</h4>
                                                
                                                @if(isset($media['images']) && count($media['images']) > 0)
                                                    <div class="admin-dashboard-media-grid">
                                                        <h5 class="admin-dashboard-media-type-title">Images ({{ count($media['images']) }})</h5>
                                                        <div class="admin-dashboard-media-items">
                                                            @foreach($media['images'] as $image)
                                                                <div class="admin-dashboard-media-item">
                                                                    <img src="{{ $image['url'] }}" alt="Image" class="admin-dashboard-media-thumb">
                                                                    <div class="admin-dashboard-media-overlay">
                                                                        <form action="{{ route('admin.media.delete') }}" method="POST" class="admin-dashboard-media-delete-form" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                                            @csrf
                                                                            <input type="hidden" name="media_id" value="{{ $image['id'] }}">
                                                                            <input type="hidden" name="file_path" value="{{ $image['path'] }}">
                                                                            <input type="hidden" name="file_type" value="image">
                                                                            <button type="submit" class="admin-dashboard-media-delete-btn" title="Delete Image">
                                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M3 6H5H21M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                    <path d="M10 11V17M14 11V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(isset($media['videos']) && count($media['videos']) > 0)
                                                    <div class="admin-dashboard-media-grid">
                                                        <h5 class="admin-dashboard-media-type-title">Videos ({{ count($media['videos']) }})</h5>
                                                        <div class="admin-dashboard-media-items">
                                                            @foreach($media['videos'] as $video)
                                                                <div class="admin-dashboard-media-item">
                                                                    <video src="{{ $video['url'] }}" class="admin-dashboard-media-thumb"></video>
                                                                    <div class="admin-dashboard-media-overlay">
                                                                        <form action="{{ route('admin.media.delete') }}" method="POST" class="admin-dashboard-media-delete-form" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                                            @csrf
                                                                            <input type="hidden" name="media_id" value="{{ $video['id'] }}">
                                                                            <input type="hidden" name="file_path" value="{{ $video['path'] }}">
                                                                            <input type="hidden" name="file_type" value="video">
                                                                            <button type="submit" class="admin-dashboard-media-delete-btn" title="Delete Video">
                                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path d="M3 6H5H21M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                    <path d="M10 11V17M14 11V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="admin-dashboard-empty-state">
                                    <p>No media files uploaded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const wrapper = input.closest('.admin-dashboard-password-wrapper');
    const eyeOpen = wrapper.querySelector('.admin-dashboard-eye-open');
    const eyeClosed = wrapper.querySelector('.admin-dashboard-eye-closed');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
}

function previewProfileImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const profileCircle = document.querySelector('.admin-dashboard-profile-circle');
        
        reader.onload = function(e) {
            // Remove initials if exists
            const initials = profileCircle.querySelector('.admin-dashboard-profile-initials');
            if (initials) {
                initials.remove();
            }
            
            // Remove existing image if exists
            const existingImg = profileCircle.querySelector('.admin-dashboard-profile-img');
            if (existingImg) {
                existingImg.remove();
            }
            
            // Create and add new image
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Profile Picture';
            img.className = 'admin-dashboard-profile-img';
            profileCircle.appendChild(img);
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Media Files Filter Function
function filterMedia() {
    const userId = document.getElementById('userFilter').value;
    const category = document.getElementById('categoryFilter').value;
    const url = new URL(window.location.href);
    
    // Always set user_id (default is admin's ID, but can select 'all')
    if (userId === 'all') {
        url.searchParams.set('user_id', 'all');
    } else {
        url.searchParams.set('user_id', userId);
    }
    
    // Always set category (default is first category)
    url.searchParams.set('category', category);
    
    window.location.href = url.toString();
}

// Connect upload button to file input
document.addEventListener('DOMContentLoaded', function() {
    const uploadBtn = document.querySelector('.admin-dashboard-upload-btn');
    const fileInput = document.getElementById('profile_image_form');
    
    if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
    }
    
    // Handle form submission
    const form = document.getElementById('profile-update-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Form will submit normally with the file input included
        });
    }
});
</script>
@endpush
@endsection
