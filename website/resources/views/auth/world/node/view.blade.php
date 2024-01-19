@extends('layouts.app_auth_world')

@section('title', 'Village ' . $node->name)

@section('page')

<a href="{{route('auth.world.node.building.list', ['world' => $world->id, 'node' => $node->id])}}">Batiments</a>


@endsection


