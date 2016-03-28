<?php
session_start();
//include_once 'dbconfig.php';
$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";
$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
$sql = "SELECT p.id FROM project p
        HAVING p.id >= ALL (
          SELECT id FROM project
        );";
$result = pg_query($dbcon, $sql);
$row = pg_fetch_assoc($result);
$newid = $row['id'] + 1;
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $title = trim($_POST['title']);
    $description = $_POST['description'];
    $start = trim($_POST['start']);
    $expiry = trim($_POST['expiry']);
    $target = trim($_POST['target']);
    $status = $_POST['status'];
    $mail = $_SESSION['email'];
    //$insertT = "INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (18, 'able_too@gmail.com', 'Food Maker', 'Cook twice the amount of food in half the time!', '2015/09/14', '2016/10/14', 'Japan', 2000, 'ongoing')";

    $insert = "INSERT INTO project(id, title, description, start, expiry, target, status) 
            VALUES ('$newid', '$mail'. '$title', '$description', '$start', '$expiry', '$target', '$status')";
    //$result = pg_query($dbcon, $insert);
    $result = pg_query($dbcon, $insertT);
    if(!$result) {
        echo 'true';
    }else {
        echo 'false';
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

                <p>
                    <input type="radio" name="status" value="ongoing" checked> Ongoing<br>
                    <input type="radio" name="status" value="closed"> Closed<br>
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
