<!-- Collapsible Inbox Navigation (using Bootstrap collapse functionality) -->
<button class="btn btn-block btn-primary visible-xs push" data-toggle="collapse" data-target="#inbox-nav" type="button">Navigation</button>
<div class="collapse navbar-collapse remove-padding" id="inbox-nav">
    <!-- Inbox Menu -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <ul class="block-options">
                <li>
                    <a href="/profile/inbox/compose" :class="currentSection == 'compose' ? 'active' : ''"><i class="fa fa-pencil"></i> New Message</a>
                </li>
            </ul>
            <h3 class="block-title">Inbox</h3>
        </div>
        <div class="block-content">
            <ul class="nav nav-pills nav-stacked push">
                <li :class="{active: currentSection == 'inbox'}">
                    <a href="javascript:void(0)" v-on:click="go('inbox')">
                        <span v-if="counters.inbox > 0" class="badge pull-right" v-text="counters.inbox"></span><i class="fa fa-fw fa-inbox push-5-r" :class="{'text-success': currentSection == 'inbox'}"></i> <span :class="currentSection == 'inbox' ? 'text-success' : 'text-gray-darker'">Inbox</span>
                    </a>
                </li>
                <li :class="{active: currentSection == 'starred'}">
                    <a href="javascript:void(0)" v-on:click="go('starred')">
                        <span v-if="counters.starred > 0" class="badge pull-right" v-text="counters.starred"></span><i class="fa fa-fw fa-star push-5-r" :class="{'text-success': currentSection == 'starred'}"></i> <span :class="currentSection == 'starred' ? 'text-success' : 'text-gray-darker'">Starred </span>
                    </a>
                </li>
                <li :class="{active: currentSection == 'sent'}">
                    <a href="javascript:void(0)" v-on:click="go('sent')">
                        <span v-if="counters.sent > 0" class="badge pull-right" v-text="counters.sent"></span><i class="fa fa-fw fa-send push-5-r" :class="{'text-success': currentSection == 'sent'}"></i> <span :class="currentSection == 'sent' ? 'text-success' : 'text-gray-darker'">Sent</span>
                    </a>
                </li>
                {{--<li :class="{active: currentSection == 'draft'}">--}}
                    {{--<a href="javascript:void(0)" v-on:click="go('draft')">--}}
                        {{--<span v-if="counters.draft > 0" class="badge pull-right" v-text="counters.draft"></span><i class="fa fa-fw fa-pencil push-5-r" :class="{'text-success': currentSection == 'draft'}"></i> <span :class="currentSection == 'draft' ? 'text-success' : 'text-gray-darker'">Draft</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li :class="{active: currentSection == 'archive'}">
                    <a href="javascript:void(0)" v-on:click="go('archive')">
                        <span v-if="counters.archive > 0" class="badge pull-right" v-text="counters.archive"></span><i class="fa fa-fw fa-folder push-5-r" :class="{'text-success': currentSection == 'archive'}"></i><span :class="currentSection == 'archive' ? 'text-success' : 'text-gray-darker'"> Archive</span>
                    </a>
                </li>
                <li :class="{active: currentSection == 'trash'}">
                    <a href="javascript:void(0)" v-on:click="go('trash')">
                        <span v-if="counters.trash > 0" class="badge pull-right" v-text="counters.trash"></span><i class="fa fa-fw fa-trash push-5-r" :class="{'text-success': currentSection == 'trash'}"></i><span :class="currentSection == 'trash' ? 'text-success' : 'text-gray-darker'"> Trash</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Inbox Menu -->
</div>
<!-- END Collapsible Inbox Navigation -->