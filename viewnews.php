<?php
include './config.php';

$sql;

if (isset($_GET['id'])) {
    $newsId = (int) mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM news n INNER JOIN category c on n.category_id = c.id WHERE n.id={$newsId};";
}
?>

<?php
include './config.php';

$sql;

if (isset($_GET['id'])) {
    $newsId = (int) mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM news n INNER JOIN category c on n.category_id = c.id WHERE n.id={$newsId};";
}
?>

<style>
    .container-fluid {
  padding: 20px;
}

.fh5co-post-entry {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.fh5co-meta {
  display: block;
  font-size: 20px;
  color: #888;
  margin-bottom: 10px;
}

.fh5co-article-title {
  font-size: 32px;
  margin-top: 0;
  margin-bottom: 20px;
  text-align: center;
}

.fh5co-meta.fh5co-date {
  font-style: italic;
}

.img-responsive {
  max-width: 100%;
  height: auto;
  margin-bottom: 20px;
}

.content-article {
  margin-top: 30px;
}

.content-article .row {
  margin-top: 15px;
}

.content-article .animate-box {
  font-size: 25px;
  line-height: 1.6;
  text-align: justify;
  l
}

.back-button {
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 999;
  background-color: gray;
  padding: 10px 15px;
  border-radius: 10px;
  font-size: 16px;
  color: white;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
  .back-button {
    top: 10px;
    left: 10px;
    padding: 8px 12px;
    font-size: 14px;
  }
}


</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<a href="news.php" class="back-button" style="text-decoration: none;"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
<div class=" container-fluid" style="margin-inline: 80px;">
        <div class="row fh5co-post-entry single-entry">
            <article
                class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
                <?php
                if ($result = $conn->query($sql)) {
                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        echo '<figure class="animate-box"><img src="' . $row['image_url'] . '" alt="Image" class="img-responsive"></figure>';
                        echo '<span class="fh5co-meta animate-box">' . $row['name'] . '</span>';
                        echo '<h2 class="fh5co-article-title animate-box">' . $row['title'];
                        echo '</h2>'; 
                        echo '<span class="fh5co-meta fh5co-date animate-box"> ' . $row['created_at'] . ' </span>';
                        echo '<div class="col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-left content-article"><div class="row"><div class="animate-box">' . $row['description'] . '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
        </div>
            </article>

