@extends('layouts.app_auth_world')

@section('title', 'Admin World HomePage')

@section('page')

<div class="card text-dark bg-light mb-12">
    <div class="card-header">PHPSIMUL World {{$world->name}} - Admin Connected</div>
    <div class="card-body">
      <h5 class="card-title">Welcome on Administration of world {{$world->name}}</h5>
      <p class="card-text">This is the description of the world : <br /> {{$world->description}}.
      </p>
    </div>
</div>
<a href="{{route('auth.world.admin.buildings.create', $world->id)}}" class="btn btn-primary btn-block">Create a new building</a>
@foreach ($world->buildings as $building)
<div class="card text-dark bg-light mb-12">
    <div class="card-header">Building {{$building->name}} #{{$building->id}}</div>
    <div class="card-body">
      <p class="card-text">{{$building->description}}</p>
    </div>
</div>
@endforeach

@endsection
