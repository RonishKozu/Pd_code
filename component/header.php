<?php
// session_start();
function active($page)
{
  $url_array = explode('/', $_SERVER['REQUEST_URI']);
  $url = end($url_array);
  if ($page == $url) {
    return TRUE;
  }
  return FALSE;
}

function activeLinkContains($keyword)
{
  if (strpos($_SERVER['REQUEST_URI'], $keyword) !== false) {
    return TRUE;
  }
  return FALSE;
}
?>

<style>

  *{
    font-family: "Sans Serif";
    font-size:18px;
  }
  header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  
  }



.logo-container img {
    width: 50px;
    height: auto;
    position:relative;
  }
  
  
  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
  }
  
  nav li {
    margin-right: 20px;
  }
  
  nav a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  nav a:hover {
    color: #ccc;
  }
  
  nav .active {
    color: #ccc;
  }
</style>
<header>
        <div class="logo-container">
            <img src="/final_project/images/logo.png" alt="Company Logo">
        </div>
        <nav>
            <ul>
                <li><a style="<?php if (activeLinkContains('home') or active('schedule.php'))
                echo "color: white; font-weight:bold;" ?>" href="/final_project/home">Home</a></li>
                <li><a style="<?php if (active('news.php'))
                echo "color: white; font-weight:bold;" ?>" href="/final_project/news.php">Latest News</a></li>
                <li><a style="<?php if (active('aboutus.php'))
                echo "color: white; font-weight:bold;" ?>" href="/final_project/aboutus.php">About Us</a></li>
                <li><a style="<?php if (active('contactus.php'))
                echo "color: white; font-weight:bold;" ?>" href="/final_project/contactus.php">Contact Us</a></li>
                <li><a style="<?php if (active('gallery.php'))
                echo "color: white; font-weight:bold;" ?>" href="/final_project/gallery.php">Gallery</a></li>
                <?php
                  $path = $_SERVER['DOCUMENT_ROOT'];
                  $path .= "/final_project/config.php";

                  include $path;
                  $sessionEmail = isset($_SESSION['SESSION_EMAIL']) ? $_SESSION['SESSION_EMAIL'] : FALSE;

                  $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$sessionEmail}'");

                  if (mysqli_num_rows($query) == 1) {
                    echo '<li><a href="/final_project/logout.php">Logout</a></li>';
                  } else {
                    echo '<li><a href="/final_project/login.php">Login</a></li>';
                  }
              ?>
            </ul>
        </nav>
    </header>