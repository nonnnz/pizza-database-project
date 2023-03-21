<?php
session_start();

require_once "../components/connect.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
}

$user_id = $_SESSION['user_id'];

// retrieve all user address
$select_adds = $pdo->prepare("SELECT `address_book`.`addb_id`, `address_book`.`addb_name` FROM `address_book` WHERE `user_id`  = ?");
$select_adds->execute([$user_id]);
$adds_results = $select_adds->fetchAll(PDO::FETCH_ASSOC);

// array
$menu_items = array();

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

// cart info
$cart_total = $cart_row['cart_total'];
$cart_id = $cart_row['cart_id'];


$sql = "SELECT `shopping_cart`.`cart_id`, `shopping_cart`.`cart_total`, `cart_item`.`cart_itemid`, `cart_item`.`quantity`, `cart_item`.`cartit_total`, `food`.`fd_name`, `category`.`cat_id`, `pizza`.`pz_name`, `crust`.`crust_name`, `food`.`fd_price`
FROM `shopping_cart` 
	LEFT JOIN `cart_item` ON `cart_item`.`cart_id` = `shopping_cart`.`cart_id` 
	LEFT JOIN `food` ON `cart_item`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `category` ON `food`.`cat_id` = `category`.`cat_id`
	LEFT JOIN `pizza_detail` ON `pizza_detail`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `pizza` ON `pizza_detail`.`pz_id` = `pizza`.`pz_id` 
	LEFT JOIN `crust` ON `pizza_detail`.`crust_id` = `crust`.`crust_id`
    WHERE `shopping_cart`.`cart_id` = ?;";
$result = $pdo->prepare($sql);
$result->execute([$cart_id]);

// echo $result->rowCount();
// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        // 'fd_id' => $row['fd_id'],
        'fd_name' => $row['fd_name'],
        'fd_price' => $row['fd_price'],
        'cat_id' => $row['cat_id'],
        // 'pz_id' => $row['pz_id'],
        'pz_name' => $row['pz_name'],
        'cart_itemid' => $row['cart_itemid'],
        'quantity' => $row['quantity'],
        'crust_name' => $row['crust_name'],
        'cartit_total' => $row['cartit_total'],
    );

    array_push($menu_items, $menu_item);
}


if(isset($_POST['submit'])) {
    // Set session
    
    if($_POST['options-outlined'] == '1'){
        try {
            error_reporting(E_ERROR | E_PARSE);
            $_SESSION['deli_address'] = $_POST['addb-select'];
        } catch (Exception $e){
            
        }
    } else {
        $_SESSION['deli_address'] = $_POST['store-select'];
    }
    if ($_SESSION['deli_address']){
        $options_outlined = $_POST['options-outlined'];
        // $_SESSION['menu_item'] = $menu_item;
        header("Location: payment.php?opt=$options_outlined");
        exit();
    } else {
        $message = "address not found";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    
}


// deleting a item
if (isset($_POST['delete_item'])) {
    echo "passed";
    $cart_itemid = $_POST['delete_item'];
    // echo $_POST['delete_user'];

    // check ing
    $sql = "SELECT `cartitem_ingredient`.*, `ingredient`.`ing_name`, `ingredient`.`ing_price`
                            FROM `cartitem_ingredient` 
                                LEFT JOIN `ingredient` ON `cartitem_ingredient`.`ing_id` = `ingredient`.`ing_id`
                                WHERE `cartitem_ingredient`.`cart_itemid` = ?;";
    $result_ing = $pdo->prepare($sql);
    $result_ing->execute([$menu_item['cart_itemid']]);
    $row_ing = $result_ing->fetchAll(PDO::FETCH_ASSOC);
    if($result_ing->rowCount() != 0) {
        $stmt = $pdo->prepare('DELETE FROM cartitem_ingredient WHERE cart_itemid = ?');
        $stmt->execute([$cart_itemid]);
    }
    $stmt = $pdo->prepare('DELETE FROM cart_item WHERE cart_itemid = ?');
    $stmt->execute([$cart_itemid]);

    // add new total
    // update total by loop all again

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
        );
    
        array_push($items, $item);
    }

    $cart_total = 0;

    foreach ($items as $item):
        echo $cart_total;
        $cart_total += $item['cartit_total'];

        $udcart = $pdo->prepare("UPDATE shopping_cart SET cart_total= :cart_total WHERE cart_id  = :id");
        $udcart->bindValue(":cart_total", $cart_total);
        $udcart->bindValue(":id", $cart_id);
        $udcart->execute();
    endforeach;

    header("Refresh:0");
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/style12.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script>
    function toggleParagraph() {
      var paragraph = document.getElementById("myParagraph");
      var selectBar = document.getElementById("mySelect");
      if (selectBar.value === "show") {
        paragraph.style.display = "flex";
      } else {
        paragraph.style.display = "none";
      }
    }
  </script>
</head>

<body>

<?php require_once '../components/user_header_new.php'; ?>

    <div class="order-container">
        <div class="row" >
            <h4>Order review</h4>
        </div>
        <div class="order-item" style="border-bottom: 1px solid #008556; border-top: 1px solid #008556;">
            <?php foreach ($menu_items as $menu_item): ?>
                <div class="row" style="margin-top: 1em;">
                    <div class="col">
                        <h6><?php echo $menu_item['crust_name']; ?></h6>
                        <p style="margin-bottom:0;"><?php echo $menu_item['pz_name']; ?> (<?php echo number_format($menu_item['fd_price'],0); ?> ฿)</p>
                        <?php 
                            $sql = "SELECT `cartitem_ingredient`.*, `ingredient`.`ing_name`, `ingredient`.`ing_price`
                            FROM `cartitem_ingredient` 
                                LEFT JOIN `ingredient` ON `cartitem_ingredient`.`ing_id` = `ingredient`.`ing_id`
                                WHERE `cartitem_ingredient`.`cart_itemid` = ?;";
                            $result_ing = $pdo->prepare($sql);
                            $result_ing->execute([$menu_item['cart_itemid']]);
                            $row_ing = $result_ing->fetchAll(PDO::FETCH_ASSOC);
                            if($result_ing->rowCount() != 0) {
                                foreach ($row_ing as $ing):
                                    if($ing['ing_quantity'] < 0) echo '<p style="margin-bottom:0;">'.'<small>'.'<i style="margin-right:10px;margin-left:10px" class="fa fa-minus"></i>'.$ing['ing_name'].'</small>'."</p>";
                                    else echo '<p style="margin-bottom:0;">'.'<small>'.'<i style="margin-right:10px;margin-left:10px" class="fa fa-plus"></i>'.$ing['ing_name'].' ('.$ing['ing_price'].' ฿)'.' x '.$ing['ing_quantity'].'</small>'."</p>";
                                endforeach;
                            }
                        ?>
                    </div> 
                    <div class="col" style="text-align: center;">
                        <p> x <?php echo $menu_item['quantity']; ?></p>
                    </div>
                    <div class="col" style="text-align: end;">
                    <?php echo $menu_item['quantity']*$menu_item['cartit_total']; ?> ฿
                    </div> 
                    <div class="col-1">
                        <form method="post" action="">
                            <input type="hidden" name="delete_item" value="<?php echo $menu_item['cart_itemid'];?>">
                            <button type="submit" style="background: none;border: none;padding: 0;cursor: pointer;" ><i class="fa fa-close" style="color: red;"></i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
          
            
        </div>
        <div class="row" style="margin-top: 1em;">
            <div class="col"style="text-align: end;">
                sub - Total
            </div>
            <div class="col" style="text-align: end;">
            <?php echo number_format($cart_total,0); ?> ฿
            </div>
            <div class="col-1">
                   
            </div>
        </div>
    </div>

    <div class="select-delivery-container">
        <div class="row" style="border-bottom: 1px solid #008556;">
            <h4>SERVICE TYPE</h4>
        </div>
    <form method="POST" action="">
            <div class="row" style="margin-top:1em ;">
                <div class="col">
                    <input type="radio" value="1" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                    <label class="btn btn-outline-success" for="success-outlined" style="width: 100%; height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;" >30 Minutes Delivery</label>
                </div>
                <div class="col">
                    <input type="radio" value="2" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                    <label class="btn btn-outline-success" for="danger-outlined" style="width: 100%;  height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;">Pick Up 0 B</label>
                </div>
            </div>
                
            <div id="address-selection" style="display:block;">
                <!-- Address selection -->
                <div class="row" style="margin-top:1em ; border-bottom: 1px solid #008556;" >
                    <h4>DELIVERY ADDRESS</h4>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-4">
                        <h4>
                            Delivery Address
                        </h4>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1">
                                <img src="https://1112.com/images/address_review.svg" alt="address">
                            </div>
                            <div class="col">
                                <select name="addb-select" class="form-select required"  style="width: 80%;">
                                    <!-- <option selected disabled>Open this select menu</option> -->
                                    <?php foreach ($adds_results as $adds): ?>
                                        <option value="<?php echo $adds['addb_id'] ?>"><?php echo $adds['addb_name'] ?></option>
                                    <?php endforeach; ?>
                                    
                                    <!-- <option value="2">Two</option>
                                    <option value="3">Three</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col">
                                <button type="button" class="btn btn-success" style="width: 50%; font-weight: bold;">Add New Address</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 2em;">
                    <div class="col-4">
                        <h4>
                            Delivery Time
                        </h4>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1">
                                <img src="https://1112.com/images/deliverytime_review.svg" alt="store">
                            </div>
                            <div class="col">
                                <select class="form-select"  style="width: 80%;">
                                    <!-- <option >Select time pickup</option> -->
                                    <option value="1" selected>Pickup Now</option>
                                    <!-- <option value="2">Pickup Later</option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3em;border-bottom: 1px solid #008556; ">
                    <div class="col">
                        <h4>Sub - Total <br> Delivery Charge</h4>
                    </div>
                    <div class="col" style="text-align: end; ">
                    <?php echo number_format($cart_total,0); ?> ฿ <br> 0 ฿
                    </div>
                    <div class="col-1">
                    </div>
                
                </div>            
            </div>
            
            <div id="store-selection" style="display:none;">
                <!-- Store selection -->
                <div class="row" style="margin-top:1em ; border-bottom: 1px solid #008556;" >
                    <h4>SELECT STORE</h4>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-4">
                        <h4>
                            Select Store
                        </h4>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1">
                                <img src="https://1112.com/images/selectstore_review.svg" alt="store">
                            </div>
                            <div class="col">
                                <select name="store-select" class="form-select"  style="width: 80%;">
                                    <!-- <option selected disabled>Open this select menu</option> -->
                                    <?php foreach ($store_rows as $store_row): ?>
                                        <option value="<?php echo $store_row['store_id'] ?>"><?php echo $store_row['st_name_en'] ?></option>
                                    <?php endforeach; ?>
                                    
                                    <!-- <option value="2">Two</option>
                                    <option value="3">Three</option> -->
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row" style="margin-top: 2em;">
                    <div class="col-4">
                        <h4>
                            Pickup Time
                        </h4>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1">
                                <img src="https://1112.com/images/deliverytime_review.svg" alt="store">
                            </div>
                            <div class="col">
                                <select class="form-select"  style="width: 80%;">
                                    <!-- <option >Select time pickup</option> -->
                                    <option value="1" selected>Pickup Now</option>
                                    <!-- <option value="2">Pickup Later</option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3em;border-bottom: 1px solid #008556; ">
                    <div class="col">
                        <h4>Sub - Total</h4>
                    </div>
                    <div class="col" style="text-align: end; ">
                    <?php echo number_format($cart_total,0); ?> ฿
                    </div>
                    <div class="col-1">
                    </div>
                
                </div>
            </div>
            <div class="row" style="margin-top: 2em;" >
                <div class="col" style="text-align: end;">
                    <h4>Total</h4>
                </div>
                <div class="col" style="text-align: end; ">
                <?php echo number_format($cart_total,0); ?> ฿ 
                </div>
                <div class="col-1">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid d-md-flex justify-content-md-end">
                    <!-- <button type="button" class="btn btn-success" style="padding-left: 4em; padding-right: 4em; font-weight:bold; margin-top: 1em;">Success</button> -->
                    <!-- <form method="POST" action=""> -->
                        <input type="submit" name="submit" value="Success" class="btn btn-success" style="padding-left: 4em; padding-right: 4em; font-weight:bold; margin-top: 1em;">
                    <!-- </form> -->
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </form>

    <script>
        // Get the radio buttons and divs for address and store selection
        const deliveryRadio = document.getElementById('success-outlined');
        const pickUpRadio = document.getElementById('danger-outlined');
        const addressDiv = document.getElementById('address-selection');
        const storeDiv = document.getElementById('store-selection');

        // Add a change event listener to the radio buttons
        deliveryRadio.addEventListener('change', () => {
        // If 30 Minutes Delivery is selected, show the address selection div and hide the store selection div
        addressDiv.style.display = 'block';
        storeDiv.style.display = 'none';
        });

        pickUpRadio.addEventListener('change', () => {
        // If Pick Up 0 B is selected, show the store selection div and hide the address selection div
        storeDiv.style.display = 'block';
        addressDiv.style.display = 'none';
        });
    </script>
</body>

</html>