if(typeof Chart === "undefined")
    throw "ChartJS is undefined";
// 4 kb here
window.VueCharts = {};

VueCharts.core = require('./vue-chartjs-lib.js');

VueCharts.install = function (Vue) {
    Vue.component('chartjs-line', require('../../components/charts/chartjs-line.vue'));
    Vue.component('chartjs-bar', require('../../components/charts/chartjs-bar.vue'));
    Vue.component('chartjs-horizontal-bar', require('../../components/charts/chartjs-horizontal-bar.vue'));
    Vue.component('chartjs-radar', require('../../components/charts/chartjs-radar.vue'));
    Vue.component('chartjs-polar-area', require('../../components/charts/chartjs-polar-area.vue'));
    Vue.component('chartjs-pie', require('../../components/charts/chartjs-pie.vue'));
    Vue.component('chartjs-doughnut', require('../../components/charts/chartjs-doughnut.vue'));
}
