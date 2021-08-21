@extends('layout')


@section('content')

    <div class="container">
        <h2 class="mt-4">Tests</h2>

        <div class="row my-3">
            @foreach($tests as $test)
               <div class="col-lg-4 col-md-6 mt-4 pt-4">
                   <div class="card shadow-sm h-100">
                       <a href="{{route('tests.show',$test)}}">
                           <img onerror="this.style.display='none'" src="{{$test->thumbUrl()}}" class="card-img-top" alt="...">
                       </a>
                       <div class="card-body d-flex flex-column justify-content-between">
                           <a class="text-black-50" href="{{route('tests.show',$test)}}">
                               <h4>{{$test->title}}</h4>
                           </a>
                           <p class="mb-auto mt-3">{{$test->excerpt}}</p>
                           <div class="text-center mt-2">
                               <a class="btn btn-outline-dark btn-block" href="{{route('tests.show',$test)}}">Find out!</a>
                           </div>
                       </div>
                   </div>
               </div>
            @endforeach
        </div>
    </div>

@endsection
