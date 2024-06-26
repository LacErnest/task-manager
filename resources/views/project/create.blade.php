  @extends('layouts.app')

  @section('content')
  <div class="card p-2">
    <form method="post" action="{{ url('project/store') }}">
        @csrf
        <div  class="form-group">
          <label for="name" class="form-label">{{__('project.title')}}</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
          @error('title')
          <p class="text-danger"> {{$message}} </p>
          @enderror
        </div>
        <div class="form-group">
            <label for="description">{{__('project.description')}}</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            @error('description')
             <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">{{__('global.save')}}</button>
      </form>
  </div>
    @endsection