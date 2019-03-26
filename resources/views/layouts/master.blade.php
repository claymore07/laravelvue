<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="fa-IR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سامانه پژوهشی</title>

    <link  type="text/css"  href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body class="hold-transition sidebar-mini" style="direction: rtl">
<div class="wrapper"  id="app">

    <!-- Navbar -->
    <nav  class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <div class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input   class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar"  type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" style="align-self: center;">
                ترم فعال:
                <u><?php
                $term = \App\Term::whereStatus(1)->first();
                echo $term->name;
                    ?></u>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                        class="fa fa-th-large"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/dashboard" class="brand-link">
            <img src="{{asset('img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">سامانه پژوهشی</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img//profile/{{auth()->user()->photo}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->profile->Fname   }} {{ Auth::user()->profile->Lname }}</a>
                    @if(auth()->user()->type == 'admin')
                        <span style="color: white;">مسئول سیستم</span>
                    @elseif(auth()->user()->type == 'author')
                        <span style="color: white;">کارشناس سیستم</span>
                        @else
                        <span style="color: white;">کاربر</span>
                        @endif
                </div>
            </div>

            <!-- Sidebar Menu -->
           @include('layouts.sidebar')
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">خانه</a></li>
                            <li class="breadcrumb-item active">@{{this.pageName}}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6 text-right">
                        <h1 class="m-0 text-dark">سامانه جامع پژوهشی</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <router-view></router-view>

            <vue-progress-bar></vue-progress-bar>
            @yield('content')
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content11111111</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">

        </div>
        <!-- Default to the left -->
        <strong>کلیه حقوق متعلق به دانشگاه می باشد &copy; @{{ 1397|faDigit }}-@{{ 1398|faDigit }}</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@auth
    <script>
        window.user = @json(auth()->user()->load('profile'))
    </script>
@endauth
{{ Session::get('test') }}
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/FarsiType.js') }}"></script>


<script>

</script>
</body>
</html>
