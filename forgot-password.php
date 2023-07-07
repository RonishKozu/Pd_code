<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_SESSION['SESSION_LOGGED_IN'])) {
    header("Location: home");
    die();
}

require 'vendor/autoload.php';
include 'config.php';

$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));
    $_SESSION['SESSION_EMAIL'] = $email;

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

        if ($query) {
            $mail = new PHPMailer(true);

            try {
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
                $mail->Body = '<h1 style="color:#4070f4;">Secure Auth</h1><p>Change the password for your account using the link below</p><b><a href="http://localhost/final_project/change-password.php?reset=' . $code . '">http://localhost/final_project/change-password.php?reset=' . $code . '</a></b>';

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";
            $msg = "<div class='alert alert-info'>We've sent a link to change your password on your email address.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address do not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>forgot_password_db</title>
    
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
                        <h2>Forgot Password</h2>
                        <p>we will send you a reset link in your mail</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Type Your Email" required>
                            <button name="submit" class="btn" type="submit">Send Reset Link</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to <a href="index.php">Login</a>.</p>
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