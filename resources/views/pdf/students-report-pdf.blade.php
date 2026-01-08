<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th,td { border:1px solid #000; padding:6px; }
        th { background:#eee; }
    </style>
</head>
<body>

<h3>Students Report</h3>

<table>
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Courses</th>
    <th>Attempts</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@foreach($reports as $i => $row)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $row->name }}</td>
    <td>{{ $row->email }}</td>
    <td>{{ $row->courses }}</td>
    <td>{{ $row->attempts }}</td>
    <td>{{ $row->status ? 'Active' : 'Inactive' }}</td>
</tr>
@endforeach
</tbody>
</table>

</body>
</html>
