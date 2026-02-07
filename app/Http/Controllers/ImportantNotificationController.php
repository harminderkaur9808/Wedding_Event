<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\View\View;

class ImportantNotificationController extends Controller
{
    /**
     * Show the Important Notification page. Notes with tags appear as notifications and can be filtered by tag.
     */
    public function index(): View
    {
        $allNotes = Note::with('user:id,first_name,last_name,profile_image')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->filter(function ($n) {
                if (empty($n->tags) || ! is_array($n->tags)) {
                    return false;
                }
                $hasContent = trim((string) ($n->content ?? '')) !== '' || trim((string) ($n->title ?? '')) !== '';
                return $hasContent;
            })
            ->values();

        $notesTotalCount = $allNotes->count();
        $notes = $allNotes->take(10);

        // Only show filter tags that have at least one notification with a message
        $allTagOptions = Note::notificationTagOptions();
        $usedTagSlugs = $allNotes->pluck('tags')->flatten()->unique()->filter()->values()->all();
        $tagOptions = array_intersect_key($allTagOptions, array_flip($usedTagSlugs));

        return view('pages.important_notification', [
            'notes' => $notes,
            'notesTotalCount' => $notesTotalCount,
            'tagOptions' => $tagOptions,
        ]);
    }
}
