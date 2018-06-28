@extends('main')

@section('title', '| Homepage')

@section('stylesheets')
    {!! Html::style('css/styles.css') !!}
@endsection

@section('content')
    @if(Session::has('success'))
       <div class="alert alert-success" role="alert">
           <strong>{{Session::get('success')}}</strong> 
       </div>
    @endif
    <div class="row">
          <div class="col-md-12" style="text-align: center;"> 
              <img src="{{ asset('images/quiz-banner.jpg') }}" >
          </div>
    </div>
    <br><br>
     <div class="container-fluid">
       <div class="row content">

         <div class="col-sm-3 sidenav hidden-xs" style="background-color: #e7e7e7; height: 532px;">
           <h2 style="color: #91A745"><strong>Menu</strong></h2>

           <ul class="nav nav-pills nav-stacked check" >
            @foreach ($categories as $category)
                <li value="{{$category->id}}"><strong>{{$category->name}} ({{count($category->topics)}})</strong></li>
            @endforeach
           </ul>
         </div>
             <div class="col-sm-9">
              <div class="row btn-all" style="margin-bottom: 5px; display: none;">
                <a href="{{ url('/') }}" class="btn btn-default" id="btn-menu"> Tất cả danh mục </a> 
              </div>
               <div class="row topics" style="margin-left: 30px; width: auto;">
                    @foreach ($topics as $topic)
                      @php
                        $created_at = new DateTime($topic->created_at);
                        $time_zone = new DateTimeZone('Asia/Ho_Chi_Minh');
                        $created_at->setTimezone($time_zone);
                      @endphp
                        <a class="category_{{$topic->category_id}}" href="{{ route('topic', $topic->id) }}">
                          <div class="col-sm-4 well " id="topic_id">
                            @php
                              $check = 0;
                            @endphp
                            @foreach ($topic->users as $user)
                                @if (Auth::check() && (Auth::user()->id == $user->pivot->user_id) && $check != 1)
                                  <span class="glyphicon glyphicon-ok-sign text-success" style="float: right;"></span>
                                  @php
                                    $check = 1;
                                  @endphp
                              @else
                                <span class="glyphicon glyphicon-ok-sign text-success" style="display: none;"></span>
                              @endif
                            @endforeach
                                <h4 id="topic-name">{{$topic->name}}</h4>
                                <span id="created_at" >{{$created_at->format('d/m/Y')}}</span>
                          </div>
                       </a>
                    @endforeach
               </div>

              <div class="text-center">
                  {!! $topics->links() !!}
              </div>

             </div>

       </div>
     </div>

@endsection

@section('scripts')
    <script type="text/javascript">
     $(document).ready(function() {

      $('ul.check > li').on('click', function(){
        $('div.btn-all').show();
        var category_id = $(this).val();
        var li_current = $(this).parents().find('li');

        if(li_current.hasClass('active')){
              li_current.removeClass('active').removeAttr('style');
              $(this).addClass('active').css('background-color', '#c2c2a3');
        }
        
        $.ajax({
           url: 'category/'+category_id,
           method: "GET",
          datatype: "json",
          success: function(data){

            $('.topics').empty();
            $.each(data, function(key, topic){
              console.log(topic);
              if(topic.user){
                $('.topics').append(
                    `<a href="topics/`+topic.id+`">
                          <div class="col-sm-4 well" id="topic_id">
                            <span class="glyphicon glyphicon-ok-sign text-success" style="float: right;"></span>
                            <h4 style="height: 40px;">`+topic.name+`</h4>
                            <span id="created_at">
                              ` + moment(`${topic.created_at}`).format('DD/MM/YYYY') + `
                            </span>
                          </div>
                      </a>`
                  );  
              } else {
                $('.topics').append(
                    `<a href="topics/`+topic.id+`">
                          <div class="col-sm-4 well" id="topic_id">
                            <span class="glyphicon glyphicon-ok-sign text-success" style="display: none;"></span>
                            <h4 style="height: 40px;">`+topic.name+`</h4>
                            <span id="created_at">
                              ` + moment(`${topic.created_at}`).format('DD/MM/YYYY') + `
                            </span>
                          </div>
                      </a>`
                  );
                
              }
            });
            $('div.text-center').remove();
          }
        });
      });
    });
    </script>
@endsection

