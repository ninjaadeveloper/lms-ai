@extends('../admin.layout')

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0"><i class="fas fa-envelope-open-text mr-1"></i> Feedback Detail</h4>
              <a href="{{ route('admin.feedback.admin') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back
              </a>
            </div>

            <div class="card-body">
              <div class="mb-2">
                <span class="badge badge-light text-capitalize">{{ $feedback->user_role ?? '-' }}</span>
                <span class="mx-2">•</span>
                <span class="text-muted">{{ optional($feedback->created_at)->format('d M Y, h:i A') }}</span>
              </div>

              <h5 class="mb-2">{{ $feedback->subject ?? 'No Subject' }}</h5>
              <p class="mb-0" style="line-height:1.9;">{{ $feedback->message }}</p>

              <hr>

              <div class="d-flex flex-wrap align-items-center">
                <div class="mr-3 mb-2">
                  <strong>User:</strong> {{ $feedback->user->name ?? '-' }}
                  <span class="text-muted">({{ $feedback->user->email ?? '' }})</span>
                </div>

                <div class="mr-3 mb-2">
                  <strong>Rating:</strong> {{ $feedback->rating ?? '-' }}
                </div>

                <div class="mb-2">
                  <strong>Status:</strong>
                  <span class="badge badge-{{ ($feedback->status=='new')?'danger':(($feedback->status=='read')?'warning':'success') }}">
                    {{ strtoupper($feedback->status ?? 'new') }}
                  </span>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <form method="POST" action="{{ route('admin.feedback.status', $feedback->id) }}" class="form-inline">
                @csrf
                <label class="mr-2">Update Status:</label>
                <select name="status" class="form-control mr-2">
                  <option value="new" {{ $feedback->status=='new'?'selected':'' }}>New</option>
                  <option value="read" {{ $feedback->status=='read'?'selected':'' }}>Read</option>
                  <option value="resolved" {{ $feedback->status=='resolved'?'selected':'' }}>Resolved</option>
                </select>
                <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save</button>
              </form>
            </div>

          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header">
              <h5 class="mb-0"><i class="fas fa-user mr-1"></i> User Snapshot</h5>
            </div>
            <div class="card-body">
              <div><strong>Name:</strong> {{ $feedback->user->name ?? '-' }}</div>
              <div class="text-muted"><strong>Email:</strong> {{ $feedback->user->email ?? '-' }}</div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>
@endsection