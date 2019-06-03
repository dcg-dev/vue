<header id="header-navbar" class="content-mini content-mini-full">
    <div class="content-boxed">
        <!-- Header Navigation Right -->
        <ul class="nav-header pull-right push-30-r">
            @if(!in_array(Route::current()->getName(), ['dashboard', 'items', 'category']))
                <li>
                    <form method="get" id="search-form" action="/items">
                        <input class="form-control" name="q" placeholder="Search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </li>
            @endif
            @if($currentUser && $currentUser->isAdmin())
                <li>
                    <a href="{{route('admin.dashboard')}}"
                       class="font-w400 push-10-l btn btn-danger btn-outline btn-rounded" target="__blank">
                        Control Panel
                    </a>
                </li>
            @endif
            @if(!$currentUser)
                <li class="hidden-xs">
                    <a href="{{route('start_selling')}}"
                       class="font-w400 push-10-l btn btn-success-modern-register btn-outline btn-rounded">Start
                        selling</a>
                </li>
            @endif
            <li id="checkout-cart-icon">
                <a class="cart-icon btn btn-outline text-right text-right" data-action="#" type="button"
                   href="{{ route('checkout') }}">
                    <span class="badge badge-primary badge-xs pull-right"
                          v-text="cart && cart.info.items.length ? cart.info.items.length  : ''"></span><i
                            class="fa fa-shopping-cart"></i>
                </a>
            </li>
            @if($currentUser)
                <li id="profile-notifications-icon">
                    <a class="btn btn-outline text-left" href="{{ route('profile.notifications') }}" data-action="#"
                       type="button">
                        <span class="badge badge-success badge-xs pull-right"
                              v-if="currentUser && currentUser.attributes.count_notifications"
                              v-text="currentUser.attributes.count_notifications"></span><i
                                class="fa fa-bell-o"></i>
                    </a>
                </li>
                <li>
                    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                    <div class="btn-group">
                        <button class="btn btn-outline btn-image dropdown-toggle" data-toggle="dropdown" type="button"
                                aria-expanded="false">
                            <img src="{{$currentUser->avatar}}" alt="{{$currentUser->fullname}}">
                            <span class="caret rounded text-white"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">

                            <li>
                                <a tabindex="-1" href="{{ route('profile.edit') }}">
                                    <i class="si si-user pull-right text-gray"></i>
                                    <span class="text-gray-dark">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{ route('profile.inbox') }}">
                                    <i class="si si-envelope{{ $currentUser->inboxCount() > 0 ? '-open' : '' }} pull-right text-gray"></i>
                                    <?php if($currentUser->inboxCount() > 0) : ?>
                                    <span class="badge badge-primary pull-right">{{ $currentUser->inboxCount()  }}</span>
                                    <?php endif ?>
                                    <span class="text-gray-dark">Inbox</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{ route('profile.settings') }}">
                                    <i class="si si-settings pull-right text-gray"></i><span class="text-gray-dark">Settings</span>
                                </a>
                            </li>
                            <li class="text-gray-dark">
                                <a tabindex="-1" href="{{ route('profile.downloads') }}">
                                    <i class="si si-cloud-download pull-right text-gray"></i><span
                                            class="text-gray-dark">Downloads</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{ route('profile.affiliate.sales') }}">
                                    <i class="fa fa-money pull-right text-gray"></i><span class="text-gray-dark">Affiliate Sales</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{route('profile.item.favourites')}}">
                                    <i class="si si-heart pull-right text-gray"></i><span class="text-gray-dark">Favourites</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1"
                                   href="{{route('user.collections', ['user' => $currentUser->username])}}">
                                    <i class="fa fa-archive pull-right text-gray"></i><span class="text-gray-dark">Collections</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{route('feed')}}">
                                    <i class="si si-feed pull-right text-gray"></i><span class="text-gray-dark">Follow Feed</span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a tabindex="-1" href="{{ route('profile.dashboard') }}">
                                    <i class="fa fa-dashboard pull-right text-gray"></i><span class="text-gray-dark">Seller Dashboard      </span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{ route('profile.sales') }}">
                                    <i class="fa fa-dashboard pull-right text-gray"></i><span class="text-gray-dark">Sale Statistics </span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{route('profile.my.items')}}">
                                    <i class="si si-list pull-right text-gray"></i><span
                                            class="text-gray-dark">My Items</span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{route('profile.item.upload')}}">
                                    <i class="si si-cloud-upload pull-right text-gray"></i><span class="text-gray-dark">Upload Item </span>
                                </a>
                            </li>
                            <li>
                                <a tabindex="-1" href="{{route('billing.subscription.upgrade')}}">
                                    <i class="si si-graduation pull-right text-gray"></i><span class="text-gray-dark">Upgrade subscription</span>
                                </a>
                            </li>

                            <li class="divider"></li>
                            <li>
                                <a tabindex="-1" href="javascript:void(0)" data-href="{{route('logout')}}"
                                   data-redirect="post">
                                    <i class="si si-logout pull-right text-gray"></i><span class="text-gray-dark">Log out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @else
                <li>
                    <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                    <div class="btn-group">
                        <a class="btn btn-login push-10-r" href="{{url('login')}}">Login</a>
                        <a class="btn btn-success-modern" href="{{url('register')}}">Register</a>
                    </div>
                </li>
            @endif
        </ul>
        <!-- END Header Navigation Right -->

        <!-- Header Navigation mobile -->
        <ul class="nav-header pull-left hidden-xs">
            <li class="header-content">
                <a href="{{url('/')}}"><img srcset="{{asset('images/logos/logo.png')}}" alt="Logo" border="0" width="98"
                                            height="33"></a>
            </li>
        </ul>

        <div class="visible-xs">
            <div class="col-xs-4 leftUser toggle_Left"><i class="fa fa-navicon push-5-r"></i></div> <!-- push-5-r -->

            <div class="col-xs-4 no-padding">
                <ul class="nav-header pull-left hidden-md">
                    <li class="header-content">
                        <a href="{{url('/')}}" class="remove-padding"><img srcset="{{asset('images/logos/logo.png')}}"
                                                                           border="0" height="35"></a>
                    </li>
                </ul>
            </div> <!-- Logo -->

            <div class="col-xs-4 rightUser toggle_Right"><i class="si si-user backgr"></i></div><!-- background user -->
        </div> <!-- visible-xs -->
        <!-- END Header Navigation Left -->
    </div>
</header>