@extends('layouts.app')

@section('title', isset($note) ? 'Edit Note - Admin' : 'Create Note - Admin')

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
                    <a href="{{ route('admin.dashboard', ['tab' => 'all-users']) }}" class="admin-dashboard-tab">
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
                    <a href="{{ route('admin.dashboard', ['tab' => 'notes']) }}" class="admin-dashboard-tab active">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Notes</span>
                    </a>
                </div>
            </div>

            <div class="admin-dashboard-content">
                <div class="admin-dashboard-tab-content admin-notes-form-tab">
                    <div class="admin-notes-form-header">
                        <h1 class="admin-notes-form-title">{{ isset($note) ? 'Edit Note' : 'Create Note' }}</h1>
                        <a href="{{ route('admin.dashboard', ['tab' => 'notes']) }}" class="admin-dashboard-btn admin-dashboard-btn-secondary admin-notes-back-btn">Back to Notes</a>
                    </div>

                    <form method="POST" action="{{ isset($note) ? route('admin.notes.update', $note->id) : route('admin.notes.store') }}" class="admin-notes-form">
                        @csrf
                        @if(isset($note))
                            @method('PUT')
                        @endif
                        <div class="admin-notes-form-card">
                            <div class="admin-notes-form-section">
                                <label for="note_content" class="admin-notes-form-label">Content</label>
                                <textarea id="note_content" name="content" class="admin-notes-form-textarea" rows="6" placeholder="Write your note...">{{ old('content', $note->content ?? '') }}</textarea>
                                @error('content')
                                    <span class="admin-dashboard-form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="admin-notes-form-section">
                                <span class="admin-notes-form-label">Tags</span>
                                <p class="admin-notes-form-hint">Select one or more tags so guests can filter this note on the Important Notification page.</p>
                                <div class="admin-notes-form-tags">
                                    @foreach($tagOptions as $slug => $label)
                                        <label class="admin-notes-form-tag">
                                            <input type="checkbox" name="tags[]" value="{{ $slug }}" class="admin-notes-form-tag-cb"
                                                {{ in_array($slug, old('tags', $note->tags ?? []), true) ? 'checked' : '' }}>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="admin-notes-form-section">
                                <span class="admin-notes-form-label">Share with admins</span>
                                <p class="admin-notes-form-hint">Select admins who can view and edit this note. Only you and the selected admins can access it.</p>
                                @if($adminUsers->isNotEmpty())
                                    @php
                                        $selectedShareIds = old('share_with', isset($note) ? $note->sharedWith->pluck('id')->toArray() : []);
                                    @endphp
                                    <div class="admin-notes-share-dropdown-wrap">
                                        <button type="button" class="admin-notes-share-trigger" id="shareWithTrigger" aria-haspopup="listbox" aria-expanded="false" aria-label="Select admins to share with">
                                            <span class="admin-notes-share-trigger-text" id="shareWithTriggerText">Select admins...</span>
                                            <svg class="admin-notes-share-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                        </button>
                                        <div class="admin-notes-share-panel" id="shareWithPanel" role="listbox" aria-multiselectable="true" hidden>
                                            @foreach($adminUsers as $admin)
                                                <label class="admin-notes-share-option">
                                                    <input type="checkbox" name="share_with[]" value="{{ $admin->id }}" class="admin-notes-share-cb" {{ in_array($admin->id, $selectedShareIds, true) ? 'checked' : '' }}>
                                                    <span>{{ $admin->first_name }} {{ $admin->last_name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p class="admin-notes-form-empty">No other admins to share with.</p>
                                @endif
                            </div>

                            <div class="admin-notes-form-actions">
                                <a href="{{ route('admin.dashboard', ['tab' => 'notes']) }}" class="admin-dashboard-btn admin-dashboard-btn-secondary">Cancel</a>
                                <button type="submit" class="admin-dashboard-btn admin-dashboard-btn-primary admin-notes-submit">
                                    {{ isset($note) ? 'Update Note' : 'Create Note' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var trigger = document.getElementById('shareWithTrigger');
    var panel = document.getElementById('shareWithPanel');
    var triggerText = document.getElementById('shareWithTriggerText');
    if (trigger && panel && triggerText) {
        function updateTriggerText() {
            var checked = panel.querySelectorAll('.admin-notes-share-cb:checked');
            if (checked.length === 0) triggerText.textContent = 'Select admins...';
            else if (checked.length === 1) triggerText.textContent = '1 admin selected';
            else triggerText.textContent = checked.length + ' admins selected';
        }
        updateTriggerText();
        panel.querySelectorAll('.admin-notes-share-cb').forEach(function(cb) {
            cb.addEventListener('change', updateTriggerText);
        });
        trigger.addEventListener('click', function() {
            var open = panel.hidden === false;
            panel.hidden = open;
            trigger.setAttribute('aria-expanded', !open);
            trigger.classList.toggle('admin-notes-share-trigger--open', !open);
        });
        document.addEventListener('click', function(e) {
            if (panel && !panel.hidden && !trigger.contains(e.target) && !panel.contains(e.target)) {
                panel.hidden = true;
                trigger.setAttribute('aria-expanded', 'false');
                trigger.classList.remove('admin-notes-share-trigger--open');
            }
        });
    }
})();
</script>
@endpush
@endsection
