

@if(!empty($subtasks))
    @foreach($subtasks  as $subtask)
        @if($subtask->subtask_status != 1  ||  $subtask->tested != 1 )
            <tr>
                <td>

                    @if($subtask->tested == 1 )
                        <label class="form-checkbox-label testing">
                            <input name="completed" class="form-checkbox-field tested" value="0" type="checkbox" data-id="{{$subtask->id}}"   checked   />
                            <i class="form-checkbox-button"></i>
                        </label>

                    @endif
                    @if($subtask->tested == 0 )
                        <label class="form-checkbox-label testing">
                            <input name="completed" class="form-checkbox-field tested" value="1" type="checkbox" data-id="{{$subtask->id}}"   />
                            <i class="form-checkbox-button"></i>
                        </label>
                    @endif


                </td>

                <td class="col-md-2">
                    <p> {!!$subtask->subtask_title!!} </p>
                </td>
                <td class="col-md-3">
                    <p data-id="{{$subtask->id}}">  @if(!empty($subtask->task->task_title))    {{$subtask->task->task_title }}     @else "No Task"  @endif </p>
                </td>

                <td class="col-md-1">
                    <div class="responsable">
                        @if(!empty($subtask->responsible))
                            @if(file_exists(public_path().'/assets/images/users/'.$subtask->responsible->image) && !empty($subtask->responsible->image))
                                <img src="{{asset('public/assets/images/users/'.$subtask->responsible->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->responsible->first_name}}</p>
                            @else
                                <img src="https://pri-po.com/public/assets/images/default.png" style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                <p class="addedby_id">{{$subtask->responsible->first_name}}</p>
                            @endif
                        @else
                            -------
                        @endif
                    </div>
                </td>

                <td class="col-md-1">
                    <div class="responsable">
                        @if(!empty($subtask->added_by))
                            @if(file_exists(public_path().'/assets/images/users/'.$subtask->added_by->image) && !empty($subtask->added_by->image))
                                <img src="{{asset('public/assets/images/users/'.$subtask->added_by->image)}}" style="height:25px;width:25px;border-radius:50%;" alt="member"> <p class="addedby_id">{{$subtask->added_by->first_name}}</p>
                            @else
                                <img src="https://pri-po.com/public/assets/images/default.png" style="height: 25px ; width: 25px; border-radius: 50% ; ">
                                <p class="addedby_id">{{$subtask->added_by->first_name}}</p>
                            @endif
                        @else
                            -------
                        @endif
                    </div>
                </td>


                <td class="col-md-1">
                    <p class="sub-date">
                    <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                    {{ date('d.m.Y', strtotime($subtask->created_at->addhours(2)))}}  </p>
                </td>
                <td class="col-md-1">
                    <p class="sub-date">
                    <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                    @if(!empty($subtask->subtask_completed_at)) {{ date('d.m.Y', strtotime($subtask->subtask_completed_at))}} @else -- @endif  </p>
                </td>

                <td class="col-md-1">
                    <p class="sub-date">
                    <p style="visibility: hidden ; height: 0 "> {{$subtask->created_at}}</p>
                    @if(!empty($subtask->subtask_due_date))
                        {{ date('d.m.Y', strtotime($subtask->subtask_due_date))}}
                    @endif
                    </p>
                </td>
                <td>
                    <p><i class="fa fa-list btn-task-popup" data-id="{{$subtask->task->id}}"></i></p>
                </td>
            </tr>
        @endif
    @endforeach
@else
    <tr>No tasks </tr>
@endif







