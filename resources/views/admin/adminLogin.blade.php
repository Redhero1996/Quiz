<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Admin Login Form</title>
  <base href="{{asset('')}}">

    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="js/prefixfree.min.js"></script>

</head>

<body>

  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Admin<span>Login</span></div>
		</div>

		<br>

		@if(Session::has('danger'))
	      	 <div class="alert alert-danger" role="alert">
	      	     <strong>{{Session::get('danger')}}</strong> 
	      	 </div>
      	@endif
		<form class="login" action="{{ url('admin/login') }}" method="POST">
			{{csrf_field() }}
				<input type="email" placeholder="email" name="email" value="{{old('emai')}}"><br>
				@if($errors->has('email'))
					<span style="color: red;"><i> {{ $errors->first('email') }} </i></span>
				@endif
				<br>
				<input type="password" placeholder="password" name="password" value="{{old('password')}}"><br>
				@if($errors->has('password'))
					<span style="color: red;"><i> {{ $errors->first('password') }} </i></span>
				@endif
				<div id="remember" class="checkbox" style="margin-top: 10px;">
					 <label>
					 	<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} > Remember Me
					 </label>
				</div>
				
				<input type="submit" value="Login">
		</form>

  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

</body>

</html>