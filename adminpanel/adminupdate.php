<?php require '../functions/connections.php'; ?>
<?php
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
 // redirect to Login Page
 header("Location: ../login");
}
?>
<?php
// fetch info from db
// Assign the ID of user Logged in
$userID = $_SESSION["userID"];
// Prepare and bind
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION["first_name"] = $row['fname'];
$_SESSION["last_name"] = $row['lname'];
$_SESSION["email"] = $row['email'];
$_SESSION["password"] = $row['password'];
$_SESSION["phone"] = $row['phone'];
$stmt->close();
// gets old password
$PW = $_POST['password'];
?>
<?php
// if update button is clicked
if (isset($_POST['update'])) {
 // Prepare and bind
 $stmt2 = $con->prepare("UPDATE Users SET fname = ?, lname = ?, email = ?, phone = ? WHERE userID = $userID");
 $stmt2->bind_param("ssss", $updatefirstname, $updatelastname, $updateemail, $updatephone);
 // Check Password entered matches current logged in user password
 if (password_verify($PW, $_SESSION["password"])) {
  //fetch the admin new detail from form
  $updatefirstname = $_POST['first_name'];
  $updatelastname = $_POST['last_name'];
  $updateemail = $_POST['email'];
  $updatephone = $_POST['phone'];
  $stmt2->execute();
  $stmt2->close();
  // pop up success message when account updated successfully
  echo '<script>
    	setTimeout(function() {
        swal({
            title: "Account Update",
            text: "Account Updated Successfully!",
            type: "success"
        }, function() {
            window.location = "adminupdate";
        });
    }, 100);
   </script>';
 }
 else {
  //close the prepared statement
  $stmt2->close();
 }
}
?>
<!DOCTYPE html>
<html>
   <!-- include page head file-->
   <?php include 'includes/head.php'; ?>
   <body>
      <!-- include navigation menu -->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Admin Update Account</h2>
            </div>
         </header>
         <!-- Regitered User-->
         <section class="dashboard no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="container">
                     <div class="signup-form-container">
                        <!----------------------- Start Form ---on submit check validation----------->
                        <form method="post" role="form" name="update-form" id="update-form" autocomplete="off" onsubmit="return update_account(this)">
                           <div class="form-header">
                              <h3 class="form-title"><i class="fa fa-user"></i> Update Account</h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                              </div>
                           </div>
                           <div class="form-body">
                              <div class="form-group">
                                 <label>First Name</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="first_name" id="first_name" type="text" class="form-control" value="<?php echo $_SESSION["first_name"]; ?>">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Last Name</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="last_name" id="last_name" type="text" class="form-control" value="<?php echo $_SESSION["last_name"]; ?>">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Phone Number</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-phone"></span>
                                    </div>
                                    <input name="phone" id="phone" type="text" class="form-control" value="<?php echo $_SESSION["phone"]; ?>">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Email Address</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-envelope"></span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control" value="<?php echo $_SESSION["email"]; ?>">
                                 </div>
                                 <span class="help-block" id="error"></span>
                                 <div id="status"></div>
                              </div>
                              <div class="form-group">
                                 <label>Please Enter Account Password to Update Details</label>
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-lock"></span>
                                    </div>
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Password" autocomplete="off">
                                 </div>
                                 <span class="help-block" id="error"></span>
                                 <div id="password_status"></div>
                              </div>
                           </div>
                           <!-- Update Button -->
                           <div class="form-footer">
                              <div class="row">
                                 <div class="form-group col-6">
                                    <button type="submit" name="update" id="update" class="btn btn-info">Update Account</button>
                                 </div>
                                 <div class="form-group col-6">
                                    <a href="adminupdatepassword.php"><input name="updatepassword" type="button" class="btn btn-info" id="updatepassword" value="Update Password"></a>
                                 </div>
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
   </body>
</html>