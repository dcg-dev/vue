@extends('layouts.main')
@section('title', 'Support Center')
@section('subtitle', 'Building awesome products is not our only job. We care about our clients.')
@section('content')
<div id="support-faq-view">
    <support-faq-topbar title="@yield('title')" subtitle="@yield('subtitle')" route="{{ asset('/images/headers/header-console.jpg') }}"></support-faq-topbar>
    
    <!-- Categories -->
    <support-faq-categories :account="countAccount" :features="countFeatures" :services="countServices" :payment="countPayment"></support-faq-categories>
    <!-- END Categories -->
    
    <!-- Search -->
    <support-faq-search v-on:getTopics="getTopics"></support-faq-search>
    <!-- END Search -->
    
    <div class="bg-white">
        <section class="content content-full content-boxed">
            <!-- Section Content -->
            <div class="row push-20-t push-20" v-if="categories.length > 0">
                <div class="col-sm-8 col-sm-offset-2" v-for="categoryName in categories">
                    <!-- Introduction -->
                    <h2 class="h3 font-w600 push-30-t push" v-text="categoryName"></h2>
                    <div v-if="!topics.isEmpty()" v-for="topic in topics.getData()">
                        <div v-bind:id="'frontend-faq' + topic.get('faq_category_id')" class="panel-group" v-if="topic.get('category').get('name') == categoryName">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" 
                                           data-toggle="collapse" 
                                           v-bind:data-parent="'#frontend-faq' + topic.get('faq_category_id')" 
                                           v-bind:href="'#frontend-faq' + topic.get('faq_category_id') + '_q' + topic.get('id')"
                                           v-text="topic.get('question')"></a>
                                    </h3>
                                </div>
                                <div v-bind:id="'frontend-faq' + topic.get('faq_category_id') + '_q' + topic.get('id')" class="panel-collapse collapse">
                                    <div class="panel-body" v-html="topic.get('answer')"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Introduction -->
                </div>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
    
    <!-- Ticket -->
    <support-faq-ticket :user="currentUser" route="{{ route('support.ticket.list') }}"></support-faq-ticket>
    <!-- END Ticket -->   
</div>
@endsection