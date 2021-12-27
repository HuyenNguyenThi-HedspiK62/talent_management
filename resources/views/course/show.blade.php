@extends('layouts.dashboard')
@section('content-header')
<div style="padding-bottom: 15px">
    <a style="color: black" href="{{ url()->previous() }}"><i class="fa fa-arrow-left" style="font-size:24px;"></i></a>
</div>
    コース詳細
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h4 class="mt-1 mr-3 d-inline">コース名</h4>
                    <p class="badge p-2 badge-success">未着手</p>
                </div>
                <div class="col-2 offset-4 text-right pr-3">
                    <div style="font-size:20px;">
                        <a style="color: black;"><i class="far fa-edit"></i></a>
                        <a class="pl-2"><i class="far fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">コース名</label>
                            <div class="col-sm-10">
                                <input value="コース名kkkkk" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">開始日</label>
                                <div class="col-sm-6">
                                    <input value="2021/12/21" disabled type="text" class="bg-white form-control text-center">
                                </div>
                            </div>
                            <div class="col-sm-6 row">
                                <label class="col-sm-4 col-form-label text-right">終了日</label>
                                <div class="col-sm-6">
                                    <input value="2021/12/21" disabled type="text" class="bg-white form-control text-center">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">場所</label>
                                    <div class="col-sm-6">
                                        <input value="Ha Noi" disabled type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <label class="col-sm-4 col-form-label text-right">時間</label>
                                    <div class="col-sm-6">
                                        <input value="10:00 - 12:00" disabled type="text" class="bg-white form-control text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                                <input value="Aさん" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">成績満点</label>
                            <div class="col-sm-10">
                                <input value="100" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label text-left">タレント数（3名）</label>
                            <p>タレント1,タレント2、タレント３</p>
                            <div class="row" style="border-top: 1px solid black; padding: 40px 0px 30px 0px">
                                <div class="col-md-6">
                                    <h2>成績管理</h2>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <button type="button" class="btn btn-primary">成績入力</button>
                                </div>
                            </div>
                            <div>
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <thead style="background-color: #a0e4fc;">
                                        <tr>
                                            <th>名前</th>
                                            <th>成績</th>
                                            <th>コメント</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>タレント1</td>
                                            <td>1/100</td>
                                            <td>Khi an vao nut nhap thanh tich thi chuyen den form nhap thanh tich ben duoi</td>
                                        </tr>
                                        <tr>
                                            <td>タレント2</td>
                                            <td>1/100</td>
                                            <td>Khi an vao nut nhap thanh tich thi chuyen den form nhap thanh tich ben duoi</td>
                                        </tr>
                                        <tr>
                                            <td>タレント3</td>
                                            <td>1/100</td>
                                            <td>Khi an vao nut nhap thanh tich thi chuyen den form nhap thanh tich ben duoi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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