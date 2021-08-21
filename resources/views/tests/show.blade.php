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

        <p>
            {{$userTest->test->description}}
        </p>

        <div class="mt-5 row">
            <questionnaire class="col-lg-8 mx-auto"
                           :questions="{{json_encode($userTest->test->questions)}}"
                           :initial-answers="{{json_encode($userTest->answers)}}"
                           complete-url="{{route('tests.complete',$userTest->test)}}"
                           redirect-url="{{route('tests.result',$userTest->test)}}"
            ></questionnaire>
        </div>
    </div>

@endsection
