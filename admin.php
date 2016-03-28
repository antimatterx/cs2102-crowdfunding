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

    <style>
      div.scroll {
        background-color: #FFFFFF;
        width:100%;
        height:100%;
        overflow: scroll;
      }
    </style>
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
          <div class="scroll">
            <table border = "0" style="width:60%;">
              <?php
                $query = "SELECT p.title AS title, c.name AS name FROM project p, person c WHERE p.creator = c.email;";

                $result = pg_query($query) or die('Query failed: ' . pg_last_error());
              ?>

              <?php while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){ ?>
                <?php foreach ($line as $col_value) { ?>
                  <option value = "#"><?php echo $col_value; ?></a></li>
                  <?php } ?>
                <?php } ?>
              <?php pg_free_result($result); ?></td>
            </table>
          </div>
        

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