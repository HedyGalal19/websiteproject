<?php require 'functions/connections.php'; ?>
<?php
   //Resumes the session for current user
   session_start();
   //users account status
   $admin = $_SESSION[ 'admin' ];
   ?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <!-- individual services css -->
      <link rel="stylesheet" href="css/services.css" type="text/css"/>
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
               <h1>SERVICES &amp; PRICES</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > SERVICES &amp; PRICES</p>
            </div>
         </div>
         <!--  services -->
         <div id="services" class="services-main-block">
            <div class="container">
               <div class="section text-xs-center">
				   <!-- services title -->
                  <h3 class="section-heading">Our Services</h3>
				   <!-- description -->
                  <p class="sub-heading">Get 2 free Air fresheners &amp; Spray on Wax when booking online!</p>
               </div>
               <div class="row">
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-01.jpg" class="img-fluid" alt="service-01">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Vehicle Hand Wash</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-02.jpg" class="img-fluid" alt="service-02">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Headlight Lens Restoration</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-03.jpg" class="img-fluid" alt="service-03">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Scratch Removal</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-04.jpg" class="img-fluid" alt="service-04">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Tar Removal</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-05.jpg" class="img-fluid" alt="service-05">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Odour Elimination</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-06.jpg" class="img-fluid" alt="service-06">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Engine Cleaning</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-07.jpg" class="img-fluid" alt="service-07">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Hazardous Cleaning</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <div class="service-block text-xs-center">
                        <div class="service-icon">
							<!-- picture of service -->
                           <img src="img/service-08.jpg" class="img-fluid" alt="service-08">
                        </div>
                        <div class="service-dtl">
							<!-- service title-->
                           <h5 class="service-heading">Valet Service</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--  end services -->
         <div class="booknow">
            <div class="container">
               <div class="row">
                  <div class="col-md-6">
                     <h3 class="title">
                     NO 1. CAR WASH IN EASTBOURNE</h5>
                  </div>
                  <div class="col-md-6">
					  <!-- button takes user to the booking page -->
                     <a href="booking.php"><button href="booking" type="button" class="btn btn-secondary btn-lg">Book Appointment</button></a>
                  </div>
               </div>
            </div>
         </div>
         <!-- tabs to contain different services and prices we offer for car sizes -->
         <div id="pricing-plan-two" class="pricing-plan-main-block pricing-plan-two-main-block">
            <div class="container">
               <div class="section text-center">
				   <!-- page title -->
                  <h3 class="section-heading">Services</h3>
				   <!-- description -->
                  <p class="sub-heading">Select car size to view the pricing and service available</p>
               </div>
               <ul class="nav nav-tabs nav-justified" role="tablist">
                  <li role="presentation" class="nav-item">
                     <a class="nav-link active" href="#plan-1" aria-controls="plan-1" role="tab" data-toggle="tab"><span><i class="icon-7"></i></span>Small Car</a>
                  </li>
                  <li role="presentation" class="nav-item">
                     <a class="nav-link" href="#plan-2" aria-controls="plan-2" role="tab" data-toggle="tab"><span><i class="icon-1"></i></span>Medium Car</a>
                  </li>
                  <li role="presentation" class="nav-item">
                     <a class="nav-link" href="#plan-3" aria-controls="plan-3" role="tab" data-toggle="tab"><span><i class="icon-2"></i></span>Large Car</a>
                  </li>
               </ul>
               <!-- each tab panes contains information about services and pricing for car size -->
               <div class="tab-content">
				  <!-- Small Car Size Pricing -->
                  <div role="tabpanel" class="tab-pane active" id="plan-1">
                     <div class="row">
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior Wash</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£6.00</h2>
                                 <div class="pricing-duration">10 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Windows Outside</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior &amp; Interior Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£18.00</h2>
                                 <div class="pricing-duration">25 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Full Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£50.00</h2>
                                 <div class="pricing-duration">60 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Bodywork Polished</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Seats Washed &amp; Dried</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                    <li>Air Freshener</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Extra Services</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">Price Below</h2>
                                 <div class="pricing-duration">From 5 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Screenwash Top-up - <b>£3</b></li>
                                    <li>Extra Wax - <b>£5</b></li>
                                    <li>Paint Protection - <b>£40</b></li>
                                    <li>Odour Elimination - <b>£15</b></li>
                                    <li>Leather Seat Treatment - <b>£5 p/seat</b></li>
                                    <li>Fabric Hood Treatment - <b>£17</b></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
				   <!-- Medium Car Size Pricing -->
                  <div role="tabpanel" class="tab-pane" id="plan-2">
                     <div class="row">
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior Wash</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£8.00</h2>
                                 <div class="pricing-duration">15 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Windows Outside</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior &amp; Interior Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£23.00</h2>
                                 <div class="pricing-duration">30 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Full Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£60.00</h2>
                                 <div class="pricing-duration">70 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Bodywork Polished</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Seats Washed &amp; Dried</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                    <li>Air Freshener</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Extra Services</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">Price Below</h2>
                                 <div class="pricing-duration">From 5 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Screenwash Top-up - <b>£3</b></li>
                                    <li>Extra Wax - <b>£5</b></li>
                                    <li>Paint Protection - <b>£50</b></li>
                                    <li>Odour Elimination - <b>£15</b></li>
                                    <li>Leather Seat Treatment - <b>£5 p/seat</b></li>
                                    <li>Fabric Hood Treatment - <b>£17</b></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
				   <!-- Large Car Size Pricing -->
                  <div role="tabpanel" class="tab-pane" id="plan-3">
                     <div class="row">
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior Wash</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£10.00</h2>
                                 <div class="pricing-duration">20 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Windows Outside</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Exterior &amp; Interior Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£28.00</h2>
                                 <div class="pricing-duration">45 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Full Valet</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">£70.00</h2>
                                 <div class="pricing-duration">80 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Exterior Hand Wash</li>
                                    <li>Towel Hand Dry</li>
                                    <li>Wheel Shine</li>
                                    <li>Tire Dressing</li>
                                    <li>Window In &amp; Out</li>
                                    <li>Bodywork Polished</li>
                                    <li>Sealer Hand Wax</li>
                                    <li>Interior Vacuum</li>
                                    <li>Seats Washed &amp; Dried</li>
                                    <li>Door Shut’s &amp; Plastics</li>
                                    <li>Dashboard Clean</li>
                                    <li>Air Freshener</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                           <div class="pricing-block text-center">
                              <h6 class="pricing-heding">Extra Services</h6>
                              <div class="pricing-price-block">
                                 <h2 class="pricing-price">Price Below</h2>
                                 <div class="pricing-duration">From 5 Mins</div>
                              </div>
                              <div class="pricing-dtl">
                                 <ul>
                                    <li>Screenwash Top-up - <b>£3</b></li>
                                    <li>Extra Wax - <b>£5</b></li>
                                    <li>Paint Protection - <b>£60</b></li>
                                    <li>Odour Elimination - <b>£15</b></li>
                                    <li>Leather Seat Treatment - <b>£5 p/seat</b></li>
                                    <li>Fabric Hood Treatment - <b>£17</b></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		  <!-- Shows map of car wash location on button click -->
         <div id='location-canvas' style='width:100%;height:300px;'></div>
		  <!-- button to show the map -->
         <button id="showb" class="button" value="Show map">Show map</button>
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
   </body>
</html>