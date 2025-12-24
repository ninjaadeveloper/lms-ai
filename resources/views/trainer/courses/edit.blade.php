@extends('../admin.layout')

@section('content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('trainer.courses.update', $course->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-header">
                                <h4>Edit Course</h4>
                            </div>

                            <div class="card-body">

                                <!-- Title -->
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $course->title) }}" required>
                                    @if($errors->has('title'))
                                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="4">{{ old('description', $course->description) }}</textarea>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>
                                @if(auth()->user()->role === 'admin')
                                <!-- Trainer -->
                                <div class="form-group">
                                    <label>Trainer</label>
                                    <select name="trainer_id" class="form-control @error('trainer_id') is-invalid @enderror">
                                        <option value="">-- Select Trainer --</option>
                                        @foreach($trainers as $t)
                                            <option value="{{ $t->id }}"
                                                {{ old('trainer_id', $course->trainer_id) == $t->id ? 'selected' : '' }}>
                                                {{ $t->name }} ({{ $t->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('trainer_id'))
                                        <div class="invalid-feedback">{{ $errors->first('trainer_id') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>
                                @endif
                                <!-- Video URL -->
                                <div class="form-group">
                                    <label>Video URL</label>
                                    <input type="text" name="video_url"
                                        class="form-control @error('video_url') is-invalid @enderror"
                                        value="{{ old('video_url', $course->video_url) }}"
                                        placeholder="https://youtube.com/...">
                                    @if($errors->has('video_url'))
                                        <div class="invalid-feedback">{{ $errors->first('video_url') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- PDF File -->
                                <div class="form-group">
                                    <label>Course PDF (optional)</label>
                                    <input type="file" name="pdf_file"
                                        class="form-control @error('pdf_file') is-invalid @enderror"
                                        accept="application/pdf">

                                    @if($course->pdf_file)
                                        <small class="d-block mt-2">
                                            Current PDF:
                                            <a href="{{ asset('storage/'.$course->pdf_file) }}" target="_blank">View / Download</a>
                                        </small>
                                    @endif

                                    @if($errors->has('pdf_file'))
                                        <div class="invalid-feedback">{{ $errors->first('pdf_file') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Duration -->
                                <div class="form-group">
                                    <label>Duration (hours)</label>
                                    <input type="number" name="duration_hours"
                                        class="form-control @error('duration_hours') is-invalid @enderror"
                                        value="{{ old('duration_hours', $course->duration_hours) }}" min="1">
                                    @if($errors->has('duration_hours'))
                                        <div class="invalid-feedback">{{ $errors->first('duration_hours') }}</div>
                                    @else
                                        <div class="valid-feedback">Looks good!</div>
                                    @endif
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label>Status</label><br>
                                    <input type="checkbox" name="status" value="1"
                                        {{ old('status', $course->status) ? 'checked' : '' }}>
                                    Active
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
