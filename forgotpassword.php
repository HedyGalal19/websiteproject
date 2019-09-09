<?php require 'functions/connections.php'; ?>
<?php
// include email sending functions
require 'functions/email.php';

// Resumes the session for current user
session_start();
// check if userD is set i.e user is logged in
if (isset($_SESSION['userID'])) {
 // direct to index page if already logged in
 header('Location: ../index');
}
else {
 $emailcheck = '';
 // In scenarios where the email entered is incorrect,
 if (isset($_SESSION['emailcheckfail'])) {
  $emailcheck = 'failed';
 }
 unset($_SESSION['emailcheckfail']);
 // otherwise add database when they register
 // Prepare and bind
 $stmt = $con->prepare("SELECT * FROM Users WHERE email = ?");
 $stmt->bind_param("s", $email);
 // when the rest button is clicked in the form
 if (isset($_POST['reset'])) {
  // fetch the email written in the field
  $email = $_POST['email'];
  // assign a random unique md5 hash to forgotpassword variable - used i database for futher password resetting
  $forgotpassword = md5(uniqid(rand()));
  // execute statment
  $stmt->execute();
  $result = $stmt->get_result();
  // check if there are data in the database table
  if ($row = $result->fetch_assoc()) {
   // update the database column 'forgot password' where the email matches entered email
   $stmt2 = $con->prepare("UPDATE Users SET forgotpassword = ? WHERE userID = ?");
   $stmt2->bind_param("si", $forgotpassword, $userID);
   $first_name = $row['fname'];
   $userID = $row['userID'];
   $stmt2->execute();
   // send a forgot password email including name of customer, the email and forgot password link
   send_email_forgotpassword($first_name, $email, $forgotpassword);
	$_SESSION['resetEsent'] = 'resetEsent';
	header("Location: login");
   $stmt2->close();
  }
  else {
   // redirect to forgot password page as incorrect email entered in failed.
   $_SESSION['emailcheckfail'] = 'yes';
   header('Location: forgotpassword');
   $stmt->close();
  }
 }
}
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include the head php file -->
      <?php include 'includes/head.php'; ?>
      <!-- use the login form css -->
      <link rel="stylesheet" href="css/login-form.css" type="text/css"/>
   </head>
   <body>
      <!-- include the header php file -->
      <?php include 'includes/header.php'; ?>
      <!-- content container-->
      <main class="main">
		  <!-- image and text for page title-->
         <div class="py-5 bg-image-full">
            <div id="text">
				<!-- page title-->
               <h1>FORGOT PASSWORD</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > FORGOT PASSWORD</p>
            </div>
         </div>
		  <!-- used for seperating page title with content-->
         <hr class="featurette-divider">
         <div class="container">
            <div class="signup-form-container">
               <!----------------------- Start Form ---------------------->
               <form method="post" name="login-form" id="login-form">
                  <div class="form-header">
                     <h3 class="form-title"><i class="fa fa-user"></i> Forgot Password</h3>
                     <div class="pull-right">
                        <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                     </div>
                  </div>
                  <div class="form-body">
                     <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                           <!-- font awesome icon-->
                           <div class="input-group-addon"><span class="fa fa-envelope"></span>
                           </div>
                           <input name="email" type="email" class="form-control" id="email">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <!-- output a error message if email entered is incorrect -->
                     <?php if($emailcheck == 'failed'){ ?>
                     <div class="ErrorMessage">
                        Please check your email
                     </div>
                     <?php } ?>
                  </div>
                  <!-- reset Button -->
                  <div class="form-footer">
                     <div class="row">
                        <div class="form-group col-6">
                           <button type="submit" name="reset" id="reset" value="reset" class="btn btn-info">
							<!-- font awesome icon-->
                           <span class="fa fa-sign-in"></span> Reset Password</button>
                        </div>
                     </div>
                  </div>
               </form>
               <!----------------------- End Form ---------------------->
            </div>
         </div>
         <hr class="featurette-divider">
      </main>
      <!----------------------- include footer file ---------------------->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
   </body>
</html>