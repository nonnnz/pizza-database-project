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

// array
$menu_items = array();

// if cart null
$select_cart = $pdo->prepare("SELECT * FROM `shopping_cart` WHERE `user_id`  = UNHEX(?)");
$select_cart->execute([$user_id]);
$cart_row = $select_cart->fetch(PDO::FETCH_ASSOC);

// check cart total
if($cart_row) $cart_total = $cart_row['cart_total'];
else $cart_total = 0;


$sql = "SELECT `shopping_cart`.`cart_id`, `cart_item`.`fd_id`, `food`.`fd_price`, `pizza_detail`.`pz_id`, `pizza`.`pz_name`, `crust`.`crust_name`, `cart_item`.`quantity`
FROM `shopping_cart` 
	LEFT JOIN `cart_item` ON `cart_item`.`cart_id` = `shopping_cart`.`cart_id` 
	LEFT JOIN `food` ON `cart_item`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `pizza_detail` ON `pizza_detail`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `pizza` ON `pizza_detail`.`pz_id` = `pizza`.`pz_id` 
	LEFT JOIN `crust` ON `pizza_detail`.`crust_id` = `crust`.`crust_id`
    WHERE shopping_cart.user_id = UNHEX(?)";
$result = $pdo->prepare($sql);
$result->execute([$user_id]);

// echo $result->rowCount();
// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        'fd_id' => $row['fd_id'],
        'fd_price' => $row['fd_price'],
        'pz_id' => $row['pz_id'],
        'pz_name' => $row['pz_name'],
        'quantity' => $row['quantity'],
        'crust_name' => $row['crust_name'],
    );

    array_push($menu_items, $menu_item);
}

// copy cart to order
if(isset($_POST['submit'])) {
    // get user adds
    $sql = "SELECT `user`.`user_id`, `address_book`.*
        FROM `user` 
        LEFT JOIN `address_book` ON `address_book`.`user_id` = `user`.`user_id`
        WHERE address_book.user_id = UNHEX(?) AND address_book.addb_id = ?;";
    $adds = $pdo->prepare($sql);
    $adds->execute([$user_id, 1]);
    $row_adds = $adds->fetch(PDO::FETCH_ASSOC);

    echo $row_adds['addb_street'];

    // adds to deli


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
                        <p><?php echo $menu_item['pz_name']; ?> (<?php echo number_format($menu_item['fd_price'],0); ?> ฿)</p>
                    </div> 
                    <div class="col" style="text-align: center;">
                        <p> x <?php echo $menu_item['quantity']; ?></p>
                    </div>
                    <div class="col" style="text-align: end;">
                    <?php echo $menu_item['quantity']*$menu_item['fd_price']; ?> ฿
                    </div> 
                    <div class="col-1">
                        <a href="#">
                            <i class="fa fa-close" style="color: red;"></i>
                        </a>
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
        
        <div class="row" style="margin-top:1em ;">
            <div class="col">
                <input type="radio" class="btn-check" name="output" id="success-outlined" value="credit"  checked>
                <label class="btn btn-outline-success" for="success-outlined" style="width: 100%; height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;" >30 Minutes Delivery</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="output" id="danger-outlined" value="true">
                <label class="btn btn-outline-success" for="danger-outlined" style="width: 100%;  height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;">Pick Up 0 B</label>
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
                        <select class="form-select"  style="width: 80%;">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
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
                            <option selected>Select time pickup</option>
                            <option value="1">Pickup Now</option>
                            <option value="2">Pickup Later</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 2em; border-bottom: 1px solid #008556;" >
            <div class="col">
                <h4>Sub - Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                <?php echo number_format($cart_total,0); ?> ฿ 
            </div>
           
        </div>
        
        <div class="row" style="margin-top: 2em;" >
            <div class="col" style="text-align: end;">
                <h4>Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                <?php echo number_format($cart_total,0); ?> ฿ 
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-success" style="padding-left: 4em; padding-right: 4em; font-weight:bold; margin-top: 1em;">Continue</button>
                </div>
            </div>
        
        </div>
                    `;
                case "credit":
                    return `
                    <div class="row" style="margin-top:1em ; border-bottom: 1px solid #008556;" >
            <h4>DELIVERY ADDRESS</h4>
        </div>

        <div class="row mt-3">
            <div class="col">
                <h5>Delivery Address</h5>
            </div>
            <div class="col-6 d-flex">
                <img src="https://1112.com/images/address_review.svg" style="padding-right: 1em;"  alt="">
                <select class="form-select"  style="width: 80%;">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col">
                <button type="button" style="width: 100%; font-weight: bold;" class="btn btn-success">Add Address</button>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col">
            </div>
            <div class="col-6">
                <div class="detail" style="color: #716E6E;">
                    <br> U life apartment 6404 wongsawang 11 Wong Sawang Bang Sue 10800 
                </div> 
                <div class="phone-number" style="color:green;">
                    <br> phone : 0943364882
                </div>
            </div>
            <div class="col">
            </div>
        </div>
        <div class="row mt-1">
            <div class="col">
                <h5>Delivery Time</h5>
            </div>
            <div class="col-1 d-flex justify-content-end">
                <img src="https://1112.com/images/deliverytime_review.svg" style="width: 30px;" alt="">
            </div>
            <div class="col-6 d-flex justify-content-end">
                <select class="form-select" id="mySelect" style="width: 100%;"  onchange="toggleParagraph()">
                    <option value="">Select time</option>
                    <option value="show">Later</option>
                    <option value="hide">Now</option>
                </select>
            </div>
            <div class="col" style="color: #716E6E;">
                <p>(30 minutes guaranteed)</p>
            </div>
        </div>
        <div class="row mt-1 " id="myParagraph">
            <div class="col">
            </div>
            <div class="col-1">
            </div>
            <div class="col-6 d-flex justify-content-between">
                <select class="form-select" id="mySelect"  >
                    <option value="">Select date</option>
                    <option value="15">15 March</option>
                    <option value="16">16 March</option>
                    <option value="16">17 March</option>
                </select>
                <select class="form-select">
                    <option value="">Select a time</option>
                    <!-- Loop through times in 30-minute intervals from 9:30 to 21:00 -->
                    <?php for ($hour = 9, $minute = 30; $hour < 21 || ($hour == 21 && $minute == 0); $minute += 30) {
                        if ($minute == 60) {
                            $hour++;
                            $minute = 0;
                        }
                        // Format the time as "hh:mm"
                        $time = sprintf('%02d:%02d', $hour, $minute);
                    ?>
                      <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                    <?php } ?>
                </select>
                  
            </div>
            <div class="col">
                
            </div>
        </div>
        <div class="row" style="margin-top: 2em;" >
            <div class="col">
                <h4>Sub - Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                <?php echo number_format($cart_total,0); ?> ฿ 
            </div>
           
        </div>
        <div class="row" style="margin-top: 1em;border-bottom: 1px solid #008556; ">
            <div class="col">
                <h4>Delivery Charge</h4>
            </div>
            <div class="col" style="text-align: end; ">
                50 B
            </div>
            
        </div>
        <div class="row" style="margin-top: 2em;" >
            <div class="col" style="text-align: end;">
                <h4>Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                <?php echo number_format($cart_total + 50,0); ?> ฿ 
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-success" style="padding-left: 4em; padding-right: 4em; font-weight:bold; margin-top: 1em;">Continue</button>
                </div>
            </div>
        
        </div>
                `;
                
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
</body>

</html>