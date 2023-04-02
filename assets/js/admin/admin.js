'use strict';

$(document).ready(function () {

    if (document.getElementById('menu_isSlug').checked) {
        document.getElementById('menu_url').disabled = true;
    }
    $('#menu_isSlug').click(function () {
        if (document.getElementById('menu_isSlug').checked) {
            document.getElementById('menu_url').disabled = true;
        } else {
            document.getElementById('menu_url').disabled = false;
        }
    });

});
