<html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Uptown Fund &raquo; Your One-Stop Crowdfunding Hub</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
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
                    scrollTop: jQuery('#homelinkhere').offset().top
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
<div id = "homelinkhere"></div>
<div id="paddingstart"></div>

<!--header strat here-->
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
        <li class="page-nav-top-posts active"><a href="javascript:void(0)" id="feature-scroll" class="page-anchor-link">Home</a></li>

        <li class="page-nav-popular-posts"><a href="javascript:void(0)" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

        <li class="page-nav-top-posts active"><a href="javascript:void(0)" id="category-scroll" class="page-anchor-link">Categories</a></li>

        <li class="page-nav-popular-posts"><a href="javascript:void(0)" id="Countries-scroll" class="page-anchor-link">Countries</a></li>

        <li class="page-nav-top-posts active"><a href="search.php" id="feature-scroll" class="page-anchor-link">Search</a></li>
      </ul>
    <!--nav bar left side content ends here-->

      <?php 
      if (!isset($_SESSION['email'])) {
        $host_url = "login.php";
        $admin_url = "login.php";
      } else {
        $host_url = "new_project.php";
        $admin_url = "admin.php";
      }
      ?>

      <ul class="nav navbar-nav navbar-right">
        <li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="register.php">Sign Up</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="login.php">Log In</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="<?php echo $host_url ?>">Host Project</a></li>
        <li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="<?php echo $host_url ?>">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>
<!--header ends here-->





<!--start of middle content-->
<div class = "container">
				
  <!--start of top big picture and intro-->
  <div = class = "row">      

    
		<div class = "col-md-7">
      <a href="#" title="Welcome to Uptown Fund"><img width="660" height="370" src="images/1.jpg" class="alignleft post-image" alt="1" /></a>	
    </div>

    <div class = "col-md-5">
      <h1 class="entry-title"><a href="#" title="Welcome to Uptown Fund" rel="bookmark">Welcome to Uptown Fund</a></h1> 

  		
  		<p id = "main_page_top_para">Uptown Fund is the one-stop hub to turn ideas into successful inventions.  Here, you can reach out to potential investors by hosting your projects and ideas.  Alternatively, you can browse through and contribute to thousands of new inventions from all around the world. </p>
      <p><a class="btn btn-primary btn-lg" href="#categories" role="button">Browse</a></p>	
    </div>


  </div>
  <!--end of top big picture and intro-->

<!-- start of Categories Section -->

<div class = "row">
  <div class="categories">
   <cap id="categories">Categories</cap>
   <br>
   <sub>Browse projects by categories</sub>
 </div>
</div>
<!-- end of Categories Section -->

<br>

<!--start of Categories List -->
<div class = "row">
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
</div>
<!--end of Categories List -->

<div class = "row">
<!-- start of Popular List -->
<div class = "col-md-6">
  <div id="popular-upcoming">

    <div>
      <h2>Popular</h2>
      <h4>The most popular crowdfunding projects</h4>
    </div>

    <ul class="list-group">   
      <?php
      $query = "SELECT p.id, p.title FROM donation d, project p WHERE p.id=d.project AND p.status='ongoing' GROUP BY p.title, p.id  ORDER BY COUNT(d.project) DESC LIMIT 10";

      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
      ?>

      <?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
      <?php if(!$line['title']) { ?>
      <?php continue; ?>
      <?php } ?>
      <?php $id = $line['id'];?>
      <li class="list-group-item"><a href="project_detail.php?id=<?php echo $id ?>"><?php echo $line['title']; ?></a></li>
      <?php } ?>
      <?php pg_free_result($result); ?>
    </ul>
  </div>
</div>
<!-- end of Popular List -->

<!--start of Countries List -->
<div class = "col-md-6">
  <div id="countries">
    <div >
      <h2 >Countries</h2>
      <h4 >Browse projects by countries</h4>
    </div>

    <ul class="list-group"> 
      <?php
      $query = 'SELECT DISTINCT country FROM project ORDER BY country';
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
      ?>

      <?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
      <?php foreach ($line as $col_value) { ?>
      <li class="list-group-item"><a href="country_result.php?country=<?php echo $col_value ?>"><?php echo $col_value; ?></a></li>
      <?php } ?>
      <?php } ?>
      <?php pg_free_result($result); ?>
    </ul>

  </div>
 <!--end of Countries List -->
</div>

  </div>
</div>

<!--end of middle content-->


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