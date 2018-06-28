 @extends('admin.layouts.index')

@section('title', 'Edit Question')

@section('stylesheets')
   <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
   <script>
        tinymce.init({ 
            selector:'textarea',
            plugins: 'link code codesample',
            codesample_languages: [
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'PHP', value: 'php'},
                {text: 'Ruby', value: 'ruby'},
                {text: 'Python', value: 'python'},
                {text: 'Java', value: 'java'},
                {text: 'C', value: 'c'},
                {text: 'C#', value: 'csharp'},
                {text: 'C++', value: 'cpp'}
            ],
        });
   </script>
@stop

 @section('content')

  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="page-header">Question
                            <small>Edit</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-md-8 col-md-offset-2" style="padding-bottom:120px">
                        <!-- In error -->
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                       {!! Form::model($question, [ 'route' => ['questions.update', $question->id], 'method' => 'PUT' ]) !!}
                            <div class="form-group">
                                  <label for="topic_id">Topic</label>
                                  {!! Form::select('topic_id', $topics, $question->topics->pluck('id'), ['class' => 'form-control']) !!}
                           </div>      

                            <div class="form-group">
                                <label>Question Content</label>
                                {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 10]) !!}
                                
                            </div>

                            @foreach ($answers as $key => $answer)
                              <div class="form-group">
                                @if(in_array($answer->id, $question->correct_ans))
                                  <input type="checkbox" name="correct_ans[]" value="{{$answer->id}}" checked="">
                                @else
                                  <input type="checkbox" name="correct_ans[]" value="{{$answer->id}}">
                                @endif                                
                                  <label>Answer {{$alphabet[$key]}}:</label>
                                  <input type="text" name="answer[]" class="form-control" value="{{$answer->content}}">
                              </div>
                            @endforeach                   
                            
                            <div class="row">                                
                                 <div class="col-sm-6">
                                     <input type="submit" value="Save Changes" class="btn btn-success btn-block">
                                 </div>

                                 <div class="col-sm-6">
                                    <a href="{{route('questions.show', $question->id)}}" class="btn btn-danger btn-block">Cancel</a>
                                 </div>
                             </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection 

@section('script')
    <script type="text/javascript">
        
        $(document).ready(function(){
            $('#reset').on('click', function(){
                $('#form').trigger("reset");
            });
        });
    </script>
@stop  