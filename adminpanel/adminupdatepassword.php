<?php
require '../functions/connections.php';
 ?>
<?php
// Resumes the session for current user
session_start();
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 // Checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  // Redirect to Account Page as user is not admin
  header("Location: ../../index");
 }
 else {
  // DO nothing as admin is logged in
 }
}
else {
 // redirect to Login Page
 header("Location: ../login");
}
?>
<?php
// fetch info from db
$userID = $_SESSION["userID"];
// Prepare and bind
$stmt = $con->prepare("SELECT * FROM Users WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION["password"] = $row['password'];
$stmt->close();
// gets old password
$password = $_POST['oldpassword'];
// gets new password
$newpassword = $_POST['newpassword'];
?>
<?php
//if update button is clicked
if (isset($_POST['update'])) {
 // Prepare and bind, update the admin password
 $stmt2 = $con->prepare("UPDATE Users SET password = ? WHERE userID = $userID");
 $stmt2->bind_param("s", $storepassword);
 if (password_verify($password, $_SESSION["password"])) {
  //hash new password
  $storepassword = password_hash($newpassword, PASSWORD_BCRYPT, array('cost' => 10));
  $stmt2->execute();
  $stmt2->close();
  // show pop up confirmation message when password updated
  echo '<script>
       setTimeout(function() {
           swal({
               title: "Password Update",
               text: "Password Updated Successfully!",
               type: "success"
           }, function() {
               window.location = "adminupdate";
           });
       }, 100);
      </script>';
 }
 else {
  //close the prepared statement
  $stmt->close();
 }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include head-->
      <?php include 'includes/head.php'; ?>
      <!-- include css file-->
      <link rel="stylesheet" href="../css/updatePassword.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Admin Change Password</h2>
            </div>
         </header>
         <section class="dashboard no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="container">
                     <!----------------------- Start Form ---------------------->
                     <div class="signup-form-container">
                        <!-- form start -->
                        <form method="post" role="form" name="changePassword-form" id="changePassword-form" autocomplete="off" onsubmit="return update_password(this)">
                           <div class="form-header">
                              <h3 class="form-title"><i class="fa fa-user"></i> Change Password</h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
                              </div>
                           </div>
                           <div class="form-body">
                              <div id="password_status"></div>
                              <!-- Field one for current Password -->
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="oldpassword" type="text" class="form-control" id="oldpassword" value="" placeholder="Current Password">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <!-- Field two for New Password -->
                              <div class="form-group">
                                 <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span>
                                    </div>
                                    <input name="newpassword" type="text" class="form-control" id="newpassword" value="" placeholder="New Password">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                           </div>
                           <!-- Update password Button -->
                           <div class="form-footer">
                              <button type="submit" name="update" id="update" class="btn btn-info">
                              <span class="fa fa-sign-in"></span> Update Account
                              </button>
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
      <!-- Javascript files and functions-->
      <?php include 'includes/adminscripts.php'; ?>
   </body>
</html>