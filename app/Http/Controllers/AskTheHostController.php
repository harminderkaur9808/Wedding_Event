<?php

namespace App\Http\Controllers;

use App\Mail\AskTheHostQuestionNotification;
use App\Mail\AskTheHostReplyNotification;
use App\Models\AskTheHostQuery;
use App\Models\AskTheHostReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AskTheHostController extends Controller
{
    /**
     * Show the Ask the Host page. Questions and replies only visible to logged-in users.
     */
    public function index()
    {
        $queries = collect();

        if (Auth::check()) {
            $queries = AskTheHostQuery::with(['user', 'replies' => fn ($q) => $q->with('user')->orderBy('created_at')])
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
            'question_text' => [
                'required',
                'string',
                'min:3',
                'max:2000',
                function ($attribute, $value, $fail) {
                    if (Str::wordCount($value) > 150) {
                        $fail('The question must not exceed 150 words. Current: ' . Str::wordCount($value) . ' words.');
                    }
                },
            ],
        ]);

        $query = AskTheHostQuery::create([
            'user_id' => Auth::id(),
            'question_text' => $request->question_text,
        ]);

        $admins = User::where('is_admin', true)->orWhere('role', 'admin')->get();
        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(new AskTheHostQuestionNotification($query));
            } catch (\Throwable $e) {
                Log::warning('Ask the Host notification email failed for admin ' . $admin->email, ['exception' => $e->getMessage()]);
            }
        }

        return redirect()->route('ask.the.host')->with('success', 'Your question has been posted.');
    }

    /**
     * Update a question (only the author can edit their own).
     */
    public function updateQuestion(Request $request, AskTheHostQuery $query)
    {
        if (Auth::id() !== (int) $query->user_id) {
            abort(403, 'You can only edit your own question.');
        }

        $request->validate([
            'question_text' => [
                'required',
                'string',
                'min:3',
                'max:2000',
                function ($attribute, $value, $fail) {
                    if (Str::wordCount($value) > 150) {
                        $fail('The question must not exceed 150 words.');
                    }
                },
            ],
        ]);

        $query->update(['question_text' => $request->question_text]);

        return redirect()->route('ask.the.host')->with('success', 'Question updated.');
    }

    /**
     * Delete a question (author or admin can delete; admin can delete any question including duplicates).
     */
    public function destroyQuestion(AskTheHostQuery $query)
    {
        $isAuthor = Auth::id() === (int) $query->user_id;
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        if (! $isAuthor && ! $isAdmin) {
            abort(403, 'You can only delete your own question.');
        }

        $query->replies()->delete();
        $query->delete();

        return redirect()->route('ask.the.host')->with('success', 'Question deleted.');
    }

    /**
     * Store a reply to a question or to another reply (nested thread). Auth required.
     */
    public function storeReply(Request $request, AskTheHostQuery $query)
    {
        $request->validate([
            'reply_text' => ['required', 'string', 'min:1', 'max:2000'],
            'parent_reply_id' => ['nullable', 'integer', 'exists:ask_the_host_replies,id'],
        ]);

        $parentReply = null;
        if ($request->filled('parent_reply_id')) {
            $parentReply = AskTheHostReply::where('id', $request->parent_reply_id)
                ->where('ask_the_host_query_id', $query->id)
                ->first();
            if (! $parentReply) {
                return redirect()->route('ask.the.host')->with('error', 'Invalid reply thread.');
            }
        }

        $reply = AskTheHostReply::create([
            'ask_the_host_query_id' => $query->id,
            'parent_reply_id' => $parentReply?->id,
            'user_id' => Auth::id(),
            'reply_text' => $request->reply_text,
        ]);

        // Notify everyone in the conversation (question author + parent reply author if nested); skip self and duplicates
        $recipients = collect();
        $questioner = $query->user;
        if ($questioner && $questioner->email && (int) $questioner->id !== (int) Auth::id()) {
            $recipients->put($questioner->email, $questioner);
        }
        if ($parentReply && $parentReply->user && $parentReply->user->email && (int) $parentReply->user_id !== (int) Auth::id()) {
            $recipients->put($parentReply->user->email, $parentReply->user);
        }

        foreach ($recipients as $email => $user) {
            try {
                Mail::to($email)->send(new AskTheHostReplyNotification($query, $reply, $parentReply));
            } catch (\Throwable $e) {
                Log::warning('Ask the Host reply notification email failed for ' . $email, ['exception' => $e->getMessage()]);
            }
        }

        return redirect()->route('ask.the.host')->with('success', 'Your reply has been posted.');
    }

    /**
     * Update a reply (only the author can edit their own).
     */
    public function updateReply(Request $request, AskTheHostReply $reply)
    {
        if (Auth::id() !== (int) $reply->user_id) {
            abort(403, 'You can only edit your own reply.');
        }

        $request->validate([
            'reply_text' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        $reply->update(['reply_text' => $request->reply_text]);

        return redirect()->route('ask.the.host')->with('success', 'Reply updated.');
    }

    /**
     * Delete a reply (author or admin can delete; admin can delete any reply).
     */
    public function destroyReply(AskTheHostReply $reply)
    {
        $isAuthor = Auth::id() === (int) $reply->user_id;
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        if (! $isAuthor && ! $isAdmin) {
            abort(403, 'You can only delete your own reply.');
        }

        $reply->delete();

        return redirect()->route('ask.the.host')->with('success', 'Reply deleted.');
    }
}
