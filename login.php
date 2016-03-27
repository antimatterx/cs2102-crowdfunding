<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die('Could not connect: ' . pg_last_error());

//$query = "SELECT * FROM person WHERE name='$username' AND password='$password'";
$query = "SELECT * FROM person WHERE name='Peter' AND password='123456'";
$result = pg_query($con, $query)or die(pg_last_error());
$num_row = pg_num_rows($result);
		$row=pg_fetch_array($result);
		if( $num_row ==1 ) {
			echo 'true';
			$_SESSION['user_name']=$row['name'];			
			
		}
		else{
			echo "$username";
		}
?>