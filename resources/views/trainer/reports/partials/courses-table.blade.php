@forelse($reports as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $row->title }}</td>
    <td>{{ $row->quizzes }}</td>
    <td>{{ $row->students }}</td>
    <td>
        <span class="badge {{ $row->status ? 'badge-success' : 'badge-danger' }}">
            {{ $row->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4 text-muted">
        No courses found
    </td>
</tr>
@endforelse
