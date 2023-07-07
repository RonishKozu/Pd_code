<?php
session_start();
if (isset($_SESSION['SESSION_ADMIN'])) {
    if (!$_SESSION['SESSION_ADMIN']) {
        header("Location: /final_project/home");
        die();
    }
}

$title = $description = $category = $location = $genderRepresentation = $url = $startsAt = $endsAt = "";
$titleError = $descriptionError = $categoryError = $locationError = $genderRepresentationError = $urlError = $startsAtError = $endsAtError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = (int) trim($_POST['category']);
    $location = trim($_POST['location']);
    $genderRepresentation = trim($_POST['gender_representation']);
    $url = trim($_POST['url']);
    $startsAt = trim($_POST['starts_at']);
    $endsAt = trim($_POST['ends_at']);

    if ($title == '') {
        $titleError = 'Title field is required!';
    }

    if ($description == '') {
        $descriptionError = 'Description field is required!';
    }

    if ($category == '') {
        $categoryError = 'Category field is required!';
    }

    if ($location == '') {
        $locationError = 'Location field is required!';
    }

    if ($genderRepresentation == '') {
        $genderRepresentationError = 'Gender Representation field is required!';
    }

    if ($url == '') {
        $urlError = 'Url field is required!';
    } else {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $urlError = 'Invalid url format!';
        }
    }

    if ($startsAt == '') {
        $startsAtError = 'Starts at field is required!';
    }

    if ($endsAt == '') {
        $endsAtError = 'Ends at field is required!';
    }

    if ($titleError == "" && $descriptionError == "" && $urlError == "" && $startsAtError == "" && $endsAtError == "") {
        require "../config.php";

        $sql = "INSERT INTO broadcast(title, description, category_id, location, gender_representation, url, starts_at, ends_at) VALUES ('{$title}', '{$description}', '{$category}', '{$location}', '{$genderRepresentation}', '{$url}', '{$startsAt}', '{$endsAt}')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("location: broadcast-d.php");
            $conn->close();
        } else {
            echo "Error Inserting record" . mysqli_error($conn);
        }
    }
}
?>

<?php
require "../config.php";

$query = "SELECT * FROM category";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>title-placeholder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php require "../component/header.php" ?>
    <div class="contain-main">
        <?php require "../component/sidebar.php" ?>
        <div class="box">
            <div class="contain-title">
                <h1>Broadcast Create</h1>
                <p>
                    <a href="broadcast-d.php">
                        <i class="fas fa-arrow-left"></i>
                        BACK
                    </a>
                </p>
            </div>
            <div class="form-container">
                <form action="create.php" method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <div class="in-box">
                            <input type="text" name="title" class="form-control" value="<?= $title; ?>">
                            <p class="text-danger-edit">
                                <?= $titleError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <div class="in-box">
                            <textarea name="description" class="form-control" rows="6"><?= $description; ?></textarea>
                            <p class="text-danger-edit">
                                <?= $descriptionError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <div class="in-box">
                            <select name="category" class="form-control">
                                <option value=""></option>
                                <?php
                                foreach ($options as $option) {
                                    ?>
                                    <?php echo "<option value={$option['id']}" ?>
                                    <?php if ($category == $option['id'])
                                        echo "selected" ?>
                                    <?php echo ">" ?>
                                    <?php echo "{$option['name']}" ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <p class="text-danger-edit">
                                <?= $categoryError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <div class="in-box">
                            <input type="text" name="location" class="form-control" value="<?= $location; ?>">
                            <p class="text-danger-edit">
                                <?= $locationError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gender_representation">Gender Representation</label>
                        <div class="in-box">
                            <select name="gender_representation" class="form-control">
                                <option value=""></option>
                                <option value="Male" <?php if ($genderRepresentation == "Male")
                                    echo "selected" ?>>Male
                                    </option>
                                    <option value="Female" <?php if ($genderRepresentation == "Female")
                                    echo "selected" ?>>
                                        Female</option>
                                    <option value="Hybrid" <?php if ($genderRepresentation == "Hybrid")
                                    echo "selected" ?>>
                                        Hybrid</option>
                                </select>
                                <p class="text-danger-edit">
                                <?= $genderRepresentationError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='url'>Url</label>
                        <div class="in-box">
                            <input type="text" name="url" value="<?= $url; ?>" class="form-control">
                            <p class="text-danger-edit">
                                <?= $urlError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='starts_at'>Starts At</label>
                        <div class="in-box">
                            <input type="datetime-local" value="<?= $startsAt; ?>" name="starts_at"
                                class="form-control">
                            <p class="text-danger-edit">
                                <?= $startsAtError ?>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for='ends_at'>Ends At</label>
                        <div class="in-box">
                            <input type="datetime-local" value="<?= $endsAt; ?>" name="ends_at" class="form-control">
                            <p class="text-danger-edit">
                                <?= $endsAtError ?>
                            </p>
                        </div>
                    </div>

                    <input type="Submit" value="CREATE BROADCAST" class="btn-submit">
                </form>
            </div>
        </div>
    </div>
    <?php require "../component/footer.php" ?>
</body>

</html>