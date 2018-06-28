@extends('admin.layouts.index')

@section('title', '| All Answers')


@section('content')

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Answers
                            <small>List</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Content</th>
                                <th>Question</th>
                                <th>View</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach danh sach the loai tu phia controller -->
                            @foreach($answers as $answer)
                            <tr class="odd gradeX" align="center">
                                <td>{{$answer->id}}</td>
                                {{-- strip_tags() sẽ loại bỏ các thẻ HTML và PHP ra khỏi chuỗi --}}
                                <td>{{ substr(strip_tags($answer->content), 0, 50) }}{{ strlen(strip_tags($answer->content)) > 50 ? '...': '' }}
                                </td>      
                                <td>{{ substr(strip_tags($answer->question->content), 0, 50) }}{{ strlen(strip_tags($answer->question->content)) > 50 ? '...': '' }}</td>
                               
                                
                                <td class="center"><i class="glyphicon glyphicon-folder-open"></i><a href="{{ route('questions.show', $answer->question->id) }}"> View</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{{ route('questions.edit', $answer->question->id) }}">Edit</a></td>
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