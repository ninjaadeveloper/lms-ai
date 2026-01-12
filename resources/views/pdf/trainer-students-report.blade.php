<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>My Students Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>My Students Report</h2>

    {{-- TOP STATS --}}
    <table width="100%" style="margin-bottom:20px;">
        <tr>
            <td><b>Total:</b> {{ $stats['total'] }}</td>
            <td><b>Active:</b> {{ $stats['active'] }}</td>
            <td><b>Inactive:</b> {{ $stats['inactive'] }}</td>
        </tr>
    </table>

    {{-- STUDENTS TABLE --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Email</th>
                <th>Courses</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reports as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->email }}</td>
                    <td class="text-center">{{ $s->courses }}</td>
                    <td>{{ $s->status ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>