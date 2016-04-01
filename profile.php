<html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<style>
table,th,td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 2px;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Uptown Fund &raquo; Your One-Stop Crowdfunding Hub</title>
<link rel="stylesheet" id="child-theme-css" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" id="responsive-main-css-css" href="css/responsive-main.min.css" type="text/css" media="all" />
<link rel="stylesheet" id="responsive-css-css" href="css/responsive.css" type="text/css" media="all" />
<link rel="stylesheet" id="tb_styles-css" href="css/tb-styles.min.css" type="text/css" media="all" />

<?php
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());
?>

<?php session_start(); ?>
<?php $email = $_SESSION['email']; ?>

<script type="text/javascript" src="js/jquery.js"></script>

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
  
  jQuery(document).ready(function (){
  jQuery('#popular-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#popular-upcoming').offset().top
                     }, 2000);
            //});
        });
		
		jQuery('#feature-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#inner').offset().top
                     }, 2000);
            //});
        });
		  });
	  </script>
</head>

<body class="home blog header-full-width full-width-content">
  <div id="header">
  <div class="site-header">
    <h1 class="site-header-logo-container">
    <a>Logo</span>
    <img src="images/logo.png" width="100%" id="bigg-logo" alt="Bigg" /></a>
    </h1>
      
            <ul id="page-nav" class="horizontal-list">
<li class="page-nav-top-posts active"><a href="javascript:void(0)" id="feature-scroll" class="page-anchor-link">Home</a></li>

<li class="page-nav-popular-posts"><a href="javascript:void(0)" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

<li class="page-nav-top-posts active"><a href="index.php#categories" id="feature-scroll" class="page-anchor-link">Categories</a></li>

<li class="page-nav-popular-posts"><a href="index.php#countries" id="popular-scroll" class="page-anchor-link">Countries</a></li>

<li class="page-nav-top-posts active"><a href="index.php#categories" id="feature-scroll" class="page-anchor-link">Search</a></li>
</ul>

<div id="site-nav" class="horizontal-list"><div class="menu-main-menu-container">
	<ul id="menu-main-menu" class="menu">
		<li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="/">Sign Up</a></li>
		<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="sample-page.htm">Log In</a></li>
		<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="sample-page.htm">Host Project</a></li>
	</ul></div></div><!-- #site-nav -->
<div id="site-header-bigg-social">
    
    </div>  
    </div>
  </div>
  <div id="wrap">
<div id="inner">
<div class="wrap">
<div id="content-sidebar-wrap">

				
<br><br><br><br>
<!--user profile-->

<h1 style = "text-align:center;"> User Profile </h1>
<?php
$query = "SELECT p.firstname, p.lastname, p.email, p.address, p.register_date, p.phone FROM person p WHERE p.email = '$email'";
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
	echo "<table align = 'center' style = 'width:60%'>";

	foreach($array as $list) {
		echo "<tr><td><p>First Name</p></td>";
		echo "<td><p>" . $list["firstname"] . "</p></td></tr>";
		echo "<tr><td><p>Last Name</p></td>";
		echo "<td><p>" . $list["lastname"] . "</p></td></tr>";
		echo "<tr><td><p>Email</p></td>";
		echo "<td><p>" . $list["email"] . "</p></td></tr>";
		echo "<tr><td><p>Address</p></td>";
		echo "<td><p>" . $list["address"] . "</p></td></tr>";
		echo "<tr><td><p>Register Date</p></td>";
		echo "<td><p>" . $list["register_date"] . "</p></td></tr>";
		echo "<tr><td><p>Contact Number</p></td>";
		echo "<td><p>" . $list["phone"] . "</p></td></tr>";	
	}
	echo "<tr><td><p> Total Donation </p></td>";
	echo "<td><p>". $total. "</p></td></tr>";
	echo "</table>";
} else {
	echo "<p> There is no such user! </p>";
}
?>


<!--proposed project profile-->

<h1 style = "text-align:center;"> Projects Proposed </h1>
<?php
$email = $_GET['id'];
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
		echo "<td><p>" . $list["id"] . "</p></td></tr>";
		echo "<tr><td><p>Project Creator</p></td>";
		echo "<td><p>" . $list["creator"] . "</p></td></tr>";
		echo "<tr><td><p>Project Title</p></td>";
		echo "<td><p>" . $list["title"] . "</p></td></tr>";
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
$email = $_GET['id'];
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
	</div><!-- end .wrap --></div><!-- end #inner --> 
<div id="bigg-footer">
<div class="wrap">
        <div class="twocol">
            <div id="text-2" class="widget widget_text"><div class="widget-wrap"><h4 class="widgettitle">Company</h4>			
			<div class="textwidget"><ul class="plain-list">
<li><a href="#">About</a></li>
<li><a href="#">Jobs</a></li>
<li><a href="#">Contact</a></li>
<li><a href="#">Terms</a></li>
<li><a href="#">Privacy</a></li>
</ul>
</div>
		</div></div>
        </div>
        <div class="twocol">
            <div id="text-3" class="widget widget_text"><div class="widget-wrap"><h4 class="widgettitle">Community</h4>			<div class="textwidget"><ul class="plain-list">
<li><a href="#">Blog</a></li>
<li><a href="#">Twitter</a></li>
<li><a href="#">Facebook</a></li>
<li><a href="#">Help</a></li>
</ul>
</div>

		</div></div>
        </div>
        <div class="fourcol">
            <div id="text-4" class="widget widget_text"><div class="widget-wrap"><h4 class="widgettitle"></h4>			<div class="textwidget"><p></p>

<div>

</div>

</div>
		</div></div>
        </div>
        <div class="fourcol last">
             <div id="text-4" class="widget widget_text"><div class="widget-wrap"><h4 class="widgettitle">Subscribe to the newsletter</h4>			<div class="textwidget"><p>Get news of the latest inventions in your inbox</p>

<div>
<input type="text" placeholder="Enter your email address" name="email" class="form-field" id="newsletter-email-input"> <input type="button" value="Submit" class="button" id="newsletter-email-submit-btn">
</div>
<p class="legalese">
Opt-out anytime with one click and we'll never share your information.
</p></div>
        </div>
</div>
 
</div><!-- end #wrap -->


</div>

</body>
</html>

