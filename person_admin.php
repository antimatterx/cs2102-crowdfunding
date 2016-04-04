<?php session_start() ?>
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

if(isset($_GET['id'])) {
	$_SESSION['session-ID'] = $_GET['id'];
} 
// echo "<h3> B " . $_SESSION['session-ID'] . "</h3>";

$isAdmin = $_SESSION['email'];

$sql = "SELECT p.admin FROM person p WHERE p.email = '" . $isAdmin . "';";

// echo "<br><br><br><br><h1>" . $sql . "</h1>";
$result = pg_query($sql) or die("Query failed: " . pg_last_error());

$isAdmin = pg_fetch_array($result);
$isAdmin = $isAdmin['admin'];
$isAdmin = ($isAdmin == "Y");


// echo "<br><br><br><br><h1>" . $isAdmin . "<h1>";
if (!$isAdmin) {
	echo "<script type='text/javascript'>";
	echo " $(function(){
	window.location.href='index.php';
	});";
echo "</script>";      
}

$curr_id = $_SESSION['session-ID'];

if (isset($_GET['edit-account-submit'])) { #ACCOUNT EDIT
	$emailSuccess = ($_GET['person-email'] != $_SESSION['session-email']);
	$fnameSuccess = ($_GET['person-firstname'] != $_SESSION['session-firstname']);
	$lnameSuccess = ($_GET['person-lastname'] != $_SESSION['session-lastname']);
	$passwordSuccess = ($_GET['person-password'] != $_SESSION['session-password']);
	$sexSuccess = ($_GET['person-sex'] != $_SESSION['session-sex']);
	$addressSuccess = ($_GET['person-address'] != $_SESSION['session-address']);
	$phoneSuccess = ($_GET['person-phone'] != $_SESSION['session-phone']);
	$adminSuccess = ($_GET['person-admin'] != $_SESSION['session-admin']);
	
	$email = $_GET['person-email'];
	$email = trim($email);
	$email = str_replace("'", "''", $email);
	if ($email == "") {
		$email = $curr_id;
		$emailSuccess = false;
	}

	$cfirstname = $_GET['person-firstname'];
	$cfirstname = trim($cfirstname);
	$cfirstname = str_replace("'", "''", $cfirstname);
	if ($cfirstname == "") {
		$cfirstname = $_SESSION['session-firstname'];
		$fnameSuccess = false;
	}

	$clastname = $_GET['person-lastname'];
	$clastname = trim($clastname);
	$clastname = str_replace("'", "''", $clastname);
	if ($clastname == "") {
		$clastname = "NULL";
	} else {
		$clastname = "'" . $clastname . "'";
	}

	$password = $_GET['person-password'];
	$password = trim($password);
	$password = str_replace("'", "''", $password);
	if ($password == "") {
		$password = $_SESSION['session-password'];
		$passwordSuccess = false;
	}
	
	if ($_GET['person-sex'] != "M" and $_GET['person-sex'] != "F" and $_GET['person-sex'] != "O") {
		$sex = $_SESSION['session-sex'];
		$sexSuccess = false;
	} else {
		$sex = $_GET['person-sex'];
	}

	$address = $_GET['person-address'];
	$address = trim($address);
	$address = str_replace("'", "''", $address);
	if ($address == "") {
		$address = "NULL";
	} else {
		$address = "'" . $address . "'";
	}


	if (!(is_numeric($_GET['person-phone']))) {
		$phone = $_SESSION['session-phone'];
		$phoneSuccess = false;
	} else {
		$phone = $_GET['person-phone'];
	}

	if ($_GET['person-admin'] != "Y" and $_GET['person-admin'] != "N") {
		$admin = $_SESSION['session-admin'];
		$adminSuccess = false;
	} else {
		$admin = $_GET['person-admin'];
	}

	if ($emailSuccess or $fnameSuccess or $lnameSuccess or $passwordSuccess or $sexSuccess or $addressSuccess or $phoneSuccess or $adminSuccess) {
		$_SESSION['success'] = true;
	} else {
		$_SESSION['success'] = false;
	}

	// echo "<br><br><br><br><h1>" .
	// "T" . $_SESSION['success'].  
	// "a" . $fnameSuccess . 
	// "b" . $lnameSuccess . 
	// "c" . $passwordSuccess . 
	// "d" . $sexSuccess . 
	// "e" . $addressSuccess . 
	// "f" . $phoneSuccess . 
	// "g" . $adminSuccess . "</h1><br>";


	$email = trim($email);
	$password = trim($password);
	$sql = "UPDATE person 
	SET email = '" . $email . "',
	firstname = '" . $cfirstname . "', 
	lastname = " . $clastname . ", 
	password = '" . $password . "', 
	sex = '" . $sex . "', 
	address = " . $address . ", 
	phone = " . $phone . ", 
	admin = '" . $admin . "' 
	WHERE email = '" . $curr_id .  "';";

	$_SESSION['session-ID'] = $email;
	if ($_SESSION['email'] == $curr_id) {
		$_SESSION['email'] = $email;
	}
	$curr_id = $email;

	// echo "<br><br><h1>" . $sql . "</h1><br><h2>" . $_SESSION['session-ID'] . "</h2>";
	pg_query($sql) or die('Query failed: ' . pg_last_error());
}

// echo "<br><br><br><br><br><h3> A " . $_SESSION['session-ID'] . "</h3>";

$sql = "SELECT p.email AS EMAIL, 
    p.firstname AS FirstName,
    p.lastname AS LastName,
    p.password AS Password,
    p.sex AS Sex,
    p.register_date AS Registerdate,
    p.address AS Address,
    p.phone AS Phone,
    p.admin AS Admin
    FROM person p
    WHERE p.email = '".$curr_id."'
    GROUP BY p.email, p.firstname, p.lastname, p.password, p.sex, p.register_date, p.address, p.phone, p.admin";

	// echo"<br><br><br><br><br><h1>" . $sql . "</h1>";


	$resultInit = pg_query($dbcon, $sql) or die("Query Failed: " . pg_last_error());
	if (!$resultInit) {
	    echo "<h1> Nothing found </h1>";
	}
	else {
	    $rowInit = pg_fetch_row($resultInit);

	    $email =  $rowInit[0]; 
	    $cfirstname = $rowInit[1];
	    $clastname =  $rowInit[2];
	    $password =  $rowInit[3];
	    $sex = $rowInit[4];
	    $registerdate = $rowInit[5];
	    $address = $rowInit[6];
	    $phone =  $rowInit[7];
	    $admin =  $rowInit[8];
	    
	    $_SESSION['session-email']  = $rowInit[0];
	    $_SESSION['session-firstname']  = $rowInit[1];
	    $_SESSION['session-lastname'] = $rowInit[2];
	    $_SESSION['session-password'] = $rowInit[3];
	    $_SESSION['session-sex'] = $rowInit[4];
	    $_SESSION['session-resgisterdate'] = $rowInit[5];
	    $_SESSION['session-address'] = $rowInit[6];
	    $_SESSION['session-phone'] = $rowInit[7];
	    $_SESSION['session-admin'] = $rowInit[8];
	}
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

      <?php $profile_button = "Profile Page"; ?>
      <?php $profile_url = "profile.php"; ?>
      <?php $host_url = "new_project.php"; ?>

      <?php 
      if (!isset($_SESSION['email'])) {
        $host_url = "login.php";
      } else {
        $host_url = "new_project.php";
      }
      ?>

      <!-- Display Login name -->
    <?php if (isset($_SESSION['email'])) { ?>
      <?php $isAdmin = $_SESSION['email']; ?>
      <?php $log_button = "Log Out"; ?>
      <?php $log_url = "logout.php"; ?>
      <?php $login_query = "SELECT p.firstname, p.lastname, p.admin FROM person p WHERE p.email='$isAdmin'"; ?>
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
          <a href="<?php echo $profile_url ?>"><?php echo $profile_button ?></a></li>
      </ul>
    </div>
  </div>
</nav>
<!--nav bar ends here-->
<div class = "container">
	<div class = "row"> 
		<?php
			if ($email == "") {
				echo "<h3> Account does not exist!</h3>";
			}
		?>
					
		<form>
			<table class = "table">
			<colgroup>
				<col width="40%">
				<col width="60%">
			</colgroup>

				<tr>
					<td><b>Email: </b></td>
					<td>
						<input class = "form-control" type = "email" name = "person-email" value = 
						<?php echo "\"".$email."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>First Name: </b></td>
					<td>
						<input class = "form-control" type = "text" name = "person-firstname" value = 
						<?php echo "\"".$cfirstname."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>Last Name: </b></td>
					<td>
						<input class = "form-control" type = "text" name = "person-lastname" value = 
						<?php echo "\"".$clastname."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>Password: </b></td>
					<td>
						<input class = "form-control" type = "text" name = "person-password" value = 
						<?php echo "\"".$password."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>Sex: </b></td>
					<td>
						<?php 
						if ($sex == "M") {
							echo "<input type = \"radio\" name = \"person-sex\" value = \"M\" checked> Male ";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"F\"> Female ";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"O\"> Other ";
						} else if ($sex == "F") {
							echo "<input type = \"radio\" name = \"person-sex\" value = \"M\"> Male ";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"F\" checked> Female ";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"O\"> Other ";
						} else {
							echo "<input type = \"radio\" name = \"person-sex\" value = \"M\"> M<br>";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"F\"> F<br>";
							echo "<input type = \"radio\" name = \"person-sex\" value = \"O\" checked> O<br>";
						}
						?>
					</td>
				</tr>
				<tr>
					<td><b>Address: </b></td>
					<td>
						<input class = "form-control" type = "text" name = "person-address" value = 
						<?php echo "\"".$address."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>Date Registered: </b></td>
					<td>
						<?php
						$datearray = explode("-", $registerdate);
						$temp = $datearray[2] . "/" . $datearray[1] . "/" . $datearray[0];
						$temp = str_replace("/0", "/", $registerdate);
						$temp = ltrim($temp, '0');
									    echo "<p>" . $temp . "</p>"; #start
									    ?>
					</td>
				</tr>
				<tr>
					<td><b>Phone Number: </b></td>
					<td>
						<input class = "form-control" type = "number" name = "person-phone" value = 
						<?php echo "\"".$phone."\""; ?>>
					</td>
				</tr>
				<tr>
					<td><b>Admin: </b></td>
					<td>
						<?php 
						if ($admin == "Y") {
							echo "<input type = \"radio\" name = \"person-admin\" value = \"Y\" checked> Yes ";
							echo "<input type = \"radio\" name = \"person-admin\" value = \"N\"> No";
						} else {
							echo "<input type = \"radio\" name = \"person-admin\" value = \"Y\"> Yes ";
							echo "<input type = \"radio\" name = \"person-admin\" value = \"N\" checked> No ";
						}
						?>
					</td>
				</tr>
			</table>
			<div style="text-align: center;">
				<input type="submit" value="Apply Changes" class="button btn btn-default" name="edit-account-submit">
			</div>
			</form>
			<?php
				if ($email != "") {
					if(isset($_GET['edit-account-submit'])) {
						if ($_SESSION['success']) {
							echo "<h3> Changes successful!</h3>";
						} else {
							echo "<h3> No Changes Made!</h3>";
						}
					}
				}
			?>
		</div> <!-- end of row-->
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
            <p class="pull-left"> Copyright © 2016 Uptown Fund Pte. Ltd. All rights reserved. </p>
        </div>
    </div>
    <!--/.footer-bottom--> 
</footer>
<!--end of footer-->

</body>
</html>