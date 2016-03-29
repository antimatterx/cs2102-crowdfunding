<html>
<head> <title>Demo Image Upload</title> </head>

<?php 

$host = "localhost"; 
$user = "postgres"; 
$pass = "password"; 
$db = "test"; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");


$images = array(2, 14, 55, 56, 67, 72, 73, 84);

foreach($images as $id) {
	$file_name = $id . ".jpg";	
	
	$img = fopen($file_name, 'r') or die("cannot read image\n");
	$data = fread($img, filesize($file_name));

	$es_data = pg_escape_bytea($data);
	fclose($img);

	$query = "INSERT INTO image(id, data) Values($id, '$es_data')";
	pg_query($con, $query); 

	echo $file_name . " uploaded to table!" ."<br>";
}


pg_close($con); 

?>

</html>