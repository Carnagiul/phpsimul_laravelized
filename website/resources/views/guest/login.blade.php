@extends('layouts.app_guest')

@section('title', 'Login Page')

@section('page')

<div class="card text-dark bg-light mb-12">
    <div class="card-header">PHPSIMUL</div>
        <div class="card-body">
            <h5 class="card-title">Connect on project</h5>
            <p class="card-text">
                <form method="post" action="{{route('guest.login.post')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <center><button type="submit" class="btn btn-primary" style="margin-top: 30px;">Submit</button></center>
                </form>
            </p>
        </div>
    </div>
</div>
@endsection
