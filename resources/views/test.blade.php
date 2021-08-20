@extends('layout')

@section('content')

    <header class="row">
        <h1 class="col-12 my-4 text-center">{{$userTest->test->title}}</h1>

        <h5 class="col-8 mx-auto text-center px-5 mb-5">{{$userTest->test->excerpt}}</h5>

        <div class="col-12">
            <img class="header_image" src="{{$userTest->test->imageUrl()}}" alt="">
        </div>
    </header>


    <div class="container py-5">
        <p>
            {{$userTest->test->description}}
        </p>
    </div>

@endsection
