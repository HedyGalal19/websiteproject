<?php
require '../functions/connections.php';
 ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../functions/adminemailsetting.php';
// Resumes the session for current user
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
//show all customers table used for booking
function popCustomersList()
{
 //admin user id
 $sessionuserID = $_SESSION["userID"];
 //connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 //fetch all data for customer where customer is not logged in
 $query = "SELECT * FROM Users WHERE userID != $sessionuserID";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $lastName = $row["lname"];
   $fullName = $firstName . " " . $lastName;
   //create a row contain the select button to choose the customer for booking
   print '
   			    <tr>
   		<td id="reg">' . $reg . '</td>
   					<td>' . $fullName . '</td>
   				    <td>' . $row["phone"] . '</td>
   				    <td><a class="btn btn-primary btn-xs customer-select" data-customer-id="' . $row['userID'] . '" data-customer-name="' . $row['fname'] . '" data-customer-Lname="' . $row['lname'] . '" data-customer-email="' . $row['email'] . '" data-customer-phone="' . $row['phone'] . '" data-customer-reg="' . $row['reg'] . '" data-customer-model="' . $row['model'] . '" data-customer-year="' . $row['year'] . '">Select</a></td>
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
//check if the submit button is pressed
if (isset($_POST['submit'])) {
 $userID = $_POST['userId'];
 $newuserID = $_POST['newuserId'];
 //if there is no user id
 if (!isset($userID) || trim($userID) == '') {
  //insert into the database a new record containing the customers information
  $stmt = $con->prepare("INSERT INTO Users(reg, model, year,fname, lname, phone, email, password, com_code, regdate) VALUES (?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("ssssssssss", $reg, $model, $year, $first_name, $last_name, $phone, $email, $storePassword, $com_code, $time);
  //fetch the users detail from the form
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $reg = $_POST['lookup'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $password1 = substr($first_name, -4); //returns the last 4 characters of the customer first name
  $password2 = substr($phone, -4); // returns the last 4 digits of the customer phone number
  $password = $password1 . $password2; //combine the substring of firstname and phone number to create password
  //create a random activation code
  $com_code = md5(uniqid(rand()));
  //timestap of registration
  $time = date("Y-m-d");
  //hash password
  $storePassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
  //execute the query
  $stmt->execute();
  //create a query to store the booking detail for the customer
  $stmt1 = $con->prepare("INSERT INTO Appointment(reg, model, year, timeSlot, date, carSize, serviceOption, extraOption, totalPrice,servicenote, userID) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
  $stmt1->bind_param("ssssssssssi", $reg, $model, $year, $timeSlot, $date, $carSize, $serviceOption, $extraOption, $totalPrice, $servicenote, $newuserID);
  //fetch the booking detail from the form
  $reg = $_POST['lookup'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $timeSlot = $_POST['time'];
  $date = $_POST['date'];
  $carSize = $_POST['carSize'];
  $serviceOption = $_POST['serviceSelected'];
  $extraOption = $_POST['optionsSelected'];
  $totalPrice = $_POST['totalPrice'];
  $servicenote = htmlspecialchars($_POST['message']);
//  $userID = $_SESSION["userID"];
  //execute the booking storing query
//	 
	 	 send_email_booking($first_name,$reg,$model,$year,$carSize,$serviceOption,$extraOption,$date,$timeSlot,$totalPrice,$email);
  $stmt1->execute();
  //close the prepared statement
  $stmt1->close();
	   //close the prepared statement
  $stmt->close();

 }
 else {
  //if the customer already exists but updates their detail when booking 
  $stmt2 = $con->prepare("UPDATE Users SET reg=?, model=?, year=?, fname = ?, lname = ?, email = ?, phone = ?, subscribe=? WHERE userID = $userID");
  $stmt2->bind_param("ssssssss", $updatereg, $updatemodel, $updateyear, $updatefirstname, $updatelastname, $updateemail, $updatephone, $subscribe);
  //fetch the new details from the form
  $updatefirstname = $_POST['first_name'];
  $updatelastname = $_POST['last_name'];
  $updateemail = $_POST['email'];
  $updatephone = $_POST['phone'];
  $updatereg = $_POST['lookup'];
  $updatemodel = $_POST['model'];
  $updateyear = $_POST['year'];
  $subscribe = '0';
  //execute the query to update customer details
  $stmt2->execute();
  //close the prepared statement
  $stmt2->close();
  //query to store the booking detail
  $stmt3 = $con->prepare("INSERT INTO Appointment(reg, model, year, timeSlot, date, carSize, serviceOption, extraOption, totalPrice,servicenote, userID) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
  $stmt3->bind_param("ssssssssssi", $reg, $model, $year, $timeSlot, $date, $carSize, $serviceOption, $extraOption, $totalPrice, $servicenote, $userID);
  //fetch the booking detail from the form
  $reg = $_POST['lookup'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $timeSlot = $_POST['time'];
  $date = $_POST['date'];
  $carSize = $_POST['carSize'];
  $serviceOption = $_POST['serviceSelected'];
  $extraOption = $_POST['optionsSelected'];
  $totalPrice = $_POST['totalPrice'];
  $servicenote = htmlspecialchars($_POST['message']);
  $stmt3->execute();
	 send_email_booking($updatefirstname,$updatereg,$updatemodel,$updateyear,$carSize,$serviceOption,$extraOption,$date,$timeSlot,$totalPrice,$updateemail);
  //close the prepared statement
  $stmt3->close();
	 
 }
 header("Location: adminhome");
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php require 'includes/head.php'; ?>
      <link rel="stylesheet" href="../css/adminbooking.css" type="text/css"/>
      <!-- Javascript files-->
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Booking</h2>
            </div>
         </header>
         <!-- table to show the all available customers -->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="card text-center">
                  <div class="card-header">
                     Customer Detail
                  </div>
                  <div class="card-body">
                     <div class="table-responsive" id="table-responsive">
                        <!--this is used for responsive display in mobile and other devices-->
                        <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="userTable">
                           <thead>
                              <tr>
                                 <th>Car Reg</th>
                                 <th>Full Name</th>
                                 <th>Phone</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php popCustomersList(); ?>
                           </tbody>
                        </table>
                        <!----------------------- End Table ---------------------->
                     </div>
                     <div class="signup-form-container">
                        <!-- not allowing to register if javascript is disabled -->
                        <div id="nscript">
                           <noscript>
                              You cannot register without javascript enabled.
                           </noscript>
                        </div>
                        <!----------------------- Start Form ---------------------->
                        <form method="post" role="form" name="register-form" id="register-form" autocomplete="off" onsubmit="return admin_booking(this)">
                           <div class="form-header">
                              <h3 class="form-title"><i class="fa fa-user"></i> Registration</h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                              </div>
                           </div>
							<!-- customers detail -->
                           <div class="form-body">
                              <div class="form-group"   hidden="">
                                 <label>User ID</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="userId" id="userId" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group" hidden="">
                                 <label>User ID</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="newuserId" id="newuserId" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>First Name</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="first_name" id="first_name" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label for="exampleInputEmail1">Last Name</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="last_name" id="last_name" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Phone Number</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-phone"></span>
                                    </div>
                                    <input name="phone" id="phone" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Email Address</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-envelope"></span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
								  <!-- checks for email validation -->
                                 <div id="status" class="field-item"></div>
                              </div>
                           </div>
							<!-- car details -->
                           <h5 class="form-heading-title"><span class="form-heading-no">1.</span>Vehicle Information</h5>
                           <div class="row">
                              <div class="col-sm">
                                 <p>Car VRM</p>
                                 <div class="form-group">
                                    <div class="input-group">
                                       <div class="input-group-addon" id="regNumber">GB
                                       </div>
                                       <input type="text" class="registration-ui form-control" id="lookup" name="lookup" placeholder="Car Reg" required>
                                    </div>
                                    <span class="help-block" id="entererror"></span>
                                 </div>
                              </div>
                              <div class="col-sm">
                                 <p>Make &amp; Model</p>
                                 <div class="form-group">
                                    <div class="input-group">
                                       <input id="model" name="model" class="form-control" readonly>
                                    </div>
                                    <span class="help-block" id="error6"></span>
                                 </div>
                                 <div id="searchError" disabled></div>
                              </div>
                              <div class="col-sm">
                                 <p>Car Year</p>
                                 <input id="year" name="year" class="form-control" readonly>
                              </div>
                              <div id="regsearch">
								  <!-- search for the car detail -->
                                 <a onclick="startAjax();" id="search" class="btn">Search</a>
                              </div>
                           </div>
							<!-- booking information, services, booking date and timeslot-->
                           <h5 class="form-heading-title"><span class="form-heading-no">2.</span>Appointment Information</h5>
                           <div class="row">
                              <div class="col-md-8">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <p>Car Size</p>
                                       <div class="form-group">
                                          <div class="input-group">
											  <!-- car sizes -->
                                             <select class="selectpicker purpose" name="size" id="size" onChange="resetting()" title="Select Car Size">
                                                <option id="Small" value="1">Small</option>
                                                <option id="Medium" value="2">Medium</option>
                                                <option id="Large" value="3">Large</option>
                                             </select>
                                          </div>
                                          <span class="help-block" id="error1"></span>
                                       </div>
                                    </div>
									 <!-- services options -->
                                    <div class="col-md-6">
                                       <p>Service Options</p>
                                       <div class="form-group">
                                          <div class="input-group">
                                             <select class="selectpicker empty1" title="Select Service Option">
                                             </select>
                                             <select class="selectpicker select1" name="option" onChange="calculatePrice()" title="Select Service Option" id="option" required>
                                                <option value=""></option>
                                                <option value="6" id="Exterior Valet">Exterior Valet - <span>£6</span>
                                                </option>
                                                <option value="18" id="Exterior &amp; Interior Valet">Exterior &amp; Interior Valet - <b>£18</b>
                                                </option>
                                                <option value="50" id="Full Valet">Full Valet - <b>£50</b>
                                                </option>
                                             </select>
                                             <select class="selectpicker select2" NAME="option1" onChange="calculatePrice1()" title="Select Service Option" id="option1">
                                                <option value=""></option>
                                                <option value="8" id="Exterior Valet">Exterior Valet - <span>£8</span>
                                                </option>
                                                <option value="23" id="Exterior &amp; Interior Valet">Exterior &amp; Interior Valet - <b>£23</b>
                                                </option>
                                                <option value="60" id="Full Valet">Full Valet - <b>£60</b>
                                                </option>
                                             </select>
                                             <select class="selectpicker select3" NAME="option2" onChange="calculatePrice2()" title="Select Service Option" id="option2">
                                                <option value=""></option>
                                                <option value="10" id="Exterior Valet">Exterior Valet - <span>£10</span>
                                                </option>
                                                <option value="28" id="Exterior &amp; Interior Valet">Exterior &amp; Interior Valet - <b>£28</b>
                                                </option>
                                                <option value="70" id="Full Valet">Full Valet - <b>£70</b>
                                                </option>
                                             </select>
                                          </div>
                                          <span class="help-block" id="error2"></span>
                                          <span id="instruction">Please Select Car Size First</span>
                                       </div>
                                    </div>
                                 </div>
								  <!-- appointment date and time slot-->
                                 <div class="row">
                                    <div class="col-md-6">
                                       <p>Appointment Date</p>
                                       <div class="form-group">
                                          <div class="input-group date">
                                             <input type="text" class="form-control" name="datepicker" id="datepicker" placeholder="Appointment Date"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          </div>
                                          <span class="help-block" id="error3"></span>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <p>Time Slots</p>
                                       <div class="form-group">
                                          <div class="input-group">
                                             <select class="selectpicker" id="times22" name="timeSelection" title="Select Available Time">
                                             </select>
                                          </div>
                                          <span class="help-block" id="error4"></span>
                                          <span id="instruction1">Please Select Appointment Date First</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
							   <!-- extra services -->
                              <div class="col-md-4">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <p>Extra Services Options</p>
                                       <span id="instruction2">Please Select Service Options First</span>
                                       <div class="extraEmpty1">
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Screen Wash Top-up</span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Extra Wax</span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Odour Elimination</span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Fabric Hood</span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Leather Seat Treatment</span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" disabled> <span class="label-text">Paint Protection</span>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="extra1">
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Screen Wash Top-up" value="3" onClick="calculatePrice();" disabled> <span class="label-text">Screen Wash Top-up - <b>£3</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Extra Wax" value="5"  onClick="calculatePrice();" disabled> <span class="label-text">Extra Wax - <b>£5</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Odour Elimination" value="15"  onClick="calculatePrice();" disabled> <span class="label-text">Odour Elimination - <b>£15</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Fabric Hood" value="17"  onClick="calculatePrice();" disabled> <span class="label-text">Fabric Hood - <b>£17</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Leather Seat Treatment" value="25"  onClick="calculatePrice();" disabled> <span class="label-text">Leather Seat Treatment - <b>£25</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Paint Protection" value="40"  onClick="calculatePrice();" disabled> <span class="label-text">Paint Protection - <b>£40</b></span>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="extra2">
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Screen Wash Top-up" value="3" onClick="calculatePrice1();" disabled> <span class="label-text">Screen Wash Top-up - <b>£3</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Extra Wax" value="5"  onClick="calculatePrice1();" disabled> <span class="label-text">Extra Wax - <b>£5</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Odour Elimination" value="15"  onClick="calculatePrice1();" disabled> <span class="label-text">Odour Elimination - <b>£15</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Fabric Hood" value="17"  onClick="calculatePrice1();" disabled> <span class="label-text">Fabric Hood - <b>£17</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Leather Seat Treatment" value="25"  onClick="calculatePrice1();" disabled> <span class="label-text">Leather Seat Treatment - <b>£25</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Paint Protection" value="50"  onClick="calculatePrice1();" disabled> <span class="label-text">Paint Protection - <b>£50</b></span>
                                             </label>
                                          </div>
                                       </div>
                                       <div class="extra3">
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Screen Wash Top-up" value="3" onClick="calculatePrice2();" disabled> <span class="label-text">Screen Wash Top-up - <b>£3</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Extra Wax" value="5"  onClick="calculatePrice2();" disabled> <span class="label-text">Extra Wax - <b>£5</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Odour Elimination" value="15"  onClick="calculatePrice2();" disabled> <span class="label-text">Odour Elimination - <b>£15</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Fabric Hood" value="17"  onClick="calculatePrice2();" disabled> <span class="label-text">Fabric Hood - <b>£17</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Leather Seat Treatment" value="25"  onClick="calculatePrice2();" disabled> <span class="label-text">Leather Seat Treatment - <b>£25</b></span>
                                             </label>
                                          </div>
                                          <div class="form-check">
                                             <label>
                                             <input type="checkbox" name="Paint Protection" value="60"  onClick="calculatePrice2();" disabled> <span class="label-text">Paint Protection - <b>£60</b></span>
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
							<!-- booking summary -->
                           <h5 class="form-heading-title"><span class="form-heading-no">3.</span>Contact Details &amp; Booking Summary</h5>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="row">
                                    <div class="col-md-8 contactdetail">
                                       <div class="col-sm-12">
                                          <p>Booking Summary</p>
                                          <div class="summary">
                                             <div class="form-group ">
                                                <label class="control-label " for="text">
                                                Vehicle Details
                                                </label>
                                                <input class="form-control" id="carDetail" name="carDetail" type="text" readonly/>
                                             </div>
                                             <div class="form-group ">
                                                <label class="control-label " for="text">
                                                Car Size
                                                </label>
                                                <input class="form-control" id="carSize" name="carSize" type="text" readonly/>
                                             </div>
                                             <div class="form-group ">
                                                <label class="control-label " for="text">
                                                Service Selected
                                                </label>
                                                <input class="form-control" id="serviceSelected" name="serviceSelected" type="text" readonly/>
                                             </div>
                                             <div class="form-group ">
                                                <label class="control-label " for="text">
                                                Date of Appointment
                                                </label>
                                                <input class="form-control" id="date" name="date" type="text" readonly/>
                                             </div>
                                             <div class="form-group ">
                                                <label class="control-label " for="text">
                                                Time Slot
                                                </label>
                                                <input class="form-control" id="time" name="time" type="text" readonly/>
                                             </div>
                                             <div class="form-group ">
                                                <input class="form-control" id="optionsSelected" name="optionsSelected" type="text" hidden readonly/>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <p id="serviceNote">Service Note</p>
                                       <textarea id="message" name="message" rows="17" placeholder="Message" maxlength="600" ></textarea>
                                       <span class="help-block" id="Serviceerror"></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row confirm">
							   <!-- sumbit the booking -->
                              <div class="col">
                                 <button type="submit" name="submit" id="submit"  value="submit" class="btn btn-secondary float-xs-right">Book Now</button>
                              </div>
							   <!-- total price -->
                              <div class="col">
                                 <div class="input-group mb-3" id="total">
                                    <div class="input-group-prepend" id="totaltext">
                                       <span class="input-group-text">Total is: £  </span>
                                    </div>
                                    <input id="totalPrice" name="totalPrice" class="form-control btn" value="0"></input>
                                 </div>
                              </div>
                           </div>
                     </div>
                     </form>
                     <!----------------------- End Form ---------------------->
                  </div>
               </div>
            </div>
		  <!-- include the footer -->
            <?php include 'includes/footer.php'; ?>
      </div>
      </section>
      </div>
		<!-- javascripts and functions -->
      <?php include 'includes/adminscripts.php'; ?>
      <script>
         $(document).ready(function(){
            $(this).scrollTop(0);
         });
      </script>
      <script>
         $( "#email" ).keyup(function() {
         	admin_booking();
         });
      </script>
      <script>
         $(document).on('click', '.customer-select', function (event) {
                   $( "input[type='search']" ).val('');
              		 $("#userTable").hide();
              $("#userTable_paginate").hide();
                       			$( "#searchError" ).hide();
         $( "#entererror" ).hide();
         $( "#error6" ).hide();
                 }
              );
           
      </script>
      <script>
         $(document).ready(function(){	
         $("#userTable").hide();
         $("#userTable_paginate").hide();
         
         //         
         //         $("#userTable_wrapper > div:first-child").addClass( "d-flex justify-content-center" );
         
         $("#userTable_wrapper").removeClass("container-fluid");
         
         
         
         
         
         
         $( "input[type='search']" ).keyup(function() {
             if($( "input[type='search']" ).val() == ''){
         $("#userTable").hide();
         	$("#userTable_paginate").hide();
         }else{
         $("#userTable").show();
         $("#userTable_paginate").show();
         }
         });
         
         //			 $("#search").click(function(){
         //    $("#userTable").show();
         //});
         
         $('#userTable_length').remove();
         $('#userTable_info').remove();
         
         
         
         //	$('.customer-select').attr("data-dismiss","modal"); 
         	
         	$(document).on('click', ".select-customer", function(e) {
         
            		e.preventDefault;
         
            		var customer = $(this);
         
            		$('#insert_customer').modal({ backdrop: 'static', keyboard: false });
         
            		return false;
         
            	});
         
            	$(document).on('click', ".customer-select", function(e) {
         			var customer_id = $(this).attr('data-customer-id');
         		    var customer_name = $(this).attr('data-customer-name');
         			var customer_Lname = $(this).attr('data-customer-Lname');
         		    var customer_email = $(this).attr('data-customer-email');
         		    var customer_phone = $(this).attr('data-customer-phone');
         var customer_reg = $(this).attr('data-customer-reg');
         var customer_model = $(this).attr('data-customer-model');
         var customer_year = $(this).attr('data-customer-year');
         
         $('#userId').val(customer_id);
         		    $('#first_name').val(customer_name);
         			$('#last_name').val(customer_Lname);
         		    $('#email').val(customer_email);
         		    $('#phone').val(customer_phone);
         $('#lookup').val(customer_reg);
         $('#model').val(customer_model);
         $('#year').val(customer_year);
         $('#carDetail').val(customer_year + " " + customer_model);
         	});
         
         });
         
      </script>
      <script>
         $( function () {
         var today = new Date();
         	$( "#datepicker" ).datepicker( {
         		dateFormat: "yyyy-mm-dd",
         minDate: today.getHours() >= 17 ? 2:1
         	} );
         	$( '#error4' ).hide();
         	$( "#datepicker" ).on( "change", function () {
         		var selected = $( this ).val();
         		$( "#instruction1" ).html( "" );
         		$( '#error4' ).show();
         		$( "#error3" ).html( "" );
         		$.ajax( {
         			url: '../functions/time1.php',
         			type: 'POST',
         			data: {
         				'date': selected
         			},
         			success: function ( data ) {
         
         				var availableTimes = [ '9:00 - 10:00', '11:00 - 12:00', '12:00 - 13:00', '13:00 - 14:00', '14:00 - 15:00', '15:00 - 16:00', '16:00 - 17:00' ];
         				var times;
         				var options = '';
         				var count = 0;
         				for ( var i = 0, l = availableTimes.length; i < l; i++ ) {
         
         					times = availableTimes[ i ];
         
         					if ( data.indexOf( times ) == -1 ) {
         						options += '<option value="' + times + '">' + times + '</option>';
         						count += 1;
         					}
         
         				}
         
         				if ( count < 1 ) {
         					options = '<option value="">No time available</option>';
         				}
         				$( '#times22' ).html( options );
         				$( "#times22" ).selectpicker( "refresh" );
         
         document.getElementById('date').value = $('#datepicker').val();
         
         
         
         			},
         
         		} ); // end ajax call
         	} );
         } );
      </script>
      <script>
         window.onload = function () {
         	$( '.selectpicker' ).find( '[value=""]' ).remove();
         	$( '.selectpicker' ).selectpicker( 'refresh' );
         	$( ".select1" ).hide();
         	$( ".select2" ).hide();
         	$( ".select3" ).hide();
         
         	$( ".extra1" ).hide();
         	$( ".extra2" ).hide();
         	$( ".extra3" ).hide();
         
         };
         $( document ).ready( function () {
         
         
         	$( '.purpose' ).on( 'change', function () {
         var selected = $(this).find("option:selected").val();
         		if ( selected == '1' ) {
         			$( 'input[type=checkbox]' ).each( function () {
         				this.checked = false;
         			} );
         			$( ".select1" ).show();
         			$( ".extra1" ).show();
         			$( "#error1" ).html( "" );
         			$( ".extraEmpty1" ).hide();
         			$( "#instruction" ).html( "" );
         			$( 'select[name=option1]' ).val( 0 );
         			$( 'select[name=option2]' ).val( 0 );
         			$( "input[type=checkbox]" ).attr( 'disabled', true );
         			$( '.selectpicker' ).selectpicker( 'refresh' );
         			$( "#instruction2" ).html( "Please Select Service Options First" );
         
         		} else {
         			$( ".select1" ).hide();
         			$( ".extra1" ).hide();
         			$( ".empty1" ).hide();
         			$( ".empty2" ).hide();
         
         		}
         		if ( selected == '2' ) {
         			$( 'input[type=checkbox]' ).each( function () {
         				this.checked = false;
         			} );
         			$( ".select2" ).show();
         			$( ".extra2" ).show();
         			$( "#error1" ).html( "" );
         			$( ".extraEmpty1" ).hide();
         			$( "#instruction" ).html( "" );
         			$( 'select[name=option]' ).val( 0 );
         			$( 'select[name=option2]' ).val( 0 );
         			$( '.selectpicker' ).selectpicker( 'refresh' );
         			$( "input[type=checkbox]" ).attr( 'disabled', true );
         			$( "#instruction2" ).html( "Please Select Service Options First" );
         
         
         		} else {
         			$( ".select2" ).hide();
         			$( ".extra2" ).hide();
         			$( ".empty1" ).hide();
         			$( ".empty2" ).hide();
         		}
         		if ( selected == '3' ) {
         			$( 'input[type=checkbox]' ).each( function () {
         				this.checked = false;
         			} );
         			$( ".select3" ).show();
         			$( ".extra3" ).show();
         			$( "#error1" ).html( "" );
         			$( ".extraEmpty1" ).hide();
         			$( "#instruction" ).html( "" );
         			$( 'select[name=option]' ).val( 0 );
         			$( 'select[name=option1]' ).val( 0 );
         			$( '.selectpicker' ).selectpicker( 'refresh' );
         			$( "input[type=checkbox]" ).attr( 'disabled', true );
         			$( "#instruction2" ).html( "Please Select Service Options First" );
         		} else {
         			$( ".select3" ).hide();
         			$( ".extra3" ).hide();
         			$( ".empty1" ).hide();
         			$( ".empty2" ).hide();
         		}
         	} );
         
         	$( '.select1' ).on( 'change', function () {
         		$( "input[type=checkbox]" ).attr( 'disabled', false );
         		$( "#error2" ).html( "" );
         		$( "#instruction2" ).html( "" );
         
         
         
         	} );
         	$( '.select2' ).on( 'change', function () {
         		$( "input[type=checkbox]" ).attr( 'disabled', false );
         		$( "#error2" ).html( "" );
         		$( "#instruction2" ).html( "" );
         
         	} );
         	$( '.select3' ).on( 'change', function () {
         		$( "input[type=checkbox]" ).attr( 'disabled', false );
         		$( "#error2" ).html( "" );
         		$( "#instruction2" ).html( "" );
         	} );
         	$( '#times22' ).on( 'change', function () {
         		$( "input[type=checkbox]" ).attr( 'disabled', false );
         		$( "#error4" ).html( "" );
         
         	} );
         
         } );
      </script>
      <script>
         var date = new Date();
         var dates = new Date();
         dates.getHours() >= 17 ? 1:1;
         date.setDate( date.getDate() - 1 );
         $( '#datepicker' ).datepicker( {
         	inline: true,
         	autoclose: true,
         	startDate: date,
         	todayHighlight: false,
         	format: "yyyy-mm-dd",
         minDate: dates,
         } );
      </script>
      <script>
         $('#lookup').on('input', function() {
         	    if ($(this).val().length > 0) {
              $('#model').val('');
         $('#year').val('');
         			$('#carDetail').val('');
         $( "#error6" ).show();
         $( "#searchError" ).show();
         $( "#entererror" ).show();
         
         
          }
          // do something
         });
         
      </script>
      <script>
         setInterval(function() 
          {
            $.ajax({                                      
              url: '../functions/getmaxid.php',              //the script to call to get data          
              data: "",                        //you can insert url argumnets here to pass to api.php    
              success: function(data)          //on recieve of reply
              {
         		if( $('#userId').val().trim() == '' ) {
         		$("#newuserId").val(data);
         	}else{
         		$("#newuserId").val("");
         	}
               
               
              }
         
            });
          }, 100);
         
         
         
      </script>
   </body>
</html>