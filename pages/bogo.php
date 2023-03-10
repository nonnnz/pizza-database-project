<?php

session_start();
// Include the database connection file
require_once "../components/connect.php";

// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
}

// array
$menu_items = array();

// retrieve data from the database
// $sql = "SELECT pizza.pz_id, pizza.pz_name, food.fd_image, MIN(food.fd_price) AS min_price, food.fd_id
//             FROM pizza
//             INNER JOIN pizza_detail ON pizza.pz_id = pizza_detail.pz_id
//             INNER JOIN food ON pizza_detail.fd_id = food.fd_id
//             GROUP BY pizza.pz_name";
// show all list in food
$sql = "SELECT pizza.pz_id, pizza.pz_name, food.fd_image, food.fd_price AS min_price, food.fd_id
            FROM pizza
            INNER JOIN pizza_detail ON pizza.pz_id = pizza_detail.pz_id
            INNER JOIN food ON pizza_detail.fd_id = food.fd_id";
$result = $pdo->query($sql);

$result->execute();

// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        'fd_id' => $row['fd_id'],
        'fd_image' => $row['fd_image'],
        'fd_price' => $row['min_price'],
        'pz_name' => $row['pz_name'],
        'pz_id' => $row['pz_id'],
    );

    array_push($menu_items, $menu_item);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bogo</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"></head>

<body>

<?php require_once '../components/user_header_new.php'; ?>

    <div class="home-category" style = "margin-top: 80px ">

        <h4 style = "margin-left : 6em;"> <img src="https://cdn.1112.com/1112/public/images/web/menu.svg" alt="Cheese"> </img>
            Menu</h4>
        <div class="category_container" >
            <a href="#">
                <div class="box bbox1">
                    <h6>Pizza</h6>
                </div>
            </a>
            <a href="#">
                <div class="box2 bbox2">
                    <h6 id="bottom">Appetizer</h6>
                </div>
            </a>
            <a href="#">
                <div class="box2 bbox3">
                    <h6 id="bottom">Chicken</h6>
                </div>
            </a>
            <a href="#">
                <div class="box2 bbox4">
                    <h6 id="bottom">Pasta</h6>
                </div>
            </a>
            <a href="#">
                <div class="box2 bbox5">
                    <h6 id="bottom">Salad & Steak</h6>
                </div>
            </a>
            <a href="#">
                <div class="box2 bbox6">
                    <h6 id="bottom">Drink & <br>Desserts</h6>
                </div>
            </a>
            
        </div>
    </div>
    
    <h3 style = "text-align: center; padding-top : 1em;">SPECIAL DEAL BUY 1 GET 1 FREE</h3>
    <div class="container">

        <div class="product_container" >
            <?php foreach ($menu_items as $item): ?>
                <div class="product">
                    <div class="product_item">
                        <img src="<?php echo $item['fd_image']; ?>" alt="<?php echo $item['pz_name']; ?>" style = "width : 100% ;  height : 217px ;">
                    
                    </div>
                    <div class="item-footer">
                        <h5><?php echo $item['pz_name']; ?></h5>
                        <a  href="select_pizza.php?id=<?php echo $item['fd_id']; ?>" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                            <span><?php echo $item['fd_price']; ?></span>
                            <span>
                                <i class="fa fa-plus right txt" style="margin-right: 5px;"></i>Select
                            </span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            
        </div>
    </div>
        
    </body>
    </html>