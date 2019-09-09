<?php require 'connections.php'; ?>
<?php
//check for Email being entered
if ( isset( $_POST[ 'Email' ] ) ) {
    //prepare and bind
	$stmt = $con->prepare( "SELECT 'email' FROM Users WHERE email = ?" );
	$stmt->bind_param( "s", $email );
	$email = $_POST[ 'Email' ];
	$stmt->execute();
	$stmt->store_result();
	$email_check = "";
	$stmt->bind_result( $email_check );
	$stmt->fetch();
    
    //check if email there more than 1 email in database
	if ( $stmt->num_rows >= 1 ) {
		echo '<div style="color: red; font-size: 10px;"> <b>' . $email . '</b> is already in use! </div>';
		$stmt->close();
	} else {

	}

	}
?>