@extends('layouts.main')
@section('title', 'Referral Links')
@section('subtitle', 'Share links to items you like and earn money')
@section('content')
    @include('affiliate.partials.topbar', ['backgroundImage' => 'header-console', 'backgroundClass' => ''])
    <div class="content content-boxed overflow-hidden" id="affiliate-link">
        <div class="block block-themed push-100">
            <div class="block-header bg-white">
                <ul class="block-options">
                    <li>
                        <button class="btn btn-muted" data-toggle="modal" data-target="#modal-fadein" type="button">
                        <i class="si si-info fa-2x text-muted"></i></button>
                    </li>
                </ul>
                <h4 class="text-capitalize font-w300"><i class="fa fa-link"></i> Generate Affiliate Link</h4>
            </div>

             <div class="block-content push-50" v-if="currentUser">
            <div class="row items-push">
            <div class="col-sm-8">


                <div class="form-horizontal push-10-t push-10">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <div class="form-control-static font-w700" v-text="currentUser.get('username')"></div>
                                <label for="login2-username">Your Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input v-model="currentUser.attributes.affiliate_link" class="form-control"
                                       placeholder="Copy the item or link of the page here...">
                                <label class="font-w300">Link to an item</label>
                            </div>
                            <span class="help-block" v-if="errors.link">
                               <strong v-text="errors.link" class="text-danger"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-sm switch-info">
                                <input v-model="currentUser.attributes.accepted" id="login2-remember-me"
                                       name="login2-remember-me" type="checkbox"><span></span> I agree to the terms
                                &amp; conditions.
                            </label>
                            <span class="help-block" v-if="errors.accept">
                               <strong v-text="errors.accept" class="text-danger"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button v-on:click="generateLink" class="btn btn-lg btn-success-modern" type="submit">Generate
                                Link
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <label>Copy this link and place it on your website or social media profile.</label>
                            <div class="input-group input-disable input-group-lg">
                                <input v-model="generatedLink" id="clipboard-input" class="form-control"
                                       placeholder="Your generated link appears here.." type="text">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" id="clipboard-button" v-on:click="copyToClipboard">
                                        <i class="fa fa-link"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
                 <div class="col-sm-4">


                 <div class="push-15-r bg-gray-lighter block-content">
                           <h4 class="push-10">What is my main referral link?</h4>
                           <p class="text-muted">With the main referral link you can refer new users to our page. Whenever someone purchases an item you will get paid a commission amount of our share or a commission for the first subscription. Below you can find your referral code to add to any link of this page but you can use the tool on the left side to create a referral link for items. The links track items and the subscription.</p>
                           <div class="form-group">

                                         <h4 class="font-w300 push-15">Main referral link</h4>

                                         <div class="row font-w400"><div class="col-sm-1 col-md-1 text-left">?ref=</div><div class="col-sm-4 col-md-4 font-w700 text-left" v-text="currentUser.get('username')"></div></div>
                                          </div>
                                        </div>
                                       <div class="small text-muted text-center push-30 push-10-t"> By using this link you agree to our terms & conditions.  </div>
                                    </form>
                          </div>












            </div>
           </div>


        </div>
    </div>
    @include('affiliate.partials.modal')
@endsection