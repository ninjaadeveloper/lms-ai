@extends('../admin.layout')

@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-body">

        {{-- Flash Messages --}}
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
        @endif

        <div class="row">
          <div class="col-12">
            <div class="card shadow-sm">

              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Quizzes</h4>

                {{-- ✅ create is course-based, so send admin to courses list --}}
                <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary btn-sm">
                  <i class="fas fa-plus"></i> Add Quiz
                </a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped table-hover mb-0">
                    <thead>
                      <tr>
                        <th style="width:70px;">#</th>
                        <th>Quiz</th>
                        <th>Course</th>
                        <th class="text-center" style="width:180px;">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($quizzes as $key => $qz)
                        <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.quizzes.show', $qz->id) }}'">

                          <td>
                            {{ ($quizzes->currentPage() - 1) * $quizzes->perPage() + $key + 1 }}
                          </td>

                          <td>
                            <strong>{{ $qz->title ?? ($qz->topic ?? 'Quiz') }}</strong><br>
                            <small class="text-muted">Created {{ optional($qz->created_at)->diffForHumans() }}</small>
                          </td>

                          <td>
                            <strong>{{ $qz->course->title ?? '-' }}</strong><br>
                            <small class="text-muted">Total Qs:
                              {{ $qz->total_questions ?? ($qz->questions_count ?? '-') }}</small>
                          </td>

                          <td class="text-center" onclick="event.stopPropagation();">
                            <a href="{{ route('admin.quizzes.show', $qz->id) }}" class="btn btn-sm btn-info" title="View">
                              <i class="fas fa-eye"></i>
                            </a>

                            <form action="{{ route('admin.quizzes.destroy', $qz->id) }}" method="POST"
                              style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this quiz?')"
                                title="Delete">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </td>

                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center text-muted py-4">No quizzes found.</td>
                        </tr>
                      @endforelse
                    </tbody>

                  </table>
                </div>
              </div>

              <div class="card-footer text-right">
                {{ $quizzes->links() }}
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
@endsection