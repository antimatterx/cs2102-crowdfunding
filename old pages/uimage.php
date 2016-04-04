<html>
<head> <title>Demo Image Upload</title> </head>

<?php 

$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

$file_name = "images\idea.jpg";

$img = fopen($file_name, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file_name));

$es_data = pg_escape_bytea($data);
fclose($img);

$query = "INSERT INTO image(id, data) Values(123, '$es_data')";
pg_query($con, $query); 

pg_close($con); 

?>

</html>