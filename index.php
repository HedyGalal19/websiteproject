<?php require 'functions/connections.php'; ?>
<?php
   //Resumes the session for current user
   session_start();
   //users account status
   $admin = $_SESSION[ 'admin' ];

$sendcontact = '';
if(isset($_SESSION['sendcontact'])){
	$sendcontact = 'sent';
}

$booking = '';
if(isset($_SESSION['bookingdone'])){
	$booking = 'booked';
}

$passwordupdate = '';
if(isset($_SESSION['passwordupdate'])){
	$passwordupdate = 'updated';
}

$accountupdate = '';
if(isset($_SESSION['accountupdate'])){
	$accountupdate = 'accountupdated';
}

   ?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php require 'includes/head.php'; ?>
      <!-- individual homepage css -->
      <link rel="stylesheet" href="css/index.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu file -->
      <?php require 'includes/header.php'; ?>
      <main class="main">
         <!----------------------- Start Carousel slide show ---------------------->
         <div class="carousel slide" id="carousel" data-ride="carousel">
            <ol class="carousel-indicators">
               <li class="active" data-target="#carousel" data-slide-to="1"></li>
               <li data-target="#carousel" data-slide-to="2"></li>
               <li data-target="#carousel" data-slide-to="3"></li>
            </ol>
            <div class="carousel-caption">
               <h3>BOOK A CAR WASH NOW</h3>
               <p>Fully Insured - No Scratch - Trained Professionals</p>
		  	   <?php 
	   if($sendcontact == 'sent'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Thank you for contacting us - We will get back to you as soon as possible"
				</div>';}
	   unset($_SESSION['sendcontact']);
	   ?>
		<?php 
	   if($booking == 'booked'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Thank you for booking - A booking confirmation has been sent - Please check the details.
				</div>';}
	   unset($_SESSION['bookingdone']);
	   ?>
       <?php 
	   if($passwordupdate == 'updated'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Your Account Password Has been updated successfully.
				</div>';}
	   unset($_SESSION['passwordupdate']);
	   ?>
        <?php 
	   if($accountupdate == 'accountupdated'){
		   echo '<div class="alert alert-success alert dismissible fade show" role="alert">
		   	<button type="button" class="close" data-dismiss="alert" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				Your Account Details Has been updated successfully.
				</div>';}
	   unset($_SESSION['accountupdate']);
	   ?>
            </div>
            <div class="carousel-inner" role="listbox">
               <div class="carousel-item active" data-src="img/audi.jpg">
               </div>
               <div class="carousel-item" data-src="img/audi1.jpg">
               </div>
               <div class="carousel-item" data-src="img/audi2.jpg">
               </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
		  </div>
         <!----------------------- End Carousel slide show ---------------------->
         <div class="booknow">
            <div class="container">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="title">
                     NO 1. CAR WASH IN EASTBOURNE</h5>
                  </div>
                  <div class="col-md-6">
                     <a href="booking.php"><button href="booking.php" type="button" class="btn btn-secondary btn-lg">Book Appointment</button></a>
                  </div>
               </div>
            </div>
         </div>
         <!----------------------- Who we are ---------------------->
         <div id="who-we-are" class="who-we-are-main-block">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8">
                     <div class="section">
                        <h3 class="section-heading">Who We Are?</h3>
                        <p>
                           Car Park Valeting is an eco-friendly, hand car wash and detailing service based in Eastbourne. Our company was founded back in 2017 by a team of experts with more than 10 years of professional car wash experience. Our goal is to provide our customers with the friendliest, most convenient hand car wash experience possible. We use the most modern and up-to-date water reclamation modules as a part of our car wash systems. Our products are all biodegradable and eco-friendly.
                        </p>
                     </div>
                     <div class="row who-we-are-points">
                        <div class="col-md-6">
                           <div class="who-we-are-block">
                              <div class="who-we-are-icon"><span class="fa fa-car"></span>
                              </div>
                              <div class="who-we-are-dtl">
                                 <h5 class="who-we-are-heading">THE BEST CAR WASH</h5>
                                 <ul class="component-list">
                                    <li> <span class="fa fa-check"></span> We offer multiple services at a great value</li>
                                    <li> <span class="fa fa-check"></span> Biodegradable and eco-friendly products</li>
                                    <li> <span class="fa fa-check"></span> Book an appointment online under 5 minutes</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="who-we-are-block">
                              <div class="who-we-are-icon"> <span class="fa fa-comments-o"></span>
                              </div>
                              <div class="who-we-are-dtl">
                                 <h5 class="who-we-are-heading">CONTACTING US</h5>
                                 <ul class="component-list">
                                    <li> <span class="fa fa-check"></span> We are very open and easy to reach company</li>
                                    <li> <span class="fa fa-check"></span> Our email is checked hourly during the day</li>
                                    <li> <span class="fa fa-check"></span> Trained and skilled car wash crew members</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="who-we-are-img">
                        <img src="img/who-we-are.jpg" class="img-fluid" alt="who-we-are">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- services we offer section -->
         <div id="services" class="services-main-block">
            <div class="container">
               <div class="section text-center sc-content">
                  <h3 class="section-heading">Our Services</h3>
                  <p class="sub-heading">Get 2 FREE Air fresheners &amp; Spray on Wax when booking online</p>
               </div>
               <div class="row">
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-01.jpg" class="img-fluid" alt="service-01"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Vehicle Hand Wash</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-02.jpg" class="img-fluid" alt="service-02"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Headlight Lens Restoration</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-03.jpg" class="img-fluid" alt="service-03"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Scratch Removal</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-04.jpg" class="img-fluid" alt="service-04"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Tar Removal</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-05.jpg" class="img-fluid" alt="service-05"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Odour Elimination</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-06.jpg" class="img-fluid" alt="service-06"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Engine Cleaning</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-07.jpg" class="img-fluid" alt="service-07"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Hazardous Cleaning</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="service-block text-center">
                        <div class="service-icon"> <a href="services.php"><img src="img/service-08.jpg" class="img-fluid" alt="service-08"></a>
                        </div>
                        <div class="service-dtl">
                           <a href="services">
                              <h5 class="service-heading">Valet Service</h5>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end services -->
         <!-- three testimonials -->
         <div class="test">
         <div class="carousel slide" data-ride="carousel">
            <div class="parallax" style="background-image: url('img/testimonials-bg.jpg')">
               <h3>TESTIMONIALS</h3>
               <div class="carousel-inner text-center">
                  <div class="carousel-item active">
                     <div class="d-flex h-100 align-items-center justify-content-center">
                        <p>"Quick and easy to book and the car has been left in a fabulous condition. Absolutely spotless and smells lovely too. Will definitely recommend to family and friends and will use again!"<br><br>Rhi Bee<br>Customer since 2016</p>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="d-flex h-100 align-items-center justify-content-center">
                        <p>"Had a mini valet on my car today and it looks like new. Great job, friendly professional service and I highly recommend this company to everyone."<br><br>Kim Ridgway<br>Customer since 2017</p>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="d-flex h-100 align-items-center justify-content-center">
                        <p>"Had my car cleaned today after only contacting them yesterday night, very friendly and amazing job well done for a great price. Will definitely be using again."<br><br>Georgia Wilson<br>Customer since 2016</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end testimonials -->
		 <!-- show map of car wash location -->
         <div id='location-canvas' style='width:100%;height:300px;'></div>
		 <!-- button to the show map -->
         <button id="showb" class="button" value="Show map">Show map</button>
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
      <!-- script for carousel -->
      <script>
         $( function () {
         	'use strict';
         
         	$( '.carousel .carousel-item[data-src]' ).each( function () {
         		var $this = $( this );
         
         		$this.prepend( [
         			'<div style="background-image: url(', $this.attr( 'data-src' ), ')"></div>'
         		].join( '' ) );
         	} );
         } );
      </script>
   </body>
</html>