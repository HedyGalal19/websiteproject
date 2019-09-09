<?php require '../functions/connections.php'; ?>
<?php
// Resumes the session for current user
session_start();
// Boolean of user being admin or not
// $admin = $_SESSION[ 'Admin' ];
// Check if UserID is set indicating if user is logged in
if (isset($_SESSION["userID"])) {
 // Checks if user is logged in
 if ($_SESSION["admin"] === 0) {
  // Redirect to home page as user is not admin
  header("Location: ../index");
 }
}
else {
 // redirect to Login Page as user has not logged in
 header("Location: ../login");
}
?>
<?php
//show last 5 registerd customers and put into table
function customers()
{
 $sessionuserID = $_SESSION["userID"];
 // Connect to the database
 $mysqli = new mysqli("mysql.hostinger.co.uk", "u700784489_cpv", "316118", "u700784489_cpvd");
 // output any connection error
 if ($mysqli->connect_error) {
  die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
 }
 // WHERE appdone='0'
 // the query
 $query = "select * from Users WHERE userID != $sessionuserID ORDER BY regdate DESC LIMIT 5";
 // mysqli select query
 $results = $mysqli->query($query);
 if ($results) {
  while ($row = $results->fetch_assoc()) {
   $userID = $row["userID"];
   $reg = $row["reg"];
   $firstName = $row["fname"];
   $regdate = $row["regdate"];
   $status = $row["com_code"];
   print '
                         <tr>
                          <td id="reg">' . $reg . '</td>
                             <td>' . $firstName . '</td>
                             <td>' . $regdate . '</td>
                     ';
   if ($status == NULL) {
    print '
                       
                          
                  <td style="color:green;">Active</td>
                         
                     ';
   }
   else {
    print '      
                  <td style="color:red;">Unactive</td>       
                     ';
   }
   print '
                      
                      
                  				    <td><form method="GET" action="admin_edit.php">
   																
      			<button type="submit"  id="submit" name="edi" value="' . $userID . '" class="btn btn-primary btn-xs customer-select">View</button>
              </form></td>
                         
                     ';
  }
 }
 // Frees the memory associated with a result
 $results->free();
 // close connection
 $mysqli->close();
}
?>
<?php
// get the number of rows in database to display number of customers
$q = "select SUM(totalPrice) from Appointment WHERE appdone = '1'";
$result = mysqli_query($con, $q);
$data = mysqli_fetch_array($result);
$totalSum = $data[0];
?>
<?php
// get the number of rows in database to display number of customers
$query = "SELECT * FROM Users";
if ($stmt = $con->prepare($query)) {
 /* execute query */
 $stmt->execute();
 /* store result */
 $stmt->store_result();
 $num = $stmt->num_rows;
 /* close statement */
 $stmt->close();
}
?>
<?php
// get the number of appointments for today
$query = "SELECT * FROM Appointment WHERE date IN (CURRENT_DATE )";
if ($stmt = $con->prepare($query)) {
 /* execute query */
 $stmt->execute();
 /* store result */
 $stmt->store_result();
 $totalBooking = $stmt->num_rows;
 /* close statement */
 $stmt->close();
}
?>
<?php
//fetch the time stamps for the all users to be displayed in bar graph
$sql = "SELECT
          DATE_FORMAT(regdate,'%M %Y') AS `date`,
          COUNT(`Users`.`userID`) AS `count`
      FROM `Users`
      GROUP BY YEAR(`regdate`), MONTH(`regdate`) ASC";
$run = mysqli_query($con, $sql); //here run the sql query.
$date = array();
$count = array();
while ($row = mysqli_fetch_array($run)) {
 $date[] = $row['date'];
 $count[] = $row['count'];
}
?>
<?php
// fetch total number of booking for each month
$sql1 = "SELECT
          DATE_FORMAT(date,'%M %Y') AS `bookingdate`,
          COUNT(`Appointment`.`appID`) AS `totalcount`
      FROM `Appointment` WHERE appdone = '1'
      GROUP BY YEAR(`date`), MONTH(`date`) ASC";
$run = mysqli_query($con, $sql1); //here run the sql query.
$bookingdate = array();
$totalcount = array();
while ($row = mysqli_fetch_array($run)) {
 $bookingdate[] = $row['bookingdate'];
 $totalcount[] = $row['totalcount'];
}
?>
<?php
// fetch the total booking revenue for each month
$sql2 = "SELECT
          DATE_FORMAT(date,'%M %Y') AS `bookingdate1`,
          SUM(`Appointment`.`totalPrice`) AS `total`
      FROM `Appointment` WHERE appdone = '1'
      GROUP BY YEAR(`date`), MONTH(`date`) ASC";
$run = mysqli_query($con, $sql2); //here run the sql query.
$bookingdate1 = array();
$total = array();
while ($row = mysqli_fetch_array($run)) {
 $bookingdate1[] = $row['bookingdate1'];
 $total[] = $row['total'];
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- include page head file-->
      <?php include 'includes/head.php'; ?>
	   <!-- individual admin dashboard css -->
      <link rel="stylesheet" href="../css/admindashboard.css" type="text/css"/>
   </head>
   <body>
      <!-- include navigation menu-->
      <?php include 'includes/navigation.php'; ?>
      <div class="content-inner">
         <!-- page title-->
         <header class="page-header">
            <div class="container-fluid">
               <h2 class="no-margin-bottom">Data Analytics</h2>
            </div>
         </header>
         <!-- Dashboard Counts Section-->
         <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
               <div class="row bg-white has-shadow">
                  <!-- total clients -->
                  <div class="col-xl-4 col-sm-6">
                     <div class="item d-flex align-items-center">
                        <div class="icon bg-violet"><i class="fa fa-users"></i>
                        </div>
                        <div class="title"><span>Total<br>Clients</span>
                        </div>
                        <div class="number">
                           <strong>
                           <?php echo $num;?>
                           </strong>
                        </div>
                     </div>
                  </div>
                  <!-- total booking today -->
                  <div class="col-xl-4 col-sm-6">
                     <div class="item d-flex align-items-center">
                        <div class="icon bg-red"><i class="fa fa-padnote"></i>
                        </div>
                        <div class="title"><span>Booking<br>Today</span>
                        </div>
                        <div class="number">
                           <strong>
                           <?php echo $totalBooking; ?>
                           </strong>
                        </div>
                     </div>
                  </div>
                  <!-- total revenue to date -->
                  <div class="col-xl-4 col-sm-6">
                     <div class="item d-flex align-items-center">
                        <div class="icon bg-green"><i class="icon-bill"></i>
                        </div>
                        <div class="title"><span>Total<br>Revenue</span>
                        </div>
                        <div class="number"><strong>£ <?php echo $totalSum;?></strong>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- total regitered user by month -->
         <div class="row">
            <div class="col-lg-6">
               <section class="dashboard-counts no-padding-bottom">
                  <div class="container-fluid">
                     <div class="row bg-white has-shadow" id="graph">
                        <div class="panel-body table-responsive">
                           <div id="userregistration"></div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
			 <!-- last 5 registered users-->
            <div class="col-lg-6">
               <section class="dashboard-counts no-padding-bottom">
                  <div class="container-fluid">
                     <div class="row bg-white has-shadow" id="customers">
                        <p id="customertitle">Last 5 Registered Users</p>
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered dt-responsive nowrap cellspacing='0' width='100%'" id="customer">
                              <thead>
                                 <tr>
                                    <th>Car Reg</th>
                                    <th>First Name</th>
                                    <th>Register Date</th>
                                    <th>Status</th>
                                    <th>View</th>
                                 </tr>
                              </thead>
                              <?php customers(); ?>
                           </table>
                        </div>
                        <!----------------------- End Table ---------------------->
                     </div>
                  </div>
               </section>
            </div>
         </div>
		  <!-- total revenue by month-->
         <div class="row">
            <div class="col-lg-6">
               <section class="dashboard-counts no-padding-bottom">
                  <div class="container-fluid">
                     <div class="row bg-white has-shadow" id="graphtotal">
                        <div class="panel-body table-responsive">
                           <div id="revenue"></div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
			 <!-- total completed booking by month graph-->
            <div class="col-lg-6">
               <section class="dashboard-counts no-padding-bottom">
                  <div class="container-fluid">
                     <div class="row bg-white has-shadow" id="graphbooking">
                        <div class="panel-body table-responsive">
                           <div id="totalbooking"></div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
         </div>
         <!-- Page Footer-->
         <?php include 'includes/footer.php'; ?>
      </div>
      </div>
      </div>
      <!-- Javascript files-->
      <?php include 'includes/adminscripts.php'; ?>
      <script>
         $( function () {
         	$( '#userregistration' ).highcharts( {
         		chart: {
         			type: 'column'
         		},
         		title: {
         			text: 'User Registrations by Month'
         		},
         		xAxis: {
         			categories: [ '<?php echo join($date, "', '") ?>' ],
         			crosshair: true,
         			title: {
         				text: 'Month and Year'
         			}
         		},
         		yAxis: {
         			min: 0,
         			title: {
         				text: 'New Users (number of)'
         			}
         		},
         		tooltip: {
         			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
         			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         				'<td style="padding:0"><b>{point.y:f}</b></td></tr>',
         			footerFormat: '</table>',
         			shared: true,
         			useHTML: true
         		},
         		plotOptions: {
         			column: {
         				dataLabels: {
         					enabled: true,
         					crop: false,
         					overflow: 'none'
         				}
         				//         				pointPadding: 0,
         				//         				borderWidth: 0
         			}
         		},
         		series: [ {
         			name: 'Registrations',
         			data: [ <?php echo join($count, ', ') ?> ]
         		} ]
         	} );
         } );
      </script>
      <script>
         $( function () {
         	$( '#revenue' ).highcharts( {
         		chart: {
         			type: 'column'
         		},
         		title: {
         			text: 'Completed Booking Revenue by Month'
         		},
         		xAxis: {
         			categories: [ '<?php echo join($bookingdate1, "', '") ?>' ],
         			crosshair: true,
         			title: {
         				text: 'Month and Year'
         			}
         		},
         		yAxis: {
         			min: 0,
         			title: {
         				text: 'Total Revenue (£)'
         			}
         		},
         		tooltip: {
         			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
         			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         				'<td style="padding:0"><b>{point.y:f}</b></td></tr>',
         			footerFormat: '</table>',
         			shared: true,
         			useHTML: true
         		},
         		plotOptions: {
         			column: {
         				dataLabels: {
         					enabled: true,
         					crop: false,
         					overflow: 'none'
         				}
         				//         				pointPadding: 0,
         				//         				borderWidth: 0
         			}
         		},
         		series: [ {
         			name: 'SUM',
         			data: [ <?php echo join($total, ', ') ?> ]
         		} ]
         	} );
         } );
      </script>
      <script>
         $( function () {
         	$( '#totalbooking' ).highcharts( {
         		chart: {
         			type: 'column'
         		},
         		title: {
         			text: 'Total Completed Booking by Month'
         		},
         		xAxis: {
         			categories: [ '<?php echo join($bookingdate, "', '") ?>' ],
         			crosshair: true,
         			title: {
         				text: 'Month and Year'
         			}
         		},
         		yAxis: {
         			min: 0,
         			title: {
         				text: 'Total Appointments (number of)'
         			}
         		},
         		tooltip: {
         			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
         			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
         				'<td style="padding:0"><b>{point.y:f}</b></td></tr>',
         			footerFormat: '</table>',
         			shared: true,
         			useHTML: true
         		},
         		plotOptions: {
         			column: {
         				dataLabels: {
         					enabled: true,
         					crop: false,
         					overflow: 'none'
         				}
         				//         				pointPadding: 0,
         				//         				borderWidth: 0
         			}
         		},
         		series: [ {
         			name: 'Total',
         			data: [ <?php echo join($totalcount, ', ') ?> ]
         		} ]
         	} );
         } );
      </script>
      <script>
         $( function () {
         	$( '.deletebutton' ).click( function ( e ) {
         		e.preventDefault();
         		var tthis = $( this );
         		swal( {
         			title: "Are you sure?",
         			text: $( this ).data( 'title' ),
         			type: $( this ).data( 'type' ),
         			showCancelButton: true,
         			confirmButtonText: "Delete",
         			cancelButtonText: "Cancel",
         		}, function ( isConfirm ) {
         			if ( isConfirm ) {
         				document.location.href = tthis.attr( 'href' );
         			}
         		} );
         	} );
         } );
      </script>
   </body>
</html>