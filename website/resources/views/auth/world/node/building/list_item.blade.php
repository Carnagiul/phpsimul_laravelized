@php
    $building = $nodeBuilding->building;
    $level = $nodeBuilding->level;
    $level += $node->buildingQueue()->where('world_building_id', $building->id)->get()->count();
    $details =  App\Models\WorldBuildingEvolution::where('world_building_id', $nodeBuilding->world_building_id)->whereIn('level', [$level, $level + 1])->get();
    $actual =  $details->first();
    $next =  $details->last();
    $upgradeAvaible = true;
    $canEvolve = true;
    $requirementAvaible = true;
    $requirementList = "";
    $ressourcesAvaibles = true;
    if ($next->id == $actual->id)
        $upgradeAvaible = false;
    if ($building->buildingRequirements->count() > 0) {
        foreach ($building->buildingRequirements as $requirement) {
            if ($node->buildings->where('world_building_id', $requirement->required_world_building_id)->first()->level < $requirement->level)
            {
                $requirementAvaible = false;
                $requirementList .= "[" . $requirement->requiredWorldBuilding->name . " " . $requirement->level . "] ";
            }
        }
    }
@endphp
<div class="building" data-id="{{$building->id}}" data-next="{{route('auth.world.node.building.actions.evolve', ['building' => $building->id, 'world' => $world->id, 'node' => $node->id])}}" data-href="building_{{$building->id}}">

[{{$building->name}} {{$nodeBuilding->level}}]
@if ($upgradeAvaible && $requirementAvaible)
    [{{Carbon\Carbon::parse($next->duration)->format("H:i:s")}}]
    @foreach ($next->costs as $cost)
        @foreach ($ressources as $resource)
            @if ($resource->id == $cost->world_ressource_id)

                @php
                    $ress = $node->ressources->where('world_ressource_id', $cost->world_ressource_id)->first();
                    if ($ress->amount < $cost->amount)
                    {
                        $canEvolve = false;
                        $ressourcesAvaibles = false;
                    }
                @endphp

                [{{$resource->name}}
                <span class="building_ress_{{$cost->world_ressource_id}}" data-amount="{{$cost->amount}}">{{$cost->amount}}</span>]
            @break
            @endif
        @endforeach
    @endforeach
    <span class="building_{{$building->id}}">
    @if ($canEvolve)
        <a class="btn btn-primary btn-rounded" href="{{route('auth.world.node.building.actions.evolve', ['building' => $building->id, 'world' => $world->id, 'node' => $node->id])}}">UPGRADE TO <span class="badge badge-primary">{{$next->level}}</span></a>
    @endif
    @if ($ressourcesAvaibles == false)
        <span class="text-warning">Vous ne possedez pas assez de ressources</span>
    @endif
    </span>

@else
    @if ($upgradeAvaible == false)
        Plus aucune amelioration possible
    @else
        {{$requirementList}}
    @endif
@endif
</div>
<br />
