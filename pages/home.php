<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
    $user_id = $_SESSION['user_id'];

    // if cart null
    $select_cart = $pdo->prepare("SELECT * FROM `shopping_cart` WHERE `user_id`  = ? AND `cart_active` = 1");
    $select_cart->execute([$user_id]);
    $cart_row = $select_cart->fetch(PDO::FETCH_ASSOC);

    // init cart
    if($select_cart->rowCount() == 0){
        $insert_cart = $pdo->prepare("INSERT INTO `shopping_cart` (user_id, cart_total) VALUES (?, ?)");
        $insert_cart->execute([$user_id, 0]);
    }

    // check cart again
    $select_cart = $pdo->prepare("SELECT * FROM `shopping_cart` WHERE `user_id`  = ? AND `cart_active` = 1");
    $select_cart->execute([$user_id]);
    $cart_row = $select_cart->fetch(PDO::FETCH_ASSOC);

    // get items


    // cart info
    $cart_total = $cart_row['cart_total'];
    $cart_id = $cart_row['cart_id'];
} else {
    // cart info
    $cart_total = 0;
    $cart_id = 0;
}


?>


<!DOCTYPE html>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="script.js"></script>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<?php require_once '../components/user_header_new.php'; ?>

    <div class="slider-frame">
        <div class="slide-images">
            <div class="img-container">
                <img src="https://cdn.1112.com/1112/public/images/banners/Feb2023/BOGO_1440_EN_1.jpg">
            </div>
        </div>
    </div>
    <div class="festive-bg" >
        <a href="bogo.php" class="q_order"style="padding-top :25px; display: flex; justify-content: center;">
            <div  >
                <button type="submit" style = "font-size : 23px; border-radius:12px" class="btn btn-success">START BUY 1 GET 1 NOW!!</button>
            </div>
        </a>
        
    <div class="home-category" style = "margin-bottom: 80px ">

        <h4 style = "margin-left : 6em;"> <img src="https://cdn.1112.com/1112/public/images/web/menu.svg" alt="Cheese"> </img>
            Menu</h4>
        <div class="category_container" >
            <a href="bogo.php">
                <div class="box bbox1">
                    <h6>Pizza</h6>
                </div>
            </a>
            <a href="apptizer.php">
                <div class="box2 bbox2">
                    <h6 id="bottom">Appetizer</h6>
                </div>
            </a>
            <a href="chicken.php">
                <div class="box2 bbox3">
                    <h6 id="bottom">Chicken</h6>
                </div>
            </a>
            <a href="pasta.php">
                <div class="box2 bbox4">
                    <h6 id="bottom">Pasta</h6>
                </div>
            </a>
            <a href="salad.php">
                <div class="box2 bbox5">
                    <h6 id="bottom">Salad & Steak</h6>
                </div>
            </a>
            <a href="drink.php">
                <div class="box2 bbox6">
                    <h6 id="bottom">Drink & <br>Desserts</h6>
                </div>
            </a>
            
        </div>
    </div>
    <!-- <div class="home-category" >

        <h3 style = "margin-left : 8em;">Menu</h3>
        <div class="category_container">
            <a href="bogo.php" class="cate cate1" >
                <div >
                    <h4 id="bottom">Pizza</h4>
                </div>
            </a>
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
    </div> -->
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