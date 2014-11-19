$(document).ready(function() {

    $('body').stickTheFooter();

    $('input, textarea').placeholder({
        color : '#8f8f8f'
    });

    $(".c-input-phone").inputmask({ mask: "+7[-999][-999999]",
        greedy: false,
        showMaskOnHover: false,
        'clearIncomplete': false,
        clearMaskOnLostFocus: false
    });

    $('.dropdown-on').dropdown();

    $('.fancybox').fancybox();

    $('.fancybox-modal').fancybox({
        // modal:true,
        closeBtn:false
    });

    $('.c-slider-on').bxSlider();

    $('.c-slider-fade-on').bxSlider({
        mode:'fade'
    });

    $('.c-tabs-on').tabslet({
        animation: true
    });

    $('.toggle-box').toggleBox();

    $('.c-input').focus(function() {
        $(this).removeClass('c-input-error');
        $(this).closest('.c-input-outer').removeClass('c-input-error');
    });

    $('#map_canvas').createMap({
        centerY:59.937266,
        centerX:30.322400,
        zoom:17,
        places: HELPERS.googleMaps.places,
        markerImgUrl:'/assets/images/map-marker-sprite.png',
        markerWidth:27,
        markerHeight:40,
        markerOffsetX:14,
        markerOffsetY:40,
        animation: google.maps.Animation.DROP,
        styles: HELPERS.googleMaps.styles,
        draggable: IS_MOBILE.any() ? false : true,
        actions: function(map, markers, infowindow, addMarkers){
            HELPERS.googleMaps.actions(map, markers, addMarkers);
        }
    });

    $('.datepicker').datetimepicker({
        lang:'ru',
        timepicker:false,
        format:'d.m.Y',
        dayOfWeekStart:1,
        closeOnDateSelect:true,
        scrollInput: false,
        scrollMonth: false,
        onChangeMonth: function(current_time, $input){
            $input.val( current_time.dateFormat('d.m.Y') );
        }
    });

    $(".c-range").ionRangeSlider();

    $('.c-range-double').ionRangeSlider({
        type:'double',
        min:1000,
        max:50000,
        from:10000,
        to:40000,
        step: 1000,
        prefix: "",
        prettify: true,
        onLoad:   function (obj) {
            HELPERS.rangeSlider.setVal(obj);
        },
        onChange: function (obj) {
            HELPERS.rangeSlider.setVal(obj);
        }
    });

    $('.active-toggle').click(function(){
        $(this).toggleClass('active');
    });

    HELPERS.browser.ie();
    HELPERS.browser.mobile();
    HELPERS.formControls();
    HELPERS.local.init();


}); /*_____________End_______________*/