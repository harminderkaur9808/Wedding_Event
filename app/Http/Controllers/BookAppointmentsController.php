<?php

namespace App\Http\Controllers;

use App\Models\BookAppointmentEntry;

class BookAppointmentsController extends Controller
{
    /**
     * Show the Book your appointments page with dynamic entries.
     */
    public function index()
    {
        $entriesBySection = BookAppointmentEntry::getGroupedBySection();
        return view('pages.book_appointments', [
            'entriesBySection' => $entriesBySection,
        ]);
    }
}
