'use strict';

import Cookies from 'js-cookie/src/js.cookie';

$(document).ready(() => {
    let currentUrl = window.location.href;

    $('.sidebar .nav-item').each(function () {
        let sidebarLink = $('a', this).attr('href');
        if (
            currentUrl.includes(sidebarLink) ||
            (sidebarLink.includes('locations') &&
                currentUrl.includes('locations'))
        ) {
            $(this).addClass('active');
        }
    });

    // if (currentUrl.indexOf('profile') !== -1) {
    //     $('.list-group-item-action:eq(2)').addClass('active');
    // } else if (currentUrl.indexOf('unpublished') !== -1) {
    //     $('.list-group-item-action:eq(1)').addClass('active');
    // } else {
    //     $('.list-group-item-action:eq(0)').addClass('active');
    // }

    // Toggle the side navigation
    $('#sidebarToggle').on('click', (e) => {
        let $body = $('body');
        e.preventDefault();

        if ($($body).is('.sidebar-toggled')) {
            Cookies.set('sidebar-toggled', false);
        } else {
            Cookies.set('sidebar-toggled', true);
        }

        $body.toggleClass('sidebar-toggled');
        $('.sidebar').toggleClass('toggled');
    });

});
