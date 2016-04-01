<?session_start(); ?>

<!DOCTYPE html>

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
  

  //TODO for jQuery comment 
  jQuery(document).ready(function (){
    jQuery("#advancedSearch_JH").hide();
    jQuery("#search-type-btn").click(function(){
    jQuery("#advancedSearch_JH").toggle();
});
    jQuery("#closs_button_JH").click(function(){
      jQuery("#advancedSearch_JH").hide();
    })
      });
    </script>
</head>

<body>
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
<!--header ends here-->



  <div id="wrap">
<div id="inner">
<div class="wrap">
<div id="content-sidebar-wrap">
<br><br><br><br>
</div><!-- end #top--> 

<!-- bootstrap start here-->
<div class = "container">
<!-- startsearch -->

<!-- START NORMAL SEARCH FORM-->
<div style = "text-align:center;">
  <h1 id="Search" class="stories-section-header-hed" style = "text-align:center;font-size:150%;">Search</h1>
  <form>
    <input type="text" placeholder="Enter Project Title" name="search-query" class="search-field" id="search-input"> 
    <input type="submit" value="Search" class="button" name="search-submit-btn"> 
  </form>
  <input style = "background-color:#BEBEBE"type="button" value="Advanced Search" class="button" id="search-type-btn"> <!-- FOR HIDE/SHOW-->
  <div id="content" class="hfeed"></div>
</div>

<div id = "advancedSearch_JH">
<div style = "text-align:center;">
<p id = "closs_button_JH" type = "button" style="text-align: right;">&times;</p>
<br><br><br><br>
</div>
<!-- END NORMAL SEARCH FORM-->

<!-- advanced search below  -->



<!-- START ADV SEARCH FORM-->
<div class = "col-md-offset-4 col-md-4">
<div class="stories-section-header"><h1 id="Advanced Search" class="stories-section-header-hed" style = "text-align:center;font-size:180%;">Advanced Search</h1>
<br>
</div>
<!--

<div class = "three col"></div>
<div class = "three col" style = "text-align:center;">
  
  <table border = "0" style="width:60%; text-align: left; margin-left: 30%;">
-->

<form>
  <table border = "0" style="width:100%; text-align: left;">
    <col width=\"70%\">
    <col width=\"30%\">
    <tr>
      <td><b>Project Title </b></td>
      <td><input style = "width:335px; text-align:left;" type = "text" name = "project-title" id = "project-title" value = <?php if (isset($_GET['project-title'])) echo $_GET['project-title']; ?>></td>
    </tr>
    <tr>
      <td><b>Project ID </b></td>
      <td><input style = "width:335px;" type = "text" name = "project-ID" id = "project-ID" value = <?php if (isset($_GET['project-ID'])) echo $_GET['project-ID']; ?>></td>
    </tr>
    <tr>
      <td><b>Creator's First Name </b></td>
      <td><input style = "width:335px;" type = "text" name = "project-firstname" id = "project-firstname" value = <?php if (isset($_GET['project-firstname'])) echo $_GET['project-firstname']; ?>></td>
    </tr>
    <tr>
      <td><b>Creator's Last Name </b></td>
      <td><input style = "width:335px;" type = "text" name = "project-lastname" id = "project-lastname" value = <?php if (isset($_GET['project-lastname'])) echo $_GET['project-lastname']; ?>></td>
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
        <select name = "project-country" style = "width:340px;" id = "project-country">
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
        <select name = "project-start-D" style = "width:44px;" id = "project-start-D">
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
       <select name = "project-start-M" style = "width:50px;" id = "project-start-M">
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
       <input type = "number" placeholder = "YYYY" style = "width:57px;" name = "project-start-Y" id = "project-start-Y" min = "1900" value = <?php if (isset($_GET['project-start-Y'])) echo $_GET['project-start-Y']; ?>></td>
    </tr>
    <tr>
      <td><b>Project Expiry </b></td>
      <td>
      <select name = "project-expiry-D" style = "width:44px;" id = "project-expiry-D">
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
       <select name = "project-expiry-M" style = "width:50px;" id = "project-expiry-M">
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

       <input type = "number" placeholder = "YYYY" style = "width:57px;" name = "project-expiry-Y" id = "project-expiry-Y" min = "1900" value = <?php if (isset($_GET['project-expiry-Y'])) echo $_GET['project-expiry-Y']; ?>></td>
    </tr>
  </table>

  <div style = "text-align:center;"><input type="submit" value="Submit" class="button" name="adv-search-submit-btn"></div>
  </form>
<!-- END ADV SEARCH FORM-->

<!-- START SEARCH QUERIES-->
  <?php
    if(isset($_GET['search-submit-btn']))  { #NORMAL SEARCH
      $result2 = array();
      $words = explode(" ", $_GET['search-query']);
      foreach ($words as $word) {
        if ($word != "") {
          $query = 
            "(SELECT p.id AS ID,
            p.title AS Title,
            c.firstname AS FirstName,
            c.lastname AS LastName,
            to_char(p.start, 'DD/MM/YYYY') AS Start,
            to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
            p.target AS Target,
            p.status AS Status, 
            p.creator AS Email 
            FROM project p, person c
            WHERE c.email = p.creator
            AND LOWER(p.title) LIKE LOWER('%".$word."%')
            GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status, p.creator)
            UNION
            (SELECT p.id AS ID,
            p.title AS Title,
            c.firstname AS FirstName,
            c.lastname AS LastName,
            to_char(p.start, 'DD/MM/YYYY') AS Start,
            to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
            p.target AS Target,
            p.status AS Status, 
            p.creator AS Email 
            FROM project p, person c
            WHERE c.email = p.creator
            AND LOWER(c.firstname) LIKE LOWER('%".$word."%')
            GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status, p.creator)
            UNION
            (SELECT p.id AS ID,
            p.title AS Title,
            c.firstname AS FirstName,
            c.lastname AS LastName,
            to_char(p.start, 'DD/MM/YYYY') AS Start,
            to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
            p.target AS Target,
            p.status AS Status, 
            p.creator AS Email
            FROM project p, person c
            WHERE c.email = p.creator
            AND LOWER(c.lastname) LIKE LOWER('%".$word."%')
            GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status, p.creator)";

          #echo "<b>SQL:    </b>".$query."<br><br>";
          $print = array();
          $temp = pg_query($query) or die('Query failed: ' . pg_last_error());
          while($row = pg_fetch_array($temp)) {
            array_push($print, $row);
          }
        }
      } 
    } else if(isset($_GET['adv-search-submit-btn']))  { #ADVANCED SEARCH
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
      
      $query = "";
      if ($_GET['project-ID'] == "") {
        $query = 
          "SELECT p.id AS ID,
          p.title AS Title,
          c.firstname AS FirstName, 
          c.lastname AS LastName,
          to_char(p.start, 'DD/MM/YYYY') AS Start,
          to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
          p.target AS Target,
          p.status AS Status, 
          p.creator AS email
          FROM project p, person c 
          WHERE c.email = p.creator ".
          $category . " AND LOWER(p.title) LIKE LOWER('%".$_GET['project-title']."%')
          AND LOWER(c.firstname) LIKE LOWER('%".$_GET['project-firstname']."%')
          AND LOWER(c.lastname) LIKE LOWER('%".$_GET['project-lastname']."%')
          AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
          AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
          AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
          GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status, p.creator;";
      } else {
        $query = 
        "SELECT p.id AS ID, 
        p.title AS Title,
        c.firstname AS FirstName, 
        c.lastname AS LastName,
        to_char(p.start, 'DD/MM/YYYY') AS Start,
        to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
        p.target AS Target,
        p.status AS Status,
        p.creator AS Email
        FROM project p, person c 
        WHERE d.project = p.id ".
          $category . " AND c.email = p.creator
        AND LOWER(p.title) LIKE LOWER('%".$_GET['project-title']."%')
        AND LOWER(c.firstname) LIKE LOWER('%".$_GET['project-firstname']."%')
        AND LOWER(c.lastname) LIKE LOWER('%".$_GET['project-lastname']."%')
        AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
        AND p.id = ".$_GET['project-ID']."
        AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
        AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
        GROUP BY p.id, p.title, c.firstname, c.lastname, p.start, p.expiry, p.target, p.status, p.creator;";
      }
      
      #echo "<b>ADV SQL:    </b>".$query."<br><br>";
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    
      $print = array();

      while ($row = pg_fetch_row($result)) {
        array_push($print, $row);
      }
    }
  ?>
</div>

<!-- <p> nothing here</p> -->
<!-- LOOK FOR SOME DATE PICKER -->

</div>
</div> <!-- END CONTAINER-->
<!-- END SEARCH QUERIES-->

<!-- START PRINT-->
<?php
  if (sizeof($print) == 0) {
    if(isset($_GET['search-submit-btn']) or isset($_GET['adv-search-submit-btn'])){
      echo "<br><br><p>No Results Found</p>";
    }
  } else {
    $past = array();
    echo "<br><br><h4 style = \"text-align:center;\"> Search Results</h4>";
    echo "<br><table border=\"1\" >
    <col width=\"20%\">
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <col width=\"10%\">
    <tr>
    <th>Title</th>
    <th>Creator</th>
    <th>Categories</th>
    <th>Start Date</th>
    <th>Expiry Date</th>
    <th>Contributions</th>
    <th>Target</th>
    <th>Status</th>
    </tr>";
  
    foreach ($print as $row) {
      $isPast = false;
      foreach ($past as $pastVal) {
        if ($pastVal == $row[0]) {
          $isPast = true;
          break;
        }
      }

      array_push($past, $row[0]);
      
      if (!$isPast) {
        echo "<tr>";
        echo "<td><a href = \"project_detail.php?id=".$row[0]."\">".$row[1]."</a></td>"; #title
        echo "<td><a href = \"profile.php?id=".$row[8]."\">".$row[2]. " " . $row[3] . "</a></td>"; #creator
        
        #categories
        $q = "SELECT h.tag FROM has_category h WHERE h.id = ".$row[0]." ORDER BY h.tag ASC;";
        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
        
        echo "<td>";
        while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
          foreach ($line as $col_value) { 
            echo"<a href = \"cat_result.php?varname=".$col_value."\">".$col_value."</a><br>";
          }
        }
        pg_free_result($res);
        echo "</td>";

        $temp = str_replace("/0", "/", $row[4]);
        $temp = ltrim($temp, '0');
        echo "<td>" . $temp . "</td>"; #start
        
        $temp = str_replace("/0", "/", $row[5]);
        $temp = ltrim($temp, '0');
        echo "<td>" . $temp . "</td>"; #expiry

        #contributions
        $q = "SELECT SUM(d.amount) FROM donation d WHERE d.project = ".$row[0].";";
        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
        
        echo "<td>";
        while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
          foreach ($line as $col_value) {
            if ($col_value == "") {
              $col_value = "0";
            } 
            echo"$".$col_value.".00";
          }
        }
        pg_free_result($res);

        echo "<td>$" . $row[6] . ".00</td>"; #target
        echo "<td>" . $row[7] . "</td>"; #status
        echo "</tr>";
      }
    }
    echo "</table>";
  }
?>
<!-- END PRINT-->

  </div><!-- end #content-sidebar-wrap -->
  </div><!-- end .wrap --></div><!-- end #inner --> 
  <br><br><br><br><br>


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