@extends('../admin.layout')

@section('content')
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
                                    </small>
                                </div>
                            </div>

                            <div class="mt-3 mt-md-0 d-flex flex-wrap">
                                <a href="{{ route('trainer.courses.index') }}" class="btn btn-light mr-2 mb-2">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                                <a href="{{ route('trainer.courses.edit', $course->id) }}" class="btn btn-primary mr-2 mb-2">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        {{-- Left: Overview --}}
                        <div class="col-12 col-lg-7">
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
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <span class="badge badge-light p-2">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $course->duration_hours ?? '-' }}
                                                    </span>
                                                </div>
                                                <small class="text-muted">Estimated learning time</small>
                                            </div>
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
                        </div>

                        {{-- Right: Trainer + Content --}}
                        <div class="col-12 col-lg-5">

                            {{-- Trainer --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-chalkboard-teacher mr-1"></i> Trainer</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $trainerName = null;
                                        if (isset($trainerNameFromController)) {
                                            $trainerName = $trainerNameFromController;
                                        } elseif (isset($trainersMap) && $course->trainer_id) {
                                            $trainerName = $trainersMap[$course->trainer_id] ?? null;
                                        }
                                    @endphp

                                    @if($course->trainer_id && $trainerName)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar mr-3">
                                                <div class="avatar-initial rounded-circle bg-primary text-white"
                                                     style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
                                                    {{ strtoupper(substr($trainerName, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $trainerName }}</div>
                                                <small class="text-muted">Assigned Trainer</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-muted">
                                            No trainer assigned yet.
                                        </div>
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

                                            {{-- Optional simple preview (works for many youtube links, not all) --}}
                                            <div class="mt-3">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe class="embed-responsive-item"
                                                            src="{{ str_contains($course->video_url, 'youtube.com') || str_contains($course->video_url, 'youtu.be')
                                                                    ? 'https://www.youtube.com/embed/' . (str_contains($course->video_url, 'youtu.be') ? trim(parse_url($course->video_url, PHP_URL_PATH), '/') : (request()->fullUrl() && parse_str(parse_url($course->video_url, PHP_URL_QUERY) ?? '', $q) ? ($q['v'] ?? '') : ''))
                                                                    : $course->video_url }}"
                                                            allowfullscreen></iframe>
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    If preview doesn’t load, just use “Open Video”.
                                                </small>
                                            </div>
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

                                            {{-- Optional inline viewer --}}
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
