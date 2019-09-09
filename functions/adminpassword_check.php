<?php require 'connections.php'; ?>
<?php
session_start();
if ( isset( $_POST[ 'Password' ] ) ) {
	//Prepare and bind
	$stmt = $con->prepare( "SELECT * FROM Users WHERE userID = ?" );
	$stmt->bind_param( "i", $userID );
	$userID = $_SESSION[ 'userID' ];
	$oldPassword = $_POST[ 'Password' ];
	$stmt->execute();
	$result = $stmt->get_result();
	if ( $row = $result->fetch_assoc() ) {
		$hashedPwdCheck = password_verify( $oldPassword, $row[ 'password' ] );
		if ( $hashedPwdCheck == false ) {
			echo '<div style="color: red; font-size: 12px;"> Incorrect password. </div>';
			$stmt->close();
		} elseif ( $hashedPwdCheck == true ) {
			$stmt->close();
		}
	}
}
?>