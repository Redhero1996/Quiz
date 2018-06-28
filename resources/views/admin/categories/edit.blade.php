 @extends('admin.layouts.index')

@section('title', 'Edit Category')
 @section('content')

  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="page-header">Category
                            <small>{{$category->name}}</small>
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

                        {!! Form::model($category, [ 'route' => ['categories.update', $category->id], 'method' => 'PUT' ]) !!}                      
                            <div class="form-group">
                                <label>Category Name</label>
                                <input class="form-control" name="name" placeholder="New category" value="{{$category->name}}" />
                            </div>                           
                            
                            <div class="row">                                
                                 <div class="col-sm-6">
                                     <input type="submit" value="Save Changes" class="btn btn-success btn-block">
                                 </div>

                                <div class="col-sm-6">
                                    <a href="{{route('categories.show', $category->slug)}}" class="btn btn-danger btn-block">Cancel</a>
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