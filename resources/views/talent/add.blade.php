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
                                <input type="text" name="tname" class="form-control" placeholder="名前を入力して下さい" class="@error('tname') is-invalid @enderror">
                            </div>
                        </div>
                        @error('tname')
                            <div class="alert alert-danger">名前を入力して下さい</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">メールアドレス　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="メールアドレスを入力して下さい" class="@error('email') is-invalid @enderror">
                            </div>
                        </div>
                        @error('email')
                            <div class="alert alert-danger">メールアドレスをもう一度入力して下さい</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1">パスワード　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="パスワードを入力して下さい">
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
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="1" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio1">男</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="2" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">女</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="0" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">他の性</label>
                                </div>
                            </div>
                        </div>
                        @error('gender')
                            <div class="alert alert-danger">性を入力して下さい</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">会社入日　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="date" class="form-control" id="exampleFormControlInput1" placeholder="MM/DD/YYYY" class="@error('date') is-invalid @enderror">
                            </div>
                        </div>
                        @error('date')
                            <div class="alert alert-danger">会社入日を入力して下さい</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                            <label for="exampleFormControlTextarea1">詳細の情報</label>
                            </div>
                            <div class="col-md-8">
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="button">
                        <a href="{{route('talent.index')}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                        <button type="submit" class="btn btn-success">登記</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
@endsection
