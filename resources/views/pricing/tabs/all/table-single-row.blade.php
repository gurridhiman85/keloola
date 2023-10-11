<tr>
    <td>{{ $record->id }}</td>
    <td>{{ $record->detailed_title }}</td>
    <td>{{ $record->description }}</td>
    <td class="text-center">
        <button class="btn btn-outline-info ajax-Link" data-href="{{ url('/pricing/view/'.$record->id) }}">View</button>

        <button class="btn btn-outline-warning ajax-Link" data-href="{{ url('/pricing/add/'.$record->id) }}">Edit</button>

        <button data-confirm="true" data-title="Are you sure want to delete this pricing ?"  class="btn btn-outline-danger ajax-Link" data-href="{{ url('/pricing/delete/'.$record->id) }}">Delete</button>
    </td>

</tr>
