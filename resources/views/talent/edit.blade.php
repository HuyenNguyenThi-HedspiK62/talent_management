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
        padding-right: 75px;
        }
    </style>
</head>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('talent.update',  ['id' => $talent->id,'option' => 'all']) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                              <label for="exampleFormControlInput1">名前　(*)</label>
                            </div>
                            <div class="col-md-8">
                              <input type="text" name="tname" class="form-control" id="exampleFormControlInput1" placeholder="名前を入力して下さい" value="@if(!$errors->isEmpty()){{old('tname')}}@else{{$talent->name}}@endif" class="@error('tname') is-invalid @enderror">
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
                              <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="メールアドレスを入力して下さい" value="@if(!$errors->isEmpty()){{old('email')}}@else{{$talent->email}}@endif" class="@error('email') is-invalid @enderror">
                                @error('email')
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
                                    <input class="form-check-input" type="radio" name="gender" value="1" @if(!$errors->isEmpty()) @if(old('gender') == 1) checked @endif @elseif($talent->gender == 1) checked @endif id="male" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio1">男</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="2" @if(!$errors->isEmpty()) @if(old('gender') == 2) checked @endif @elseif($talent->gender == 2) checked @endif id="female" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio2">女</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="0" @if(!$errors->isEmpty()) @if(old('gender') == 0) checked @endif @elseif($talent->gender == 0) checked @endif id="other" class="@error('gender') is-invalid @enderror">
                                    <label class="form-check-label" for="inlineRadio1">他の性</label>
                                </div>
                            </div>
                            @error('gender')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">会社入日　(*)</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="date" class="form-control" id="exampleFormControlInput1" placeholder="MM/DD/YYYY" value="@if(!$errors->isEmpty()){{old('date')}}@else{{$talent->join_company_date}}@endif" class="@error('date') is-invalid @enderror">
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
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="7">@if(!$errors->isEmpty()){{old('description')}}@else{{$talent->information}}@endif</textarea>
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
