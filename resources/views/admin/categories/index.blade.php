@extends('admin.layouts.index')

@section('title', '| All Categories')

@section('content')

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Categories
                            <small>List</small>
                        </h1>
                    </div>
                     @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('success')}}
                            </div>
                        @endif
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>View</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach danh sach the loai tu phia controller -->
                            @foreach($categories as $category)
                            <tr class="odd gradeX" align="center">
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->slug}}</td>
                                <td class="center"><i class="glyphicon glyphicon-folder-open"></i><a href="{{ route('categories.show', $category->slug) }}"> View</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{ route('categories.edit', $category->id) }}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

@endsection