		<!----------------------- Jquery file ---------------------->
<script src="../js/plugins/jquery/jquery.min.js"></script>
<script src="../js/plugins/bootstrap/popper.min.js"></script>
		<!----------------------- Navbar Scrolling ---------------------->
<script src="../js/javascript_functions.js"></script>
		<!----------------------- Bootstrap core JavaScript ------------->
<script src="../js/plugins/bootstrap/bootstrap.min.js"></script>
		<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="../js/plugins/bootstrap/holder.min.js"></script>

		<!-- SweetAlert Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>

<!----------------------- validation plugin javascripts --------->
<script src="../js/plugins/jquery-validation/jquery.validate.min.js"></script>
		<!----------------------- validation rules ------------->
<script src="../js/formvalidations.js"></script>
		<!----------------------- show map ------------->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMbFhcsk8fr1O9Iu9vijG_QfHdohTcTQI&callback=initMap"></script>



<!-- Latest compiled and minified JavaScript -->
<script src="../js/plugins/bootstrapselect/bootstrap-select.min.js"></script>


		<!----------------------- active menu setting ------------->
<script>
	var url = window.location;
	// Will only work if string in href matches with location
	$( 'ul li a[href="' + url + '"]' ).parent().addClass( 'active' );

	// Will also work for relative and absolute hrefs
	$( 'ul li a' ).filter( function () {
		return this.href == url;
	} ).parent().addClass( 'active' );
</script>


		<!-- show company map -->
<script>
	function initialize() {
		var mapOptions = {
			zoom: 16,
			center: new google.maps.LatLng( 50.796869, 0.286594 ),
			mapTypeId: google.maps.MapTypeId.TERRAIN
		};

		var map = new google.maps.Map( document.getElementById( 'location-canvas' ),
			mapOptions );

		var marker = new google.maps.Marker( {
			map: map,
			draggable: false,
			position: new google.maps.LatLng( 50.796869, 0.286594 )
		} );
	}

	google.maps.event.addDomListener( window, 'resize', initialize );
	google.maps.event.addDomListener( window, 'load', initialize );

	$( document ).ready( function () {
		$( '.button' ).click( function () {
			$( '#location-canvas' ).fadeToggle();
			initialize(); // initialize the map
			$( '#location-canvas' ).get( 0 ).scrollIntoView();
			$( this ).text( $( this ).text() == "Hide map" ? "Show map" : "Hide map" );
		} );
	} );
</script>