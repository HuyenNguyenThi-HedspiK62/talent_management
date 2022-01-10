@extends('layouts.dashboard')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content-header')
    コース一覧
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mb-4">
                    <a href="{{ route('course.index', ['option' => 'all'])}}" class="btn btn-default">全て</a>
                    <a href="{{ route('course.index', ['option' => 'not-started'])}}" class="btn text-white btn-success ml-2">未着手</a>
                    <a href="{{ route('course.index', ['option' => 'processing'])}}" class="btn btn-warning ml-2">進行中</a>
                    <a href="{{ route('course.index', ['option' => 'done'])}}" class="btn text-white btn-info ml-2">完了</a>
                    <a href="{{ route('course.index', ['option' => 'interrupted'])}}" class="btn text-white btn-danger ml-2">中断</a>
                </div>
                <div class="col-2 offset-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span onclick="search()" class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input onkeypress="handleKeyPress(event)" id="text_search" type="text" class="form-control text-center" placeholder="検索">
                    </div>
                </div>
                @if(auth()->user()->role == 0)
                <div class="col-1 text-center">
                    <a href="{{ route('course.create') }}"><i class="fas fa-plus-circle fa-2x"></i></a>
                </div>
                @endif
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <table id="example2" class="table table-bordered table-hover text-center table-responsive-sm">
                        <thead style="background-color: #a0e4fc;">
                        <tr>
                            <th>コース名</th>
                            <th>日程</th>
                            <th width="12%">ステータス</th>
                            <th width="35%">担当者</th>
                            @if(auth()->user()->role == 0)
                            <th>アクション</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td onclick="window.location.href = '{{route('course.show', ['id' => $course->id])}}';" style='cursor: pointer;'>
                                    {{ $course->name }}
                                </td>
                                <td onclick="window.location.href = '{{route('course.show', ['id' => $course->id])}}';" style='cursor: pointer;'>{{ $course->start_date }} ~ {{ $course->end_date }}</td>
                                <td>
                                    <ul class="navbar-nav d-inline">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown-{{$course->id}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                @switch($course->status)
                                                    @case(0)
                                                    <p class="badge p-2 badge-success">未着手</p>
                                                    @break
                                                    @case(1)
                                                    <p class="badge p-2 badge-warning">進行中</p>
                                                    @break
                                                    @case(2)
                                                    <p class="badge px-3 py-2 badge-info">完了</p>
                                                    @break
                                                    @case(3)
                                                    <p class="badge px-3 py-2 badge-danger">中断</p>
                                                    @break
                                                    @default
                                                    <p class="badge p-2 badge-success">未着手</p>
                                                    @break
                                                @endswitch
                                            </a>
                                            @if(auth()->user()->role == 0)
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item text-center" onclick="updateStatus({{ $course->id }}, 0)">
                                                    <p class="badge p-2 badge-success">未着手</p>
                                                </a>
                                                <a class="dropdown-item text-center" onclick="updateStatus({{ $course->id }}, 1)">
                                                    <p class="badge p-2 badge-warning">進行中</p>
                                                </a>
                                                <a class="dropdown-item text-center" onclick="updateStatus({{ $course->id }}, 2)">
                                                    <p class="badge px-3 py-2 badge-info">完了</p>
                                                </a>
                                                <a class="dropdown-item text-center" onclick="updateStatus({{ $course->id }}, 3)">
                                                    <p class="badge px-3 py-2 badge-danger">中断</p>
                                                </a>
                                            </div>
                                            @endif
                                        </li>
                                    </ul>
                                </td>
                                <td onclick="window.location.href = '{{route('course.show', ['id' => $course->id])}}';" style='cursor: pointer;'>{{ $course->instructor }}</td>
                                @if(auth()->user()->role == 0)
                                <td>
                                    <a style="color: black;" href="{{ route('course.edit', ['id' => $course->id]) }}"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="deleteCourse({{$course->id}})" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(count($courses) === 0)<span class="d-block text-center p-3 font-weight-bold" style="margin-top: -16px; background-color: #e9ecef;">データが見つかりません</span>@endif
                    <span class="d-flex justify-content-center">
                        {{ $courses->links('pagination::bootstrap-4') }}
                    </span>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        function handleKeyPress(e){
            var key=e.keyCode || e.which;
            if (key==13){
                search();
            }
        }

        function search(){
            let textSearch = document.getElementById('text_search').value
            window.location.href = 'http://' + window.location.host + '/course/all?search=' + (textSearch);
        }

        function deleteCourse(courseId) {
            if (confirm('本当に削除しますか？')) {
                window.location.href = 'http://' + window.location.host + '/course/delete/' + courseId;
            }
        }

        function updateStatus(id, status) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('course/update-status/')}}",
                type: "POST",
                data: {
                    id: id,
                    status: status
                },
                success: function (success) {
                    let navbarDropdown = $(`#navbarDropdown-${id}`)
                    navbarDropdown.find('p').remove()
                    switch(status) {
                        case 0:
                            navbarDropdown.append('<p class="badge p-2 badge-success">未着手</p>')
                            break;
                        case 1:
                            navbarDropdown.append('<p class="badge p-2 badge-warning">進行中</p>')
                            break;
                        case 2:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-info">完了</p>')
                            break;
                        case 3:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-danger">中断</p>')
                            break;
                    }

                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    </script>
@endsection
