<?php session_start();?>

<!DOCTYPE html>

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

	if(isset($_GET['id'])) {
		$_SESSION['session-ID'] = $_GET['id'];
	} 
	// echo "<h3> B " . $_SESSION['session-ID'] . "</h3>";
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
	
	if ($_GET['person-email'] == "") {
		$email = $curr_id;
		$emailSuccess = false;
	} else {
		$email = $_GET['person-email'];
	}

	if ($_GET['person-firstname'] == "") {
		$firstname = $_SESSION['session-firstname'];
		$fnameSuccess = false;
	} else {
		$firstname = $_GET['person-firstname'];
	}

	$lastname = $_GET['person-lastname'];
	if ($lastname == "") {
		$lastname = "NULL";
	} else {
		$lastname = "'" . $lastname . "'";
	}

	if ($_GET['person-password'] == "") {
		$password = $_SESSION['session-password'];
		$passwordSuccess = false;
	} else {
		$password = $_GET['person-password'];
	}
	
	if ($_GET['person-sex'] != "M" and $_GET['person-sex'] != "F" and $_GET['person-sex'] != "O") {
		$sex = $_SESSION['session-sex'];
		$sexSuccess = false;
	} else {
		$sex = $_GET['person-sex'];
	}

	$address = $_GET['person-address'];
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


	$sql = "UPDATE person 
	SET email = '" . $email . "',
	firstname = '" . $firstname . "', 
	lastname = " . $lastname . ", 
	password = '" . $password . "', 
	sex = '" . $sex . "', 
	address = " . $address . ", 
	phone = " . $phone . ", 
	admin = '" . $admin . "' 
	WHERE email = '" . $curr_id .  "';";

	$_SESSION['session-ID'] = $email;
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
    GROUP BY p.email, p.firstname, p.lastname, p.password, p.sex, p.register_date, p.address, p.phone, p.admin
    ORDER BY p.email ASC;";

	// echo"<br><br><br><br><br><h1>" . $sql . "</h1>";


	$resultInit = pg_query($dbcon, $sql) or die("Query Failed: " . pg_last_error());
	if (!$resultInit) {
	    echo "<h1> Nothing found </h1>";
	}
	else {
	    $rowInit = pg_fetch_row($resultInit);

	    $email =  $rowInit[0]; 
	    $firstname = $rowInit[1];
	    $lastname =  $rowInit[2];
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

<body class="home blog header-full-width full-width-content">
	<div id="header">
		<div class="site-header">
		  <h1 class="site-header-logo-container">
		    <a>Logo</span>
		      <img src="images/logo.png" width="100%" id="bigg-logo" alt="Bigg" />
		    </a>
		  </h1>

			<ul id="page-nav" class="horizontal-list">
				<li class="page-nav-top-posts active"><a href="index.php" id="feature-scroll" class="page-anchor-link">Home</a></li>
				<li class="page-nav-popular-posts"><a href="index.php#countries" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>
				<li class="page-nav-top-posts active"><a href="index.php#categories" id="category-scroll" class="page-anchor-link">Categories</a></li>
				<li class="page-nav-popular-posts"><a href="index.php#countries" id="Countries-scroll" class="page-anchor-link">Countries</a></li>
				<li class="page-nav-top-posts active"><a href="search.php" id="feature-scroll" class="page-anchor-link">Search</a></li>
			</ul>

			<div id="site-nav" class="horizontal-list">
				<div class="menu-main-menu-container">
				<ul id="menu-main-menu" class="menu">
					<li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="/">Sign Up</a></li>
					<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="sample-page.htm">Log In</a></li>
					<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="sample-page.htm">Host Project</a></li>
				</ul>
				</div>
			</div><!-- #site-nav -->

			<div id="site-header-bigg-social">
			</div>  
		</div>
	</div>

	<div id="wrap">
	    <div id="inner">
			<div class="wrap">
				<div id="content-sidebar-wrap">
						
					<!-- INSERT CONTENT HERE -->
					<br><br><br>	
					<?php
						if ($email == "") {
							echo "<h3> Account does not exist!</h3>";
						} else { 
							if(isset($_GET['edit-account-submit'])) {
								if ($_SESSION['success']) {
									echo "<h3> Changes successful!</h3>";
								} else {
									echo "<h3> No Changes Made!</h3>";
								}
							}
						}
					?>

					<br>

					<div class = "sixcol"> <form>
						<table border = "0">
							<col width=\"40%\">
					        <col width=\"60%\">
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Email: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "person-email" value = 
				        			<?php echo "\"".$email."\""; ?>>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>First Name: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "person-firstname" value = 
				        			<?php echo "\"".$firstname."\""; ?>>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Last Name: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "person-lastname" value = 
				        			<?php echo "\"".$lastname."\""; ?>>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Password: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "person-password" value = 
				        			<?php echo "\"".$password."\""; ?>>
			        			</td>
		        			</tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Sex: </b></th>
				        		</td>
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
		        				<td>
		        					<th style = "text-align:left;"><b>Address: </b></th>
		        				</td>
		        				<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "person-address" value = 
				        			<?php echo "\"".$address."\""; ?>>
								</td>
		        			</tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Date Registered: </b></th>
					        	</td>
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
					        	<td>
					        		<th style = "text-align:left;"><b>Phone Number: </b></th>
				        		</td>
				        		<td>
					        		<input style = "width:335px; text-align:left;" type = "text" name = "person-phone" value = 
				        			<?php echo "\"".$phone."\""; ?>>
								</td>
							</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Admin: </b></th>
				        		</td>
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
				        <input type="submit" value="Apply Changes" class="button" name="edit-account-submit">
				    </form>
				    </div> <!-- end of sixcol-->
				</div><!-- end #content-sidebar-wrap -->
			</div><!-- end .wrap -->
	    </div><!-- end #inner --> 
		<div id="bigg-footer">
			<div class="wrap">
				<div class="twocol">
					<div id="text-2" class="widget widget_text">
						<div class="widget-wrap">
							<h5 class="widgettitle">Company</h5>			
							<div class="textwidget">
								<ul class="plain-list">
									<li><a href="#">About</a></li>
									<li><a href="#">Jobs</a></li>
									<li><a href="#">Contact</a></li>
									<li><a href="#">Terms</a></li>
									<li><a href="#">Privacy</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			    <div class="twocol">
				    <div id="text-3" class="widget widget_text">
						<div class="widget-wrap"><h5 class="widgettitle">Community</h5>			
							<div class="textwidget">
								<ul class="plain-list">
									<li><a href="#">Blog</a></li>
									<li><a href="#">Twitter</a></li>
									<li><a href="#">Facebook</a></li>
									<li><a href="#">Help</a></li>
								</ul>
							</div>
						</div>
				    </div>
				</div>
				<div class="fourcol">
					<div id="text-4" class="widget widget_text">
						<div class="widget-wrap"><h5 class="widgettitle"></h5>			
							<div class="textwidget"><p></p>
								<div>
								</div>
							</div>
						 </div>
					</div>
				</div>
				<div class="fourcol last">
					<div id="text-4" class="widget widget_text">
						<div class="widget-wrap"><h5 class="widgettitle">Subscribe to the newsletter</h5>			
							<div class="textwidget"><p>Get news of the latest inventions in your inbox</p>
								<div>
									<input type="text" placeholder="Enter your email address" name="email" class="form-field" id="newsletter-email-input">
									<input type="button" value="Submit" class="button" id="newsletter-email-submit-btn">
								</div>
							<p class="legalese"> 
							Opt-out anytime with one click and we'll never share your information.</p>
							</div>
						</div>
					</div>
				</div>
			</div><!-- end #wrap -->
		</div>
	</div>
</body>
</html>