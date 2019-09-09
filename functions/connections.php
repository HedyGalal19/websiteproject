<?php
//connects to the database
$con = mysqli_connect("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
//$con = mysqli_connect("localhost", "root", "root", "userregtutorial");
$getadmin = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM Users WHERE userID = $id"));
$admin = $getadmin['admin'];
$id = $_SESSION['userID'];
?>