window.FREE_PLAN = 'Free';
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-less');
require('jquery-slimscroll');
require('jquery-scroll-lock');
require('jquery-countto');
require('jquery.appear');
require('jquery.placeholder');
require('js-cookie');
require('cropper');
require('select2');
require('ckeditor');
require('sweetalert');
require('ion-rangeslider');
window.moment = require('moment');
window.queryString = require('query-string')
window.WaveSurfer = require('./vendor/audioplayer/wavesurfer.js');
require('./vendor/audioplayer/audioplayer.js');
require('./vendor/pace.min.js');
Pace.options.ajax = false;
require('./vendor/stripe.min.js');
CKEDITOR.basePath = '/ckeditor/';
CKEDITOR.customConfig = '/ckeditor/config.js';
CKEDITOR.getUrl = function (resource) {
    var pluginsPos = null;
    if ((pluginsPos = resource.indexOf("plugins")) > 0) {
        return CKEDITOR.basePath + resource.slice(pluginsPos);
    }
    -1 == resource.indexOf(":/") && 0 !== resource.indexOf("/") && (resource = this.basePath + resource);
    this.timestamp && "/" != resource.charAt(resource.length - 1) && !/[&?]t=/.test(resource) && (resource += (0 <= resource.indexOf("?") ? "\x26" : "?") + "t\x3d" + this.timestamp);
    return resource;
};
window.queryString = require('query-string');
window.toastr = require('toastr');
window.Ladda = require('ladda/dist/ladda.min');
window.Vue = require('vue');
require('slick-carousel');

window.axios = require('axios');
window.ajaxHeaders = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};
window.axios.defaults.headers.common = window.ajaxHeaders
require('chart.js');
require('./vendor/vue-charts/vue-charts.js');
import Vue2Filters from 'vue2-filters';
Vue.use(VueCharts);
Vue.use(Vue2Filters);
Vue.component('select2', require('./components/select2.vue'));
Vue.component('Dropzone', require('vue2-dropzone'));
Vue.component('ckeditor', require('./components/ckeditor.vue'));
Vue.component('tags', require('./components/tags.vue'));
Vue.component('users', require('./components/users.vue'));
Vue.component('items-select', require('./components/items.vue'));
Vue.component('skills', require('./components/skills.vue'));
Vue.component('categories', require('./components/categories.vue'));
Vue.component('countries', require('./components/countries.vue'));
Vue.component('player', require('./components/player.vue'));
Vue.component('pagination', require('./components/pagination.vue'));
Vue.component('collection-pagination', require('./components/collection-pagination.vue'));
Vue.component('stars', require('./components/stars.vue'));
Vue.component('items', require('./components/items/list.vue'));
Vue.component('items-featured', require('./components/items/featured.vue'));
Vue.component('item-buttons', require('./components/items/buttons.vue'));
Vue.component('item-user', require('./components/items/user.vue'));
Vue.component('item-rating', require('./components/items/rating.vue'));
Vue.component('item-sub-buttons', require('./components/items/sub-buttons.vue'));
Vue.component('item-comment-info', require('./components/items/comment-info.vue'));
Vue.component('item-social-buttons', require('./components/items/social-buttons.vue'));
Vue.component('item-sub-info', require('./components/items/sub-info.vue'));
Vue.component('item-tags', require('./components/items/tags.vue'));
Vue.component('item-header', require('./components/items/header.vue'));
Vue.component('item-info', require('./components/items/info.vue'));
Vue.component('sellers', require('./components/user/sellers.vue'));
Vue.component('sellers-advanced', require('./components/user/sellers_advanced.vue'));
Vue.component('user-followers', require('./components/user/followers.vue'));
Vue.component('user-following', require('./components/user/following.vue'));
Vue.component('user-items', require('./components/user/items.vue'));
Vue.component('user-ratings', require('./components/user/ratings.vue'));
Vue.component('user-header', require('./components/user/header.vue'));
Vue.component('user-buttons', require('./components/user/buttons.vue'));
Vue.component('user-freelance', require('./components/user/freelance.vue'));
Vue.component('user-country', require('./components/user/country.vue'));
Vue.component('user-badges', require('./components/user/badges.vue'));
Vue.component('user-skills', require('./components/user/skills.vue'));
Vue.component('user-follow-email', require('./components/user/follow-email.vue'));
Vue.component('user-latest-followers', require('./components/user/latest-followers.vue'));
Vue.component('user-latest-items', require('./components/user/latest-items.vue'));
Vue.component('user-latest-ratings', require('./components/user/latest-ratings.vue'));
Vue.component('new-collection-button', require('./components/user/new-collection-button.vue'));
Vue.component('comment', require('./components/comment.vue'));
Vue.component('comment-form', require('./components/comment-form.vue'));
Vue.component('comment-reply-form', require('./components/comment-reply-form.vue'));
Vue.component('rating-overview', require('./components/rating-overview.vue'));
Vue.component('item-status', require('./components/items/status.vue'));
Vue.component('stories-list', require('./components/stories/list.vue'));
Vue.component('stories-create', require('./components/stories/create.vue'));
Vue.component('collections', require('./components/collections/list.vue'));
Vue.component('collection-create', require('./components/collections/create.vue'));
Vue.component('collection-attach', require('./components/collections/attach.vue'));
Vue.component('list-advance', require('./components/items/list_advance.vue'));
Vue.component('plans', require('./components/billing/plans.vue'));
Vue.component('promo-plans', require('./components/billing/promo-plans.vue'));
Vue.component('credit-card', require('./components/billing/credit_card.vue'));
Vue.component('blog-promote', require('./components/billing/blog-promote.vue'));
Vue.component('inbox-messages', require('./components/inbox/messages.vue'));
Vue.component('inbox-list', require('./components/inbox/list.vue'));
Vue.component('inbox-view', require('./components/inbox/view.vue'));
Vue.component('inbox-compose', require('./components/inbox/compose.vue'));
Vue.component('inbox-compose-modal', require('./components/inbox/compose-modal.vue'));
Vue.component('subscription-upgrade', require('./components/billing/upgrade.vue'));
Vue.component('promo-buy', require('./components/billing/promo-buy.vue'));
Vue.component('billing-invoices', require('./components/billing/invoices.vue'));
Vue.component('sales', require('./components/sales/list.vue'));
Vue.component('downloads', require('./components/downloads/list.vue'));
Vue.component('rate', require('./components/downloads/rate.vue'));
Vue.component('stories-pay', require('./components/stories/pay.vue'));
Vue.component('ticket-create', require('./components/support/ticket/create.vue'));
Vue.component('support-faq-ticket', require('./components/support/faq/ticket.vue'));
Vue.component('support-faq-search', require('./components/support/faq/search.vue'));
Vue.component('support-faq-categories', require('./components/support/faq/categories.vue'));
Vue.component('support-faq-topbar', require('./components/support/faq/topbar.vue'));
Vue.component('affiliate-request', require('./components/affiliate/request.vue'));
Vue.component('dashboard-counters', require('./components/profile/dashboard/counters.vue'));
Vue.component('dashboard-search', require('./components/dashboard/search.vue'));
Vue.component('inline-editor', require('./components/inline-editor.vue'));
Vue.component('modal-edit-profile', require('./components/user/modal-edit-profile.vue'));
Vue.component('form-alert', require('./components/form-alert.vue'));
var helpers = require.context("./helpers", true, /^(.*\.(js$))[^.]*$/igm);
helpers.keys().forEach(function (key) {
    helpers(key);
});
var models = require.context("./models", true, /^(.*\.(js$))[^.]*$/igm);
models.keys().forEach(function (key) {
    models(key);
});
window.currentUser = false;
var registerApps = function () {
    var apps = require.context("./apps", true, /^(.*\.(js$))[^.]*$/igm);
    apps.keys().forEach(function (key) {
        apps(key);
    });
};

var getCart = function () {
    cart.getCartInfo(function () {
        registerApps();
    }, function () {
        registerApps();
    });
};

Vue.mixin({
    mounted() {
        $('body').addClass('loaded');
        $('#load-box').removeClass('hide');
    }
});

users().current(function (user) {
    window.currentUser = user;
    getCart();
}, function () {
    window.currentUser = false;
    getCart();
});

$(window).on('unload', function () {
    $('body').removeClass('loaded');
});

//setInterval(function(){
//    users().current(function(user) {
//        window.currentUser = user;
//    }, function() {
//        window.currentUser = false;
//    }, true);
//}, 5000);
