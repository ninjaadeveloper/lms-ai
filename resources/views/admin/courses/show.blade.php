@extends('../admin.layout')

@section('content')
@php
    use Illuminate\Support\Facades\DB;

    // ✅ Enrollments (course_students)
    $enrollmentsCount = 0;
    $recentEnrolled = collect();

    if (\Illuminate\Support\Facades\Schema::hasTable('course_students')) {
        $enrollmentsCount = DB::table('course_students')
            ->where('course_id', $course->id)
            ->count();

        // recent 10 students
        $recentEnrolled = DB::table('course_students')
            ->join('users', 'users.id', '=', 'course_students.user_id')
            ->where('course_students.course_id', $course->id)
            ->orderByDesc('course_students.created_at')
            ->select('users.id','users.name','users.email','course_students.created_at')
            ->limit(10)
            ->get();
    }

    // ✅ YouTube ID helper
    $youtubeId = null;
    if (!empty($course->video_url)) {
        $url = $course->video_url;

        if (str_contains($url, 'youtu.be/')) {
            $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
            $youtubeId = $path ?: null;
        }

        if (!$youtubeId && str_contains($url, 'youtube.com')) {
            parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $q);
            $youtubeId = $q['v'] ?? null;
        }
    }

    // ✅ trainer relation (may be null)
    $trainer = $course->trainer ?? null;
@endphp

<div class="main-content">
    <section class="section">
        <div class="section-body">

            {{-- Flash Messages --}}
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

            <div class="row justify-content-center">
                <div class="col-12 col-lg-12">

                    {{-- Header Card --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div>
                                <h4 class="mb-1">{{ $course->title }}</h4>
                                <div class="text-muted">
                                    <small>
                                        Created: {{ optional($course->created_at)->format('d M Y') ?? '-' }}
                                        <span class="mx-2">•</span>
                                        Updated: {{ optional($course->updated_at)->format('d M Y') ?? '-' }}
                                        <span class="mx-2">•</span>
                                        <span class="badge badge-light">Enrollments: {{ $enrollmentsCount }}</span>
                                    </small>
                                </div>
                            </div>

                            <div class="mt-3 mt-md-0 d-flex flex-wrap">
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-light mr-2 mb-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>

                                {{-- ✅ Full list page --}}
                                <a href="{{ route('admin.courses.enrollments', $course->id) }}" class="btn btn-secondary mr-2 mb-2">
                                    <i class="fas fa-users mr-1"></i> Enrollments
                                </a>

                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-primary mr-2 mb-2">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>

                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        {{-- Left: Overview + Enrolled Students --}}
                        <div class="col-12 col-lg-7">

                            {{-- Overview --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-info-circle mr-1"></i> Overview</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Description</h6>
                                        <p class="mb-0" style="line-height: 1.8;">
                                            {{ $course->description ?: 'No description added yet.' }}
                                        </p>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <h6 class="text-muted mb-1">Duration (hours)</h6>
                                            <span class="badge badge-light p-2">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $course->duration_hours ?? '-' }}
                                            </span>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-1">Status</h6>
                                            @if($course->status)
                                                <span class="badge badge-success py-2 px-3">
                                                    <i class="fas fa-check-circle mr-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-danger py-2 px-3">
                                                    <i class="fas fa-times-circle mr-1"></i> Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Enrolled Students (Quick View) --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-user-graduate mr-1"></i> Recently Enrolled Students</h5>
                                    <a href="{{ route('admin.courses.enrollments', $course->id) }}" class="btn btn-sm btn-outline-secondary">
                                        View All
                                    </a>
                                </div>

                                <div class="card-body p-0">
                                    @if($enrollmentsCount === 0)
                                        <div class="p-4 text-muted">No students enrolled yet.</div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th class="text-right">Enrolled At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentEnrolled as $s)
                                                        <tr>
                                                            <td>{{ $s->name }}</td>
                                                            <td>{{ $s->email }}</td>
                                                            <td class="text-right">{{ \Carbon\Carbon::parse($s->created_at)->format('d M Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Right: Trainer + Content --}}
                        <div class="col-12 col-lg-5">

                            {{-- Trainer --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-chalkboard-teacher mr-1"></i> Trainer</h5>
                                </div>

                                <div class="card-body">
                                    @if($trainer)
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <div class="avatar-initial rounded-circle bg-primary text-white"
                                                     style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
                                                    {{ strtoupper(substr($trainer->name ?? 'T', 0, 1)) }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="font-weight-bold">{{ $trainer->name }}</div>
                                                <small class="text-muted">{{ $trainer->email }}</small>
                                                <div class="mt-1">
                                                    <span class="badge badge-light">Assigned Trainer</span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-muted">No trainer assigned yet.</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Course Content --}}
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-folder-open mr-1"></i> Course Content</h5>
                                </div>

                                <div class="card-body">

                                    {{-- Video --}}
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-muted">Video</h6>
                                            @if(!empty($course->video_url))
                                                <span class="badge badge-info">URL</span>
                                            @endif
                                        </div>

                                        @if(!empty($course->video_url))
                                            <div class="d-flex flex-wrap">
                                                <a href="{{ $course->video_url }}" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                                    <i class="fas fa-play mr-1"></i> Open Video
                                                </a>
                                                <button class="btn btn-outline-secondary btn-sm mb-2" type="button"
                                                        onclick="navigator.clipboard.writeText('{{ $course->video_url }}')">
                                                    <i class="far fa-copy mr-1"></i> Copy Link
                                                </button>
                                            </div>

                                            @if($youtubeId)
                                                <div class="mt-3">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item"
                                                                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                                                allowfullscreen></iframe>
                                                    </div>
                                                    <small class="text-muted d-block mt-1">
                                                        If the preview doesn’t load, use “Open Video”.
                                                    </small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-muted">No video link added.</div>
                                        @endif
                                    </div>

                                    <hr>

                                    {{-- PDF --}}
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0 text-muted">PDF Resource</h6>
                                            @if(!empty($course->pdf_file))
                                                <span class="badge badge-success">PDF</span>
                                            @endif
                                        </div>

                                        @if(!empty($course->pdf_file))
                                            <div class="d-flex flex-wrap">
                                                <a href="{{ asset('storage/'.$course->pdf_file) }}" target="_blank"
                                                   class="btn btn-outline-success btn-sm mr-2 mb-2">
                                                    <i class="far fa-file-pdf mr-1"></i> View PDF
                                                </a>
                                                <a href="{{ asset('storage/'.$course->pdf_file) }}" download
                                                   class="btn btn-outline-secondary btn-sm mb-2">
                                                    <i class="fas fa-download mr-1"></i> Download
                                                </a>
                                            </div>

                                            <div class="mt-3">
                                                <div class="embed-responsive" style="height: 420px;">
                                                    <iframe class="embed-responsive-item"
                                                            src="{{ asset('storage/'.$course->pdf_file) }}"
                                                            style="width:100%;height:100%;border:1px solid #eee;border-radius:6px;"></iframe>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-muted">No PDF uploaded.</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
