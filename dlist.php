<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Uptown Fund &raquo; Your One-Stop Crowdfunding Hub</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
<script src="js/jquery-2.2.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>

<!--footer files-->
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel = "stylesheet" type = "text/css" href = "css/footer_JH.css">

<!--own css, js links-->
<link rel = "stylesheet" type = "text/css" href = "css/bodypadding.css">
<link rel = "stylesheet" type = "text/css" href = "css/style_JH.css">

<?php
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());
?>


<script type="text/javascript">
  jQuery(window).scroll(function (event) {
	  	
		var top = jQuery('#popular-upcoming').offset().top - jQuery(document).scrollTop();;
		// what the y position of the scroll is
		var y = jQuery(this).scrollTop();
		// whether that's below the form
		if (y >= top)  {
		// if so, add the active class to popular-upcoming and remove from content
		jQuery('.page-nav-popular-posts').addClass('active');
		jQuery('.page-nav-top-posts').removeClass('active');
		} else {
		// otherwise remove it
		jQuery('.page-nav-popular-posts').removeClass('active');
		jQuery('.page-nav-top-posts').addClass('active');
	   }
  });
  
	  </script>
</head>

<body>
<div id = "homelinkhere"></div>

<div id="paddingstart"></div>

<!--nav bar strat here-->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">

    <!--logo img starts here-->    
    <div class="navbar-header" >
     <!--  <a class="navbar-brand">Project name</a> -->
     <a><img src="images/logo.png" height="40px" /></a>                                                                                                                       
    </div>
   <!--logo img ends here-->      

   <!--nav content strats here -->
    <div id="navbar" class="navbar-collapse collapse">
    <!--nav bar left side content starts here-->          
    <ul class="nav navbar-nav">
        <li class="page-nav-top-posts active"><a href="index.php" id="feature-scroll" class="page-anchor-link">Home</a></li>

        <li class="page-nav-popular-posts"><a href="index.php#popular-upcoming" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

        <li class="page-nav-top-posts active"><a href="index.php#categories" id="feature-scroll" class="page-anchor-link">Categories</a></li>

        <li class="page-nav-popular-posts"><a href="index.php#countries" id="popular-scroll" class="page-anchor-link">Countries</a></li>

        <li class="page-nav-top-posts active"><a href="search.php" id="feature-scroll" class="page-anchor-link">Search</a></li>
    </ul>
    <!--nav bar left side content ends here-->

      <!-- Check if Logged in -->
      <?php 
      if (!isset($_SESSION['email'])) {
        $host_url = "login.php";
        $admin_url = "login.php";
      } else {
        $host_url = "new_project.php";
        $admin_url = "profile.php";
      }
      ?>

      <!-- Display Login name -->
    <?php if (isset($_SESSION['email'])) { ?>
      <?php $is_admin = $_SESSION['email']; ?>
      <?php $log_button = "Log Out"; ?>
      <?php $log_url = "logout.php"; ?>
      <?php $login_query = "SELECT p.firstname, p.lastname, p.admin FROM person p WHERE p.email='$is_admin'"; ?>
      <?php $name = pg_query($login_query) or die('Query failed: ' . pg_last_error()); ?>
      <?php $firstname = pg_fetch_result($name, 0, 0); ?>
      <?php $lastname = pg_fetch_result($name, 0, 1); ?>
      <?php $is_admin = pg_fetch_result($name, 0, 2); ?>
      <?php $log_status_string = "You are logged in as " . $firstname . "."; ?>

      <!-- Set Admin/Profile Button and URL -->
      <?php if($is_admin=='Y') { ?>
        <?php $profile_button = "Admin"; ?>
        <?php $profile_url = "admin.php"; ?>
      <?php } else { ?>
        <?php $profile_button = "Profile Page"; ?>
        <?php $profile_url = "profile.php"; ?>
      <?php } ?>
      <?php pg_free_result($name); ?> 
      <!-- End Set Admin/Profile Button and URL -->
    <?php } else { ?>
      <?php $log_button = "Log In"; ?>
      <?php $log_url = "login.php" ?>
      <?php $log_status_string = "You are not logged in" ?>
      <?php $profile_button = "Profile Page"; ?>
      <?php $profile_url = "login.php"; ?>
    <?php } ?>


      <ul class="nav navbar-nav navbar-right">
        <li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="register.php">Sign Up</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $log_url ?>"><?php echo $log_button ?></a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $host_url ?>">Host Project</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $profile_url ?>"><?php echo $profile_button ?></a></li>
      </ul>
    </div>
  </div>
</nav>
<!--nav bar ends here-->
	    <div class = "container">
						
				<!-- INSERT CONTENT HERE -->		
				<?php
					if (isset($_GET['id'])) {
						$ID = $_GET['id'];

						$sql = "SELECT p.title, 
						c.firstname, 
						c.lastname, 
						d.amount, 
						to_char(d.time, 'DD/MM/YYYY') AS ddate,
						to_char(d.time, 'HH24:MI:SS') AS dtime
						FROM project p, donation d, person c 
						WHERE d.project = p.id 
						AND c.email = d.donor
						AND p.id = " . $ID ."
						GROUP BY p.title, c.firstname, c.lastname, d.amount, d.time
						ORDER BY d.time DESC";

						// echo "<h1>" . $sql . "</h1>";
						$result = pg_query($sql) or die("Query failed: " . pg_last_error());

						$array = array();

						while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
							array_push($array, $line);
						}

						$sql = "SELECT p.title FROM project p WHERE p.id = " . $ID;

						$result = pg_query($sql) or die("Query failed: " . pg_last_error());

						$title = pg_fetch_array($result);
						$title = $title['title'];

						if ($title == "") {
							echo "<h2 style = 'text-align:center' >Project does not exist " . $title . "</h2>";
						} else {
							$sql = "SELECT SUM(d.amount) AS total FROM donation d WHERE d.project = " . $ID;

							$result = pg_query($sql) or die("Query failed: " . pg_last_error());

							$total = pg_fetch_array($result, NULL, PGSQL_ASSOC);
							$total = $total['total'];
							if ($total == "") {
								$total = 0;
							}

							$sql = "SELECT p.target FROM project p WHERE p.id = " . $ID;

							$result = pg_query($sql) or die("Query failed: " . pg_last_error());

							$target = pg_fetch_array($result, NULL, PGSQL_ASSOC);
							$target = $target['target'];

							$reached = 100.0 * $total / $target;
							$reached = number_format($reached, 2, ".", "");
							
							echo "<h2 style = 'text-align:center' > Funding Statistics for " . $title . "</h2>";
							echo "<table align='center'class = 'table table-striped'>";
							echo "<tr>";
							echo "<th><p> Donations Received </p></th>";
							echo "<th><p> Target Amount </p></th>";
							echo "<th><p> Percentage of Target reached </p></th>";
							echo "</tr>";
							echo "<tr>";
							echo "<td><p> US$" . $total . ".00 </p></td>";
							echo "<td><p> US$" . $target . ".00 </p></td>";
							echo "<td><p> " . $reached . "% </p></td>";
							echo "</tr>";
							echo "</table>";							

							echo "<h2 style = 'text-align:center' >List of donations </h2>";
						}
						if (sizeof($array) > 0) {
							echo "<table align='center' class = 'table table-striped'>";
							echo "<tr>";
							echo"<td><p><b> Donor </b></p></td>";
							echo"<td><p><b> Amount </b></p></td>";
							echo"<td><p><b> Date </b></p></td>";
							echo"<td><p><b> Time </b></p></td>";
							echo "</tr>";
							foreach($array as $row) {
								echo "<tr>";
								echo"<td><p>" . $row['firstname'] . " " . $row['lastname'] . "</p></td>";
								echo"<td><p> US$" . $row['amount'] . ".00 </p></td>";
								echo"<td><p>" . $row['ddate'] . "</p></td>";
								echo"<td><p>" . $row['dtime'] . "</p></td>";
								echo "</tr>";					
							}
							echo "</table>";

						} else {
							if ($title != "") {
								echo "<p align = 'center'> No donors for this project </p><br>";
							}
						}
					}
				?>
	    </div><!-- end container --> 

<!--start of footer-->
<footer>
    <div class="footer" id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-6">
                    <h3> Company </h3>
                    <ul>
                      <li><a href="#">About</a></li>
                      <li><a href="#">Jobs</a></li>
                      <li><a href="#">Contact</a></li>
                      <li><a href="#">Terms</a></li>
                      <li><a href="#">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-6">
                    <h3> Community</h3>
                    <ul>
                      <li><a href="#">Blog</a></li>
                      <li><a href="#">Twitter</a></li>
                      <li><a href="#">Facebook</a></li>
                      <li><a href="#">Help</a></li>
                    </ul>
                </div>

                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-6">
                  <h3> Career</h3>
                  <ul>
                    <li><a href="#">Why Join us</a></li>
                    <li><a href="#">What do we offer</a></li>
                    <li><a href="#">Internship</a></li>
                    <li><a href="#">More information</a></li>
                  </ul>
                </div>

                <div class=" col-lg-3  col-md-3 col-sm-6 col-xs-6 ">
                    <h3> Subscribe </h3>
                    <ul>
                        <li>
                          Get the latest news in your inbox
                        </li>
                        <li>
                            <div class="input-append newsletter-box text-center">
                                <input type="text" class="full text-center" placeholder="Email ">
                                <button class="btn  bg-gray" type="button"> Subscribe to the newsletter </button>
                            </div>
                        </li>
                        <li>
                          Opt-out anytime with one click and we'll never share your information.
                        </li>
                    </ul>

                </div>
            </div>
            <!--/.row--> 
        </div>
        <!--/.container--> 
    </div>
    <!--/.footer-->
    
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left"> Copyright © Uptown Fund Pre Ltd. All right reserved. </p>
        </div>
    </div>
    <!--/.footer-bottom--> 
</footer>
<!--end of footer-->
</body>
</html>