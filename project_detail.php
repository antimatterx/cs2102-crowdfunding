
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
        <?php
        $host = "localhost";
        $user = "postgres";
        $pass = "password";
        $db = "test";

        $dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
        or die('Could not connect: ' . pg_last_error());
        session_start();
        $curr_id = $_GET['id'];
        //$curr_id = 2;
        $sql = "SELECT * FROM project
        WHERE id=$curr_id;";
        $result = pg_query($dbcon, $sql);
        if (!$result || pg_num_rows($result) == 0) {
            echo "<br>Nothing here but us chickens<br>";
        }
        else {
        $received_query = "SELECT SUM(amount) FROM donation WHERE project=$curr_id;";
        if (is_null($received_query))
            $donated = pg_fetch_assoc(pg_query($dbcon,$received_query))['sum'];
        else
            $donated = 0;
        $image = pg_fetch_assoc($pic_query)['data'];
        $row = pg_fetch_assoc($result);
        $creator = $row['creator'];
        $title  = $row['title'];
        $description = $row['description'];
        $start = $row['start'];
        $expiry = $row['expiry'];
        $country = $row['country'];
        $target = $row['target'];
        $status = $row['status'];
        //category query
        $cat_sql = "SELECT tag FROM has_category WHERE id=$curr_id;";
        $cat_result = pg_query($dbcon, $cat_sql);
        $category = "";
        while ($cat_row = pg_fetch_array($cat_result)) {
            $category = $category . ", " . $cat_row['tag'];
        }
        $category = ltrim($category, ",");
        ?>

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




<div class="container">
<div class = "row">




<?php
// Fetch the image
$sqlImg = "SELECT data
    FROM image
    WHERE id = '$curr_id'";

$resImg = pg_query($dbcon, $sqlImg) or die("Query Failed: " . pg_last_error());

if(pg_num_rows($resImg) > 0) {
    $dataImg = pg_fetch_result($resImg, 'data');
    $unes_image = pg_unescape_bytea($dataImg);

    // save image to file
    $file_name = "temp/" . $curr_id . ".jpg";
    $img = fopen($file_name, 'wb') or die("cannot open image\n");
    fwrite($img, $unes_image) or die("cannot write image data\n");
    fclose($img);
} else {
    $file_name = "images/blank.jpg";
}
?>

<div class = "col-md-3" >
<?php
$query = "SELECT i.data FROM image i WHERE i.id = $curr_id;";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());

echo "<img src=$file_name class=\"alignleft post-image\" alt=\"Image Not Found\" style='max-width: 350px;'/>";
?>
</div>

  <div class="col-md-offset-1 col-md-6">
  <h2><?php echo $title; ?></h2>        
  <table class="table table-striped">
    <tbody>
      <tr>
        <th>Creators</th>
        <td><?php echo $creator; ?></td>
      </tr>
      <tr>
        <th>Description</th>
        <td><?php echo $description; ?></td>
      </tr>
      <tr>
        <th>Category</th>
        <td><?php echo $category; ?></td>
      </tr>
      <tr>
        <th>Country</th>
        <td><?php echo $country; ?></td>
      </tr>
      <tr>
        <th>Starting From:</th>
        <td><?php echo $start; ?></td>
      </tr>
      <tr>
        <th>Ending at:</th>
        <td><?php echo $expiry; ?></td>
      </tr>
      <tr>
        <th>Target amount:</th>
        <td><?php echo $target; ?></td>
      </tr>
      <tr>
        <th>Currently received</th>
        <td><?php echo $donated; ?></td>
      </tr>
      <tr>
        <th>Current status</th>
        <td><?php echo $status; ?></td>
      </tr>
    </tbody>
  </table>




<div class= "row">
<div style = "text-align:center;">
<?php  if (isset($_SESSION['email'])) /* the user is logged in, show donation bar*/ {?>
        <h3>Interested?</h3>
        <form action="donate.php" method="GET">
        <h4>You can donate below:</h4>
              <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">$</span>
                  <input class = "form-control" id="donation" name="donation" required="required" type="number" min="1" aria-describedby="basic-addon1">
                  <span class="input-group-btn">
                    <input class = "btn btn-default" type="submit" name="donate" value="Donate" />
                </span>
              </div>
            <div class="donate button">
                
            </div>
            <input id="id" name="id" type="hidden" value="<?php echo $curr_id;?>"/>

        </form>
        <div style = "font-size:11px; color:#cc0000; margin-top:10px">
        <?php if ($donate_query) echo $donate_result;?>
        </div>
<?php } else /*tell user to login*/{ ?>
    <p>You have to <a href="login.php">log in</a> before making a donation! </p>

<?php }}; ?>
</div>
</div>
</div>
</div>
</div><!--end of container-->

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
