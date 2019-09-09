<?php require 'functions/connections.php'; ?>
<?php
//resumes the session for current user
session_start();
$booking = $_GET['booking'];
$register = '';
$bookingnote = '';

if ($booking == '1') {
 $bookingnote = 'bookingnote';
}
$confirm = '';
if(isset($_SESSION['confirm'])){
	$confirm = 'yes';
}
unset($_SESSION[$booking]);

$resetEsent = '';
if(isset($_SESSION['resetEsent'])){
	$resetEsent = 'resetEsent';
}
$registerdone = '';
if(isset($_SESSION['registerdone'])){
	$registerdone = 'registerdone';
}
// check if userD is set i.e user is logged in
if (isset($_SESSION['userID'])) {
 // direct to index page if logged in
 header('Location: index');
}
else {
 $loginStatus = '';
 $activation = '';
 // If a user has just registered set the variable to display a confirmation message for successfully registering.
 if (isset($_SESSION['loginFailed'])) {
  $loginStatus = 'failed';
 }
 unset($_SESSION['loginFailed']);
 if (isset($_SESSION['error'])) {
  $activation = 'failed1';
 }
 unset($_SESSION['error']);
 // Prepare and bind
 $stmt = $con->prepare("SELECT * FROM Users WHERE Email = ?");
 $stmt->bind_param("s", $email);
 //check if the login button is clicked
 if (isset($_POST['LogIn'])) {
  //fetch the form inputs
  $email = $_POST['email'];
  $password = $_POST['password'];
  //execute the query
  $stmt->execute();
  $result = $stmt->get_result();
  //check if there is data in database
  if ($row = $result->fetch_assoc()) {
   // verify password entered matches database password
   $hashedPwdCheck = password_verify($password, $row['password']);
   $code = $row['com_code'];
   //password does not match
   if ($hashedPwdCheck == false) {
    // login failed indication
    $_SESSION['loginFailed'] = 'yes';
    // redirect to login page
    header('Location: login');
   }
   elseif ($hashedPwdCheck == true) {
    //check if account is activated
    if ($code == NULL) {
	 //fetch the users information and assign to the session
     $_SESSION['userID'] = $row['userID'];
     $userID = $row['userID'];
     $_SESSION['email'] = $row['email'];
     $_SESSION['password'] = $row['password'];
     $_SESSION['admin'] = $row['admin'];
	$_SESSION['fname'] = $row['fname'];
	 //update the subscribe for user logged in
     $stmt2 = $con->prepare("UPDATE Users SET subscribe = ? WHERE userID = $userID");
	 //bind the subscribe variable to the query
     $stmt2->bind_param("s", $subscribe);
     $subscribe = '0';
	 //execute the query
     $stmt2->execute();
	 //close the prepared statement
     $stmt2->close();
	 //direct to booking page when logged in sucessfully
     header('Location: booking');
    }
    else {
	//account exists but unactivated
     $_SESSION['error'] = 'yes';
     header('Location: login.php');
    }
	//close the prepared statement
    $stmt->close();
   }
  }
  else {
   //redirect to login page as log in failed.
   $_SESSION['loginFailed'] = 'yes';
   header('Location: login.php');
   //close the prepared statement
   $stmt->close();
  }
 }
}
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include the head file-->
      <?php include 'includes/head.php'; ?>
      <!-- individual login page css -->
      <link rel="stylesheet" href="css/login-form.css" type="text/css"/>
   </head>
   <body>
      <!-- include the navigation menu file-->
      <?php include 'includes/header.php'; ?>
	    <!-- content container-->
      <main class="main">
		  <!-- image and text for page title-->
         <div class="py-5 bg-image-full">
            <div id="text">
				<!-- page title-->
               <h1>LOGIN</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > LOGIN</p>
										<?php 
	   if($confirm == 'yes'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Thank you for activating your account - Please Now log in.
				</div>';}
	   unset($_SESSION['confirm']);
	   ?>
						  	   <?php 
	   if($resetEsent == 'resetEsent'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Email Has been sent with instruction to reset account password"
				</div>';}
	   unset($_SESSION['resetEsent']);
	   ?>
										  	   <?php 
	   if($registerdone == 'registerdone'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				 Email has been sent - Please Activate your Account"
				</div>';}
	   unset($_SESSION['registerdone']);
	   ?>
            </div>
         </div>
         <div class="container">
            <div class="signup-form-container">
               <!----------------------- Start Form ---------------------->
               <form method="post" name="login-form" id="login-form">
                  <div class="form-header">
                     <h3 class="form-title"><i class="fa fa-user"></i> Sign In</h3>
                     <div class="pull-right">
                        <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                     </div>
                  </div>
                  <div class="form-body">
                     <!-- output error message if account is not activated -->
                     <?php if($activation == 'failed1'){ ?>
                     <div class="ErrorMessage">
                        Please Activate Your Account
                     </div>
                     <?php } ?>
                     <?php if($bookingnote == 'bookingnote'){ ?>
                     <div class="ErrorMessage">
                        Please Sign In to Book an Appointment
                     </div>
                     <?php } ?>
                     <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                           <div class="input-group-addon"><span class="fa fa-user"></span>
                           </div>
                           <input name="email" type="email" class="form-control" id="email">
                        </div>
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="password" type="password" class="form-control" id="password">
                        </div>
                        <span class="help-block" id="error"></span>
                     </div>
                     <!-- output error message if login details are incorrect-->
                     <?php if($loginStatus == 'failed'){ ?>
                     <div class="ErrorMessage">
                        Incorrect Email or Password
                     </div>
                     <?php } ?>
                  </div>
                  <!-- Login Button -->
                  <div class="form-footer">
                     <div class="row">
                        <div class="form-group col-6" id="loginButton">
                           <button type="submit" name="LogIn" id="LogIn" value="LogIn" class="btn btn-info">
                           <span class="fa fa-sign-in"></span> Login</button>
                        </div>
                        <!-- forgot password link -->
                        <div class="form-group col-6" id="forgotPassword">
                           <a href="forgotpassword.php">Forgot Password</a>
                        </div>
                     </div>
                  </div>
                  <div class="noAccount">Don't Have An Account? <a href="register">Register Now</a></div>
               </form>
               <!----------------------- End Form ---------------------->
            </div>
         </div>
         <hr class="featurette-divider">
         <!-- /.container -->
      </main>
      <!----------------------- Start Footer ---------------------->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
   </body>
</html>