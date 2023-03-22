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

// array
$menu_items = array();

// retrieve data from the database
$sql = "SELECT `food`.*
FROM `food` WHERE `food`.`cat_id` = 2;";
// show all list in food
// $sql = "SELECT pizza.pz_id, pizza.pz_name, food.fd_image, food.fd_price AS min_price, food.fd_id
//             FROM pizza
//             INNER JOIN pizza_detail ON pizza.pz_id = pizza_detail.pz_id
//             INNER JOIN food ON pizza_detail.fd_id = food.fd_id";
$result = $pdo->query($sql);

$result->execute();

// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        'fd_id' => $row['fd_id'],
        'fd_image' => $row['fd_image'],
        'fd_price' => $row['fd_price'],
        'fd_name' => $row['fd_name']
        // 'pz_name' => $row['pz_name'],
        // 'pz_id' => $row['pz_id'],
    );

    array_push($menu_items, $menu_item);
}

if(isset($_POST['submit'])) {
    // echo "test";
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    // echo $_POST['food_id'];
    $id = $_POST['food_id'];

    $query = $pdo->prepare("SELECT `food`.*
    FROM `food` WHERE `food`.`fd_id` = :id;");
    $query->bindParam(':id', $id);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    $price = $row['fd_price'];
    // echo $price;

    // check if have a item
    $select_itemcart = $pdo->prepare("SELECT * FROM `cart_item` WHERE `cart_id` = ? AND `fd_id` = ?");
    $select_itemcart->execute([$cart_id, $id]);
    $itemcart_row = $select_itemcart->fetch(PDO::FETCH_ASSOC);

    if($select_itemcart->rowCount() == 0) {
        // add
        $insert_itemcart = $pdo->prepare("INSERT INTO cart_item (cart_id, fd_id, quantity, cartit_total) VALUES (?, ?, ?, ?)");
        $insert_itemcart->execute([$cart_id , $id, 1, $price]);
    } else {
        $item_id = $itemcart_row['cart_itemid'];
        $quantity = $itemcart_row['quantity'] + 1;
        $update_itemcart = $pdo->prepare("UPDATE cart_item SET quantity = :quantity WHERE cart_itemid = :id");
        $update_itemcart->bindValue(":quantity", $quantity);
        $update_itemcart->bindValue(":id", $item_id);
        $update_itemcart->execute();
    }


}

// array
$items = array();

// echo $cart_id;

// $sql = "SELECT cart_item.cart_id, cart_item.quantity, food.fd_id, food.fd_price
//             FROM cart_item
//             LEFT JOIN food ON cart_item.fd_id = food.fd_id
//             WHERE cart_item.cart_id = ?";
$selectall_itemcart = $pdo->prepare("SELECT cart_item.cart_itemid, cart_item.cart_id, cart_item.quantity, food.fd_id, cart_item.cartit_total
FROM cart_item
LEFT JOIN food ON cart_item.fd_id = food.fd_id
WHERE cart_item.cart_id = ?");
$selectall_itemcart->execute([$cart_id]);
// $selectall_itemcart->bindValue(":id", $row['cart_id']);
// $selectall_itemcart->execute();


while ($allitemcart_row = $selectall_itemcart->fetch(PDO::FETCH_ASSOC)) {
    $item = array(
        'fd_id' => $allitemcart_row['fd_id'],
        'cartit_total' => $allitemcart_row['cartit_total'],
        'quantity' => $allitemcart_row['quantity'],
    );

    array_push($items, $item);
}

$cart_total = 0;

foreach ($items as $item):
    // echo $cart_total;
    $sumitem = $item['cartit_total'] *  $item['quantity'];
    $cart_total += $sumitem;

    $udcart = $pdo->prepare("UPDATE shopping_cart SET cart_total= :cart_total WHERE cart_id  = :id");
    $udcart->bindValue(":cart_total", $cart_total);
    $udcart->bindValue(":id", $cart_id);
    $udcart->execute();
endforeach;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chicken</title>
    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"></head>

<body>

<?php require_once '../components/user_header_new.php'; ?>
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
    <h3 style = "text-align: center; padding-top : 1em;">Chicken</h3>


    <div class="container">
        <div class="product_container" >
        <?php foreach ($menu_items as $item): ?>
            <form action="" method="post" id="form">
                <div class="card d-flex justify-content-between p-1" style="width: 18rem; border-radius: 12px !important ; border: 1px solid green;">
                    <img class="card-img-top" src="<?php echo $item['fd_image']; ?>" alt="Card image cap" >
                    <div class="card-body1 text-center d-flex align-items-center flex-column" style="padding-bottom: 1em;">
                    <h5 class="card-title"><?php echo $item['fd_name']; ?></h5>
                    
                    <button type="submit" form="form" name="submit" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                        <input type="text" style="display:none;" name="food_id" value="<?php echo $item['fd_id']; ?>">    
                        <span><?php echo number_format($item['fd_price'], 2); ?> ฿</span>
                        <span>
                            <img src="https://1112.com/images/cart_select.svg" alt="bucket">
                        </span>
                    </button>
                    </div>
                </div>
            </form>
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>