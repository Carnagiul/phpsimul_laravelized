<div class="card text-dark bg-light mb-12">
    <div class="card-header">Bienvenue {{$worldUser->user->name ?? "Inconnu"}} </div>
    <div class="card-body">
      <h5 class="card-title">Tu possedes {{ $worldUser->nodes->count() }} villages!</h5>
        <p class="card-text">
            @foreach ($worldUser->nodes as $node)
                {{$node->name}} {{$node->x}}|{{$node->y}} {{$node->updated_at->toDateString()}}
            @endforeach
        </p>

    </div>
  </div>
