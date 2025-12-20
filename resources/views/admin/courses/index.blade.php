@extends('../admin.layout')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Courses</h4>
                            {{-- <a href="{{ route('courses.create') }}" class="btn btn-primary float-right">Add Course</a> --}}
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        {{-- <th>AI Description</th> --}}
                                        <th>Duration (hrs)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>

                                    @forelse($courses as $key => $course)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ Str::limit($course->description, 50) }}</td>
                                        {{-- <td>{{ Str::limit($course->ai_description, 50) }}</td> --}}
                                        <td>{{ $course->duration_hours ?? '-' }}</td>
                                        <td>
                                            @if($course->status)
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-danger">Inactive</div>
                                            @endif
                                        </td>
                                        <td>
                                             <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info">Detail</a>
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No courses found</td>
                                    </tr>
                                    @endforelse

                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <!-- Pagination placeholder -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
