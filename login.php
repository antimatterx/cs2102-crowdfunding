<<<<<<< HEAD
<?php
   $host = "localhost"; 
   $user = "postgres"; 
   $pass = "password"; 
   $db = "test"; 
   $dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
   session_start();
   
   
?>
<html>
   
   <head>
      <title>Login Page</title>
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
               <div style = "margin:30px">
               
               <!--<form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>-->
               <form  action="" method="post"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your email </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="mymail@mail.com"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <p class="keeplogin"> 
                        </p>
                                <p class="login button"> 
                                 <input type="submit" value="Submit" /> 
                        </p>
                                <p class="change_link">
                           Not a member yet ?
                           <a href="register.php" class="to_register">Join us</a>
                        </p>

      <?php
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form 
        $myusername = trim($_POST['username']);
        $mypassword = $_POST['password'];

        $sql = "SELECT * FROM person WHERE email='$myusername' AND password = '$mypassword'";
        $result = pg_query($dbcon, $sql);
        $count = pg_num_rows($result);
        
        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
           session_register("myusername");
           $_SESSION['login_user'] = $myusername;
           header("location: welcome.php");
           //print "Login successfull";
        }else {
           $error = "Your Login Name or Password is invalid";
        }
      }
     ?> 
               </form>
                   <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

               </div>
         </div>
      </div>

   </body>
</html>
<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die('Could not connect: ' . pg_last_error());

//$query = "SELECT * FROM person WHERE name='$username' AND password='$password'";
$query = "SELECT * FROM person WHERE name='Peter' AND password='123456'";
$result = pg_query($con, $query)or die(pg_last_error());
$num_row = pg_num_rows($result);
		$row=pg_fetch_array($result);
		if( $num_row ==1 ) {
			echo 'true';
			$_SESSION['user_name']=$row['name'];			
			
		}
		else{
			echo "$username";
		}
?>
