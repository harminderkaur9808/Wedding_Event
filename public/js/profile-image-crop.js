// Profile Image Cropper (Admin + User dashboards)
// Requires Cropper.js loaded on the page.

(function () {
    const fileInput = document.getElementById('profile_image_form');
    const modal = document.getElementById('profileImageCropModal');
    const sourceImg = document.getElementById('profileImageCropSource');
    const applyBtn = document.getElementById('profileImageCropApply');
    const cancelBtn = document.getElementById('profileImageCropCancel');
    const closeXBtn = document.getElementById('profileImageCropCloseX');
    const previewEl = document.querySelector('.wm-crop-preview');

    if (!fileInput || !modal || !sourceImg || !applyBtn || !cancelBtn || !previewEl) return;

    let cropper = null;
    let objectUrl = null;
    let lastPreviewUrl = null;

    function openModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        // Allow re-selecting the same file later
        fileInput.value = '';
    }

    function setCirclePreview(url) {
        // Revoke old preview url if it was a blob url we created
        if (lastPreviewUrl && lastPreviewUrl.startsWith('blob:')) {
            try { URL.revokeObjectURL(lastPreviewUrl); } catch (e) {}
        }
        lastPreviewUrl = url;

        const circle =
            document.querySelector('.admin-dashboard-profile-circle') ||
            document.querySelector('.user-dashboard-profile-circle');

        if (!circle) return;

        const initials =
            circle.querySelector('.admin-dashboard-profile-initials') ||
            circle.querySelector('.user-dashboard-profile-initials');
        if (initials) initials.remove();

        const existingImg =
            circle.querySelector('.admin-dashboard-profile-img') ||
            circle.querySelector('.user-dashboard-profile-img');
        if (existingImg) existingImg.remove();

        const img = document.createElement('img');
        img.src = url;
        img.alt = 'Profile Picture';
        img.className = circle.classList.contains('admin-dashboard-profile-circle')
            ? 'admin-dashboard-profile-img'
            : 'user-dashboard-profile-img';
        circle.appendChild(img);
    }

    function initCropper() {
        if (cropper) cropper.destroy();
        cropper = new Cropper(sourceImg, {
            viewMode: 1,
            aspectRatio: 1,
            dragMode: 'move',
            autoCropArea: 1,
            responsive: true,
            background: false,
            guides: false,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            preview: previewEl,
        });
    }

    fileInput.addEventListener('change', function () {
        const file = fileInput.files && fileInput.files[0];
        if (!file) return;
        if (!file.type || !file.type.startsWith('image/')) return;

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
        objectUrl = URL.createObjectURL(file);
        sourceImg.src = objectUrl;

        sourceImg.onerror = function () {
            if (objectUrl) URL.revokeObjectURL(objectUrl);
            objectUrl = null;
            fileInput.value = '';
            alert('Failed to load the image. Please try another file.');
        };

        sourceImg.onload = function () {
            initCropper();
            openModal();
        };
    });

    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) return meta.getAttribute('content');
        var input = document.querySelector('input[name="_token"]');
        return input ? input.value : '';
    }

    applyBtn.addEventListener('click', function () {
        if (!cropper) return;

        var uploadUrl = modal.getAttribute('data-profile-image-url');
        var btnEl = applyBtn;
        var originalText = btnEl.textContent;

        // Output size: good balance between quality + file size
        var canvas = cropper.getCroppedCanvas({
            width: 420,
            height: 420,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function (blob) {
            if (!blob) return;
            var croppedFile = new File([blob], 'profile.png', { type: 'image/png' });

            if (uploadUrl) {
                btnEl.disabled = true;
                btnEl.textContent = 'Saving…';
                var formData = new FormData();
                formData.append('profile_image', croppedFile);
                formData.append('_token', getCsrfToken());

                fetch(uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                })
                    .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, status: res.status, data: data }; }); })
                    .then(function (result) {
                        if (result.ok && result.data.success && result.data.url) {
                            setCirclePreview(result.data.url);
                            closeModal();
                        } else {
                            var msg = result.data.message || (result.data.errors && result.data.errors.profile_image && result.data.errors.profile_image[0]) || 'Failed to save image.';
                            alert(msg);
                        }
                    })
                    .catch(function () {
                        alert('Failed to save image. Please try again.');
                    })
                    .finally(function () {
                        btnEl.disabled = false;
                        btnEl.textContent = originalText;
                    });
                return;
            }

            // Fallback: no upload URL – just update local preview and file input
            var dt = new DataTransfer();
            dt.items.add(croppedFile);
            fileInput.files = dt.files;
            setCirclePreview(URL.createObjectURL(blob));
            closeModal();
        }, 'image/png', 0.92);
    });

    cancelBtn.addEventListener('click', function () {
        closeModal();
    });

    if (closeXBtn) {
        closeXBtn.addEventListener('click', function () {
            closeModal();
        });
    }

    // Close on overlay click
    const overlay = modal.querySelector('.admin-dashboard-modal-overlay, .user-dashboard-modal-overlay');
    if (overlay) overlay.addEventListener('click', closeModal);

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
})();

