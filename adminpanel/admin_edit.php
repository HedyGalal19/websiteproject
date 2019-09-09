<?php require '../functions/connections.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//require the email functionality
require '../functions/adminemailsetting.php';
//resumes the session for current user
session_start();
//retrieve user id from url
$edit = $_GET['edi'];
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
$stmt->bind_param("i", $edit);
$stmt->execute();
$result = $stmt->get_result();
$num_of_rows = $result->num_rows;
if (isset($_SESSION["userID"])) {
 // Checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  // if not admin direct to account page
  header("Location: ../index.php");
 }
 else {
  // if Admin logged in direct user to Admin panel page
  if ($edit == $_SESSION["userID"]) {
   header("Location: admin");
  }
  //wont allow to navigate to user by typing in the url
  elseif ($num_of_rows <= 0) {
   header("Location: admin");
  }
 }
}
else {
 // direct to login page if not logged in
 header("Location: ../login");
}
?>
<?php
// Retrieve the Customers Information
// Prepare and bind
$row = $result->fetch_assoc();
$_User["first_name"] = $row['fname'];
$_User["last_name"] = $row['lname'];
$_User["email"] = $row['email'];
$_User["reg"] = $row['reg'];
$_User["model"] = $row['model'];
$_User["year"] = $row['year'];
$_User["email"] = $row['email'];
$_User["phone"] = $row['phone'];
$_User["PW"] = $row['password'];
$_User["admin"] = $row['admin'];
$_User["subscribe"] = $row['subscribe'];
$id = $row['userID'];
//close prepared statement
$stmt->close();
?>
<?php
// Update Customer Information When Update button clicked
if (isset($_POST['update'])) {
 //update the detail for the specific user
 $stmt2 = $con->prepare("UPDATE Users SET fname = ?, lname = ?, email = ?, phone = ? ,reg=?,model=?,year=? WHERE userID = $edit");
 //bind the inputs from the form to the query
 $stmt2->bind_param("sssssss", $updatefirstname, $updatelastname, $updateemail, $updatephone, $updatereg, $updatemodel, $updateyear);
 //fetch the users detail from the form
 $updatefirstname = $_POST['first_name'];
 $updatelastname = $_POST['last_name'];
 $updateemail = $_POST['email'];
 $updatephone = $_POST['phone'];
 $updatereg = $_POST['lookup'];
 $updatemodel = $_POST['model'];
 $updateyear = $_POST['year'];
 $stmt2->execute();
 $stmt2->close();
 // show pop up success file when details are updated
 echo '<script>
    	setTimeout(function() {
        swal({
            title: "Account Update",
            text: "Account Updated Successfully!",
            type: "success"
        }, function() {
            window.location = "admin";
        });
    }, 100);
   </script>';
}
?>
<?php
//reset the password of the user, will set the new password to the last 4 characters of the firstname and last 4 digits of the phone number
if (isset($_POST['resetpassword'])) {
 //get the user id from the url parameter
 $edit = $_GET['edi'];
 $query = "SELECT * FROM Users WHERE userID = $edit";
 $results = $con->query($query);
 //if there is any data returned from the query
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $firstname = $row['fname'];
   $phone = $row['phone'];
	  $email = $row['email'];
   // hash and store new password new password
   $password1 = substr($firstname, -4); // returns last 4 characters of the user first name
   $password2 = substr($phone, -4); // returns last 4 digits of the user phone number
   $password = $password1 . $password2;
   //hash the password
   $storePassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
   //update the password
   $stmt3 = $con->prepare("UPDATE Users SET password = ? WHERE userID = $edit");
   $stmt3->bind_param("s", $storePassword);
   $stmt3->execute();
  
	  send_email_passwordreset($firstname,$email);
	   $stmt3->close();
   //redirect to the admin editing page
   header("Location: admin_edit.php?edi=$edit");
  }
 }
}
?>
<?php
//get the appointments booked for the user
function customersbooking()
{
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 // WHERE appdone='0'
 // the query
 $edit = $_GET['edi'];
 $query = "SELECT *
   FROM Appointment WHERE userID = '.$edit.'";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $appid = $row["appID"];
   print '
                      <tr>
                       <td id="reg">' . $row["reg"] . '</td>
                          <td>' . $row["date"] . '</td>
                          <td>' . $row["timeSlot"] . '</td>
                  ';
   if ($row["appdone"] == '0') {
    print '
                    
                       
               <td>Not Done</td>
                      
                  ';
   }
   else {
    print '      
               <td>Done</td>       
                  ';
   }
   print '
                   
                   
               				    <td id="buttonrow">
   													
   			       <button type="button" class="btn btn-primary view-select" data-toggle="modal" data-target="#exampleModal" view-customer-userid="' . $row['userID'] . '" view-customer-appointmentid="' . $row['appID'] . '" view-customer-carsize="' . $row['carSize'] . '" view-customer-service="' . $row['serviceOption'] . '" view-customer-extra="' . $row['extraOption'] . '" view-customer-totalprice="' . $row['totalPrice'] . '" view-customer-servicenote="' . $row['servicenote'] . '">View</button>
   	   
   	   <form method="GET" action="admineditbooking.php">
   													
   			<button type="submit"  id="submit" name="edi" value="' . $appid . '" class="btn btn-primary btn-xs">Edit Booking</button>
           </form>
		      	   <form method="GET" action="../functions/deletebooking.php?="'.$appid.'"">
   													
   			<button type="submit"  id="submit" name="del" value="' . $appid . '" class="btn btn-primary btn-xs">Delete Booking</button>
           </form>
          </td>
                      
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
//send new activation email
if (isset($_POST['newactivate'])) {
 $edit = $_GET['edi'];
 $query = "SELECT * FROM Users WHERE userID = $edit";
 // mysqli select query
 $results = $con->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $first_name = $row['fname'];
   $email = $row['email'];
   $com_code = md5(uniqid(rand()));
   $stmt3 = $con->prepare("UPDATE Users SET com_code = ? WHERE userID = $edit");
   $stmt3->bind_param("s", $com_code);
   $stmt3->execute();
   $stmt3->close();
   send_email_register($first_name, $email, $com_code);
   header("Location: admin_edit.php?edi=$edit");
  }
 }
}
?>
<?php
//activate users account
if (isset($_POST['activate'])) {
 $edit = $_GET['edi'];
 $com_code = NULL;
 $stmt3 = $con->prepare("UPDATE Users SET com_code = ? WHERE userID = $edit");
 $stmt3->bind_param("s", $com_code);
 $stmt3->execute();
 $stmt3->close();
 header("Location: admin_edit.php?edi=$edit");
}
?>
<?php
//add back to emailing list
if (isset($_POST['readd'])) {
 $edit = $_GET['edi'];
 $emailstatus = '0';
 $stmt3 = $con->prepare("UPDATE Users SET subscribe = ? WHERE userID = $edit");
 $stmt3->bind_param("s", $emailstatus);
 $stmt3->execute();
 $stmt3->close();
 header("Location: admin_edit.php?edi=$edit");
}
?>
<?php
//take off emailing list
if (isset($_POST['noemail'])) {
 $edit = $_GET['edi'];
 $emailstatus1 = '1';
 $stmt3 = $con->prepare("UPDATE Users SET subscribe = ? WHERE userID = $edit");
 $stmt3->bind_param("s", $emailstatus1);
 $stmt3->execute();
 $stmt3->close();
 header("Location: admin_edit.php?edi=$edit");
}
?>
<?php
//send email to the specific customer
function sendingemail()
{
 $edit = $_GET['edi'];
 print '
   			<form method="GET" action="adminemail.php">
   																
      			<button type="submit"  id="email" name="email" value="' . $edit . '" class="btn btn-primary btn-xs customer-select">Send Email</button>
              </form>
                         
                     ';
}
?>
<?php
//send email to the specific customer
function sendingsms()
{
 $edit = $_GET['edi'];
 print '
   			<form method="GET" action="adminsms.php">
   																
      			<button type="submit"  id="sms" name="sms" value="' . $edit . '" class="btn btn-primary btn-xs customer-select">Send SMS</button>
              </form>
                         
                     ';
}
?>
<?php
if (isset($_POST['adminupdate'])) {
 $edit = $_GET['edi'];
 $admin = '1';
 $stmt3 = $con->prepare("UPDATE Users SET admin = ? WHERE userID = $edit");
 $stmt3->bind_param("s", $admin);
 $stmt3->execute();
 $stmt3->close();
 header("Location: admin_edit.php?edi=$edit");
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php include 'includes/head.php'; ?>
	  <!-- individual css -->
      <link rel="stylesheet" href="../css/admineditaccount.css" type="text/css"/>
      <link rel="stylesheet" href="../css/adminusers.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
         </header>
         <!-- customers account page-->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="card">
                  <div class="card-header">
                     Customer Detail - <span id="customerview">Customers Detail</span>
                  </div>
				   <!-- dropdown to show different customer details-->
                  <div class="card-body">
                     <div class="form-group">
                        <div class="input-group">
                           <select class="selectpicker users" name="users" id="users">
                              <option id="allcustomer" value="1">Customer Details</option>
                              <option id="newcar" value="2">Customers Bookings</option>
                              <option id="oldcar" value="3">Actions</option>
                           </select>
                        </div>
                     </div>
                     <div class="signup-form-container" id="customerdetail">
                        <!----------------------- Start Form --- on submit check validation ---->
                        <form method="post" role="form" name="adminupdate-form" id="adminupdate-form" autocomplete="off" onsubmit="return admin_edit_account(this)">
                           <div class="form-header">
                              <h3 class="form-title"><i class="fa fa-user"></i> Update Account - <span id="deleted"><?php if( $_User[ "subscribe" ]==1){echo "UNSUBSCRIBED";} ?></span></h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                              </div>
                           </div>
                           <div class="form-body">
                              <div class="row numberplate">
                                 <div class="col-sm">
                                    <div class="form-group">
                                       <label>Car Registeration Number</label>
                                       <div class="input-group">
                                          <div class="input-group-addon" id="regNumber">GB
                                          </div>
                                          <input type="text" class="registration-ui form-control" id="lookup" name="lookup" value="<?= $_User[ "reg" ]; ?>" required>
                                       </div>
										<!-- input validation appears here --> 
                                       <span class="help-block" id="error"></span>
                                    </div>
									 <!-- checks the car reg number -->
                                    <div id="searchError" disabled></div>
                                 </div>
                                 <div class="col-sm">
									 <!-- search for car detail -->
                                    <a onclick="startAjax();" id="search" class="btn">Search</a>
                                 </div>
                              </div>
                              <div class="row numberdetail">
                                 <div class="col-sm">
                                    <div class="form-group">
                                       <label>Make &amp; Model</label>
                                       <div class="input-group">
										   <!-- font awesome icon -->
                                          <div class="input-group-addon"><span class="fa fa-user"></span>
                                          </div>
                                          <input id="model" name="model" class="form-control" value="<?= $_User[ "model" ]; ?>" readonly>
                                       </div>
										<!-- input validation appears here -->
                                       <span class="help-block" id="error"></span>
                                    </div>
                                 </div>
                                 <div class="col-sm">
                                    <div class="form-group">
                                       <label>Year</label>
                                       <div class="input-group">
										   <!-- font awesome icon -->
                                          <div class="input-group-addon"><span class="fa fa-user"></span>
                                          </div>
                                          <input id="year" name="year" class="form-control" value="<?= $_User[ "year" ]; ?>" readonly>
                                       </div>
										<!-- input validation appears here -->
                                       <span class="help-block" id="error"></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>First Name</label>
                                 <div class="input-group">
									 <!-- font awesome icon -->
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="first_name" id="first_name" type="text" class="form-control" value="<?=  $_User[ "first_name" ]; ?>" ?>
                                 </div>
								  <!-- input validation appears here -->
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Last Name</label>
                                 <div class="input-group">
									 <!-- font awesome icon -->
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="last_name" id="last_name" type="text" class="form-control" value="<?=  $_User[ "last_name" ]; ?>">
                                 </div>
								  <!-- input validation appears here -->
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Phone Number</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-phone"></span>
                                    </div>
                                    <input name="phone" id="phone" type="text" class="form-control" value="<?= $_User[ "phone" ]; ?>">
                                 </div>
								  <!-- input validation appears here -->
                                 <span class="help-block" id="error"></span>
                                 <div id="status"></div>
                              </div>
                              <div class="form-group">
                                 <label>Email Address</label>
                                 <div class="input-group">
									 <!-- font awesome icon -->
                                    <div class="input-group-addon"><span class="fa fa-envelope"></span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control" value="<?= $_User[ "email" ]; ?>">
                                 </div>
								  <!-- input validation appears here -->
                                 <span class="help-block" id="error"></span>
								  <!-- check for email duplication -->
                                 <div id="status"></div>
                              </div>
                           </div>
                           <!-- Update account Button -->
                           <div class="form-footer">
                              <div class="form-group col">
                                 <button type="submit" href="admin.php" name="update" id="update" class="btn btn-info">Update Account</button>
                              </div>
                           </div>
                        </form>
                        <!----------------------- End Form ---------------------->
                     </div>
					  <!----------------------- second drop down option - show all customers bookings ---------------------->
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="customerbooking">
                        <div class="table-scroll ">
                           <div class="table-responsive ">
                              <!--this is used for responsive display in mobile and other devices-->
                              <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="customerbookings">
                                 <thead>
                                    <tr>
                                       <th>Car Reg</th>
                                       <th>Booking Date</th>
                                       <th>Booking Time</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <?php customersbooking(); ?>
                              </table>
                              <!----------------------- End Table ---------------------->
                           </div>
                        </div>
                     </div>
					 <!----------------------- third drop down option - show actions ---------------------->
                     <div class="col-lg-12 col-lg-8 bg-white has-shadow" id="actions">
                        <div class="container">
                           <div class="row">
                              <div class="col">
                                 <form method="POST">
                                    <div class="form-group col">
                                       <button type="submit" name="resetpassword" type="button" class="btn btn-info" id="resetpassword" value="Reset Password">Reset Password</button>
                                    </div>
                                 </form>
                              </div>
                              <div class="col">
                                 <div class="form-group col">
                                    <a class="deletebutton" data-title="Want to delete this?" data-type="warning" href="../functions/delete.php?del=<?php echo $edit ?>"><button class="btn btn-danger">Delete</button></a>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col">
                                 <form method="POST">
                                    <div class="form-group col">
                                       <button type="submit" name="activate" type="button" class="btn btn-info" id="activate" value="Activate Account">Activate Account</button>
                                    </div>
                                 </form>
                              </div>
                              <div class="col">
                                 <form method="POST">
                                    <div class="form-group col">
                                       <button type="submit" name="newactivate" type="button" class="btn btn-info" id="newactivate" value="Resend Activation Email">Resend Activation Email</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col">
                                 <form method="POST">
                                    <div class="form-group col">
                                       <button type="submit" name="readd" type="button" class="btn btn-info" id="readd" value="Add User Back">Re add to Email List</button>
                                    </div>
                                 </form>
                              </div>
                              <div class="col">
								  <form method="POST">
                                 <div class="form-group col">
                                    <button type="submit" name="noemail" type="button" class="btn btn-info" id="noemail" value="Take off email">Take off Email List</button>
                                 </div>
							</form>
                              </div>
                           </div>
							<div class="row">
                              <div class="col">
                                 <form method="POST">
                                    <div class="form-group col">
                                       <button type="submit" name="adminupdate" type="button" class="btn btn-info" id="adminupdate" value="admin update">Upgrade to Admin</button>
                                    </div>
                                 </form>
                              </div>
                              <div class="col">
                                 <div class="form-group col">
                                    <?php sendingemail(); ?>
                                 </div>
                              </div>
                           </div>
							
						<div class="row">
                              <div class="col">
                                 <div class="form-group col">
                                    <?php sendingsms(); ?>
                                 </div>
                              </div>
							  <div class="col">

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
		   <!----------------------- modal showing the booking information when view is clicked in customers bookings ---------------------->
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
      <!-- Javascript files-->
      <?php include 'includes/adminscripts.php'; ?>
      <script>
         window.onload = function () {
         	$( "#customerbooking" ).hide();
         	$( "#actions" ).hide();
         
         };
         $( document ).ready( function () {
         	var table2 = $('#customerbookings').DataTable();
         
         	$( '.users' ).on( 'change', function () {
         		var selected = $( this ).find( "option:selected" ).val();
         		if ( selected == '1' ) {
         			$( "#customerdetail" ).show();
         			$( "#customerbooking" ).hide();
         			$( "#actions" ).hide();
         			$( "#customerview" ).html( "Customer Details" );
         
         		}
         		if ( selected == '2' ) {
         			$( "#customerdetail" ).hide();
         			$( "#actions" ).hide();
         			$( "#customerbooking" ).show();
         			$( "#customerview" ).html( "Customers Booking" );
         			  table2.columns.adjust();
         
         		}
         		if ( selected == '3' ) {
         			$( "#customerdetail" ).hide();
         			$( "#customerbooking" ).hide();
         			$( "#actions" ).show();
         			$( "#customerview" ).html( "Actions" );
         			
         
         		}
         
         	} );
         
         } );
      </script>
      <script>
         $( document ).ready( function () {
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
      <script>
         $( function () {
         	$( '.deletebutton' ).click( function ( e ) {
         		e.preventDefault();
         		var tthis = $( this );
         		swal( {
         			title: "Are you sure?",
         			text: $( this ).data( 'title' ),
         			type: $( this ).data( 'type' ),
         			showCancelButton: true,
         			confirmButtonText: "Delete",
         			cancelButtonText: "Cancel",
         		}, function ( isConfirm ) {
         			if ( isConfirm ) {
         				document.location.href = tthis.attr( 'href' );
         			}
         		} );
         	} );
         } );
      </script>

   </body>
</html>