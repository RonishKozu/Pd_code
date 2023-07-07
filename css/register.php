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
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, ($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
    $code = mysqli_real_escape_string($conn, md5(rand()));
    $is_admin = 0;
    $is_verified = 0;

    $sk = $_POST['g-recaptcha-response'];
    $site_key = "6Lfo1GAlAAAAAADLuTYY68ZJY8ekGkuSU6QHkAHP";
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$site_key&response=$sk&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire, true);

    if ($data['success'] == "true") {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 12) {
            $msg = "<div class='alert alert-danger'>Password should be at least 12 characters in length, should include at least one upper case letter, one number, and one special character</div>";
        } else {
            $salt = "D;%yL9TS:5PalS/d";
            $hashedPassword = hash('sha256', $password . $salt);

            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
                $msg = "<div class='alert alert-danger'>This email is already registered</div>";
            } else {
                if ($password === $confirm_password) {
                    $sql = "INSERT INTO users (name, email, password, code, is_admin, is_verified) VALUES ('{$name}', '{$email}', '{$hashedPassword}', '{$code}', '{$is_admin}', '{$is_verified}')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<div style='display: none;'>";
                        $mail = new PHPMailer(true);

                        try {
                            $mail->isSMTP();
                            $mail->SMTPDebug = 1;
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
                            $mail->Body = '<h1 style="color:#4070f4;">Secure Auth</h1><p>Click the link provided below to verify your account and get access to our features.</p><b><a href="http://localhost/pd-finalProject/login.php?verification=' . $code . '">http://localhost/pd-finalProject/login.php?verification=' . $code . '</a></b>';

                            $mail->send();
                            echo 'Message has been sent';
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                        echo "</div>";
                        $msg = "<div class='alert alert-info'>Check your email to verify your account</div>";
                        $name = "";
                        $email = "";
                    } else {
                        $msg = "<div class='alert alert-danger'>Some Error Occured</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Password and Confirm password doesn't match</div>";
                }
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Verification Needed<p>Please verify you are not a robot</p></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>register form - register_db</title>
    
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
                        <h2>Register Now</h2>
                        <p>enter the required details here.. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input id="psw-input" type="password" class="form-control" name="password" placeholder="Put Password" style="margin-bottom: 2px;" required>
                            <div id="pswmeter" class="mt-3"></div>
                            <div id="pswmeter-message" class="mt-3"></div>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                            <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6Lfo1GAlAAAAADdslWQ4xXp_Bg9UwuGDlQN5OdqZ"></div>
                        </div>
                            <button name="submit" class="btn" type="submit">Register</button>

                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="index.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    

    <script src="js/jquery.min.js"></script>
    <script src="js/pswmeter.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });

            
            const myPassMeter = passwordStrengthMeter({
            containerElement: '#pswmeter',
            passwordInput: '#psw-input',
            showMessage: true,
            messageContainer: '#pswmeter-message',
            messagesList: [
                'Type Password',
                'Too easy to guess',
                'Fair',
                'Better',
                'Strong ;)'
            ],
            height: 6,
            borderRadius: 0,
            pswMinLength: 8,
            colorScore1: '#aaa',
            colorScore2: '#aaa',
            colorScore3: '#aaa',
            colorScore4: 'limegreen'
            });
        });
        
    </script>
    
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>