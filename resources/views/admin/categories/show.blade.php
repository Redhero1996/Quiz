@extends('admin.layouts.index')

@section('title', "| $category->name ")

@section('content')

<!-- Page Content -->
      <div id="page-wrapper">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                      <h1 class="page-header">Detial</h1>
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
                          <label>Category Name</label>
                          <input class="form-control" name="name" value="{{$category->name}}" disabled="" />
                      </div> 

                      <div class="form-group">
                          <label>Slug</label>
                          <input class="form-control" name="slug" value="{{$category->slug}}" disabled="" />
                      </div>                                
                      
                      <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-block">Edit</a>
                        </div>

                        <div class="col-sm-6">      
                            <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-{{$category->id}}">Delete</a>
                        </div>

                        <!-- Delete Confirmation Modal (place it right below the button) -->

                            <div class="modal fade" id="delete-{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Delete Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Are you sure you want to delete this category?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            
                                            {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE', 'style' => 'width: 500px; float:left;']) !!}
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

   