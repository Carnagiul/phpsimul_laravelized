@foreach (App\Models\World::all() as $world)
    @if (app(App\Http\Controllers\WorldInterface::class)->canEnterInWorld($world))
        @if (app(App\Http\Controllers\WorldInterface::class)->userExistInWorld($world, Auth::user()))
            <a href="{{route('auth.world.home', $world->id)}} " class="btn btn-info">{{$world->name}}</a>
        @else
            <a href="{{route('auth.world.register', $world->id)}}" class="btn btn-success">Register on {{$world->name}}</a>
        @endif
    @endif
@endforeach
