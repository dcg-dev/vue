@extends('layouts.main')
@section('title', $item->name)
@section('meta')
    <meta property="og:url" content="{{route('item',['item'=>$item->slug])}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$item->name}}"/>
    <meta property="og:description" content="{{strip_tags($item->description)}}"/>
    <meta property="og:image" content="{{url($item->image)}}"/>
@endsection
@section('content')
    <div id="item-view" data-id="{{$item->slug}}">
        <div v-if="item">
            <div class="bg-img">
                <item-header :item="item"></item-header>
            </div>
            <div class="bg-gray-lighter">
                <section class="content content-boxed">
                    <div class="row">
                        <div class="col-lg-8">
                            <item-info :item="item"></item-info>
                            <div v-if="!releated.isEmpty()" class="hidden-sm hidden-xs">
                                <h5 class="m-b-lg" style="margin-bottom: 20px;">More items
                                    from @{{ item.get('creator').getFullname() }}</h5>
                                <div class="releated-items">
                                    <div v-for="item in releated.getData()">
                                        <div class="block">
                                            <div class="img-container">
                                                <img class="img-responsive" v-bind:src="item.get('image')" alt="">
                                                <div class="img-options">
                                                    <div class="img-options-content">
                                                        <div class="push-20">
                                                            <a class="btn btn-lg btn-primary"
                                                               v-bind:href="item.getUrl()">View</a>
                                                        </div>
                                                        <stars :rating="item.get('rating', 0)"></stars>
                                                        <span class="text-white"
                                                              v-if="item.get('count_rating', false)">(<span
                                                                    v-text="item.get('count_rating', 0)"></span>)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <div>
                                                    <div class="font-w600 text-success pull-right push-10-l">
                                                        <span v-if="item.isFree()">Free</span>
                                                        <span v-if="!item.isFree()">
                            $<span v-text="item.getPrice()"></span>
                        </span>
                                                    </div>
                                                    <a class="concat-title" v-bind:title="item.get('name')"
                                                       v-bind:href="item.getUrl()"
                                                       v-text="item.get('name')"></a>
                                                </div>
                                                <div class="push-20">
                                                    by <a class="text-muted"
                                                          v-bind:href="item.get('creator').getUrl()"
                                                          v-text="item.get('creator').getFullname()"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="">
                                <item-buttons :item="item" :license="license" :user="currentUser"></item-buttons>
                                <item-user :user="currentUser" :item="item"></item-user>
                                <item-rating :item="item"></item-rating>
                                <item-sub-buttons :user="currentUser" :item="item"></item-sub-buttons>
                                <item-comment-info :item="item"></item-comment-info>
                                <item-social-buttons :item="item"></item-social-buttons>
                                <item-sub-info :item="item"></item-sub-info>
                                <item-tags :item="item" route="{{ route('items') }}" style="margin-bottom: 10px;"></item-tags>
                                <div class="text-center h6 hidden-sm hidden-xs" style="margin-bottom: 25px">
                                    <a href="/support/faq" class="text-muted">Need help? Get support.</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row visible-sm visible-xs">
                        <div class="col-md-12">
                            <div v-if="!releated.isEmpty()">
                                <h5 class="m-b-lg" style="margin-bottom: 20px;">More items
                                    from @{{ item.get('creator').getFullname() }}</h5>
                                <div class="releated-items">
                                    <div v-for="item in releated.getData()">
                                        <div class="block">
                                            <div class="img-container">
                                                <img class="img-responsive" v-bind:src="item.get('image')" alt="">
                                                <div class="img-options">
                                                    <div class="img-options-content">
                                                        <div class="push-20">
                                                            <a class="btn btn-lg btn-primary"
                                                               v-bind:href="item.getUrl()">View</a>
                                                        </div>
                                                        <stars :rating="item.get('rating', 0)"></stars>
                                                        <span class="text-white"
                                                              v-if="item.get('count_rating', false)">(<span
                                                                    v-text="item.get('count_rating', 0)"></span>)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <div class="h4 push-10">
                                                    <div class="font-w600 text-success pull-right push-10-l">
                                                        <span v-if="item.isFree()">Free</span>
                                                        <span v-if="!item.isFree()">
                            $<span v-text="item.getPrice()"></span>
                        </span>
                                                    </div>
                                                    <a class="concat-title" v-bind:title="item.get('name')"
                                                       v-bind:href="item.getUrl()"
                                                       v-text="item.get('name')"></a>
                                                </div>
                                                <div class="push-20">
                                                    by <a class="text-muted"
                                                          v-bind:href="item.get('creator').getUrl()"
                                                          v-text="item.get('creator').getFullname()"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection