@extends('layouts.app_auth_world')

@section('title', 'Village ' . $node->name)

@section('page')

<div class="card text-dark bg-light mb-12">
    <div class="card-header">Village {{$node->name}} {{$node->x . "|" . $node->y}}  [{{$node->updated_at}}]</div>
    <div class="card-body">
      <h5 class="card-title">Vos ressources sur ce village</h5>
      <p class="card-text">
        @foreach ($ressources as $ressource)
            @foreach ($node->ressources as $ress)
                @if ($ress->world_ressource_id == $ressource->id && $ressource->type == "node")
                    {{$ressource->name}} {{$ress->amount}} &nbsp;
                @break
                @endif
            @endforeach
        @endforeach
      </p>
    </div>
  </div>

<div class="card text-dark bg-light mb-12">
    <div class="card-header">Vos batiments</div>
    <div class="card-body">
      <h5 class="card-title">Ameliorer un batiment</h5>
        <p class="card-text">

                @foreach ($node->buildings as $nodeBuilding)
                    @foreach ($buildings as $building)
                        @if ($building->id == $nodeBuilding->world_building_id)
                            [{{$building->name}} {{$nodeBuilding->level}}]
                            @foreach ($building->evolutions as $evolution)
                                @if ($evolution->level == $nodeBuilding->level + 1)
                                @php
                                    $canEvolve = true;
                                @endphp
                                [{{Carbon\Carbon::parse($evolution->duration)->format("H:i:s")}}]
                                    @foreach ($evolution->costs as $cost)
                                        @foreach ($ressources as $resource)
                                            @php
                                                if ($node->ressources->where('world_ressource_id', $cost->world_ressource_id)->first()->amount < $cost->amount)
                                                    $canEvolve = false;
                                            @endphp
                                            @if ($resource->id == $cost->world_ressource_id)
                                                [{{$resource->name}} {{$cost->amount}}]&nbsp;
                                            @break
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if ($canEvolve)
                                        UPGRADE to {{$evolution->level}}
                                        {{-- <a href="{{route('world.user.node.building.evolve', ['world' => $world->id, 'user' => $worldUser->id, 'node' => $node->id, 'building' => $nodeBuilding->id])}}">Evolve</a> --}}
                                    @endif
                                @break
                                @endif
                            @endforeach

                            <br />

                        @break
                        @endif
                    @endforeach
                @endforeach
        </p>

    </div>
  </div>


@endsection


