@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('asset/css/schedule.css') }}" rel="stylesheet">
@endpush
@section('style')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px;
        }
    </style>
@endsection
@section('content-header')
    スケジュール追加
@endsection
<head>
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
</head>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('schedule.store', ['option' => 'all']) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">スケジュール名 (*)</label>
                        </div>
                        <div class="col-md-8">
                          <input value="{{old('schedulename')}}" type="text" name="schedulename" class="form-control" placeholder="スケジュール名を入力して下さい" class="@error('schedulename') is-invalid @enderror">
                            @error('schedulename')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>

                    </div>
                    <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-6 col-form-label text-right">開始日</label>
                                <div class="col-sm-5" style="margin-left: 8px">
                                <input value="{{old('date')}}" type="date" name="date" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-5 col-form-label text-right">時間</label>
                                <div class="col-sm-5" >
                                <input value="{{old('date')}}" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">場所 (*)</label>
                        </div>
                        <div class="col-md-8">
                          <input value="{{old('location')}}" type="text" name="location" class="form-control" placeholder="場所を入力して下さい" class="@error('location') is-invalid @enderror">
                            @error('location')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlSelect1">担当者 (*)</label>
                        </div>
                        <div class="col-md-8">
                            <select name="person" class="form-control select2" style="width: 100%;">
                                <option selected disabled hidden></option>
                                @foreach($persons as $person)
                                    <option @if(old('person') == $person->id) selected @endif value="{{$person->id}}">{{$person->name}}</option>
                                @endforeach
                            </select>
                            @error('person')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>

                      

                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">レビュアー</label>
                        </div>
                        <div class="col-md-8">
                          <input value="{{old('schedulename')}}" type="text" name="schedulename" class="form-control" class="@error('schedulename') is-invalid @enderror">
                            @error('schedulename')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>
                      　  
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlTextarea1">詳細の情報</label>
                        </div>
                        <div class="col-md-8">
                          <textarea class="form-control" name="info" id="exampleFormControlTextarea1" rows="7">{{old('info')}}</textarea>
                            @error('info')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                      </div>
                    </div>
                    <div class="button">
                        <a href="{{route('schedule.index', ['option' => 'all'])}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endsection
