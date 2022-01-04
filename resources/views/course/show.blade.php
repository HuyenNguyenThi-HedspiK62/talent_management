@extends('layouts.dashboard')
@section('content-header')
<div style="padding-bottom: 15px">
    <a style="color: black" href="{{ url()->previous() }}"><i class="fa fa-arrow-left" style="font-size:24px;"></i></a>
</div>
    コース詳細
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h4 class="mt-1 mr-3 d-inline">コース名</h4>
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
                </div>
                <div class="col-2 offset-4 text-right pr-3">
                    <div style="font-size:20px;">
                        <a href="{{ route('course.edit', ['id' => $course->id]) }}" style="color: black;"><i class="far fa-edit"></i></a>
                        <a onclick="deleteCourse({{$course->id}})" class="pl-2"><i class="far fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                                <input value="{{ $course->name }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-6">
                                    <input value="{{ $course->start_date }}" disabled type="text" class="bg-white form-control text-center">
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-6">
                                    <input value="{{ $course->end_date }}" disabled type="text" class="bg-white form-control text-center">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">場所</label>
                                    <div class="col-sm-6">
                                        <input value="{{ $course->location }}" disabled type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-6">
                                        <input value="{{ $course->start_time }} - {{ $course->end_time }}" disabled type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                                <input value="{{ $course->instructor }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-10">
                                <input value="{{ $course->max_score }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label text-left">タレント数（{{ count($course->users) }}名）</label>
                            <p>
                                @for($i = 0; $i < count($course->users); $i++)
                                    @if($i === count($course->users) - 1)
                                        {{ $course->users[$i]->name }}
                                    @else
                                        {{$course->users[$i]->name}}、
                                    @endif
                                @endfor
                            </p>
                            <div class="row" style="border-top: 1px solid black; padding: 40px 0px 30px 0px">
                                <div class="col-md-6">
                                    <h2>成績管理</h2>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">成績入力</button>
                                </div>
                            </div>
                            <div>
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <thead style="background-color: #a0e4fc;">
                                        <tr>
                                            <th width="25%">名前</th>
                                            <th width="10%">成績</th>
                                            <th width="66%">コメント</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($course->users as $talent)
                                        <tr>
                                            <td>{{$talent->name}}</td>
                                            <td>{{$talent->pivot->score}}/{{$course->max_score}}</td>
                                            <td>{{$talent->pivot->comment}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('course.update_score', ['id' => $course->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <table id="example2" class="table table-bordered table-hover text-center">
                            <thead style="background-color: #a0e4fc;">
                            <tr>
                                <th width="30%">名前</th>
                                <th width="20%">成績</th>
                                <th width="50%">コメント</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($course->users as $talent)
                                <tr>
                                    <td>{{$talent->name}}</td>
                                    <td>
                                        <input value="{{$talent->pivot->score}}" name="scores[]" min="1" max="{{$course->max_score}}" type="number" style="width: 47px; margin-top: 4px;">&nbsp;&nbsp;/{{$course->max_score}}</td>
                                    <td>
                                        <textarea name="comments[]" class="form-control" rows="1">{{$talent->pivot->comment}}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function deleteCourse(courseId) {
        if (confirm('xoa nhe?')) {
            window.location.href = 'http://' + window.location.host + '/course/delete/' + courseId;
        }
    }
</script>
@endsection
