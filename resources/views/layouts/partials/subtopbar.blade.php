<div class="bg-modern-darkest collapse navbar-collapse" id="sub-header-nav">
    <div class="content-mini content-boxed">
        <ul id="categories" class="nav nav-pills nav-sub-header">
            <li class="dropdown">
                <a href="/items" class="dropdown-toggle" role="button" aria-haspopup="true"
                   aria-expanded="false">
                    All Items
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('items')}}?order[0]=created_at|desc">Latest Items</a>
                    </li>
                    <li>
                        <a href="{{route('items')}}?order[0]=popular">Popular Items</a>
                    </li>
                    <li>
                        <a href="{{route('featured')}}">Featured Items</a>
                    </li>
                    <li>
                        <a href="{{route('sellers.top')}}">Top Sellers</a>
                    </li>
                    @if($currentUser)
                        <li>
                            <a href="{{route('feed')}}">Follow Feed</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{route('collections.top')}}">Top Collections</a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="hidden-xs"
                     style="height: 25px; margin-top:5px; border-left: 1px solid rgba(255,255,255, 0.15);"></div>
            </li>
            @foreach($categories as $category)
                <li class="{{$category->childs ? 'dropdown':''}}">
                    <a href="{{route('category', ['category' => $category->slug])}}" class="dropdown-toggle"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">
                        {{$category->name}}
                    </a>
                    @if($category->childs)
                        <ul class="dropdown-menu">
                            @foreach($category->childs as $child)
                                <li>
                                    <a href="{{route('category', ['category' => $child->slug])}}">{{$child->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>