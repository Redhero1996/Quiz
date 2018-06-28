 @extends('admin.layouts.index')

@section('title', 'Create New Topic')
 @section('content')

  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="page-header">Topic
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

                        <form id="form" action="{{ route('topics.store') }}" method="POST"> 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />                      
                            <div class="form-group">
                                <label>Topic Name</label>
                                <input class="form-control" name="name" placeholder="New category" />
                            </div>

                            <div class="form-group">
                                  <label for="category_id">Category</label>
                                  <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                  </select>
                            </div>                           
                            
                            <div class="row">                                
                                 <div class="col-sm-6">
                                     <input type="submit" value="Create Topic" class="btn btn-success btn-block">
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
        });
    </script>
@stop        