<?php require 'functions/connections.php'; ?>
<?php
   //Resumes the session for current user
   session_start();
   //users account statues
   $admin = $_SESSION[ 'admin' ];
   ?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <!-- individual services css -->
      <link rel="stylesheet" href="css/privacy.css" type="text/css"/>
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
               <h1>TERMS and CONDITIONS</h1>
               <!-- breadcrumb navigation-->
               <p>HOME > TERMS &amp; CONDITIONS</p>
            </div>
         </div>
         <div class="container" id="terms">
            <div id="privacy">
               <h6>Booking</h6>
               <p>Bookings are deemed to be placed with Car Park Valeting portal. Bookings may also be made by calling the site phone and speaking to the supervisor. Payment is made using cash. Car Park Valeting reserves the right to cancel or restrict bookings subject to availability</p>
              
			   <h6>Pricing</h6>
               <p>All prices are listed on our service menu which can be found on the site. We reserve the right to change pricing without prior notice</p>
				
               <h6>Payment</h6>
               <ul>
				<li>You are required to make the payment for your car wash when you return to pick up your vehicle, at the price set out in our service menu.</li>
				<li>Any amount unpaid will result in us retaining your vehicle and not releasing it until you have made payment in full to us. Your vehicle will remain with us, at your risk, until any such late payment is received.</li>
			   </ul>
               
			   <h6>Liability</h6>
               <ul>
                  <li>We will perform the services selected by you from our service menu with all reasonable skill and care.</li>
                  <li>Whilst the Car Park Valeting shall take all reasonable steps to ensure that its servants or agents shall take reasonable care of the vehicle whilst in its custody (including without limitation where the vehicle is washed and cleaned), the company shall not be liable for:</li>
                  <li>Damage to, loss of the vehicle or any part of it, or any of its accessories or any of its content and/or</li>
                  <li>Customers are requested to deposit their valuables in a safe deposit box or other secure place prior to leaving the vehicle in the Car Park Valeting custody.</li>
               </ul>
				
               <h6>Car Size</h6>
               <p>The car size is determined by you when booking online, Car Park Valeting can change the car size and update the service charge before the service is carried out.</p>
				

				
            </div>
         </div>
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
   </body>
</html>