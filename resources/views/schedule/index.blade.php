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
                            <th width="12%">ステータス</th>
                            <th width="35%">場所</th>
                            @if(auth()->user()->role == 0)
                            <th>アクション</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id])}}';" style='cursor: pointer;'>
                                    {{ $schedule->schedule_name }}
                                </td>
                                @php
                                    $fullTalent = '';
                                @endphp
                                @for($i = 0; $i < count($schedule->users); $i++)
                                    @if($i == count($schedule->users) - 1)
                                        @php $fullTalent = $fullTalent.$schedule->users[$i]->name @endphp
                                    @else
                                        @php $fullTalent = $fullTalent.$schedule->users[$i]->name.'、' @endphp
                                    @endif
                                @endfor
                                <td data-html="true" data-toggle="tooltip" title="<h5>{{ $fullTalent }}</h5>" onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id])}}';" style='cursor: pointer;'>@if(strlen($fullTalent) > 25){{ substr($fullTalent, 0, 25) }}...@else {{ $fullTalent }} @endif</td>
                                <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id])}}';" style='cursor: pointer;'>{{ $schedule->date }}</td>
                                <td>
                                    <ul class="navbar-nav d-inline">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown-{{$schedule->id}}" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="margin-top: -10px">
                                                @switch($schedule->status)
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
                                            @if(auth()->user()->role == 0 && ($schedule->status == 0 || $schedule->status == 1))
                                                <div id="changeStatus-{{ $schedule->id }}" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                    @switch($schedule->status)
                                                        @case(0)
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 1)">
                                                            <p class="badge p-2 badge-warning">進行中</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 2)">
                                                            <p class="badge px-3 py-2 badge-info">完了</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 3)">
                                                            <p class="badge px-3 py-2 badge-danger">中断</p>
                                                        </a>
                                                        @break
                                                        @case(1)
{{--                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 0)">--}}
{{--                                                            <p class="badge p-2 badge-success">未着手</p>--}}
{{--                                                        </a>--}}
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 2)">
                                                            <p class="badge px-3 py-2 badge-info">完了</p>
                                                        </a>
                                                        <a class="dropdown-item text-center" onclick="updateStatus({{$schedule->id}}, 3)">
                                                            <p class="badge px-3 py-2 badge-danger">中断</p>
                                                        </a>
                                                        @break
                                                    @endswitch
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                </td>
                                <td onclick="window.location.href = '{{route('schedule.show', ['scheduleId' => $schedule->id])}}';" style='cursor: pointer;'>{{ $schedule->location }}</td>
                                @if(auth()->user()->role == 0)
                                    <td style="font-size:20px;">
                                        <a style="color: black;" href="{{ route('schedule.edit', $schedule->id) }}"><i class="far fa-edit"></i></a>
                                        <a href="{{ route("schedule.delete", ['scheduleId' => $schedule->id]) }}" onclick="return confirm('本当に削除しますか？');" class="pl-2"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                @endif
                            </tr>
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

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

        function updateStatus(schedule_id, status) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('schedule/update-status/')}}",
                type: "POST",
                data: {
                    schedule_id: schedule_id,
                    status: status
                },
                success: function (success) {
                    let navbarDropdown = $(`#navbarDropdown-${schedule_id}`)
                    navbarDropdown.find('p').remove()
                    //change status
                    let changeStatus = $(`#changeStatus-${success}`)
                    changeStatus.find('a').remove()
                    switch(status) {
                        case 0:
                            navbarDropdown.append('<p class="badge p-2 badge-success">未着手</p>')
                            //change status
                            changeStatus.append('<a class="dropdown-item text-center" onclick="updateStatus('+ success +', 1)">\n' +
                                '                                                            <p class="badge p-2 badge-warning">進行中</p>\n' +
                                '                                                        </a>')
                            changeStatus.append('<a class="dropdown-item text-center" onclick="updateStatus('+ success +', 2)">\n' +
                                '                                                            <p class="badge px-3 py-2 badge-info">完了</p>\n' +
                                '                                                        </a>')
                            changeStatus.append('<a class="dropdown-item text-center" onclick="updateStatus('+ success +', 3)">\n' +
                                '                                                            <p class="badge px-3 py-2 badge-danger">中断</p>\n' +
                                '                                                        </a>')
                            break;
                        case 1:
                            navbarDropdown.append('<p class="badge p-2 badge-warning">進行中</p>')
                            //change status
                            changeStatus.append('<a class="dropdown-item text-center" onclick="updateStatus('+ success +', 2)">\n' +
                                '                                                            <p class="badge px-3 py-2 badge-info">完了</p>\n' +
                                '                                                        </a>')
                            changeStatus.append('<a class="dropdown-item text-center" onclick="updateStatus('+ success +', 3)">\n' +
                                '                                                            <p class="badge px-3 py-2 badge-danger">中断</p>\n' +
                                '                                                        </a>')
                            break;
                        case 2:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-info">完了</p>')
                            //change status
                            changeStatus.addClass('d-none')
                            break;
                        case 3:
                            navbarDropdown.append('<p class="badge px-3 py-2 badge-danger">中断</p>')
                            //change status
                            changeStatus.addClass('d-none')
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
