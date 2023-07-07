<!DOCTYPE html>
<html>
    <head>
        <title>About Us Section</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1,0">
        <link rel="stylesheet" type="text/css" href="./aboutus.css">
        <style>
            *{
    margin:0px;
    padding:0px;
    box-sizing: border-box;
    font-family: sans-serif;
}
body{
    background: lavender;
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
.heading{
    text-align: center;
    margin-top: 25px;
}
.heading h1{
    font-size: 50px;
    color: #36455c;
    margin-bottom: 10px;
}
.heading p{
    font-size: 20px;
    color: #666;
    margin-bottom: 50px;
}
.about-us{
    display: flex;
    align-items: center;
    width: 85%;
    margin: auto;
}
.about-us img{
    flex: 0 50%;
    max-width: 50%;
    box-shadow: 10px 10px 6px 10px rgba(0,0,0,0.2);
    z-index: 10;
    height: auto;
}
.content{
    flex: 0 50%;
    background-color: #f9f9f9;
    padding: 35px;
}
.content h2{
    color: #36455c;
    font-size: 24px;
    margin: 15px 0px;
    font-family: "Dokdo", cursive;
}
.content p{
    color: #666;
    font-size: 18px;
    line-height: 1.5;
    margin: 15px 0px;
}


@media(max-width: 768px){
    .about-us{
        flex-direction: column;
    }
    .about-us img{
        flex:0 100%;
        max-width: 100%;
    }
    .content{
        flex:0 100%;
        max-width: 100%;
        padding:15px;
    }
}

        </style>
    </head>
    <body>
        <?php 
        session_start();
        include './component/header.php' ?>
        <div class="heading">
            <h1>About Us</h1>
            <p>FunOlympic Games 2023</p>
        </div>
        <section class="about-us">
            <img src="./images/aboutus.png">
            <div class="content">
                <h2>Kind Information</h2>
                <p>At FunOlympic Games, we are dedicated to bringing the spirit of the Olympics to life. We provide a live streaming platform that allows you to experience the excitement of the games in real-time. From thrilling races to fierce competitions, our platform offers a front-row seat to all the action. Join us as we celebrate the athletes, the sportsmanship, and the moments of triumph that make the Olympics so special. Get ready to immerse yourself in the world of FunOlympic Games and witness the magic unfold before your eyes.</p>
            </div>
        </section>
        
    </body>
</html>
