 @extends('admin.layouts.index')

@section('title', 'Edit Topic')
 @section('content')

  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="page-header">Topic
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

                       {!! Form::model($topic, [ 'route' => ['topics.update', $topic->id], 'method' => 'PUT' ]) !!}                 
                            <div class="form-group">
                                <label>Topic Name</label>
                                <input class="form-control" name="name" value="{{$topic->name}}" />
                            </div>

                            <div class="form-group">
                                  <label for="category_id">Category</label>
                                  {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
                            </div>                           
                            
                            <div class="row">                                
                                 <div class="col-sm-6">
                                     <input type="submit" value="Save Changes" class="btn btn-success btn-block">
                                 </div>

                                 <div class="col-sm-6">
                                    <a href="{{route('topics.show', $topic->slug)}}" class="btn btn-danger btn-block">Cancel</a>
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

@section('scripts')
    <script type="text/javascript">
        
        $(document).ready(function(){
            $('#reset').on('click', function(){
                $('#form').trigger("reset");
            });
        });
    </script>
@stop        