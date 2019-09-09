<?php require 'functions/connections.php';?>
<?php
//Resumes the session for current user
session_start();
$admin = $_SESSION['admin'];
//used for outputting error message
$passwordcheck = '';
//in scenarios where the password entered is incorrect,
if (isset($_SESSION['passwordcheckfail'])) {
 $passwordcheck = 'failed';
}
unset($_SESSION['passwordcheckfail']);
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 if ($_SESSION["admin"] === 1) {
  // Redirect to homepage as admin has their own account page
  header("Location: ../index");
 }
}else {
 // Redirect to Login Page as user not logged in
 header('Location: login');
}//end of else
?>
<?php
//fetching the data from the database
//hold the session userid
$userID = $_SESSION["userID"];
// Prepare and bind
// select all users whos userID matches the session id
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
//bind session userid to the query
$stmt->bind_param("i", $userID);
//execute the statement
$stmt->execute();
//store the result
$result = $stmt->get_result();
$row = $result->fetch_assoc();
//store the current user password
$_SESSION["password"] = $row['password'];
//close the prepared statement
$stmt->close();
?>
<?php
// if update button is clicked
if (isset($_POST['update'])) {
//gets old password
$password = $_POST['oldpassword'];
//gets new password
$newpassword = $_POST['newpassword'];
 //Prepare and bind
 $stmt2 = $con->prepare("UPDATE Users SET password = ? WHERE userID = $userID");
 //bind the new password to the query
 $stmt2->bind_param("s", $storepassword);
 //check the password entered matches the current user password in the database
 if (password_verify($password, $_SESSION["password"])) {
  //hash the new file and store in the database for the user logged in
  $storepassword = password_hash($newpassword, PASSWORD_BCRYPT, array('cost' => 10));
  //execute the query
  $stmt2->execute();
  //close the prepared statement
  $stmt2->close();
  // pop up a success message when password updated
	 $_SESSION['passwordupdate'] = 'updated';
	 header("Location: index");
 }
 else {
  // password entered is wrong, redirect to update password page and show error message
  $_SESSION['passwordcheckfail'] = 'yes';
  header('Location: update_password');
  $stmt->close();
 }
}
?>

<!doctype html>
<html lang="en">
   <head>
      <!-- include the head file-->
      <?php include 'includes/head.php'; ?>
	   <!-- individual style sheet-->
      <link rel="stylesheet" href="css/updatePassword.css" type="text/css"/>
   </head>
   <body>
      <!-- include the navigation menu-->
      <?php include 'includes/header.php'; ?>
	   <!-- content container-->
      <main class="main">
		  <!-- image and text for page title-->
         <div class="py-5 bg-image-full">
            <div id="text">
               <h1>UPDATE PASSWORD</h1>
				<!-- breadcrumb navigation-->
               <p>ACCOUNT > UPDATE PASSWORD</p>
            </div>
         </div>
		  <!-- used for seperating page titile with content-->
         <hr class="featurette-divider">
         <div class="container">
            <!----------------------- Start Form ---------------------->
            <div class="signup-form-container">
               <!-- form start -->
               <form method="post" role="form" name="changePassword-form" id="changePassword-form" autocomplete="off">
                  <div class="form-header">
					  <!-- form title -->
                     <h3 class="form-title"><i class="fa fa-user"></i> Change Password</h3>
                     <div class="pull-right">
						 <!-- font awesome icon -->
                        <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                     </div>
                  </div>
                  <div class="form-body">
                     <!-- input one for current Password -->
                     <div class="form-group">
                        <label>Current Password</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="oldpassword" type="password" class="form-control" id="oldpassword" value="">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <!-- input for New Password -->
                     <div class="form-group">
                        <label>New Password</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="newpassword" type="password" class="form-control" id="newpassword" value="">
                        </div>
						 <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <!-- output a error message if password entered is incorrect -->
                     <?php if($passwordcheck == 'failed'){ ?>
                     <div class="ErrorMessage">
                        Please check your password
                     </div>
                     <?php } ?>
                  </div>
                  <!-- Update Button -->
                  <div class="form-footer">
                     <button type="submit" name="update" id="update" class="btn btn-info">
                     <span class="fa fa-sign-in"></span> Update Account
                     </button>
                  </div>
               </form>
               <!----------------------- End Form ---------------------->
            </div>
         </div>
         <hr class="featurette-divider">
      </main>
      <!---------- Footer -------------->
      <?php include 'includes/footer.php'; ?>
      <!----- scripts and functions ----->
      <?php include 'includes/script.php'; ?>
   </body>
</html>