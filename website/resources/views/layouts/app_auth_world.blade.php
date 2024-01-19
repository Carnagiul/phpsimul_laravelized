<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@section('title')@show</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        @section('css')
        @show
    </head>
    <body>
        @if (session('popup-success'))
            <div class="alert alert-success">
                {{ session('popup-success') }}
            </div>
        @endif
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{route('auth.home')}}">PHPSIMUL</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link  @if (Route::is('auth.home')) active @endif" @if (Route::is('auth.home')) aria-current="page" @endif href="{{route('auth.home')}}">PHPSIMUL</a>
                    </li>
                    @if (Auth::user()->isAdmin())
                    <li class="nav-item">
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger">Administration</button>
                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                              <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('auth.world.admin.home', $world->id)}}">Home</a></li>
                                <li><a class="dropdown-item" href="{{route('auth.world.admin.buildings.list', $world->id)}}">Buildings</a></li>
                              <li><a class="dropdown-item" href="#">Units</a></li>
                              <li><a class="dropdown-item" href="#">Research</a></li>
                              <li><a class="dropdown-item" href="{{route('auth.world.admin.ressources.list', $world->id)}}">Ressources</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="#">Users</a></li>
                              <li><a class="dropdown-item" href="#">Alliances</a></li>
                              <li><a class="dropdown-item" href="#">Nodes</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="#">Options</a></li>
                            </ul>
                          </div>
                      </li>
                    @endif
                </ul>
              </div>
            </div>
          </nav>
          @if (!Route::is('auth.world.admin.*'))
          <div class="card text-dark bg-light mb-12">
            <div class="card-header">Village {{$node->name}} {{$node->x . "|" . $node->y}}  [{{$node->updated_at}}]</div>
            <div class="card-body">
              <h5 class="card-title">Vos ressources sur ce village</h5>
              <p class="card-text">

                @foreach ($ressources as $ressource)

                    @foreach ($node->ressources as $ress)
                        @if ($ress->world_ressource_id == $ressource->id && $ressource->type == "node")
                        <span class="ressource prodress_{{$ress->world_ressource_id}}" data-id="{{$ress->world_ressource_id}}">
                            <span class="ressource_name">{{$ressource->name}}</span> <span class="ressource_amount ress_{{$ress->world_ressource_id}}">{{$ress->amount}}</span> &nbsp;
                        </span>
                        @break
                        @endif
                    @endforeach
                @endforeach
              </p>
            </div>
          </div>
        @endif
        @section('page')
        @show
    </body>
    <footer>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        @if (!Route::is('auth.world.admin.*'))
        <script>
            // Fonction pour mettre à jour la div
            function updateDiv() {
                // Faire une requête AJAX vers votre route Laravel
                fetch('{{ route("auth.world.node.nodeRess", ["world" => $world->id, "node" => $node->id]) }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la requête AJAX');
                        }

                        return response.json();
                    })
                    .then(data => {
                        var datas = data
                        for (const ress of datas) {
                            document.querySelector(".ress_" + ress.world_ressource_id).innerHTML = ress.amount;
                            if (ress.prod != undefined && ress.prod != null) {
                                document.querySelector(".prodress_" + ress.world_ressource_id).setAttribute('title', ress.prod + "/H")
                                document.querySelector(".prodress_" + ress.world_ressource_id).setAttribute('alt', ress.prod + "/H")

                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la requête AJAX', error);
                    });
            }

            // Appeler la fonction updateDiv toutes les secondes (1000 millisecondes)
            setInterval(updateDiv, 1000);
        </script>
        @endif

        @section('scripts')
        @show
    </footer>
</html>
