<?php require 'functions/connections.php'; ?>
<?php
require 'functions/email.php';
   //resumes the session for current user
   session_start();
   //users account authority status
if (isset($_SESSION['userID'])) {
   $admin = $_SESSION['admin'];

}

   ?>
<?php
 if (isset($_POST['submit'])) {
	  //allows emails to be sent in the background
 // don't let user kill the script by hitting the stop button
 ignore_user_abort(true);
 // don't let the script time out
 set_time_limit(0);
 // start output buffering
 ob_start();

	$name = $_POST['name'];
	$email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
	$to = "hedy2010@hotmail.co.uk";
	
	 $_SESSION['sendcontact'] = 'yes';
	 
	     // usleep(1500000); // do some stuff...
    header("Location: index");
    // now force PHP to output to the browser...
    $size = ob_get_length();
    header("Content-Length: $size");
    header('Connection: close');
    ob_end_flush();
    ob_flush();
    flush(); // yes, you need to call all 3 flushes!
    if (session_id()) session_write_close();
	 
	 
	//send email to the user
    send_email_contact($name,$subject,$message,$email,$to);

   
 }
?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <!-- individual contact us css -->
      <link rel="stylesheet" href="css/contactus.css" type="text/css"/>
	         <link rel="stylesheet" href="css/plugins/bootstrapselect/bootstrap-select.min.css">
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
               <h1>CONTACT US</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > CONTACT US</p>
            </div>
         </div>
         <!-- contact information-->
         <div class="container marketing">
            <div class="row">
               <div class="col-lg-4">
                  <span class="fa fa-phone fa-4x"></span>
                  <h5>CALL US AT</h5>
                  <p><br>07934996574</p>
               </div>
               <!-- /.col-lg-4 -->
               <div class="col-lg-4">
                  <span class="fa fa-map-marker fa-4x"></span>
                  <h5>OUR ADDRESS</h5>
                  <p><br>Eastbourne Morrisions<br>Lottbridge Drove<br>BN23 6QN</p>
               </div>
               <!-- /.col-lg-4 -->
               <div class="col-lg-4">
                  <span class="fa fa-clock-o fa-4x"></span>
                  <h5>WORKING HOURS</h5>
                  <p><br>OPEN 7 DAYS A WEEK<br>8am - 6pm</p>
               </div>
               <!-- /.col-lg-4 -->
            </div>
         </div>
		  <!-- FAQ section-->
         <div class="container">
            <div class="row">
				<!-- contact us form-->
               <div class="col-lg-6">
                  <h4 id="sectiontitle">Contact Us</h4>
                  <div class="contact-form-block">
                     <form id="contact-form" class="contact-form" method="post">
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Full Name">
                                 </div>
								  <!-- validation check appears here -->
                                 <span class="help-block" id="error"></span>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="E-Mail">
                                 </div>
								  <!-- validation check appears here -->
                                 <span class="help-block" id="error"></span>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                                <div class="input-group">
                                          <select class="selectpicker" name="subject" id="subject" title="Select Subject">
                                             <option value="General Enquiry">General Enquiry</option>
											  <option value="Feedback">Feedback</option>
                                             <option value="Complaint">Complaint</option>
                                             
                                          </select>
                                       </div>
							<!-- validation check appears here -->
                           <span class="help-block" id="error"></span>
                        </div>
                        <div class="form-group">
                           <div class="input-group">
                              <textarea id="message" name="message" rows="6" placeholder="Message" maxlength="600"></textarea>
                           </div>
							<!-- validation check appears here -->
                           <span class="help-block" id="error"></span>
							<!-- word limit counter-->
                           <div id="textarea_feedback"></div>
                        </div>
                        <button type="submit"  name="submit"  id="submit" class="btn btn-primary float-right">Send Message</button>
                     </form>
                  </div>
               </div>
				               <div class="col-lg-6">
                  <h4 id="sectiontitle">FAQ</h4>
                  <div id="accordion" class="accordion">
                     <div class="card m-b-0">
                        <div class="card-header"  href="#collapseOne">
                           <a class="card-title">
                           How much will it cost?
                           </a>
                        </div>
                        <div id="collapseOne" class="card-block">
                           <p>Prices are found on the main booking page and in the Services tab on the website.
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseTwo">
                           <a class="card-title">
                           What if I need to cancel or reschedule my booking?
                           </a>
                        </div>
                        <div id="collapseTwo" class="card-block">
                           <p>You are welcome to cancel or change your order up to 2 hours before the start of the booking window. Should you need to change the time of your booking or cancel the booking you may contact us on 07934996574. During the hours of operation we will be on hand to help facilitate any changes.
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseThree">
                           <a class="card-title">
                           Does Car Park Valeting provide Detailing Services?
                           </a>
                        </div>
                        <div id="collapseThree" class="card-block">
                           <p>Yes we do! In most cases, detailing will be a bespoke service so please drop us a line and we can discuss your requirements and quote accordingly.
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseFour">
                           <a class="card-title">
                           Do I need to be present?
                           </a>
                        </div>
                        <div id="collapseFour" class="card-block">
                           <p>No! You can leave the car with us, after it has been assesed
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseFive">
                           <a class="card-title">
                           What are the payment methods?
                           </a>
                        </div>
                        <div id="collapseFive" class="card-block">
                           <p>At the moment we only accept Cash payment.
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseSix">
                           <a class="card-title">
                           Who will valet the car and will they be any good?
                           </a>
                        </div>
                        <div id="collapseSix" class="card-block">
                           <p>All our staff are fully trained valeters using top of the range products.
                           </p>
                        </div>
                     </div>
                     <div class="card m-b-0">
                        <div class="card-header" href="#collapseSeven">
                           <a class="card-title">
                           Can I have a receipt so I can expense the wash.
                           </a>
                        </div>
                        <div id="collapseSeven" class="card-block">
                           <p>Yes, An invoice is automatically sent to you in a separate email after the completion of your car wash.
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
      <script>
         $(document).ready(function() {
            var text_max = 600;
            $('#textarea_feedback').html(text_max + ' characters remaining');
         
            $('#message').keyup(function() {
                var text_length = $('#message').val().length;
                var text_remaining = text_max - text_length;
         
                $('#textarea_feedback').html(text_remaining + ' characters remaining');
            });
         });
      </script>
   </body>
</html>