<?php require 'functions/connections.php'; ?>
<?php
//include email functions
require 'functions/email.php';
//resumes the session for current user
session_start();
// check if userD is set i.e user is logged in
if (isset($_SESSION['userID'])) {
 // direct user to homepage as user is logged in
 header('Location: ../index');
}
else {
 // otherwise add database when they register
 // Prepare and bind
 $stmt = $con->prepare("INSERT INTO Users(reg, model, year,fname, lname, phone, email, password, com_code, regdate) VALUES (?,?,?,?,?,?,?,?,?,?)");
 //bind the form inputs to the query
 $stmt->bind_param("ssssssssss", $reg, $model, $year, $first_name, $last_name, $phone, $email, $storePassword, $com_code, $time);
 //check if register button being clicked
 if (isset($_POST['register'])) {
  //fetch the input values from the form
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $reg = $_POST['lookup'];
  $model = $_POST['model'];
  $year = $_POST['year'];
  $password = $_POST['password'];
  //random activation code generated
  $com_code = md5(uniqid(rand()));
  //timestap of registration date
  $time = date("Y-m-d");
  //hash account password
  $storePassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
  //execute the query
  $stmt->execute();
  //close the prepared statement
  $stmt->close();
  //send an email to registered user email to activate their account
  send_email_register($first_name, $email, $com_code);
  // direct to the login page after successful registration
  $_SESSION['registerdone'] = 'registerdone';
	 header('Location: login');
 }
}//end else
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
	  <!-- individual register page css-->
      <link rel="stylesheet" href="css/signup-form.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu -->
      <?php include 'includes/header.php'; ?>
      <main class="main">
         <div class="py-5 bg-image-full">
            <div id="text">
               <h1>SIGN UP</h1>
               <p>HOME > SIGN UP</p>
            </div>
         </div>
         <div class="container">
            <div class="signup-form-container">
               <!-- not allowing to register if javascript is disabled -->
               <div id="nscript">
                  <noscript>
                     Please Enable Javascript to Continue.
                  </noscript>
               </div>
               <!----------------------- Start Form -- on submit check validation--->
               <form method="post" role="form" name="register-form" id="register-form" autocomplete="off" onsubmit="return registercheck(this)">
                  <div class="form-header">
                     <h3 class="form-title"><i class="fa fa-user"></i> Registration</h3>
                     <div class="pull-right">
                        <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                     </div>
                  </div>
                  <div class="form-body">
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
							   <!-- input field title -->
                              <label>Car Registeration Number</label>
                              <div class="input-group">
								  <!-- font awesome icon -->
                                 <div class="input-group-addon" id="regNumber">GB
                                 </div>
                                 <input type="text" class="registration-ui form-control" id="lookup" name="lookup" required>
                              </div>
                              <span class="help-block" id="error"></span>
                           </div>
							<!-- validation check appears here -->
                           <div id="searchError" disabled></div>
                        </div>
						 <!-- search for the car details -->
                        <div class="col-sm">
                           <a onclick="startAjax();" id="search" class="btn">Search</a>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
							   <!-- input field title -->
                              <label>Make &amp; Model</label>
                              <div class="input-group">
								  <!-- font awesome icon -->
                                 <div class="input-group-addon"><span class="fa fa-user"></span>
                                 </div>
                                 <input id="model" name="model" class="form-control" readonly>
                              </div>
							   <!-- validation check appears here -->
                              <span class="help-block" id="error"></span>
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
							   <!-- input field title -->
                              <label>Year</label>
                              <div class="input-group">
								  <!-- font awesome icon -->
                                 <div class="input-group-addon"><span class="fa fa-user"></span>
                                 </div>
                                 <input id="year" name="year" class="form-control" readonly>
                              </div>
							   <!-- validation check appears here -->
                              <span class="help-block" id="error"></span>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>First Name</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-user"></span>
                           </div>
                           <input name="first_name" id="first_name" type="text" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Last Name</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-user"></span>
                           </div>
                           <input name="last_name" id="last_name" type="text" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Mobile Phone Number</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-phone"></span>
                           </div>
                           <input name="phone" id="phone" type="text" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Email Address</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-envelope"></span>
                           </div>
                           <input name="email" id="email" type="text" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                        <div id="status"></div>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Password - Minimum of 8 Characters</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="password" id="password" type="password" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Retype Password</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="copypassword" id="copypassword" type="password" class="form-control">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                  </div>
                  <!-- Register Button -->
                  <div class="form-footer">
                   <div class="row">
                   <div class="col-lg-9">
                    <span id="termscondition">By clicking Register you agree to our <a href="terms.php">Term of Service</a> &amp; <a href="privacy.php">Privacy Policy</a></span>
                    </div>
                    <div class="col">
                     <button type="submit" name="register" id="register" class="btn btn-info" disabled>
					<!-- font awesome icon -->
                     <span class="fa fa-sign-in"></span> Register
         
                     </button>
                     </div>
                    </div>
                  </div>
               </form>
               <!----------------------- End Form ---------------------->
            </div>
         </div>
         <hr class="featurette-divider">
         <!-- /.container -->
      </main>
      <!----------------------- Footer ---------------------->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
      <script type="text/javascript">
         var _onload = window.onload || function () {
         	document.getElementById( 'register' ).disabled = false;
         }
         _onload();
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
   </body>
</html>