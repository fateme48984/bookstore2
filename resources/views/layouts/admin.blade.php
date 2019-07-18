<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'پنل مدیریت | معرفی کتاب') }}</title>
    <script src="{{ asset('js/app.js') }}" ></script>

    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet"  type="text/css" >
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet"  type="text/css" >
    <link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet" type="text/css" >



<!-- Scripts -->
{{--
    <script src="{{ asset('js/app.js') }}" defer></script>
--}}


    <!-- Styles -->
{{--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
--}}
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" target="_blank" class="nav-link">خانه</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ ('خروج') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        {{--    <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">تماس</a>
            </li>--}}
        </ul>

        <!-- SEARCH FORM -->
    {{--    <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>--}}

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">



        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">


        <!-- Sidebar -->
        <div class="sidebar">
            <div>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/images/authors/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>
 
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->



                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/user')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/user')active @endif">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    مدیریت کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('user.list') }}" class="nav-link @if(\Request::route()->getName() == 'user.list' || \Request::route()->getName() == 'user.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.create') }}" class="nav-link @if(\Request::route()->getName() == 'user.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>کاربر جدید</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/book')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/book')active @endif">
                                <i class="nav-icon fa fa-book"></i>
                                <p>
                                  مدیریت کتاب ها
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('book.list') }}" class="nav-link @if(\Request::route()->getName() == 'book.list' || \Request::route()->getName() == 'book.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کتاب ها</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('book.create') }}" class="nav-link @if(\Request::route()->getName() == 'book.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>کتاب جدید</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/author')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/author')active @endif">
                                <i class="nav-icon fa fa-pencil"></i>
                                <p>
                                    مدیریت نویسندگان
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('author.list') }}" class="nav-link @if(\Request::route()->getName() == 'author.list' || \Request::route()->getName() == 'author.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست نویسندگان</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('author.create') }}" class="nav-link @if( \Request::route()->getName() == 'author.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نویسنده جدید</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/category')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/category')active @endif">
                                <i class="nav-icon fa fa-list"></i>
                                <p>
                                    مدیریت موضوعات
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('category.list') }}" class="nav-link  @if(\Request::route()->getName() == 'category.list' || \Request::route()->getName() == 'category.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست موضوعات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('category.create') }}" class="nav-link  @if(\Request::route()->getName() == 'category.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>موضوع جدید</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/translator')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/translator')active @endif">
                                <i class="nav-icon fa fa-language"></i>
                                <p>
                                  مدیریت مترجم ها
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('translator.list') }}" class="nav-link  @if(\Request::route()->getName() == 'translator.list' || \Request::route()->getName() == 'translator.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست مترجمین </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('translator.create') }}" class="nav-link  @if(\Request::route()->getName() == 'translator.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>مترجم جدید</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/publisher')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/publisher')active @endif">
                                <i class="nav-icon fa fa-newspaper-o"></i>
                                <p>
                                    مدیریت انتشارات
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('publisher.list') }}" class="nav-link  @if(\Request::route()->getName() == 'publisher.list' || \Request::route()->getName() == 'publisher.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست ناشران</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('publisher.create') }}" class="nav-link  @if(\Request::route()->getName() == 'publisher.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>ناشر جدید</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview @if(\Request::route()->getPrefix() == '/slider')menu-open @endif">
                            <a href="#" class="nav-link @if(\Request::route()->getPrefix() == '/slider')active @endif">
                                <i class="nav-icon fa fa-stack-exchange"></i>
                                <p>
                                    مدیریت محتوا
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('slider.list') }}" class="nav-link  @if(\Request::route()->getName() == 'slider.list' || \Request::route()->getName() == 'slider.edit')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست محتوا</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('slider.create') }}" class="nav-link  @if(\Request::route()->getName() == 'slider.create')active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>محتوای جدید</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview @if(\Route::current()->uri() == 'setting/{id}/edit' )menu-open @endif">
                            <a href="#" class="nav-link @if(\Route::current()->uri() == 'setting/{id}/edit' )active @endif">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>
                                  تنظیمات
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('setting.edit' , 1) }}" class="nav-link  @if(\Route::current()->uri() == 'setting/{id}/edit' && \Route::current()->parameter['id'] == 1)active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>درباره ما</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('setting.edit' , 2) }}" class="nav-link  @if(\Route::current()->uri() == 'setting/{id}/edit' && \Route::current()->parameter['id'] == 2)active @endif">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>تماس با ما</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
        </div>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        <div class="content-header">
        {{--    <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">داشبورد دوم</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">خانه</a></li>
                            <li class="breadcrumb-item active">داشبورد دوم</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>--}}<!-- /.container-fluid -->
        </div>


        <section class="content">
            <div class="container-fluid">
                @yield('content')
             </div>
        </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
{{--    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-sm-none d-md-block">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>CopyLeft &copy; 2018 <a href="http://github.com/fateme48984/">فاطمه یعقوبی</a>.</strong>
    </footer>--}}

</div>

<script src="{{ asset('js/jquery.min.js') }}" ></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" ></script>
<script src="{{ asset('js/adminlte.js') }}" ></script>
<script src="{{ asset('js/admin.js') }}" ></script>

</body>
</html>