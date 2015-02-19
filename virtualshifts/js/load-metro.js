$(function(){
    var app_rul = 'http://184.168.29.222/virtualshifts/';
    if ((document.location.host.indexOf('.dev') > -1) || (document.location.host.indexOf('modernui') > -1) ) {
        $("<script/>").attr('src', app_rul+'js/metro/metro-loader.js').appendTo($('head'));
    } else {
        $("<script/>").attr('src', app_rul+'js/metro.min.js').appendTo($('head'));
    }
})