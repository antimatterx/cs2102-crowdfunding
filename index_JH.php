<html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Uptown Fund &raquo; Your One-Stop Crowdfunding Hub</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


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
<?php $email = $_POST['email']; ?>


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
//scroll the popular
  jQuery('#popular-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#popular-upcoming').offset().top
                     }, 1000);
            //});
        });

//scroll the home button
		jQuery('#feature-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#inner').offset().top
                     }, 1000);
            //});
        });

//scroll the category button
				jQuery('#category-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#categories').offset().top
                     }, 1000);
            //});
        });

//scroll the country button
				jQuery('#Countries-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#countries').offset().top
                     }, 1000);
            //});
        });


		  });
	  </script>
</head>

<body>

<!--header strat here-->
  <div id="header">
  <div class="site-header">
    <h1 class="site-header-logo-container">
    <a>Logo</span>
    <img src="images/logo.png" width="100%" id="bigg-logo" alt="Bigg" /></a>
    </h1>
      
            <ul id="page-nav" class="horizontal-list">
<li class="page-nav-top-posts active"><a href="javascript:void(0)" id="feature-scroll" class="page-anchor-link">Home</a></li>

<li class="page-nav-popular-posts"><a href="javascript:void(0)" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

<li class="page-nav-top-posts active"><a href="javascript:void(0)" id="category-scroll" class="page-anchor-link">Categories</a></li>

<li class="page-nav-popular-posts"><a href="javascript:void(0)" id="Countries-scroll" class="page-anchor-link">Countries</a></li>

<li class="page-nav-top-posts active"><a href="search.php" id="feature-scroll" class="page-anchor-link">Search</a></li>
</ul>

<?php 
if (!isset($_SESSION['email'])) {
  $host_url = "login.php";
  $admin_url = "login.php";
} else {
  $host_url = "new_project.php";
  $admin_url = "admin.php";
}
?>

<div id="site-nav" class="horizontal-list"><div class="menu-main-menu-container">
	<ul id="menu-main-menu" class="menu">
		<li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="register.php">Sign Up</a></li>
		<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="login.php">Log In</a></li>
		<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="<?php echo $host_url ?>">Host Project</a></li>
	  <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="<?php echo $host_url ?>">Admin</a></li>
  </ul></div></div><!-- #site-nav -->
<div id="site-header">
    
    </div>  
    </div>
  </div>

<!--header ends here-->

<div id="wrap">
<div id="inner">
<div class="wrap">
<div id="content-sidebar-wrap">
				
				<div id="content" class="hfeed">
				<div class="post-5 post type-post status-publish format-standard hentry category-featured category-parent-category-i entry feature feature">
    <br><br>
		<a href="#" title="Welcome to Uptown Fund"><img width="660" height="370" src="images/1.jpg" class="alignleft post-image" alt="1" /></a>		<h2 class="entry-title"><a href="#" title="Welcome to Uptown Fund" rel="bookmark">Welcome to Uptown Fund</a></h2> 

				<div class="entry-content">
			<p>Uptown Fund is the one-stop hub to turn ideas into successful inventions.  Here, you can reach out to potential investors by hosting your projects and ideas.  Alternatively, you can browse through and contribute to thousands of new inventions from all around the world. </p>

			<a href="index.php#categories" class="bigg-read-more">Browse</a>		</div><!-- end .entry-content -->

	</div><!-- end .postclass -->
	</div><!-- end #content -->

<!-- Categories Section -->
<div class="categories">
	<cap id="categories">Categories</cap>
	<br>
	<sub>Browse projects by categories</sub>
</div>
<br>

<!-- Categories List -->
<div class="categories">
	<a href="cat_result.php?varname=<?php echo "art" ?>"><span><img src="images/art.jpg" style="width: 100%" class="post-image">Art</span></a>
	<a href="cat_result.php?varname=<?php echo "education" ?>"><span><img src="images/education.jpg" style="width: 100%" class="post-image">Education</span></a>
	<a href="cat_result.php?varname=<?php echo "environment" ?>"><span><img src="images/environment.jpg" style="width: 100%" class="post-image">Environment</span></a>
	<a href="cat_result.php?varname=<?php echo "gaming" ?>"><span><img src="images/game.jpg" style="width: 100%" class="post-image">Gaming</span></a>

	<a href="cat_result.php?varname=<?php echo "music" ?>"><span><img src="images/music.jpg" style="width: 100%" class="post-image">Music</span></a>
	<a href="cat_result.php?varname=<?php echo "technology" ?>"><span><img src="images/technology.jpg" style="width: 100%" class="post-image">Technology</span></a>
	<a href="cat_result.php?varname=<?php echo "video" ?>"><span><img src="images/video.jpg" style="width: 100%" class="post-image">Video</span></a>
	<a href="cat_result.php?varname=<?php echo "others" ?>"><span><img src="images/other.jpg" style="width: 100%" class="post-image">Others</span></a>
</div>

<!-- Popular List -->
<div id="popular-upcoming" class="stories-container sixcol">

<div class="stories-section-header">
<h2 id="popular" class="stories-section-header-hed">Popular</h2>
<h3 class="stories-section-header-subhed">The most popular crowdfunding projects</h3>
</div>

<ul class="plain-list stories-table">    
<?php
$query = "SELECT p.id, p.title FROM donation d, project p WHERE p.id=d.project AND p.status='ongoing' GROUP BY p.title, p.id  ORDER BY COUNT(d.project) DESC LIMIT 10";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
  <?php if(!$line['title']) { ?>
  <?php continue; ?>
  <?php } ?>
  <?php $id = $line['id'];?>
  <li><a href="project_detail.php?id=<?php echo $id ?>"><?php echo $line['title']; ?></a></li>
 <?php } ?>
<?php pg_free_result($result); ?>
</ul>
</div>

<!-- Countries List -->
<div id="countries" class="stories-container sixcol last">
<div class="stories-section-header">
<h2 class="stories-section-header-hed">Countries</h2>
<h3 class="stories-section-header-subhed">Browse projects by countries</h3>
</div>

<ul class="plain-list stories-table">    
<?php
$query = 'SELECT DISTINCT country FROM project ORDER BY country';
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
	<?php foreach ($line as $col_value) { ?>
  	<li><a href="country_result.php?country=<?php echo $col_value ?>"><?php echo $col_value; ?></a></li>
   <?php } ?>
 <?php } ?>
<?php pg_free_result($result); ?>
</ul>


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