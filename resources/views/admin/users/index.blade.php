@extends('admin.layouts.index')

@section('title', '| All users')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Users
                            <small>List</small>
                        </h1>
                    </div>

                     <!-- Success -->
                    @if(Session::has('success'))
                     <div class="alert alert-success" role="alert">
                         <strong>Success:</strong> {{Session::get('success')}}
                     </div>
                    @endif

                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>View</th>                                
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="odd gradeX" align="center">                                
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if($user->level == 1)
                                        {{"Admin"}}
                                    @else
                                        {{"User"}}
                                    @endif        
                                </td>
                                <td class="center"><i class="glyphicon glyphicon-folder-open"></i> <a href="{{ route('users.show', $user->id) }}">View</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{ route('users.edit', $user->id) }}">Edit</a></td>                                          
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