<html>
<head> <title>Demo Crowdfunding</title> </head>

<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1> Demo Crowdfunding</h1>
</td> </tr>

<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=test user=postgres password=wordpass")
    or die('Could not connect: ' . pg_last_error());
?>

<tr>
<td style="background-color:#eeeeee;">
<form>
        ID: <input type="text" name="ID" id="ID">
        Title: <input type="text" name="Title" id="Title">
        Description: <input type="text" name="Description" id="Description">

        <select name="Country"> <option value="">Select Country</option>
        <?php
        $query = 'SELECT DISTINCT country FROM project';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
           foreach ($line as $col_value) {
              echo "<option value=\"".$col_value."\">".$col_value."</option><br>";
            }
        }
        pg_free_result($result);
        ?>
        </select>

        <input type="radio" name="Status" id="Status1" value="closed">closed
        <input type="radio" name="Status" id="Status2" value="ongoing" checked="checked">ongoing

        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT title, description FROM project WHERE description like '%".$_GET['Description']."%' AND title LIKE '%".$_GET['Title']."%' AND country LIKE'%".$_GET['Country']."%' AND status='".$_GET['Status']."'" ; echo "<b>SQL: </b>".$query."<br><br>";

    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"25%\">
    <col width=\"75%\">
    <tr>
    <th>Project</th>
    <th>Description</th>
    </tr>";


    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    
    pg_free_result($result);
}
?>

</td> </tr>
<?php
pg_close($dbconn);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>

</body>
</html>
