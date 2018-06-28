@extends('main')

@section('title', '| Topics')

@section('content')
	 <div class="row">
          <div class="col-md-12">
              <img src="{{ asset('images/92996-OJLN0Q-378.jpg') }}" style="width: 100% ; height: 500px;">
          </div>
    </div>
    <br>
     <div class="container-fluid">
       <div class="row content">
         @include('partials._sidebar')
         
         <div class="col-sm-9">
          
           <div class="row">
                @foreach ($topics as $topic)
                  <a href="{{ route('topic', $topic->id) }}">
                  	<div class="col-sm-4" id="topic_id">
                     <div class="well">
                       <h4>{{$topic->name}}</h4>
                     </div>
                   </div>
                  </a>
                @endforeach

           </div>
         
         </div>
       </div>
     </div>
@endsection
