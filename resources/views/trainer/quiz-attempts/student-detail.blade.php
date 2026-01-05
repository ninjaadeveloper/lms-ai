@extends('admin.layout')

@section('content')
<div class="main-content">
<section class="section">

  <div class="section-header">
    <h1>{{ $quiz->topic }} – {{ $attempt->student->name }}</h1>
  </div>

  {{-- SAME AS STUDENT RESULT CARD --}}
  @include('student.quizzes.result-detail', [
      'attempt' => $attempt,
      'quiz' => $quiz
  ])

</section>
</div>
@endsection
