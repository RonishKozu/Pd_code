<?php
    session_start();

    include 'config.php';

    $msg = "";

    if (isset($_GET['reset'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
            if (isset($_POST['submit'])) {
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $salt = "D;%yL9TS:5PalS/d";
                $hashedPassword = hash('sha256', $password . $salt);

                if ($password === $confirm_password) {
                    $uppercase = preg_match('@[A-Z]@', $password);
                    $lowercase = preg_match('@[a-z]@', $password);
                    $number = preg_match('@[0-9]@', $password);
                    $specialChars = preg_match('@[^\w]@', $password);

                    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 12) {
                        $msg = "<div class='alert alert-danger'>Password should be at least 12 characters in length, should include at least one upper case letter, one number, and one special character</div>";
                    } else {
                        $sqlSelect = "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'";
                        $result = mysqli_query($conn, $sqlSelect);

                        if (mysqli_num_rows($result) === 1) {
                            $row = mysqli_fetch_assoc($result);
                            $passwd = $row["password"];

                            if ($passwd == $hashedPassword) {
                                $msg = "<div class='alert alert-danger'>Can not use previously used password</div>";
                            } else {
                                $query = "UPDATE users SET password='$hashedPassword' WHERE email='{$_SESSION['SESSION_EMAIL']}'";
                                $res =mysqli_query($conn, $query);

                                if($res){
                                    $msg = "<div class='alert alert-success'>Password changed sucessfully.</br>Please login to continue</div>";
                                }else{
                                    $msg = "<div class='alert alert-danger'>Some Error Occured</div>";
                                }
                            }
                        }
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Password and Confirm Password doesn't match</div>";
                }
            }
        } else {
            $msg = "<div class='alert alert-danger'>Invalid Link</div>";
        }
    } else {
        if (isset($_SESSION['SESSION_LOGGED_IN'])) {
            header("Location: home");
            die();
        }
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>change_password_db</title>
    
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
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    
                    <div class="content-wthree">
                        <h2>Change Password</h2>
                        <p>enter new password</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                        <input id="psw-input" type="password" class="form-control" name="password" placeholder="Put Password" style="margin-bottom: 2px;" required>
                            <div id="pswmeter" class="mt-3"></div>
                            <div id="pswmeter-message" class="mt-3"></div>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="index.php">Login</a>.</p>
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
                'Insert password',
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

</body>

</html>