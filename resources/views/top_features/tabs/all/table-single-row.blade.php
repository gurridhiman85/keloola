<tr>
    <td>{{ $record->id }}</td>
    <td>{{ $record->text }}</td>
    <td class="text-center">
        @if(isset($record->attachment))
            <img src="{{ $record->attachment->is_thumbnail == 1 ? url('/uploads/top_features/thumb/'.$record->attachment->attachment_url) : '' }}"/>
        @endif
    </td>
    <td class="text-center">
        <button class="btn btn-outline-info ajax-Link" data-href="{{ url('/top_features/view/'.$record->id) }}">View</button>

        <button class="btn btn-outline-warning ajax-Link" data-href="{{ url('/top_features/add/'.$record->id) }}">Edit</button>

        <button data-confirm="true" data-title="Are you sure want to delete this feature ?"  class="btn btn-outline-danger ajax-Link" data-href="{{ url('/top_features/delete/'.$record->id) }}">Delete</button>
    </td>

</tr>
