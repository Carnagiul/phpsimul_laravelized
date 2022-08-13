@extends('layouts.app_auth_world')

@if (isset($ressource))
    @section('title', 'Admin Ressource Edit')
@else
    @section('title', 'Adming Ressource Create')
@endif

@section('page')

@if (isset($ressource))
    <form action="{{route(Route::currentRouteName() . '.post', ['world' => $world->id, 'ressource' => $ressource->id])}}" method="POST">
@else
<form action="{{route(Route::currentRouteName() . '.post', $world->id)}}" method="POST">
@endif
@csrf

<div class="form-group">
    <label for="name">Name of building</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" @if (isset($ressource)) value="{{$ressource->name}}" @endif>
</div>

<div class="form-group">
    <label for="name">Description of building</label>
    <textarea class="form-control" id="description" name="description" placeholder="Enter Description" >@if (isset($ressource)){{$ressource->description}}@endif</textarea>
</div>
<center><button type="submit" class="btn btn-primary">Submit</button></center>
</form>
@endsection
