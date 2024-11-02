<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top" style="background:#3e2e6b !important;">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="/module/dashboard" class="navbar-brand" style="padding-left: 0;">
                <small>
                    <img style="width: 25px;border: 1px solid gray;" src="{{asset($company->logo ? $company->logo : '/noImage.gif')}}" alt="">
                    <span style="color:#000;font-weight:700;letter-spacing:1px;font-size:16px;"> </span>
                    {{$company->title}}
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="clock_li">
                    <a class="clock" style="background:#3e2e6b !important;">
                        <span style="font-size:20px;"><i class="ace-icon fa fa-clock-o"></i></span> <span style="font-size:15px;"><?php date_default_timezone_set('Asia/Dhaka');echo date("l, d F Y"); ?>,&nbsp;<span id="timer" style="font-size:15px;"></span></span>
                    </a>
                </li>



                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset(auth()->user()->image != null ? auth()->user()->image: '/no-userimage.png')}}" alt="{{auth()->user()->name}}" />
                        <span class="user-info">
                            <small>Welcome,</small>
                            {{auth()->user()->name}}
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="/user-profile">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{route('user.logout')}}">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>