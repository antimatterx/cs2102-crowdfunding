<?php
   $host = "localhost"; 
   $user = "postgres"; 
   $pass = "password"; 
   $db = "test"; 
   $dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      

      $myusername = trim($_POST['username']);
      $mypassword = trim($_POST['password']); 

      $sql = "SELECT * FROM person WHERE name = '$myusername' and password = '$mypassword'";
      $result = pg_query($dbcon, $sql);
      $count = pg_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
         session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         header("location: welcome.php");
         print "Login successfull";
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
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
                           <a href="#toregister" class="to_register">Join us</a>
                        </p>
               </form>

               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					

                        <div id="register" class="animate form">
                            <form  action="" method="post"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your name</label>
                                    <input id="usernamesignup" name="usernamesignup" required="required" type="text" placeholder="myusername" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <input id="emailsignup" name="emailsignup" required="required" type="email" placeholder="mymail@mail.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="passwordsignup" name="passwordsignup" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="Same as above"/>
                                </p>
                                <p class="signin button"> 
                           <input type="submit" value="Sign up"/> 
                        </p>
                                <p class="change_link">  
                           Already a member ?
                           <a href="#tologin" class="to_register"> Go and log in </a>
                        </p>
                            </form>
                        </div>
            </div>
				
         </div>
			
      </div>

   </body>
</html>