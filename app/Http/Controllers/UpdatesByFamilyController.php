<?php

namespace App\Http\Controllers;

use App\Mail\FamilyUpdateNotificationMail;
use App\Models\FamilyUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UpdatesByFamilyController extends Controller
{
    /**
     * Show the Updates by Family page with timeline (newest first).
     */
    public function index()
    {
        $updates = FamilyUpdate::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.updates_by_family', [
            'updates' => $updates,
        ]);
    }

    /**
     * Store a new family update (admin only).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('updates.by.family')
                ->with('error', 'Only admins can add updates.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1|max:2000',
        ], [
            'message.required' => 'Please enter an update message.',
            'message.max'      => 'Message may not exceed 2000 characters.',
        ]);

        $familyUpdate = FamilyUpdate::create([
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Notify all admins + only approved (non-admin) users; exclude the poster
        $recipients = User::where('id', '!=', $user->id)
            ->where(function ($q) {
                $q->where('is_admin', true)
                    ->orWhere('role', 'admin')
                    ->orWhere('is_approved', true);
            })
            ->get();
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new FamilyUpdateNotificationMail($recipient, $familyUpdate));
            } catch (\Throwable $e) {
                \Log::error('Family update email failed for ' . $recipient->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('updates.by.family')
            ->with('success', 'Update added successfully.');
    }

    /**
     * Update a family update (only the admin who posted it).
     */
    public function update(Request $request, FamilyUpdate $update)
    {
        $user = Auth::user();
        if (!$user || $update->user_id !== $user->id) {
            return redirect()->route('updates.by.family')
                ->with('error', 'You can only edit your own updates.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:1|max:2000',
        ], [
            'message.required' => 'Please enter an update message.',
            'message.max'     => 'Message may not exceed 2000 characters.',
        ]);

        $update->update(['message' => $validated['message']]);

        return redirect()->route('updates.by.family')
            ->with('success', 'Update updated successfully.');
    }

    /**
     * Delete a family update (only the admin who posted it).
     */
    public function destroy(FamilyUpdate $update)
    {
        $user = Auth::user();
        if (!$user || $update->user_id !== $user->id) {
            return redirect()->route('updates.by.family')
                ->with('error', 'You can only delete your own updates.');
        }

        $update->delete();

        return redirect()->route('updates.by.family')
            ->with('success', 'Update deleted successfully.');
    }
}
