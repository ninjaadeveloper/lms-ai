<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // ===============================
    // Student / Trainer
    // ===============================

    // feedback form
    public function index()
    {
        return view(auth()->user()->role . '.feedback.index');
    }

    // submit feedback
    public function store(Request $request)
    {
        $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:5'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'subject' => $request->subject,
            'message' => $request->message,
            'rating' => $request->rating,
            'status' => 'new',
        ]);

        return back()->with('success', 'Feedback submitted successfully.');
    }

    // ===============================
    // Admin
    // ===============================

    // list page
    public function adminIndex(Request $request)
    {
        $q = Feedback::with('user')->orderByDesc('id');

        if ($request->filled('role')) {
            $q->where('user_role', $request->role);
        }

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $q->where(function ($qq) use ($s) {
                $qq->where('subject', 'like', "%{$s}%")
                    ->orWhere('message', 'like', "%{$s}%")
                    ->orWhereHas('user', function ($u) use ($s) {
                        $u->where('name', 'like', "%{$s}%")
                            ->orWhere('email', 'like', "%{$s}%");
                    });
            });
        }

        $feedbacks = $q->paginate(20)->withQueryString();

        return view('admin.feedback.index', compact('feedbacks'));
    }

    // 🔥 FIXED: single feedback show
// ✅ Admin: single feedback show
    public function adminShow(Feedback $feedback)
    {
        $feedback->load('user');

        // auto mark as read
        if (($feedback->status ?? 'new') === 'new') {
            $feedback->update(['status' => 'read']);
        }

        return view('admin.feedback.show', compact('feedback'));
    }

    // update status
    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => ['required', 'in:new,read,resolved'],
        ]);

        $feedback->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Feedback status updated.');
    }
}
