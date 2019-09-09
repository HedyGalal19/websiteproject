<?php require 'connections.php'; ?>
<?php
//Resumes the session for current user
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
//get user id from url
$delete_id = $_GET[ 'del' ];
//check for user UserID being present
if ( isset( $_SESSION[ "userID" ] ) ) {
	//Checks if user is logged in
	if ( $_SESSION[ "admin" ] === 0 ) {
        //direct to Account Page 
		header( "Location: ../index.php" );
	} else {
        //Not to allow current admin to delete their profile
		if ( $delete_id == $_SESSION[ "userID" ] ) {
			header( "Location: ../adminpanel/admin.php" );
		} else {
            //delete selected user from database
			$delete_query = "delete from Users WHERE userID='$delete_id'"; //delete query
			$run = mysqli_query( $con, $delete_query );
			if ( $run ) {
				//javascript function to open in the same window
				header( "Location: ../adminpanel/admin.php" );
			}
		}
	}
} else {
    //direct to login Page
	header( "Location: ../login.php" );
}
?>