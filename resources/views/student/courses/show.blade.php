@php
  $isEnrolled = DB::table('course_user')
      ->where('user_id', auth()->id())
      ->where('course_id', $course->id)
      ->exists();
@endphp

<h3>{{ $course->title }}</h3>
<p>{{ $course->description }}</p>

@if(!$isEnrolled)
  <div class="alert alert-warning">
    Enroll karne ke baad hi video / PDFs access hongi.
  </div>

  <form method="POST" action="{{ route('student.courses.enroll', $course->id) }}">
    @csrf
    <button class="btn btn-primary">Enroll Now</button>
  </form>
@else
  {{-- ✅ content visible --}}
  <a class="btn btn-success" target="_blank" href="{{ $course->video_url }}">Watch Video</a>

  @if($course->pdf_url)
    <a class="btn btn-info" target="_blank" href="{{ $course->pdf_url }}">Download PDF</a>
  @endif
@endif
