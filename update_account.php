<?php require 'functions/connections.php'; ?>
<?php
//resumes the session for current user
session_start();
//user status of being admin or not
$admin = $_SESSION['admin'];
//check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 if ($_SESSION["admin"] === 1) {
  //redirect to homepage Page as admin has its own account page
  header("Location: ../index");
 }
}else {
 // Redirect to Login Page as user is not logged in
 header('Location: login');
}
?>
<?php
//fetch user data from database
//Assign the ID of user Logged in
$userID = $_SESSION["userID"];
// Prepare and bind
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
//bind the session id to the query
$stmt->bind_param("i", $userID);
//execute the query
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
//fetch the users data and assign to session variable
$_SESSION["first_name"] = $row['fname'];
$_SESSION["last_name"] = $row['lname'];
$_SESSION["email"] = $row['email'];
$_SESSION["password"] = $row['password'];
$_SESSION["phone"] = $row['phone'];
$_SESSION["reg"] = $row['reg'];
$_SESSION["model"] = $row['model'];
$_SESSION["year"] = $row['year'];
//close the prepared statement
$stmt->close();
//fetch the password entered from the form
$PW = $_POST['password'];
?>
<?php
// if update button is clicked
if (isset($_POST['update'])) {
 // Prepare and bind an update query 
 $stmt2 = $con->prepare("UPDATE Users SET fname = ?, lname = ?, email = ?, phone = ? ,reg=?,model=?,year=? WHERE userID = $userID");
 //bind the input values to the query
 $stmt2->bind_param("sssssss", $updatefirstname, $updatelastname, $updateemail, $updatephone, $updatereg, $updatemodel, $updateyear);
 // Check Password entered matches users account password for the user Logged in
 if (password_verify($PW, $_SESSION["password"])) {
  //fetch the input values from the form
  $updatefirstname = $_POST['first_name'];
  $updatelastname = $_POST['last_name'];
  $updateemail = $_POST['email'];
  $updatephone = $_POST['phone'];
  $updatereg = $_POST['lookup'];
  $updatemodel = $_POST['model'];
  $updateyear = $_POST['year'];
  // hash the new password
  $storePassword = password_hash($NEWPW, PASSWORD_BCRYPT, array('cost' => 10));
  //execute the query
  $stmt2->execute();
  //close the prepared statement
  $stmt2->close();
  // display a pop up success message when account updated successfully
	 $_SESSION['accountupdate'] = 'accountupdated';
	 header("Location: index");
	 
 }
 else {
  $stmt2->close();
 }
}
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <!-- individual update account css -->
      <link rel="stylesheet" href="css/update_account.css" type="text/css"/>
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
               <h1>UPDATE ACCOUNT</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > UPDATE ACCOUNT</p>
            </div>
         </div>
		  <!-- used for seperating page titile with content-->
         <hr class="featurette-divider">
         <div class="container">
            <div class="signup-form-container">
               <!----------------------- Start Form --- on submit check the form validations ------>
               <form method="post" role="form" name="update-form" id="update-form" autocomplete="off" onsubmit="return update_account(this)">
                  <div class="form-header">
					  <!-- form title -->
                     <h3 class="form-title"><i class="fa fa-user"></i> Update Account</h3>
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
                                 <input type="text" class="registration-ui form-control" id="lookup" name="lookup" value="<?php echo $_SESSION["reg"]; ?>" required>
                              </div>
							    <!-- validation check appears here -->
                              <span class="help-block" id="error"></span>
                           </div>
							 <!-- checks the number plate entered -->
                           <div id="searchError" disabled></div>
                        </div>
                        <div class="col-sm">
							 <!-- searches for the care detail -->
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
                                 <input id="model" name="model" class="form-control" value="<?php echo $_SESSION["model"]; ?>" readonly>
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
                                 <input id="year" name="year" class="form-control" value="<?php echo $_SESSION["year"]; ?>" readonly>
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
                           <input name="first_name" id="first_name" type="text" class="form-control" value="<?php echo $_SESSION["first_name"]; ?>">
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
                           <input name="last_name" id="last_name" type="text" class="form-control" value="<?php echo $_SESSION["last_name"]; ?>">
                        </div>
						  <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Phone Number</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-phone"></span>
                           </div>
                           <input name="phone" id="phone" type="text" class="form-control" value="<?php echo $_SESSION["phone"]; ?>">
                        </div>
						  <!-- validation check appears here -->
                        <span class="help-block" id="error"></span>
                        <div id="status"></div>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Email Address</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-envelope"></span>
                           </div>
                           <input name="email" id="email" type="text" class="form-control" value="<?php echo $_SESSION["email"]; ?>">
                        </div>
						 <!-- password validation message -->
                        <span class="help-block" id="error"></span>
						 <!-- email duplication validation -->
                        <div id="status"></div>
                     </div>
                     <div class="form-group">
						 <!-- input field title -->
                        <label>Please Enter Account Password to Update Details</label>
                        <div class="input-group">
							<!-- font awesome icon -->
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="password" id="password" type="password" class="form-control" autocomplete="off">
                        </div>
						 <!-- password validation message -->
                        <span class="help-block" id="error"></span>
						 <!-- password validation appears in the div -->
                        <div id="password_status"></div>
                     </div>
                  </div>
                  <div class="form-footer">
                     <div class="row">
						 <!-- submit the form to update account button -->
                        <div class="form-group col-6">
                           <button type="submit" name="update" id="update" class="btn btn-info">Update Account</button>
                        </div>
                        <!-- update password button -->
                        <div class="form-group col-6">
                           <a href="update_password.php"><input name="updatepassword" type="button" class="btn btn-info" id="updatepassword" value="Update Password"></a>
                        </div>
                     </div>
                  </div>
               </form>
               <!----------------------- End Form ---------------------->
            </div>
         </div>
         <hr class="featurette-divider">
      </main>
      <!----------------------- Start Footer ---------------------->
      <?php include 'includes/footer.php'; ?>
      <!-------- scripts and functions --------------->
      <?php include 'includes/script.php'; ?>
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