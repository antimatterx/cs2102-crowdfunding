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
        c.firstname AS Creator,
        to_char(p.start, 'DD/MM/YYYY') AS Start,
        to_char(p.expiry, 'DD/MM/YYYY') AS Expiry,
        p.target AS Target,
        p.status AS Status,
        p.country AS Country
        FROM project p, donation d, person c, has_category h 
        WHERE d.project = p.id 
        AND h.id = p.id
        AND c.email = p.creator
        AND p.id = $curr_id
        GROUP BY p.id, p.title, c.firstname, p.start, p.expiry, p.target, p.status
        ORDER BY p.id;";
$result = pg_query($dbcon, $sql);
if (!$result) {
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
    $category = $category . " " . $cat_row['tag'];
}
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
    $res = pg_query("SELECT encode(data, 'base64') AS data FROM image WHERE id=$curr_id;");
    $raw = pg_fetch_result($res, 'data');

    // Convert to binary and send to the browser
//    header('Content-type: image/jpeg');
//    echo base64_decode($raw);
    ?>
</div>

<?php  if (isset($_SESSION['email'])) /* the user is logged in, show donation bar*/ {?>
    <div>
        <p>Interested?</p>
        <form action="" method="GET">
            <h4>I wish to donate $</h4>
            <input id="donation" name="donation" required="required" type="number"/>
            <h4>to this project</h4>
            <p class="donate button">
                <input type="submit" name="donate" value="Donate" />
            </p>
            <?php
            if(isset($_GET["donate"])) {
                $amount = $_GET['donation'];
                $donor = $_SESSION['email'];
                $donate_date = date("Y-m-d");
                $donate_sql = "INSERT INTO donation (time, donor, amount, project)
                                   VALUES ('$donate_date', '$donor', '$amount', '$curr_id');";
                $donate_query = pg_query($dbcon, $donate_sql);
            }
            if(!$donate_query) {
                $donate_result = "You have successfully donated $amount to project";
            } else {
                $donate_result = "Something wrong happend. Please try again";
            }
            ?>
        </form>
        <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php if ($donate_query) echo $donate_result;?></div>
    </div>
<?php } else /*tell user to login*/{ ?>
    <p>You have to <a href="login.php">log in</a> before making a donation! </p>

<?php }}; ?>

</body>
</html>
