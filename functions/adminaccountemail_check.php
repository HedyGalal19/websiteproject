<?php require 'connections.php'; ?>
<?php
session_start();
if ( isset( $_POST[ 'Email' ] ) ) {
	$stmt = $con->prepare( "SELECT 'Email' FROM Users WHERE email = ? AND userID <> ?" );
	$stmt->bind_param( "si", $email, $id );

	$email = $_POST[ 'Email' ];
	$id = $_POST[ 'id' ];
	
	$stmt->execute();
	$stmt->store_result();
	$email_check = "";
	$stmt->bind_result( $email_check );
	$stmt->fetch();

	if ( $stmt->num_rows >= 1 ) {
		echo '<div style="color: red; font-size: 10px;"> <b>' . $email . '</b> is already in use! </div>';
 		$stmt->close();
	}
	}
?>