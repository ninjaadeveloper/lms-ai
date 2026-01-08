<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quiz Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        h2, h4 { margin: 0; }
    </style>
</head>
<body>

<h2>Quiz Performance Report</h2>
<p>
    <strong>Total Attempts:</strong> {{ $stats['attempts'] }} |
    <strong>Pass %:</strong> {{ $stats['pass_percent'] }}% |
    <strong>Fail %:</strong> {{ $stats['fail_percent'] }}%
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Quiz</th>
            <th>Course</th>
            <th>Attempts</th>
            <th>Avg Score</th>
            <th>Pass %</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->course }}</td>
                <td>{{ $row->attempts }}</td>
                <td>{{ $row->avg_score }}%</td>
                <td>{{ $row->pass_percent }}%</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;">No data found</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
