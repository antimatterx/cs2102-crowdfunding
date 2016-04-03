<?php session_start();?>

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

$isAdmin = $_SESSION['email'];

$sql = "SELECT p.admin FROM person p WHERE p.email = '" . $isAdmin . "';";

// echo "<br><br><br><br><h1>" . $sql . "</h1>";
$result = pg_query($sql) or die("Query failed: " . pg_last_error());

$isAdmin = pg_fetch_array($result);
$isAdmin = $isAdmin['admin'];
$isAdmin = ($isAdmin == "Y");

if (!$isAdmin) {
	echo "<script type='text/javascript'>";
	echo " $(function(){
	window.location.href='index.php';
	});";
echo "</script>";      
}

if(isset($_GET['id'])) {
	$_SESSION['session-ID'] = $_GET['id'];
}
$curr_id = $_SESSION['session-ID'];

if (isset($_GET['delete-project-submit'])) { #PROJECT DELETION
	$sql = "DELETE FROM project 
	WHERE id = ". $curr_id;

	// echo "<br><br><h1>" . $sql . "</h1><br>";
	pg_query($sql) or die('Query Failed: ' . pg_last_error());

	$ID = "";
	$title = "";//$_SESSION['session-title'];
	$description = "";//$_SESSION['session-description'];
	$country = "";//$_SESSION['session-country'];
	$start = "";//$_SESSION['session-start'];
	$expiry = "";//$_SESSION['session-expiry'];
	$target = "";//$_SESSION['session-target'];
	$status = "";//$_SESSION['session-status'];

} else if (isset($_GET['edit-project-submit'])) { #PROJECT EDIT
	
	$titleSuccess = ($_GET['project-title'] != $_SESSION['session-title']);
	$descriptionSuccess = ($_GET['project-description'] != $_SESSION['session-description']);
	$temp1 = str_replace("-0", "-", $_SESSION['session-start']); 
	$temp2 = str_replace("-0", "-", ($_GET['project-start-Y']."-".$_GET['project-start-M']."-".$_GET['project-start-D'])); 
	$startSuccess = ($temp1!=$temp2);
	$countrySuccess = ($_GET['project-country'] != $_SESSION['session-country']);
	$temp1 = str_replace("-0", "-", $_SESSION['session-expiry']); 
	$temp2 = str_replace("-0", "-", ($_GET['project-expiry-Y']."-".$_GET['project-expiry-M']."-".$_GET['project-expiry-D'])); 
	$expirySuccess = ($temp1!=$temp2);
	$statusSuccess = ($_GET['project-status'] != $_SESSION['session-status']);
	$targetSuccess = ($_GET['project-target'] != $_SESSION['session-target']);
	$categorySuccess = false;

	

	$list = $_GET['project-category'];
	
	if ($_GET['project-title'] == "") {
		$title = $_SESSION['session-title'];
		$titleSuccess = false;
	} else {
		$title = $_GET['project-title'];
	}

	$description = $_GET['project-description'];
	if ($description == "") {
		$description = "NULL";
	} else {
		$description = "'" . $description . "'";
	}

	if ($_GET['project-country'] == "") {
		$country = $_SESSION['session-country'];
		$countrySuccess = false;
	} else {
		$country = $_GET['project-country'];
	}
	
	if (!is_numeric($_GET['project-start-Y'])) {
		$start = $_SESSION['session-start'];
		$startSuccess = false;
	} else {
		$start = $_GET['project-start-Y'] . "-" . $_GET['project-start-M'] . "-" . $_GET['project-start-D'];
	}

	if (!is_numeric($_GET['project-expiry-Y'])) {
		$expiry = $_SESSION['session-expiry'];
		$expirySuccess = false;
	} else {
		$expiry = $_GET['project-expiry-Y'] . "-" . $_GET['project-expiry-M'] . "-" . $_GET['project-expiry-D'];
	}


	if (strcmp($start, $expiry) >= 0) {
		$start = $_SESSION['session-start'];
		$expiry = $_SESSION['session-expiry'];
		$startSuccess = false;
		$expirySuccess = false;
	}

	if (!(is_numeric($_GET['project-target']))) {
		$target = $_SESSION['session-target'];
		$targetSuccess = false;
	} else {
		$target = $_GET['project-target'];
	}

	if ($_GET['project-status'] != "ongoing" && $_GET['project-status'] != "closed") {
		$status = $_SESSION['session-status'];
		$statusSuccess = false;
	}  else {
		$status = $_GET['project-status'];
	}
	
	if (sizeof($list) > 0) {
		$sql = "SELECT h.tag FROM has_category h WHERE h.id = ".$curr_id;
		$result = pg_query($sql) or die("Query Failed: " . pg_last_error());
		
		$cats = array();
		while($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			foreach ($line as $key) {
				array_push($cats, $key);
			}
		}

		// echo "<br><br><br><br><h1>" . sizeof(array_diff($cats, $list)) . sizeof(array_diff($list, $cats)) . "</h1><br>";

		if (sizeof(array_diff($cats, $list)) != 0 or sizeof(array_diff($list, $cats)) != 0) {
			$categorySuccess = true;
		}


		$sql = "DELETE FROM has_category WHERE id = ".$curr_id.";";
		pg_query($sql) or die('Query failed: ' . pg_last_error());

		foreach($list as $elem) {
			$sql = "INSERT INTO has_category (id, tag) VALUES (" . $curr_id . ", '" . $elem . "');";
			pg_query($sql) or die('Query failed: ' . pg_last_error());
		}
	}

	if ($titleSuccess or $descriptionSuccess or $startSuccess or $countrySuccess or $expirySuccess or $statusSuccess or $targetSuccess or $categorySuccess) {
		$_SESSION['success'] = true;
	} else {
		$_SESSION['success'] = false;
	}

	// echo "<br><br><br><br><h1>" .
	// "T" . $_SESSION['success'].  
	// "a" . $titleSuccess . 
	// "b" . $descriptionSuccess . 
	// "c" . $startSuccess . 
	// "d" . $countrySuccess . 
	// "e" . $expirySuccess . 
	// "f" . $targetSuccess . 
	// "g" . $categorySuccess . 
	// "h" . $statusSuccess ."</h1><br>";


	$sql = "UPDATE project 
	SET title = '" . $title . "', 
	description = " . $description . ", 
	country = '" . $country . "', 
	start = '" . $start . "', 
	expiry = '" . $expiry . "', 
	status = '" . $status . "', 
	target = '" . $target . "' 
	WHERE id = " . $curr_id;

	// echo "<br><br><h1>" . $sql . "</h1><br>";
	pg_query($sql) or die('Query failed: ' . pg_last_error());
}


$sql = "SELECT p.id AS ID, 
    p.title AS Title,
    c.firstname AS FirstName,
    c.lastname AS LastName,
    p.description AS Description,
    p.start AS Start,
    p.expiry AS Expiry,
    p.country AS Country,
    p.target AS Target,
    p.status AS Status,
    p.creator AS Email
    FROM project p, person c
    WHERE c.email = p.creator
    AND p.id = ".$curr_id."
    GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status";

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

	echo"<br><br><br><br><br>";


	$resultInit = pg_query($dbcon, $sql) or die("Query Failed: " . pg_last_error());
	if (!$resultInit) {
	    echo "<h1> Nothing found </h1>";
	}
	else {
	    $rowInit = pg_fetch_row($resultInit);

	    $ID = $rowInit[0];
	    $title  = $rowInit[1];
	    $firstname = $rowInit[2];
	    $lastname = $rowInit[3];
	    $description = $rowInit[4];
	    $start = $rowInit[5];
	    $expiry = $rowInit[6];
	    $country = $rowInit[7];
	    $target = $rowInit[8];
	    $status = $rowInit[9];
	    $email = $rowInit[10];

	    $_SESSION['session-title']  = $rowInit[1];
	    $_SESSION['session-firstname'] = $rowInit[2];
	    $_SESSION['session-lastname'] = $rowInit[3];
	    $_SESSION['session-description'] = $rowInit[4];
	    $_SESSION['session-start'] = $rowInit[5];
	    $_SESSION['session-expiry'] = $rowInit[6];
	    $_SESSION['session-country'] = $rowInit[7];
	    $_SESSION['session-target'] = $rowInit[8];
	    $_SESSION['session-status'] = $rowInit[9];
	}
?>

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

<!--body content start here-->
<div class = "container">
	<div class="row">

		<!--image below-->
		<div class = "col-md-3 col-xs-12">
			<?php
			if ($ID != "") { 
				$query = "SELECT i.data FROM image i WHERE i.id = ".$ID.";";

				$result = pg_query($query) or die('Query failed: ' . pg_last_error());

				echo "<img src=$file_name class=\"alignleft post-image\" alt=\"Image Not Found\" style='max-width: 370px;'/>";
			}
			?>
		</div>
		<!--image above-->

			<div class = "col-md-offset-1 col-md-6"> 
			<?php
				if ($ID == "" and !isset($_GET['delete-project-submit'])) {
					echo "<h3> Project does not exist!</h3>";
				}
			?>
			<form>
				<table class="table">
					<col width="30%">
					<col width="70%">
					<tr>
						<th><b>ID: </b></th>
						<td>
							<p><?php echo $ID; ?></p>
						</td>
					</tr>
							<th><b>Title: </b></th>
						<td>
							<input class = "form-control" type = "text" name = "project-title" value = 
							<?php echo "\"".$title."\""; ?>>
						</td>
					</tr>
					<tr>
							<th><b>Creator: </b></th>
						<td>
							<?php
							echo"<p><a href = \"person_admin.php?id=".$email."\">".$firstname . " " . $lastname."</a></p>";
							?>
						</td>
					</tr>
					<tr>
							<th><b>Description: </b></th>
						<td>
							<input class = "form-control" type = "text" name = "project-description" value = 
							<?php echo "\"".$description."\""; ?>>
						</td>
					</tr>
					<tr>
							<th><b>Country: </b></th>
						<td>
							<select name = "project-country" class = "form-control" id = "project-country">
								<?php
								echo "<option value = \"".$country."\">".$country."</option>";
								$tempC = $country;

								$query = "SELECT p.country FROM project p GROUP BY p.country ORDER BY p.country ASC;";

								$result = pg_query($query) or die('Query failed: ' . pg_last_error());

								while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
									foreach ($line as $col_value) { 
										if($col_value != $tempC) {
											echo"<option value = \"".$col_value."\">".$col_value."</option>";
										}
									}
								}
								pg_free_result($result);
								?>
							</select>
						</td>
					</tr>
					<tr>
							<th><b>Categories: </b></th>
						<td>
							<?php
							$q = "SELECT h.tag 
							FROM has_category h 
							WHERE h.id = ".$curr_id."
							ORDER BY h.id ASC;";

							$res = pg_query($q) or die('Query Failed: ' . pg_last_error());

							$q = "SELECT c.name
							FROM category c 
							ORDER BY c.name ASC;";

							$res2 = pg_query($q) or die('Query Failed: ' . pg_last_error());

							$line = array();
							while ($temp = pg_fetch_array($res, null, PGSQL_ASSOC)) {
								foreach($temp as $x) {
									array_push($line, $x);
								}
							}

							while($cats = pg_fetch_array($res2, null, PGSQL_ASSOC)) {
								foreach($cats as $cat) {
									$isFound = 0;
									foreach($line as $col_value) {
										if ($col_value == $cat) {
											$isFound = 1;
											break;
										}
									}

									if ($isFound == 1) {
										echo "<input type = \"checkbox\" name = \"project-category[]\" value = \"".$cat."\" checked>".$cat."<br>";
									} else {
										echo "<input type = \"checkbox\" name = \"project-category[]\" value = \"".$cat."\">".$cat."<br>";
									}
								}
							}

							pg_free_result($res);
							pg_free_result($res2);
							?>
						</td>
					</tr>
					<tr>

						<th><b>Start Date: </b></th>

						<td>
						<div class = "row">
						<div class = "col-md-4">
							<select name = "project-start-D" class = "form-control" id = "project-start-D">
								<?php
								$date = explode("-", $start);
								$year = $date[0];
								$month = $date[1];
								$day = $date[2];

								echo "<option value = \"".$day."\">".$day."</option>";

								$num = 1;
								while($num <= 31) {
									echo "<option value = \"".$num."\">".$num."</option>";
									$num = $num + 1;
								}
								?>
							</select>
							</div>
							<div class = "col-md-4">
							<select name = "project-start-M" class = "form-control" id = "project-start-M">
								<?php
								if ($month == "1") {
									echo "<option value = \"1\">Jan</option>";
								} else if ($month == "2") {
									echo "<option value = \"2\">Feb</option>";
								} else if ($month == "3") {
									echo "<option value = \"3\">Mar</option>";
								} else if ($month == "4") {
									echo "<option value = \"4\">Apr</option>";
								} else if ($month == "5") {
									echo "<option value = \"5\">May</option>";
								} else if ($month == "6") {
									echo "<option value = \"6\">Jun</option>";
								} else if ($month == "7") {
									echo "<option value = \"7\">Jul</option>";
								} else if ($month == "8") {
									echo "<option value = \"8\">Aug</option>";
								} else if ($month == "9") {
									echo "<option value = \"9\">Sep</option>";
								} else if ($month == "10") {
									echo "<option value = \"10\">Oct</option>";
								} else if ($month == "11") {
									echo "<option value = \"11\">Nov</option>";
								} else if ($month == "12") {
									echo "<option value = \"12\">Dec</option>";
								} 
								?>
								<option value = "1">Jan</option>
								<option value = "2">Feb</option>
								<option value = "3">Mar</option>
								<option value = "4">Apr</option>
								<option value = "5">May</option>
								<option value = "6">Jun</option>
								<option value = "7">Jul</option>
								<option value = "8">Aug</option>
								<option value = "9">Sep</option>
								<option value = "10">Oct</option>
								<option value = "11">Nov</option>
								<option value = "12">Dec</option>
							</select>
							</div>
							<div class = "col-md-4">
							<input type = "number" placeholder = "YYYY" class = "form-control" name = "project-start-Y" id = "project-start-Y" min = "1900" value = <?php echo $year; ?>>
							</div>
						</div>
						</td>
					</tr>
					<tr>

						<th style = "text-align:left;"><b>Expiry Date: </b></th>

						<td>
						<div class = "row">
						<div class = "col-md-4">
							<select name = "project-expiry-D" class = "form-control" id = "project-expiry-D">
								<?php
								$date = explode("-", $expiry);
								$year = $date[0];
								$month = $date[1];
								$day = $date[2];

								echo "<option value = \"".$day."\">".$day."</option>";

								$num = 1;
								while($num <= 31) {
									echo "<option value = \"".$num."\">".$num."</option>";
									$num = $num + 1;
								}
								?>
							</select>
							</div>
							<div class = "col-md-4">
							<select name = "project-expiry-M" class = "form-control" id = "project-expiry-M">
								<?php
								if ($month == "1") {
									echo "<option value = \"1\">Jan</option>";
								} else if ($month == "2") {
									echo "<option value = \"2\">Feb</option>";
								} else if ($month == "3") {
									echo "<option value = \"3\">Mar</option>";
								} else if ($month == "4") {
									echo "<option value = \"4\">Apr</option>";
								} else if ($month == "5") {
									echo "<option value = \"5\">May</option>";
								} else if ($month == "6") {
									echo "<option value = \"6\">Jun</option>";
								} else if ($month == "7") {
									echo "<option value = \"7\">Jul</option>";
								} else if ($month == "8") {
									echo "<option value = \"8\">Aug</option>";
								} else if ($month == "9") {
									echo "<option value = \"9\">Sep</option>";
								} else if ($month == "10") {
									echo "<option value = \"10\">Oct</option>";
								} else if ($month == "11") {
									echo "<option value = \"11\">Nov</option>";
								} else if ($month == "12") {
									echo "<option value = \"12\">Dec/option>";
								} 
								?>
								<option value = "1">Jan</option>
								<option value = "2">Feb</option>
								<option value = "3">Mar</option>
								<option value = "4">Apr</option>
								<option value = "5">May</option>
								<option value = "6">Jun</option>
								<option value = "7">Jul</option>
								<option value = "8">Aug</option>
								<option value = "9">Sep</option>
								<option value = "10">Oct</option>
								<option value = "11">Nov</option>
								<option value = "12">Dec</option>
							</select>
							</div>
							<div class = "col-md-4">
							<input type = "number" placeholder = "YYYY" class = "form-control" name = "project-expiry-Y" id = "project-expiry-Y" min = "1900" value = <?php echo $year; ?>>
							</div>
							</div>
						</td>
					</tr>
					<tr>

						<th style = "text-align:left;"><b>Contributions: </b></th>

						<td>
							<?php
							$q = "SELECT SUM(d.amount) FROM donation d WHERE d.project = ".$curr_id.";";
							$res = pg_query($q) or die('Query Failed: ' . pg_last_error());

							while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
								foreach ($line as $col_value) {
									if ($col_value == "") {
										$col_value = "0";
									} 
									echo"US$".$col_value.".00";
								}
							}
							pg_free_result($res);
							?>
						</td>
					</tr>
					<tr>

						<th style = "text-align:left;"><b>Target: </b></th>

						<td>
							<p>US$<input class = "form-control" type = "number" name = "project-target" value = <?php echo $target;  ?>>
							</p>
						</td>
					</tr>
					<tr>

						<th style = "text-align:left;"><b>Status: </b></th>

						<td>
							<?php 
							if ($status == "ongoing") {
								echo "<input type = \"radio\" name = \"project-status\" value = \"ongoing\" checked> Ongoing ";
								echo "<input type = \"radio\" name = \"project-status\" value = \"closed\"> Closed ";
							} else {
								echo "<input type = \"radio\" name = \"project-status\" value = \"ongoing\"> Ongoing ";
								echo "<input type = \"radio\" name = \"project-status\" value = \"closed\" checked> Closed";
							}
							?>
						</td>
					</tr>
				</table>
				<?php
					if ($ID == "" and isset($_GET['delete-project-submit'])) {
						echo "<h3> Project has been successfully deleted!</h3>";
					} else {
						if(isset($_GET['edit-project-submit'])) {
							if ($_SESSION['success']) {
								echo "<h3> Changes successful!</h3>";
							} else {
								echo "<h3> No Changes Made!</h3>";
							}
						}
					}
				?>
				<input type="submit" value="Apply Changes" class="button btn btn-default" name="edit-project-submit">
				<input style = "background-color:"type="submit" value="Delete Project" class="button btn btn-default" name="delete-project-submit">
			</form>
		</div> <!-- end of col-mid-6-->
</div><!-- end .wrap -->
</div>
<!--body content end here-->


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