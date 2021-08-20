<nav class="navbar navbar-expand-lg navbar-light bg-light px-5 py-3">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">{{config('app.name')}}</a>
        <a class="navbar-toggler" type="button"
           data-bs-toggle="collapse"
           data-bs-target="#navbarNav"
           aria-controls="navbarNav"
           aria-expanded="false"
           aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </a>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <ul class="navbar-nav text-right pt-3">
                <li class="nav-item {{ request()->routeIs('home') ? 'font-weight-bold active' : '' }}">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item {{ request()->routeIs('tests.*') ? 'font-weight-bold active' : '' }}">
                    <a href="{{ route('tests.index',['test' => 'personality-test']) }}" class="nav-link">Personality
                        Test</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
