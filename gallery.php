<?php require 'functions/connections.php'; ?>
<?php
   //Resumes the session for current user
   session_start();
   //user account authority status
   $admin = $_SESSION[ 'admin' ];
   ?>
<!doctype html>
<html lang="en">
   <head>
      <!-- include head file -->
      <?php include 'includes/head.php'; ?>
      <!-- individual gallery css -->
      <link rel="stylesheet" href="css/gallery.css" type="text/css"/>
      <link rel="stylesheet" href="css/baguetteBox.css">
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
               <h1>GALLERY</h1>
				<!-- breadcrumb navigation-->
               <p>HOME > GALLERY</p>
            </div>
         </div>
         <!-- tabbed gallery -->
         <div class="container">
            <ul class="nav nav-tabs nav-justified" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" href="#all" role="tab" data-toggle="tab">Exterior Valeting</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#interior" role="tab" data-toggle="tab">Interior Valeting</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#beforeafter" role="tab" data-toggle="tab">Before and After</a>
               </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="all">
                  <div class="container gallery-container">
                     <div class="tz-gallery">
                        <div class="row">
                           <div class="col-sm-12 col-md-4">
                              <a class="lightbox" href="img/gallery1.jpg" data-caption="Paint Protection">
                              <img src="img/gallery1.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery2.jpg" data-caption="Hand Wash">
                              <img src="img/gallery2.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery3.jpg" data-caption="Clay Bar">
                              <img src="img/gallery3.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <a class="lightbox" href="img/gallery4.jpg" data-caption="Snow Foam">
                              <img src="img/gallery4.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery5.jpg" data-caption="Wheel Cleaning">
                              <img src="img/gallery5.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12 col-md-4">
                              <a class="lightbox" href="img/gallery6.jpg" data-caption="No scratches">
                              <img src="img/gallery6.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery7.jpg" data-caption="No Harsh Chemicals">
                              <img src="img/gallery7.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery8.jpg" data-caption="Polished and Protected">
                              <img src="img/gallery8.jpg">
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane fade" id="interior">
                  <div class="container gallery-container">
                     <div class="tz-gallery">
                        <div class="row">
                           <div class="col-sm-12 col-md-4">
                              <a class="lightbox" href="img/gallery9.jpg" data-caption="BMW Dust free">
                              <img src="img/gallery9.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery10.jpg" data-caption="Cleaned and Polished">
                              <img src="img/gallery10.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery11.jpg" data-caption="Dashboard deep cleaned">
                              <img src="img/gallery11.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12 col-md-4">
                              <a class="lightbox" href="img/gallery12.jpg" data-caption="GearBox area fully cleaned">
                              <img src="img/gallery12.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery13.jpg" data-caption="BMW inteior Cleaned">
                              <img src="img/gallery13.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery14.jpg" data-caption="Cleaned and polished windscreen">
                              <img src="img/gallery14.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12 col-md-4">
                              <a class="lightbox" href="img/gallery15.jpg" data-caption="Cluster glass cleaned">
                              <img src="img/gallery15.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery16.jpg" data-caption="Leather treatment">
                              <img src="img/gallery16.jpg">
                              </a>
                           </div>
                           <div class="col-sm-6 col-md-4">
                              <a class="lightbox" href="img/gallery17.jpg" data-caption="Leather Shine">
                              <img src="img/gallery17.jpg">
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane fade" id="beforeafter">
                  <div class="container gallery-container">
                     <div class="tz-gallery">
                        <div class="row">
                           <div class="col">
                              <a class="lightbox" href="img/gallery18.jpg" data-caption="Before Head Light Restoration">
                              <img src="img/gallery18.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery19.jpg" data-caption="After Head Light Restoration">
                              <img src="img/gallery19.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery20.jpg" data-caption="Before Wheel and tyre clean">
                              <img src="img/gallery20.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery21.jpg" data-caption="After Wheel and tyre clean">
                              <img src="img/gallery21.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <a class="lightbox" href="img/gallery22.jpg" data-caption="Before Engine cleaning">
                              <img src="img/gallery22.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery23.jpg" data-caption="After Engine cleaning">
                              <img src="img/gallery23.jpg">
                              </a>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <a class="lightbox" href="img/gallery24.jpg" data-caption="Before Carpert clean">
                              <img src="img/gallery24.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery25.jpg" data-caption="After Carpet clean">
                              <img src="img/gallery25.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery26.jpg" data-caption="Before driver carpet clean">
                              <img src="img/gallery26.jpg">
                              </a>
                           </div>
                           <div class="col">
                              <a class="lightbox" href="img/gallery27.jpg" data-caption="After driver carpet clean">
                              <img src="img/gallery27.jpg">
                              </a>
                           </div>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
      <script>
         baguetteBox.run( '.tz-gallery' );
      </script>
   </body>
</html>