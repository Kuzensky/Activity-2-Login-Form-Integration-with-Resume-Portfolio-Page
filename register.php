<?php
session_start();
require_once 'db.php';

$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = $success_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter a valid email address.";
    } elseif(!preg_match('/@gmail\.com$/', trim($_POST["email"]))){
        $email_err = "Please use a Gmail address (@gmail.com).";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(1, $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
            unset($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must be at least 6 characters long.";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }

    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(1, $param_email, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_password, PDO::PARAM_STR);

            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if($stmt->execute()){
                $success_msg = "Registration successful! You can now login.";
                $email = $password = $confirm_password = "";
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
    <title>Register - Nayre Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="floating-shapes"></div>
    <div class="container">
        <div class="form-container">
            <h2>Create Account</h2>
            <p>Register to access the portfolio</p>

            <?php if(!empty($success_msg)): ?>
                <div class="success-message"><?php echo $success_msg; ?></div>
            <?php endif; ?>

            <div class="gmail-note">
                Please use your Gmail address (@gmail.com) to register.
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>" placeholder="yourname@gmail.com">
                    <?php if(!empty($email_err)): ?>
                        <span class="error-text"><?php echo $email_err; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'error' : ''; ?>" placeholder="At least 6 characters">
                    <?php if(!empty($password_err)): ?>
                        <span class="error-text"><?php echo $password_err; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'error' : ''; ?>" placeholder="Confirm your password">
                    <?php if(!empty($confirm_password_err)): ?>
                        <span class="error-text"><?php echo $confirm_password_err; ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-primary" id="registerBtn">
                    <span class="loading-spinner"></span>
                    <span class="btn-text">Create Account</span>
                </button>
            </form>

            <div class="switch-form">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <script>
        // Add loading animation to form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.getElementById('registerBtn');
            const btnText = btn.querySelector('.btn-text');

            btn.classList.add('loading');
            btnText.textContent = 'Creating Account...';

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

        // Add real-time email validation
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const value = this.value;
                if (value && !value.includes('@gmail.com')) {
                    this.style.borderColor = '#ffa500';
                } else if (value.includes('@gmail.com')) {
                    this.style.borderColor = '#51cf66';
                } else {
                    this.style.borderColor = '';
                }
            });
        }

        // Password strength indicator
        const passwordInput = document.querySelector('input[name="password"]');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const value = this.value;
                const length = value.length;

                if (length < 6) {
                    this.style.borderColor = length > 0 ? '#ff6b6b' : '';
                } else {
                    this.style.borderColor = '#51cf66';
                }
            });
        }
    </script>
</body>
</html>