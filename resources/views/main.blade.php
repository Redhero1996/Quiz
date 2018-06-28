<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials._head')  
  </head>

  <body>

    @include('partials._nav')
    
    <div class="container" style="margin-top: 54px;">

      @yield('content')

      @include('partials._footer')

    </div>
      <!-- end of .container -->

      @include('partials._script')

      @yield('scripts')

  </body>

</html>