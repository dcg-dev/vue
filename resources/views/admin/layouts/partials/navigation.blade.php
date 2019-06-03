<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">Navigation</li>
            <li class="{{!Route::is('admin.dashboard') ?: 'active'}}">
                <a href="{{route('admin.dashboard')}}"><i class="fa fa-th-large"></i> <span
                            class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.item.list','admin.comment.list','admin.rating.list', 'admin.item.create', 'admin.item.edit', 'admin.tag.list', 'admin.license.list', 'admin.format.list',]) ?: 'active'}}">
                <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Items <span
                                class="badge badge-info badge-xs">{{ isset($draftItems) && $draftItems ? $draftItems : '' }}</span></span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.item.list') ?: 'active'}}">
                        <a href="{{route('admin.item.list')}}">
                            Item List
                        </a>
                    </li>
                    <li class="{{!Route::is('admin.comment.list') ?: 'active'}}">
                        <a href="{{route('admin.comment.list')}}">
                            Comments
                        </a>
                    </li>
                    <li class="{{!Route::is('admin.rating.list') ?: 'active'}}">
                        <a href="{{route('admin.rating.list')}}">
                            Review
                        </a>
                    </li>
                    <li class="{{!in_array(Route::currentRouteName(), ['admin.tag.list', 'admin.license.list', 'admin.format.list',]) ?: 'active'}}">
                        <a href="#"><i class="fa fa-sliders"></i> <span class="nav-label">Options</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li class="{{!Route::is('admin.tag.list') ?: 'active'}}"><a
                                        href="{{route('admin.tag.list')}}">Tags</a></li>
                            <li class="{{!Route::is('admin.license.list') ?: 'active'}}"><a
                                        href="{{route('admin.license.list')}}">Licenses</a></li>
                            <li class="{{!Route::is('admin.format.list') ?: 'active'}}"><a
                                        href="{{route('admin.format.list')}}">Formats</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="{{!Route::is('admin.category.list') ?: 'active'}}">
                <a href="{{route('admin.category.list')}}"><i class="fa fa-server"></i> <span class="nav-label">Categories</span></a>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.billing.plan.list', 'admin.billing.promo-plan.index']) ?: 'active'}}">
                <a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">Subscriptions</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.billing.plan.list') ?: 'active'}}"><a
                                href="{{route('admin.billing.plan.list')}}">Plans</a></li>
                    <li class="{{!Route::is('admin.billing.promo-plan.index') ?: 'active'}}"><a
                                href="{{route('admin.billing.promo-plan.index')}}">Promotional</a></li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.blog.story.create', 'admin.blog.story.edit', 'admin.blog.story.list']) ?: 'active'}}">
                <a href="#"><i class="fa fa-pencil-square-o"></i> <span class="nav-label">Blog <span
                                class="badge badge-danger badge-xs">{{ isset($disapprovedStories) && $disapprovedStories ? $disapprovedStories : '' }}</span></span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!in_array(Route::currentRouteName(), ['admin.blog.story.create', 'admin.blog.story.edit', 'admin.blog.story.list']) ?: 'active'}}">
                        <a href="#"><i class="fa fa-book"></i> <span class="nav-label">Stories</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li class="{{!Route::is('admin.blog.story.list') ?: 'active'}}"><a
                                        href="{{route('admin.blog.story.list')}}">Stories List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.user.list', 'admin.user.create', 'admin.user.edit', 'admin.user.skill.list']) ?: 'active'}}">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Users</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.user.list') ?: 'active'}}"><a href="{{route('admin.user.list')}}">User
                            List</a></li>
                    <li class="{{!Route::is('admin.user.skill.list') ?: 'active'}}"><a
                                href="{{route('admin.user.skill.list')}}">Skills</a></li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.order.list', 'admin.order.edit', 'admin.subscription.list']) ?: 'active'}}">
                <a href="#"><i class="fa fa-shopping-basket"></i> <span class="nav-label">Orders</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.order.list') ?: 'active'}}"><a href="{{route('admin.order.list')}}">Order
                            List</a></li>
                    <li class="{{!Route::is('admin.subscription.list') ?: 'active'}}"><a
                                href="{{route('admin.subscription.list')}}">Subscription List</a></li>
                    <li class="{{!Route::is('admin.promotional.list') ?: 'active'}}"><a
                                href="{{route('admin.promotional.list')}}">Promotional List</a></li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.affiliate.request.list', 'admin.affiliate.request.edit', 'admin.affiliate.sale.list', 'admin.affiliate.sale.edit', 'admin.affiliate.configuration']) ?: 'active'}}">
                <a href="#"><i class="fa fa-link"></i> <span class="nav-label">Affiliate Sales</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.affiliate.sale.list') ?: 'active'}}"><a
                                href="{{route('admin.affiliate.sale.list')}}">Sales</a></li>
                    <li class="{{!Route::is('admin.affiliate.request.list') ?: 'active'}}"><a
                                href="{{route('admin.affiliate.request.list')}}">Requests</a></li>
                    <li class="{{!Route::is('admin.affiliate.configuration') ?: 'active'}}"><a
                                href="{{route('admin.affiliate.configuration')}}">Configuration</a></li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.support.ticket.list', 'admin.support.ticket.create', 'admin.support.ticket.edit']) ?: 'active'}}">
                <a href="#"><i class="fa fa-ticket"></i> <span class="nav-label">Tickets <span
                                class="badge badge-warning badge-xs">{{ isset($openTickets) && $openTickets ? $openTickets : '' }}</span></span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-third-lavel collapse">
                    <li class="{{!Route::is('admin.support.ticket.list') ?: 'active'}}"><a
                                href="{{route('admin.support.ticket.list')}}">Ticket List</a></li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.support.faq.category.list', 'admin.support.faq.topic.list', 'admin.support.ticket.list', 'admin.support.ticket.edit']) ?: 'active'}}">
                <a href="#"><i class="fa fa-life-ring"></i> <span class="nav-label">Support</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!in_array(Route::currentRouteName(), ['admin.support.faq.category.list', 'admin.support.faq.topic.list']) ?: 'active'}}">
                        <a href="#"><i class="fa fa-question"></i> <span class="nav-label">FAQ</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-third-lavel collapse">
                            <li class="{{!Route::is('admin.support.faq.category.list') ?: 'active'}}"><a
                                        href="{{route('admin.support.faq.category.list')}}">Category List</a></li>
                            <li class="{{!Route::is('admin.support.faq.topic.list') ?: 'active'}}"><a
                                        href="{{route('admin.support.faq.topic.list')}}">Topic List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="{{!in_array(Route::currentRouteName(), ['admin.settings.notifications', 'admin.settings.sociality', 'admin.settings.billing', 'admin.settings.pagination', 'admin.country.list']) ?: 'active'}}">
                <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{!Route::is('admin.settings.notifications') ?: 'active'}}"><a
                                href="{{route('admin.settings.notifications')}}">Notifications</a></li>
                    <li class="{{!Route::is('admin.settings.sociality') ?: 'active'}}"><a
                                href="{{route('admin.settings.sociality')}}">Social Networks</a></li>
                    <li class="{{!Route::is('admin.settings.billing') ?: 'active'}}"><a
                                href="{{route('admin.settings.billing')}}">Billing</a></li>
                    <li class="{{!Route::is('admin.settings.pagination') ?: 'active'}}"><a
                                href="{{route('admin.settings.pagination')}}">Pagination</a></li>
                    <li class="{{!Route::is('admin.country.list') ?: 'active'}}"><a
                                href="{{route('admin.country.list')}}">Countries</a></li>
                    <li class="{{!Route::is('admin.firewall') ?: 'active'}}"><a
                                href="{{route('admin.firewall')}}">Firewall</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
