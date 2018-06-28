@extends('admin.layouts.index')

@section('title', "| $user->name ")

@section('content')

<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="page-header"> Information
                        <small>{{$user->name}}</small>
                    </h2>

                </div>
                <!-- /.col-lg-12 -->
                <div class="col-md-8 col-md-offset-2" style="padding-bottom:120px">
                    
                    <!-- Success -->
                   @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{Session::get('success')}}</strong> 
                    </div>
                   @endif
                  
                    <div class="form-group">
                        <label>Avatar</label><br>
                        <img src="{{ asset('images/'.$user->avatar) }}" class="image-avatar">
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="name" value="{{$user->name}}" disabled=""/>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" disabled="" />
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary btn-block">Edit</a>
                        </div>
                        <div class="col-sm-6">      
                             <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete-{{$user->id}}">Delete</a>

                        </div>
                         <!-- Delete Confirmation Modal (place it right below the button) -->

                            <div class="modal fade" id="delete-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Delete Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Are you sure you want to delete this user?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            
                                            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'style' => 'width: 500px; float:left;']) !!}
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

   