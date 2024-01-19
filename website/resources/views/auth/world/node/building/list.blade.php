@extends('layouts.app_auth_world')

@section('title', 'Village ' . $node->name)

@section('page')

  @if ($node->buildingQueue->count() > 0)
<div class="card text-dark bg-light mb-12">
    <div class="card-header">Vos constructions en cours</div>
    <div class="card-body">
        <ul>
            @foreach ($node->buildingQueue as $queue)
                <li>{{$queue->building->name}} lvl: {{$queue->level}} Remaining: <span class="remaining" remaining="{{$queue->remaining}}">{{Carbon\Carbon::parse($queue->remaining)->format("H:i:s")}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<div class="card text-dark bg-light mb-12">
    <div class="card-header">Vos batiments</div>
    <div class="card-body">
      <h5 class="card-title">Ameliorer un batiment</h5>
        <p class="card-text">

                @foreach ($node->buildings as $nodeBuilding)
                    @foreach ($buildings as $building)
                        @if ($building->id == $nodeBuilding->world_building_id)
                            [{{$building->name}} {{$nodeBuilding->level}}]
                            @php
                                $level = $nodeBuilding->level;
                                $level += $node->buildingQueue()->where('world_building_id', $building->id)->get()->count();
                                $details =  App\Models\WorldBuildingEvolution::where('world_building_id', $nodeBuilding->world_building_id)->whereIn('level', [$level, $level + 1])->get();
                                $actual =  $details->first();
                                $next =  $details->last();
                                $upgradeAvaible = true;
                                $canEvolve = true;
                                if ($next->id == $actual->id)
                                    $upgradeAvaible = false;
                            @endphp
                            @if ($upgradeAvaible)
                                [{{Carbon\Carbon::parse($next->duration)->format("H:i:s")}}]
                                @foreach ($next->costs as $cost)
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
                                    <a href="{{route('auth.world.node.building.actions.evolve', ['building' => $building->id, 'world' => $world->id, 'node' => $node->id])}}">UPGRADE TO {{$next->level}}</a>

                                @endif
                            @else
                                Plus aucune amelioration possible
                            @endif


                            <br />

                        @break
                        @endif
                    @endforeach
                @endforeach
        </p>

    </div>
  </div>


@endsection


