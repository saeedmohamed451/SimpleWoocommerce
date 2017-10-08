(function ($) {
	"use strict";
	var G5PlusGoogleMap = {
		init: function() {
			var mapStyleArr = [];
			mapStyleArr['none'] = [];
			mapStyleArr['gray_scale'] = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];
			mapStyleArr['icy_blue'] = [{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}];
			mapStyleArr['mono_green'] = [{"featureType":"all","elementType":"geometry","stylers":[{"color":"#8dcaaa"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#8dcaaa"},{"lightness":"60"},{"saturation":"20"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#8dcaaa"},{"lightness":"-40"},{"weight":"3"},{"saturation":"10"}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":"-20"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"lightness":"-15"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"-35"}]},{"featureType":"water","elementType":"all","stylers":[{"lightness":"-10"}]}];
			$('.handmade-google-map').each(function () {
				var locationX = $(this).attr('data-location-x');
				var locationY = $(this).attr('data-location-y');
				var markerTitle = $(this).attr('data-marker-title');
				var mapZoom = $(this).attr('data-map-zoom');
				var mapStyle = $(this).attr('data-map-style');

				if (locationX == '') {
					locationX = 0;
				}
				if (locationY == '') {
					locationY = 0;
				}
				if (mapZoom == '') {
					mapZoom = 11;
				}
				mapZoom = parseInt(mapZoom, 10);
				if (typeof (mapStyleArr[mapStyle]) == "undefined") {
					mapStyle = 'none';
				}

				// Basic options for a simple Google Map
				// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
				var mapOptions = {
					// How zoomed in you want the map to start at (always required)
					zoom: mapZoom,
					scrollwheel: false,

					// The latitude and longitude to center the map (always required)
					center: new google.maps.LatLng(locationX, locationY), // New York

					// How you would like to style the map.
					// This is where you would paste any style found on Snazzy Maps.
					styles: mapStyleArr[mapStyle]
				};

				// Get the HTML DOM element that will contain your map
				// We are using a div with id="map" seen below in the <body>
				var mapElement = this;

				// Create the Google Map using our element and options defined above
				var map = new google.maps.Map(mapElement, mapOptions);

				// Let's also add a marker while we're at it
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(locationX, locationY),
					map: map,
					title: markerTitle
				});
			});
		}
	};
	$(document).ready(G5PlusGoogleMap.init);
})(jQuery);