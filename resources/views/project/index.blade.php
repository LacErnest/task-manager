@extends('layouts.app')

@section('content')
@php
$selectedProjectId = isset($selectedProjectId) ? $selectedProjectId : 0;
@endphp

<div id="project-info-div">

    <div class="card w-50 mx-auto m-4">
      <div class="card-header d-flex justify-content-between">
          <h5>{{__('project.projects')}}</h5>
          <div >
            <a href=" {{ url('project/index') }}" class="btn btn-primary m-1">{{__('project.all_projects')}}</a>
            <a href=" {{ url('project/create') }}" class="btn btn-primary m-1">{{__('project.create_project')}}</a>
          </div>
      </div>

      <select class="target">
        <option value="" disabled selected>{{__('project.select_project_placeholder')}}</option>
        @foreach ($projects as $project)
            @if(($selectedProjectId > 0) && ($selectedProjectId == $project->id))
              <option value="{{$project->id}}" selected="selected">{{$project->title}}</option>
            @else
              <option value="{{$project->id}}">{{$project->title}}</option>
            @endif
        @endforeach
      </select>

    </div>

    <div class="project-section">
       <div class="project-body"></div>
    </div>
    
  </div>


  <script type="text/javascript">
    $( function() {

      var selectedProjectId = {{$selectedProjectId}};
      if(selectedProjectId > 0){
          $.ajax({
              url: "{{ url('project/list-project-tasks') }}",
              method: 'GET',
              data: {selectedProjectId: selectedProjectId},
              success: function(data) {
                $('.project-body').html(data);
              }
          });
      }

      $( "select" ).change(function() {
            selectedProjectId  = $('option:selected', this).val();
            $.ajax({
            url: "{{ url('project/list-project-tasks') }}",
            method: 'GET',
            data: {selectedProjectId: selectedProjectId},
            success: function(data) {
              $('.project-body').html(data);
            }
            });
        }) 

    });
  </script>
  @endsection