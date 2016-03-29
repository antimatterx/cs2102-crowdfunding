<form method="post" action="index.php"> 

0. <input type="text" name="email"/> <br/><br/>
1. <input type="text" name="password"/> <br/><br/>
<input type="submit" name="submit"/> </form>


<?php 
if (!isset($_SESSION['email'])) {
  echo "PLEASE LOGIN";
}
?>