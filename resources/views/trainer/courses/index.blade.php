@extends('admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>My Courses</h1>
    </div>

    <div class="section-body">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($courses->count() === 0)
        <div class="card">
          <div class="card-body text-center py-5">
            <h6 class="mb-1">No courses found</h6>
            <small class="text-muted">Abhi aapko koi course assign nahi hua.</small>
          </div>
        </div>
      @else
        <div class="row">
          @foreach($courses as $course)
            <div class="col-12 col-md-6 col-lg-4">
              <div class="card">
                <div class="card-header">
                  <h4 class="mb-0">{{ $course->title }}</h4>
                </div>

                <div class="card-body">
                  <p class="text-muted mb-3">
                    {{ \Illuminate\Support\Str::limit($course->description, 120) }}
                  </p>

                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      @if(($course->status ?? 0))
                        <span class="badge badge-success">Active</span>
                      @else
                        <span class="badge badge-danger">Inactive</span>
                      @endif
                    </div>

                    <div class="text-right">
                      <a href="{{ route('trainer.courses.show', $course->id) }}" class="btn btn-sm btn-info">
                        View
                      </a>

                      <a href="{{ route('trainer.courses.edit', $course->id) }}" class="btn btn-sm btn-primary">
                        Edit
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-muted">
                  <small>Created: {{ optional($course->created_at)->format('d M Y') }}</small>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-3">
          {{ $courses->links() }}
        </div>
      @endif

    </div>
  </section>
</div>
@endsection
