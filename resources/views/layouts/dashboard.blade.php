<!DOCTYPE html>

<html lang="en" style="height: auto; margin-left: -10px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>タレント管理ツール</title>



    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
    @yield('style')
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        *{
            word-break: break-all;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" @if(auth()->user()->role == 1) style="margin-left: -250px" @endif>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
        <!-- Left navbar links -->
        @if(auth()->user()->role == 0)
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        @endif

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @if(auth()->user()->role == 0)
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">タレント管理ツール</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link @if(str_contains(request()->path(), 'manager') || str_contains(request()->path(), 'talent')) active @endif">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                ユーザー
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview ml-3">
                            <li class="nav-item">
                                <a href="{{ route('manager.index') }}" class="nav-link @if(str_contains(request()->path(), 'manager')) active @endif">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        マネジャー一覧
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('talent.index') }}" class="nav-link @if(str_contains(request()->path(), 'talent')) active @endif">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        タレント一覧
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('schedule.index', ['option' => 'all']) }}" class="nav-link @if(str_contains(request()->path(), 'schedule')) active @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                スケジュール一覧
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('course.index', ['option' => 'all'])}}" class="nav-link @if(str_contains(request()->path(), 'course')) active @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                コース一覧
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @endif

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">
                            @yield('content-header')
                        </h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- REQUIRED SCRIPTS -->
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
@yield('script')
</body>
