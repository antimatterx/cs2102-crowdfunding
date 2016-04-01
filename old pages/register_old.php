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

   if($_SERVER["REQUEST_METHOD"] == "GET") {
      // username and password sent from form


       $myfirstname = trim($_GET['firstname']);
       $mylastname = trim($_GET['lastname']);
       $myemail = trim($_GET['email']);
       $mypassword = $_GET['password'];
       $mypassword2 = $_GET['password_confirm'];
       $mysex = $_GET['sex'];
       $myaddress = $_GET['address'];
       $myphone = $_GET['phone'];
       $register_date = date("Y-m-d");

      $sql = "INSERT INTO person(firstname, lastname, email, password, sex, address, register_date, phone, admin)
              VALUES ('$myfirstname', '$mylastname', '$myemail', '$mypassword', '$mysex', '$myaddress',
              '$register_date', '$myphone', 'N')";
      $result = pg_query($dbcon, $sql);

      if(!$result) {
        $error = "The email address is already used";
      }else {
        $success = "You have successfully registered";
        $_SESSION['email'] = $myemail;
          header( "refresh:3;url=index.php" );
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
               <form  action="" method="GET">
                                <h1>Sign up</h1>
                                <p> 
                                    <label for="firstname" class="uname" data-icon="u">Your first name</label>
                                    <input id="firstname" name="firstname" required="required" type="text" placeholder="First name" />
                                </p>
                                <p>
                                    <label for="lastname" class="uname" data-icon="u">Your last name</label>
                                    <input id="lastname" name="lastname" required="required" type="text" placeholder="Last name" />
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
                                <p>
                                   <label for="address" class="addr" data-icon="u">Your address<br></label>
                                   <input id="address" name="address" type="text" placeholder="Address" />
                                </p>
                                <p>
                                    <label for="phone" class="phone" data-icon="u">Your phone number</label>
                                    <input id="phone" name="phone" type="number" placeholder="phone" />
                                </p>
                                <p>
                                    <label for="sex" class="sex" data-icon="s">You gender<br></label>
                                    <input type="radio" name="sex" value="O" checked/> Other<br>
                                    <input type="radio" name="sex" value="M"/> Male<br>
                                    <input type="radio" name="sex" value="F"/> Female<br>
                                </p>
                                <p class="signin button"> 
                           <input type="submit" value="Register"/>
                        </p>
                                <p class="change_link">  
                           Already a member ?
                           <a href="login.php" class="to_register"> Go to log in </a>
                        </p>
               </form>
                            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                            <div style = "font-size:11px; color:#0000cc; margin-top:10px"><?php echo $success; ?></div>
                        </div>
            </div>
         </div>
      </div>

   </body>
</html>
