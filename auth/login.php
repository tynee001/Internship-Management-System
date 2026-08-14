<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';



if(isLoggedIn()){
    redirect("../dashboard.php");
}
$errors = "";
if ($_SERVER["REQUEST_METHOD" == "POST"]){
    $email = cleanInput($_POST["email"]);
    $password = $_POST["password"];
}
    if (empty($email) || empty($password)){
        $errors ="Please, fill all the fields.";
    }else {
        //Prepared statements
        $sql = "SELECT * FROM users WHERE email = $email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result(stmt);

        
    }
?>