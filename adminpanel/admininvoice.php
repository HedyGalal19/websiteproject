<?php require '../functions/connections.php'; ?>
<?php
//resumes the session for current user
session_start();
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 // Checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  // Redirect to Account Page as user is not admin
  header("Location: ../index");
 }
}
else {
 // redirect to Login Page as user is not logged in
 header("Location: ../login");
}
?>
<?php
// populate product dropdown for invoice creation
function oldbooking()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
$mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 // WHERE appdone='0'
 //fetch all customers whos last booking is greater than a month
 $query = "SELECT Users.reg,Users.fname,Appointment.serviceOption, Appointment.totalPrice, Appointment.userID,Users.userID
      FROM Appointment INNER JOIN Users
           ON Appointment.userID = Users.userID ";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $serviceOption = $row["serviceOption"];
   $totalPrice = $row['totalPrice'];
   print '
                         <tr>
                          
                             <td>' . $firstName . '</td>
							 <td id="reg">' . $reg . '</td>
   						  <td>' . $serviceOption . '</td>
   						  <td>£' . $totalPrice . '</td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php include 'includes/head.php'; ?>
	   <!-- individual css -->
      <link rel="stylesheet" href="../css/adminusers.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title -->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Invoices</h2>
            </div>
         </header>
         <!-- drop down to populate table depending on option selected-->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="card">
                  <div class="card-header">
                     Invoices
                  </div>
                  <div class="card-body">
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="displayallcustomer">
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="allcustomers">
                                 <thead>
                                    <tr>
                                       <th>First Name</th>
										<th>Car Registeration</th>
                                       <th>Service Option</th>
                                       <th>Total Price</th>
                                    </tr>
                                 </thead>
                                 <?php oldbooking(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>




                  </div>
               </div>
            </div>
         </section>
         <!-- Page Footer-->
         <?php include 'includes/footer.php'; ?>
      </div>
      <!-- Javascript files-->
      <?php include 'includes/adminscripts.php'; ?>
 
   </body>
</html>