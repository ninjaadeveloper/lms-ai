<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Quiz Result</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .h { font-size: 18px; font-weight: bold; margin-bottom: 8px; }
    .muted { color: #666; }
    table { width:100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border:1px solid #ddd; padding:8px; vertical-align: top; }
    th { background:#f5f5f5; }
  </style>
</head>
<body>
  <div class="h">Quiz Result</div>
  <div class="muted">Course: <b>{{ $quiz->course->title ?? '-' }}</b></div>
  <div class="muted">Topic: <b>{{ $quiz->topic ?? '-' }}</b></div>
  <div class="muted">Score: <b>{{ $attempt->score_percent ?? 0 }}%</b></div>
  <div class="muted">Submitted: <b>{{ optional($attempt->submitted_at)->format('d M Y, h:i A') }}</b></div>

  <table>
    <thead>
      <tr>
        <th style="width:35px;">#</th>
        <th>Question</th>
        <th style="width:140px;">Selected</th>
        <th style="width:140px;">Correct</th>
      </tr>
    </thead>
    <tbody>
      @foreach($quiz->questions as $i => $q)
        @php
          $ans = $attempt->answers->firstWhere('question_id', $q->id);
        @endphp
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $q->question }}</td>
          <td>{{ $ans->selected_option ?? '-' }}</td>
          <td>{{ $q->correct_option }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
