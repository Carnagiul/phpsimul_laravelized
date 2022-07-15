@extends('layouts.app_auth_world')

@section('title', 'World HomePage')

@section('page')

<div class="card text-dark bg-light mb-12">
    <div class="card-header">PHPSIMUL World {{$world->name}} - Connected</div>
    <div class="card-body">
      <h5 class="card-title">Welcome on World {{$world->name}}</h5>
      <p class="card-text">This is the description of the world : <br /> {{$world->description}}.
      </p>
    </div>
  </div>
@endsection
