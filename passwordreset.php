<?php require 'functions/connections.php'; ?>
<?php
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );
   //Resumes the session for current user
   session_start();
   //UserID is set so if user is logged in
   if ( isset( $_SESSION[ "userID" ] ) ) {
	   header( 'Location: login' );
   } elseif ( isset( $_GET[ 'passkey' ] ) ) {
			$forgotpassword = $_GET[ 'passkey' ];
		   //if update button is clicked
		   if ( isset( $_POST[ 'update' ] ) ) {
			//Prepare and bind
			$stmt2 = $con->prepare( "UPDATE Users SET password = ? WHERE forgotpassword ='$forgotpassword'" );
			$stmt2->bind_param( "s", $storepassword );
			$newpassword = $_POST[ 'newpassword' ];
			$storepassword = password_hash( $newpassword, PASSWORD_BCRYPT, array( 'cost' => 10 ) );
			$stmt2->execute();
			$stmt2->close();

				echo '<script>
				setTimeout(function() {
				swal({
					title: "Password Reset",
					text: "Password Updated Successfully! - Please Log In",
					type: "success",
					  focusConfirm: false,
					confirmButtonText:"Login",
				}, function() {
					window.location = "login.php";
				});
			}, 100);
		   </script>'; 

			  }
		}else{
	   header( 'Location: login.php' );
   }
   
   ?>
<!doctype html>
<html lang="en">
   <head>
		<!-- include the head file-->
      <?php include 'includes/head.php'; ?>
      <link rel="stylesheet" href="css/updatePassword.css" type="text/css"/>

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
               <h1>PASSWORD RESET</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > PASSWORD RESET</p>
            </div>
         </div>
         <hr class="featurette-divider">
         <div class="container">
            <!----------------------- Start Form ---------------------->
            <div class="signup-form-container">
               <!-- form start -->
               <form method="post" role="form" name="resetpassword-form" id="resetpassword-form" autocomplete="off">
                  <div class="form-header">
                     <h3 class="form-title"><i class="fa fa-lock"></i> Change Password</h3>
                     <div class="pull-right">
                        <h3 class="form-title"><span class="fa fa-pencil"></span></h3>
                     </div>
                  </div>
                  <div class="form-body">
                     <!-- Field one for current Password -->
                     <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="newpassword" type="password" class="form-control" id="newpassword" value="" placeholder="New Password">
                        </div>
                        <span class="help-block" id="error"></span>
                     </div>
                     <!-- Field two for New Password -->
                     <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-addon"><span class="fa fa-lock"></span>
                           </div>
                           <input name="retypenewpassword" type="password" class="form-control" id="retypenewpassword" value="" placeholder="Retype New Password">
                        </div>
                        <span class="help-block" id="error"></span>
                     </div>
                  </div>
                  <!-- Update Button -->
                  <div class="form-footer">
                     <button type="submit" name="update" id="update" class="btn btn-info">
                     <span class="fa fa-sign-in"></span> Update Password
                     </button>
                  </div>
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