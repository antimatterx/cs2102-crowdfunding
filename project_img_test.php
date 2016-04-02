<?php

$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die('Could not connect: ' . pg_last_error());

$res = pg_query("SELECT encode(data, 'base64') AS data FROM image WHERE id=2;");
$raw = pg_fetch_result($res, 'data');

// Convert to binary and send to the browser
header('Content-type: image/jpeg');
//echo '<img src="data:image/jpeg;base64,'.base64_encode($raw).'">';
echo base64_decode($raw);
?>

