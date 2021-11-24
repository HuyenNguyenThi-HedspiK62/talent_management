@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('asset/css/schedule.css') }}" rel="stylesheet">
@endpush
@section('content-header')
    タレント編集
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
                <form action="{{ route('talent.update', $talent->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                              <label for="exampleFormControlInput1">名前　(*)</label>
                            </div>
                            <div class="col-md-8">
                              <input type="text" name="tname" class="form-control" id="exampleFormControlInput1" placeholder="名前を入力して下さい" value="{{$talent->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">メールアドレス　(*)</label>
                            </div>
                            <div class="col-md-8">
                              <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="メールアドレスを入力して下さい" value="{{ $talent->email }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">性　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" @if($talent->gender == 1) checked @endif>
                                    <label class="form-check-label" for="inlineRadio1">男</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" @if($talent->gender == 2) checked @endif>
                                    <label class="form-check-label" for="inlineRadio2">女</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" @if($talent->gender == 0) checked @endif>
                                    <label class="form-check-label" for="inlineRadio1">他の性</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">ロール　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" @if($talent->role == 0) checked @endif>
                                    <label class="form-check-label" for="inlineRadio1">管理者</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="role" @if($talent->role == 1) checked @endif>
                                    <label class="form-check-label" for="inlineRadio2">タレント</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">会社入日　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="date" class="form-control" id="exampleFormControlInput1" placeholder="MM/DD/YYYY" value="{{ $talent->join_company_date }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                            <label for="exampleFormControlTextarea1">詳細の情報</label>
                            </div>
                            <div class="col-md-8">
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="7">{{$talent->information}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" class="btn btn-danger" style="margin-right: 30px;">キャンセル</button>
                        <button type="submit" class="btn btn-success">編集</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection
