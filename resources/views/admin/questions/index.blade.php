@extends('admin.layouts.index')

@section('title', '| All Questions')


@section('content')

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Questions
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
                                <th>Content</th>
                                <th>Category</th>
                                <th>Topic</th>
                                <th>View</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach danh sach the loai tu phia controller -->
                            @foreach($questions as $question)
                            <tr class="odd gradeX" align="center">
                                <td>{{$question->id}}</td>
                                {{-- strip_tags() sẽ loại bỏ các thẻ HTML và PHP ra khỏi chuỗi --}}
                                <td>{{ substr(strip_tags($question->content), 0, 50) }}{{ strlen(strip_tags($question->content)) > 50 ? '...' : "" }}
                                </td> 
                                    @foreach ($question->topics as $topic)
                                        @if ($topic->name)
                                            <td>{{$topic->category->name}}</td>
                                            <td>{{$topic->name}}</td>
                                        @else
                                            <td>NULL</td>
                                            <td>NULL</td>
                                        @endif
                                    @endforeach 
                                                               
                                <td class="center"><i class="glyphicon glyphicon-folder-open"></i><a href="{{ route('questions.show', $question->id) }}"> View</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{ route('questions.edit', $question->id) }}">Edit</a></td>
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

@section('scripts')

@stop