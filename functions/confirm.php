<?php require 'connections.php'; ?>
<?php
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );
//confirm that account is activated
//checks if there is a passkey parameter in the url
if ( isset( $_GET[ 'passkey' ] ) ) {
	$passkey = $_GET[ 'passkey' ];
	//check the parameter code matches the code in the database.
	$sql = "UPDATE Users SET com_code=NULL WHERE com_code='$passkey'";
	$result = mysqli_query( $con, $sql )or die( mysqli_error() );
	if ( $result ) {
		$_SESSION['confirm'] = 'yes';
		header('Location: ../login');
	}else{
		header('Location: ../index');
	}
}else{
	header('Location: ../index');
}

?>
<!doctype html>
<html lang="en">

<head>
	<!-- include the head file-->
	<?php require '../includes/head.php'; ?>
</head>

<body>
	<!-- scripts and functions -->
	<?php require '../includes/script.php'; ?>

</body>

</html>