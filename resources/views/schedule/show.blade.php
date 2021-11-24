@extends('layouts.dashboard')

@section('content-header')
    スケジュール詳細
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h4 class="mt-1 mr-3 d-inline">{{ $schedule->schedule_name }}</h4>
                    @switch($schedule->users[0]->pivot->status)
                        @case(0)
                        <p class="badge p-2 badge-success">未着手</p>
                        @break
                        @case(1)
                        <p class="badge p-2 badge-warning">進行中</p>
                        @break
                        @case(2)
                        <p class="badge px-3 py-2 badge-info">完了</p>
                        @break
                        @case(3)
                        <p class="badge px-3 py-2 badge-danger">中断</p>
                        @break
                    @endswitch
                </div>
                <div class="col-2 offset-4 text-right pr-3">
                    <div style="font-size:20px;">
                        <a style="color: black;" href="{{ route('schedule.edit', $schedule->id) }}"><i class="far fa-edit"></i></a>
                        <a onclick="deleteSchedule({{$schedule->id}})" class="pl-2"><i class="far fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-10 offset-1">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">スケジュール名</label>
                            <div class="col-sm-10">
                                <input value="{{ $schedule->schedule_name }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">開始日</label>
                            <div class="col-sm-10">
                                <input value="{{ $schedule->date }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">場所</label>
                            <div class="col-sm-10">
                                <input value="{{ $schedule->location }}" disabled type="text" class="bg-white form-control text-center">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">担当者</label>
                            <div class="col-sm-10">
                                <input disabled type="text" class="bg-white form-control text-center" value="{{$schedule->users[0]->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">詳細の情報</label>
                            <div class="col-sm-10">
                                <textarea disabled class="bg-white text-center form-control" rows="3">
                                    {{$schedule->information}}
                                </textarea>
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
        if (confirm('want to delete')) {
            window.location.href = 'http://' + window.location.host + '/schedule/delete/' + scheduleId;
        }
    }
</script>
@endsection
