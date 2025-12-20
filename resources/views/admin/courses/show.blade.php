@extends('../admin.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-light">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Course Details</h4>
                            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm">Back to Courses</a>
                        </div>
                        <div class="card-body">

                            <div class="mb-4">
                                <h5 class="text-muted">Title</h5>
                                <p class="h6">{{ $course->title }}</p>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-muted">Description</h5>
                                <p class="text-justify">{{ $course->description ?? '-' }}</p>
                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6">
                                    <h5 class="text-muted">Duration (hours)</h5>
                                    <p>{{ $course->duration_hours ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-muted">Status</h5>
                                    @if($course->status)
                                        <span class="badge badge-success py-2 px-3">Active</span>
                                    @else
                                        <span class="badge badge-danger py-2 px-3">Inactive</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
