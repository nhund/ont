/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: url_upload,
    //     done : function (e, data) {
    //         console.log(e);
    // // data.result
    // // data.textStatus;
    // // data.jqXHR;
    //     }
    });

    // Enable iframe cross-domain access via redirect option:
    // $('#fileupload').fileupload(
    //     'option',
    //     'redirect',
    //     // window.location.href.replace(
    //     //     /\/[^\/]*$/,
    //     //     '/cors/result.html?%s'
    //     // )
    // );

    // Load existing files:
        // $('#fileupload').addClass('fileupload-processing');
        // $.ajax({
        //     // Uncomment the following to send cross-domain cookies:
        //     //xhrFields: {withCredentials: true},
        //     headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
        //     url: $('#fileupload').fileupload('option', 'url'),
        //     dataType: 'json',
        //     context: $('#fileupload')[0]
        // }).always(function () {
        //     $(this).removeClass('fileupload-processing');
        // }).done(function (result) {
        //     cón
        //     $(this).fileupload('option', 'done')
        //         .call(this, $.Event('done'), {
        //             result: result
        //         });
        // });

});
