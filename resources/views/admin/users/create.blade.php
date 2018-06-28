@extends('admin.layouts.index')

@section('title', '| Create New User')

@section('content')

<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="page-header">User
                        <small>Add</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-md-8 col-md-offset-2" style="padding-bottom:120px">
                    

                    <!-- FORM-->
                    <form id="form" action="{{ route('users.store') }}" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Avatar</label>
                            <input type="file" name="avatar" />
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" name="name" placeholder="Username" value="{{old('name')}}" />
                             @if($errors->has('name'))
                                <span style="color: red;"><i>{{$errors->first('name')}}</i></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}" />
                            @if($errors->has('email'))
                                <span style="color: red;"><i>{{$errors->first('email')}}</i></span>
                            @endif
                        </div>

                       <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password"/>
                            @if($errors->has('password'))
                                <span style="color: red;"><i>{{$errors->first('password')}}</i></span>
                            @endif
                        </div> 

                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" class="form-control" name="confirm_pass" placeholder="Confirm password" />
                            @if($errors->has('confirm_pass'))
                                <span style="color: red;"><i>{{$errors->first('confirm_pass')}}</i></span>
                            @endif
                        </div> 

                        <div class="form-group">
                            <label>Level</label>
                            <label class="radio-inline">
                                <input name="level" value="1" type="radio">Admin
                            </label>
                            <label class="radio-inline">
                                <input name="level" value="0" checked="" type="radio">User
                            </label>
                        </div>
                       <div class="row">                                
                            <div class="col-sm-6">
                                <input type="submit" value="Create user" class="btn btn-success btn-block">
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