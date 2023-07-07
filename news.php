
<?php
session_start();
$sql = "SELECT n.id, n.title, n.description, n.created_at, n.image_url, c.name as category FROM news n inner join category c on n.category_id = c.id";

include './config.php';

if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {

    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/news.css">
    <title>Latest News</title>
</head>

<body>
    
<?php include './component/header.php' ?>

    <section class="news-container">
        <?php
            while ($row = $result->fetch_assoc()) {
                echo '<div class="news-card">';
                echo '<a href="viewnews.php?id=' .$row["id"] . '"><img src="'. $row['image_url']. '" alt="News Image"></a>';
                echo '<h2>'.$row['title'] .'</h2>';
                echo '<p style="max-height: 42px; line-clamp: 2; overflow: hidden; text-overflow: ellipsis;">'.$row['description'].'</p>';
                echo '</div>';
            }
        ?>
    </section>
    
</body>

</html>
