<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';

session_start();

$msg = "";

if (isset($_GET['verification'])) {
    $verificationCode = mysqli_real_escape_string($conn, $_GET['verification']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE code='{$verificationCode}'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $isVerified = $row['is_verified'];

        if ($isVerified == "1") {
            header("Location: home");
        } else {
            $query = mysqli_query($conn, "UPDATE users SET code='',is_verified='1' WHERE code='{$verificationCode}'");

            if ($query) {
                if (isset($_SESSION['SESSION_LOGGED_IN'])) {
                    header("Location: home");
                    die();
                }
                $msg = "<div class='alert alert-success'>Your account has been verified</div>";
            }
        }
    }
} else {
    if (isset($_SESSION['SESSION_LOGGED_IN'])) {
        header("Location: home");
        die();
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $salt = "D;%yL9TS:5PalS/d";
    $hashedPassword = hash('sha256', $password . $salt);

    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$hashedPassword}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['SESSION_ID'] = $row['id'];
        $_SESSION['SESSION_EMAIL'] = $email;
        $_SESSION['SESSION_ADMIN'] = $row['is_admin'] === "0" ? FALSE : TRUE;
        $cookie_name = "userName";
        $cookie_value = substr($email, 0, strpos($email, '@'));
        setcookie($cookie_name, $cookie_value, 0, "/"); // 86400 = 1 day

        $account_verified = $row['is_verified'];
        $code = $row['code'];

        if ($account_verified == "1") {
            $_SESSION['SESSION_LOGGED_IN'] = true;
            header("Location: home");
        } else {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'secureauth315@gmail.com';
            $mail->Password = 'iptvrxkdxteayegf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('secureauth315@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'no reply';
            $mail->Body = '<h1 style="color:#4070f4;">Secure Auth</h1><p>Click the link provided below to verify your account and get access to our features.</p><b><a href="http://localhost/final_project/login.php?verification=' . $code . '">http://localhost/final_project/login.php?verification=' . $code . '</a></b>';

            $mail->send();

            $msg = "<div class='alert alert-danger'>Account Verification Needed!<p>Check your email to verify your account</p></div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email or password</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>login_db</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="./css/auth.css" type="text/css" media="all" />
    

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    
    <section class="w3l-mockup-form">
        <div class="container">
            
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    
                    <div class="content-wthree">
                        <h2>Login Here</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>

                        <div class="social-icons">
                            <p>Create Account! <a href="register.php">Register</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });

            
        });
    </script>

</body>

</html>