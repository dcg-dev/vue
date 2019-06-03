<div class="canvasMenuLeft visible-xs">
    <ul id="categories-mobile">
        <li class="responsive-image block-content">
            <img src="{{asset('images/logos/logo.png')}}" alt="" border="0" width="100" height="35">
        </li>
        <div class="clickToggle">
            <form method="get" action="{{ route('items') }}">
                <input type="text" name="q" class="text" placeholder="Search">
                <button class="submit" type="submit" name="submit"><i class='fa fa-search search'></i></button>
            </form>
        </div><!-- clickToggle -->
        <li class="dropdownClick">
            <a class="local local_class_clickable" href="#">Popular Items <i class="fa fa-caret-down"></i></a>
            <ul class="local_class_show" style="display: none;" >
                <li>
                    <a href="{{route('items')}}?order[0]=created_at|desc" class="linkSub">Latest Items</a>
                </li>
                <li>
                    <a href="{{route('items')}}?order[0]=popular" class="linkSub">Popular Items</a>
                </li>
                <li>
                    <a href="{{route('featured')}}" class="linkSub">Featured Items</a>
                </li>
                <li>
                    <a href="{{route('sellers.top')}}" class="linkSub">Top Sellers</a>
                </li>
                @if($currentUser)
                    <li>
                        <a href="{{route('feed')}}" class="linkSub">Follow Feed</a>
                    </li>
                @endif
                <li>
                    <a href="{{route('collections.top')}}" class="linkSub">Top Collections</a>
                </li>
            </ul>
        </li>
        <li v-if="!list.isEmpty()" v-for="category in list.getData()" v-bind:class="!category.get('childs').isEmpty() ? 'dropdownClick' : 'local'">
            <a  v-bind:href="category.get('childs').isEmpty() ? category.getUrl() : '#'" class="dropdown-toggle" v-bind:class="!category.get('childs').isEmpty() ? 'local local_class_clickable' : ''" role="button" aria-haspopup="true" aria-expanded="false"><span v-text="category.get('name')"></span> <i v-if="!category.get('childs').isEmpty()" class="fa fa-caret-down"></i></a>
            <ul class="local_class_show" v-if="!category.get('childs').isEmpty()" style="display: none;">
                <li v-for="child in category.get('childs').getData()">
                    <a v-bind:href="child.getUrl()" v-text="child.get('name')" class="linkSub"></a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="canvasMenuRight visible-xs">
    <ul>
        @if($currentUser)
        <li class="image">
            <img src="{{$currentUser->avatar}}" alt="{{$currentUser->username}}">
        </li>
        <li class="username text-white-op">{{ $currentUser->username }}</li>
        <li class="cartIcon">
            <a href="{{ route('checkout') }}">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </li>
        @if($currentUser && $currentUser->isAdmin())
        <li class="dash">
            <a href="{{route('admin.dashboard')}}">
                Control Panel
            </a>
        </li>
        @endif
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.edit') }}">
                <i class="si si-user text-muted push-10-r"></i>
                <span >Profile</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.inbox') }}">
                <i class="si si-envelope{{ $currentUser->inboxCount() > 0 ? '-open' : '' }} text-muted push-10-r"></i>
                <span class="badge badge-primary pull-right">{{ $currentUser->inboxCount()  }}</span>
                <span >Inbox</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.settings') }}">
                <i class="si si-settings text-muted push-10-r"></i><span >Settings</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.downloads') }}">
                <i class="si si-cloud-download text-muted push-10-r"></i><span >Downloads</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.affiliate.sales') }}">
                <i class="fa fa-money text-muted push-10-r"></i><span >Affiliate Sales</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('profile.item.favourites')}}">
                <i class="si si-heart text-muted push-10-r"></i><span >Favourites</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('user.collections', ['user' => $currentUser->username])}}">
                <i class="fa fa-archive text-muted push-10-r"></i><span >Collections</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('feed')}}">
                <i class="si si-feed text-muted push-10-r"></i><span >Follow Feed</span>
            </a>
        </li>
        <li class="divider"></li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.dashboard') }}">
                <i class="fa fa-dashboard text-muted push-10-r"></i><span >Seller Dashboard      </span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{ route('profile.sales') }}">
                <i class="fa fa-dashboard text-muted push-10-r"></i><span >Sale Statistics </span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('profile.my.items')}}">
                <i class="si si-list text-muted push-10-r"></i><span >My Items</span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('profile.item.upload')}}">
                <i class="si si-cloud-upload text-muted push-10-r"></i><span >Upload Item </span>
            </a>
        </li>
        <li class="dash">
            <a tabindex="-1" href="{{route('billing.subscription.upgrade')}}">
                <i class="si si-graduation text-muted push-10-r"></i><span >Upgrade subscription</span>
            </a>
        </li>
        <li class="divider"></li>
        <li class="dash logout  push-20-r">
            <a tabindex="-1" href="{{route('logout')}}" data-redirect="post">
                <i class="si si-logout push-10-r"></i><span >Log out</span>
            </a>
        </li>
        @else
        <li class="dash">
            <a class="btn btn-login push-10-r" href="{{url('login')}}">Login</a>
        </li>
        <li class="dash">
            <a class="btn btn-success-modern" href="{{url('register')}}">Register</a>
        </li>
        @endif
    </ul>
</div>