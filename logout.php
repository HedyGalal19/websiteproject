<?php require 'functions/connections.php'; ?>
<?php
//resumes the session for current user
session_start();
//destroys the 'UserID' variables.
unset($_SESSION["UserID"]);
//destroys the session.
session_destroy();
//direct users to home page page when logged out
header( 'Location: index' );
?>

