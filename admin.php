<?php session_start(); ?>

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

<?php 
  $isAdmin = $_SESSION['email'];

  $sql = "SELECT p.admin FROM person p WHERE p.email = '" . $isAdmin . "';";

  // echo "<br><br><br><br><h1>" . $sql . "</h1>";
  $result = pg_query($sql) or die("Query failed: " . pg_last_error());

  $isAdmin = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  $isAdmin = $isAdmin['admin'];
  $isAdmin = ($isAdmin == "Y");

  if (!$isAdmin) {
    echo "<script type='text/javascript'>";
    echo " $(function(){
    window.location.href='index.php';
    });";
    echo "</script>";      
  }
?>


<?php session_start(); ?>
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

      <?php $profile_button = "Profile Page"; ?>
      <?php $profile_url = "profile.php"; ?>
      <?php $host_url = "new_project.php"; ?>
      
      <!-- Check if Logged in -->
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

<!-- startsearch -->
<div class = "container">
<div class = "row">
  <form>
  <table class = "table">
    <tr>
      <td><b>Project Title </b></td>
      <td><input class = "form-control" type = "text" name = "project-title" id = "project-title" value = <?php if (isset($_GET['project-title'])) echo $_GET['project-title']; ?>></td>
    </tr>
    <tr>
      <td><b>Project ID </b></td>
      <td><input class = "form-control" type = "number" name = "project-ID" id = "project-ID" value = <?php if (isset($_GET['project-ID'])) echo $_GET['project-ID']; ?>></td>
    </tr>
    <tr>
      <td><b>Creator's First Name </b></td>
      <td><input class = "form-control" type = "text" name = "project-firstname" id = "project-firstname" value = <?php if (isset($_GET['project-firstname'])) echo $_GET['project-firstname']; ?>></td>
    </tr>
    <tr>
      <td><b>Creator's Last Name </b></td>
      <td><input class = "form-control" type = "text" name = "project-lastname" id = "project-lastname" value = <?php if (isset($_GET['project-lastname'])) echo $_GET['project-lastname']; ?>></td>
    </tr>
    <tr>
      <td><b>Category </b></td>
      <td>
      <?php
        $list = $_GET['project-category'];

        $q = "SELECT c.name
            FROM category c 
            ORDER BY c.name ASC;";

        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());

        while($cats = pg_fetch_array($res, null, PGSQL_ASSOC)) {
          foreach($cats as $cat) {
            $isFound = false;
            foreach($_GET['project-category'] as $col_value) {
              if ($col_value == $cat) {
                $isFound = true;
                break;
              }
            }
            
            if ($isFound) {
              echo "<input type = \"checkbox\" name = \"project-category[]\" value = \"".$cat."\" checked>".$cat."<br>";
            } else {
              echo "<input type = \"checkbox\" name = \"project-category[]\" value = \"".$cat."\">".$cat."<br>";
            }
          }
        }

        pg_free_result($res);
      ?>
        
      </td>
    </tr>
    <tr>
      <td><b>Country </b></td>
      <td>
        <select name = "project-country" class = "form-control" id = "project-country">
          <?php
            if (isset($_GET['project-country'])){
              echo "<option value = \"".$_GET['project-country']."\">".$_GET['project-country']."</option>";
              if ($_GET['project-country'] != "") {
                echo "<option value = \"\"></option>";
              } 
            } else { 
              echo "<option value = \"\"></option>";
            }

          
            $query = "SELECT p.country FROM project p GROUP BY p.country ORDER BY p.country ASC;";

            $result = pg_query($query) or die('Query failed: ' . pg_last_error());

            while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
              foreach ($line as $col_value) { 
                echo"<option value = \"".$col_value."\">".$col_value."</option>";
              }
            }
            pg_free_result($result);
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td><b>Project Start Date </b></td>
      <td>
        <div class = "row">
        <div class = "col-md-2">
        <select name = "project-start-D" class = "form-control" id = "project-start-D">
          <?php
            if (isset($_GET['project-start-D'])){
              if ($_GET['project-start-D'] == "-1") {
                echo "<option value = \"-1\">DD</option>";
              } else {
                echo "<option value = \"".$_GET['project-start-D']."\">".$_GET['project-start-D']."</option>";
                echo "<option value = \"-1\">DD</option>";
              }
            } else { 
              echo "<option value = \"-1\">DD</option>";
            }

            $num = 1;
            while($num <= 31) {
              echo "<option value = \"".$num."\">".$num."</option>";
              $num = $num + 1;
            }
          ?>
       </select>
       </div>
       <div class = "col-md-2">
       <select name = "project-start-M" class = "form-control" id = "project-start-M">
        <?php
          if (isset($_GET['project-start-M'])){
            if ($_GET['project-start-M'] == "-1") {
              echo "<option value = \"-1\">MM</option>";
            } else {
              if ($_GET['project-start-M'] == "1") {
                echo "<option value = \"1\">Jan</option>";
              } else if ($_GET['project-start-M'] == "2") {
                echo "<option value = \"2\">Jan</option>";
              } if ($_GET['project-start-M'] == "3") {
                echo "<option value = \"3\">Jan</option>";
              } if ($_GET['project-start-M'] == "4") {
                echo "<option value = \"4\">Jan</option>";
              } if ($_GET['project-start-M'] == "5") {
                echo "<option value = \"5\">Jan</option>";
              } if ($_GET['project-start-M'] == "6") {
                echo "<option value = \"6\">Jan</option>";
              } if ($_GET['project-start-M'] == "7") {
                echo "<option value = \"7\">Jan</option>";
              } if ($_GET['project-start-M'] == "8") {
                echo "<option value = \"8\">Jan</option>";
              } if ($_GET['project-start-M'] == "9") {
                echo "<option value = \"9\">Jan</option>";
              } if ($_GET['project-start-M'] == "10") {
                echo "<option value = \"10\">Jan</option>";
              } if ($_GET['project-start-M'] == "11") {
                echo "<option value = \"11\">Jan</option>";
              } if ($_GET['project-start-M'] == "12") {
                echo "<option value = \"12\">Jan</option>";
              } 
              echo "<option value = \"-1\">MM</option>";
            }
          } else { 
            echo "<option value = \"-1\">MM</option>";
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
       <div class = "col-md-2">
       <input type = "number" placeholder = "YYYY" class = "form-control" name = "project-start-Y" id = "project-start-Y" min = "1900" value = <?php if (isset($_GET['project-start-Y'])) echo $_GET['project-start-Y']; ?>></td>
       </div>
    </div>
    </tr>
    <tr>
      <td><b>Project Expiry </b></td>
      <td>
      <div class = "row">
      <div class = "col-md-2">
      <select name = "project-expiry-D" class = "form-control" id = "project-expiry-D">
          <?php
            if (isset($_GET['project-expiry-D'])){
              if ($_GET['project-expiry-D'] == "-1") {
                echo "<option value = \"-1\">DD</option>";
              } else {
                echo "<option value = \"".$_GET['project-expiry-D']."\">".$_GET['project-expiry-D']."</option>";
                echo "<option value = \"-1\">DD</option>";
              }
            } else { 
              echo "<option value = \"-1\">DD</option>";
            }

            $num = 1;
            while($num <= 31) {
              echo "<option value = \"".$num."\">".$num."</option>";
              $num = $num + 1;
            }
          ?>
       </select>
       </div>
       <div class = "col-md-2">
       <select name = "project-expiry-M" class = "form-control" id = "project-expiry-M">
        <?php
          if (isset($_GET['project-expiry-M'])){
            if ($_GET['project-expiry-M'] == "-1") {
              echo "<option value = \"-1\">MM</option>";
            } else {
              if ($_GET['project-expiry-M'] == "1") {
                echo "<option value = \"1\">Jan</option>";
              } else if ($_GET['project-expiry-M'] == "2") {
                echo "<option value = \"2\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "3") {
                echo "<option value = \"3\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "4") {
                echo "<option value = \"4\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "5") {
                echo "<option value = \"5\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "6") {
                echo "<option value = \"6\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "7") {
                echo "<option value = \"7\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "8") {
                echo "<option value = \"8\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "9") {
                echo "<option value = \"9\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "10") {
                echo "<option value = \"10\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "11") {
                echo "<option value = \"11\">Jan</option>";
              } if ($_GET['project-expiry-M'] == "12") {
                echo "<option value = \"12\">Jan</option>";
              } 
              echo "<option value = \"-1\">MM</option>";
            }
          } else { 
            echo "<option value = \"-1\">MM</option>";
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
       <div class = "col-md-2">
       <input type = "number" placeholder = "YYYY" class = "form-control" name = "project-expiry-Y" id = "project-expiry-Y" min = "1900" value = <?php if (isset($_GET['project-expiry-Y'])) echo $_GET['project-expiry-Y']; ?>></td>
       </div>
    </tr>
  </table>

  <div style = "text-align:center;"><input type="submit" value="Apply Filter" class="button btn btn-default" name="adv-search-submit-btn"></div>
  </form>
</div>
<!--   <h1>test35</h1><br> -->
  <?php
    
    $query1 = "SELECT p.email AS Email,
    p.firstname AS Firstname,
    p.lastname AS Lastname
    FROM person p
    ORDER BY p.firstname ASC, p.lastname";

    $query2 = "SELECT p.id AS ID,
          p.title AS Title,
          to_char(p.start, 'DD/MM/YYYY') AS Start,
          to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
          p.target AS Target,
          p.status AS Status,
          p.creator AS Email 
          FROM project p
          GROUP BY p.creator, p.id, p.title, p.start, p.expiry, p.target, p.status
          ORDER BY p.id";

    if(isset($_GET['adv-search-submit-btn']))  { #ADVANCED SEARCH
      $startDay = $_GET['project-start-D'];
      $expiryDay = $_GET['project-expiry-D'];
      $startMonth = $_GET['project-start-M'];
      $expiryMonth = $_GET['project-expiry-M'];
      $startYear = $_GET['project-start-Y'];
      $expiryYear = $_GET['project-expiry-Y'];
      
      if ($startYear == "") {
        if ($startDay == "-1" and $startMonth == "-1") {
          $startYear = "1900";
        } else {
          $startYear = date("Y");
        }
      }

      if ($expiryYear == "") {
        if ($expiryDay == "-1" and $expiryMonth == "-1") {
          $expiryYear = "9999";
        } else {
          $expiryYear = date("Y");
        }
      }

      if ($startMonth == "-1") {
        if ($startDay == "-1") {
          $startMonth = "1";
        } else {
          $startMonth = date("m");
        }
      }

      if ($expiryMonth == "-1") {
        if ($expiryDay == "-1") {
          $expiryMonth = "12";
        } else {
          $expiryMonth = date("m");
        }
      }

      if ($startDay == "-1") {
        $startDay = "1";
      }

      if ($expiryDay == "-1") {
        $expiryDay = "31";
      }

      $list = $_GET['project-category'];
      $category = "";
      foreach ($list as $key) {
        $category = $category . " AND '" . $key . "' in (SELECT h1.tag FROM has_category h1 WHERE h1.id = p.id)";
      }

      $project_title = $_GET['project-title'];
      $project_title = trim($project_title);
      $project_title = str_replace("'", "''", $project_title);

      $project_firstname = $_GET['project-firstname'];
      $project_firstname = trim($project_firstname);
      $project_firstname = str_replace("'", "''", $project_firstname);

      $project_lastname = $_GET['project-lastname'];
      $project_lastname = trim($project_lastname);
      $project_lastname = str_replace("'", "''", $project_lastname);


      if ($_GET['project-title'] == "" AND $_GET['project-ID'] == "" AND $_GET['project-country'] == "" AND $_GET['project-start-D'] == "-1" AND $_GET['project-start-M'] == "-1" AND $_GET['project-start-Y'] == "" AND $_GET['project-expiry-D'] == "-1" AND $_GET['project-expiry-M'] == "-1" AND $_GET['project-expiry-Y'] == "" AND sizeof($_GET['project-category']) == 0) {
          #get people with no projects that fit with the person filters
          $query1 = "SELECT 
            c.firstname AS Firstname,
            c.lastname AS Lastname,
            c.email AS Email
            FROM person c, project p, has_category h
            WHERE (LOWER(c.firstname) LIKE LOWER('%".$project_firstname."%')
            AND LOWER(c.lastname) LIKE LOWER('%".$project_lastname."%')) 
            OR (LOWER(c.firstname) LIKE LOWER('%".$project_firstname."%')
            AND LOWER(c.lastname) LIKE LOWER('%".$project_lastname."%')
            AND h.id = p.id"
            . $category .
            " AND c.email = p.creator
            AND LOWER(p.title) LIKE LOWER('%".$project_title."%')
            AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
            AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
            AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."')
            GROUP BY c.firstname, c.lastname, c.email
            ORDER BY c.firstname, c.lastname, c.email";

            // $query1  = "(" . $query1 . ") UNION (" . $query3. ")";
            // echo "<h1>" . $query1 . "</h1>";
      } else {
        $query1 = 
          "SELECT 
          c.firstname AS Firstname,
          c.lastname AS Lastname,
          c.email AS Email 
          FROM project p, person c, has_category h 
          WHERE 
          LOWER(c.firstname) LIKE LOWER('%".$project_firstname."%')
          AND LOWER(c.lastname) LIKE LOWER('%".$project_lastname."%')
          AND h.id = p.id"
          . $category .
          " AND c.email = p.creator
          AND CAST(p.id AS VARCHAR(31)) LIKE '%" . $_GET['project-ID'] . "%'
          AND LOWER(p.title) LIKE LOWER('%".$project_title."%')
          AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
          AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
          AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
          GROUP BY c.firstname, c.lastname, c.email
          ORDER BY c.firstname, c.lastname, c.email";

          // echo "<h1>'$query1'</h1>";
      }
      $query2 = 
      "SELECT p.id AS ID,
      p.title AS Title,
      to_char(p.start, 'DD/MM/YYYY') AS Start,
      to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
      p.target AS Target,
      p.status AS Status,
      p.creator AS Email 
      FROM project p, person c, has_category h 
      WHERE h.id = p.id"
      . $category .
      " AND c.email = p.creator
      AND CAST(p.id AS VARCHAR(31)) LIKE '%" . $_GET['project-ID'] . "%'
      AND LOWER(p.title) LIKE LOWER('%".$project_title."%')
      AND LOWER(c.firstname) LIKE LOWER('%".$project_firstname."%')
      AND LOWER(c.lastname) LIKE LOWER('%".$project_lastname."%')
      AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
      AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
      AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
      GROUP BY p.id, p.title, p.start, p.expiry, p.target, p.status, p.creator
      ORDER BY p.creator";
    
      #echo "<b>ADV SQL:   </b>".$query."<br><br>";
    }
    // echo "<h1>". $query1 ."</h1>";
    $result = pg_query($query1) or die('Query 1 failed: ' . pg_last_error());

    $nameList = array();
    $projList = array();
    while ($name = pg_fetch_array($result, NULL, PGSQL_ASSOC)) { #populate name table, and create new items in proj tree
      $temp = $name['email'];
      if (!array_key_exists($temp, $projList)) {
        $projList[$temp] = array();
      }
      array_push($nameList, $name);
    }

    // echo "<h1>". $query2 ."</h1>";
    $result = pg_query($query2) or die('Query 2 failed: ' . pg_last_error());

    while ($proj = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
      $temp = $proj['email'];
      if (!array_key_exists($temp, $projList)) {
        $projList[$temp] = array();
      }
      array_push($projList[$temp], $proj);
      // print_r($projList[$temp]);
    }
  ?>


<!-- LOOK FOR SOME DATE PICKER -->

<!-- endsearch -->
<div class = "row">
<!--START PRINT -->
<?php
  if (sizeof($nameList) == 0) {
    echo "<br><br><p style=\"text-align:center;\">No Results Found</p>";
  } else {
  echo "<table class=\"table table-striped\">
    <colgroup>
        <col width=25%>
        <col width=1%>
    </colgroup>
    <col width=\"15%\">
    <col width=\"5%\">
    <col width=\"20%\">
    <col width=\"15%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <tr>
    <th>Full Name</th>
    <th>Project ID</th>
    <th>Title</th>
    <th>Categories</th>
    <th>Start Date</th>
    <th>Expiry Date</th>
    <th>Contributions</th>
    <th>Target</th>
    <th>Status</th>
    </tr>";

    foreach($nameList as $name) {
      $temp = $name['email'];
      if (sizeof($projList[$temp]) <= 0) {
        $size = 1;
      } else {
        $size = sizeof($projList[$temp]);
      }
      echo "<tr>";
      echo "<td rowspan = '" . $size . "'><a href = \"person_admin.php?id=".$name['email']."\">".$name['firstname']." ".$name['lastname']."</a></td>"; #creator

      if (sizeof($projList[$temp]) <= 0) {
        echo "<td>-</td>";
        echo "<td>No projects to display</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "</tr>";
      }

      $projArray = $projList[$temp];
      $first = true;
      foreach($projArray as $proj) {
        if ($first) {
          $first = false;
        } else {
          echo "<tr>";
        }
        echo "<td><a href = \"project_admin.php?id=".$proj['id']."\">".$proj['id']."</a></td>"; #ID
        echo "<td><a href = \"project_admin.php?id=".$proj['id']."\">".$proj['title']."</a></td>"; #title
        #categories
        $q = "SELECT h.tag FROM has_category h WHERE h.id = ".$proj['id']." ORDER BY h.tag ASC;";
        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
        
        echo "<td>";
        while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
          foreach ($line as $col_value) { 
            echo"<a href = \"cat_result.php?varname=".$col_value."\">".$col_value."</a><br>";
          }
        }
        pg_free_result($res);
        echo "</td>";

        $temp = str_replace("/0", "/", $proj['start']);
        $temp = ltrim($temp, '0');
        echo "<td>" . $temp . "</td>"; #start
        
        $temp = str_replace("/0", "/", $proj['expiry']);
        $temp = ltrim($temp, '0');
        echo "<td>" . $temp . "</td>"; #expiry

        #contributions
        $q = "SELECT SUM(d.amount) FROM donation d WHERE d.project = ".$proj['id'];
        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
        
        echo "<td>";
        while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
          foreach ($line as $col_value) {
            if ($col_value == "") {
              $col_value = "0";
            } 
            echo"US$".$col_value.".00";
          }
        }
        pg_free_result($res);

        echo "<td>US$" . $proj['target'] . ".00</td>"; #target
        echo "<td>" . $proj['status'] . "</td>"; #status
        echo "</tr>";
      }
    }

    pg_free_result($result);
  }
  echo "</table>";
?>
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