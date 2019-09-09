<?php require 'connections.php'; ?>
<?php
//get the maxium id from user table. used for when adding new user form admin booking form
$q = "select max(userID)+1 from Users";
$result = mysqli_query($con,$q);
$data = mysqli_fetch_array($result);
echo $data[0];
?>