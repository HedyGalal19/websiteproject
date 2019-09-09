<header>

		<nav class="navbar navbar-expand-lg fixed-top navbar-dark  main-nav">
			<a class="navbar-brand" href="index"><img src="img/logo.png" width="210" height="60"></a>

			<!-- Mobile Menu Navigation -->
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class></span> <span class></span> <span class></span> </button>

			<div id="navbarNavDropdown" class="navbar-collapse collapse">
				<ul class="navbar-nav navbar-nav  mx-md-auto">
					<li class="nav-item">
						<a class="nav-link" href="index">HOME</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="booking">BOOKING</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="services">SERVICES</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="gallery">GALLERY</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contactus">CONTACT US</a>
					</li>

				</ul>
				<ul class="navbar-nav">
					
					<?php
					//admin value is set 0 i.e not an admin logged in
					if ($admin === 0 ) {
						echo '<li class="nav-item" id="booknow"> <a class="btn btn-success my-3 my-sm-0"  href="booking">Book Now</a> </li>';
						//show the customer menu
						echo '<div class="dropdown dropdown-pull-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="update_account.php">Update Account</a>
                        <a class="dropdown-item" href="logout">Sign Out</a>
                        </div>
                        </div>';
					} elseif ($admin === 1 ) { //else user logged in is admin
						//show admin menu
						echo '<li class="nav-item" id="booknow"> <a class="btn btn-success my-3 my-sm-0" href="booking">Book Now</a> </li>';
						echo '<div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="adminpanel/adminhome">Admin</a>
                        <a class="dropdown-item" href="logout">Sign Out</a>
                        </div>
                        </div>';
					}
					else {
						//no user is logged in show the login and register menu
						echo '<li class="nav-item"> <a class="nav-link" href="login">SIGN IN</a> </li>';
						echo '<li class="nav-item"> <a class="btn btn-success my-3 my-sm-0" href="register">Register</a> </li>';
					}
					?>
				</ul>
			</div>
		</nav>

</header>