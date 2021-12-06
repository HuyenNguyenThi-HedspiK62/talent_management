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
                            <span class="text-danger">スケジュール名を入力して下さい</span>
                            @enderror
                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlInput1">開始日 (*)</label>
                        </div>
                        <div class="col-md-8">
                          <input value="{{old('date')}}" type="date" name="date" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
                            @error('date')
                            <span class="text-danger">開始日を入力して下さい</span>
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
                          <input value="{{old('location')}}" type="text" name="location" class="form-control" placeholder="場所を入力して下さい" class="@error('location') is-invalid @enderror">
                            @error('location')
                            <span class="text-danger">場所を入力して下さい</span>
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
                          <select class="form-control" name="person" id="exampleFormControlSelect2" class="@error('person') is-invalid @enderror">
                            <option selected disabled>担当者</option>
                            @foreach($persons as $person)
                                  <option @if(old('person') == $person->id) selected @endif value="{{$person->id}}">{{$person->name}}</option>
                              @endforeach
                          </select>
                            @error('person')
                                <span class="text-danger">担当者を入力して下さい</span>
                            @enderror
                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-3">
                          <label for="exampleFormControlTextarea1">詳細の情報</label>
                        </div>
                        <div class="col-md-8">
                          <textarea class="form-control" name="info" id="exampleFormControlTextarea1" rows="7">{{old('info')}}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="button">
                        <a href="{{route('schedule.index', ['option' => 'all'])}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                        <button type="submit" class="btn btn-success">保存する</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection
