<?php
session_start();
//include_once 'dbconfig.php';
$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";
$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
$cnt = pg_query($dbcon, "SELECT COUNT(*) FROM project") + 1;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $title = trim($_POST['title']);
    $description = $_POST['description'];
    $start = trim($_POST['start']);
    $expiry = trim($_POST['expiry']);
    $target = trim($_POST['target']);

    $insert = "INSERT INTO project(id, title, description, start, expiry, target, current) 
            VALUES ('$cnt', '$title', '$description', '$start', '$expiry', '$target', '0')";
      $result = pg_query($dbcon, $insert);
      if(!$result) {
          $error = "Error creating new project, please try again";
      }else {
          $success = "You have successfully added a new project";
      }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Project</title>
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
                <h1> Sign up </h1>
                <p>
                    <label for="title" class="title" data-icon="u">Title</label>
                    <input id="title" name="title" required="required" type="text" placeholder="Title" />
                </p>
                <p>
                    <label for="description" class="description" data-icon="e" > Description</label>
                    <input id="description" name="description" required="required" type="text" placeholder="Description"/>
                </p>
                <p>
                    <label for="start" class="date" data-icon="p">Start date </label>
                    <input id="start" name="passwordsignup" required="required" type="date" placeholder="2001-12-31"/>
                </p>
                <p>
                    <label for="expiry" class="expiry" data-icon="p">End date</label>
                    <input id="expiry" name="expiry" required="required" type="date" placeholder="2002-12-31"/>
                </p>
                <p>
                    <label for="target" class="expiry" data-icon="p">Target amount</label>
                    <input id="target" name="target" required="required" type="number" placeholder="In US$"/>
                </p>
                <p class="create button">
                    <input type="submit" value="Submit"/>
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
