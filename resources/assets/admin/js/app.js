window.serialize = function (obj, prefix) {
    var str = [], p;
    for (p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
            str.push((v !== null && typeof v === "object") ?
                    serialize(v, k) :
                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
}
window.isInt = function (value) {
    return value === parseInt(value, 10);
}
Location.prototype.params = function (params) {
    return queryString.parse(location.search, params);
}
require('./bootstrap');
$(document).ready(function () {
    $('.datepicker-default').datetimepicker({
        format: 'MM-DD-YYYY HH:mm'
    });
    $('.select2-element').select2();
    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    $.when($('#page-loader').addClass('hide')).done(function () {
        $('#wrapper').addClass('in');
    });

    function redirect(url, method) {
        var form = document.createElement('form');
        form.method = method;
        form.action = url;
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "_token";
        input.value = Laravel.csrfToken;
        form.appendChild(input);
        document.body.appendChild(form).submit();
    }
    $('a[data-redirect]').on('click', function (e) {
        e.preventDefault();
        redirect($(this).attr('href'), $(this).data('redirect'));
    });

    $('.icheckbox').iCheck({
         checkboxClass: 'icheckbox_square-red',
    });
    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('body').on('click', '.collapse-link', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('body').on('click', '.close-link', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('body').on('click', '.fullscreen-link', function () {
        var ibox = $(this).closest('div.ibox');
        if (ibox.hasClass('collapsed')) {
            ibox.find('.collapse-link').trigger('click');
        }
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Minimalize menu 
    $('body').on('click', '.navbar-minimalize', function (e) {
        e.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeigh > wrapperHeigh) {
                $('#page-wrapper').css("min-height", navbarHeigh + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                color: 'white',
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
    $('body').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
                function () {
                    $('#side-menu').fadeIn(400);
                }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
                function () {
                    $('#side-menu').fadeIn(400);
                }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

$(document).on('click', '.filter .dropdown-menu', function (e) {
    e.stopPropagation();
});