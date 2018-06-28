 <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Laravel-Quiz</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="{{ Request::is('/') ? 'active' : "" }}"><a href="/">Trang chủ</a></li>
            <li class="{{ Request::is('about') ? 'active' : "" }}"><a href="/about">About</a></li>
            <li class="{{ Request::is('contact') ? 'active' : "" }}"><a href="/contact">Liên hệ</a></li>
          </ul>
          <ul class="nav navbar-nav" style="right: 126px; position: absolute; margin: 10px 20px 0px 0px;">
            <li>
               <span id="timer">15:00</span>
              <button class="btn btn-primary" type="submit" id="btn_submit">
                Nộp bài
              </button>
            </li>
          </ul>
          
          <ul class="nav navbar-nav pull-right">
              @if(Auth::check())
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      @if (isset(Auth::user()->avatar))                        
                        <img src="{{ asset('images/'.Auth::user()->avatar) }}" style="width: 25px; height: 25px; border-radius: 50% 50%;">                           
                      @else
                        <img src="{{ asset('images/avatar.png') }}" style="width: 25px; height: 25px; border-radius: 50% 50%;">   
                      @endif
                       {{Auth::user()->name}}
                  <span class="caret"></span></a>   
                  <ul class="dropdown-menu">
                    <li><a href="{{ route('user.profile', Auth::user()->id) }}"><i class="glyphicon glyphicon-user" style="margin-right: 5px;"></i>Hồ sơ</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}"><i class="glyphicon glyphicon-log-out" style="margin-right: 5px;"></i>Đăng xuất</a></li>
                  </ul>
                </li>                                    
              @else                        
                  <li><a href="{{ route('login') }}"><strong>ĐĂNG NHẬP</strong></a></li>
                  <li><a href="{{ route('register') }}"><strong>ĐĂNG KÝ</strong></a></li>
              @endif
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
