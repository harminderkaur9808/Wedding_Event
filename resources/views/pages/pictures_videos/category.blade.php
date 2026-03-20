@extends('layouts.app')

@section('title', $categoryName . ' - Pictures and Videos - Wedding Event')

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

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
            <!-- Back to Pictures & Videos -->
            <div class="wm-pv-category-back-wrap">
                <a href="{{ route('pictures_videos') }}" class="wm-pv-category-back-btn" aria-label="Back to Pictures and Videos">
                    <svg class="wm-pv-category-back-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Back to Pictures &amp; Videos
                </a>
            </div>
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
                $perPage = 28;
                $itemsInitial = array_slice($items, 0, $perPage);
                $totalItems = count($items);
                $hasMore = $totalItems > $perPage;
            @endphp
            <!-- Image/Video Grid (28 shown by default, View More loads next 28). Admin can drag to reorder. -->
            <div class="wm-pv-category-grid" id="galleryGrid" data-shown="{{ count($itemsInitial) }}" data-total="{{ $totalItems }}" data-per-page="{{ $perPage }}">
                @auth
                    @forelse($itemsInitial as $index => $item)
                        <div class="wm-pv-category-item" data-id="{{ $item['id'] }}" data-index="{{ $index }}" onclick="openImageViewer({{ $index }})">
                            @if(!empty($canReorder))
                            <div class="wm-pv-drag-handle" title="Drag to reorder (admin)" onclick="event.stopPropagation();" onmousedown="event.stopPropagation();" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 6h.01M8 12h.01M8 18h.01M16 6h.01M16 12h.01M16 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            @endif
                            <div class="wm-pv-category-item-image">
                                @if(isset($item['is_video']) && $item['is_video'])
                                    <video src="{{ $item['url'] }}" class="wm-pv-category-item-img" style="object-fit: cover;"></video>
                                @else
                                    <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="wm-pv-category-item-img"
                                         loading="{{ $index < 6 ? 'eager' : 'lazy' }}"
                                         {{ $index < 4 ? 'fetchpriority="high"' : '' }}
                                         decoding="async"
                                         onload="this.classList.add('loaded')"
                                         onerror="this.style.opacity=1">
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

            <!-- View More Button (shows when more than 28 items; loads next 28 on click) -->
            @if($hasMore)
                <div class="wm-pv-category-view-more" id="viewMoreContainer">
                    <button type="button" class="wm-pv-category-view-more-btn" id="viewMoreBtn">View More</button>
                </div>
            @endif
            @if(!empty($canReorder))
            <div class="wm-pv-order-toast" id="galleryOrderToast" aria-live="polite">Order saved.</div>
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
                            <span>Images (JPEG, PNG, GIF, WEBP — Max 20 MB each)
                                <span class="wm-pv-compress-badge">Auto-compressed for fast loading &bull; originals kept for download</span>
                            </span>
                            <input type="file" name="images[]" accept="image/*" multiple class="wm-pv-upload-input" id="imagesInput">
                        </label>
                        <div class="wm-pv-upload-file-info" id="imagesInfo"></div>
                    </div>

                    <div class="wm-pv-upload-form-group">
                        <label class="wm-pv-upload-label">
                            <span>Videos (MP4, AVI, MOV, WMV, FLV, WEBM — Max 200 MB each)</span>
                            <input type="file" name="videos[]" accept="video/*" multiple class="wm-pv-upload-input" id="videosInput">
                        </label>
                        <div class="wm-pv-upload-file-info" id="videosInfo"></div>
                    </div>

                    <!-- Upload progress (shown while uploading) -->
                    <div class="wm-pv-upload-progress-wrap" id="uploadProgressWrap" style="display:none;">
                        <div class="wm-pv-upload-progress-track">
                            <div class="wm-pv-upload-progress-fill" id="uploadProgressFill"></div>
                        </div>
                        <div class="wm-pv-upload-progress-label" id="uploadProgressLabel">Uploading… 0%</div>
                    </div>

                    <!-- Success state (shown after upload) -->
                    <div class="wm-pv-upload-success-wrap" id="uploadSuccessWrap" style="display:none;">
                        <svg class="wm-pv-upload-success-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" fill="#dcfce7"/>
                            <path d="M7 12.5L10.5 16L17 9" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="wm-pv-upload-success-text">Upload complete! Refreshing…</span>
                    </div>

                    <div class="wm-pv-upload-form-actions" id="uploadFormActions">
                        <button type="button" class="wm-pv-upload-btn-cancel" id="uploadCancelBtn" onclick="closeUploadModal()">Cancel</button>
                        <button type="submit" class="wm-pv-upload-btn-submit" id="uploadSubmitBtn" disabled>
                            <span class="wm-pv-upload-btn-spinner" id="uploadBtnSpinner" style="display:none;"></span>
                            <span id="uploadSubmitText">Upload Media</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const galleryItems = @json($items);
let currentImageIndex = 0;
const currentCategory = '{{ $category }}';
const currentType = '{{ $type }}';
const perPage = {{ $perPage ?? 28 }};
const showFullViewIconUrl = @json(asset('Images/picturesandvideos/Showfullviewicon.png'));
const canReorder = @json($canReorder ?? false);
const galleryOrderUrl = @json(route('pictures_videos.gallery_order', ['category' => $category]));
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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
    document.body.classList.add('pv-viewer-open');
}

function closeImageViewer() {
    document.getElementById('imageViewer').classList.remove('active');
    document.body.style.overflow = '';
    document.body.classList.remove('pv-viewer-open');
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
    
    // Add counter and download link
    const infoDiv = document.createElement('div');
    infoDiv.className = 'wm-pv-image-viewer-info';
    infoDiv.innerHTML = `<span id="viewerCounter">${currentImageIndex + 1} / ${galleryItems.length}</span>`;
    if (item.download_url) {
        const downloadLink = document.createElement('a');
        downloadLink.href = item.download_url;
        downloadLink.className = 'wm-pv-image-viewer-download';
        downloadLink.setAttribute('download', '');
        downloadLink.title = 'Download';
        downloadLink.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Download';
        infoDiv.appendChild(downloadLink);
    }
    viewerContent.appendChild(infoDiv);
    
    // Update button states
    document.getElementById('prevBtn').style.opacity = galleryItems.length > 1 ? '1' : '0.5';
    document.getElementById('nextBtn').style.opacity = galleryItems.length > 1 ? '1' : '0.5';
}

// ── Upload Modal ────────────────────────────────────────────────────
var pvUploading = false;

function openUploadModal() {
    document.getElementById('uploadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    if (pvUploading) return; // block close while uploading
    document.getElementById('uploadModal').classList.remove('active');
    document.body.style.overflow = '';
    pvResetUploadModal();
}

function pvResetUploadModal() {
    document.getElementById('uploadForm').reset();
    pvUploading = false;
    ['uploadProgressWrap', 'uploadSuccessWrap'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
    var info = document.getElementById('imagesInfo');
    if (info) { info.textContent = ''; info.removeAttribute('style'); }
    var vinfo = document.getElementById('videosInfo');
    if (vinfo) { vinfo.textContent = ''; vinfo.removeAttribute('style'); }
    var actions = document.getElementById('uploadFormActions');
    if (actions) actions.style.display = '';
    pvSetSubmitBtn(false, 'Upload Media');
}

function pvSetSubmitBtn(enabled, label) {
    var btn  = document.getElementById('uploadSubmitBtn');
    var txt  = document.getElementById('uploadSubmitText');
    var spin = document.getElementById('uploadBtnSpinner');
    if (!btn) return;
    btn.disabled = !enabled;
    if (txt)  txt.textContent = label || 'Upload Media';
    if (spin) spin.style.display = 'none';
}

// File input handlers + XHR upload
document.addEventListener('DOMContentLoaded', function() {
    var imagesInput = document.getElementById('imagesInput');
    var videosInput = document.getElementById('videosInput');
    var uploadForm  = document.getElementById('uploadForm');

    function pvCheckReady() {
        var hasImages = imagesInput && imagesInput.files && imagesInput.files.length > 0;
        var hasVideos = videosInput && videosInput.files && videosInput.files.length > 0;
        pvSetSubmitBtn(hasImages || hasVideos, 'Upload Media');
    }

    if (imagesInput) {
        imagesInput.addEventListener('change', function() {
            var info = document.getElementById('imagesInfo');
            if (this.files.length > 0) {
                info.textContent = this.files.length + ' image' + (this.files.length > 1 ? 's' : '') + ' selected';
                info.style.color = '#2F4F75';
            } else {
                info.textContent = '';
                info.removeAttribute('style');
            }
            pvCheckReady();
        });
    }

    if (videosInput) {
        videosInput.addEventListener('change', function() {
            var info = document.getElementById('videosInfo');
            if (this.files.length > 0) {
                info.textContent = this.files.length + ' video' + (this.files.length > 1 ? 's' : '') + ' selected';
                info.style.color = '#2F4F75';
            } else {
                info.textContent = '';
                info.removeAttribute('style');
            }
            pvCheckReady();
        });
    }

    // Intercept form submit — XHR so we can track upload progress
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (pvUploading) return;

            var hasImages = imagesInput && imagesInput.files && imagesInput.files.length > 0;
            var hasVideos = videosInput && videosInput.files && videosInput.files.length > 0;
            if (!hasImages && !hasVideos) return;

            pvUploading = true;

            var fd = new FormData(uploadForm);

            document.getElementById('uploadProgressWrap').style.display = 'block';
            document.getElementById('uploadFormActions').style.display = 'none';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', uploadForm.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.upload.onprogress = function(ev) {
                if (!ev.lengthComputable) return;
                var pct = Math.round((ev.loaded / ev.total) * 100);
                var fill  = document.getElementById('uploadProgressFill');
                var label = document.getElementById('uploadProgressLabel');
                if (fill)  fill.style.width = pct + '%';
                if (label) label.textContent = 'Uploading… ' + pct + '%';
            };

            xhr.onload = function() {
                pvUploading = false;
                document.getElementById('uploadProgressWrap').style.display = 'none';
                document.getElementById('uploadSuccessWrap').style.display = 'flex';
                setTimeout(function() { window.location.reload(); }, 1200);
            };

            xhr.onerror = function() {
                pvUploading = false;
                document.getElementById('uploadProgressWrap').style.display = 'none';
                document.getElementById('uploadFormActions').style.display = '';
                pvSetSubmitBtn(true, 'Upload Media');
                alert('Upload failed. Please try again.');
            };

            xhr.send(fd);
        });
    }

    // Escape closes modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var m = document.getElementById('uploadModal');
            if (m && m.classList.contains('active')) closeUploadModal();
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

// Mark image as loaded when already cached (e.g. complete)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wm-pv-category-item-img[src]').forEach(function(img) {
        if (img.tagName.toLowerCase() === 'img' && img.complete) img.classList.add('loaded');
    });
});

// Admin drag-and-drop: init Sortable and save order on drop
document.addEventListener('DOMContentLoaded', function() {
    if (!canReorder || typeof Sortable === 'undefined') return;
    const galleryGrid = document.getElementById('galleryGrid');
    if (!galleryGrid) return;

    new Sortable(galleryGrid, {
        handle: '.wm-pv-drag-handle',
        animation: 200,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        onStart: function() {
            galleryGrid.classList.add('sortable-dragging');
        },
        onEnd: function() {
            galleryGrid.classList.remove('sortable-dragging');
            var visibleIds = [];
            Array.from(galleryGrid.querySelectorAll('.wm-pv-category-item')).forEach(function(el) {
                var id = el.getAttribute('data-id');
                if (id) visibleIds.push(id);
            });
            var allIds = galleryItems.map(function(item) { return item.id; });
            var restIds = allIds.filter(function(id) { return visibleIds.indexOf(id) === -1; });
            var fullOrder = visibleIds.concat(restIds);

            fetch(galleryOrderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ order: fullOrder, type: currentType })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    var byId = {};
                    galleryItems.forEach(function(item) { byId[item.id] = item; });
                    var reordered = [];
                    fullOrder.forEach(function(id) {
                        if (byId[id]) reordered.push(byId[id]);
                    });
                    galleryItems.length = 0;
                    reordered.forEach(function(item) { galleryItems.push(item); });
                    galleryGrid.querySelectorAll('.wm-pv-category-item').forEach(function(el, idx) {
                        el.setAttribute('data-index', idx);
                        el.onclick = function() { openImageViewer(idx); };
                    });
                    showGalleryOrderSaved();
                } else {
                    alert(data.message || 'Failed to save order.');
                }
            })
            .catch(function() {
                alert('Failed to save order.');
            });
        }
    });
});

// View More: load next 28 items
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
            div.setAttribute('data-id', item.id);
            div.setAttribute('data-index', i);
            div.onclick = function() { openImageViewer(i); };

            let mediaHtml;
            if (item.is_video) {
                mediaHtml = '<video src="' + escapeHtml(item.url) + '" class="wm-pv-category-item-img" style="object-fit: cover;"></video>';
            } else {
                mediaHtml = '<img src="' + escapeHtml(item.url) + '" alt="' + escapeHtml(item.title) + '" class="wm-pv-category-item-img" loading="lazy" decoding="async" onload="this.classList.add(\'loaded\')" onerror="this.style.opacity=1">';
            }
            const badgeHtml = item.is_current_user ? '<div style="position: absolute; top: 8px; right: 8px; background: rgba(46, 125, 50, 0.9); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Your Upload</div>' : '';
            const handleHtml = canReorder ? '<div class="wm-pv-drag-handle" title="Drag to reorder (admin)" onclick="event.stopPropagation();" onmousedown="event.stopPropagation();" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 6h.01M8 12h.01M8 18h.01M16 6h.01M16 12h.01M16 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>' : '';
            div.innerHTML = handleHtml + '<div class="wm-pv-category-item-image">' + mediaHtml +
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

function showGalleryOrderSaved() {
    var el = document.getElementById('galleryOrderToast');
    if (el) {
        el.classList.add('show');
        clearTimeout(window._galleryOrderToastTimer);
        window._galleryOrderToastTimer = setTimeout(function() { el.classList.remove('show'); }, 3000);
    }
}
</script>
@endpush
@endsection
