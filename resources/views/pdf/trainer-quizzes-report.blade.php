<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>

    <h2>My Quizzes Report</h2>

    <table style="margin-bottom:20px">
        <tr>
            <td><b>Total Attempts:</b> {{ $stats['attempts'] }}</td>
            <td><b>Pass %:</b> {{ $stats['pass_percent'] }}%</td>
            <td><b>Fail %:</b> {{ $stats['fail_percent'] }}%</td>
        </tr>
    </table>

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
            @foreach($reports as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->title }}</td>
                    <td>{{ $r->course }}</td>
                    <td>{{ $r->attempts }}</td>
                    <td>{{ $r->avg_score }}%</td>
                    <td>{{ $r->pass_percent }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>