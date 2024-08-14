<?php
$servername = "srv1385.hstgr.io";  // or use 82.197.80.206
$username = "u763122759_madata";   // The MySQL user you've set up
$password = "Novapoint@xxiv25#madata";// The password for this user
$db_name = "u763122759_novapoint"; // Your database name

$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  echo "Welcome again!";
}
?>
