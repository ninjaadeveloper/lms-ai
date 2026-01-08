@forelse($reports as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td><strong>{{ $row->name }}</strong></td>
    <td>{{ $row->email }}</td>
    <td>{{ $row->courses }}</td>
    <td>{{ $row->quizzes }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted py-4">
        No trainers found
    </td>
</tr>
@endforelse
