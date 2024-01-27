<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>@yield('title')</title>

	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<link href="/css/animate.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">

	<link href="/css/plugins/switchery/switchery.css" rel="stylesheet">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/css/plugins/bootstrap-select/bootstrap-select.min.css">

	@yield('css')
</head>

<body>
	<div id="wrapper">
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element">
							{{-- @if ($user->player_id != null) --}}
							{{-- <img alt="image" class="rounded-circle" src="https://crafatar.com/renders/head/{{$user->player->uuid}}"> --}}
							{{-- @endif --}}
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="block m-t-xs font-bold">{{Auth::user()->name}}</span>
								<span class="text-muted text-xs block">{{Auth::user()->email}} <b class="caret"></b></span>
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li>
									<a class="dropdown-item" href="#">Logout</a>
								</li>
							</ul>
						</div>
						<div class="logo-element">
							ZG
						</div>
					</li>
					<li>
						<a href="{{route('auth.world.node.building.list', ['world' => $world->id, 'node' => $node->id])}}"><i class="fa fa-building"></i> <span class="nav-label">Buildings</span></a>
					</li>
					<li>
						<a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">My Player</span></a>
					</li>

				</ul>

			</div>
		</nav>

		<div id="page-wrapper" class="gray-bg">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
            </nav>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>{{$node->name}}</h2>
                    <ol class="breadcrumb">
                        @foreach ($ressources as $ressource)
                            @foreach ($node->ressources as $ress)
                                @if ($ress->world_ressource_id == $ressource->id && $ressource->type == "node")
                                <li class="breadcrumb-item ressource prodress_{{$ress->world_ressource_id}}" data-id="{{$ress->world_ressource_id}}">
                                    <span class="ressource_name">{{$ressource->name}}</span> <span class="ressource_amount ress_{{$ress->world_ressource_id}}">{{round($ress->amount)}}</span>/<span class="ressource_storage ress_{{$ress->world_ressource_id}}">{{$ress->storage ?? "-"}}</span>
                                </span>
                                @break
                                @endif
                            @endforeach
                        @endforeach
                    </ol>
                </div>
            </div>
			<div class="wrapper wrapper-content">
				@yield('page')
			</div>
		</div>
		<footer>
			<!-- Mainly scripts -->
			<script src="/js/jquery-3.1.1.min.js"></script>
			<script src="/js/popper.min.js"></script>
			<script src="/js/bootstrap.js"></script>
			<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
			<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

			<!-- Flot -->
			<script src="/js/plugins/flot/jquery.flot.js"></script>
			<script src="/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
			<script src="/js/plugins/flot/jquery.flot.spline.js"></script>
			<script src="/js/plugins/flot/jquery.flot.resize.js"></script>
			<script src="/js/plugins/flot/jquery.flot.pie.js"></script>
			<script src="/js/plugins/flot/jquery.flot.symbol.js"></script>
			<script src="/js/plugins/flot/jquery.flot.time.js"></script>
			<script src="/js/plugins/switchery/switchery.js"></script>

			<!-- Custom and plugin javascript -->
			<script src="/js/inspinia.js"></script>
			<script src="/js/plugins/pace/pace.min.js"></script>

			<!-- jQuery UI -->
			<script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>

			<!-- Latest compiled and minified JavaScript -->
			<script src="/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
			@yield('js')

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
                                document.querySelector(".prodress_" + ress.world_ressource_id + " .ressource_amount").innerHTML = Math.round(ress.amount);
                                document.querySelector(".prodress_" + ress.world_ressource_id + " .ressource_storage").innerHTML = ress.storage;
                                if (ress.prod != undefined && ress.prod != null) {
                                    document.querySelector(".prodress_" + ress.world_ressource_id).setAttribute('title', Math.round(ress.prod) + "/H")
                                    document.querySelector(".prodress_" + ress.world_ressource_id).setAttribute('alt', Math.round(ress.prod) + "/H")
                                }
                                document.querySelectorAll(".building").forEach(building => {
                                    var constructable = true;
                                    building.querySelectorAll(".building_ress_" + ress.world_ressource_id).forEach(element => {
                                        var dataAmount = element.getAttribute('data-amount');
                                        if (dataAmount == undefined || dataAmount == null) {
                                            // continue ;
                                        }
                                        else
                                        {
                                            if (Math.round(dataAmount) >= Math.round(ress.amount)) {
                                                element.classList.add('text-danger')
                                                constructable = false;
                                            }
                                            else {
                                                element.classList.remove('text-danger');
                                            }
                                        }
                                    });
                                if (constructable == true) {
                                    var toFind = building.getAttribute('data-href');
                                    var toUrl = building.getAttribute('data-next');
                                    console.log(toFind)
                                    var toUpdate = building.querySelector("."+toFind);
                                    toUpdate.innerHTML = "<a class='btn btn-primary btn-rounded' href='"+toUrl+"'>UPGRADE</a>";
                                }
                            });

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
		</footer>

</body>

</html>
