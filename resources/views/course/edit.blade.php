@extends('layouts.dashboard')
@section('content-header')
<div style="padding-bottom: 15px">
    <a style="color: black" href="{{ url()->previous() }}"><i class="fa fa-arrow-left" style="font-size:24px;"></i></a>
</div>
    コース編集
@endsection
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
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h4 class="mt-1 mr-3 d-inline">コース名</h4>
                    <p class="badge p-2 badge-success">未着手</p>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                                <input value="" type="text" class="bg-white form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース詳細</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="info" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-6">
                                    <input value="" type="date" class="bg-white form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-6">
                                    <input value="" type="date" class="bg-white form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">場所</label>
                                    <div class="col-sm-6">
                                        <input value="" type="text" class="bg-white form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-6">
                                        <input value="" type="time" class="bg-white form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                                <select name="person" class="form-control select2" style="width: 100%;">
                                    <option>Aさん</option>
                                    <option>Aさん</option>
                                    <option>Aさん</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-10">
                                <input value="100" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label text-left">タレント数（3名選んだ）</label>
                            <p>タレント1,タレント2、タレント３</p>
                        </div>
                        <div class="button">
                            <a href="{{route('talent.index')}}" class="btn btn-danger" style="margin-right: 30px;">キャンセル</a>
                            <button type="submit" class="btn btn-success">編集</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
<script>
    function deleteSchedule(scheduleId) {
        if (confirm('このスケジュールを削除してもよろしいですか？')) {
            window.location.href = 'http://' + window.location.host + '/schedule/delete/' + scheduleId;
        }
    }
</script>
@endsection