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
    コース追加
@endsection
@section('content')
    <style>
        .multipleChosen, .multipleSelect2 {
            width: 300px;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                                <input value="{{old('name')}}" type="text" name="name" class="form-control" placeholder="コース名を入力して下さい">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース詳細</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="detail" rows="3">{{old('detail')}}</textarea>
                                @error('detail')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-8">
                                    <input value="{{old('start_date')}}" type="date" name="start_date" class="form-control">
                                    @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-8">
                                    <input value="{{old('end_date')}}" type="date" name="end_date" class="form-control">
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
                                    <div class="col-sm-6">
                                        <input value="{{old('location')}}" type="text" name="location" class="bg-white form-control text-center">
                                        @error('location')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 row bootstrap-timepicker">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-4">
                                        <input value="{{old('start_time')}}" type="time" id="start_time" name="start_time" class="form-control time-picker"/>
                                        @error('start_time')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <input value="{{old('end_time')}}" type="time" name="end_time" class="form-control"/>
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
                                        <option @if(old('instructor') == $instructor->name) selected
                                                @endif value="{{$instructor->name}}">{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                                @error('instructor')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-2">
                                <input value="{{old('max_score')}}" type="number" class="bg-white form-control text-center" name="max_score" min="1" max="100">
                                @error('max_score')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>タレント追加&nbsp;(<span id="selectedNumbers">0</span>&nbsp;名選んだ)</label>
                            <select onchange="countSelected()" class="select2" multiple="multiple" name="talents[]" data-placeholder="Select a talent" style="width: 100%;">
                                @foreach($talents as $talent)
                                    <option @if(in_array($talent->id, old('talents') ?? [])) selected
                                            @endif value="{{$talent->id}}">{{$talent->name}}</option>
                                @endforeach
                            </select>
                            @error('talents')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <a href="#" class="btn btn-danger mr-3">一時保存</a>
                            <button type="submit" class="btn btn-success">登録</button>
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
{{--    <script>--}}
{{--        function deleteSchedule(scheduleId) {--}}
{{--            if (confirm('このスケジュールを削除してもよろしいですか？')) {--}}
{{--                window.location.href = 'http://' + window.location.host + '/schedule/delete/' + scheduleId;--}}
{{--            }--}}
{{--        }--}}

{{--        // $(document).ready(function () {--}}
{{--        //     //Chosen--}}
{{--        //     $(".multipleChosen").chosen({--}}
{{--        //         placeholder_text_multiple: "What's your rating" //placeholder--}}
{{--        //     });--}}
{{--        //     //Select2--}}
{{--        //     $(".multipleSelect2").select2({--}}
{{--        //         placeholder: "What's your rating" //placeholder--}}
{{--        //     });--}}
{{--        // })--}}
{{--        // })--}}
{{--        // ;--}}
{{--    </script>--}}
@endsection
