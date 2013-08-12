(function( $ ) {

	function GoogleMapType(settings, map_el) {

		var settings = $.extend( {
			  'search_input_el'    : null,
			  'search_action_el'   : null,
			  'search_error_el'    : null,
			  'current_position_el': null,
			  'default_lat'        : '1',
			  'default_lng'        : '-1',
			  'default_zoom'       : 5,
			  'lat_field'          : null,
			  'lng_field'          : null,
			  'callback'           : function (location, gmap) {},
			  'error_callback'     : function(status) {
			  	$this.settings.search_error_el.text(status);
			  },
			}, settings);

		this.settings = settings;

		this.map_el = map_el;

		this.geocoder = new google.maps.Geocoder();

	}

	GoogleMapType.prototype = {
		initMap : function(center) {

			var center = new google.maps.LatLng(this.settings.default_lat, this.settings.default_lng);

			var mapOptions = {
				zoom: this.settings.default_zoom,
				center: center,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			var $this = this;
			
			this.map =  new google.maps.Map(this.map_el[0], mapOptions);

			this.addMarker(center);

			google.maps.event.addListener(this.marker, "dragend", function(event) {

				var point = $this.marker.getPosition();
				$this.map.panTo(point);
				$this.updateLocation(point);

			});

			google.maps.event.addListener(this.map, 'click', function(event) {
				$this.insertMarker(event.latLng);
			});

			this.settings.search_action_el.click($.proxy(this.searchAddress, $this));
			
			this.settings.current_position_el.click($.proxy(this.currentPosition, $this));
		},

		searchAddress : function (e){
			e.preventDefault();
			var $this = this;
			var address = this.settings.search_input_el.val();
			this.geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$this.map.setCenter(results[0].geometry.location);
					$this.map.setZoom(16);
					$this.insertMarker(results[0].geometry.location);
				} else {
					$this.settings.error_callback(status);
				}
			});
		},

		currentPosition : function(e){
			e.preventDefault();
			var $this = this;
			
			if ( navigator.geolocation ) {
				navigator.geolocation.getCurrentPosition ( 
					function(position) {
						var clientPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						$this.insertMarker(clientPosition);
						$this.map.setCenter(clientPosition);
						$this.map.setZoom(16);
					}, 
					function(error) {
						$this.settings.error_callback(error);
					}
				);      
			} else {
				$this.settings.search_error_el.text('Your broswer does not support geolocation');
			}
			
		},

		updateLocation : function (location){
			this.settings.lat_field.val(location.lat());
			this.settings.lng_field.val(location.lng());
			this.settings.callback(location, this);
		},

		addMarker : function(center) {
			if(this.marker){
				this.marker.setMap(this.map);
				this.marker.setPosition(center);
			}else{
				this.marker = new google.maps.Marker({
					map: this.map,
					position: center,
					draggable: true
				});
			}
		},

		insertMarker : function (position) {
			this.removeMarker();

			this.addMarker(position);

			this.updateLocation(position);

		},
		removeMarker : function () {
			if(this.marker != undefined){
				this.marker.setMap(null);
			}
		}

	}

	$.fn.ohGoogleMapType = function(settings) {

		settings = $.extend({}, $.fn.ohGoogleMapType.defaultSettings, settings || {});

		return this.each(function() {
			var map_el = $(this);

			map_el.data('map', new GoogleMapType( settings, map_el ));

			map_el.data('map').initMap();

		});

	};
	
	$.fn.ohGoogleMapType.defaultSettings = {
			  'search_input_el'    : null,
			  'search_action_el'   : null,
			  'search_error_el'    : null,
			  'current_position_el': null,
			  'default_lat'        : '1',
			  'default_lng'        : '-1',
			  'default_zoom'       : 5,
			  'lat_field'          : null,
			  'lng_field'          : null,
			  'callback'           : function (location, gmap) {},
			  'error_callback'     : function(status) {
			  	$this.settings.search_error_el.text(status);
			  }
			}

})( jQuery );
