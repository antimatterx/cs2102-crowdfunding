<?php
   $host = "localhost"; 
   $user = "postgres"; 
   $pass = "password"; 
   $db = "test"; 
   $dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
   session_start();

//   $sql = "INSERT INTO person(name, email, password) VALUES ('Jack', 'mas@yahoo.com', '234567')";
//   $result = pg_query($dbcon, $sql);
//   if (!$result) {
//       print "F";
//   }
//   else {
//      print "T";
//   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form


       $myusername = trim($_POST['username']);
       $myemail = trim($_POST['email']);
       $mypassword = $_POST['password'];
       $mypassword2 = $_POST['password_confirm'];

      $sql = "INSERT INTO person(name, email, password) VALUES ($myusername, $myemail, $mypassword)";
      $result = pg_query($dbcon, $sql);
      if(!$result) {
        $error = "The email address is already used";
      }else {
        $success = "You have successfully registered, please go to login page";
      }
   }
?>

<html>
   
   <head>
      <title>Sign Up Page</title>
   </head>
   
   <body bgcolor = "#FFFFFF">
    
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Register</b></div>
                
               <div style = "margin:30px">
               
               <!--<form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>-->
               <form  action="" method="post">
                                <h1>Sign up</h1>
                                <p> 
                                    <label for="username" class="uname" data-icon="u">Your name</label>
                                    <input id="username" name="username" required="required" type="text" placeholder="myusername" />
                                </p>
                                <p> 
                                    <label for="email" class="youmail" data-icon="e" > Your email</label>
                                    <input id="email" name="email" required="required" type="email" placeholder="mymail@mail.com"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="password_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="password_confirm" name="password_confirm" required="required" type="password" placeholder="Same as above"/>
                                </p>
                                <p class="signin button"> 
                           <input type="submit" value="Submit"/> 
                        </p>
                                <p class="change_link">  
                           Already a member ?
                           <a href="login.php" class="to_register"> Go to log in </a>
                        </p>
               </form>
                            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                            <div><?php echo "Entered user ".$myusername."email ".$myemail."pw ".$mypassword; ?></div>
                            <div style = "font-size:11px; color:#0000cc; margin-top:10px"><?php echo $success; ?></div>
                        </div>
            </div>
         </div>
      </div>

   </body>
</html>
