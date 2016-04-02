<html>
<title></title>

<?php
$host = "localhost";
$user = "postgres";
$pass = "password";
$db = "test";

$dbcon = pg_connect("host=$host dbname=$db user=$user password=$pass")
or die('Could not connect: ' . pg_last_error());
session_start();
$curr_id = $_GET['id'];
//$curr_id = 2;
$sql = "SELECT p.id AS ID, 
        p.title AS Title,
        p.creator AS Creator,
        to_char(p.start, 'DD/MM/YYYY') AS Start,
        to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
        p.target AS Target,
        p.status AS Status,
        p.country AS Country
        FROM project p 
        WHERE p.id = $curr_id
        GROUP BY p.id, p.title, p.start, p.expiry, p.target, p.status
        ORDER BY p.id = " . $curr_id;
// echo "<br><br><br><br><h1>" . $sql . "</h1>";
$result = pg_query($dbcon, $sql);
if (!$result || pg_num_rows($result) == 0) {
    echo "Nothing here but us chickens";
}
else {
$received_query = "SELECT SUM(amount) FROM donation WHERE project=$curr_id;";
$donated = pg_fetch_assoc(pg_query($dbcon,$received_query))['sum'];
$image = pg_fetch_assoc($pic_query)['data'];
$row = pg_fetch_assoc($result);
$creator = $row['creator'];
$title  = $row['title'];
$description = $row['description'];
$start = $row['start'];
$expiry = $row['expiry'];
$country = $row['country'];
$target = $row['target'];
$status = $row['status'];
//category query
$cat_sql = "SELECT tag FROM has_category WHERE id=$curr_id;";
$cat_result = pg_query($dbcon, $cat_sql);
$category = "";
while ($cat_row = pg_fetch_array($cat_result)) {
    $category = $category . ", " . $cat_row['tag'];
}
$category = ltrim($category, ",");
?>
<body>
<div>
    <p>Title</p>
    <?php echo $title; ?>
    <p>Creators</p>
    <p><?php echo $creator; ?></p>
    <p>Description</p>
    <p><?php echo $description; ?></p>
    <p>Category</p>
    <p><?php echo $category; ?></p>
    <p>Country</p>
    <p><?php echo $country; ?></p>
    <p>Starting From: </p>
    <p><?php echo $start; ?></p>
    <p>Ending at:</p>
    <p><?php echo $expiry; ?></p>
    <p>Target amount:</p>
    <p><?php echo $target; ?></p>
    <p>Currently received<br></p>
    <p><?php echo $donated; ?></p>
    <p>Current status<br></p>
    <p><?php echo $status; ?></p>
<?php
// Fetch the image
$sqlImg = "SELECT data
    FROM image
    WHERE id = '$curr_id'";

$resImg = pg_query($dbcon, $sqlImg) or die("Query Failed: " . pg_last_error());

if(pg_num_rows($resImg) > 0) {
    $dataImg = pg_fetch_result($resImg, 'data');
    $unes_image = pg_unescape_bytea($dataImg);

    // save image to file
    $file_name = "temp/" . $curr_id . ".jpg";
    $img = fopen($file_name, 'wb') or die("cannot open image\n");
    fwrite($img, $unes_image) or die("cannot write image data\n");
    fclose($img);
} else {
    $file_name = "images/blank.jpg";
}
?>
</div>
<?php
$query = "SELECT i.data FROM image i WHERE i.id = $curr_id;";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());

echo "<img style=\"text-align:center;\" width=\"330\" height=\"175\" src=$file_name class=\"alignleft post-image\" alt=\"Image Not Found\" />";
?>
<?php  if (isset($_SESSION['email'])) /* the user is logged in, show donation bar*/ {?>
    <div>
        <h3>Interested?</h3>
        <form action="donate.php" method="GET">
            <h4>I wish to donate $
            <input id="donation" name="donation" required="required" type="number"/>
            to this project
            <input id="id" name="id" type="hidden" value="<?php echo $curr_id;?>" ></h4>
            <p class="donate button">
                <input type="submit" name="donate" value="Donate" />
            </p>
        </form>
        <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if ($donate_query) echo $donate_result;?></div>
    </div>
<?php } else /*tell user to login*/{ ?>
    <p>You have to <a href="login.php">log in</a> before making a donation! </p>

<?php }}; ?>

</body>
</html>
