@extends('admin.layout')

@section('content')
<div class="main-content">
    <section class="section">

        <div class="card">
            <div class="card-header">
                <h4>Contact Message</h4>
            </div>

            <div class="card-body">
                <p><strong>Name:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Date:</strong> {{ $contact->created_at->format('d M Y') }}</p>

                <hr>

                <p><strong>Message:</strong></p>
                <div class="p-3 bg-light rounded">
                    {{ $contact->message }}
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary">
                    Back
                </a>
            </div>
        </div>

    </section>
</div>
@endsection
