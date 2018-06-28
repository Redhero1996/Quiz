
	<div class="col-sm-3 sidenav hidden-xs" style="background-color: #e7e7e7;">
      <h2><strong>Menu</strong></h2>
      <ul class="nav nav-pills nav-stacked">
      	@foreach ($categories as $category)
      		<li id="check"><a href="{{ route('category', $category->id) }}">{{$category->name}}</a></li>
      	@endforeach
      </ul><br>
    </div>



