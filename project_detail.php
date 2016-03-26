<?php
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());

    $sql = "SELECT * FROM project WHERE id = $id";
    $result = pg_query($dbcon, $sql);
    if (!$result) {
        echo "Nothing found";
    }
    else {
        $row = pg_fetch_assoc($result);
        $id = $row['id'];
        $creator = $row['creator'];
        $title  = $row['title'];
        $description = $row['description'];
        $start = $row['start'];
        $expiry = $row['expiry'];
        $country = $row['country'];
        $target = $row['target'];
        $current = $row['current'];
    }
?>

<html>
<title><?php echo $title; ?></title>
<body>
    <p>Creators</p>
    <p><?php echo $creator; ?></p>
    <p>Description</p>
    <p><?php echo $description; ?></p>
    <p>Starting From: </p>
    <p><?php echo $start; ?></p>
    <p>Ending at:</p>
    <p><?php echo $expiry; ?></p>
    <p>Target amount:</p>
    <p><?php echo $target; ?></p>
    <p>Completed:</p>
    <p><?php echo $current; ?></p>
</body>
</html>
