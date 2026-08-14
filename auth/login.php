<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';


if(isLoggedIn()) {
    redirect("../dashboard.php");
}

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = cleanInput($_POST["email"]);
    $password = $_POST["password"];

    if(empty($email) || empty($password)) {
        $error = "Please fill all the fields.";
    }else {
        //prepared statements
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); 
        $user = mysqli_fetch_assoc($result);
        var_dump($user["password"]);

        if($user) {
            if($password === $user["password"]) {
                // logged in successfully
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_role"] = $user["role"];

                // Redirect to dashboard
                redirect("../dashboard.php");
            } else {
                $error = "Invalid email or password.";
            }
           
        } else {
            $error = "User not found.";
        }

    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="row-justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card-shadow"> 
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Login</h3>
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . "/../includes/footer.php";?>