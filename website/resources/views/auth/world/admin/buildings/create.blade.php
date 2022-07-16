@extends('layouts.app_auth_world')

@if (isset($building))
    @section('title', 'Admin Building Edit')
@else
    @section('title', 'Adming Building Create')
@endif

@section('page')

<form action="{{route(Route::currentRouteName() . '.post', $world->id)}}" method="POST">
@csrf

<div class="form-group">
    <label for="name">Name of building</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" @if (isset($building)) value="{{$building->name}}" @endif>
</div>
<div class="form-group">
    <label for="max_level">Max Level</label>
    <input type="number" step="1" min="0" class="form-control" id="max_level" name="max_level" placeholder="Enter max Level" @if (isset($building)) value="{{$building->max_level}}" @endif>
</div>
<div class="form-group">
    <label for="min_level">Min Level</label>
    <input type="number" step="1" min="0" class="form-control" id="min_level" name="min_level" placeholder="Enter min level" @if (isset($building)) value="{{$building->min_level}}" @endif>
</div>
<div class="form-group">
    <label for="default_level">Default Level</label>
    <input type="number" step="1" min="0" class="form-control" id="default_level" name="default_level" placeholder="Enter default Level" @if (isset($building)) value="{{$building->default_level}}" @endif>
</div>

<div class="form-group">
    <label for="name">Description of building</label>
    <textarea class="form-control" id="description" name="description" placeholder="Enter Description" >@if (isset($building)){{$building->description}}@endif</textarea>
</div>
<center><button type="submit" class="btn btn-primary">Submit</button></center>
</form>
@endsection
