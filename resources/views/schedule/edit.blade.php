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
    スケジュール編集
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
            <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3">
                      <label for="exampleFormControlInput1">スケジュール名 (*)</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" name="schedulename" value="@if(!$errors->isEmpty()) {{old('schedulename')}} @else {{ $schedule->schedule_name }} @endif" class="form-control" placeholder="スケジュール名を入力して下さい" class="@error('schedulename') is-invalid @enderror">
                        @error('schedulename')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                  </div>

                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3">
                      <label>開始日 (*)</label>
                    </div>
                    <div class="col-md-8">
                      <input type="date" name="date" value="@if(!$errors->isEmpty()){{old('date')}}@else{{$schedule->date}}@endif" class="form-control">
                        @error('date')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                  </div>

                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3">
                      <label for="exampleFormControlInput1">場所 (*)</label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" name="location" value="@if(!$errors->isEmpty()){{old('location')}}@else{{$schedule->location}}@endif" class="form-control" placeholder="場所を入力して下さい" class="@error('location') is-invalid @enderror">
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
                        @foreach($persons as $person)
                          <option @if(!$errors->isEmpty()) @if(old('person') == $person->id) selected @endif @elseif($schedule->users[0]->id == $person->id) selected @endif value="{{$person->id}}">{{$person->name}}</option>
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
                      <label for="exampleFormControlSelect1">ステータス (*)</label>
                    </div>
                    <div class="col-md-8">
                      <select class="form-control" name="status" id="exampleFormControlSelect2">
                        <option @if(!$errors->isEmpty()) @if(old('status') == 0) selected @endif @elseif($schedule->users[0]->pivot->status == 0) selected @endif value="0">未着手</option>
                        <option @if(!$errors->isEmpty()) @if(old('status') == 1) selected @endif @elseif($schedule->users[0]->pivot->status == 1) selected @endif value="1">進行中</option>
                        <option @if(!$errors->isEmpty()) @if(old('status') == 2) selected @endif @elseif($schedule->users[0]->pivot->status == 2) selected @endif value="2">完了</option>
                        <option @if(!$errors->isEmpty()) @if(old('status') == 3) selected @endif @elseif($schedule->users[0]->pivot->status == 3) selected @endif value="3">中断</option>
                      </select>
                    </div>
                  </div>

                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-3">
                      <label for="exampleFormControlTextarea1">詳細の情報</label>
                    </div>
                    <div class="col-md-8">
                      <textarea class="form-control" name="info" rows="7">@if(!$errors->isEmpty()){{old('info')}}@else{{$schedule->information}}@endif</textarea>
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
