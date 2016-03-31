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

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());
?>

<?php session_start(); ?>

<body class="home blog header-full-width full-width-content">
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

$query = "SELECT p.id, p.title, p.status FROM has_category h, project p WHERE p.id=h.id AND h.tag='$var_value' ORDER BY p.status DESC, p.title;";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?php 
// create temp folder to store images
function makeDir($path)
{
     return is_dir($path) || mkdir($path);
}

makeDir("temp");
?>

<div class="categories">

<?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
    <?php if(!$line['title']) { ?>
    <?php continue; ?>
    <?php } ?>

    <?php
    $status = $line['status'];
    $id = $line['id'];
    $queryImg = "SELECT data FROM image WHERE id=$id";
    $resImg = pg_query($dbcon, $queryImg) or die (pg_last_error($con));
    if(pg_num_rows($resImg) > 0) {
      $dataImg = pg_fetch_result($resImg, 'data');
      $unes_image = pg_unescape_bytea($dataImg);

      // save image to file
      $file_name = "temp/" . $id . ".jpg";
      $img = fopen($file_name, 'wb') or die("cannot open image\n");
      fwrite($img, $unes_image) or die("cannot write image data\n");
      fclose($img);
    } else {
      $file_name = "images/blank.jpg";
    }
    ?>

    <a href="project_detail.php?id=<?php echo $id ?>">
    <div>
    <img src="<?php echo $file_name; ?>" style="width: 100%" class="post-image"><?php echo $line['title']; ?>
    <?php if($status=='closed') { ?>
      <img src="images/expired.png" class="overlay" />
    <?php } ?>
    
    </div>
    
    </a>
 <?php } ?>
<?php pg_free_result($result); ?>
</div>


	</div><!-- end #content-sidebar-wrap -->
	</div><!-- end .wrap --></div><!-- end #inner --> 



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