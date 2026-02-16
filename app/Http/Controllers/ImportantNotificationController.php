<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\TravelAccommodationEntry;
use App\Models\TravelAccommodationNote;
use Illuminate\View\View;

class ImportantNotificationController extends Controller
{
    /**
     * Show the Important Notification (Travel & Accommodation) page.
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
        $notes = $allNotes;

        $allTagOptions = Note::notificationTagOptions();
        $usedTagSlugs = $allNotes->pluck('tags')->flatten()->unique()->filter()->values()->all();
        $tagOptions = array_intersect_key($allTagOptions, array_flip($usedTagSlugs));

        $travelEntries = TravelAccommodationEntry::where('type', TravelAccommodationEntry::TYPE_TRAVEL)
            ->orderBy('sort_order')->orderBy('id')->get();
        $accommodationEntries = TravelAccommodationEntry::where('type', TravelAccommodationEntry::TYPE_ACCOMMODATION)
            ->orderBy('sort_order')->orderBy('id')->get();

        $travelNote = null;
        $accommodationNote = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('travel_accommodation_notes')) {
            $travelNote = TravelAccommodationNote::where('type', TravelAccommodationNote::TYPE_TRAVEL)->first();
            $accommodationNote = TravelAccommodationNote::where('type', TravelAccommodationNote::TYPE_ACCOMMODATION)->first();
        }

        return view('pages.important_notification', [
            'notes' => $notes,
            'notesTotalCount' => $notesTotalCount,
            'tagOptions' => $tagOptions,
            'travelEntries' => $travelEntries,
            'accommodationEntries' => $accommodationEntries,
            'travelNote' => $travelNote,
            'accommodationNote' => $accommodationNote,
        ]);
    }
}
