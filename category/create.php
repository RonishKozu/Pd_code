<?php
    session_start();
    if (isset($_SESSION['SESSION_ADMIN'])) {
        if(!$_SESSION['SESSION_ADMIN']){
            header("Location: /secure-auth/home");
            die();
        }
    }

    $name = "";
    $nameError = "";
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = trim($_POST['name']);

        if ($name == '') {
            $nameError = 'Title field is required!';
        }

        if ($nameError == "") {
            require "../config.php";

            $sql = "INSERT INTO category(name) VALUES ('{$name}')";
            $result = mysqli_query($conn, $sql);

            if($result){
                header("location: category-d.php");
                $conn->close();
            }else{
                echo "Error Inserting record" . mysqli_error($conn);
            }
        }
    }
?> 

<!DOCTYPE html>
<html>
    <head>
        <title>title-placeholder</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link
        rel="stylesheet"
        href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
        crossorigin="anonymous"
        />
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <?php require "../component/header.php" ?>
        <div class="contain-main">
            <?php require "../component/sidebar.php" ?>
            <div class="box">
                <div class="contain-title">
                    <h1>CATEGORY CREATE</h1>
                    <p>
                        <a href="category-d.php">
                            <i class="fas fa-arrow-left"></i>
                            BACK
                        </a>
                    </p>
                </div>
                <div class="form-container">
                    <form action="create.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="in-box">
                                <input type="text" name="name" class="form-control" value="<?= $name; ?>">
                                <p class="text-danger-edit"> <?= $nameError ?> </p>
                            </div>
                        </div>

                        <input type="Submit" value="CREATE CATEGORY" class="btn-submit">
                    </form>     
                </div>
            </div>
        </div>
        <?php require "../component/footer.php" ?>
    </body>
</html>
