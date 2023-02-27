<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";

// check if the user is logged in
// $name = "Guest";
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     if($_SESSION["email"] == "admin@gmail.com") {
//         $name = "Admin";
//     } else {
//         $name = $_SESSION["fname"];
//     }
// }

// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['email'])){
    $name = $_SESSION["fname"];
}

// if (isset($_SESSION['email'])) {
//     // Redirect to login page
//     $name = $_SESSION["fname"];
// }

?>


<!DOCTYPE html>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="homestyle.css">
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="header" >
        <div class="inner_header">
            <div class="logo_container">
                <h1>112Pizza</h1>
            </div>
            <ul class = "navigation">
                <li><a href="#">Menu</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <?php if(isset($_SESSION['email'])): ?>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="login.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="slider-frame">
        <div class="slide-images" style = "margin-top: 80px">
            <div class="img-container">
                <img src="https://cdn.1112.com/1112/public/images/banners/Feb2023/BOGO_1440_EN_1.jpg">
            </div>
            <!-- <div class="img-container">
                <img src="https://cdn.1112.com/1112/public/images/banners/Feb2023/Ecomm-1440_TH.jpg">
            </div>
            <div class="img-container">
                <img src="https://cdn.1112.com/1112/public/images/banners/Feb2023/Coke2_X_Sewensent_1440_TH.jpg">
            </div> -->
        </div>
    </div>
    <div class="festive-bg" >
        <div class="q_order"style="padding-top :25px; display: flex; justify-content: center;" >
            <button type="submit" style = "font-size : 23px; border-radius:12px" class="btn btn-success">START BUY 1 GET 1 NOW!!</button>
        </div>

    <div class="home-category" >

        <h3 style = "margin-left : 8em;">Menu</h3>
        <div class="category_container">
            
            <div class="cate cate1" >
                <h4 id="bottom">Pizza</h4>
            </div>
            <div class="cate cate2">
                <h4 id="bottom">Pizza of the<br>month</h4>
            </div>
            <div class="cate cate3">
                <h4 id="bottom">Appetizer</h4>
            </div>
            <div class="cate cate4">
                <h4 id="bottom">Chicken</h4>
            </div>
            <div class="cate cate5">
                <h4 id="bottom">Pasta</h4>
            </div>
            <div class="cate cate6">
                <h4 id="bottom">Salad & Steak</h4>
            </div>
            
        </div>
    </div>
    </div>
    

    <!-- <div class="container">
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <?php if(isset($_SESSION['email'])): ?>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="login.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="main-content">
            <?php if(isset($_SESSION['email'])): ?>
                <h1>Welcome, <?php echo $name; ?>!</h1>
            <?php else: ?>
                <h1>Welcome to The Pizza Company!</h1>
            <?php endif; ?>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ac libero quis massa suscipit tristique ac a urna. Fusce iaculis sit amet nunc eu laoreet. Vivamus blandit laoreet turpis, nec blandit justo iaculis id. Pellentesque congue tortor et dolor suscipit, at hendrerit dui aliquam. Quisque dignissim purus vel sapien dignissim aliquet. Aliquam dignissim convallis dolor ac iaculis. In euismod pellentesque convallis. Aliquam erat volutpat. Integer posuere vel elit a elementum. Fusce posuere, augue quis pulvinar vulputate, ipsum tellus congue magna, id tempus velit sapien sed dolor. Pellentesque non lobortis felis. Aliquam et sem ut nibh ultricies bibendum nec ut nunc. Integer eu interdum odio. Ut laoreet iaculis faucibus.</p>
        </div>
    </div> -->
</body>
</html>