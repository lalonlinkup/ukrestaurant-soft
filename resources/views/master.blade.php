<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>@yield('title')</title>

    <meta name="description" content="Static &amp; Dynamic Tables" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- bootstrap & fontawesome -->
    <script src="{{asset('backend')}}/js/vue/vue.js"></script>
    <link rel="stylesheet" href="{{asset('backend')}}/css/selectize.default.min.css">

    <link rel="stylesheet" href="{{asset('backend')}}/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{asset('backend')}}/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{asset('backend')}}/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{asset('backend')}}/css/ace.min.css" />
    <link rel="stylesheet" href="{{asset('backend')}}/css/responsive.css" />

    <link rel="stylesheet" href="{{asset('backend')}}/css/style.css" />
    <link rel="stylesheet" href="{{asset('backend')}}/css/ace-skins.min.css" />
    <script src="{{asset('backend')}}/js/jquery-2.1.4.min.js"></script>
    <link href="{{asset('backend')}}/css/toastr.min.css" rel="stylesheet" />

    @include('layouts.dashboard_style')
    <link rel="icon" type="image/x-icon" href="{{asset($company->favicon ? $company->favicon : '/noImage.gif')}}">
    @stack('style')
    <link href="{{asset('backend')}}/css/vue-select.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="skin-2">
    <div class="preloader">
        <img src="{{asset('loading.gif')}}" alt="Loading...">Loading...
    </div>

    @include('layouts.navbar')

    <div class="main-container ace-save-state" id="main-container">
        <div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed sidebar-scroll">
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <a href="/graph" class="btn btn-success">
                        <i class="ace-icon fa fa-signal"></i>
                    </a>

                    <a href="/module/AccountsModule" class="btn btn-info">
                        <i style="color: #fff;border: none;" class="ace-icon fa fa-pencil"></i>
                    </a>

                    <a href="/module/HRPayroll" class="btn btn-warning">
                        <i class="ace-icon fa fa-users"></i>
                    </a>

                    <a href="/module/Administration" class="btn btn-danger">
                        <i class="ace-icon fa fa-cogs"></i>
                    </a>
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- /.sidebar-shortcuts -->

            @include('layouts.sidebar')

            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>
        </div>

        <div class="main-content">
            <div class="main-content-inner">
                <div class="customScroll">
                    <div class="main-content-navbar menuItem"></div>
                </div>
                <!-- <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <a style="color: #fff;" href="/clear-cache"><i class="ace-icon fa fa-home home-icon"></i></a>
                            <a style="color: #fff;" href="{{route('dashboard')}}">Home</a>
                        </li>
                        <li>
                            <a style="color: #fff;" href="#">@yield('breadcrumb_title')</a>
                        </li>
                    </ul>

                    <div class="nav-search" id="nav-search">
                        <span style="font-weight: bold; color: #fff; font-size: 16px;">
                            {{$company->title}}
                        </span>
                    </div>
                </div> -->

                <div class="page-content">
                    <div id="loader" hidden style="position: fixed; z-index: 1000; margin: auto; height: 100%; width: 100%; background:rgba(255, 255, 255, 0.72);;">
                        <img src="" style="top: 30%; left: 50%; opacity: 1; position: fixed;">
                    </div>

                    @yield('content')

                </div>
                <div class="row" style="display:none;">
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    </table>
                </div>
            </div>
        </div><!-- /.main-content -->

        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content">
                    <div class="row">
                        <div class="col-md-9" style="padding-right: 0;">
                            <marquee scrollamount="2" onmouseover="this.stop();" onmouseout="this.start();" direction="left" height="30" style="padding-top: 3px;color: red;margin-bottom: -10px;font-size: 15px;" id="linkup_api">Please Call for Support : 01981-800200, Billing Issue : 01911-978897</marquee>
                        </div>
                        <div class="col-md-3" style="padding: 4px 0;background-color: #3e2e6b;color:white; margin-bottom: -1px;">
                            <span style="font-size: 12px;">
                                Developed by <span class="blue bolder"><a href="https://srsidea.biz/" target="_blank" style="color: white;text-decoration: underline;font-weight: normal;">SRS Idea Ltd.</a></span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>

    @include("layouts.shortcutModal")

    @include("layouts.script")
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#organizationChange").selectize({
            onChange: id => {
                if (id) {
                    location.href = "/organization/" + id;
                }
            }
        });
    </script>

    <script>
        var menuArr = [];

        function showMenu() {
            menuArr = JSON.parse(localStorage.getItem('menus')) == null ? [] : JSON.parse(localStorage.getItem('menus'));
            if (menuArr == null) {
                menuArr = [];
            }
            let menuUrl = "";
            $.each(menuArr, (index, val) => {
                menuUrl += "<a href='/" + val.url + "'>" + val.value + "</a>"
            })

            let menuHtml = `
                    <a href="/module/dashboard">Dashboard</a>
                    ${menuUrl}
                    <a onclick="shortcutMenuModal()"><i class="bi bi-plus-circle"></i></a>

            `;

            $(".menuItem").html(menuHtml);

        }
        showMenu();

        function shortcutMenuModal() {
            menuArr = JSON.parse(localStorage.getItem('menus')) == null ? [] : JSON.parse(localStorage.getItem('menus'));
            $("#shortcutMenuModal").modal("show");
            if (menuArr != null) {
                $.each(menuArr, (index, val) => {
                    $("#shortcutMenuModal").find('#' + val.url).prop("checked", true);
                })
            }
        }

        function singleCheck(event) {
            let menu = event.target.value.split(',')
            let menuItem = {
                url: menu[0],
                value: menu[1].trim()
            }
            if (event.target.checked) {
                menuArr.push(menuItem);
            } else {
                let findInd = menuArr.findIndex(item => item.url == menuItem.url);
                menuArr.splice(findInd, 1);
            }
            let checkMenu = JSON.parse(localStorage.getItem('menus'));
            if (checkMenu != null) {
                localStorage.removeItem('menus');
            }
            localStorage.setItem('menus', JSON.stringify(menuArr));

            showMenu();
        }
    </script>
</body>

</html>