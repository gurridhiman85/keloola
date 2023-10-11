<tr>
    <td>{{ $record->id }}</td>
    <td>{{ $record->title }}</td>
    <td>{{ $record->question }}</td>
    <td>{{ $record->answer }}</td>
    <td>{{ $record->description }}</td>
    <td class="text-center">
        <button class="btn btn-outline-info ajax-Link" data-href="{{ url('/knowledge_base/view/'.$record->id) }}">View</button>

        <button class="btn btn-outline-warning ajax-Link" data-href="{{ url('/knowledge_base/add/'.$record->id) }}">Edit</button>

        <button data-confirm="true" data-title="Are you sure want to delete this Knowledge Base ?"  class="btn btn-outline-danger ajax-Link" data-href="{{ url('/knowledge_base/delete/'.$record->id) }}">Delete</button>
    </td>

</tr>
