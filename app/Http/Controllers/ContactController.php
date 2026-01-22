<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = ContactMessage::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(ContactMessage $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        ContactMessage::create($request->only('name', 'email', 'message'));

        return redirect()->route('index', '#contact')
            ->with('success', 'Message sent successfully!');
    }
}