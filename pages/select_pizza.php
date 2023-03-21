<?php
session_start();

require_once "../components/connect.php";

// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
}

if(!isset($_GET["id"])) {
    header("Location: bogo.php");
    exit;
}

$id = $_GET["id"];

// retrieve pizza info from the database
$stmt = $pdo->prepare("SELECT pizza.pz_name, food.fd_image, food.fd_price, pizza.pz_id, size.size_id, size.size_name, crust.crust_id, crust.crust_name
                            FROM pizza
                            INNER JOIN pizza_detail ON pizza.pz_id = pizza_detail.pz_id
                            INNER JOIN size ON size.size_id = pizza_detail.size_id
                            INNER JOIN crust ON crust.crust_id = pizza_detail.crust_id
                            INNER JOIN food ON pizza_detail.fd_id = food.fd_id
                            WHERE food.fd_id = :food_id");
$stmt->bindParam(":food_id", $_GET["id"]);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$pz_id = $result["pz_id"];
$pz_name = $result["pz_name"];
$fd_image = $result["fd_image"];
$fd_price = $result["fd_price"];
$size_id = $result["size_id"];
$size_name = $result["size_name"];
$crust_id = $result["crust_id"];
$crust_name = $result["crust_name"];

// new pages when change value

// echo var_dump($_POST);
// $select_sauce = $_POST['selectsauce'];

// Use the form data as needed
// For example, you can echo the values to the page:


// retrieve all pizza names from the food table
$stmt = $pdo->prepare("SELECT `pizza_detail`.`pz_id`, `pizza`.`pz_name`
    FROM `pizza_detail` 
    LEFT JOIN `pizza` ON `pizza_detail`.`pz_id` = `pizza`.`pz_id`
    GROUP BY `pizza_detail`.`pz_id`;");
$stmt->execute();
$pizza_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retrieve all size names from the current pz_id
$stmt = $pdo->prepare("SELECT `pizza_detail`.`size_id`
FROM `pizza_detail`
WHERE `pizza_detail`.`pz_id` = :pz_id
GROUP BY `pizza_detail`.`size_id`;");
$stmt->bindParam(":pz_id", $pz_id);
$stmt->execute();
$size_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retrieve all crust names from the current pz_id, size_id
$stmt = $pdo->prepare("SELECT `pizza_detail`.*, `crust`.`crust_name`
FROM `pizza_detail` 
LEFT JOIN `crust` ON `pizza_detail`.`crust_id` = `crust`.`crust_id`
WHERE `pizza_detail`.`pz_id` = :pz_id AND `pizza_detail`.`size_id` = :size_id;");
$stmt->bindParam(":pz_id", $pz_id);
$stmt->bindParam(":size_id", $size_id);
$stmt->execute();
$crust_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// retrieve all Sauce names from the current pz_id
$stmt = $pdo->prepare("SELECT `pizza_detail`.`pz_id`, `pizza_sauce`.`sauce_id`, `sauce`.`sauce_name`
FROM `pizza_detail`
	, `pizza_sauce` 
	LEFT JOIN `sauce` ON `pizza_sauce`.`sauce_id` = `sauce`.`sauce_id`
    WHERE `pizza_detail`.`pz_id` = :pz_id
    GROUP BY `pizza_sauce`.`sauce_id`;");
$stmt->bindParam(":pz_id", $pz_id);
$stmt->execute();
$sauce_results = $stmt->fetchAll(PDO::FETCH_ASSOC);


try {
    // retrieve all Ingredients names from the current pz_id
    $stmt = $pdo->prepare("SELECT `pizza_ingredient`.`pz_id`, `ingredient`.*
    FROM `pizza_ingredient`
    LEFT JOIN `ingredient` ON `pizza_ingredient`.`ing_id` = `ingredient`.`ing_id`
    WHERE `pizza_ingredient`.`pz_id` = :pz_id;");
    $stmt->bindParam(":pz_id", $pz_id);
    $stmt->execute();
    $ingpz_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $ingpz_results = array();
}

    // retrieve all Ingredients names but not in ingpz
    $stmt = $pdo->prepare("SELECT `ingredient`.*
    FROM `ingredient`
    WHERE `ingredient`.`ing_id` NOT IN (SELECT `pizza_ingredient`.`ing_id`
        FROM `pizza_ingredient`
        WHERE `pizza_ingredient`.`pz_id` = :pz_id);");
    $stmt->bindParam(":pz_id", $pz_id);
    $stmt->execute();
    $ing_results = $stmt->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['refresh'])) {
    $select_pizza = $_POST['selectpizza'];
    $radio_size = $_POST['options-outlined'];
    $select_crust = $_POST['selectcrust'];
    // echo $select_pizza . "<br>";
    // echo $radio_size . "<br>";
    // echo $select_crust . "<br>";
    
    // find food id
    // retrieve pizza info from the database
    $stmt = $pdo->prepare("SELECT `pizza_detail`.`fd_id`
    FROM `pizza_detail`
    WHERE `pizza_detail`.`pz_id` = :pz_id AND `pizza_detail`.`size_id` = :size_id AND `pizza_detail`.`crust_id` = :crust_id");
    $stmt->bindParam(":pz_id", $select_pizza);
    $stmt->bindParam(":size_id", $radio_size);
    $stmt->bindParam(":crust_id", $select_crust);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($stmt->rowCount() == 0 || is_null($stmt)) {
        $message = "crust not found";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $stmt2 = $pdo->prepare("SELECT `pizza_detail`.`fd_id`
        FROM `pizza_detail`
        WHERE `pizza_detail`.`pz_id` = :pz_id AND `pizza_detail`.`size_id` = :size_id");
        $stmt2->bindParam(":pz_id", $select_pizza);
        $stmt2->bindParam(":size_id", $radio_size);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);

        if($stmt2->rowCount() == 0 || is_null($stmt2)) {
            $message = "size not found";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $stmt3 = $pdo->prepare("SELECT `pizza_detail`.`fd_id`
            FROM `pizza_detail`
            WHERE `pizza_detail`.`pz_id` = :pz_id");
            $stmt3->bindParam(":pz_id", $select_pizza);
            $stmt3->execute();
            $result = $stmt3->fetch(PDO::FETCH_ASSOC);
        }
    } 

    $fid = $result['fd_id'];
    // echo $fid;
    header("Location: select_pizza.php?id=$fid");
}


if(isset($_POST['submit'])) {
    // echo "test";
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['user_id'];

    // check if no shopping cart
    $select_cart = $pdo->prepare("SELECT * FROM `shopping_cart` WHERE `user_id`  = ? AND `cart_active` = 1");
    $select_cart->execute([$user_id]);
    $row = $select_cart->fetch(PDO::FETCH_ASSOC);

    // intial a cart
    // echo $select_cart->rowCount();
    if($select_cart->rowCount() == 0){
        $insert_cart = $pdo->prepare("INSERT INTO `shopping_cart` (user_id, cart_total) VALUES (?, ?)");
        $insert_cart->execute([$user_id, 0]);
    }

    // check again
    $select_cart = $pdo->prepare("SELECT * FROM `shopping_cart` WHERE `user_id`  = ? AND `cart_active` = 1");
    $select_cart->execute([$user_id]);
    $row = $select_cart->fetch(PDO::FETCH_ASSOC);

    $cart_id = $row['cart_id'];
    // echo $row['cart_total'];
    // // check if have a item
    // $select_itemcart = $pdo->prepare("SELECT * FROM `cart_item` WHERE `cart_id` = ?");
    // $select_itemcart->execute([$cart_id, $id]);
    // $itemcart_row = $select_itemcart->fetch(PDO::FETCH_ASSOC);
    
    // sum a ingredeint
    // add item to cart_item to get cart item id
    $insert_itemcart = $pdo->prepare("INSERT INTO cart_item (cart_id, fd_id, quantity, cartit_total) VALUES (?, ?, ?, ?)");
    $insert_itemcart->execute([$cart_id , $id, 1, 0]);

    // get a item id
    $select_item_cart = $pdo->prepare("SELECT `cart_item`.*
    FROM `cart_item`
    WHERE `cart_id` = ?
    ORDER BY `cart_itemid` DESC;");
    $select_item_cart->execute([$cart_id]);
    $row_it = $select_item_cart->fetch(PDO::FETCH_ASSOC);

    $cart_itemid = $row_it['cart_itemid'];   

    // echo $cart_itemid;

    
    $ing_json = $_POST['selectedIngredients'];
    // echo $ing_json;
    // have ingredient
    $ing_total = 0;
    if($ing_json) {
        // Extract the substring without the prefix and last character
        $jsonData = substr($ing_json, strlen('{"selectedIngredients":'), -1);
        // $jsonf = '[{"ing_name":"Mozzarella-Cheese","ing_price":59,"quantity":-1},{"ing_name":"Anchovies","ing_price":79,"quantity":1},{"ing_name":"Bacon Dice","ing_price":59,"quantity":1},{"ing_name":"BBQ Chicken","ing_price":59,"quantity":1},{"ing_name":"GarlicButterChicken","ing_price":59,"quantity":1}]';

        $selectedIngredients = json_decode($jsonData, true);

        // Loop through the selectedIngredients array
        foreach ($selectedIngredients as $ingredient) {
        $ing_name = $ingredient["ing_name"];
        $ing_price = $ingredient["ing_price"];
        $ing_id = $ingredient["ing_id"];
        $ing_qty = $ingredient["quantity"];
        // echo $ing_id.' ';
        // add to table
        if($ing_qty > 0) $ing_total += $ing_price;

        $insert_itemcart = $pdo->prepare("INSERT INTO cartitem_ingredient (cart_itemid, ing_id, ing_quantity	
        ) VALUES (?, ?, ?)");
        $insert_itemcart->execute([$cart_itemid , $ing_id, $ing_qty]);
        }
    }


    $cartit_total = $ing_total+$fd_price;
    // echo $cartit_total;
    // echo "<br>\n";

    $uditemcart = $pdo->prepare("UPDATE cart_item SET cartit_total = :cartit_total WHERE cart_itemid = :id");
    $uditemcart->bindValue(":cartit_total", $cartit_total);
    $uditemcart->bindValue(":id", $cart_itemid);
    $uditemcart->execute();

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
        
        // $insert_cart = $pdo->prepare("UPDATE `shopping_cart` SET `cart_total`='[value-3]' WHERE user_id = UNHEX(:id)");
        // $insert_cart->execute([$user_id, 0]);
        // $fname = $_POST["us_fname"];
        // $lname = $_POST["us_lname"];
        // $phone = $_POST["us_phone"];
        // $birthdate = $_POST["us_birthdate"];
        // $gender = $_POST["us_gender"];
        // $email = $_POST["us_email"];
        // $password = $_POST["us_password"];

        // $stmt = $pdo->prepare("UPDATE user SET us_fname = :fname, us_lname = :lname, us_phone = :phone, us_birthdate = :birthdate, us_gender = :gender, us_email = :email, us_password = :password WHERE user_id = UNHEX(:id)");
        // $stmt->bindValue(":fname", $fname);
        // $stmt->bindValue(":lname", $lname);
        // $stmt->bindValue(":phone", $phone);
        // $stmt->bindValue(":birthdate", $birthdate);
        // $stmt->bindValue(":gender", $gender);
        // $stmt->bindValue(":email", $email);
        // $stmt->bindValue(":password", $password);
        // $stmt->bindValue(":id", $id);
        // $stmt->execute();

        // header("Location: bogo.php");
        // exit;
    // }
}

// test submit
if(isset($_POST['submzit'])) {
    echo "passed";

    $var = $_POST['selectedIngredients'];
    echo $var;
    // have ingredient
    if($var) {
        // Extract the substring without the prefix and last character
        $jsonData = substr($var, strlen('{"selectedIngredients":'), -1);
        // $jsonf = '[{"ing_name":"Mozzarella-Cheese","ing_price":59,"quantity":-1},{"ing_name":"Anchovies","ing_price":79,"quantity":1},{"ing_name":"Bacon Dice","ing_price":59,"quantity":1},{"ing_name":"BBQ Chicken","ing_price":59,"quantity":1},{"ing_name":"GarlicButterChicken","ing_price":59,"quantity":1}]';

        $selectedIngredients = json_decode($jsonData, true);

        // Loop through the selectedIngredients array
        foreach ($selectedIngredients as $ingredient) {
        $ing_name = $ingredient["ing_name"];
        $ing_price = $ingredient["ing_price"];
        $ing_id = $ingredient["ing_id"];

        // echo $ing_id.' ';

        // add to table
        }
    }
    
    
}
// echo $size_results[0]['size_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBogo</title>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- <script
    src="https://code.jquery.com/jquery-3.6.4.js"
    integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script> -->
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/script.js"></script>
    <script src="bogosc.js"></script>
    <script src="https://kit.fontawesome.com/f8a584406d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/f8a584406d.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-cF1nBvxbnU27eJm6YM8U6mGx6p7MTdZtwmk9df8VoyW5Jv0yzw5y5c5sw2V5Wx0vNo2tZzM9RZhK8V+dWUGrOQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
      
</head>
<body>
    
<?php require_once '../components/user_header_new.php'; ?>

    <div class="home-category" style = "margin-top: 80px ">

        <h4 style = "margin-left : 6em;"> <img src="https://cdn.1112.com/1112/public/images/web/menu.svg" alt="Cheese"> </img>
            Menu</h4>
        <div class="category_container" >
            <a href="bogo.php">
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
    <h4 style = "text-align: center; padding-top : 1em;">SELECT PIZZA</h4>
    <form id="my-form" method="POST" action="">
        <div class="pizza-item-container" >
            <div class="row" ">
                <div class="col text-center" style="padding-left : 6em; padding-right : 6em;" >
                    <img src="<?php echo $fd_image; ?>" alt="<?php echo $pz_name; ?>" style="height: 315px; width: 400px;">
                </div>
                <div class="col">
                    
                    <select name="selectpizza" id="selectpizza" class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6; font-weight: bold; ">
                    <?php foreach ($pizza_results as $pizza): ?>
                        <option value="<?php echo $pizza['pz_id']; ?>" <?php if ($pizza['pz_id'] == $pz_id) { echo "selected"; } ?>><?php echo $pizza['pz_name']; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <p class="pt-3"> </p>
                    <h3><?php echo $fd_price; ?></h3>
                    <div class="row  pt-3">
                        <div class="col-4">
                            <h5 >Select <br> Size</h5>
                        </div>
                        <div class="col-8 d-flex flex-row">
                            <div class="row">
                                <div class="col bottom-0" >
                                    <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" value="1" autocomplete="off" <?php if (1 == $size_id) { echo "checked"; } ?>>
                                    <label class="btn btn-outline-success " for="success-outlined" style="border-radius: 100%; display:<?php foreach ($size_results as $size): if ($size['size_id'] == 1) { echo "Block"; break;} else {echo "None";} endforeach;?>;">M</label>
                                </div>
                                <div class="col" >
                                    <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" value="2" autocomplete="off" <?php if (2 == $size_id) { echo "checked"; } ?>>
                                    <label class="btn btn-outline-success" for="danger-outlined" style="border-radius: 100% ; display : flex ; justify-content: center; width: 50px; height: 50px; text-align: center; align-items: center; display:<?php foreach ($size_results as $size): if ($size['size_id'] == 2) { echo "Block"; break;} else {echo "None";} endforeach;?>;">L</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col  pt-3">
                        <div class="row">
                            <div class="col-4">
                                <h5>Select <br> crust</h5>
                            </div>
                            <div class="col-8">
                                <select name="selectcrust" id="selectcrust" class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6 ;font-weight: bold;">
                                    <?php foreach ($crust_results as $crust): ?>
                                        <option value="<?php echo $crust['crust_id']; ?>" <?php if ($crust['crust_id'] == $crust_id) { echo "selected"; } ?>><?php echo $crust['crust_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <button name="refresh" class="btn btn-primary" style="width:100px;margin-left: auto;margin-right: 150px;"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i>&nbsp;Refresh</button>
            </div>
    </form>
    <form method="POST" action="">
        <div style="text-align: center;">
        
            <!-- <button id="toggle-button" class="button1" onclick="toggleButton()">Add to Basket</button> -->
        
                <!-- hidden input field to store the JSON data -->
                <input type="hidden" name="selectedIngredients" id="selectedIngredients" >

                <input type="submit" name="submit" value="Add to Basket" class="button1" id="submit">
            <!-- </form> -->
        </div>
            <div style="text-align: center; margin-top: 2em;">
                <button id="toggle-button-ingredients" onclick="IngredientsButton(); return false;" style=" <?php if(!$ingpz_results) {echo "display:None";}?> "><img src="https://1112.com/images/cutlery_pizza_custom.svg" alt="knife"> 
                    Customize Pizza <br> * Up to 7 extra ingredients</button>
            </div>
            <div id="Ingredients-container" style="display: none;">
            <div style="text-align: center;">
                <input type="submit" name="submiting" value="Confirm ingredient" class="btn btn-secondary" id="submiting" style="margin: 20px;">
            </div>
                <p>Select Sauce</p>
            
                    <select name="selectsauce" class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6 ;font-weight: bold; width: 30%;">
                        <!-- <option disabled selected>Pizza Sauce</option> -->
                        <?php foreach ($sauce_results as $sauce): ?>
                        <option <?php if ($sauce['sauce_name'] == end($sauce_results)['sauce_name']) {echo "selected";}?> value="<?php echo $sauce['sauce_id']?>"><?php echo $sauce['sauce_name']?></option>
                        <!-- <option value="3">Pan Medium</option>
                        <option value="4">Extreme Cheese Medium</option> -->
                        <?php endforeach; ?>
                    </select>
    </form>
            
            <p style="color : green ; margin : 1em ;">Ingredients in this pizza</p>
            <div class="grid-container-ing">
                <?php foreach ($ingpz_results as $ingpz): ?>
                    <div class="card border border-success ing-item"  >
                        <div class="card-img" style="background-position: center; margin-top: 1em; border-radius: 50%; width: 7rem; height: 7rem; background-image:url(<?php echo $ingpz['ing_img']?>) ;background-size: cover; ">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-success"><?php echo $ingpz['ing_name']?></h6>
                            <p class="card-text text-success">+ <?php echo $ingpz['ing_price']?> Baht/Each.</p>
                            <p style="display:none;" class="card-id"><?php echo $ingpz['ing_id']?></p>
                            <div class="ingpz_qty">
                                <input id="my-input" type="number" min="-1" max="7" value="0" readonly>
                                <button class="pluspz-btn">+</button>
                                <button class="minuspz-btn">-</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


                <!-- <div class="card border border-success ing-item"  >
                    <div class="card-img" style="margin-top: 1em; border-radius: 50%; width: 7rem; height: 7rem; background-image:url(https://cdn.1112.com/1112/public/images/products/ingredients/website/Mozzarella-Cheese.jpg) ;background-size: cover; ">
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-success">Mozzarella Cheese</h6>
                        <p class="card-text text-success">+ 59 Baht/Each.</p>
                        <div>
                            <input id="my-input" type="number" min="0" max="7" value="0">
                            <button class="plus-btn">+</button>
                            <button class="minus-btn">-</button>
                        </div>
                    </div>
                </div>   -->
            </div>    
            <p style="color : black ; margin : 1em ;">Add more ingredients</p>     
            <div class="grid-container-ing">
                <?php foreach ($ing_results as $ing): ?>
                    <div class="card border border-success ing-item"  >
                        <div class="card-img" style="background-position: center; margin-top: 1em; border-radius: 50%; width: 7rem; height: 7rem; background-image:url(<?php echo $ing['ing_img']?>) ;background-size: cover; ">
                        </div>
                        <div class="card-body">
                            <h6 id="ing-name" class="card-title text-success"><?php echo $ing['ing_name']?></h6>
                            <p id="ing-price"class="card-text text-success">+ <?php echo $ing['ing_price']?> Baht/Each.</p>
                            <p style="display:none;" class="card-id"><?php echo $ing['ing_id']?></p>
                            <div class="ing_qty">
                                <input  id="my-input" type="number" min="0" max="7" value="0" readonly>
                                <button class="plus-btn">+</button>
                                <button class="minus-btn">-</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>               
        </div>

    </div>
    <script>
        const plusButtons = document.querySelectorAll('.plus-btn');
        const minusButtons = document.querySelectorAll('.minus-btn');
        const pluspzButtons = document.querySelectorAll('.pluspz-btn');
        const minuspzButtons = document.querySelectorAll('.minuspz-btn');
        const quantityInputs = document.querySelectorAll('.ing_qty input[type="number"]');
        const quantitypzInputs = document.querySelectorAll('.ingpz_qty input[type="number"]');
        const quantityallInputs = document.querySelectorAll('input[type="number"]');
        const maxQuantity = 7;
        // var totalQuantity = 0;

        // Add event listeners to plus and minus buttons
        for (let i = 0; i < plusButtons.length; i++) {
            plusButtons[i].addEventListener('click', () => {
            event.preventDefault();
            let totalQuantity = 0;

            // Calculate total quantity
            for (let j = 0; j < quantityallInputs.length; j++) {
                if(parseInt(quantityallInputs[j].value) != -1) totalQuantity += parseInt(quantityallInputs[j].value);
            }

            // Check if total quantity is greater than maxQuantity
            if (totalQuantity >= maxQuantity) {
                // Disable plus button and show error message
                // plusButtons[i].setAttribute('disabled', true);
                alert('You have reach maximum numbers of extra ingredients');
            } else {
                // Increment quantity and enable plus button
                quantityInputs[i].value = parseInt(quantityInputs[i].value) + 1;
                plusButtons[i].removeAttribute('disabled');
            }
            });

            minusButtons[i].addEventListener('click', () => {
            event.preventDefault();
            // Decrement quantity and enable plus button
            if (parseInt(quantityInputs[i].value) > 0) {
                quantityInputs[i].value = parseInt(quantityInputs[i].value) - 1;
                plusButtons[i].removeAttribute('disabled');
            }
            });
        }

        for (let i = 0; i < pluspzButtons.length; i++) {
            pluspzButtons[i].addEventListener('click', () => {
            event.preventDefault();
            let totalQuantity = 0;

            // Calculate total quantity
            for (let j = 0; j < quantityallInputs.length; j++) {
                if(parseInt(quantityallInputs[j].value) != -1) totalQuantity += parseInt(quantityallInputs[j].value);
            }

            // Check if total quantity is greater than maxQuantity
            if (totalQuantity >= maxQuantity && quantitypzInputs[i].value != -1) {
                // Disable plus button and show error message
                // pluspzButtons[i].setAttribute('disabled', true);
                alert('You have reach maximum numbers of extra ingredients');
            } else {
                // Increment quantity and enable plus button
                quantitypzInputs[i].value = parseInt(quantitypzInputs[i].value) + 1;
                pluspzButtons[i].removeAttribute('disabled');
            }
            });

            minuspzButtons[i].addEventListener('click', () => {
            event.preventDefault();
            // Decrement quantity and enable plus button
            if (parseInt(quantitypzInputs[i].value) > -1) {
                quantitypzInputs[i].value = parseInt(quantitypzInputs[i].value) - 1;
                pluspzButtons[i].removeAttribute('disabled');
            }
            });
        }
        // Get the button element
        const submitButton = document.getElementById('submiting');

        // Listen for a click event on the button
        submitButton.addEventListener('click', () => {
        // event.preventDefault();
        // Get all the quantity input elements
        const quantityInputs = document.querySelectorAll('input[type="number"]');

        // Create a new array to store the selected ingredients
        const selectedIngredients = [];

        // Loop through the quantity inputs
        quantityInputs.forEach(input => {
            event.preventDefault();
            // Check if the input value is greater than 0
            if (input.value > 0 || input.value == -1) {
            // Get the ingredient name and price from the input parent element
            // console.log(input.parentNode.parentNode.querySelector('.card-title').textContent);
            const ingName = input.parentNode.parentNode.querySelector('.card-title').textContent;
            const ingPrice = input.parentNode.parentNode.querySelector('.card-text').textContent.replace(/\D/g, ''); // Remove non-numeric characters
            const ingId = input.parentNode.parentNode.querySelector('.card-id').textContent;
            const qty = parseInt(input.value);
            // Push an object with the ingredient name and price to the selectedIngredients array
            selectedIngredients.push({ ing_name: ingName, ing_price: parseFloat(ingPrice/100), ing_id: parseInt(ingId), quantity: qty});
            }
        });

        // Log the selected ingredients array
        console.log(selectedIngredients);
        // send json
        var jsondata = JSON.stringify({selectedIngredients: selectedIngredients});

        document.getElementById('selectedIngredients').value = jsondata;
        });

        

  
        
    </script>

    </body>
    </html>