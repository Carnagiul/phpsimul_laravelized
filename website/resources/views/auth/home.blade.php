@extends('layouts.app_auth')

@section('title', 'Home Page')

@section('page')

<div class="card text-dark bg-light mb-12">
    <div class="card-header">PHPSIMUL - Connected</div>
    <div class="card-body">
      <h5 class="card-title">Welcome on project</h5>
      <p class="card-text">This is the description of the project.
        @include('auth.partials.worlds')
      </p>
    </div>
  </div>
@endsection
