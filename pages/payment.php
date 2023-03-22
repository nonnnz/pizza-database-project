<?php
session_start();

// Include the database connection file
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


if($_GET["opt"] == 1) {
    // retrieve all user address
    $select_adds = $pdo->prepare("SELECT `address_book`.`addb_buildingNo`, `address_book`.`addb_buildingName`, `address_book`.`addb_street`, `address_book`.`addb_prov`, `address_book`.`addb_dist`, `address_book`.`addb_subdist`, `address_book`.`addb_zipcode`, `address_book`.`addb_phone` FROM `address_book` WHERE `addb_id`  = ?");
    $select_adds->execute([$_SESSION['deli_address']]);
    $adds_results = $select_adds->fetch(PDO::FETCH_ASSOC);

    // echo join(" ",$adds_results);
    $deli_address = join(" ",$adds_results);
} else {
    $select_adds = $pdo->prepare("SELECT `store`.`st_name_en`
    FROM `store` WHERE `store_id`  = ?");
    $select_adds->execute([$_SESSION['deli_address']]);
    $adds_results = $select_adds->fetch(PDO::FETCH_ASSOC);
    $deli_address = $adds_results['st_name_en'];

    // echo $deli_address;
}

// get menu

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

// copy to order
if(isset($_POST['submit'])) {
    // echo $_POST['output'];
    if($_POST['output'] == 'cash') {
        // insert deli
        $insert_deli = $pdo->prepare("INSERT INTO `delivery` (deli_address, deli_charge) VALUES (?, ?)");
        $insert_deli->execute([$deli_address, 0]);

        // insert payment
        $insert_pt = $pdo->prepare("INSERT INTO `payment` (pay_method, pay_amt) VALUES (?, ?)");
        $insert_pt->execute([$_POST['output'], $cart_total]);

        // insert get id
        $select_deli = $pdo->prepare("SELECT `delivery`.`deli_id`
        FROM `delivery`
        ORDER BY `deli_id` DESC;");
        $select_deli->execute();
        $deli_row = $select_deli->fetch(PDO::FETCH_ASSOC);

        // echo $deli_row['deli_id'];

        $select_pt = $pdo->prepare("SELECT `payment`.`pay_id`
        FROM `payment`
        ORDER BY `pay_id` DESC;");
        $select_pt->execute();
        $pt_row = $select_pt->fetch(PDO::FETCH_ASSOC);

        // insert order
        $insert_order = $pdo->prepare("INSERT INTO `order` (user_id, deli_id, pay_id, ords_id, order_total) VALUES (?, ?, ?, ?, ?)");
        $insert_order->execute([$user_id, $deli_row['deli_id'], $pt_row['pay_id'], 1, $cart_total]);

        // get order id
        $select_order = $pdo->prepare("SELECT `order`.`order_id`
        FROM `order`
        ORDER BY `order_id` DESC;");
        $select_order->execute();
        $order_row = $select_order->fetch(PDO::FETCH_ASSOC);

        // insert order items
        $sql = "SELECT `cart_item`.*
        FROM `cart_item`
        WHERE `cart_id` = ?;";
        $result = $pdo->prepare($sql);
        $result->execute([$cart_id]);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $insert_pt = $pdo->prepare("INSERT INTO `order_item` (order_id, fd_id, quantity, orderit_total) VALUES (?, ?, ?, ?)");
            $insert_pt->execute([$order_row['order_id'], $row['fd_id'], $row['quantity'], $row['cartit_total']]);
            
            // insert orderitem_ingredient
            $sql = "SELECT `cartitem_ingredient`.*, `ingredient`.`ing_name`, `ingredient`.`ing_price`
            FROM `cartitem_ingredient` 
                LEFT JOIN `ingredient` ON `cartitem_ingredient`.`ing_id` = `ingredient`.`ing_id`
                WHERE `cartitem_ingredient`.`cart_itemid` = ?;";
            $result_ing = $pdo->prepare($sql);
            $result_ing->execute([$row['cart_itemid']]);
            $row_ing = $result_ing->fetchAll(PDO::FETCH_ASSOC);

            // get order order_itemid
            $selectit_order = $pdo->prepare("SELECT `order_item`.`order_itemid`
            FROM `order_item`
            ORDER BY `order_itemid` DESC;");
            $selectit_order->execute();
            $orderit_row = $selectit_order->fetch(PDO::FETCH_ASSOC);

            if($result_ing->rowCount() != 0) {
                foreach ($row_ing as $ing):


                    $insert_oring = $pdo->prepare("INSERT INTO `orderitem_ingredient` (order_itemid, ing_id, ing_quantity) VALUES (?, ?, ?)");
                    $insert_oring->execute([$orderit_row['order_itemid'],$ing['ing_id'], $ing['ing_quantity']]);
                endforeach;
            }
        }



        //  disable cart
        $udcart = $pdo->prepare("UPDATE shopping_cart SET cart_active = 0 WHERE cart_id  = :id");
        $udcart->bindValue(":id", $cart_id);
        $udcart->execute();

        $order_id = $order_row['order_id'];

        header("Location: tracking.php?orid=$order_id");
        exit();
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>payment</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

<?php require_once '../components/user_header_new.php'; ?>
    
<div class="pickup-container" >
        <?php if($_GET["opt"] == 1) echo '<h4>DELIVERY ADDRESS</h4>'; else echo '<h4>PICKUP STORE</h4>'?>      
        <div class="store" style="display: flex;  border-top: 1px solid #008556; padding-top: 1em;">
            <img src="https://1112.com/images/selectstore_review.svg" alt="STORE" style="margin-right: 1em;">
            <?php echo $deli_address ?>
        </div>
        <div class="pickup-time"  style="display: flex;  padding-top: 1em;" >
            <img src="https://1112.com/images/deliverytime_review.svg" alt="clock" style="margin-right: 1em;">
            Pickup Now
        </div>
    </div>

    <div class="order-review">
        <h4>ORDER REVIEW</h4>

        <div class="order-bill" style="border-top: 1px solid #008556;" >
            <?php foreach ($menu_items as $menu_item): ?>
                <?php if($menu_item['cat_id'] == 1) {?>
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
                        <?php echo number_format($menu_item['quantity']*$menu_item['cartit_total'], 2) ?> ฿
                        </div> 
                    </div>
                <?php } else { ?>
                    <div class="row" style="margin-top: 1em;">
                        <div class="col">
                            <h6><?php echo $menu_item['fd_name']; ?></h6>
                        </div> 
                        <div class="col" style="text-align: center;">
                            <p> x <?php echo $menu_item['quantity']; ?></p>
                        </div>
                        <div class="col" style="text-align: end;">
                        <?php echo number_format($menu_item['quantity']*$menu_item['cartit_total'], 2); ?> ฿
                        </div> 
                    </div>
                <?php }?>
            <?php endforeach; ?>
            <div class="row" style="margin-top: 1em;">
                <div class="col"style="text-align: end;">
                    sub - Total
                </div>
                <div class="col" style="text-align: end;">
                <?php echo number_format($cart_total,2); ?> ฿
                </div>
                <div class="col-1">
                   
                </div>
            </div>
            <div class="row" style="margin-top: 1em;">
                <div class="col"style="text-align: end;">
                    Total
                </div>
                <div class="col" style="text-align: end;">
                <?php echo number_format($cart_total,2); ?> ฿
                </div>
                <div class="col-1">
                   
                </div>
            </div>
        </div>
    </div>
    <div class="sauce-container">
        <h4>CUTLERY AND SAUCE</h4>
        <div class="Cutlery-Sauce">
            <div class="row">
                <div class="col-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" >
                    <img src="https://cdn.1112.com/1112/public/images/Icon_Cutlery@3x.png" alt="knife" style="width: 25px;">
                    Cutlery
                    </label>
                </div>
                <div class="col">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" >
                    <img src="https://cdn.1112.com/1112/public/images/icon_sauce@3x.png" alt="knife" style="width: 25px;">
                    Sauce
                    </label>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" >
        <div class="payment-options" style="padding-left: 3em; padding-right: 3em;">
            <h4>PAYMENT OPTIONS</h4>
            <div class="payment-button" style="border-top: 1px solid green; border-bottom: 1px solid green; padding-top: 1em; padding-bottom: 2em;">
                <div class="row">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" >
                        <input type="radio" class="btn-check" name="output" id="btnradio1" value="cash" checked>
                        <label class="btn btn-outline-success d-flex flex-column" for="btnradio1" style="text-align: center; align-items: center;  height: 80px; border-radius: 12px;">
                            <img class ="p" src="https://1112.com/images/cash_payment.svg" alt="cash" style="width: 40px; background-color: white; border: 1px solid white; border-radius: 5px; width:15%;">
                            <p class="p">Cash On Delivery</p>
                        </label>
                        <input type="radio" class="btn-check" name="output" id="btnradio2" value="credit" >
                        <label class="btn btn-outline-success d-flex flex-column" for="btnradio2" style="padding-top: 1em; text-align: center; display: flex; justify-content: center; align-items: center;  height: 80px; margin-left: 10px; margin-right: 10px; border-radius: 12px;  width:15%;">
                            <img class ="p" src="https://1112.com/images/credit-card_payment.svg" alt="cash" style="width: 40px; border: 1px solid white; background-color: white; border-radius: 5px; clip-path: inset(5px 1px 5px 1px);">
                            <p class="p">Credit Card</p>
                        </label>
                    
                        <input type="radio" class="btn-check" name="output" id="btnradio3" value="true">
                        <label class="btn btn-outline-success d-flex flex-column" for="btnradio3" style="padding-top: 1em; text-align: center; display: flex; justify-content: center; align-items: center; height: 80px;  border-radius: 12px; width:15%;">
                            <img class ="p" src="https://1112.com/images/truemoney_payment.svg" alt="cash" style="width: 40px; border: 1px solid white; background-color: white; border-radius: 5px; clip-path: inset(5px 1px 5px 1px);">
                            <p class="p">TrueMoney Wallet</p>
                        </label>
                    </div>  
                </div>
                
                <div id="output"></div>
                <script>
                    const outputDiv = document.getElementById("output");
                    const radioButtons = document.getElementsByName("output");
            
                    function getOutput(value) {
                        switch (value) {
                        case "true":
                            return `
                                <div class="Truewallet-container">
                                    <div class="d-flex flex-column">
                                        <div class="p-2"><img src="https://1112.com/images/truemoney_payment.svg" alt="Wallet"></div>
                                        <div class="p-2">Enter your <br> mobile number</div>
                                        <div class="p-2"> 
                                            <div class="form-outline mb-3" style="width: 100%; max-width: 22rem">
                                                <input type="text" id="phone" class="form-control" data-mdb-input-mask="+66 999-999-999" maxlength="10" placeholder="098xxxxxxx" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        case "credit":
                            return `
                                <div class="credit-card">
                                    <div class="row" >
                                        <div class="col">
                                            <h5>Select Your Card</h5>
                                        </div>
                                        <div class="col d-flex">
                                            <img class="store-icon-review" style="padding-right: 5px;" src="https://1112.com/images/credit-card_payment.svg">
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected> </option>
                                                <option value="1"><php? echo"text";?></option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-success" style="width: 100%; font-weight: bold;">Add New Card</button>
                                        </div>
                                    </div>
                                </div>
                        `;
                        case "cash":
                            return " ";
                        }
                    }
                    
                    for (const radioButton of radioButtons) {
                        radioButton.addEventListener("change", () => {
                            outputDiv.innerHTML = getOutput(radioButton.value);
                        });
                        if (radioButton.checked) {
                            radioButton.dispatchEvent(new Event('change'));
                        }
                    }
                </script>
                
            </div>
            <div class="d-flex align-items-end flex-column" >
                <input type="submit" name="submit" value="Place Order" class="btn btn-success p" style="font-weight: bold; margin-top: 1em; padding-left: 4em; padding-right: 4em;"></input>
            </div>

        </div>
    </form>
</body>
</html>