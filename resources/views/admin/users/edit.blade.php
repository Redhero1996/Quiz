@extends('admin.layouts.index')

@section('title', '| Edit User')

@section('content')
	<!-- Page Content -->
	    <div id="page-wrapper">
	        <div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h1 class="page-header">User
	                        <small>{{$user->name}}</small>
	                    </h1>
	                </div>
	                <!-- /.col-lg-12 -->
	                <div class="col-md-8 col-md-offset-2" style="padding-bottom:120px">
	                    

	                    <!-- FORM  -->
						{!! Form::model($user, [ 'route' => ['users.update', $user->id], 'method' => 'PUT', 'files' => true ]) !!}

							<div class="form-group">
							    <label>Avatar</label><br>
								<img src="{{ asset('images/'.$user->avatar) }}" id="img" class="image-avatar">
							    <input id="upload" type="file" name="avatar" style="margin-top: 10px;" />
							</div>
							
							<div class="form-group">
							    <label>Username</label>
							    <input class="form-control" name="name" placeholder="Username" value="{{$user->name}}" />
							     @if($errors->has('name'))
							        <span style="color: red;"><i>{{$errors->first('name')}}</i></span>
							    @endif
							</div>

							 <div class="form-group">
							     <label>Email</label>
							     <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}" disabled="" />
							     @if($errors->has('email'))
							         <span style="color: red;"><i>{{$errors->first('email')}}</i></span>
							     @endif
							 </div>

							<div class="form-group">
								 <input type="checkbox" name="changePassword" id="changePassword">
							     <label>Change Password</label>
							     <input type="password" class="form-control password" name="password" placeholder="Password" disabled=""/>
							     @if($errors->has('password'))
							         <span style="color: red;"><i>{{$errors->first('password')}}</i></span>
							     @endif
							 </div> 

							 <div class="form-group">
							     <label>Confirm password</label>
							     <input type="password" class="form-control password" name="confirm_pass" placeholder="Confirm password" disabled="" />
							     @if($errors->has('confirm_pass'))
							         <span style="color: red;"><i>{{$errors->first('confirm_pass')}}</i></span>
							     @endif
							 </div> 
							
							<div class="form-group">
							    <label>Level</label>
							    <label class="radio-inline">
							        <input name="level" value="1" 
										@if($user->level == 1)
											{{'checked'}}
										@endif	
							        type="radio">Admin
							    </label>
							    <label class="radio-inline">
							        <input name="level" value="0"
										@if($user->level == 0)
											{{'checked'}}
										@endif	
							        type="radio">User
							    </label>
							</div>

							<div class="row">								
								<div class="col-sm-6">
									<input type="submit" value="Save Changes" class="btn btn-success btn-block">
								</div>

								<div class="col-sm-6">
									<a href="{{route('users.show', $user->id)}}" class="btn btn-danger btn-block">Cancel</a>
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
@stop

@section('scripts')
	<script type="text/javascript">
		// Check password
		$(document).ready(function(){
			$('#changePassword').change(function(){
				if($(this).is(':checked')){
					$('.password').removeAttr('disabled');
				}else{
					$('.password').attr('disabled', '');
				}
			});
		});

		// Avatar
		$(function(){
		  $('#upload').change(function(){
		    var input = this;
		    var url = $(this).val();
		    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		     {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		           $('#img').attr('src', e.target.result);
		           $('#img').css({"width" : "200px", "height" : "200px"});

		        }
		       reader.readAsDataURL(input.files[0]);
		    }
		    else
		    {
		      $('#img').attr('src', '{{ asset('images/'.$user->avatar) }}');
		    }
		  });

		});
	</script>
@stop