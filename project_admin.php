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
$curr_id = $_SESSION['session-ID'];

if (isset($_GET['delete-project-submit'])) { #PROJECT DELETION
	$sql = "DELETE FROM has_category 
	WHERE id = " . $curr_id . "; DELETE FROM donation 
	WHERE project = " . $curr_id . "; DELETE FROM image 
	WHERE id = ". $curr_id . "; DELETE FROM project 
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
	WHERE id = " . $curr_id .  ";";

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
    p.status AS Status
    FROM project p, person c
    WHERE c.email = p.creator
    AND p.id = ".$curr_id."
    GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status
    ORDER BY p.id;";

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
				<li class="page-nav-top-posts active"><a href="javascript:void(0)" id="feature-scroll" class="page-anchor-link">Home</a></li>
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
					<?php
						if ($ID == "") {
							if(isset($_GET['delete-project-submit'])) {
								echo "<h3> Project has been successfully deleted!</h3>";
							} else {
								echo "<h3> Project does not exist!</h3>";
							}
						} else { 
							if(isset($_GET['edit-project-submit'])) {
								if ($_SESSION['success']) {
									echo "<h3> Changes successful!</h3>";
								} else {
									echo "<h3> No Changes Made!</h3>";
								}
							}
							$query = "SELECT i.data FROM image i WHERE i.id = ".$ID.";";

							$result = pg_query($query) or die('Query failed: ' . pg_last_error());

							echo "<img style=\"text-align:center;\" width=\"330\" height=\"175\" src=\"images/".$data.".jpg\" class=\"alignleft post-image\" alt=\"Image Not Found\" />";
						}
					?>

					<br><br>

					<div class = "sixcol"> <form>
						<table border = "0">
							<col width=\"30%\">
					        <col width=\"75%\">
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>ID: </b></th>
				        		</td>
				        		<td>
				        			<p><?php echo $ID; ?></p>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Title: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "project-title" value = 
				        			<?php echo "\"".$title."\""; ?>>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Creator: </b></th>
				        		</td>
				        		<td>
				        			<p><?php echo $firstname . " " . $lastname;?></p>
			        			</td>
		        			</tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Description: </b></th>
				        		</td>
				        		<td>
				        			<input style = "width:335px; text-align:left;" type = "text" name = "project-description" value = 
				        			<?php echo "\"".$description."\""; ?>>
			        			</td>
		        			</tr>
		        			<tr>
		        				<td>
		        					<th style = "text-align:left;"><b>Country: </b></th>
		        				</td>
		        				<td>
				        			<select name = "project-country" style = "width:340px;" id = "project-country">
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
					        	<td>
					        		<th style = "text-align:left;"><b>Categories: </b></th>
				        		</td>
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
					        	<td>
					        		<th style = "text-align:left;"><b>Start Date: </b></th>
					        	</td>
					        	<td>
							        <select name = "project-start-D" style = "width:44px;" id = "project-start-D">
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
							       	<select name = "project-start-M" style = "width:50px;" id = "project-start-M">
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
									<input type = "number" placeholder = "YYYY" style = "width:57px;" name = "project-start-Y" id = "project-start-Y" min = "1900" value = <?php echo $year; ?>>
       							</td>
					        </tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Expiry Date: </b></th>
					        	</td>
					        	<td>
							        <select name = "project-expiry-D" style = "width:44px;" id = "project-expiry-D">
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
							       	<select name = "project-expiry-M" style = "width:50px;" id = "project-expiry-M">
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
									<input type = "number" placeholder = "YYYY" style = "width:57px;" name = "project-expiry-Y" id = "project-expiry-Y" min = "1900" value = <?php echo $year; ?>>
       							</td>
					        </tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Contributions: </b></th>
				        		</td>
				        		<td>
					        		<?php
								        $q = "SELECT SUM(d.amount) FROM donation d WHERE d.project = ".$curr_id.";";
										$res = pg_query($q) or die('Query Failed: ' . pg_last_error());

										while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
										foreach ($line as $col_value) {
											if ($col_value == "") {
												$col_value = "0";
											} 
											echo"$".$col_value.".00";
											}
										}
										pg_free_result($res);
									?>
								</td>
							</tr>
					        <tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Target: </b></th>
				        		</td>
				        		<td>
				        			<p>$<input style = "width:327px; text-align:left;" type = "number" name = "project-target" value = <?php echo $target;  ?>>
			        				</p>
			        			</td>
		        			</tr>
		        			<tr>
					        	<td>
					        		<th style = "text-align:left;"><b>Status: </b></th>
				        		</td>
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
				        <input type="submit" value="Apply Changes" class="button" name="edit-project-submit">
				        <input style = "background-color:"type="submit" value="Delete Project" class="button" name="delete-project-submit">
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