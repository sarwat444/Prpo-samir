<table  class="table  table-bordered filtered_table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>{{__('messages.hide')}}</th>
        <th>{{__('messages.comments')}}</th>
        <th>{{__('messages.created_by')}}</th>
        <th>{{__('messages.created_at')}}</th>
        <th>{{__('messages.details')}} </th>
    </tr>
    </thead>
    <tbody  class="tasks user_subtasks commentslist">

    @foreach($notes as $note)

    <tr>
        <td class="col-md-1">
            <label class="form-checkbox-label">
                <input name="completed" class="form-checkbox-field show_read_comments" value="0" type="checkbox"  checked />
                <i class="form-checkbox-button"></i>
            </label>
        </td>

        <td class="col-md-3">
            <p> {!!$note->comment!!} </p>
        </td>

        <td class="col-md-1">
            @if(!empty($note->comment_added_by))
                @if(file_exists(public_path().'/assets/images/users/'.$note->added_by->image))
                    <img src="{{asset('public/assets/images/users/'.$note->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" class="addedbyimg"  alt="member">
                @else
                    <img src="https://source.unsplash.com/user/c_v_r" style="width:40px;height:40px;border-radius:50%;">
                @endif
            @endif
        </td>

        <td class="col-md-1">
            <p class="sub-date" style="height: 0">
                {{ date('d.m.Y', strtotime($note->created_at->addhours(2)))}}
            </p>
        </td>

        <td class="col-md-1">
            <i class="fa fa-list btn-task-popup" data-id="{{$note->task_id}}"></i>
        </td>


    </tr>


    @endforeach

    </tbody>
</table>





