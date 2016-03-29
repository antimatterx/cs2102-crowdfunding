<?php
$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die('Could not connect: ' . pg_last_error());

$curr_id = $_POST['id'];
    $sql = "SELECT p.id AS ID, 
        p.title AS Title,
        c.name AS Creator,
        to_char(p.start, 'DD/MM/YYYY') AS Start,
        to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
        p.target AS Target,
        p.status AS Status
        FROM project p, donation d, person c, has_category h 
        WHERE d.project = p.id 
        AND h.id = p.id
        AND c.email = p.creator
        AND p.id = ".$curr_id."
        GROUP BY p.id, p.title, c.name, p.start, p.expiry, p.target, p.status
        ORDER BY p.id;";
    $result = pg_query($dbcon, $sql);
    if (!$result) {
        echo "Nothing found";
    }
    else {
        $row = pg_fetch_assoc($result);
        $creator = $row['creator'];
        $title  = $row['title'];
        $description = $row['description'];
        $start = $row['start'];
        $expiry = $row['expiry'];
        $country = $row['country'];
        $target = $row['target'];
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
</body>
</html>
