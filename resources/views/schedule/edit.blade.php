@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('asset/css/schedule.css') }}" rel="stylesheet">
@endpush
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
                      <input type="text" name="schedulename" value="{{ $schedule->schedule_name }}" class="form-control" placeholder="スケジュール名を入力して下さい" class="@error('schedulename') is-invalid @enderror">
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
                      <input type="date" name="date" value="{{ $schedule->date }}" class="form-control" id="exampleFormControlInput1" class="@error('date') is-invalid @enderror">
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
                      <input type="text" name="location" value="{{ $schedule->location }}" class="form-control" placeholder="場所を入力して下さい" class="@error('location') is-invalid @enderror">
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
                      <select class="form-control" name="person" class="@error('person') is-invalid @enderror">
                        <option value = "{{$schedule->users[0]->id}}">{{$schedule->users[0]->name}}</option>
                        @foreach($persons as $person)
                          <option value="{{$person->id}}">{{$person->name}}</option>
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
                      <label for="exampleFormControlSelect1">ステータス (*)</label>
                    </div>
                    <div class="col-md-8">
                      <select class="form-control" name="status" id="exampleFormControlSelect2">
                        <option @if($schedule->users[0]->pivot->status == 0) selected @endif value="0">未着手</option>
                        <option @if($schedule->users[0]->pivot->status == 1) selected @endif value="1">進行中</option>
                        <option @if($schedule->users[0]->pivot->status == 2) selected @endif value="2">完了</option>
                        <option @if($schedule->users[0]->pivot->status == 3) selected @endif value="3">中断</option>
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
                      <textarea class="form-control" name="info" value="{{ $schedule->information }}" rows="7">{{ $schedule->information }}</textarea>
                    </div>
                  </div>
                </div>
                <div class="button">
                  <a href="{{route('schedule.index', ['option' => 'all'])}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                  <button type="submit" class="btn btn-success">編集</button>
                </div>
              </form>
        </div>
    </div>
  </div>
@endsection
