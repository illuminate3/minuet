import $ from 'jquery';
window.jQuery = $;
window.$ = $;
import 'bootstrap';
import 'lazysizes';
import bootbox from 'bootbox';
import swal from 'sweetalert';
window.bootbox = bootbox;

'use strict';

import Cookies from 'js-cookie/src/js.cookie';

/*=============================================
    =    		 Preloader			      =
=============================================*/
function preloader() {
    $('.preloader').delay(0).fadeOut();
};

$(document).ready(() => {
    preloader();
});
