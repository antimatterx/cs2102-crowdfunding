<?php
//include_once 'dbconfig.php';
$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";
$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

$sql = "SELECT p.id FROM project p
        GROUP BY p.id
        HAVING p.id >= ALL (
          SELECT id FROM project
        );";
$result = pg_query($dbcon, $sql);
$row = pg_fetch_assoc($result);
$newid = $row['id'] + 1;

session_start();
$_SESSION['email'] = "april_foo@hotmail.com";
if($_SERVER["REQUEST_METHOD"] == "GET") {
    // username and password sent from form
    $title = trim($_GET['title']);
    $description = trim($_GET['description']);
    $start = trim($_GET['start']);
    $expiry = trim($_GET['expiry']);
    $target = trim($_GET['target']);
    $mail = $_SESSION['email'];
    //$photo = $FILES('photo','name');
    //$insertT = "INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (18, 'able_too@gmail.com', 'Food Maker', 'Cook twice the amount of food in half the time!', '2015/09/14', '2016/10/14', 'Japan', 2000, 'ongoing')";

    $insert = "INSERT INTO project(id, creator, title, description, start, expiry, target, status) 
            VALUES ('$newid', '$mail', '$title', '$description', '$start', '$expiry', '$target', 'ongoing');";
    //$result = pg_query($dbcon, $insert);
    $result = pg_query($dbcon, $insert);
    if($result) {
        $success = "Successfully created new project";
    }else {
        $error = "Something wrong happens, please try again";
    }
//    $upload_img = "INSERT INTO image VALUES ('$newid', '$photo')";
//    $img_result = pg_query($dbcon, $upload_img);
//
//    if($img_result && move_uploaded_file($_FILES['photo']['tmp_name'], $target_dir)) {
//        echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory";
//    }
}
?>


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

<div class = "container">

    <div class = "col-md-offset-4 col-md-4">

            <!--<form action = "" method = "post">
               <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
               <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
               <input type = "submit" value = " Submit "/><br />
            </form>-->
            <form  action="" method="GET">
                <h1> Sign up </h1>
                <p>
                    <label for="title" class="title" data-icon="u">Title</label>
                    <input class="form-control" id="title" name="title" required="required" type="text" placeholder="Title" />
                </p>
                <p>
                    <label for="description" class="description" data-icon="e" > Description</label>
                    <input class="form-control" id="description" name="description" required="required" type="text" placeholder="Description"/>
                </p>
                <p>
                    <label for="start" class="date" data-icon="p">Start date </label>
                    <input class="form-control" id="start" name="start" required="required" type="date" placeholder="2001-12-31"/>
                </p>
                <p>
                    <label for="expiry" class="expiry" data-icon="p">End date</label>
                    <input class="form-control" id="expiry" name="expiry" required="required" type="date" placeholder="2002-12-31"/>
                </p>
                <p>
                    <label for="target" class="expiry" data-icon="p">Target amount</label>
                    <input class="form-control" id="target" name="target" required="required" type="number" placeholder="In US$"/>
                </p>
                <!--<p>
                    You May Upload a Photo in gif or jpeg format. If the same file name is uploaded twice it will be overwritten! Maxium size of File is 35kb.
                </p>
                <p>
                    Photo:
                </p>
                <input type="hidden" name="size" value="350000">
                <input type="file" name="photo">-->
                <p class="create button" style="text-align:center;">
                    <input class = "btn btn-default" type="submit" value="Submit"/>
                </p>
            </form>
            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <div style = "font-size:11px; color:#0000cc; margin-top:10px"><?php echo $success; ?></div>
        </div>
    
</div>


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
