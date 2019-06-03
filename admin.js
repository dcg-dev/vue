const gulp = require('gulp');
const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');
require('laravel-elixir-remove');

elixir(mix => {
//    mix.remove([
//        'public/fonts',
//        'public/images',
//        'public/ckeditor',
//        'public/css',
//        'public/js',
//        'admin',
//    ]);
    
    // Admin
    mix.sass('../admin/sass/app.scss', 'public/admin/css/app.css');
    mix.copy('resources/assets/admin/vendor/font-awesome/fonts', 'public/admin/fonts')
    mix.styles([
        'resources/assets/admin/vendor/bootstrap/css/bootstrap.css',
        'resources/assets/admin/vendor/animate/animate.css',
        'resources/assets/admin/vendor/font-awesome/css/font-awesome.css',
        'resources/assets/admin/vendor/bootstrapSocial/bootstrap-social.css',
        'resources/assets/admin/vendor/jasny/jasny-bootstrap.min.css',
        'resources/assets/admin/vendor/select2/select2.min.css',
        'resources/assets/admin/vendor/toastr/toastr.min.css',
        'resources/assets/admin/vendor/bootstrap3-editable/bootstrap3-editable/css/bootstrap-editable.css',
        'resources/assets/admin/vendor/ladda/ladda.min.css',
        'resources/assets/admin/vendor/ladda/ladda-themeless.min.css',
        'resources/assets/admin/vendor/sweetalert/sweetalert.css',
        'resources/assets/admin/vendor/daterangepicker/daterangepicker-bs3.css',
        'resources/assets/admin/vendor/datapicker/datepicker3.css',
        'resources/assets/admin/vendor/datapicker/bootstrap-datetimepicker.min.css',
        'resources/assets/admin/vendor/iCheck/custom.css',
    ], 'public/admin/css/vendor.css', './');
    mix.scripts([
        'resources/assets/admin/vendor/jquery/jquery-2.1.1.js',
        'resources/assets/admin/vendor/bootstrap/js/bootstrap.js',
        'resources/assets/admin/vendor/metisMenu/jquery.metisMenu.js',
        'resources/assets/admin/vendor/slimscroll/jquery.slimscroll.min.js',
        'resources/assets/admin/vendor/pace/pace.min.js',
        'resources/assets/admin/vendor/jasny/jasny-bootstrap.min.js',
        'resources/assets/admin/vendor/select2/select2.full.min.js',
        'resources/assets/admin/vendor/toastr/toastr.min.js',
        'resources/assets/admin/vendor/bootstrap3-editable/bootstrap3-editable/js/bootstrap-editable.js',
        'resources/assets/admin/vendor/moment/moment.js',
        'resources/assets/admin/vendor/ladda/spin.min.js',
        'resources/assets/admin/vendor/ladda/ladda.min.js',
        'resources/assets/admin/vendor/ladda/ladda.jquery.min.js',
        'resources/assets/admin/vendor/chartJs/Chart.min.js',
        'resources/assets/admin/vendor/sweetalert/sweetalert.min.js',
        'resources/assets/admin/vendor/daterangepicker/daterangepicker.js',
        'resources/assets/admin/vendor/datapicker/bootstrap-datepicker.js',
        'resources/assets/admin/vendor/datapicker/bootstrap-datetimepicker.min.js',
        'resources/assets/admin/vendor/iCheck/icheck.min.js',
    ], 'public/admin/js/vendor.js', './');
    mix.webpack('../admin/js/app.js', 'public/admin/js/app.js');
    
//    mix.version(['css/app.css', 'js/app.js']);
//    mix.version(['admin/css/app.css', 'admin/js/app.js','admin/css/vendor.css', 'admin/js/vendor.js']);
});