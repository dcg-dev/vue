window._ = require('lodash');
require('ckeditor');
window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};
window.queryString = require('query-string');
window.Ladda = require('ladda/dist/ladda.min');
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
Vue.component('datepicker', require('vuejs-datepicker'));
window.WaveSurfer = require('../../js/vendor/audioplayer/wavesurfer.js');
require('../../js/vendor/audioplayer/audioplayer.js');
Vue.component('draggable', require('vuedraggable'));
Vue.component('pagination', require('../../js/components/pagination.vue'));
Vue.component('ckeditor', require('../../js/components/ckeditor.vue'));
Vue.component('Dropzone', require('vue2-dropzone'));
Vue.component('list', require('../../js/components/admin/list.vue'));
Vue.component('collection-pagination', require('../../js/components/collection-pagination.vue'));
Vue.component('comment', require('../../js/components/comment.vue'));
Vue.component('users', require('../../js/components/users.vue'));
Vue.component('rating-overview', require('../../js/components/rating-overview.vue'));
Vue.component('stars', require('../../js/components/stars.vue'));
Vue.component('player', require('../../js/components/player.vue'));
Vue.component('item-status', require('../../js/components/items/status.vue'));
Vue.component('countries', require('../../js/components/countries.vue'));
Vue.component('plan', require('./components/billing/plan.vue'));
Vue.component('promo-plan', require('./components/billing/promo.vue'));
Vue.component('select2', require('../../js/components/select2.vue'));
Vue.component('categories', require('../../js/components/categories.vue'));
Vue.component('tags', require('../../js/components/tags.vue'));
Vue.component('ticket-post', require('./components/support/ticket-post.vue'));
Vue.component('faq-category', require('./components/support/faq-category.vue'));
Vue.component('faq-topic', require('./components/support/faq-topic.vue'));
Vue.component('user-skill', require('./components/user/skill.vue'));
Vue.component('tag-form', require('./components/tag/form.vue'));
Vue.component('country-form', require('./components/country/form.vue'));
Vue.component('countries', require('../../js/components/countries.vue'));
Vue.component('subscription-list', require('./components/subscription/dashboard-widget.vue'));
Vue.component('dashboard-dd', require('./components/dashboard-dd.vue'));
require('chart.js');
require('../../js/vendor/vue-charts/vue-charts.js');
Vue.use(VueCharts);

var helpers = require.context("../../js/helpers", true, /^(.*\.(js$))[^.]*$/igm);
helpers.keys().forEach(function (key) {
    helpers(key);
});
var models = require.context("../../js/models", true, /^(.*\.(js$))[^.]*$/igm);
models.keys().forEach(function (key) {
    models(key);
});
var adminModels = require.context("./models", true, /^(.*\.(js$))[^.]*$/igm);
adminModels.keys().forEach(function (key) {
    adminModels(key);
});
var apps = require.context("./apps", true, /^(.*\.(js$))[^.]*$/igm);
apps.keys().forEach(function (key) {
    apps(key);
});