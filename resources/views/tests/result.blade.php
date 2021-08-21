@extends('layout')

@section('content')

    <header class="row">
        <h1 class="col-12 mb-4 text-center">{{$userTest->test->title}}</h1>

        <h5 class="col-8 mx-auto text-center px-5 mb-5">{{$userTest->test->excerpt}}</h5>

        <div class="col-12">
            <img class="header_image" src="{{$userTest->test->imageUrl()}}" alt="">
        </div>
    </header>


    <div class="container pt-5 pb-3">


        <div class="mt-3 row">
            <div class="col-lg-10 mx-auto">
                <h1>Result:</h1>

                <h3>{{$result['label']}}</h3>

                <p>{{$result['description']}}</p>

                <div>
                    <a class="btn btn-outline-info" href="{{route('tests.show',$userTest->test)}}">Try again</a>
                </div>
            </div>
        </div>


    </div>

@endsection
