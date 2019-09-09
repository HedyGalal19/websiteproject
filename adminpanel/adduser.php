<?php require '../functions/connections.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include email functions
require '../functions/adminemailsetting.php';
// Resumes the session for current user
session_start();
$admin = $_SESSION['admin'];
// check if userD is set i.e user is logged in
if (isset($_SESSION['userID'])) {
 if ($_SESSION["admin"] === 0) {
  // direct user to index page as user is already registered
  header('Location: ../index');
 }
 else {
  // otherwise add database when they register
  // Prepare and bind
  // check for register button being clicked
  if (isset($_POST['register'])) {
   $stmt = $con->prepare("INSERT INTO Users(reg, model, year,fname, lname, phone, email, password, com_code, regdate) VALUES (?,?,?,?,?,?,?,?,?,?)");
   $stmt->bind_param("ssssssssss", $reg, $model, $year, $first_name, $last_name, $phone, $email, $storePassword, $com_code, $time);
   //fetch the input values from form
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $phone = $_POST['phone'];
   $email = $_POST['email'];
   $reg = $_POST['lookup'];
   $model = $_POST['model'];
   $year = $_POST['year'];
   //get the last 4 characters of first name and last 4 digits of phone number 
   $password1 = substr($first_name, -4);
   $password2 = substr($phone, -4);
   //create password from substrings
   $password = $password1 . $password2;
   //random generated activation code
   $com_code = md5(uniqid(rand()));
   //timestap of registration
   $time = date("Y-m-d");
   //hash password
   $storePassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
   //execute query
   $stmt->execute();
   //close prepared statement
   $stmt->close();
	  send_email_register($first_name, $email, $com_code);
   //show success message and direct to the admin page
   echo '<script>
      	setTimeout(function() {
          swal({
              title: "Registration",
              text: "Added Successfully!",
              type: "success"
          }, function() {
              window.location = "admin";
          });
      }, 100);
      </script>';
  }
 }
}
else {
 header('Location: ../login');
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <link rel="stylesheet" href="../css/adminregister.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu file -->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Add Customer</h2>
            </div>
         </header>
         <!-- Dashboard Counts Section-->
         <section class="dashboard no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <div class="container">
                     <div class="signup-form-container">
                        <!----------------------- Start Form --- on submit check validation ----------->
                        <form method="post" role="form" name="register-form" id="register-form" autocomplete="off" onsubmit="return registercheck(this)">
                           <div class="form-header">
							   <!-- form title -->
                              <h3 class="form-title"><i class="fa fa-user"></i> Registration</h3>
                              <div class="pull-right">
                                 <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                              </div>
                           </div>
                           <div class="form-body">
                              <div class="row">
                                 <div class="col-sm">
                                    <div class="form-group">
                                       <label>Car Registeration Number</label>
                                       <div class="input-group">
                                          <div class="input-group-addon" id="regNumber">GB
                                          </div>
                                          <input type="text" class="registration-ui form-control" id="lookup" name="lookup" required>
                                       </div>
										<!-- validation check appears here -->
                                       <span class="help-block" id="error"></span>
                                    </div>
                                    <div id="searchError" disabled></div>
                                 </div>
                                 <div class="col-sm">
									 <!-- search for the detail -->
                                    <a onclick="startAjax();" id="search" class="btn">Search</a>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm">
                                    <div class="form-group">
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
                                 <label for="exampleInputEmail1">Last Name</label>
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
                                 <label>Phone Number</label>
                                 <div class="input-group">
									 <!-- font awesome icon -->
                                    <div class="input-group-addon"><span class="fa fa-phone"></span>
                                    </div>
                                    <input name="phone" id="phone" type="text" class="form-control">
                                 </div>
                                 <span class="help-block" id="error"></span>
                              </div>
                              <div class="form-group">
                                 <label>Email Address</label>
                                 <div class="input-group">
									 <!-- font awesome icon -->
                                    <div class="input-group-addon"><span class="fa fa-envelope"></span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control">
                                 </div>
								  <!-- validation check appears here -->
                                 <span class="help-block" id="error"></span>
								  <!-- check email duplication -->
                                 <div id="status"></div>
                              </div>
                           </div>
                           <!-- Register Button -->
                           <div class="form-footer">
                              <div class="row">
                                 <div class="form-group col-6">
									 <!-- add user to system -->
                                    <button type="submit" name="register" id="register" class="btn btn-info"> Register</button>
                                 </div>
                                 <div class="form-group col-6">
									 <!-- cancel adding user -->
                                    <a href="admin.php"><input type="button" class="btn btn-info" value="Cancel"></a>
                                 </div>
                              </div>
                           </div>
                        </form>
                        <!----------------------- End Form ---------------------->
                     </div>
                  </div>
                  <!-- /.container -->
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