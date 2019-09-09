<?php require 'functions/connections.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include email functions
require 'functions/email.php';
//resumes the session for current user
session_start();
// Check if UserID is set indicating if user is logged in
if (!isset($_SESSION["userID"])) {
 header('Location: login?booking=1');
}
$userID = $_SESSION["userID"];
$admin = $_SESSION['admin'];
$email = $_SESSION['email'];
$firstname = $_SESSION['fname'];

?>
<?php
//check if submit button is pressed
if (isset($_POST['submit'])) {
	
		  //allows emails to be sent in the background
 // don't let user kill the script by hitting the stop button
 ignore_user_abort(true);
 // don't let the script time out
 set_time_limit(0);
 // start output buffering
 ob_start();
 //prepare and bind
 $stmt = $con->prepare("INSERT INTO Appointment(reg, model, year, timeSlot, date, carSize, serviceOption, extraOption, totalPrice,servicenote, userID) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
 //bind the form inputs to the query
 $stmt->bind_param("ssssssssssi", $reg, $model, $year, $timeSlot, $date, $carSize, $serviceOption, $extraOption, $totalPrice, $servicenote, $userID);
 //fetch the form inputs
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
 $userID = $_SESSION["userID"];
 //execute the query
 $stmt->execute();
 //close the prepared statement
 $stmt->close();


	 $stmt1 = $con->prepare("UPDATE Users SET reg=?, model=?, year=? WHERE userID = $userID");
 //bind the form inputs to the query
 $stmt1->bind_param("sss", $reg, $model, $year);
 //fetch the form inputs
 $reg = $_POST['lookup'];
 $model = $_POST['model'];
 $year = $_POST['year'];
 $userID = $_SESSION["userID"];
 //execute the query
 $stmt1->execute();
 //close the prepared statement
 $stmt1->close();
	 	$_SESSION['bookingdone'] = 'booked';
	header("Location: index.php");
	
		     // usleep(1500000); // do some stuff...
    header("Location: index");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
	
send_email_booking($firstname,$reg,$model,$year,$carSize,$serviceOption,$extraOption,$date,$timeSlot,$totalPrice,$email);
}
?>
<?php
//fetch data from database
//assign the ID of user Logged in
$userID = $_SESSION["userID"];
// Prepare and bind
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
$stmt->bind_param("i", $userID);
//execute the query
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION["firstName"] = $row['fname'];
$_SESSION["lastName"] = $row['lname'];
$_SESSION["email"] = $row['email'];
$_SESSION["phone"] = $row['phone'];
$_SESSION["reg"] = $row['reg'];
$_SESSION["model"] = $row['model'];
$_SESSION["year"] = $row['year'];

//close prepared statement
$stmt->close();
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php require 'includes/head.php'; ?>
      <!-- individual booking page css -->
      <link rel="stylesheet" href="css/booking.css" type="text/css"/>
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="css/plugins/bootstrapselect/bootstrap-select.min.css">
      <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
      <!-- datepicker css -->
   </head>
   <body>
      <!-- include navigation menu file -->
      <?php include 'includes/header.php'; ?>
	   <!-- content container-->
      <main class="main">
		  <!-- image and text for page title-->
         <div class="py-5 bg-image-full">
            <div id="text">
				<!-- page title-->
               <h1>BOOKING</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > BOOKING</p>
            </div>
         </div>
         <!--  appointments content-->
         <div id="appointments" class="appointment-main-block appointment-two-main-block">
            <div class="container">
               <div class="row">
                  <div class="section text-xs-center">
                     <h3 class="section-heading text-xs-center">Get an Appointment</h3>
                     <p class="sub-heading text-xs-center">To find out more about the services - Please visit <a href="services">Services Page</a>
                     </p>
                  </div>
                  <div class="appointment-block">
					  <!--  appointment form -->
                     <form id="appointment" class="appointment" method="post">
                        <h5 class="form-heading-title"><span class="form-heading-no">1.</span>Vehicle Information</h5>
                        <div class="row">
						<!-- car details-->
                           <div class="col-sm">
							   <!-- input field title -->
                              <p>Car VRM</p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" class="form-control" id="lookup" name="lookup" placeholder="Car Reg" value="<?php echo $_SESSION["reg"]; ?>" required>
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                           </div>
                           <div class="col-sm">
							   <!-- input field title -->
                              <p>Make &amp; Model</p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <input id="model" name="model" class="form-control" value="<?php echo $_SESSION["model"]; ?>" readonly>
                                 </div>
								  <!-- validation check -->
                                 <span class="help-block" id="error6"></span>
                              </div>
                              <div id="searchError" disabled></div>
                           </div>
                           <div class="col-sm">
							   <!-- input field title -->
                              <p>Car Year</p>
                              <input id="year" name="year" class="form-control" value="<?php echo $_SESSION["year"]; ?>" readonly>
                           </div>
                           <div>
							   <!-- search for car detail -->
                              <a onclick="startAjax();" id="search" class="btn">Search</a>
                           </div>
                        </div>
						 <!-- service booking, car size, options -->
                        <h5 class="form-heading-title"><span class="form-heading-no">2.</span>Appointment Information</h5>
                        <div class="row">
                           <div class="row serviceDescription" id="serviceDescription">
                              <div class="col-sm-4">
                                 <div class="card">
                                    <div class="card-block">
                                       <h4 class="card-title">Exterior Valet</h4>
                                       <h6 class="card-subtitle mb-2 text-muted">Small - £6 / Medium - £8 / Large - £10</h6>
                                       <h6 class="card-subtitle mb-2 text-muted">10 - 20 Minutes</h6>
                                       <p class="card-text">Exterior hand wash, alloy wheels cleaned, tyres conditioned and dressed, windows & mirrors cleaned</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="card">
                                    <div class="card-block">
                                       <h4 class="card-title">Exterior &amp; Interior Valet</h4>
                                       <h6 class="card-subtitle mb-2 text-muted">Small - £18 / Medium - £23 / Large - £28</h6>
                                       <h6 class="card-subtitle mb-2 text-muted">25 - 45 Minutes</h6>
                                       <p class="card-text">Exterior Valet plus interior and boot vacuum. Door shuts cleaned. All surfaces cleaned and polished. Windows Cleaned Inside and Outside</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="card">
                                    <div class="card-block">
                                       <h4 class="card-title">Full Valet</h4>
                                       <h6 class="card-subtitle mb-2 text-muted">Small - £40 / Medium - £50 / Large - £60</h6>
                                       <h6 class="card-subtitle mb-2 text-muted">60 - 80 Minutes</h6>
                                       <p class="card-text">Outside wash and full body wax polish. Windows cleaned inside - outside. All mats, carpets and upholstery shampooed. Leather cleaning and conditioning. Dashboard and fascia, all interior plastics and door. Boot (including spare tyre area). Air Vents + Ashtrays. Air freshener</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-8">
                              <div class="row">
                                 <div class="col-md-6">
                                    <p>Car Size</p>
                                    <div class="form-group">
                                       <div class="input-group">
                                          <select class="selectpicker purpose" name="size" id="size" onChange="resetting()" title="Select Car Size">
                                             <option id="Small" value="1">Small</option>
                                             <option id="Medium" value="2">Medium</option>
                                             <option id="Large" value="3">Large</option>
                                          </select>
                                       </div>
                                       <span class="help-block" id="error1"></span>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <p>Service Options</p>
                                    <div class="form-group">
                                       <div class="input-group">
                                          <select class="selectpicker empty1" title="Select Service Option">
                                          </select>
                                          <select class="selectpicker select1" NAME="option" onChange="calculatePrice()" title="Select Service Option" id="option" required>
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
							   <!-- date and time selector -->
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
							<!-- extra service options-->
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
                        <h5 class="form-heading-title"><span class="form-heading-no">3.</span>Contact Details &amp; Booking Summary  <span id="updateinfo">(To update your details, use my account section)</span></h5>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="row">
								  <!-- customer contact detail -->
                                 <div class="col-md-8 contactdetail">
                                    <div class="col-sm">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $_SESSION["firstName"]; ?>" readonly>
                                          </div>
                                          <span class="help-block" id="error"></span>
                                       </div>
                                    </div>
                                    <div class="col-sm">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $_SESSION["lastName"]; ?>" readonly>
                                          </div>
                                          <span class="help-block" id="error"></span>
                                       </div>
                                    </div>
                                    <div class="col-sm">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo $_SESSION["email"]; ?>" readonly>
                                          </div>
                                          <span class="help-block" id="error" ></span>
                                       </div>
                                    </div>
                                    <div class="col-sm">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $_SESSION["phone"]; ?>" readonly>
                                          </div>
                                          <span class="help-block" id="error"></span>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <textarea id="message" name="message" rows="6" placeholder="Message" maxlength="600" ></textarea>
                                       <span class="help-block" id="error"></span>
                                       <div id="textarea_feedback"></div>
                                    </div>
                                 </div>
								  <!-- booking summary -->
                                 <div class="col-md-4">
                                    <p>Booking Summary</p>
                                    <div class="summary">
                                       <div class="form-group ">
                                          <label class="control-label " for="text">
                                          Vehicle Details
                                          </label>
                                          <input class="form-control" id="carDetail" name="carDetail" type="text" value="<?php echo $_SESSION["year"].' '.$_SESSION["model"]; ?>" readonly/>
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
                           </div>
                        </div>
                        <div class="row confirm">
							<!-- booking button -->
                           <div class="col">
                              <button type="submit" name="submit" id="submit" value="submit" class="btn btn-secondary float-xs-right">Book Now</button>
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
               </div>
            </div>
         </div>
         </div>
         <!--  end appointments -->
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php require 'includes/script.php'; ?>
      <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
      <script type="text/javascript" src="js/totalprice.js"></script>
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
         var reg_num = $( "input[name='lookup']" ).val();
         var user_id = <?php echo $_SESSION[ "userID" ]; ?>;
         console.log(reg_num);
         console.log(user_id);
         		$( "#instruction1" ).html( "" );
         		$( '#error4' ).show();
         		$( "#error3" ).html( "" );
         		$.ajax( {
         			url: 'functions/usertime.php',
         			type: 'POST',
         			data: {
         				'date': selected,
         'user_id': user_id,
         'reg_num': reg_num
         			},
         			success: function ( data ) {
         				if(data == 'invalid'){
         options = '<option value="">You already booked this car for this date</option>';
         }else{
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
          }
         });
         
      </script>
      <script>
         $(document).ready(function() {
            var text_max = 600;
            $('#textarea_feedback').html(text_max + ' characters remaining');
         
            $('#message').keyup(function() {
                var text_length = $('#message').val().length;
                var text_remaining = text_max - text_length;
         
                $('#textarea_feedback').html(text_remaining + ' characters remaining');
            });
         });
      </script>
   </body>
</html>