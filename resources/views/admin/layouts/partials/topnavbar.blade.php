<div class="row border-bottom">
    <nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2" href=""><i class="fa fa-bars"></i> </a>
            <span class="navbar-brand hidden-xs">
                <span class="navbar-logo">
                    <a href="/" target="_blank"><span class="text-danger">{{ config('app.name')}}</span></a>
                    <a href="/control"><small>Control Panel</small></a>
                </span> 
            </span>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{$currentUser->avatar}}" alt="{{$currentUser->fullname}}" title="{{$currentUser->fullname}}" height="30px" class="img-circle">
                    <span class="hidden-xs">{{$currentUser->fullname}}</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="/control/user/{{$currentUser->username}}/edit">My Profile</a></li>
                    <!--<li><a href="javascript:;">Setting</a></li>-->
                    <li class="divider"></li>
                    <li>
                        <a href="{{route('logout')}}" data-redirect="post">
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>