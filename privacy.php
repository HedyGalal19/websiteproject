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
               <h1>PRIVACY POLICY</h1>
               <!-- breadcrumb navigation-->
               <p>HOME > PRIVACY POLICY</p>
            </div>
         </div>
         <div class="container" id="terms">
            <div id="privacy">
               <h6>Introduction</h6>
               <p>This document will provide the necessary information needed for you have peace of mind when providing your details to Car Park Valeting. This privacy policy applies between you, the User of this Website and Car Park Valeting, the owner and provider of this Website. Car Park Valeting takes the privacy of your information very seriously. This privacy policy applies to our use of any and all Data collected by us or provided by you in relation to your use of the Website. You have assigned your trust in Car Park Valeting services and we respect the trust. Please read this privacy policy carefully.</p>
               <h6>Scope of this privacy policy</h6>
               <p>This privacy policy applies only to the actions of Car Park Valeting and Users with respect to this Website.  It does not extend to any websites that can be accessed from this Website including, but not limited to, any links we may provide to social media websites.</p>
               <h6>What types of information collected by Car Park Valeting?</h6>
               <p>We collect the personal Information you give to us, this include the basic details - Full Name, Email, Telephone Number, Email address. </p>
               <h6>Why does Car Park Valeting collect and use your personal data?</h6>
               <ul>
                  <li>For purposes of the Data Protection Act 1998, Car Park Valeting is the "data controller".</li>
                  <li>Unless we are obliged or permitted by law to do so, and subject to any third party disclosures specifically set out in this policy, your Data will not be disclosed to third parties. This includes our affiliates and / or other companies within our group.</li>
                  <li>All personal Data is stored securely in accordance with the principles of the Data Protection Act 1998. </li>
                  <li>Any or all of the above Data may be required by us from time to time in order to provide you with the best possible service and experience when using our Website.  Specifically, Data may be used by us for the following reasons:</li>
                  <ul id="lastul">
                     <li>Internal record keeping</li>
                     <li>Transmission by email of promotional material that may be of interest to you</li>
                     <li>Contact for market research purpose which may be done using email, telephone or mail such information may be used to customise or update the website.  </li>
                  </ul>
               </ul>
               <h6>Links to other websites</h6>
               <p>This Website may, from time to time, provide links to other websites.  We have no control over such websites and are not responsible for the content of these websites.  This privacy policy does not extend to your use of such websites.  You are advised to read the privacy policy or statement of other websites prior to using them. </p>
               <h6>What security and retention procedures does Car Park Valeting put in place to safeguard your personal data?</h6>
               <p>In agreement with European data protection law, we abide reasonable procedures to avoid unauthorised access and misuse of your details. We use convenient business system and steps to safeguard your personal information. In addition we use security steps to ensure the personal information is kept safe and secure on the server.</p>
               <ul>
                  <li>If password access is required for certain parts of the Website, you are responsible for keeping this password confidential.</li>
                  <li>We endeavour to do our best to protect your personal Data.  However, transmission of information over the internet is not entirely secure and is done at your own risk.  We cannot ensure the security of your Data transmitted to the Website.</li>
               </ul>
               <h6>How can you control personal data you have given to Car Park Valeting?</h6>
               <p>You have the rights to view the information we have for you. You can also ask for a summary of the personal information we have for you by contacting us to the email address in the about us section. In addition you may also contact us if you think that the information we have is incorrect or believe that we should no longer store your details.</p>
               <h6>Changes to this privacy policy</h6>
               <p>Car Park Valeting reserves the right to change this privacy policy as we may deem necessary from time to time or as may be required by law.  Any changes will be immediately posted on the Website and you are deemed to have accepted the terms of the privacy policy on your first use of the Website following the alterations.
                  You may contact Car Park Valeting by email.
               </p>
            </div>
         </div>
      </main>
      <!-- footer -->
      <?php include 'includes/footer.php'; ?>
      <!-- scripts and functions -->
      <?php include 'includes/script.php'; ?>
   </body>
</html>