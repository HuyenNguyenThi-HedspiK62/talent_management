@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('asset/css/schedule.css') }}" rel="stylesheet">
@endpush
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
    }
  </style>
</head>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('schedule.store') }}" method="POST" enctype="multipart/form-data" {{ csrf_field() }}>
                  @csrf
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">スケジュール名</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="schedulename" class="form-control" placeholder="スケジュール名を入力して下さい">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">開始日</label>
                        </div>
                        <div class="col-md-9">
                          <input type="date" name="date" class="form-control" id="exampleFormControlInput1">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">場所</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="location" class="form-control" placeholder="場所を入力して下さい">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlSelect1">担当者</label>
                        </div>
                        <div class="col-md-9">
                          <select class="form-control" name="person" id="exampleFormControlSelect2">
                            <option>担当者:</option>
                            @foreach($persons as $person)
					                    <option value="{{$person->name}}">{{$person->name}}</option>
					                  @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlTextarea1">詳細の情報</label>
                        </div>
                        <div class="col-md-9">
                          <textarea class="form-control" name="info" id="exampleFormControlTextarea1" rows="7"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="button">
                        <button type="submit" class="btn btn-danger" style="margin-right: 30px;">キャンセル</button>
                        <button type="submit" class="btn btn-success">登記</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection
