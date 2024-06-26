@props(['project'])

@extends('layouts.app')


<div class="card w-50 mx-auto m-4">

    <div class="card-header">
        {{__('task.tasks')}} for ( {{$project->title}} )
    </div>
    <div class="d-flex flex-row-reverse">
       <a href=" {{ url('project/'.$project->id.'/task/create') }}" class="btn btn-primary w-25 mt-2 mr-2">{{__('task.create_task')}}</a>
       <button onclick="location.reload();" class="btn btn-secondary w-25 mt-2 mr-2">{{__('global.refresh')}}</button>
    </div>

    <div class="card-body">
    @if (count($project->tasks) > 0)
        <ul class="list-group  connectedSortable" id="tasks-drop">
            @foreach ($project->tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center" item-id="{{$task->id}}">
                <div class="d-flex">
                    <h5 class="text-break mr-2">{{$task->name}}</h3>
                <div> {!!$task->getPriorityStr()!!} </div>
                </div>
                <div class="actions d-flex justify-content-center"> 
                        <form method="POST" action="{{ url('/project/task/'.$task->id.'/delete') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"><i class='fas fa-trash'></i></button>
                        </form>
                        <a class="ml-2" href="{{ url('/project/'.$project->id.'/task/'.$task->id.'/edit') }}" > <i class='fas fa-edit'></i> </a>
                </div>
            </li>
            @endforeach   
        </ul>
    @else
        <p>There are no tasks yet</p>
    @endif
    
</div>
</div>

