@extends('layouts.app_auth_world_custom')

@section('title', 'Village ' . $node->name)

@section('page')

  @if ($node->buildingQueue->count() > 0)
<div class="card text-dark bg-light mb-12">
    <div class="card-header">Vos constructions en cours</div>
    <div class="card-body buildingQueue">
        <ul>
            @foreach ($node->buildingQueue as $queue)
                <li class="queue_{{$queue->id}}">
                    <span class="buildingName">{{$queue->building->name}}</span>
                    lvl:<span class="buildingLvl">{{$queue->level}}</span>
                    <span class="buildingRemaining" remaining="{{$queue->remaining}}">{{Carbon\Carbon::parse($queue->remaining)->format("H:i:s")}}</span>
                </li>
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
                    @include("auth.world.node.building.list_item", ['nodeBuilding' => $nodeBuilding])
                @endforeach
        </p>

    </div>
  </div>

  <script>
    // Fonction pour mettre à jour la div
        function updateQueue() {
            document.querySelectorAll(".buildingRemaining").forEach(function(item) {
                if (item.getAttribute('remaining') == 1 || item.getAttribute('remaining') == "1") {
                    item.parentNode.remove()
                }
            })

            // Faire une requête AJAX vers votre route Laravel
            fetch('{{ route("auth.world.node.nodeBuildQueue", ["world" => $world->id, "node" => $node->id]) }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la requête AJAX');
                    }

                    return response.json();
                })
                .then(data => {
                    var datas = data

                    for (const building of datas) {
                        document.querySelector(".queue_" + building.id + " .buildingRemaining").setAttribute('remaining', building.remaining)
                        document.querySelector(".queue_" + building.id + " .buildingRemaining").innerHTML = building.parseRemainingTime
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la requête AJAX', error);
                });
        }

        // Appeler la fonction updateQueue toutes les secondes (1000 millisecondes)
        setInterval(updateQueue, 1000);
    </script>
@endsection
