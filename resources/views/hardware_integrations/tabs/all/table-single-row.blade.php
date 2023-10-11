<tr>
    <td>{{ $record->id }}</td>
    <td>{{ $record->title }}</td>
    <td>{{ $record->description }}</td>
    <td>{{ $record->url }}</td>
    <td class="text-center">
        @if(isset($record->attachment))
            <img src="{{ $record->attachment->is_thumbnail == 1 ? url('/uploads/hardware_integrations/thumb/'.$record->attachment->attachment_url) : '' }}"/>
        @endif
    </td>
    <td class="text-center">
        <button class="btn btn-outline-info ajax-Link" data-href="{{ url('/hardware_integrations/view/'.$record->id) }}">View</button>

        <button class="btn btn-outline-warning ajax-Link" data-href="{{ url('/hardware_integrations/add/'.$record->id) }}">Edit</button>

        <button data-confirm="true" data-title="Are you sure want to delete this hardware integration ?"  class="btn btn-outline-danger ajax-Link" data-href="{{ url('/hardware_integrations/delete/'.$record->id) }}">Delete</button>
    </td>

</tr>
