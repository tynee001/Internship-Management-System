<?php
$host = 'localhost';
$dbname = 'internship_management_system';
$username = 'root';
$password = '';


$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn){
    die("Connection failed: " . mysql_connect_error());
}

mysqli_set_charset($conn, "utf8");
// echo "Connected Successfully";
?>