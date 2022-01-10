@extends('layouts.dashboard')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
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
                @if(auth()->user()->role == 0)
                <div class="col-1 text-center">
                    <a href="{{ route('schedule.add') }}"><i class="fas fa-plus-circle fa-2x"></i></a>
                </div>
                @endif
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <table id="example2" class="table table-bordered table-hover text-center table-responsive-sm">
                        <thead style="background-color: #a0e4fc;">
                        <tr>
                            <th>スケジュール名</th>
                            <th>タレント</th>
                            <th>開始日</th>
                            <th width="8%">ステータス</th>
                            <th width="35%">場所</th>
                            @if(auth()->user()->role == 0)
                            <th>アクション</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php $option = Request::segment(2) @endphp
                        @foreach($schedules as $schedule)
                            @php $count = 0; @endphp
                            @foreach($schedule->users as $user)
                                @php $isDisplay = 0; @endphp
                                @if(
                                    ($option == 'not-started' && $user->pivot->status == 0) ||
                                    ($option == 'processing' && $user->pivot->status == 1) ||
                                    ($option == 'done' && $user->pivot->status == 2) ||
                                    ($option == 'interrupted' && $user->pivot->status == 3) ||
                                    ($option == 'all')
                                )
                                    @php $isDisplay = 1; @endphp
                                @endif
                                @if($isDisplay == 1)
                                    <tr>
                                        @if($count == 0)
                                        <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}';" style='cursor: pointer;'>
                                            {{ $schedule->schedule_name }}
                                        </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}';" style='cursor: pointer;'>{{ $user->name }}</td>
                                        <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}';" style='cursor: pointer;'>{{ $schedule->date }}</td>
                                        <td>
                                            <ul class="navbar-nav d-inline">
                                                <li class="nav-item dropdown">
                                                    <a id="navbarDropdown-{{$schedule->id}}-{{$user->id}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="margin-top: -10px">
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
                                                            @default
                                                            <p class="badge p-2 badge-success">未着手</p>
                                                            @break
                                                        @endswitch
                                                    </a>
                                                    @if(auth()->user()->role == 0)
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}},{{ $user->id }}, 0)">
                                                            <p class="badge p-2 badge-success">未着手</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}},{{ $user->id }}, 1)">
                                                            <p class="badge p-2 badge-warning">進行中</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}},{{ $user->id }}, 2)">
                                                            <p class="badge px-3 py-2 badge-info">完了</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}},{{ $user->id }}, 3)">
                                                            <p class="badge px-3 py-2 badge-danger">中断</p>
                                                        </a>
                                                    </div>
                                                    @endif
                                                </li>
                                            </ul>
                                        </td>
                                        @if($count == 0)
                                        <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id, 'userId' => $user->id])}}';" style='cursor: pointer;'>{{ $schedule->location }}</td>
                                            @if(auth()->user()->role == 0)
                                            <td style="font-size:20px;">
                                                <a style="color: black;" href="{{ route('schedule.edit', $schedule->id) }}"><i class="far fa-edit"></i></a>
                                                <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('本当に削除しますか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                            @endif
                                        @else
                                            @if(auth()->user()->role == 0)
                                            <td></td>
                                            @endif
                                            <td></td>
                                        @endif
                                        @php $count++ @endphp
                                    </tr>
                                @endif
                            @endforeach
                            @php $count = 0 @endphp
                        @endforeach

                        </tbody>
                    </table>
                    @if(count($schedules) === 0)<span class="d-block text-center p-3 font-weight-bold" style="margin-top: -16px; background-color: #e9ecef;">データが見つかりません</span>@endif
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

        function updateStatus(schedule_id, talent_id, status) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('schedule/update-status/')}}",
                type: "POST",
                data: {
                    schedule_id: schedule_id,
                    talent_id: talent_id,
                    status: status
                },
                success: function (success) {
                    let navbarDropdown = $(`#navbarDropdown-${schedule_id}-${talent_id}`)
                    navbarDropdown.find('p').remove()
                    switch(status) {
                        case 0:
                            navbarDropdown.append('<p class="badge p-2 badge-success">未着手</p>')
                            break;
                        case 1:
                            navbarDropdown.append('<p class="badge p-2 badge-warning">進行中</p>')
                            break;
                        case 2:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-info">完了</p>')
                            break;
                        case 3:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-danger">中断</p>')
                            break;
                    }

                },
                error: function (error) {
                    console.log(error)
                }
            });
        }
    </script>
@endsection
