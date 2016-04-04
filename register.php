<?php
   $host = "localhost"; 
   $user = "postgres"; 
   $pass = "password"; 
   $db = "test"; 
   $dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
   session_start();

//   $sql = "INSERT INTO person(name, email, password) VALUES ('Jack', 'mas@yahoo.com', '234567')";
//   $result = pg_query($dbcon, $sql);
//   if (!$result) {
//       print "F";
//   }
//   else {
//      print "T";
//   }

   if($_SERVER["REQUEST_METHOD"] == "GET") {
      // username and password sent from form


       $myfirstname = trim($_GET['firstname']);
       $mylastname = trim($_GET['lastname']);
       $myemail = trim($_GET['email']);
       $mypassword = $_GET['password'];
       $mypassword2 = $_GET['password_confirm'];
       $mysex = $_GET['sex'];
       $myaddress = $_GET['address'];
       $myphone = $_GET['phone'];
       $register_date = date("Y-m-d");

      $sql = "INSERT INTO person(firstname, lastname, email, password, sex, address, register_date, phone, admin)
              VALUES ('$myfirstname', '$mylastname', '$myemail', '$mypassword', '$mysex', '$myaddress',
              '$register_date', '$myphone', 'N');";
      $result = pg_query($dbcon, $sql);

      if(!$result) {
          if (!empty($_GET))
              $error = "The email address is already used";
      }else {
        $success = "You have successfully registered";
        $_SESSION['email'] = $myemail;
          header( "refresh:3;url=index.php" );
      }
   }
?>

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

<div class = "container">
 
<div class = "col-md-offset-4 col-md-4">
  <div style= "text-align:left">

               <!--<form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
                </form>-->
                <form class="form-signin" action="" method="GET">
                  <h1 style = "text-align: center">Sign up</h1>
                  <p> 
                    <label for="firstname" class="uname" data-icon="u">Your first name</label>
                    <input class="form-control" id="firstname" name="firstname" required="required" type="text" placeholder="First name" />
                  </p>
                  <p>
                    <label for="lastname" class="uname" data-icon="u">Your last name</label>
                    <input class="form-control" id="lastname" name="lastname" required="required" type="text" placeholder="Last name" />
                  </p>
                  <p> 
                    <label for="email" class="youmail" data-icon="e" > Your email</label>
                    <input class="form-control" id="email" name="email" required="required" type="email" placeholder="mymail@mail.com"/>
                  </p>
                  <p> 
                    <label for="password" class="youpasswd" data-icon="p">Your password </label>
                    <input class="form-control" id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO"/>
                  </p>
                  <p> 
                    <label for="password_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                    <input class="form-control" id="password_confirm" name="password_confirm" required="required" type="password" placeholder="Same as above"/>
                  </p>
                  <p>
                   <label for="address" class="addr" data-icon="u">Your address<br></label>
                   <input class="form-control" id="address" name="address" type="text" placeholder="Address" />
                 </p>
                 <p>
                  <label for="phone" class="phone" data-icon="u">Your phone number</label>
                  <input class="form-control" id="phone" name="phone" type="number" placeholder="phone" />
                </p>
                <p>
                  <div class = "row">
                  <div class = "col-md-4">
                  <label for="sex" class="sex" data-icon="s">You gender </label>
                  </div>
                  <div class = "col-md-8">
                  <label><input type="radio" name="sex" value="O" checked/> Other</label>
                  </div>
                  </div>
                  <div class = "row">
                  <div class = "col-md-offset-4 col-md-8">

                  <label><input type="radio" name="sex" value="M"/> Male</label>
                  </div>
                  </div>
                  <div class = "row">
                  <div class = "col-md-offset-4 col-md-8">
                  <label><input type="radio" name="sex" value="F"/> Female</label>

                  </div>
                  </div>
                </p>
                <p style= "text-align:center" class="signin button"> 
                 <input calss = "btn btn-default" type="submit" value="Register"/>
               </p>
               <p class="change_link">  
                 Already a member ?
                 <a href="login.php" class="to_register"> Please log in </a>
               </p>
             </form>
             <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
             <div style = "font-size:11px; color:#0000cc; margin-top:10px"><?php echo $success; ?></div>
           </div>
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
            <p class="pull-left"> Copyright © 2016 Uptown Fund Pte. Ltd. All rights reserved. </p>
        </div>
    </div>
    <!--/.footer-bottom--> 
</footer>
<!--end of footer-->
   </body>
</html>
