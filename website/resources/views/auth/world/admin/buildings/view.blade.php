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
<div class="card text-dark bg-light mb-12">
    <div class="card-header"><a href="{{route('auth.world.admin.buildings.actions.view', ['world' => $world->id, 'building' => $building->id])}}">Building {{$building->name}} #{{$building->id}}</a></div>
    <div class="card-body">
      <p class="card-text">{{$building->description}}</p>
    </div>
</div>
@php
    $row = [];
    $id = 0;
    $id2 = 0;
@endphp
<table class="table">
    <thead>
        <th>Id</th>
        <th>Level</th>
        @foreach ($world->ressources as $ress)
            @if ($ress->type == 'node')
                @php
                    $row[$id] = $ress->id;
                    $id++;
                @endphp
                <th>{{$ress->name}}</th>
            @endif
        @endforeach
        <th>Duration</th>
        <th>Actions</th>
    </thead>
    <tbody>
        @foreach ($building->evolutions as $evolution)

            @php
                $id2 = 0;
            @endphp
            <tr>
                <td>{{$evolution->id}}</td>
                <td>{{$evolution->level}}</td>

                @foreach ($row as $key => $value)
                    @foreach ($evolution->costs as $cost)
                        @if ($key == $id2)
                            @if ($value == $cost->world_ressource_id)
                                @php
                                    $id2++;
                                @endphp
                                <td>{{$cost->amount}}</td>
                            @endif
                        @endif
                    @endforeach
                @endforeach
                <td>{{$evolution->duration}}</td>
                <td>
                    {{-- <a href="{{route('auth.world.admin.buildings.actions.view', ['world' => $world->id, 'building' => $building->id])}}">View</a> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
