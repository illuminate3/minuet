'use strict';

$(document).ready(function () {
    let Delta = Quill.import('delta');
    let quill = new Quill('.quill', {
        modules: {
            toolbar: true
        },
        theme: 'snow'
    });
});
