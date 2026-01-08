@forelse($reports as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $row->name }}</td>
    <td>{{ $row->email }}</td>
    <td>{{ $row->courses }}</td>
    <td>{{ $row->attempts }}</td>
    <td>
        <span class="badge {{ $row->status ? 'badge-success' : 'badge-danger' }}">
            {{ $row->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-4 text-muted">
        No students found
    </td>
</tr>
@endforelse
