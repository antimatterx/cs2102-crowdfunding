<!DOCTYPE HTML>

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
  jQuery('#popular-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#popular-upcoming').offset().top
                     }, 2000);
            //});
        });
    
    jQuery('#feature-scroll').click(function (){
            //jQuery(this).animate(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#inner').offset().top
                     }, 2000);
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
    <img src="images/logo.png" width="100%" id="bigg-logo" alt="Bigg" /></a>
    </h1>
      
            <ul id="page-nav" class="horizontal-list">
<li class="page-nav-top-posts active"><a href="index.php">Home</a></li>

<li class="page-nav-popular-posts"><a href="index.php#countries" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

<li class="page-nav-top-posts active"><a href="index.php#categories" id="feature-scroll" class="page-anchor-link">Categories</a></li>

<li class="page-nav-popular-posts"><a href="index.php#countries" id="popular-scroll" class="page-anchor-link">Countries</a></li>

</ul>

<div id="site-nav" class="horizontal-list"><div class="menu-main-menu-container"><ul id="menu-main-menu" class="menu"><li id="menu-item-144" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-144"><a href="/">Sign Up</a></li>
<li id="menu-item-142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-142"><a href="sample-page.htm">Log In</a></li>
</ul></div></div><!-- #site-nav -->
<div id="site-header-bigg-social">
<!-- <ul class="horizontal-list">
<li><a href="https://twitter.com/opendesigns" target="_blank" class="bigg-social-twitter bigg-social-icon image-replace">Twitter</a></li>
<li><a href="http://www.facebook.com/opendesigns/" target="_blank" class="bigg-social-fb bigg-social-icon image-replace">Facebook</a></li>
<li><a href="https://plus.google.com/101703942483092652776/posts" target="_blank" class="bigg-social-gplus bigg-social-icon image-replace">Google+</a></li>
</ul>
 -->      
    </div>  
    </div>
  </div>
  <div id="wrap">
<div id="inner">
<div class="wrap">
<div id="content-sidebar-wrap">
<br><br><br><br>
</div><!-- end #top--> 

<!-- startsearch -->

<div style = "text-align:center;">
  <h1 id="Search" class="stories-section-header-hed" style = "text-align:center;font-size:150%;">Search</h1>
  <form>
    <input type="text" placeholder="Enter Project Title" name="search-query" class="search-field" id="search-input"> 
    <input type="submit" value="Search" class="button" name="search-submit-btn"> 
  </form>
  <input style = "background-color:#5F5F5F"type="button" value="Advanced Search" class="button" id="search-type-btn"> <!-- FOR HIDE/SHOW-->
  <div id="content" class="hfeed"></div>
</div>


<div style = "text-align:center;">
<br><br><br><br><br><br>
</div>

<div class="stories-section-header"><h1 id="Advanced Search" class="stories-section-header-hed" style = "text-align:center;font-size:180%;">Advanced Search</h1>
<br>
</div>

<div class = "three col"></div>
<div class = "three col" style = "text-align:center;">
  <form>
  <table border = "0" style="width:60%; text-align: left; margin-left: 30%;">
    <tr>
      <td style>Project Title</td>
      <td><input style = "width:335px; text-align:left;" type = "text" name = "project-title" id = "project-title" value = <?php if (isset($_GET['project-title'])) echo $_GET['project-title']; ?>></td>
    </tr>
    <tr>
      <td>Category</td>
      <td>
        <select name = "project-category" style = "width:340px;" id = "project-category">
          <option value = ""></option>
          <?php
            $query = "SELECT c.name FROM category c;";

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
      <td>Project ID</td>
      <td><input style = "width:335px;" type = "text" name = "project-ID" id = "project-ID" value = <?php if (isset($_GET['project-ID'])) echo $_GET['project-ID']; ?>></td>
    </tr>
    <tr>
      <td>Project Creator</td>
      <td><input style = "width:335px;" type = "text" name = "project-creator" id = "project-creator" value = <?php if (isset($_GET['project-creator'])) echo $_GET['project-creator']; ?>></td>
    </tr>
    <tr>
      <td>Country</td>
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
      <td>Project Start Date</td>
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
      <td>Project Expiry</td>
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

<!--   <h1>test35</h1><br> -->
  <?php
    if(isset($_GET['search-submit-btn']))  { #NORMAL SEARCH
      $result2 = array();
      $words = explode(" ", $_GET['search-query']);
      foreach ($words as $word) {
        if ($word != "") {
          $query = 
            "(SELECT p.id AS ID,
            p.title AS Title,
            c.name AS Creator,
            to_char(p.start, 'DD/MM/YYYY') AS Start,
            to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
            p.target AS Target,
            p.status AS Status 
            FROM project p, donation d, person c, has_category h 
            WHERE h.id = p.id
            AND c.email = p.creator
            AND LOWER(p.title) LIKE LOWER('%".$word."%')
            GROUP BY p.id, p.title, c.name, p.start, p.expiry, p.target, p.status)
            UNION
            (SELECT p.id AS ID,
            p.title AS Title,
            c.name AS Creator,
            to_char(p.start, 'DD/MM/YYYY') AS Start,
            to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
            p.target AS Target,
            p.status AS Status 
            FROM project p, donation d, person c, has_category h 
            WHERE h.id = p.id
            AND c.email = p.creator
            AND LOWER(c.name) LIKE LOWER('%".$word."%')
            GROUP BY p.id, p.title, c.name, p.start, p.expiry, p.target, p.status)";

          #echo "<b>SQL:   </b>".$query."<br><br>";
          $temp = pg_query($query) or die('Query failed: ' . pg_last_error());
          while($row = pg_fetch_array($temp)) {
            array_push($result2, $row);
          }
        }
      } 
      
      $past = array();
      $first = 1;
      foreach ($result2 as $row) {
        $isPast = 0;
        foreach ($past as $pastVal) {
          if ($pastVal == $row[0]) {
            $isPast = 1;
            break;
          }
        }
        array_push($past, $row[0]);
        if ($isPast == 0) {
          if ($first == 1) {
            $first = 0;
            echo "<br><br><h4> Search Results for: \"".$_GET['search-query']."\"</h4>";
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
          }
          echo "<tr>";
          /* 
          <a href="project_detail.php?id=<?php echo $id ?>"><?php echo $line['title']; ?></a>
          */
          echo "<td><a href = \"project_detail.php?id=".$row[0]."\">".$row[1]."</a></td>"; #title
          echo "<td>" . $row[2] . "</td>"; #creator
          
          #categories
          $q = "SELECT h.tag FROM has_category h WHERE h.id = ".$row[0]." ORDER BY h.tag ASC;";
          $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
          
          echo "<td>";
          while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
            foreach ($line as $col_value) { 
              echo"".$col_value."<br>";
            }
          }
          pg_free_result($res);
          echo "</td>";

          echo "<td>" . $row[3] . "</td>"; #start
          echo "<td>" . $row[4] . "</td>"; #expiry

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

          echo "<td>$" . $row[5] . ".00</td>"; #target
          echo "<td>" . $row[6] . "</td>"; #status
          echo "</tr>";
        }
      }

      if ($first == 1) {
        echo "<br><br><p>No Results Found</p>";
      } else {
        echo "</table>";
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
      
      
      $query = "";
      if ($_GET['project-ID'] == "") {
        $query = 
          "SELECT p.id AS ID,
          p.title AS Title,
          c.name AS Creator,
          to_char(p.start, 'DD/MM/YYYY') AS Start,
          to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
          p.target AS Target,
          p.status AS Status 
          FROM project p, donation d, person c, has_category h 
          WHERE h.id = p.id
          AND c.email = p.creator
          AND LOWER(p.title) LIKE LOWER('%".$_GET['project-title']."%')
          AND LOWER(c.name) LIKE LOWER('%".$_GET['project-creator']."%')
          AND LOWER(h.tag) LIKE LOWER('%".$_GET['project-category']."%') 
          AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
          AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
          AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
          GROUP BY p.id, p.title, c.name, p.start, p.expiry, p.target, p.status;";
      } else {
        $query = 
        "SELECT p.id AS ID, 
        p.title AS Title,
        c.name AS Creator,
        to_char(p.start, 'DD/MM/YYYY') AS Start,
        to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
        p.target AS Target,
        p.status AS Status
        FROM project p, donation d, person c, has_category h 
        WHERE d.project = p.id 
        AND h.id = p.id
        AND c.email = p.creator
        AND LOWER(p.title) LIKE LOWER('%".$_GET['project-title']."%')
        AND LOWER(c.name) LIKE LOWER('%".$_GET['project-creator']."%')
        AND LOWER(h.tag) LIKE LOWER('%".$_GET['project-category']."%') 
        AND LOWER(p.country) LIKE LOWER('%".$_GET['project-country']."%')
        AND p.id = ".$_GET['project-ID']."
        AND p.start >= '".$startYear."-".$startMonth."-".$startDay."'
          AND p.expiry <= '".$expiryYear."-".$expiryMonth."-".$expiryDay."'
        GROUP BY p.id, p.title, c.name, p.start, p.expiry, p.target, p.status;";
      }
      
      #echo "<b>ADV SQL:   </b>".$query."<br><br>";
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    
      $first = 1;
      while ($row = pg_fetch_row($result)){
        if ($first == 1) {
          $first = 0;
          echo "<br><br><h4> Advanced Search Results: </h4>";
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
        }
        echo "<tr>";
        /*
        echo "<td>" . $row[1] . "</td>"; #title
        */
        echo "<td><a href = \"project_detail.php?id=".$row[0]."\">".$row[1]."</a></td>";
        echo "<td>" . $row[2] . "</td>"; #creator
        
        #categories
        $q = "SELECT h.tag FROM has_category h WHERE h.id = ".$row[0]." ORDER BY h.tag ASC;";
        $res = pg_query($q) or die('Query Failed: ' . pg_last_error());
        
        echo "<td>";
        while($line = pg_fetch_array($res, null, PGSQL_ASSOC)){
          foreach ($line as $col_value) { 
            echo"".$col_value."<br>";
          }
        }
        pg_free_result($res);
        echo "</td>";

        echo "<td>" . $row[3] . "</td>"; #start
        echo "<td>" . $row[4] . "</td>"; #expiry

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

        echo "<td>$" . $row[5] . ".00</td>"; #target
        echo "<td>" . $row[6] . "</td>"; #status
        echo "</tr>";
      }

      if ($first == 1) {
        echo "<br><br><p>No Results Found</p>";
      } else {
        echo "</table>";
      }

      pg_free_result($result);
    }
  ?>

</div>

<!-- <p> nothing here</p> -->
<!-- LOOK FOR SOME DATE PICKER -->

<!-- endsearch -->

  </div><!-- end #content-sidebar-wrap -->
  </div><!-- end .wrap --></div><!-- end #inner --> 
  <br><br><br><br><br>
<div id="bigg-footer">
<div class="wrap">
        <div class="twocol">
            <div id="text-2" class="widget widget_text"><div class="widget-wrap"><h5 class="widgettitle">Company</h5>     
      <div class="textwidget"><ul class="plain-list">
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
            <div class="textwidget"><ul class="plain-list">
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
             <div id="text-4" class="widget widget_text"><div class="widget-wrap"><h5 class="widgettitle">Subscribe to the newsletter</h5>      <div class="textwidget"><p>Get news of the latest inventions in your inbox</p>

<div>
<input type="text" placeholder="Enter your email address" name="email" class="form-field" id="newsletter-email-input"> <input type="button" value="Submit" class="button" id="newsletter-email-submit-btn">
</div>
<p class="legalese">
Opt-out anytime with one click and we'll never share your information.
</p></div>
        </div>
</div>
 
</div><!-- end #wrap -->


</div>
</body>
</html>