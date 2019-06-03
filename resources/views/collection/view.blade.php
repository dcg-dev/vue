@extends('layouts.main')
@section('title', $collection->name)
@section('meta')
    <meta property="og:url" content="{{route('item',['item'=>$collection->slug])}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:headline" content="{{$collection->name}}"/>
    <meta property="og:title" content="{{$collection->name}}"/>
    <meta property="og:description" content="{{strip_tags($collection->description)}}"/>
    <meta property="og:image" content="{{url($collection->image)}}"/>
@endsection
@section('content')
    <div id="collection-view" data-id="{{$collection->slug}}">
        <div v-if="collection">
            <div class="bg-img overflow-hidden"
                 style="background-image: url('{{asset('/images/headers/hero-poly.jpg')}}');">
                <div class="bg-flat-op">
                    <section class="content content-full content-boxed">
                        <div class="push-10-t text-center">
                            <form method="post" v-on:submit.prevent="find">
                                <div class="input-group input-group-lg col-md-6 col-md-offset-3">
                                    <input class="form-control" v-model="filters.q" placeholder="Search..." type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <h5 class="h5 text-white-op push-15-t animated fadeInDown" data-toggle="appear"
                                data-class="animated fadeInDown">Find items and inspiration now</h5>
                        </div>
                    </section>
                </div>
            </div>

            <div class="bg-image" style="background-image: url('{{asset('/images/headers/coverwall-polygon.jpg')}}');">
                <div class="content bg-modern-dark-op">
                    <div class="content-boxed push-20 clearfix align-middle">
                        <div class="push-30-l pull-left animated fadeIn col-sm-1">
                            <a v-bind:href="collection.get('creator').getUrl()">
                                <img class="img-avatar img-avatar-thumb"
                                     v-bind:src="collection.get('creator').get('avatar')" alt="">
                            </a>
                        </div>
                        <div class="animated fadeIn col-sm-8 push-10-t">
                            <h3 class="h2 text-white animated fadeIn font-w300 pull-left">
                                <inline-editor :value="collection.get('name')"
                                               :editable="currentUser && currentUser.get('id') == collection.get('creator_id')"
                                               @input="save"></inline-editor>
                            </h3>
                            <div class="pull-left push-10-t push-10-l" v-if="currentUser && currentUser.get('id') == collection.get('creator_id')">
                                <a href="#" class="text-white" @click.prevent="remove"><i
                                            class="si si-trash collection-trash"></i> </a>
                            </div>
                            <div class="pull-left push-10-t push-10-l">
                                <span class="badge badge-info">
                                    <span v-text="collection.get('items').total"></span>
                                    items
                                </span>
                            </div>
                            <div class="clearfix"></div>
                            <h5 class="h5 text-white-op animated fadeIn push-5">by <a class="text-white"
                                                                                      v-bind:href="collection.get('creator').getUrl()"
                                                                                      v-text="collection.get('creator').getFullname()"></a>
                            </h5>
                        </div>
                        <div class="col-sm-2 text-right">
                            <h4 class="font-w300 push-10 text-center text-white"><span
                                        v-text="collection.get('count_followers', 0)"></span> Followers</h4>
                            <div>
                                <a class="btn btn-white btn-outline font-w400 btn-block js-swal-success-follow-collection"
                                   href="#" v-if="!collection.iFollow()" v-on:click.prevent="follow()"><i
                                            class="si si-follow"></i>Follow</a>
                                <a class="btn btn-info font-w400 btn-block js-swal-success-follow-collection" href="#"
                                   v-if="collection.iFollow()" v-on:click.prevent="follow()"><i
                                            class="si si-follow"></i>Unfollow</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row content content-boxed">
                <div class="row">
                    <section class="content content-boxed push-50">
                        <div class="form-inline clearfix">
                            <select class="form-control push" size="1" v-model="filters.order" @change="find">
                                <option value="" disabled>Sort by</option>
                                <option value="latest">Latest</option>
                                <option value="popular">Popularity</option>
                                <option value="name|asc">Name (A to Z)</option>
                                <option value="name|desc">Name (Z to A)</option>
                                <option value="price|asc">Price (Lowest to Highest)</option>
                                <option value="price|desc">Price (Highest to Lowest)</option>
                                <option value="count_sales|asc">Sales (Lowest to Highest)</option>
                                <option value="count_sales|desc">Sales (Highest to Lowest)</option>
                            </select>
                            <div class="text-right pull-right">
                                <div class="btn-group dropup push-15">
                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                       href="javascript:void(0)" aria-expanded="false"><i class="fa fa-share-alt"></i>
                                        Share</a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a tabindex="-1" href="#" v-on:click.prevent='share("facebook")'><i
                                                        class="fa fa-fw fa-facebook pull-right"></i> Facebook</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="#" v-on:click.prevent='share("twitter")'><i
                                                        class="fa fa-fw fa-twitter pull-right"></i> Twitter</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="#" v-on:click.prevent='share("google")'><i
                                                        class="fa fa-fw fa-google-plus pull-right"></i> Google+</a>
                                        </li>
                                        <li>
                                            <a tabindex="-1" href="#" v-on:click.prevent='share("linkedin")'><i
                                                        class="fa fa-fw fa-linkedin pull-right"></i> LinkedIn</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div v-if="!collection.get('items').isEmpty()">
                            <items :collection="collection.get('items')"></items>
                            <collection-pagination :collection="collection.get('items')"
                                                   v-on:go="refresh"></collection-pagination>
                        </div>
                        <div v-if="collection.get('items').isEmpty()" class="text-center push empty-collection">
                            <strong>This collection doesn't have items.</strong>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
