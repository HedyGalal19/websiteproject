<?php require 'connections.php'; ?>
<?php
if ( isset( $_POST[ 'date' ] ) && !empty( $_POST[ 'date' ] ) ) {
	$date = $_POST[ 'date' ];
	$stmt = $con->prepare( "SELECT timeSlot as s FROM Appointment WHERE date= ? GROUP BY s HAVING COUNT(s)>2" );
	$stmt->bind_param( "s", $date );



	$stmt->execute();

	//	$result = $stmt->bind_result($timeSlot);

	$result = $stmt->get_result();

	$times = array();
	
	while ( $data = $result->fetch_assoc() ) {
		$times[] =  $data[ 's' ];
	}
	
	$myJSON = json_encode($times);
	
	$stmt->close();
	echo $myJSON;

}
//echo $_POST[ 'date' ];

?>