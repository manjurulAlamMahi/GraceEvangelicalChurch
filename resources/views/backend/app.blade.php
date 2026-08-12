<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Grace Evangelical Church admin panel — manage books, chapters, subscribers, and site content.">
    <meta name="keywords"
        content="Grace Evangelical Church, admin, CMS, church management">
    <meta name="author" content="Grace Evangelical Church">
    <title>@yield('title')</title>
    @include('backend.partials.style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    @include('backend.partials.header')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('backend.partials.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    {{-- <div class="sidenav-overlay"></div>
    <div class="drag-target"></div> --}}

    <!-- BEGIN: Footer-->
    @include('backend.partials.footer')
    <!--END: Footer-->
    @include('backend.partials.script')
</body>

</html>
