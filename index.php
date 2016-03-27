<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery.js"></script>
<link rel="stylesheet" href="styles.css" type="text/css" />
<title>Login Form</title>
<script type="text/javascript">
$(document).ready(function(){
	
   $("#login").click(function(){
		username=$("#user_name").val();
        password=$("#password").val();

         $.ajax({
            type: "POST",
            url: "login.php",
            data: "username="+username+"&password="+password,


            success: function(html){
			
			  if(html=='true')
              {
                $("#login_form").fadeOut("normal");
				$("#shadow").fadeOut();
				$("#profile").html("<a href='logout.php' class='red' id='logout'>Logout</a>");
				// You can redirect to other page here...
              }
              else
              {
                    $("#add_err").html("Wrong username or password");
              }
            },
            beforeSend:function()
			{
                 $("#add_err").html("Loading...")
            }
        });
         return false;
    });
});
</script>
</head>
<body>
<?php session_start(); ?>
	<div id="profile">
     	<?php
   	if(isset($_SESSION['user_name'])){
			?>
	<a href='logout.php'>Logout</a>
		<?php } ?>
	</div>
</body>
<?php 
if(empty($_SESSION['user_name'])){?>
<div class="container" id="login_form">
	<section id="content">
		<form action="login.php">
			<h1>Login Form</h1>
			<div>
				<input type="text" placeholder="Username" required="" id="user_name"  name="user_name"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" id="password"  name="password"/>
			</div>
		        <div class="err" id="add_err"></div>
			<div>
					<input type="submit" value="Log in" id="login"  />
				<a href="register.php">Register</a>
			</div>
		</form><!-- form -->
		<div class="button">
			
		</div><!-- button -->
	</section><!-- content -->
</div>
<?php }?>
<!-- container -->
</html>