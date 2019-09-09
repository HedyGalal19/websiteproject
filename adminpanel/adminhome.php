<?php require '../functions/connections.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//resumes the session for current user
session_start();
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 // Checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  // Redirect to homepage page as user is not admin
  header("Location: ../index");
 }
}
else {
 //redirect to Login Page as user is not logged in
 header("Location: ../login");
}
?>
<?php
// populate product dropdown for invoice creation
function todaybooking()
{
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
//fetch all the booking for today
 $query = "SELECT Appointment.reg,Users.fname,Users.lname,Appointment.userID,Users.userID,Appointment.appID,Appointment.timeSlot, Appointment.date,Appointment.carSize,Appointment.serviceOption,Appointment.extraOption,Appointment.totalPrice,Appointment.servicenote
   FROM Appointment INNER JOIN Users
        ON Appointment.userID = Users.userID WHERE appdone = '0' AND Appointment.date IN (CURRENT_DATE )";
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $lastName = $row["lname"];
   $fullName = $firstName . " " . $lastName;
	  
   print '
      			    <tr>
   					<td id="reg">' . $reg . '</td>
      					<td>' . $fullName . '</td>
      				    <td>' . $row["date"] . '</td>
   					<td>' . $row["timeSlot"] . '</td>
      				    <td>        <form method="post" onsubmit="return updateappointment();">
   									<input name="userid" id="userid" type="text" value="' . $row['userID'] . '" class="form-control" hidden/>
   			<input name="appointmentid" id="appointmentid" type="text" class="form-control" value="' . $row['appID'] . '" hidden/>
   			
        <button type="button" class="btn btn-primary view-select" data-toggle="modal" data-target="#exampleModal" view-customer-userid="' . $row['userID'] . '" view-customer-appointmentid="' . $row['appID'] . '" view-customer-carsize="' . $row['carSize'] . '" view-customer-service="' . $row['serviceOption'] . '" view-customer-extra="' . $row['extraOption'] . '" view-customer-totalprice="' . $row['totalPrice'] . '" view-customer-servicenote="' . $row['servicenote'] . '"> 
     View Booking
   </button>
   			<input type="submit" id="submit" name="submit" value="Complete Service" class="btn btn-primary btn-xs customer-select" data-customer-userid="' . $row['userID'] . '" data-customer-appointmentid="' . $row['appID'] . '"></input>
           </form>
		   
		   <div id="views">
		      	   <form method="GET" action="admineditbooking.php">
   													
   			<button type="submit"  id="submit" name="edi" value="' . $row['appID'] . '" class="btn btn-primary btn-xs">Edit Booking</button>
           </form>
		   
		   
		         		     <form method="post" onsubmit="return sendsms1();">
<input name="userid1" id="userid1" type="text" value="' . $row['userID'] . '" class="form-control" hidden/>
 
			   			<input type="submit" id="sendsms" name="sendsms" value="Complete SMS" class="btn btn-primary btn-xs customer-select1" data-customer-userid1="' . $row['userID'] . '"></input>

           </form>
		   
		   </div>
		   
		   </td>
      			    </tr>
      		    ';
  }
  print '</tr>';
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
$query = "SELECT * FROM Appointment WHERE date IN (CURRENT_DATE )";
if ($stmt = $con->prepare($query)) {
 /* execute query */
 $stmt->execute();
 /* store result */
 $stmt->store_result();
 $totalBooking = $stmt->num_rows;
 /* close statement */
 $stmt->close();
}
?>
<?php
//get total number of booking for current date
$sql = "SELECT
       DATE_FORMAT(regdate,'%M %Y') AS `date`,
       COUNT(`Users`.`userID`) AS `count`
   FROM `Users`
   GROUP BY `date`
   ORDER BY `date` DESC";
$run = mysqli_query($con, $sql); //here run the sql query.
$date = array();
$count = array();
while ($row = mysqli_fetch_array($run)) {
 $date[] = $row['date'];
 $count[] = $row['count'];
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php include 'includes/head.php'; ?>
      <link rel="stylesheet" href="../css/adminhome.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Admin Home</h2>
            </div>
         </header>
         <!-- make booking button and total bookings today -->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="col">
                     <div class="card text-center">
                        <div class="card-header">
                           Welcome
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col" id="bookbutton">
                                 <a href="adminbooking.php" class="btn btn-primary">Making a Booking</a>
                              </div>
                              <div class="col">
                                 <div class="item d-flex justify-content-center">
                                    <div class="title"><span>Total Bookings Today</span>
                                    </div>
                                    <div class="number"><strong><?php echo $totalBooking; ?></strong>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
		  <!-- bookings which are today -->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="col">
                     <div class="card text-center">
                        <div class="card-header">
                           BOOKING
                        </div>
                        <div class="card-body">
                           <div class="table-responsive" id="table-responsive">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="userTable">
                                 <thead>
                                    <tr>
                                       <th>Car Reg</th>
                                       <th>Full Name</th>
                                       <th>Date</th>
                                       <th>Time</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php todaybooking(); ?>
                                 </tbody>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Modal to show the bookings detail -->
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <table class="pull-left col ">
                        <tbody>
                           <tr>
                              <td class="h6"><strong>Appointment ID:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="viewappID"></td>
                           </tr>
                           <tr>
                              <td class="h6"><strong>Customer ID:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="viewuserID"></td>
                           </tr>
                           <tr>
                              <td class="h6"><strong>Car Size:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="viewcarsize"></td>
                           </tr>
                           <tr>
                              <td class="h6"><strong>Service:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="viewservice"></td>
                           </tr>
                           <tr>
                              <td class="h6"><strong>Extra Options:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="viewextra"></td>
                           </tr>
                           <tr>
                              <td class="h6"><strong>Total Price:</strong>
                              </td>
                              <td> </td>
                              <td class="h5" id="totalprice"></td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="clearfix"></div>
                     <p id="servicenote"><br>
                     </p>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Footer-->
         <?php include 'includes/footer.php'; ?>
      </div>
      </div>
      </div>
      <!-- Javascript files-->
      <?php include 'includes/adminscripts.php'; ?>
      <script>
         $( document ).ready( function () {
         
         
         	$( "#userTable_wrapper" ).removeClass( "container-fluid" );
         
         	$( "input[type='search']" ).keyup( function () {
         		if ( $( "input[type='search']" ).val() == '' ) {
         
         			$( "#userTable_paginate" ).hide();
         		} else {
         
         			$( "#userTable_paginate" ).show();
         		}
         	} );

         
         	$( '#userTable_length' ).remove();
         	$( '#userTable_info' ).remove();
         
         
         
         
         	var table = $( '#userTable' ).DataTable();
         	$( document ).on( 'click', ".customer-select", function ( e ) {
         		var customer_appointmentid = $( this ).attr( 'data-customer-appointmentid' );
         		var customer_userid = $( this ).attr( 'data-customer-userid' );
         
         		$( '#userid' ).val( customer_userid );
         		$( '#appointmentid' ).val( customer_appointmentid );
         
         
         	} );
			 
			 
			    $( document ).on( 'click', ".customer-select1", function ( e ) {
         		var customer_userid1 = $( this ).attr( 'data-customer-userid1' );
         
         		$( '#userid1' ).val( customer_userid1 );
         
         
         	} );
         
         	$( document ).on( 'click', ".view-select", function ( e ) {
         		var customer_appointmentid = $( this ).attr( 'view-customer-appointmentid' );
         		var customer_viewuserid = $( this ).attr( 'view-customer-userid' );
         		var customer_viewcarsize = $( this ).attr( 'view-customer-carsize' );
         		var customer_viewservice = $( this ).attr( 'view-customer-service' );
         		var customer_viewextra = $( this ).attr( 'view-customer-extra' );
         		var customer_viewtotalprice = $( this ).attr( 'view-customer-totalprice' );
         		var customer_viewservicenote = $( this ).attr( 'view-customer-servicenote' );
         
         		customer_viewextra = customer_viewextra.split( ',' ).join( '\n' );
         		$( '#viewappID' ).text( customer_appointmentid );
         		$( '#viewuserID' ).text( customer_viewuserid );
         		$( '#viewcarsize' ).text( customer_viewcarsize );
         		$( '#viewservice' ).text( customer_viewservice );
         		$( '#viewextra' ).text( customer_viewextra );
         		$( '#totalprice' ).text( '£' + customer_viewtotalprice );
         		$( '#servicenote' ).text( customer_viewservicenote );
         	} );
         
         } );
      </script>

   </body>
</html>