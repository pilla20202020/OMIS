<tr>
    <td>{{++$key}}</td>
    <td>{{ Str::limit($campaign->name, 47) }}</td>
    <td>
        <img src="{{asset($campaign->thumbnail_path)}}" class="img-circle width-1" alt="{{$campaign->name}}" width="50" height="50">
    </td>
    <td>{{ Str::limit($campaign->details, 47) }}</td>
    <td>{{ Str::limit($campaign->starts, 47) }}</td>
    <td>{{ Str::limit($campaign->ends, 47) }}</td>

    <td>
        <a href="{{route('lms.campaign.edit', $campaign->id)}}">
            <button type="button" class="btn btn-icon-toggle btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="fas fa-edit"></i></button>
        </a>
        {{-- <a href="#">
            <button type="button" class="btn btn-icon-toggle" onclick="deleteThis(this); return false;" link="{{ route('lms.campaign.delete', $campaign->id) }}">
                <i class="far fa-trash-alt"></i>
            </button>
        </a> --}}
    </td>
</tr>


