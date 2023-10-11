
<table id="basic_table2" class="table">
    <thead>
        <th>Column</th>
        <th>Value</th>
        <th></th>
    </thead>
    <tbody>
        @foreach($record as $column => $value)
            @if(strtolower($column) == 'id')
                @continue
            @else
                <tr>
                    <td>{{ ucfirst($column) }}</td>
                    @if($column == 'attachment' && !empty($record['attachment']))
                        <td class="2">
                            @foreach($record['attachment'] as $attachment)
                                @if($attachment['file_type'] == 'image')
                                    <img src="{{ $attachment['is_thumbnail'] == 1 ? url('/uploads/news_videos/thumb/'.$attachment['attachment_url']) : '' }}"  class="preview" style="width: 100px !important; height: 100px !important;"/>
                                @endif
                            @endforeach
                        </td>
                        <td class="2">
                            @foreach($record['attachment'] as $attachment)
                                @if($attachment['file_type'] == 'video')
                                    <embed type="video/webm" src="{{ !empty($attachment['attachment_url']) ? url('/uploads/news_videos/videos/'.$attachment['attachment_url']) : '' }}">
                                @endif
                            @endforeach
                        </td>
                    @elseif(is_string($column) && strtolower($column) == 'date')
                        <td colspan="2">
                            {{ !empty($value) ? date('Y-m-d',strtotime($value)) : '' }}
                        </td>
                    @else
                        <td colspan="2">
                            {{ (!empty($value) ? $value : '') }}
                        </td>
                    @endif
                </tr>
            @endif

        @endforeach
    </tbody>
</table>
