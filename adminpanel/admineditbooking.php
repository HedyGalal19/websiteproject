<?php require '../functions/connections.php';?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include email functions
require '../functions/adminemailsetting.php';
//resumes the session for current user
session_start();
$sessionuserID = $_SESSION["userID"];
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 //checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  //redirect to home page as user is not admin
  header("Location: ../index");
 }
}
else {
 // redirect to Login Page as user has not logged in
 header("Location: ../login");
}
?>
<?php
//get the appointment id from the url parameter
$edit = $_GET['edi'];
// Connect to the database
$mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
// output any connection error
if ($mysqli->connect_error) {
 die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
//get all the appointment detail where appointment matches appointment id from url 
$query = "SELECT * FROM Appointment WHERE appID = $edit";
$results = $mysqli->query($query);
if ($results) {
 while ($row = $results->fetch_assoc()) {
  $reg = $row["reg"];
  $model = $row["model"];
  $year = $row["year"];
  $date = $row["date"];
  $carSize = $row["carSize"];
  $time = $row["timeSlot"];
  $service = $row["serviceOption"];
  $extra = $row["extraOption"];
  $message = $row["servicenote"];
  $totalprice = $row["totalPrice"];
	 $userID = $row["userID"];
	
 }
}
?>
<?php
//get all the appointment detail where appointment matches appointment id from url 
$query = "SELECT * FROM Users WHERE userID = $userID";
$results = $mysqli->query($query);
if ($results) {
 while ($row = $results->fetch_assoc()) {
  $first_name = $row["fname"];
  $email = $row["email"];
	
 }
}
// if update button is clicked
if (isset($_POST['updatebooking'])) {
	$edit = $_GET['edi'];
 // Prepare and bind an update query 
 $stmt = $con->prepare("UPDATE Appointment SET reg = ?, model = ?, year = ?, timeSlot = ? ,date=?,carSize=?,serviceOption=?,extraOption = ?, totalPrice=?, servicenote= ? WHERE appID = $edit");
 //bind the input values to the query
 $stmt->bind_param("ssssssssss", $reg, $model, $year, $timeSlot, $date, $carSize, $serviceOption, $extraOption, $totalPrice, $servicenote);
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
	send_email_rebooking($first_name,$reg,$model,$year,$carSize,$serviceOption,$extraOption,$date,$timeSlot,$totalPrice,$email);
	
  //execute the query
  $stmt->execute();
  //close the prepared statement
  $stmt->close();
header("Location: admin_edit.php?edi=$userID");
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php require 'includes/head.php'; ?>
	   <!-- individual booking edit css -->
      <link rel="stylesheet" href="../css/admineditbooking.css" type="text/css"/>
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
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="card text-center">
                  <div class="card-header">
                     Customer Detail
                  </div>
                  <div class="signup-form-container">
                     <!-- not allowing to register if javascript is disabled -->
                     <div id="nscript">
                        <noscript>
                           You cannot register without javascript enabled.
                        </noscript>
                     </div>
                     <!----------------------- Start Form--------- on submit check validation------->
                     <form method="post" role="form" name="register-form" id="register-form" autocomplete="off" onsubmit="return admin_booking(this)">
                        <div class="form-header">
                           <h3 class="form-title"><i class="fa fa-user"></i> Registration</h3>
                           <div class="pull-right">
                              <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
                           </div>
                        </div>
                        <h5 class="form-heading-title"><span class="form-heading-no">1.</span>Vehicle Information</h5>
                        <div class="row">
                           <div class="col-sm">
                              <p>Car VRM</p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon" id="regNumber">GB
                                    </div>
                                    <input type="text" class="registration-ui form-control" id="lookup" name="lookup" placeholder="Car Reg" value="<?php echo $reg ?>" required>
                                 </div>
                                 <span class="help-block" id="entererror"></span>
                              </div>
                           </div>
                           <div class="col-sm">
                              <p>Make &amp; Model</p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <input id="model" name="model" class="form-control" value="<?php echo $model ?>" readonly>
                                 </div>
                                 <span class="help-block" id="error6"></span>
                              </div>
                              <div id="searchError" disabled></div>
                           </div>
                           <div class="col-sm">
                              <p>Car Year</p>
                              <input id="year" name="year" class="form-control" value="<?php echo $year ?>" readonly>
                           </div>
                           <div id="regsearch">
							   <!-- search for the car details -->
                              <a onclick="startAjax();" id="search" class="btn">Search</a>
                           </div>
                        </div>
						 <!-- Appointment information, car size, services, extra services, date and time slot -->
                        <h5 class="form-heading-title"><span class="form-heading-no">2.</span>Appointment Information</h5>
                        <div class="row">
                           <div class="col-md-8">
                              <div class="row">
                                 <div class="col-md-6">
                                    <p>Car Size</p>
                                    <div class="form-group">
                                       <div class="input-group">
                                          <select class="selectpicker purpose" name="size" id="size" onChange="resetting()" title="">
                                             <option id="Small" value="1" <?php if($carSize=="Small") echo "selected"; ?>>Small</option>
                                             <option id="Medium" value="2" <?php if($carSize=="Medium") echo "selected"; ?>>Medium</option>
                                             <option id="Large" value="3" <?php if($carSize=="Large") echo "selected"; ?>>Large</option>
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
                                          <select class="selectpicker select1" name="option" onChange="calculatePrice()" title="Select Service Option" id="option" required>
                                             <option value=""></option>
                                             <option value="6" id="Exterior Valet" <?php if($service=="Exterior Valet" && $carSize == "Small") echo "selected"; ?>>Exterior Valet - <span>£6</span>
                                             </option>
                                             <option value="18" id="Exterior &amp; Interior Valet" <?php if($service=="Exterior & Interior Valet" && $carSize == "Small") echo "selected"; ?>>Exterior &amp; Interior Valet - <b>£18</b>
                                             </option>
                                             <option value="50" id="Full Valet" <?php if($service=="Full Valet" && $carSize == "Small") echo "selected"; ?>>Full Valet - <b>£50</b>
                                             </option>
                                          </select>
                                          <select class="selectpicker select2" NAME="option1" onChange="calculatePrice1()" title="Select Service Option" id="option1">
                                             <option value=""></option>
                                             <option value="8" id="Exterior Valet" <?php if($service=="Exterior Valet" && $carSize == "Medium") echo "selected"; ?>>Exterior Valet - <span>£8</span>
                                             </option>
                                             <option value="23" id="Exterior &amp; Interior Valet" <?php if($service=="Exterior & Interior Valet" && $carSize == "Medium") echo "selected"; ?>>Exterior &amp; Interior Valet - <b>£23</b>
                                             </option>
                                             <option value="60" id="Full Valet" <?php if($service=="Full Valet" && $carSize == "Medium") echo "selected"; ?>>Full Valet - <b>£60</b>
                                             </option>
                                          </select>
                                          <select class="selectpicker select3" NAME="option2" onChange="calculatePrice2()" title="Select Service Option" id="option2">
                                             <option value=""></option>
                                             <option value="10" id="Exterior Valet" <?php if($service=="Exterior Valet" && $carSize == "Large") echo "selected"; ?>>Exterior Valet - <span>£10</span>
                                             </option>
                                             <option value="28" id="Exterior &amp; Interior Valet" <?php if($service=="Exterior & Interior Valet" && $carSize == "Large") echo "selected"; ?>>Exterior &amp; Interior Valet - <b>£28</b>
                                             </option>
                                             <option value="70" id="Full Valet" <?php if($service=="Full Valet" && $carSize == "Large") echo "selected"; ?>>Full Valet - <b>£70</b>
                                             </option>
                                          </select>
                                       </div>
                                       <span class="help-block" id="error2"></span>
                                    </div>
                                 </div>
                              </div>
							   <!-- date and time selection -->
                              <div class="row">
                                 <div class="col-md-6">
                                    <p>Appointment Date</p>
                                    <div class="form-group">
                                       <div class="input-group date">
                                          <input type="text" class="form-control" name="datepicker" id="datepicker" placeholder="Appointment Date" value="<?php echo $date ?>"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                       </div>
                                       <span class="help-block" id="error3"></span>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <p>Time Slots</p>
                                    <div class="form-group">
                                       <div class="input-group">
                                          <select class="selectpicker" id="times22" name="timeSelection">
											  <option><?php echo $time ?></option>
                                          </select>
                                       </div>
                                       <span class="help-block" id="error4"></span>
                                    </div>
                                 </div>
                              </div>
                           </div>
							<!-- extra services we offer -->
                           <div class="col-md-4">
                              <div class="row">
                                 <div class="col-md-12">
                                    <p>Extra Services Options</p>
                                    <div class="extra1">
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Screen Wash Top-up" value="3" onClick="calculatePrice();" <?php if (strpos($extra, "Screen Wash Top-up") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Screen Wash Top-up - <b>£3</b></span>
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Extra Wax" value="5"  onClick="calculatePrice();" <?php if (strpos($extra, "Extra Wax") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Extra Wax - <b>£5</b></span>
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Odour Elimination" value="15"  onClick="calculatePrice();" <?php if (strpos($extra, "Odour Elimination") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Odour Elimination - <b>£15</b></span>
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Fabric Hood" value="17"  onClick="calculatePrice();" <?php if (strpos($extra, "Fabric Hood") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Fabric Hood - <b>£17</b></span>
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Leather Seat Treatment" value="25"  onClick="calculatePrice();" <?php if (strpos($extra, "Leather Seat Treatment") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Leather Seat Treatment - <b>£25</b></span>
                                          </label>
                                       </div>
                                       <div class="form-check">
                                          <label>
                                          <input type="checkbox" name="Paint Protection" value="40"  onClick="calculatePrice();" <?php if (strpos($extra, "Paint Protection") !== false && $carSize == "Small") echo "checked"; ?>> <span class="label-text">Paint Protection - <b>£40</b></span>
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
                                             <input class="form-control" id="carDetail" name="carDetail" type="text" value="<?php echo $year." ".$model ?>" readonly/>
                                          </div>
                                          <div class="form-group ">
                                             <label class="control-label " for="text">
                                             Car Size
                                             </label>
                                             <input class="form-control" id="carSize" name="carSize" type="text" value="<?php echo $carSize ?>" readonly/>
                                          </div>
                                          <div class="form-group ">
                                             <label class="control-label " for="text">
                                             Service Selected
                                             </label>
                                             <input class="form-control" id="serviceSelected" name="serviceSelected" type="text" value="<?php echo $service ?>" readonly/>
                                          </div>
                                          <div class="form-group ">
                                             <label class="control-label " for="text">
                                             Date of Appointment
                                             </label>
                                             <input class="form-control" id="date" name="date" type="text" value="<?php echo $date ?>" readonly/>
                                          </div>
                                          <div class="form-group ">
                                             <label class="control-label " for="text">
                                             Time Slot
                                             </label>
                                             <input class="form-control" id="time" name="time" type="text" value="<?php echo $time ?>" readonly/>
                                          </div>
                                          <div class="form-group ">
                                             <input class="form-control" id="optionsSelected" name="optionsSelected" type="text" value="<?php echo $extra ?>" hidden readonly/>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col">
                                    <p id="serviceNote">Service Note</p>
                                    <textarea id="message" name="message" rows="17" placeholder="Message" maxlength="600"><?php echo $message ?></textarea>
                                    <span class="help-block" id="Serviceerror"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row confirm">
                           <div class="col">
                              <button type="submit" name="updatebooking" id="updatebooking"  value="updatebooking" class="btn btn-secondary float-xs-right">Update Booking</button>
                           </div>
						  <!-- total price -->
                           <div class="col">
                              <div class="input-group mb-3" id="total">
                                 <div class="input-group-prepend" id="totaltext">
                                    <span class="input-group-text">Total is: £  </span>
                                 </div>
                                 <input id="totalPrice" name="totalPrice" class="form-control btn" value="<?php echo $totalprice ?>"></input>
                              </div>
                           </div>
                        </div>
                  </div>
                  </form>
                  <!----------------------- End Form ---------------------->
               </div>
            </div>
		  <!-- include page footer -->
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
         
         var al = $(".purpose .filter-option").text();    
         
         
         if(al == "Small"){
         $( ".select1" ).show();
         $( ".select2" ).hide();
         $( ".select3" ).hide();
         
         $( ".extra1" ).show();
         $( ".extra2" ).hide();
         $( ".extra3" ).hide();
         
         
         }else if(al == "Medium"){
         $( ".select1" ).hide();
         $( ".select2" ).show();
         		$( ".select3" ).hide();
         $( ".extra1" ).hide();
         $( ".extra2" ).show();
         $( ".extra3" ).hide();
         }else if(al == "Large"){
         $( ".select1" ).hide();
         $( ".select2" ).hide();
         		$( ".select3" ).show();
         $( ".extra1" ).hide();
         $( ".extra2" ).hide();
         $( ".extra3" ).show();
         }

         
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
         });
         
      </script>
   </body>
</html>