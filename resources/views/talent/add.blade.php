@extends('layouts.dashboard')
@push('styles')
    <link href="{{ asset('asset/css/schedule.css') }}" rel="stylesheet">
@endpush
@section('content-header')
    タレント追加
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
        display: flex;
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
                <form action="{{ route('talent.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">名前　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="tname" class="form-control" value="{{old('tname')}}" placeholder="名前を入力して下さい" class="@error('tname') is-invalid @enderror">
                                @error('tname')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">メールアドレス　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" name="email" class="form-control" value="{{old('email')}}" id="exampleFormControlInput1" placeholder="メールアドレスを入力して下さい" class="@error('email') is-invalid @enderror">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">パスワード　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" value="{{old('password')}}" name="password" class="form-control" id="exampleFormControlInput1" placeholder="パスワードを入力して下さい">
                                @error('password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
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
                                    <input class="form-check-input" @if(old('gender') === "1") checked @endif type="radio" name="gender" id="male" value="1" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio1">男</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @if(old('gender') === "2") checked @endif type="radio" name="gender" id="female" value="2" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">女</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @if(old('gender') === "0") checked @endif type="radio" name="gender" id="other" value="0" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">他の性</label>
                                </div>
                                @error('gender')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
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
                                    <input class="form-check-input" @if(old('role') === "0") checked @endif type="radio" name="role" id="manager" value="0" class="@error('role') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio1">管理者</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @if(old('role') === "1") checked @endif type="radio" name="role" id="talent" value="1" class="@error('role') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">タレント</label>
                                </div>
                                @error('role')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">会社入日　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="date" class="form-control" value="{{old('date')}}" id="exampleFormControlInput1" placeholder="MM/DD/YYYY" class="@error('date') is-invalid @enderror">
                                @error('date')
                                <span class="text-danger">{{$message}}</span>
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
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="7">{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="button">
                        <a href="{{route('talent.index')}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection
