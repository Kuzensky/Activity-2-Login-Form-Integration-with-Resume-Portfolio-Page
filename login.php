<?php
session_start();
require_once 'db.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: resume.php");
    exit;
}

$email = $password = "";
$email_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $row = $stmt->fetch();
                    if(password_verify($password, $row["password"])){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["login_time"] = date("Y-m-d H:i:s");
                        header("location: resume.php");
                        exit;
                    } else {
                        $login_err = "Invalid email or password.";
                    }
                } else {
                    $login_err = "Invalid email or password.";
                }
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nayre Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="floating-shapes"></div>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <p>Sign in to view the portfolio</p>

            <?php if(!empty($login_err)): ?>
                <div class="error-message"><?php echo $login_err; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email">
                    <?php if(!empty($email_err)): ?>
                        <span class="error-text"><?php echo $email_err; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'error' : ''; ?>" placeholder="Enter your password">
                    <?php if(!empty($password_err)): ?>
                        <span class="error-text"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-primary" id="loginBtn">
                    <span class="loading-spinner"></span>
                    <span class="btn-text">Login</span>
                </button>
            </form>

            <div class="switch-form">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

    <script>
        // Add loading animation to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const btnText = btn.querySelector('.btn-text');

            btn.classList.add('loading');
            btnText.textContent = 'Signing in...';

            // Add a small delay to show animation
            setTimeout(() => {
                // Form will submit after this
            }, 300);
        });

        // Add focus animations to form inputs
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>