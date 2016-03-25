<html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
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

<body class="home blog header-full-width full-width-content">
  <div id="header">
  <div class="site-header">
    <h1 class="site-header-logo-container">
    <a>Logo</span>
    <img src="images/logo.png" width="100%" id="bigg-logo" alt="Bigg" /></a>
    </h1>
      
            <ul id="page-nav" class="horizontal-list">
<li class="page-nav-top-posts active"><a href="index.php" id="feature-scroll" class="page-anchor-link">Home</a></li>

<li class="page-nav-popular-posts"><a href="index.php#popular-upcoming" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

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
		
</div>end .postclass
</div><!-- end #content -->

<!-- fetch the variable name -->
<?php $var_value = $_GET['varname'];?>

<?php $title = ucfirst ($var_value);?>
<!-- Categories Section -->
<div class="categories">
	<br>
	<cap><?php echo $title;?></cap>
</div>


<ul class="plain-list stories-table">    
<?php

$query = "SELECT p.title FROM has_category h, project p WHERE p.id=h.id AND h.tag='$var_value'";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
	<?php foreach ($line as $col_value) { ?>
  	<li><a href="#"><?php echo $col_value; ?></a></li>
   <?php } ?>
 <?php } ?>
<?php pg_free_result($result); ?>
</ul>


<!-- <div class="categories">
	<a href="index.html"><span><img src="images/art.jpg" style="width: 100%" class="post-image">Art</span></a>
	<a href="index.html"><span><img src="images/education.jpg" style="width: 100%" class="post-image">Education</span></a>
	<a href="index.html"><span><img src="images/environment.jpg" style="width: 100%" class="post-image">Environment</span></a>
	<a href="index.html"><span><img src="images/game.jpg" style="width: 100%" class="post-image">Gaming</span></a>

	<a href="index.html"><span><img src="images/music.jpg" style="width: 100%" class="post-image">Music</span></a>
	<a href="index.html"><span><img src="images/technology.jpg" style="width: 100%" class="post-image">Technology</span></a>
	<a href="index.html"><span><img src="images/video.jpg" style="width: 100%" class="post-image">Video</span></a>
	<a href="index.html"><span><img src="images/other.jpg" style="width: 100%" class="post-image">Others</span></a>
</div> -->




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