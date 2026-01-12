@forelse($reports as $i => $row)
<tr>
    <td>{{ $i + 1 }}</td>
    <td>{{ $row->title }}</td>
    <td>{{ $row->course }}</td>
    <td>{{ $row->attempts }}</td>
    <td>{{ $row->avg_score }}%</td>
    <td>
        <span class="badge badge-success">
            {{ $row->pass_percent }}%
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-4 text-muted">
        No quiz data found
    </td>
</tr>
@endforelse
