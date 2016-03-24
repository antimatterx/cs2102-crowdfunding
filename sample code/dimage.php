<html>
<head> <title>Demo Image Upload</title> </head>

<?php 

// create temp folder to store images
function makeDir($path)
{
     return is_dir($path) || mkdir($path);
}

$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test";  

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

$id = 123;
$query = "SELECT data FROM image WHERE id=$id";
$res = pg_query($con, $query) or die (pg_last_error($con)); 

$data = pg_fetch_result($res, 'data');
$unes_image = pg_unescape_bytea($data);

// save image to file
makeDir("temp");
$file_name = "temp/" . $id . ".jpg";
$img = fopen($file_name, 'wb') or die("cannot open image\n");
fwrite($img, $unes_image) or die("cannot write image data\n");
fclose($img);

pg_close($con); 

// display on website
echo "<img src='{$file_name}' alt='test' width='800' height='600'><br />";

?>

</html>