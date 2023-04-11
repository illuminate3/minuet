'use strict';

import Cookies from 'js-cookie/src/js.cookie';

$(document).ready(() => {
    let currentUrl = window.location.href;
    $('.collapse').each(function () {
        let sidebarLink = $('a', this).attr('href');
        let segments = sidebarLink.split('/');
        if ( currentUrl.includes(sidebarLink) ) {
            $(this).addClass('show');
            if ( segments[2] === 'menu' ) {
                $('.menu').attr('aria-expanded', 'true');
            }
            if ( segments[2] === 'page' ) {
                $('.page').attr('aria-expanded', 'true');
            }
            if ( segments[2] === 'product' ) {
                $('.product').attr('aria-expanded', 'true');
            }
            if ( segments[2] === 'category' ) {
                $('.category').attr('aria-expanded', 'true');
            }
        }
    });
});
