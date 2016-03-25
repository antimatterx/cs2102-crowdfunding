<!DOCTYPE HTML>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Uptown Fund &raquo; Your One-Stop Crowdfunding Hub</title>
<meta name="description" content="Just another Open Designs template." />
<meta name="robots" content="noodp,noydir" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
<li class="page-nav-top-posts active"><a href="javascript:void(0)" id="feature-scroll" class="page-anchor-link">Home</a></li>

<li class="page-nav-popular-posts"><a href="javascript:void(0)" id="popular-scroll" class="page-anchor-link">Most Popular</a></li>

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
  <input type="text" placeholder="Enter Project Title" name="query" class="search-field" id="search-input"> <input type="button" value="Search" class="button" id="search-submit-btn">
  <input style = "background-color:#5F5F5F"type="button" value="Advanced Search" class="button" id="search-type-btn">
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
  <table border = "0" style="width:60%; text-align: left; margin-left: 30%;">
    <tr>
      <td style>Project Title</td>
      <td><input style = "width:335px; text-align:left;" type = "text" name = "project-title" id = "project-title"></td>
    </tr>
    <tr>
      <td>Category</td>
      <td><select name = "project-category" style = "width:340px;" id = "project-category">
        <option value = ""></option>
        <?php
          $query = "SELECT c.name FROM category c;";

          $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        ?>

        <?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
          <?php foreach ($line as $col_value) { ?>
            <option value = "#"><?php echo $col_value; ?></a></li>
           <?php } ?>
         <?php } ?>
        <?php pg_free_result($result); ?></td>
    </tr>
    <tr>
      <td>Project ID</td>
      <td><input style = "width:335px;" type = "text" name = "project-ID" id = "project-ID"></td>
    </tr>
    <tr>
      <td>Project Creator</td>
      <td><input style = "width:335px;" type = "text" name = "project-creator" id = "project-creator"></td>
    </tr>
    <tr>
      <td>Country</td>
      <td><select name = "project-country" style = "width:340px;" id = "project-country">
      <option value = ""></option>
      <?php
          $query = "SELECT p.country FROM project p GROUP BY p.country ORDER BY p.country ASC;";

          $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        ?>

        <?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
          <?php foreach ($line as $col_value) { ?>
            <option value = "#"><?php echo $col_value; ?></a></li>
           <?php } ?>
         <?php } ?>
        <?php pg_free_result($result); ?></select></td>
    </tr>
    <tr>
      <td>Project Start Date</td>
      <td>
      <input type = "text" placeholder = "DD" style = "width:22px;" name = "project-start-D" id = "project-start-D">
       <input type = "text" placeholder = "MM" style = "width:24px;" name = "project-start-M" id = "project-start-M">
       <input type = "text" placeholder = "YYYY" style = "width:42px;" name = "project-start-Y" id = "project-start-Y"></td>
    </tr>
    <tr>
      <td>Project Expiry</td>
      <td>
      <input type = "text" placeholder = "DD" style = "width:22px;" name = "project-expiry-D" id = "project-expiry-D">
       <input type = "text" placeholder = "MM" style = "width:24px;" name = "project-expiry-M" id = "project-expiry-M">
       <input type = "text" placeholder = "YYYY" style = "width:42px;" name = "project-expiry-Y" id = "project-expiry-Y"></td>
    </tr>
  </table>

  <div style = "text-align:center;"><input type="button" value="Submit" class="button" id="adv-search-submit-btn"></div>
</div>


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
    </div></div>
        </div>
        <div class="twocol">
            <div id="text-3" class="widget widget_text"><div class="widget-wrap"><h5 class="widgettitle">Community</h5>     <div class="textwidget"><ul class="plain-list">
<li><a href="#">Blog</a></li>
<li><a href="#">Twitter</a></li>
<li><a href="#">Facebook</a></li>
<li><a href="#">Help</a></li>
</ul>
</div>

    </div></div>
        </div>
        <div class="fourcol">
            <div id="text-4" class="widget widget_text"><div class="widget-wrap"><h5 class="widgettitle"></h5>      <div class="textwidget"><p></p>

<div>

</div>

</div>
    </div></div>
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