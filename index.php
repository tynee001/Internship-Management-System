<?php 
$pass = "password";
$hashedpass = password_hash($pass, PASSWORD_DEFAULT);

echo $hashedpass;
?>