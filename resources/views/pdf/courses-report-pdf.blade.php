<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Courses Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h2>Courses Report</h2>

<p>
    <strong>Total:</strong> {{ $stats['total'] }} |
    <strong>Active:</strong> {{ $stats['active'] }} |
    <strong>Inactive:</strong> {{ $stats['inactive'] }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Course</th>
            <th>Trainer</th>
            <th>Quizzes</th>
            <th>Students</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->trainer }}</td>
                <td>{{ $row->quizzes }}</td>
                <td>{{ $row->students }}</td>
                <td>{{ $row->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
