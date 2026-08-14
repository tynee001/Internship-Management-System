<?php
//start session if not already started
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

//Redirect to another page
function redirect($url) {
    header("location : $url");
    exit();
}

//check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// force user to log in if not logged in
function requireLogin(){
    if (!isLoggedIn()) {
        redirect('../auth/login.php');
    }
}

// clean user input (basic protection)
function cleanInput($data) {
  $data = trim($data);
  $data = striplashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//show success or error message
function setMessage($message, $type = 'success'){
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}


function showMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message type'];
        echo "<div class='alert alert-$type'>$message</div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}
?>