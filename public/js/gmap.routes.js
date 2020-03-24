/**
 * @author Giri Jeedigunta
 * Visit: http://thewebstorebyg.wordpress.com/ for more tutorials on maps
 */

(function (mapDemo, $, undefined) {


    mapDemo.Directions = (function () {
        function _Directions() {

            var map,
                directionsService, directionsDisplay,
                autoSrc, autoDest,

               
                // Caching the Selectors		
                $Selectors = {
                    dirPanel: jQuery('#directionsPanel'),
                    dirInputs: jQuery('.directionInputs'),
                    dirSrc: jQuery('#dirSource'),
                    dirDst: jQuery('#dirDestination'),
                    getDirBtn: jQuery('#basket_house'),
                    dirSteps: jQuery('#directionSteps'),
                    dirInfo: jQuery('#directionInfo'),
                    paneToggle: jQuery('#paneToggle'),
                    useGPSBtn: jQuery('#useGPS'),
                    paneResetBtn: jQuery('#paneReset')
                },

                autoCompleteSetup = function () {
                   // autoSrc = new google.maps.places.Autocomplete($Selectors.dirSrc[0]);
                  //  autoDest = new google.maps.places.Autocomplete($Selectors.dirDst[0]);
                }, // autoCompleteSetup Ends

                directionsSetup = function () {
                    directionsService = new google.maps.DirectionsService();
                    directionsDisplay = new google.maps.DirectionsRenderer({
                        suppressMarkers: true
                    });

                    directionsDisplay.setPanel($Selectors.dirSteps[0]);
                }, // direstionsSetup Ends

                trafficSetup = function () {
                    // Creating a Custom Control and appending it to the map
                    var controlDiv = document.createElement('div'),
                        controlUI = document.createElement('div'),
                        trafficLayer = new google.maps.TrafficLayer();

                    jQuery(controlDiv).addClass('gmap-control-container').addClass('gmnoprint');
                    jQuery(controlUI).text('Traffic').addClass('gmap-control');
                    jQuery(controlDiv).append(controlUI);

                    // Traffic Btn Click Event	  
                    google.maps.event.addDomListener(controlUI, 'click', function () {
                        if (typeof trafficLayer.getMap() == 'undefined' || trafficLayer.getMap() === null) {
                            jQuery(controlUI).addClass('gmap-control-active');
                            trafficLayer.setMap(map);
                        } else {
                            trafficLayer.setMap(null);
                            jQuery(controlUI).removeClass('gmap-control-active');
                        }
                    });
                    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);
                }, // trafficSetup Ends

        

                directionsRender = function (source, destination, id) {
                  //  $Selectors.dirSteps.find('.msg').hide();
                   // directionsDisplay.setMap(map);

                    var getTravelMode = 'DRIVING';

                    var request = {
                        origin: source,
                        destination: destination,
                        provideRouteAlternatives: false,
                        travelMode: google.maps.DirectionsTravelMode[getTravelMode]
                    };




                    directionsService.route(request, function (response, status) {
                        console.log('status='+status);
                        if (status == google.maps.DirectionsStatus.OK) {
                                
                           // directionsDisplay.setDirections(response);

                            var _route = response.routes[0].legs[0]; 
                           // $Selectors.dirInfo.html('Расстоение <b>' + _route.distance.text + '</b><br>Время <b>' + _route.duration.text + '</b>');
                            var distance = _route.distance.text.slice( 0, -3);
                            console.log('distance='+distance);
                            $('.distance').val(distance);
                            getGradation(id, distance);
                          /*
                             pinA = new google.maps.Marker({
                                                           position: _route.start_location,
                                                           map: map,
                                                           icon: markerA
                                                       }),
                                                       pinB = new google.maps.Marker({
                                                           position: _route.end_location,
                                                           map: map,
                                                           icon: markerB
                                                       });
                           */
                        }
                    });
                }, // directionsRender Ends

              




                invokeEvents = function () {
                    
                    // Get Directions
                     // Get Directions
                    $Selectors.getDirBtn.on('blur', function (e) {
                        if($('#basket_house').val() != '') {
                            var cntRest = JSON.parse(jQuery.cookie("cntRest"));
                            e.preventDefault();
                            // var src = jQuery("#source").val(),
                            //     dst = 'Донецк, '+jQuery("#dest").val();
                            for(var i =0; i< cntRest.length; i++) {
                                
                                var src = 'Донецк, '+cntRest[i].restAddr,               
                                    dst = 'Донецк, '+ $("#basket_street").val() + ' ' + $('#basket_house').val();
                                                          
                                directionsRender(src, dst, cntRest[i].id);
                                console.log('src='+src);
                                console.log('dst='+dst);
                            }
                        }
                        else {
                            $.cookie('price_delivery', null, {path:'/'});
                        }
                    });

                    // Reset Btn
                    $Selectors.paneResetBtn.on('click', function (e) {
                        $Selectors.dirSteps.html('');
                        $Selectors.dirSrc.val('');
                        $Selectors.dirDst.val('');

                        if (pinA) pinA.setMap(null);
                        if (pinB) pinB.setMap(null);

                        directionsDisplay.setMap(null);
                    });

                    // Toggle Btn
                    $Selectors.paneToggle.toggle(function (e) {
                        $Selectors.dirPanel.animate({
                            'left': '-=305px'
                        });
                        jQuery(this).html('&gt;');
                    }, function () {
                        $Selectors.dirPanel.animate({
                            'left': '+=305px'
                        });
                        jQuery(this).html('&lt;');
                    });

                    // Use My Location / Geo Location Btn
                    $Selectors.useGPSBtn.on('click', function (e) {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                fetchAddress(position);
                            });
                        }
                    });
                }, //invokeEvents Ends 

                _init = function () {
                    directionsSetup();
                    invokeEvents();
                }; // _init Ends

            this.init = function () {
                _init();
                return this; // Refers to: mapDemo.Directions
            }
            return this.init(); // Refers to: mapDemo.Directions.init()
        } // _Directions Ends
        return new _Directions(); // Creating a new object of _Directions rather than a funtion
    }()); // mapDemo.Directions Ends

})(window.mapDemo = window.mapDemo || {}, jQuery);