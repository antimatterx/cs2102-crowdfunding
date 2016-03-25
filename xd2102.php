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
<h1> User Profile </h1>
<p title="User Profile"></p>
<table style="width:60%">
  <tr>
    <td>Name:</td>
    <td>CS2102 </td>
 </tr>
<tr>
    <td>Email:</td>
    <td>CS2102@nus.edu.sg </td>
 </tr>
<tr>
    <td>Phone:</td>
    <td>999-999-999</td>
 </tr>
<tr>
    <td>DOB:</td>
    <td>20-9-2000 </td>
 </tr>
<tr>
    <td>Register Date</td>
    <td>16-7-2000 </td>
 </tr>
<tr>
    <td>Address:</td>
    <td>NUS SOC CS2102 LT19 </td>
 </tr>
<tr>
    <td>Total Donation(US $):</td>
    <td>$1500 </td>
 </tr>
<tr>
    <td>Total Collection(US $):</td>
    <td>$2500 </td>
 </tr>
</table>
<br>

<!--donated project profile-->
<h1> Donated Projects </h1>
<p title="Donated Projects"></p>
<table style="width:60%">
  <tr>
    <td>Project Name:</td>
    <td>CS2102 Project </td>
 </tr>
<tr>
    <td>Project ID:</td>
    <td>112113114 </td>
 </tr>
<tr>
    <td>Starts Date:</td>
    <td>9-7-2015</td>
 </tr>
<tr>
    <td>Ends Date:</td>
    <td>20-9-2015 </td>
 </tr>
<tr>
    <td>Donated Date:</td>
    <td>11-9-2015 </td>
 </tr>
<tr>
    <td>Donated Amount:</td>
    <td>$19.00</td>
 </tr>
<tr>
    <td>Project Status:</td>
    <td>closed</td>
 </tr>
</table>
<!--proposed project profile-->
<br>
<h1> Proposed Projects </h1>
<p title="Proposed Projects"></p>
<table style="width:60%">
  <tr>
    <td>Project Name:</td>
    <td>2102Project</td>
 </tr>
<tr>
    <td>Project ID:</td>
    <td>12341234</td>
 </tr>
<tr>
    <td>Starts Date:</td>
    <td>9-7-2015</td>
 </tr>
<tr>
    <td>Ends Date:</td>
    <td>20-9-2015</td>
 </tr>
<tr>
    <td>Target Amount:</td>
    <td>$100.00 </td>
 </tr>
   
<tr>
    <td> Current Amount:</td>
    <td>$19.00</td>
 </tr>
   <tr>
    <td>Contributor ID:</td>
    <td>45646789</td>
 </tr>
 <tr>
    <td>Project Status:</td>
    <td>ongoing</td>
 </tr>
    
</table>

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

