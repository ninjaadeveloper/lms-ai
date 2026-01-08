@forelse($reports as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td><strong>{{ $row->title }}</strong></td>
    <td>{{ $row->trainer }}</td>
    <td>{{ $row->quizzes }}</td>
    <td>{{ $row->students }}</td>
    <td>
        <span class="badge badge-{{ $row->status ? 'success' : 'danger' }}">
            {{ $row->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted py-4">
        No courses found
    </td>
</tr>
@endforelse
