 @extends('admin.layouts.index')

@section('title', "| $topic->name ")
 @section('content')

  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="page-header">Detail</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-md-8 col-md-offset-2" style="padding-bottom:120px">
                        <!-- In error -->
                    @if(Session::has('success'))
                       <div class="alert alert-success" role="alert">
                           <strong>{{Session::get('success')}}</strong> 
                       </div>
                    @endif

                        <div class="form-group">
                            <label>Topic Name</label>
                            <input class="form-control" name="name" value="{{$topic->name}}" disabled="" />
                        </div>

                       <div class="form-group">
                              <label for="category_id">Category</label>
                                @if(isset($topic->category->name))
                                    <input class="form-control" name="category_id" value="{{$topic->category->name}}" disabled="" />
                                @else
                                    <input class="form-control" name="category_id" value="NULL" disabled="" />
                                @endif

                        </div>                 
                        
                        <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-primary btn-block">Edit</a>
                        </div>

                        <div class="col-sm-6">      
                            <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-{{$topic->id}}">Delete</a>
                        </div>

                        <!-- Delete Confirmation Modal (place it right below the button) -->

                            <div class="modal fade" id="delete-{{$topic->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Delete Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Are you sure you want to delete this topic?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            
                                            {!! Form::open(['route' => ['topics.destroy', $topic->id], 'method' => 'DELETE', 'style' => 'width: 500px; float:left;']) !!}
                                            <button type="submit" class="btn btn-danger" style="margin-bottom: 5px;">DELETE</button>
                                            {!! Form::close() !!}

                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--At the end -->

                     </div><br>


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