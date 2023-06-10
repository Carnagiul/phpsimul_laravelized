<div class="card text-dark bg-light mb-12">
    <div class="card-header">Bienvenue {{$worldUser->user->name ?? "Inconnu"}} </div>
    <div class="card-body">
      <h5 class="card-title">Tu possedes {{ $worldUser->nodes->count() }} villages!</h5>
        <p class="card-text">
            @foreach ($nodes as $node)
                @foreach ($ressources as $ressource)
                    @foreach ($node->ressources as $ress)
                        @if ($ress->world_ressource_id == $ressource->id)
                            {{$ressource->name}} {{$ress->amount}}<br />
                        @break
                        @endif
                    @endforeach
                @endforeach
                {{$node->name}} {{$node->x}}|{{$node->y}} {{$node->updated_at->toDateString()}}<br />
                @foreach ($node->buildings as $nodeBuilding)
                    @foreach ($buildings as $building)
                        @if ($building->id == $nodeBuilding->world_building_id)
                            {{$building->name}} {{$nodeBuilding->level}}
                            @foreach ($building->evolutions as $evolution)
                                @if ($evolution->level == $nodeBuilding->level + 1)
                                > {{$evolution->level}} [{{Carbon\Carbon::parse($evolution->duration)->format("H:i:s")}}]
                                    @foreach ($evolution->costs as $cost)

                                        @foreach ($ressources as $resource)
                                            @if ($resource->id == $cost->world_ressource_id)
                                                [{{$resource->name}} {{$cost->amount}}]&nbsp;
                                            @break
                                            @endif
                                        @endforeach
                                    @endforeach
                                @break
                                @endif
                            @endforeach

                            <br />

                        @break
                        @endif
                    @endforeach
                    {{-- {{$nodeBuilding->building->name}} {{$nodeBuilding->level}}<br /> --}}
                @endforeach
            @endforeach
        </p>

    </div>
  </div>
