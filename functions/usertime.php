<?php require 'connections.php'; ?>
<?php
if ( isset( $_POST[ 'date' ] ) && !empty( $_POST[ 'date' ]) ) {
	$date = $_POST[ 'date' ];
	$user_id = $_POST['user_id'];
	$reg_num = strtolower($_POST['reg_num']);
	
	
	$stmt1 = $con->prepare( "SELECT timeSlot FROM Appointment WHERE date = ? AND reg = ?" );
	$stmt1->bind_param( "ss", $date, $reg_num);
	/* execute query */
	$stmt1->execute();
	/* store result */
	$stmt1->store_result();
	$number_of_bookings = $stmt1->num_rows;
	/* close statement */
	$stmt1->close();
	
	
	
	if($number_of_bookings < 1){
	
		$stmt = $con->prepare( "SELECT timeSlot as s FROM Appointment WHERE date = ? GROUP BY s HAVING COUNT(s)>2" );
		$stmt->bind_param( "s", $date);



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
	}else{
		echo 'invalid';
	}

}
//echo $_POST[ 'date' ];

?>