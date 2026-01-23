@extends('layouts.app')

@section('title', 'User Dashboard - Wedding Event')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
@endpush

@section('content')
<div class="user-dashboard-container">
    <!-- Left Decorative Frame -->
    <div class="user-dashboard-left-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_Left_side.png') }}" alt="Left Frame" class="user-dashboard-frame-img">
    </div>

    <!-- Right Decorative Frame -->
    <div class="user-dashboard-right-frame">
        <img src="{{ asset('Images/AdminAssets/Frame_right_side.png') }}" alt="Right Frame" class="user-dashboard-frame-img">
    </div>

    <div class="container user-dashboard-wrapper">
        <!-- Success Message -->
        @if(session('success'))
            <div class="user-dashboard-alert user-dashboard-alert-success">
                <svg class="user-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="user-dashboard-alert user-dashboard-alert-error">
                <svg class="user-dashboard-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Two Column Layout -->
        <div class="user-dashboard-layout">
            <!-- Left Sidebar - Tabs -->
            <div class="user-dashboard-sidebar">
                <div class="user-dashboard-tabs">
                    <a href="{{ route('user.dashboard', ['tab' => 'my-account']) }}" class="user-dashboard-tab {{ ($activeTab ?? 'my-account') === 'my-account' ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>My Account</span>
                    </a>
                    <a href="{{ route('user.dashboard', ['tab' => 'media-files']) }}" class="user-dashboard-tab {{ ($activeTab ?? 'my-account') === 'media-files' ? 'active' : '' }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16L8.586 11.414C9.367 10.633 10.633 10.633 11.414 11.414L16 16M14 14L15.586 12.414C16.367 11.633 17.633 11.633 18.414 12.414L22 16M2 20H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="2" y="4" width="20" height="4" rx="1" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <span>Media Files</span>
                    </a>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="user-dashboard-content">
                @if(($activeTab ?? 'my-account') === 'my-account')
                    <!-- My Account Tab Content -->
                    <div class="user-dashboard-tab-content">
                        <!-- Title Section -->
                        <div class="user-dashboard-title-section">
                            <div class="user-dashboard-decorative-top">
                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="user-dashboard-decorative-svg">
                                <img src="{{ asset('Images/AdminAssets/paneltxtframeuper.svg') }}" alt="Decorative Design" class="user-dashboard-svg-design">
                            </div>
                            <h1 class="user-dashboard-title">My Account</h1>
                        </div>

                        <!-- Profile Picture Section -->
                        <div class="user-dashboard-profile-section">
                            <div class="user-dashboard-profile-picture">
                                <div class="user-dashboard-profile-circle">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile Picture" class="user-dashboard-profile-img">
                                    @else
                                        <span class="user-dashboard-profile-initials">{{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <label for="profile_image_form" class="user-dashboard-upload-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Upload new picture
                            </label>
                        </div>

                        <!-- Profile Form -->
                        <div class="user-dashboard-form-section">
                            <form class="user-dashboard-form" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" id="profile-update-form">
                                @csrf
                                <input type="file" id="profile_image_form" name="profile_image" accept="image/*" style="display: none;" onchange="previewProfileImage(this)">
                                @error('profile_image')
                                    <div class="user-dashboard-form-group">
                                        <span class="user-dashboard-error-message">{{ $message }}</span>
                                    </div>
                                @enderror

                                <!-- First Name -->
                                <div class="user-dashboard-form-group">
                                    <label for="first_name" class="user-dashboard-label">First name <span class="user-dashboard-required">*</span></label>
                                    <input type="text" id="first_name" name="first_name" class="user-dashboard-input @error('first_name') user-dashboard-input-error @enderror" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <span class="user-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div class="user-dashboard-form-group">
                                    <label for="last_name" class="user-dashboard-label">Last name <span class="user-dashboard-required">*</span></label>
                                    <input type="text" id="last_name" name="last_name" class="user-dashboard-input @error('last_name') user-dashboard-input-error @enderror" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <span class="user-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="user-dashboard-form-group">
                                    <label for="email" class="user-dashboard-label">Email <span class="user-dashboard-required">*</span></label>
                                    <input type="email" id="email" name="email" class="user-dashboard-input @error('email') user-dashboard-input-error @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="user-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Change Password -->
                                <div class="user-dashboard-form-group">
                                    <label for="password" class="user-dashboard-label">Change password</label>
                                    <div class="user-dashboard-password-wrapper">
                                        <input type="password" id="password" name="password" class="user-dashboard-input @error('password') user-dashboard-input-error @enderror" placeholder="Enter new password (optional)">
                                        <span class="user-dashboard-password-toggle" onclick="togglePassword('password')">
                                            <svg class="user-dashboard-eye-icon user-dashboard-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <svg class="user-dashboard-eye-icon user-dashboard-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="user-dashboard-error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div class="user-dashboard-form-group">
                                    <label for="password_confirmation" class="user-dashboard-label">Confirm password</label>
                                    <div class="user-dashboard-password-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="user-dashboard-input" placeholder="Confirm new password">
                                        <span class="user-dashboard-password-toggle" onclick="togglePassword('password_confirmation')">
                                            <svg class="user-dashboard-eye-icon user-dashboard-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <svg class="user-dashboard-eye-icon user-dashboard-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="user-dashboard-actions">
                                    <button type="submit" class="user-dashboard-btn user-dashboard-btn-primary">Update my profile</button>
                                </div>
                            </form>
                            
                            <!-- Logout Form (Outside profile form) -->
                            <div class="user-dashboard-actions" style="margin-top: 15px;">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline-block; width: 100%;">
                                    @csrf
                                    <button type="submit" class="user-dashboard-btn user-dashboard-btn-secondary" style="width: 100%;">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif(($activeTab ?? 'my-account') === 'media-files')
                    <!-- Media Files Tab Content -->
                    <div class="user-dashboard-tab-content">
                        <!-- Title Section -->
                        <div class="user-dashboard-title-section">
                            <div class="user-dashboard-decorative-top">
                                <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="user-dashboard-decorative-svg">
                                <img src="{{ asset('Images/AdminAssets/paneltxtframeuper.svg') }}" alt="Decorative Design" class="user-dashboard-svg-design">
                            </div>
                            <h1 class="user-dashboard-title">Media Files</h1>
                        </div>

                        <!-- Filter Section -->
                        <div class="user-dashboard-media-filters">
                            <div class="user-dashboard-filter-group">
                                <label for="categoryFilter" class="user-dashboard-filter-label">Filter by Category:</label>
                                <select id="categoryFilter" class="user-dashboard-filter-select" onchange="filterUserMedia()">
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category }}" {{ ($selectedCategory ?? ($categories->first() ?? 'all')) === $category ? 'selected' : '' }}>
                                            {{ ucfirst($category) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Media Files Section -->
                        <div class="user-dashboard-media-section">
                            @forelse($mediaByCategory ?? [] as $category => $media)
                                <div class="user-dashboard-media-category-card">
                                    <h3 class="user-dashboard-media-category-title">{{ ucfirst($category) }}</h3>
                                    
                                    @if(isset($media['images']) && count($media['images']) > 0)
                                        <div class="user-dashboard-media-grid">
                                            <h4 class="user-dashboard-media-type-title">Images ({{ count($media['images']) }})</h4>
                                            <div class="user-dashboard-media-items">
                                                @foreach($media['images'] as $image)
                                                    <div class="user-dashboard-media-item">
                                                        <img src="{{ $image['url'] }}" alt="Image" class="user-dashboard-media-thumb">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($media['videos']) && count($media['videos']) > 0)
                                        <div class="user-dashboard-media-grid">
                                            <h4 class="user-dashboard-media-type-title">Videos ({{ count($media['videos']) }})</h4>
                                            <div class="user-dashboard-media-items">
                                                @foreach($media['videos'] as $video)
                                                    <div class="user-dashboard-media-item">
                                                        <video src="{{ $video['url'] }}" class="user-dashboard-media-thumb"></video>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="user-dashboard-empty-state">
                                    <p>No media files uploaded yet.</p>
                                    <p style="margin-top: 10px;">Visit the <a href="{{ route('pictures_videos') }}" style="color: #2F4F75; text-decoration: underline;">Pictures & Videos</a> section to upload your media.</p>
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
    const wrapper = input.closest('.user-dashboard-password-wrapper');
    const eyeOpen = wrapper.querySelector('.user-dashboard-eye-open');
    const eyeClosed = wrapper.querySelector('.user-dashboard-eye-closed');
    
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
        const profileCircle = document.querySelector('.user-dashboard-profile-circle');
        
        reader.onload = function(e) {
            const initials = profileCircle.querySelector('.user-dashboard-profile-initials');
            if (initials) {
                initials.remove();
            }
            
            const existingImg = profileCircle.querySelector('.user-dashboard-profile-img');
            if (existingImg) {
                existingImg.remove();
            }
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Profile Picture';
            img.className = 'user-dashboard-profile-img';
            profileCircle.appendChild(img);
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// User Media Filter Function
function filterUserMedia() {
    const category = document.getElementById('categoryFilter').value;
    const url = new URL(window.location.href);
    
    url.searchParams.set('category', category);
    url.searchParams.set('tab', 'media-files');
    
    window.location.href = url.toString();
}

// Connect upload button to file input
document.addEventListener('DOMContentLoaded', function() {
    const uploadBtn = document.querySelector('.user-dashboard-upload-btn');
    const fileInput = document.getElementById('profile_image_form');
    
    if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
    }
    
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
