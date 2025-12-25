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

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Please fix errors:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      @endif

      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header">
              <h4 class="mb-0"><i class="fas fa-comment-dots mr-1"></i> Submit Feedback</h4>
            </div>

            <form action="{{ route(auth()->user()->role.'.feedback.store') }}" method="POST">
              @csrf
              <div class="card-body">

                <div class="form-group">
                  <label>Subject (optional)</label>
                  <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="e.g. Course issue / Suggestion">
                </div>

                <div class="form-group">
                  <label>Message <span class="text-danger">*</span></label>
                  <textarea name="message" class="form-control" rows="5" placeholder="Write your feedback...">{{ old('message') }}</textarea>
                </div>

                <div class="form-group">
                  <label>Rating (optional)</label>
                  <select name="rating" class="form-control">
                    <option value="">-- Select --</option>
                    @for($i=1;$i<=5;$i++)
                      <option value="{{ $i }}" {{ old('rating')==$i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>

              </div>
              <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-primary">
                  <i class="fas fa-paper-plane mr-1"></i> Submit
                </button>
              </div>
            </form>

          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="card shadow-sm">
            <div class="card-header">
              <h5 class="mb-0"><i class="fas fa-info-circle mr-1"></i> Note</h5>
            </div>
            <div class="card-body text-muted" style="line-height:1.8;">
              Your feedback will be reviewed by the admin. Please keep it clear and helpful.
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>
@endsection
