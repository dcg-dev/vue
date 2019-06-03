<div class="bg-img overflow-hidden push" style="background-image: url('{{asset('/images/headers/header-console.jpg')}}');background-size: cover;">
    <div class="">
        <div class="content">
            <div class="block block-transparent block-themed text-center">
                <div class="block-content">
                    <h1 class="h2 font-w300 text-white-op">@yield('title')</h1>
                    <h2 class="h5 font-w400 text-white-op">@yield('subtitle')</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white collapse navbar-collapse remove-padding" id="sub-header-nav">
    <div class="content-mini content-boxed">
        <ul class="nav nav-pills-account nav-sub-header push">
            <li class="{{ Route::is('profile.dashboard') ? 'active' : '' }}">
                <a href="{{ route('profile.dashboard') }}">
                    <i class="fa fa-dashboard push-5-r "></i>Dashboard
                </a>
            </li>
            <li class="{{ Route::is('profile.edit') ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}">
                    <i class="si si-user push-5-r"></i>Profile
                </a>
            </li>
            <li class="{{ Route::is('profile.settings') ? 'active' : '' }}">
                <a href="{{ route('profile.settings') }}">
                    <i class="si si-user push-5-r"></i>Settings
                </a>
            </li>
            <li class="{{ Route::is('profile.downloads') ? 'active' : '' }}">
                <a href="{{route('profile.downloads')}}">
                    <i class="si si-cloud-download push-5-r"></i>Downloads
                </a>
            </li>
            <li class="{{ Route::is('profile.my.items') ? 'active' : '' }}">
                <a href="{{route('profile.my.items')}}">
                    <i class="fa fa-briefcase push-5-r"></i>Items
                </a>
            </li>
            <li class="{{ Route::is('profile.sales') ? 'active' : '' }}">
                <a href="{{ route('profile.sales') }}">
                    <i class="fa fa-bar-chart push-5-r"></i>Sales
                </a>
            </li>
            <li class="{{ Route::is('profile.subscriptions') ? 'active' : '' }}">
                <a href="{{ route('profile.subscriptions') }}">
                    <i class="si si-graduation push-5-r"></i>Subscriptions
                </a>
            </li>
            <li class="{{ Route::is('profile.promotions') ? 'active' : '' }}">
                <a href="{{ route('profile.promotions') }}">
                    <i class="si si-magic-wand push-5-r"></i>Promotions
                </a>
            </li>
            <li class="{{ Route::is('profile.affiliate.sales') ? 'active' : '' }} text-white">
                <a href="{{ route('profile.affiliate.sales') }}">
                    <i class="fa fa-percent push-5-r"></i>Affiliate Sales
                </a>
            </li>
            <li>
                <a href="{{route('user.collections', ['user' => $currentUser->username])}}">
                    <i class="fa fa-star-o push-5-r"></i>Collections
                </a>
            </li>
            <li class="{{ Route::is('profile.item.upload') ? 'active' : '' }} text-white">
                <a href="{{route('profile.item.upload')}}">
                    <i class="si si-cloud-upload push-5-r"></i>Upload Item
                </a>
            </li>
        </ul>
    </div>
</div>