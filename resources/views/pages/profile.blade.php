@extends('main')

@section('title', '| Profile')

@section('content')
	<div class="container">
		<div class="row">
			<form class="form-horizontal" role="form" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
				{{csrf_field()}}
	      <!-- left column -->
			      <div class="col-md-3">
			        <div class="text-center">
			        	@if (isset($user->avatar))
			        		<img id="img" src="{{ asset('images/'.$user->avatar) }}" class="avatar img-circle" alt="avatar">
			        	@else
			        		<img id="img" src="{{ asset('images/avatar.png') }}" class="avatar img-circle" alt="avatar">
			        	@endif
			          
			          <h6>Avatar</h6>
			          
			          <input class="form-control" id="upload" type="file" name="avatar">
			        </div>
			      </div>
			      
			      <!-- edit form column -->
			      <div class="col-md-9 personal-info">
			      	@if(Session::has('success'))
			      	 <div class="alert alert-success" role="alert">
			      	     <strong>{{Session::get('success')}}</strong> 
			      	 </div>
			      	@endif
					
			        <h3>Thông tin tài khoản</h3>
			        
			      
			        	<div class="form-group">
			        	  <label class="col-md-3 control-label">Tên đặng nhập:</label>
			        	  <div class="col-md-8">
			        	    <input class="form-control" type="text" value="{{$user->name}}" name="name">
			        	     @if($errors->has('name'))
			        	        <span style="color: red;"><i><strong>{{$errors->first('name')}}</strong></i></span>
			        	    @endif
			        	  </div>
			        	</div>
			          <div class="form-group">
			            <label class="col-lg-3 control-label">Email:</label>
			            <div class="col-lg-8">
			              <input class="form-control" type="text" name="email" value="{{$user->email}}" readonly>
			            </div>
			          </div>
			          <div class="form-group">
			          	<div class="col-md-3 control-label">
			              <input type="checkbox" name="changePassword" id="changePassword">
			            </div>
			            <label class="col-md-8" style="margin-top: 7px;">Thay đổi mật khẩu:</label>
			            
			          </div>
			          <div class="form-group">
			            <label class="col-md-3 control-label">Mật khẩu:</label>
			            <div class="col-md-8">
			              <input class="form-control password" type="password" name="password" value="" placeholder="Nhập mật khẩu" disabled="">
			              @if($errors->has('password'))
			                  <span style="color: red;"><i>{{$errors->first('password')}}</i></span>
			              @endif
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-md-3 control-label">Xác nhận mật khẩu:</label>
			            <div class="col-md-8">
			              <input class="form-control password" type="password" name="confirm_pass" value="" placeholder="Xác nhận mật khẩu" disabled="">
			              @if($errors->has('confirm_pass'))
			                  <span style="color: red;"><i>{{$errors->first('confirm_pass')}}</i></span>
			              @endif
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-md-3 control-label"></label>
			            <div class="col-md-8">
			            	<div class="col-sm-3">
			            		<input type="submit" value="Lưu thay đổi" class="btn btn-primary">
			            	</div>
			          	</div>
			          </div>
			    </div>
			    <div class="form-group">
			    	<h2>Bảng điểm các lần thi</h2>
			    	<table class="table table-striped">
			    		<thead>
		    		      <tr>
		    		        <th>Lần thi</th>
		    		        <th>Điểm</th>
		    		        <th>Môn học</th>
		    		      </tr>
		    		    </thead>
		    		    <tbody>
		    		    	@php
		    		    		$i = 1;
		    		    	@endphp
		    		    	@foreach ($user->topics as $topic)		    		    		
			    		      <tr>
			    		      	<td>{{$i}}</td>
			    		        <td>{{$topic->pivot->total}}</td>
			    		        <td><a href="{{ route('topic', $topic->id) }}">{{$topic->name}}</a></td>
			    		      </tr>
			    		      @php
			    		      	$i++;
			    		      @endphp
		    		    	@endforeach
		    		    </tbody>
			    	</table>
			    </div>      
	        </form>
	      </div>
	  </div>
	</div>
	<hr>
@stop

@section('scripts')
	<script type="text/javascript">
		// Check password
		$(document).ready(function(){
			$('#changePassword').change(function(){
				console.log('1223');
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
@endsection