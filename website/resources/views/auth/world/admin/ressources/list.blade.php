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

<a href="{{route('auth.world.admin.ressources.create', $world->id)}}" class="btn btn-primary btn-block">Create a new ressource</a>
@foreach ($world->ressources as $ressource)
<div class="card text-dark bg-light mb-12">
    <div class="card-header"><a href="{{route('auth.world.admin.ressources.actions.view', ['world' => $world->id, 'ressource' => $ressource->id])}}">Ressource {{$ressource->name}} #{{$ressource->id}}</a></div>
    <div class="card-body">
      <p class="card-text">{{$ressource->description}}</p>
    </div>
</div>
@endforeach

@endsection
