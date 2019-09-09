<?php require '../functions/connections.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//require email functionality
require '../functions/adminemailsetting.php';
//resumes the session for current user
session_start();
$admin = $_SESSION['admin'];
$sessionuserID = $_SESSION["userID"];
//get the email url parameter
$edit = $_GET['email'];
// check if userD is set i.e user is logged in
if (isset($_SESSION['userID'])) {
 if ($_SESSION["admin"] === 0) {
  // direct user to index page as user is already registered
  header('Location: ../index');
 }
//check if there is a url parameter with name 'email'	
 elseif (isset($_GET['email'])) {
  $edit = $_GET['email'];
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  //output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
  $query = "select * from Users WHERE userID = $edit";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $name = $row["email"];
   }
  }
 }
 else {
  header('Location: admin');
 }
}
?>
<?php
//if the send button is pressed
if (isset($_POST['send'])) {
 //allows emails to be sent in the background
 // don't let user kill the script by hitting the stop button
 ignore_user_abort(true);
 // don't let the script time out
 set_time_limit(0);
 // start output buffering
 ob_start();
 //check if the url paramter is a number
 if (is_numeric($edit)) {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
  //fetch the customer with the url parameter id
  $query = "select * from Users WHERE userID = $edit";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    //
    // usleep(1500000); // do some stuff...
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
	//send email to the user
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
	//if the parameter is set to all
 elseif ($edit == "all") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
	 //fetch all users where they are not currenly logged in and not deleted
  $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0'";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    //
    // usleep(1500000); // do some stuff...
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
	  
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
//if the paramter is set to new
 elseif ($edit == "new") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
 //get all the users which have new car up to 4 years old from today
  $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND year >= YEAR(CURDATE())-4";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
 elseif ($edit == "old") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
  //get all the users which have a old car, years or older from current year
  $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND year <= YEAR(CURDATE())-4";
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
    send_email_to1($subject, $message, $email);
   }
  }
	header("Location: admin"); 
 }
 elseif ($edit == "unactive") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
	 //fetch all users that have unactive accounts
  $query = "select * from Users WHERE userID != $sessionuserID AND subscribe='0' AND com_code  IS NOT NULL";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
 elseif ($edit == "oldbooking") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
//customers who have not booked in the last month from currrent day 
  $query = "SELECT Users.reg,Users.fname,Users.lname,Users.email as email,Users.phone,Users.subscribe,Appointment.userID,Users.userID, MAX(Appointment.date) AS `date`
      FROM Appointment INNER JOIN Users
           ON Appointment.userID = Users.userID WHERE Users.userID != $sessionuserID AND Users.subscribe='0' AND date < NOW() - INTERVAL 30 DAY GROUP BY Appointment.userID ORDER BY MAX(date) ";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
 elseif ($edit == "unsubscribed") {
  // Connect to the database
  $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
  // output any connection error
  if ($mysqli->connect_error) {
   die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
  }
	//customers who are deleted
  $query = "select * from Users WHERE userID != $sessionuserID AND subscribe ='1'";
  // mysqli select query
  $results = $con->query($query);
  if ($results) {
   while ($row = $results->fetch_assoc()) {
    $email = $row["email"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    header("Location: admin");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
    send_email_to1($subject, $message, $email);
   }
  }
	 header("Location: admin"); 
 }
} //end first if
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <link rel="stylesheet" href="../css/adminemail.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu file -->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Sending Email</h2>
            </div>
         </header>
         <!-- Dashboard Counts Section-->
         <section class="dashboard no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="container">
                     <div class="signup-form-container">
                        <!----------------------- Start Form -------on submit check validation------->
                        <form method="post" role="form" name="register-form" id="register-form" autocomplete="off" onsubmit="return registercheck(this)">
                           <div class="form-header">
							   <!-- form title-->
                              <h3 class="form-title"><i class="fa fa-envelope"></i> Send Email</h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                              </div>
                           </div>
                           <div class="form-body">
                              <div class="form-group">
                                 <label>To</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="to" id="to" type="text" class="form-control" value="<?php echo $name ?>" readonly>
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Subject</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-pencil"></span>
                                    </div>
                                    <input name="subject" id="subject" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                                 <div id="status"></div>
                              </div>
                              <div class="form-group">
                                 <label>Subject</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-pencil"></span>
                                    </div>
                                    <textarea id="message" name="message" rows="6" placeholder="Message" maxlength="600" ></textarea>
                                 </div>
                                 <span class="help-block" id="error"></span>
                                 <div id="status"></div>
                              </div>
                           </div>
                           <!-- send email button -->
                           <div class="form-footer">
                              <div class="form-group col">
                                 <button type="submit" name="send" id="send" class="btn btn-info"> Send</button>
                              </div>
                           </div>
                        </form>
                        <!----------------------- End Form ---------------------->
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Page Footer-->
         <?php include 'includes/footer.php'; ?>
      </div>
      </div>
      </div>
      <!-- Javascript files-->
      <?php include 'includes/adminscripts.php'; ?>
      <script>
         if (/all/.test(window.location.href)) {
         $( '#to' ).val("All Customers" );
         }
         	if (/new/.test(window.location.href)) {
         $( '#to' ).val("New Car Customers" );
         }
         		if (/old/.test(window.location.href)) {
         $( '#to' ).val("Old Car Customers" );
         }
         			if (/unactive/.test(window.location.href)) {
         $( '#to' ).val("Unactive Accounts" );
         }
         				if (/oldbooking/.test(window.location.href)) {
         $( '#to' ).val("Customer Last Booked More than 1 Month" );
         }
         					if (/unsubscribed/.test(window.location.href)) {
         $( '#to' ).val("Unsubscribed Customers" );
         }
      </script>
   </body>
</html>