<?php
$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die('Could not connect: ' . pg_last_error());

session_start();

if(isset($_GET["donate"]) && isset($_GET["id"])) {
    $id = $_GET['id'];
    $amount = $_GET['donation'];
    $donor = $_SESSION['email'];
    $donate_date = date("Y-m-d H:i:s");
    $donate_sql = "INSERT INTO donation (time, donor, amount, project)
                   VALUES ('$donate_date', '$donor', '$amount', '$id');";
    $donate_query = pg_query($dbcon, $donate_sql);
}
if($donate_query) {
    $donate_result = "You have successfully donated $$amount to project" . $id;
} else {
    $donate_result = "Something wrong happend. Please try again";
}
echo $donate_result."<br>";
header("refresh:3; project_detail.php?id=".urldecode($id));
?>