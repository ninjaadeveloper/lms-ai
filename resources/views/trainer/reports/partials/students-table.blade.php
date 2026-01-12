@foreach($reports as $i=>$row)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $row->name }}</td>
<td>{{ $row->email }}</td>
<td>{{ $row->courses }}</td>
<td>
@if($row->status)
<span class="badge badge-success">Active</span>
@else
<span class="badge badge-danger">Inactive</span>
@endif
</td>
</tr>
@endforeach
