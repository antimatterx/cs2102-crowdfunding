<?php session_start(); ?>
<html>
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

// Connect to the SQL Server
$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());
?>

<?php session_start(); ?>
<?php $email = $_SESSION['email']; ?>

<!-- Change the status of expired projects to 'expired' -->
<?php 
$query = "SELECT p.id FROM project p WHERE p.expiry < CURRENT_DATE AND p.status='ongoing'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
  <?php foreach ($line as $proj_id) { ?>
    <?php $update = "UPDATE project SET status='closed' WHERE id='$proj_id'"; ?>
    <?php $update_res = pg_query($update) or die('Query failed: ' . pg_last_error()); ?>
   <?php } ?>
 <?php } ?>
<?php pg_free_result($result); ?>

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
      <?php $log_button = "Log Out"; ?>
      <?php $log_url = "logout.php"; ?>
      <?php $login_query = "SELECT p.firstname, p.lastname, p.admin FROM person p WHERE p.email='$email'"; ?>
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
      <?php } ?>
      <?php pg_free_result($name); ?> 
      <!-- End Set Admin/Profile Button and URL -->
    <?php } else { ?>
      <?php $log_button = "Log In"; ?>
      <?php $log_url = "login.php" ?>
      <?php $log_status_string = "You are not logged in" ?>
    <?php } ?>


      <ul class="nav navbar-nav navbar-right">
        <li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="register.php">Sign Up</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $log_url ?>"><?php echo $log_button ?></a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $host_url ?>">Host Project</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142">
          <a href="<?php echo $admin_url ?>"><?php echo $profile_button ?></a></li>
      </ul>
    </div>
  </div>
</nav>
<!--nav bar ends here-->




<!--user profile-->
<div class = "container">

<h1 style = "text-align:center;"> User Profile 
<span style="font-size: 50%;"><a href = "profile_edit.php" style = "text-align:center;">Edit Profile</a></span>
</h1>

<div class = "row">
<div class = "col-md-offset-3 col-md-6">
<?php
$query = "SELECT p.firstname, p.lastname, p.email, p.address, p.register_date, p.phone, p.admin FROM person p WHERE p.email = '$email'";
// echo "<p>".$query ."</p>";
$result = pg_query($query) or die ("query failed:" . pg_last_error());
$array = array();
while($row = pg_fetch_array($result,NULL, PGSQL_ASSOC)) {
	array_push($array, $row);
}

$query = "SELECT SUM(d.amount) AS total FROM donation d WHERE d.donor = '" .$email ."'";

$result = pg_query($query) or die ("query failed:" . pg_last_error());
$total = pg_fetch_array($result);
$total = $total['total'];

if (sizeof($array) > 0) {
	echo "<table class=\"table table-striped\">
    <colgroup>
        <col width=40%>
        <col width=60%>
    </colgroup>

	";

	foreach($array as $list) {
		echo "<tr><th><p>First Name</p></td>";
		echo "<td><p>" . $list["firstname"] . "</p></td></tr>";
		echo "<tr><th><p>Last Name</p></td>";
		echo "<td><p>" . $list["lastname"] . "</p></td></tr>";
		// echo "<tr><td><p>Password</p></td>";
		// echo "<td><p>" . $list["password"] . "</p></td></tr>";
		echo "<tr><th><p>Email</p></td>";
		echo "<td><p>" . $list["email"] . "</p></td></tr>";
		echo "<tr><th><p>Address</p></td>";
		echo "<td><p>" . $list["address"] . "</p></td></tr>";
		echo "<tr><th><p>Register Date</p></td>";
		echo "<td><p>" . $list["register_date"] . "</p></td></tr>";
		echo "<tr><th><p>Contact Number</p></td>";
		echo "<td><p>" . $list["phone"] . "</p></td></tr>";
		echo "<tr><th><p>Admin</p></td>";
		echo "<td><p>" . $list["admin"] . "</p></td></tr>";	
	}
	echo "<tr><th><p> Total Donation </p></td>";
	echo "<td><p>". $total. "</p></td></tr>";
	echo "</table>";
} else {
	echo "<p> There is no such user! </p>";
}
?>
</div>
</div>

<!--proposed project profile-->

<h1 style = "text-align:center;"> Projects Proposed </h1>
<?php
$query = "SELECT p.id, p.creator, p.title, p.description, p.start, p.expiry,p.country,p.target,p.status FROM project p WHERE p.creator = '" .$email."'";
// echo "<p>".$query ."</p>";
$result = pg_query($query) or die ("query failed:" . pg_last_error());
$array = array();
while($row = pg_fetch_array($result,NULL, PGSQL_ASSOC)) {
	array_push($array, $row);
}
if (sizeof($array) > 0) {
	
	foreach($array as $list) {
		echo "<table align = 'center' style = 'width:60%'>";
		echo "<tr><td><p>Project ID </p></td>";
		echo "<td><a href='dlist.php?id=" . $list["id"] . "'>" . $list['id'] . "</a></td>";
		// echo "<td><p>" . $list["id"] . "</p</td></tr>";
		echo "<tr><td><p>Project Title</p></td>";
		// echo "<td><p>" . $list["title"] . "</p></td></tr>";
		echo "<td><a href='dlist.php?id=" . $list["id"] . "'>" . $list['title'] . "</a></td>";
		echo "<tr><td><p>Project Creator</p></td>";
		echo "<td><p>" . $list["creator"] . "</p></td></tr>";
		echo "<tr><td><p>Project Description</p></td>";
		echo "<td><p>" . $list["description"] . "</p></td></tr>";
		echo "<tr><td><p> Starts Date</p></td>";
		echo "<td><p>" . $list["start"] . "</p></td></tr>";
		echo "<tr><td><p>expiry Date</p></td>";
		echo "<td><p>" . $list["expiry"] . "</p></td></tr>";	
		echo "<tr><td><p> Country </p></td>";
		echo "<td><p>" . $list["country"] . "</p></td></tr>";
		echo "<tr><td><p>Target Amount</p></td>";
		echo "<td><p>" . $list["target"] . "</p></td></tr>";	
		echo "<tr><td><p> Project Status</p></td>";
		echo "<td><p>" . $list["status"] . "</p></td></tr>";
		echo "</table><br>";
	}
} else { 
	echo "<p> There are no projects proposed </p> ";
	}
?>

<!--donated project profile-->

<h1 style = "text-align:center;"> Donated Projects </h1>
<?php
$query = "SELECT d.project, d.time, d.donor, d.amount FROM donation d WHERE d.donor = '" .$email."'";
// echo "<p>".$query ."</p>";
$result = pg_query($query) or die ("query failed:" . pg_last_error());
$array = array();
while($row = pg_fetch_array($result,NULL, PGSQL_ASSOC)) {
	array_push($array, $row);
}
if (sizeof($array) > 0) {

	foreach($array as $list) {
		echo "<table align = 'center' style = 'width:60%'>";
        echo "<tr><td><p>Project ID </p></td>";
		echo "<td><p>" . $list["project"] . "</p></td></tr>";
		echo "<tr><td><p>Donation Time </p></td>";
		echo "<td><p>" . $list["time"] . "</p></td></tr>";
		echo "<tr><td><p>Donor</p></td>";
		echo "<td><p>" . $list["donor"] . "</p></td></tr>";
		echo "<tr><td><p>Amount of Donation </p></td>";
		echo "<td><p>" . $list["amount"] . "</p></td></tr>";
		echo "</table><br>";
	}
		
} else { 
	echo "<p> There is no donation!</p> ";
	}
?>

	</div><!-- end #content-sidebar-wrap -->

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

