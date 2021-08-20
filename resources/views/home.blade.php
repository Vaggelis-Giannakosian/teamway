@extends('layout')


@section('content')

    <div class="container">
        <h2 class="my-4">Tests</h2>

        <div class="row my-5">
            @foreach($tests as $test)
               <div class="col-lg-4 col-md-6">
                   <div class="card shadow-sm">
                       <a href="{{route('tests.show',$test)}}">
                           <img onerror="this.style.display='none'" src="{{$test->thumbUrl()}}" class="card-img-top" alt="...">
                       </a>
                       <div class="card-body">
                           <a class="text-black-50" href="{{route('tests.show',$test)}}">
                               <h4>{{$test->title}}</h4>
                           </a>
                           <p>{{$test->excerpt}}</p>
                           <div class="text-center">
                               <a class="btn btn-outline-dark btn-block" href="{{route('tests.show',$test)}}">Find out!</a>
                           </div>
                       </div>
                   </div>
               </div>
            @endforeach
        </div>
    </div>

@endsection
