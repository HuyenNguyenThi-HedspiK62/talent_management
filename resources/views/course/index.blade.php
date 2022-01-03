@extends('layouts.dashboard')

@section('content-header')
    コース一覧
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mb-4">
                    <a href="#" class="btn btn-default">全て</a>
                    <a href="#" class="btn text-white btn-success ml-2">未着手</a>
                    <a href="#" class="btn btn-warning ml-2">進行中</a>
                    <a href="#" class="btn text-white btn-info ml-2">完了</a>
                    <a href="#" class="btn text-white btn-danger ml-2">中断</a>
                </div>
                <div class="col-2 offset-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span onclick="search()" class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input onkeypress="handleKeyPress(event)" id="text_search" type="text" class="form-control text-center" placeholder="検索">
                    </div>
                </div>
                <div class="col-1 text-center">
                    <a href="{{ route('course.add') }}"><i class="fas fa-plus-circle fa-2x"></i></a>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <table id="example2" class="table table-bordered table-hover text-center table-responsive-sm">
                        <thead style="background-color: #a0e4fc;">
                        <tr>
                            <th>コース名</th>
                            <th>日程</th>
                            <th width="8%">ステータス</th>
                            <th width="35%">担当者</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td  style='cursor: pointer;'>
                                    {{ $course->name }}
                                </td>
                                <td style='cursor: pointer;'>{{ $course->start_date }} - {{ $course->end_date }}</td>
                                <td>
                                    <ul class="navbar-nav d-inline">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <p class="badge p-2 badge-success d-inline">未着手</p>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item text-center" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();">
                                                    <p class="badge p-2 badge-success">未着手</p>
                                                </a>
                                                <a class="dropdown-item text-center" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();">
                                                    <p class="badge p-2 badge-warning">進行中</p>
                                                </a>
                                                <a class="dropdown-item text-center" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();">
                                                    <p class="badge px-3 py-2 badge-info">完了</p>
                                                </a>
                                                <a class="dropdown-item text-center" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();">
                                                    <p class="badge px-3 py-2 badge-danger">中断</p>
                                                </a>

                                                <form id="logout-form" action="#" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                                <td style='cursor: pointer;'>{{ $course->instructor }}</td>
                                <td style="font-size:20px;">
                                    <a style="color: black;" href="{{ route('course.edit', ['id' => $course->id]) }}"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="return confirm('本当に削除しますか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

{{--@section('script')--}}
{{--    <script>--}}
{{--        function handleKeyPress(e){--}}
{{--            var key=e.keyCode || e.which;--}}
{{--            if (key==13){--}}
{{--                search();--}}
{{--            }--}}
{{--        }--}}

{{--        function search(){--}}
{{--            let textSearch = document.getElementById('text_search').value--}}
{{--            window.location.href = 'http://' + window.location.host + '/schedule/all?search=' + (textSearch);--}}
{{--        }--}}

{{--        function delete_alert() {--}}
{{--            var result = confirm("are you sure?");--}}
{{--            if (result) {--}}
{{--                // do something when OK clicked--}}
{{--            }--}}
{{--            else {--}}
{{--                // do something when cancel clicked--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
