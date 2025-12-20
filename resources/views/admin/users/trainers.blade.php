@extends('../admin.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4>All Trainers</h4>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                    @forelse($trainers as $key => $trainer)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $trainer->name }}</td>
                                        <td>{{ $trainer->email }}</td>
                                        <td>
                                            @if($trainer->status)
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-danger">Not Active</div>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('users.edit', $trainer->id) }}" class="btn btn-primary">Edit</a>
                                        </td> --}}
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No trainers found</td>
                                    </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
