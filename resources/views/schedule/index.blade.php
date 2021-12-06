@extends('layouts.dashboard')

@section('content-header')
    スケジュール一覧
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mb-4">
                    <a href="{{route('schedule.index', ['option' => 'all'])}}" class="btn btn-default">全て</a>
                    <a href="{{route('schedule.index', ['option' => 'not-started'])}}" class="btn text-white btn-success ml-2">未着手</a>
                    <a href="{{route('schedule.index', ['option' => 'processing'])}}" class="btn btn-warning ml-2">進行中</a>
                    <a href="{{route('schedule.index', ['option' => 'done'])}}" class="btn text-white btn-info ml-2">完了</a>
                    <a href="{{route('schedule.index', ['option' => 'interrupted'])}}" class="btn text-white btn-danger ml-2">中断</a>
                </div>
                <div class="col-2 offset-3">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span onclick="search()" class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input onkeypress="handleKeyPress(event)" id="text_search" type="text" class="form-control text-center" placeholder="検索">
                    </div>
                </div>
                <div class="col-1 text-center">
                    <a href="{{ route('schedule.add') }}"><i class="fas fa-plus-circle fa-2x"></i></a>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <table id="example2" class="table table-bordered table-hover text-center">
                        <thead style="background-color: #a0e4fc;">
                        <tr>
                            <th>スケジュール名</th>
                            <th>担当者</th>
                            <th>開始日</th>
                            <th>ステータス</th>
                            <th>場所</th>
                            <th>アクション</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $option = explode('/', Request::url())[4];
                        @endphp
                        @foreach($schedules as $schedule)
                            @foreach($schedule->users as $user)
                                @if($user->pivot->status == 0 && $option == 'not-started')
                                    <tr>
                                        <td>
                                            <a href="{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}">{{ $schedule->schedule_name }}</a>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>
                                            <p class="badge p-2 badge-success">未着手</p>
                                        </td>
                                        <td>{{ $schedule->location }}</td>
                                        <td style="font-size:20px;">
                                            <a><i class="far fa-edit"></i></a>
                                            <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('このスケジュールを削除してもよろしいですか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @elseif($user->pivot->status == 1 && $option == 'processing')
                                    <tr>
                                        <td>
                                            <a href="{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}">{{ $schedule->schedule_name }}</a>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>
                                            <p class="badge p-2 badge-warning">進行中</p>
                                        </td>
                                        <td>{{ $schedule->location }}</td>
                                        <td style="font-size:20px;">
                                            <a><i class="far fa-edit"></i></a>
                                            <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('このスケジュールを削除してもよろしいですか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @elseif($user->pivot->status == 2 && $option == 'done')
                                    <tr>
                                        <td>
                                            <a href="{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}">{{ $schedule->schedule_name }}</a>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>
                                            <p class="badge px-3 py-2 badge-info">完了</p>
                                        </td>
                                        <td>{{ $schedule->location }}</td>
                                        <td style="font-size:20px;">
                                            <a><i class="far fa-edit"></i></a>
                                            <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('このスケジュールを削除してもよろしいですか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @elseif($user->pivot->status == 3 && $option == 'interrupted')
                                    <tr>
                                        <td>
                                            <a href="{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}">{{ $schedule->schedule_name }}</a>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>
                                            <p class="badge px-3 py-2 badge-danger">中断</p>
                                        </td>
                                        <td>{{ $schedule->location }}</td>
                                        <td style="font-size:20px;">
                                            <a><i class="far fa-edit"></i></a>
                                            <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('このスケジュールを削除してもよろしいですか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @elseif($option == 'all')
                                    <tr>
                                        <td>
                                            <a href="{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}">{{ $schedule->schedule_name }}</a>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $schedule->date }}</td>
                                        <td>
                                            @switch($user->pivot->status)
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
                                        </td>
                                        <td>{{ $schedule->location }}</td>
                                        <td style="font-size:20px;">
                                            <a style="color: black;" href="{{ route('schedule.edit', $schedule->id) }}"><i class="far fa-edit"></i></a>
                                            <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('このスケジュールを削除してもよろしいですか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    <span class="d-flex justify-content-center">
                        {{ $schedules->links('pagination::bootstrap-4') }}
                    </span>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        function handleKeyPress(e){
            var key=e.keyCode || e.which;
            if (key==13){
                search();
            }
        }

        function search(){
            let textSearch = document.getElementById('text_search').value
            window.location.href = 'http://' + window.location.host + '/schedule/all?search=' + (textSearch);
        }
    </script>
@endsection
