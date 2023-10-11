<tr>
    <td>{{ $record->id }}</td>
    <td>{{ $record->title }}</td>
    <td>{{ !empty($record->date)?date('Y-m-d',strtotime($record->date)) :'' }}</td>
    <td>{{ $record->description }}</td>
    <td class="text-center">
        @if(isset($record->attachment))
            @foreach($record->attachment as $attachment)
                @if($attachment['file_type'] == 'image')
                    <img src="{{ $attachment['is_thumbnail'] == 1 ? url('/uploads/news_videos/thumb/'.$attachment['attachment_url']) : '' }}"/>
                @endif
            @endforeach
        @endif
    </td>
    <td class="text-center">
        @if(isset($record->attachment))
            @foreach($record->attachment as $attachment)
                @if($attachment['file_type'] == 'video')
                    <embed type="video/webm" src="{{ !empty($attachment['attachment_url']) ? url('/uploads/news_videos/videos/'.$attachment['attachment_url']) : '' }}">
                @endif
            @endforeach
        @endif
    </td>
    <td class="text-center">
        <button class="btn btn-outline-info ajax-Link" data-href="{{ url('/news_videos/view/'.$record->id) }}">View</button>

        <button class="btn btn-outline-warning ajax-Link" data-href="{{ url('/news_videos/add/'.$record->id) }}">Edit</button>

        <button data-confirm="true" data-title="Are you sure want to delete this news & video ?"  class="btn btn-outline-danger ajax-Link" data-href="{{ url('/news_videos/delete/'.$record->id) }}">Delete</button>
    </td>

</tr>
