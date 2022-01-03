@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            box-sizing: border-box;
            list-style: none;
            margin: 0;
            padding: 0 5px;
            width: 100%;
            min-height: 36px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff!important;
            border-color: #006fe6;
            color: #fff;
            padding: 0 10px;
            margin-top: 0.31rem;
        }
    </style>
@endsection
@section('content-header')
<div style="padding-bottom: 15px">
    <a style="color: black" href="{{ url()->previous() }}"><i class="fa fa-arrow-left" style="font-size:24px;"></i></a>
</div>
    コース編集
@endsection
<style>
    form {
      padding: 50px;
      border-top: 2px solid black;
    }

    .col-md-3 {
      justify-content: flex-end;
      align-items: center;
      display: flex;
    }

    .button {
      float: right;
      padding-bottom: 50px;
      padding-right: 75px;
    }
  </style>
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h4 class="mt-1 mr-3 d-inline">コース名</h4>
                    <p class="badge p-2 badge-success">未着手</p>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <form action="{{ route('course.update', ['id' => $course->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                                <input value="@if(old('name')) {{old('name')}} @else{{ $course->name }} @endif" name="name" type="text" class="bg-white form-control">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース詳細</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="detail" rows="7">@if(old('detail')) {{old('detail')}} @else{{ $course->detail }} @endif</textarea>
                                @error('detail')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-8">
                                    <input value="@if(!$errors->isEmpty()){{old('start_date')}}@else{{$course->start_date}}@endif" type="date" name="start_date" class="form-control">
                                    @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-8">
                                    <input value="@if(!$errors->isEmpty()){{old('end_date')}}@else{{$course->end_date}}@endif" type="date" name="end_date" class="form-control">
                                    @error('end_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">場所</label>
                                    <div class="col-sm-8">
                                        <input value="@if(old('location')) {{old('location')}} @else{{ $course->location }} @endif" type="text" name="location" class="bg-white form-control text-center">
                                        @error('location')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 row bootstrap-timepicker">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-4">
                                        <input value="@if(!$errors->isEmpty()){{old('start_time')}}@else{{$course->start_time}}@endif" type="time" id="start_time" name="start_time" class="form-control time-picker"/>
                                        @error('start_time')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <input value="@if(!$errors->isEmpty()){{old('end_time')}}@else{{$course->end_time}}@endif" type="time" name="end_time" class="form-control"/>
                                        @error('end_time')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                                <select name="instructor" class="form-control select2" style="width: 100%;">
                                    <option selected disabled hidden></option>
                                    @foreach($instructors as $instructor)
                                        <option @if(old('instructor') == $instructor->id) selected
                                                @elseif($course->instructor == $instructor->id) selected
                                                @endif value="{{$instructor->id}}">{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                                @error('instructor')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-10">
                                <input value="@if(old('max_score')) {{old('max_score')}} @else{{ $course->max_score }} @endif" type="text" name="max_score" class="bg-white form-control text-center">
                                @error('max_score')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label text-left">タレント数（&nbsp;<span id="selectedNumbers">0</span>&nbsp;名選んだ）</label>
                            <select onchange="countSelected()" class="select2" multiple="multiple" name="talents[]" data-placeholder="Select a talent" style="width: 100%;">
                                @if(old('talents'))
                                    @foreach($talents as $talent)
                                        @foreach(old('talents') as $old_talent)
                                            <option @if($talent->id == $old_talent) selected
                                                    @endif value="{{$talent->id}}">{{$talent->name}}</option>
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach($talents as $talent)
                                        @foreach($course->users as $user)
                                        <option @if($talent->id == $user->id) selected
                                                @endif value="{{$talent->id}}">{{$talent->name}}</option>
                                        @endforeach
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="button">
                            <a href="#" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                            <button type="submit" class="btn btn-success">編集</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
            $("#selectedNumbers").text($('ul.select2-selection__rendered li').length -1);
        })

        function countSelected(){
            $("#selectedNumbers").text($('ul.select2-selection__rendered li').length -1);
        }
    </script>
@endsection
