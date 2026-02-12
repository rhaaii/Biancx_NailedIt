<?php
$host = "sql207.infinityfree.com";
$user = "if0_41121527";
$password = "slndYSCZe0ZB";
$database = "if0_41121527_nail_db"; 

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>