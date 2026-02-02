<?php

namespace App\Http\Controllers;

use App\Models\PageSection;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Homepage with all sections (content from page_sections table).
     */
    public function index(): View
    {
        $sections = PageSection::getKeyedBySlug();
        $weddingDate = PageSection::weddingDate();

        return view('welcome', [
            'sections' => $sections,
            'weddingDate' => $weddingDate,
        ]);
    }
}
