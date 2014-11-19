var HELPERS = {


    local: {

        init: function(){
            this.site();
            this.main();
        },

        site: function(){

            (function(){  })();

        },

        main: function(){

        }

    },
    /* . */



    browser: {

        ie: function(){

            if( DETECT_BROWSER[0] == "MSIE" ){

                if ( DETECT_BROWSER[1] < 9 ){
                    //ie < 9
                }

            }

        },

        mobile: function(){

            if ( IS_MOBILE.any() ) {

                //$('body').addClass('mobile')

            }

        }

    },
    /* . */





    formControls: function(){

        $('.c-input').focus(function() {
            $(this).removeClass('c-input-error');
            $(this).closest('.c-input-outer').removeClass('c-input-error');
            $(this).next(".form-tip-error").hide();
            $(this).closest('.c-input-outer').next(".form-tip-error").hide();
        });

    },
    /* . */





    rangeSlider: {
        setVal: function(obj){
            var $outer = obj.input.closest('.c-range-outer-simple'),
                $outputMin = $outer.find('.c-range-output-min'),
                $outputMax = $outer.find('.c-range-output-max');
            $outputMin.val(obj.fromNumber);
            $outputMax.val(obj.toNumber);
        }
    },
    /* . */






    googleMaps: {

        places: [
            [
                "Мерчендайзер (соки, снеки)",
                59.9369183,
                30.3230151,
                "<img src='/assets/images/star.png' />",
                "от 26 000 руб. ",
                "АРЕС, Санкт-Петербург "
            ],
            [
                "Менеджер",
                59.9377567,
                30.3221354,
                "<img src='/assets/images/star.png' />",
                "от 26 000 руб.",
                "АРЕС, Санкт-Петербург"
            ]
        ],

        styles:[
            {
              "featureType": "water",
              "stylers": [
                { "visibility": "on" },
                { "saturation": 0 },
                { "lightness": -13 }
              ]
            }
        ],

        actions: function(map, markers, addMarkers){


            //______________Vars______________

            //путь к спрайту, размеры одного маркера в спрайте, background-position, смещение маркера (left, top)
            var icon1 = new google.maps.MarkerImage("/assets/images/map-marker-sprite.png", new google.maps.Size(27, 40), new google.maps.Point(0, 0), new google.maps.Point(14, 40));
            var icon2 = new google.maps.MarkerImage("/assets/images/map-marker-sprite.png", new google.maps.Size(27, 40), new google.maps.Point(28, 0), new google.maps.Point(14, 40));

            var y = markers[0].getPosition().lat();
            var x = markers[0].getPosition().lng();

            var iw = new google.maps.InfoWindow();

            var newPlaces = [

                [
                    "Мерчендайзер",
                    59.9376654,
                    30.3250751,
                    "<img src='/assets/images/star.png' />",
                    "от 26 000 руб.",
                    "АРЕС, Санкт-Петербург"
                ],
                [
                    "Мерчендайзер",
                    59.938047,
                    30.3239807,
                    "<img src='/assets/images/star.png' />",
                    "от 26 000 руб.",
                    "АРЕС, Санкт-Петербург"
                ]

            ];


            //______________Init______________

            addMarkersActions();

            $('.map-btn').click(function(event) {
                 map.panTo(new google.maps.LatLng( markers[0].getPosition().lat(), markers[0].getPosition().lng() ));
                 map.setZoom(16);
                 return false;
            });

            $('.map-btn-2').click(function(event) {
                map.clearOverlays();
                markers = [];
                addMarkers(map, newPlaces, markers);
                addMarkersActions();
                return false;
            });


            //______________Functions______________

            google.maps.Map.prototype.clearOverlays = function() {
              for (var i = 0; i < markers.length; i++ ) {
                markers[i].setMap(null);
              }
              markers.length = 0;
            }

            function addMarkersActions(){

                for (var i = 0; i < markers.length; i++) {

                    google.maps.event.addListener(markers[i], 'mouseover', function() {
                        if (iw.content) return;
                        this.setIcon(icon2);
                    });

                    google.maps.event.addListener(markers[i], 'mouseover', function() {
                        if (iw.content) return;
                        this.setIcon(icon2);
                    });
                    google.maps.event.addListener(markers[i], 'mouseout', function() {
                        if (iw.content) return;
                        this.setIcon(icon1);
                    });
                    google.maps.event.addListener(markers[i], 'click', function() {
                         for (var i = 0; i < markers.length; i++) {
                            markers[i].setIcon(icon1);
                         }
                         this.setIcon(icon2);
                         iw.setContent( popUpMarkUp(this.contentPic, this.title, this.contentPrice, this.contentAddress) );
                         iw.open(map,this);
                         map.panTo(new google.maps.LatLng( this.getPosition().lat(), this.getPosition().lng() ));
                    });

                }

                google.maps.event.addListener(map, 'click', function(){
                    iw.close();
                    iw.content = undefined;
                    console.log(iw);
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setIcon(icon1);
                    }
                });

                google.maps.event.addListener(iw, 'closeclick', function() {
                    this.content = undefined;
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setIcon(icon1);
                    }
                });


            }

            function popUpMarkUp(pic, title, price, address){

                return "<div class='c-map-popup'> <div class='c-map-popup'> <div class='c-map-popup-pic'> "+pic+" </div> <div class='c-map-popup-title'> "+title+" </div> <div class='c-map-popup-price'> "+price+" </div> <div class='c-map-popup-address'> "+address+" </div> </div> </div> </div>";

            }
        }



    }
    /* . */



} /*____________End Helpers____________*/