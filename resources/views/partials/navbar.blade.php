@inject('testsRepo','App\Repositories\TestsRepository')

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase" href="{{route('home')}}">{{config('app.name')}}</a>
            <a class="navbar-toggler" type="button"
               data-toggle="collapse"
               data-target="#navbarNav"
               aria-controls="navbarNav"
               aria-expanded="false"
               aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>
            <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
                <ul class="navbar-nav text-right pt-1">
                    <li class="nav-item {{ request()->routeIs('home') ? 'font-weight-bold active' : '' }}">
                        <a class="nav-link" href="{{route('home')}}">Home</a>
                    </li>
                    @if($testsRepo->count())
                        <li>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#"
                                   role="button"
                                   id="dropdownMenuLink"
                                   data-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false">
                                    Tests
                                </a>

                                <div class="dropdown-menu" style="right: 0;left: unset;" aria-labelledby="dropdownMenuLink">
                                    @foreach($testsRepo->all() as $test)
                                        <a class="dropdown-item"
                                           href="{{route('tests.show',$test)}}"
                                        >{{\Str::of(str_replace('-',' ',$test->slug))->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
