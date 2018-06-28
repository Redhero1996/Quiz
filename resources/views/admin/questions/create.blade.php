 @extends('admin.layouts.index')

@section('title', 'Create New Question')

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
                            <small>Add</small>
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

                        <form id="form" action="{{ route('questions.store') }}" method="POST"> 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                  <label for="topic_id">Categories</label>
                                  <select class="form-control" name="category_id" id="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                  </select>
                                
                            </div>

                            <div class="form-group">
                                  <label for="topic_id">Topics</label>
                                  <select class="form-control" name="topic_id" id="topic_id">   
                                     @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                    @endforeach
                                  </select>

                            </div>      

                            <div class="form-group">
                                <label>Question Content</label>
                                <textarea class="form-control" name="content" rows="10" id="summary-ckeditor" ></textarea>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="correct_ans[]" value="0">
                                <label>Answer A:</label>
                                <input type="text" name="answer[]" class="form-control" >
                            </div>

                            <div class="form-group">
                                 <input type="checkbox" name="correct_ans[]" value="1">
                                 <label>Answer B:</label>
                                <input type="text" name="answer[]" class="form-control">
                            </div> 

                            <div class="form-group">
                                 <input type="checkbox" name="correct_ans[]" value="2">
                                 <label>Answer C:</label>
                                <input type="text" name="answer[]" class="form-control">
                            </div> 

                            <div class="form-group">
                                <input type="checkbox" name="correct_ans[]" value="3">
                                <label>Answer D:</label>
                                <input type="text" name="answer[]" class="form-control">
                            </div>
               
                            
                            <div class="row">                                
                                 <div class="col-sm-6">
                                     <input type="submit" value="Create Question" class="btn btn-success btn-block">
                                 </div>

                                 <div class="col-sm-6">
                                     <input type="reset" value="Reset" class="btn btn-default btn-block" id="reset">
                                 </div>
                             </div>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection 

@section('scripts')
    <script type="text/javascript">
        
        $(document).ready(function(){
            $('#reset').on('click', function(){
                $('#form').trigger("reset");
            });

          $('select[name="category_id"]').on('change', function(){
              var category_id = $(this).val();
            
                $.ajax({
                    url: '/admin/select-ajax/'+category_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data){
                      $('select[name="topic_id"]').empty();
                      $.each(data, function(key, topic){
                          $('select[name="topic_id"]').append(
                              "<option value='"+topic.id+"'>"+topic.name+"</option>"
                          );
                      });
                    }
                });

          });
            
        });


    </script>
@stop  