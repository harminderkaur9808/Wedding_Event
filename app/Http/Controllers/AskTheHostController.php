<?php

namespace App\Http\Controllers;

use App\Models\AskTheHostQuery;
use App\Models\AskTheHostReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AskTheHostController extends Controller
{
    /**
     * Show the Ask the Host page. Questions and replies only visible to logged-in users.
     */
    public function index()
    {
        $queries = collect();

        if (Auth::check()) {
            $queries = AskTheHostQuery::with(['user', 'replies' => fn ($q) => $q->with('user')])
                ->withCount('replies')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('pages.ask_the_host', compact('queries'));
    }

    /**
     * Store a new question (auth required).
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question_text' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        AskTheHostQuery::create([
            'user_id' => Auth::id(),
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('ask.the.host')->with('success', 'Your question has been posted.');
    }

    /**
     * Store a reply to a question (auth required).
     */
    public function storeReply(Request $request, AskTheHostQuery $query)
    {
        $request->validate([
            'reply_text' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        AskTheHostReply::create([
            'ask_the_host_query_id' => $query->id,
            'user_id' => Auth::id(),
            'reply_text' => $request->reply_text,
        ]);

        return redirect()->route('ask.the.host')->with('success', 'Your reply has been posted.');
    }
}
