@extends('main')
@section('title', '| Contact')
@section('content')

      <div class="row">
        <div class="col-md-12">
          <h1>liên hệ</h1>
          <hr>
          <form action="{{ url('contact') }}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
              <label name="email">Email:</label>
              <input id="email" name="email" class="form-control">
               @if($errors->has('email'))
                  <span style="color: red;"><i><strong>{{$errors->first('email')}}</strong></i></span>
                @endif
            </div>

            <div class="form-group">
              <label name="subject">Tiêu đề:</label>
              <input id="subject" name="subject" class="form-control">
               @if($errors->has('subject'))
                  <span style="color: red;"><i><strong>{{$errors->first('subject')}}</strong></i></span>
                @endif
            </div>

            <div class="form-group">
              <label name="message">Nội dung:</label>
              <textarea id="message" name="message" class="form-control" placeholder="Type your message here..."></textarea>
               @if($errors->has('message'))
                  <span style="color: red;"><i><strong>{{$errors->first('message')}}</strong></i></span>
                @endif
            </div>

            <input type="submit" value="Send Message" class="btn btn-success">
          </form>
        </div>
      </div>
    <!-- end of .container -->
@endsection