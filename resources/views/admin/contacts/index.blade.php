@extends('admin.layout')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4>Contact Messages</h4>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $key => $contact)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ Str::limit($contact->message, 50) }}</td>
                                        <td>{{ $contact->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                                class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $contacts->links() }}
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection