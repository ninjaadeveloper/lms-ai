<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trainers Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .stats { margin-bottom: 15px; }
        .stats div { display: inline-block; margin-right: 20px; }
    </style>
</head>
<body>

<h2>Trainers Report</h2>

<div class="stats">
    <div><strong>Total:</strong> {{ $stats['total'] }}</div>
    <div><strong>Active:</strong> {{ $stats['active'] }}</div>
    <div><strong>Inactive:</strong> {{ $stats['inactive'] }}</div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Trainer</th>
            <th>Email</th>
            <th>Total Courses</th>
            <th>Total Quizzes</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->courses }}</td>
                <td>{{ $row->quizzes }}</td>
                <td>{{ $row->status ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
