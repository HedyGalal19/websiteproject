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
function customers()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 // WHERE appdone='0'
 //fetch all customers is not currenly logged in and is not deleted
 $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0'";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $phone = $row["phone"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  <td>' . $phone . '</td>
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
// populate product dropdown for invoice creation
function newcarcustomers()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 // WHERE appdone='0'
 //fetch all customers with new cars. within 4 years of current year
 $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND year >= YEAR(CURDATE())-4";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $year = $row["year"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
   					   <td>' . $year . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
// populate product dropdown for invoice creation
function oldcarcustomers()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
//fetch all customers who has old cars. mor ethan 4 years old from today
 $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND year <= YEAR(CURDATE())-4";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $year = $row["year"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
   					    <td>' . $year . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
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
 $query = "SELECT Users.reg,Users.fname,Users.lname,Users.email,Users.phone,Appointment.userID,Users.userID, MAX(Appointment.date) AS `date`
      FROM Appointment INNER JOIN Users
           ON Appointment.userID = Users.userID WHERE Users.userID != $sessionuserID AND subscribe='0' AND date < NOW() - INTERVAL 30 DAY GROUP BY Appointment.userID ORDER BY MAX(date)";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $phone = $row["phone"];
   $ldate = $row['date'];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  <td>' . $phone . '</td>
   						  <td>' . $ldate . '</td>
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
// populate product dropdown for invoice creation
function unactivecustomer()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
//fetch all customers that have not activated their account
 $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND com_code  IS NOT NULL";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $phone = $row["phone"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  <td>' . $phone . '</td>
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
// populate product dropdown for invoice creation
function deletedcustomers()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
//fetch all deleted customers
 $query = "select * from Users WHERE userID != $sessionuserID AND subscribe = '1'";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $email = $row["email"];
   $phone = $row["phone"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $email . '</td>
   						  <td>' . $phone . '</td>
                  			 <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
//button functionally to all customers email to the email form
function sendingtoall()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="all" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="all" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
//button functionally to new car customers email to the email form
function sendingtonew()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="new" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			  			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="new" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
//button functionally to pass old customers email to the email form
function sendingtoold()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="old" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			  			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="old" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
//button functionally to pass unactive account customers email to the email form
function sendingtounactive()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="unactive" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			  			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="unactive" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
//button functionally to pass not recently booking customers email to the email form
function sendingtonotbooking()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="oldbooking" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			  			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="oldbooking" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
//button functionally to pass deleted customers email to the email form
function sendingtodeleted()
{
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="unsubscribed" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
			  
			  			     			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="unsubscribed" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
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
               <h2 class="no-margin-bottom">Customers</h2>
            </div>
         </header>
         <!-- drop down to populate table depending on option selected-->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="card">
                  <div class="card-header">
                     Customer Detail - <span id="customerview">All Customers</span>
                  </div>
                  <div class="card-body">
                     <div class="form-group">
                        <div class="input-group">
                           <select class="selectpicker users" name="users" id="users">
                              <option id="allcustomer" value="1">All Customers</option>
                              <option id="newcar" value="2">New Car Customers</option>
                              <option id="oldcar" value="3">Old Car Customers</option>
                              <option id="unactivated" value="4">Customers Still Need Activation</option>
                              <option id="oldbooking" value="5">Customers Not Booked Recently</option>
                              <option id="deletedUsers" value="6">Unsubscribed Customer Accounts</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="displayallcustomer">
                        <div class="wrapper">
                           <?php sendingtoall(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="allcustomers">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php customers(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="newcarcustomer">
                        <div class="wrapper">
                           <?php sendingtonew(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="newcustomers">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>Year Of Car</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php newcarcustomers(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="oldcarcustomer">
                        <div class="wrapper">
                           <?php sendingtoold(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="oldcustomers">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>Year Of Car</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php oldcarcustomers(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="allunactivecustomer">
                        <div class="wrapper">
                           <?php sendingtounactive(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="unactivecustomer">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php unactivecustomer(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="oldbookingcustomers">
                        <div class="wrapper">
                           <?php sendingtonotbooking(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="oldbookingcustomer">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>last Booking Date</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php oldbooking(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="deletedcustomers">
                        <div class="wrapper">
                           <?php sendingtodeleted(); ?>
                        </div>
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="deletedcustomer">
                                 <thead>
                                    <tr>
                                       <th>Car Registeration</th>
                                       <th>First Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>View User</th>
                                    </tr>
                                 </thead>
                                 <?php deletedcustomers(); ?>
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
      <script>
         window.onload = function () {
         	$( "#newcarcustomer" ).hide();
         	$( "#oldcarcustomer" ).hide();
         	$( "#allunactivecustomer" ).hide();
         	$( "#oldbookingcustomers" ).hide();
         	$( "#deletedcustomers" ).hide();
         
         };
         $( document ).ready( function () {
         	var table2 = $('#newcustomers').DataTable();
         	var table3 = $('#oldcustomers').DataTable();
         	var table4 = $('#unactivecustomer').DataTable();
         	var table5 = $('#oldbookingcustomer').DataTable();
         	var table6 = $('#deletedcustomer').DataTable();
         
         	$( '.users' ).on( 'change', function () {
         		var selected = $( this ).find( "option:selected" ).val();
         		if ( selected == '1' ) {
         			$( "#displayallcustomer" ).show();
         			$( "#newcarcustomer" ).hide();
         			$( "#oldcarcustomer" ).hide();
         			$( "#allunactivecustomer" ).hide();
         			$( "#oldbookingcustomers" ).hide();
         			$( "#deletedcustomers" ).hide();
         			$( "#customerview" ).html( "All Customers" );
         
         		}
         		if ( selected == '2' ) {
         			$( "#displayallcustomer" ).hide();
         			$( "#newcarcustomer" ).show();
         			$( "#oldcarcustomer" ).hide();
         			$( "#allunactivecustomer" ).hide();
         			$( "#oldbookingcustomers" ).hide();
         			$( "#deletedcustomers" ).hide();
         			$( "#customerview" ).html( "New Car Owner Customers" );
         			  table2.columns.adjust();
         
         		}
         		if ( selected == '3' ) {
         			$( "#displayallcustomer" ).hide();
         			$( "#newcarcustomer" ).hide();
         			$( "#oldcarcustomer" ).show();
         			$( "#allunactivecustomer" ).hide();
         			$( "#oldbookingcustomers" ).hide();
         			$( "#deletedcustomers" ).hide();
         			$( "#customerview" ).html( "Old Car Owner Customers" );
         			  table3.columns.adjust();
         
         		}
         		if ( selected == '4' ) {
         			$( "#displayallcustomer" ).hide();
         			$( "#newcarcustomer" ).hide();
         			$( "#oldcarcustomer" ).hide();
         			$( "#allunactivecustomer" ).show();
         			$( "#oldbookingcustomers" ).hide();
         			$( "#deletedcustomers" ).hide();
         			$( "#customerview" ).html( "Unactive Account Customers" );
         			  table4.columns.adjust();
         
         		}
         			if ( selected == '5' ) {
         			$( "#displayallcustomer" ).hide();
         			$( "#newcarcustomer" ).hide();
         			$( "#oldcarcustomer" ).hide();
         			$( "#allunactivecustomer" ).hide();
         			$( "#oldbookingcustomers" ).show();
         				$( "#deletedcustomers" ).hide();
         			$( "#customerview" ).html( "Customer Not Booked Recently" );
         				    table5.columns.adjust();
         
         		}
         							if ( selected == '6' ) {
         			$( "#displayallcustomer" ).hide();
         			$( "#newcarcustomer" ).hide();
         			$( "#oldcarcustomer" ).hide();
         			$( "#allunactivecustomer" ).hide();
         			$( "#oldbookingcustomers" ).hide();
         			$( "#deletedcustomers" ).show();
         			$( "#customerview" ).html( "Deleted Customers" );
         				    table6.columns.adjust();
         
         		}
         
         	} );
         
         } );
      </script>
   </body>
</html>