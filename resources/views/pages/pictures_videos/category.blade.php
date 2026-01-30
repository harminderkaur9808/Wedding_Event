@extends('layouts.app')

@section('title', $categoryName . ' - Pictures and Videos - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pictures-videos.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="wm-pv-hero">
        <div class="wm-pv-hero-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/picturesandvideos/Pictures-and-Videos.png') }}"
                alt=""
                class="wm-pv-hero-bg-img"
            >
        </div>
        <div class="wm-pv-hero-overlay" aria-hidden="true"></div>
        <div class="container wm-pv-hero-content">
            <div class="wm-pv-hero-text">
                <div class="wm-pv-hero-eyebrow">Wedding Gallery</div>
                <div class="wm-pv-hero-decorative">
                    <img src="{{ asset('Images/picturesandvideos/betweentxt_design.svg') }}" alt="Decorative Element" class="wm-pv-hero-decorative-img">
                </div>
                <h1 class="wm-pv-hero-title">{{ $categoryName }} Images & video</h1>
            </div>
        </div>
    </section>

    <!-- Gallery Section with Tabs -->
    <section class="wm-pv-gallery-section">
        <div class="container">
            <!-- Tabs and Add Media Button -->
            <div class="wm-pv-category-controls">
                <div class="wm-pv-category-tabs">
                    <a href="{{ route('pictures_videos.category', ['category' => $category, 'type' => 'images']) }}" 
                       class="wm-pv-category-tab {{ $type === 'images' ? 'active' : '' }}">
                        Images
                    </a>
                    <a href="{{ route('pictures_videos.category', ['category' => $category, 'type' => 'videos']) }}" 
                       class="wm-pv-category-tab {{ $type === 'videos' ? 'active' : '' }}">
                        Videos
                    </a>
                </div>
                @auth
                <button class="wm-pv-category-add-btn" onclick="openUploadModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Add media
                </button>
                @endauth
            </div>

            @php
                $perPage = 12;
                $itemsInitial = array_slice($items, 0, $perPage);
                $totalItems = count($items);
                $hasMore = $totalItems > $perPage;
            @endphp
            <!-- Image/Video Grid (12 shown by default, View More loads next 12) -->
            <div class="wm-pv-category-grid" id="galleryGrid" data-shown="{{ count($itemsInitial) }}" data-total="{{ $totalItems }}" data-per-page="{{ $perPage }}">
                @auth
                    @forelse($itemsInitial as $index => $item)
                        <div class="wm-pv-category-item" data-index="{{ $index }}" onclick="openImageViewer({{ $index }})">
                            <div class="wm-pv-category-item-image">
                                @if(isset($item['is_video']) && $item['is_video'])
                                    <video src="{{ $item['url'] }}" class="wm-pv-category-item-img" style="object-fit: cover;"></video>
                                @else
                                    <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="wm-pv-category-item-img">
                                @endif
                                <div class="wm-pv-category-item-overlay">
                                    <img src="{{ asset('Images/picturesandvideos/Showfullviewicon.png') }}" alt="View Full" class="wm-pv-category-item-hover-icon">
                                </div>
                                @if(isset($item['is_current_user']) && $item['is_current_user'])
                                    <div style="position: absolute; top: 8px; right: 8px; background: rgba(46, 125, 50, 0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Your Upload</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="wm-pv-category-empty">
                            <p>No {{ $type }} available for {{ $categoryName }} yet.</p>
                            <p style="margin-top: 10px;">Be the first to upload {{ $type }}!</p>
                        </div>
                    @endforelse
                @else
                    <!-- Lock Icon for Non-Logged In Users -->
                    <div class="wm-pv-category-lock-container">
                        <a href="{{ route('login') }}" class="wm-pv-category-lock-link">
                            <div class="wm-pv-category-lock-icon">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3 class="wm-pv-category-lock-title">Login Required</h3>
                            <p class="wm-pv-category-lock-message">Please login to view {{ $type }} for {{ $categoryName }}</p>
                            <button class="wm-pv-category-lock-btn">Go to Login</button>
                        </a>
                    </div>
                @endauth
            </div>

            <!-- View More Button (shows when more than 12 items; loads next 12 on click) -->
            @if($hasMore)
                <div class="wm-pv-category-view-more" id="viewMoreContainer">
                    <button type="button" class="wm-pv-category-view-more-btn" id="viewMoreBtn">View More</button>
                </div>
            @endif
        </div>
    </section>

    <!-- Image Viewer Modal -->
    <div class="wm-pv-image-viewer" id="imageViewer">
        <div class="wm-pv-image-viewer-overlay" onclick="closeImageViewer()"></div>
        <div class="wm-pv-image-viewer-container">
            <button class="wm-pv-image-viewer-close" onclick="closeImageViewer()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <button class="wm-pv-image-viewer-nav wm-pv-image-viewer-prev" onclick="navigateImage(-1)" id="prevBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <div class="wm-pv-image-viewer-content">
                <img id="viewerImage" src="" alt="" class="wm-pv-image-viewer-img">
                <div class="wm-pv-image-viewer-info">
                    <span id="viewerCounter">1 / {{ $totalItems ?? count($items) }}</span>
                </div>
            </div>
            
            <button class="wm-pv-image-viewer-nav wm-pv-image-viewer-next" onclick="navigateImage(1)" id="nextBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Upload Media Modal -->
    @auth
    <div class="wm-pv-upload-modal" id="uploadModal">
        <div class="wm-pv-upload-modal-overlay" onclick="closeUploadModal()"></div>
        <div class="wm-pv-upload-modal-container">
            <button class="wm-pv-upload-modal-close" onclick="closeUploadModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <div class="wm-pv-upload-modal-content">
                <h2 class="wm-pv-upload-modal-title">Upload Media to {{ $categoryName }}</h2>
                
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 20px; padding: 12px; background: #d4edda; color: #155724; border-radius: 4px;">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger" style="margin-bottom: 20px; padding: 12px; background: #f8d7da; color: #721c24; border-radius: 4px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('pictures_videos.upload', ['category' => $category]) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    
                    <div class="wm-pv-upload-form-group">
                        <label class="wm-pv-upload-label">
                            <span>Images (JPEG, PNG, JPG, GIF, WEBP - Max 5MB each)</span>
                            <input type="file" name="images[]" accept="image/*" multiple class="wm-pv-upload-input" id="imagesInput">
                            <div class="wm-pv-upload-file-info" id="imagesInfo"></div>
                        </label>
                    </div>
                    
                    <div class="wm-pv-upload-form-group">
                        <label class="wm-pv-upload-label">
                            <span>Videos (MP4, AVI, MOV, WMV, FLV, WEBM - Max 50MB each)</span>
                            <input type="file" name="videos[]" accept="video/*" multiple class="wm-pv-upload-input" id="videosInput">
                            <div class="wm-pv-upload-file-info" id="videosInfo"></div>
                        </label>
                    </div>
                    
                    <div class="wm-pv-upload-form-actions">
                        <button type="button" class="wm-pv-upload-btn-cancel" onclick="closeUploadModal()">Cancel</button>
                        <button type="submit" class="wm-pv-upload-btn-submit">Upload Media</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

@push('scripts')
<script>
const galleryItems = @json($items);
let currentImageIndex = 0;
const currentCategory = '{{ $category }}';
const currentType = '{{ $type }}';
const perPage = {{ $perPage ?? 12 }};
const showFullViewIconUrl = @json(asset('Images/picturesandvideos/Showfullviewicon.png'));

// Fix history navigation - prevent multiple history entries when switching tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.wm-pv-category-tab');
    
    tabLinks.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const url = new URL(href, window.location.origin);
            const typeParam = url.searchParams.get('type');
            
            // Check if we're switching tabs on the same category page
            const currentPath = window.location.pathname;
            const newPath = url.pathname;
            
            if (currentPath === newPath && typeParam !== currentType) {
                // Same category, different type - replace current history entry instead of adding new one
                e.preventDefault();
                // Use location.replace to replace current history entry
                window.location.replace(href);
            }
            // If different category, allow normal navigation (creates new history entry)
        });
    });
});

function openImageViewer(index) {
    currentImageIndex = index;
    updateImageViewer();
    document.getElementById('imageViewer').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Don't create history entries for image viewer
    // The modal is just a UI overlay, not a navigation state
}

function closeImageViewer() {
    document.getElementById('imageViewer').classList.remove('active');
    document.body.style.overflow = '';
}

function navigateImage(direction) {
    currentImageIndex += direction;
    
    if (currentImageIndex < 0) {
        currentImageIndex = galleryItems.length - 1;
    } else if (currentImageIndex >= galleryItems.length) {
        currentImageIndex = 0;
    }
    
    updateImageViewer();
}

function updateImageViewer() {
    const item = galleryItems[currentImageIndex];
    const viewerContent = document.querySelector('.wm-pv-image-viewer-content');
    const viewerImage = document.getElementById('viewerImage');
    
    // Clear previous content
    viewerContent.innerHTML = '';
    
    if (item.is_video) {
        // Create video element
        const video = document.createElement('video');
        video.src = item.url;
        video.controls = true;
        video.className = 'wm-pv-image-viewer-img';
        video.style.width = '100%';
        video.style.maxHeight = '80vh';
        video.style.objectFit = 'contain';
        viewerContent.appendChild(video);
    } else {
        // Create image element
        const img = document.createElement('img');
        img.id = 'viewerImage';
        img.src = item.url;
        img.alt = item.title;
        img.className = 'wm-pv-image-viewer-img';
        viewerContent.appendChild(img);
    }
    
    // Add counter
    const counter = document.createElement('div');
    counter.className = 'wm-pv-image-viewer-info';
    counter.id = 'viewerCounter';
    counter.textContent = `${currentImageIndex + 1} / ${galleryItems.length}`;
    viewerContent.appendChild(counter);
    
    // Update button states
    document.getElementById('prevBtn').style.opacity = galleryItems.length > 1 ? '1' : '0.5';
    document.getElementById('nextBtn').style.opacity = galleryItems.length > 1 ? '1' : '0.5';
}

// Upload Modal Functions
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('active');
    document.body.style.overflow = '';
    // Reset form
    document.getElementById('uploadForm').reset();
    document.getElementById('imagesInfo').textContent = '';
    document.getElementById('videosInfo').textContent = '';
}

// File input change handlers
document.addEventListener('DOMContentLoaded', function() {
    const imagesInput = document.getElementById('imagesInput');
    const videosInput = document.getElementById('videosInput');
    
    if (imagesInput) {
        imagesInput.addEventListener('change', function(e) {
            const files = e.target.files;
            const info = document.getElementById('imagesInfo');
            if (files.length > 0) {
                info.textContent = `${files.length} image(s) selected`;
                info.style.color = '#28a745';
            } else {
                info.textContent = '';
            }
        });
    }
    
    if (videosInput) {
        videosInput.addEventListener('change', function(e) {
            const files = e.target.files;
            const info = document.getElementById('videosInfo');
            if (files.length > 0) {
                info.textContent = `${files.length} video(s) selected`;
                info.style.color = '#28a745';
            } else {
                info.textContent = '';
            }
        });
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const uploadModal = document.getElementById('uploadModal');
            if (uploadModal && uploadModal.classList.contains('active')) {
                closeUploadModal();
            }
        }
    });
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const viewer = document.getElementById('imageViewer');
    if (viewer && viewer.classList.contains('active')) {
        if (e.key === 'ArrowLeft') {
            navigateImage(-1);
        } else if (e.key === 'ArrowRight') {
            navigateImage(1);
        } else if (e.key === 'Escape') {
            closeImageViewer();
        }
    }
});

// View More: load next 12 items
document.addEventListener('DOMContentLoaded', function() {
    const viewMoreBtn = document.getElementById('viewMoreBtn');
    const galleryGrid = document.getElementById('galleryGrid');
    if (!viewMoreBtn || !galleryGrid) return;

    viewMoreBtn.addEventListener('click', function() {
        const shown = parseInt(galleryGrid.getAttribute('data-shown') || '0', 10);
        const total = galleryItems.length;
        const next = Math.min(shown + perPage, total);

        for (let i = shown; i < next; i++) {
            const item = galleryItems[i];
            const div = document.createElement('div');
            div.className = 'wm-pv-category-item';
            div.setAttribute('data-index', i);
            div.onclick = function() { openImageViewer(i); };

            let mediaHtml;
            if (item.is_video) {
                mediaHtml = '<video src="' + escapeHtml(item.url) + '" class="wm-pv-category-item-img" style="object-fit: cover;"></video>';
            } else {
                mediaHtml = '<img src="' + escapeHtml(item.url) + '" alt="' + escapeHtml(item.title) + '" class="wm-pv-category-item-img">';
            }
            const badgeHtml = item.is_current_user ? '<div style="position: absolute; top: 8px; right: 8px; background: rgba(46, 125, 50, 0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Your Upload</div>' : '';
            div.innerHTML = '<div class="wm-pv-category-item-image">' + mediaHtml +
                '<div class="wm-pv-category-item-overlay"><img src="' + escapeHtml(showFullViewIconUrl) + '" alt="View Full" class="wm-pv-category-item-hover-icon"></div>' +
                badgeHtml + '</div>';
            galleryGrid.appendChild(div);
        }

        galleryGrid.setAttribute('data-shown', next);
        if (next >= total) {
            document.getElementById('viewMoreContainer').style.display = 'none';
        }
    });
});
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endpush
@endsection
