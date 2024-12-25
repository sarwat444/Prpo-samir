<div class="form-group">
    <p>Kopieren<b>{{$subtask->subtask_title}}</b> :To</p>
    <form method="POST" action="{{route('subtask.clone',['id'=>$subtask->id])}}">
        @csrf
    <input type="hidden" value="{{$subtask->id}}">
    <select name="categories" id="categories_select" class="form-control">
        @forelse ($categories as $category)
            <option value="{{$category->id}}" {{$category->id ==$cat_id ?'selected': ''}}>{{$category->category_name}}</option>
        @empty
            There are no things
        @endforelse
    </select>
    <label for="exampleFormControlSelect1">Task</label>
    <select name="task" class="form-control copy_select" >
        @forelse ($tasks as $task)
            <option value="{{$task->id}}">{{$task->task_title}}</option>
        @empty
            There are no things
        @endforelse
    </select>


<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit"  class="btn btn-primary">Kopieren</button>
</div>
</form>
</div>

