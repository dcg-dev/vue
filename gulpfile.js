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
    
    mix.less('app.less');
    mix.copy('resources/assets/fonts', 'public/fonts');
    mix.copy('resources/assets/img', 'public/images');
    mix.webpack('app.js');
    
//    mix.version(['css/app.css', 'js/app.js']);
//    mix.version(['admin/css/app.css', 'admin/js/app.js','admin/css/vendor.css', 'admin/js/vendor.js']);
});