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

$select_order = $pdo->prepare("SELECT * FROM `order` WHERE `order_id`  = ?;");
$select_order->execute([$_GET['orid']]);
$order_results = $select_order->fetch(PDO::FETCH_ASSOC);

// echo $order_results['deli_id'];
// get items

// cart info

$cart_id = $_GET['orid'];

// array
$menu_items = array();

// if cart null
$select_order = $pdo->prepare("SELECT `order`.`order_id`, `order`.`deli_id`, `delivery`.`deli_address`, `payment`.`pay_method`, `payment`.`pay_amt`, `order`.`order_total`, `order_status`.`ords_name`
FROM `order` 
	LEFT JOIN `delivery` ON `order`.`deli_id` = `delivery`.`deli_id` 
	LEFT JOIN `payment` ON `order`.`pay_id` = `payment`.`pay_id` 
	LEFT JOIN `order_status` ON `order`.`ords_id` = `order_status`.`ords_id` WHERE `order`.`user_id`  = ? AND `order`.`ords_id` != 4");
$select_order->execute([$user_id, $cart_id]);
$order_row = $select_order->fetch(PDO::FETCH_ASSOC);


$cart_total = $order_row['cart_total'];

$sql = "SELECT `order`.`order_id`, `order_item`.`order_itemid`, `order_item`.`quantity`, `order_item`.`orderit_total`, `food`.`fd_name`, `category`.`cat_id`, `pizza`.`pz_name`, `crust`.`crust_name`, `food`.`fd_price`
FROM `order` 
	LEFT JOIN `order_item` ON `order_item`.`order_id` = `order`.`order_id` 
	LEFT JOIN `food` ON `order_item`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `category` ON `food`.`cat_id` = `category`.`cat_id`
	LEFT JOIN `pizza_detail` ON `pizza_detail`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `pizza` ON `pizza_detail`.`pz_id` = `pizza`.`pz_id` 
	LEFT JOIN `crust` ON `pizza_detail`.`crust_id` = `crust`.`crust_id`
    WHERE `order`.`order_id` = ?;";
$result = $pdo->prepare($sql);
$result->execute([$cart_id]);

// echo $result->rowCount();
// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        // 'fd_id' => $row['fd_id'],
        'fd_name' => $row['fd_name'],
        'fd_price' => $row['fd_price'],
        'order_id' => $row['order_id'],
        // 'pz_id' => $row['pz_id'],
        'pz_name' => $row['pz_name'],
        'order_itemid' => $row['order_itemid'],
        'quantity' => $row['quantity'],
        'crust_name' => $row['crust_name'],
        'orderit_total' => $row['orderit_total'],
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
  <title>tracking</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="css/style12.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    
    <div class="container p-5">
        <div class="d-flex flex-column" style="width: 100%;">
            <div class="p">
                <div class="d-flex flex-column text-center">
                    
                    <div class="p">
                        <h3>เลขที่สั่งซื้อ <?php echo $_GET['orid'] ?></h3>
                    </div>
                    <div class="p">
                        <p>กรุณาเก็บหมายเลขนี้ไว้จนกว่าสินค้าจะจัดส่งถึงมือท่าน</p>
                    </div>
                    <!-- <div class="p">
                        <p>ออร์เดอร์ของคุณจะได้รับเวลา </p>
                    </div>
                    <div class="p">
                        <p>
                            2023-03-06 18:14:14
                        </p>
                    </div> -->
                </div>
            </div>
            <div class="profile-menu d-flex justify-content-center " >
                <div class="d-flex flex-row justify-content-between" style="width: 800px; ">
                    <div class="p">
                        <a class="item-name text-center" href="" style="text-decoration: none; align-items: center;">
                            <div class="item-icon hw" style=" min-height:20vh; ">
                                <button style="border: 1px solid green; border-radius: 50%; width: 80px; height: 80px; " class="btn btn-1"> <img
                                        src="https://cdn-icons-png.flaticon.com/512/1611/1611154.png" width="70%" height="70%"></button>
                                <div class="item-name" "><font color =" #009966">ได้รับรายการอาหารแล้ว</font>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p">
                        <a class="item-name text-center" href="" style="text-decoration: none;">
                            <div class="item-icon hw" style=" min-height:20vh; ">
                                <button style="border: 1px solid green; border-radius: 50%; width: 80px; height: 80px;" class="btn btn-1"> <img
                                        src="https://cdn-icons-png.flaticon.com/512/3095/3095330.png" width="70%"
                                        height="70%"></button>
                                <div class="item-name">
                                    <font color="#009966">กำลังปรุงอาหาร</font>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p">
                        <a class="item-name text-center" href="" style="text-decoration: none;">
                            <div class="item-icon hw" style=" min-height:20vh;">
                                <button style="border: 1px solid green; border-radius: 50%; width: 80px; height: 80px; " class="btn btn-1"> <img
                                        src="https://cdn-icons-png.flaticon.com/512/5637/5637217.png" width="70%"
                                        height="70%"></button>
                                <div class="item-name">
                                    <font color="#009966">กำลังจัดส่ง</font>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p">
                        <a class="item-name text-center" href=""style="text-decoration: none;">
                            <div class="item-icon hw"style=" min-height:20vh;     ">
                                <button style="border: 1px solid green; border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://cdn-icons-png.flaticon.com/512/447/447147.png" width= "70%" height="70%"  ></button>
                                <div class="item-name"><font color ="#009966">จัดส่งเรียบร้อย</font></div>
                            </div>
                        </a>
                    </div>
                    
        
                </div>
            </div>

            <div class="detail-address">
                <h4>รายละเอียดการจัดส่ง</h4>
                <div class="NandA d-flex flex-column " style="border-top: 1px solid green; padding-top: 1em;">
                    <div class="p" style="color:green;" >
                        <p>ชื่อที่อยู่ : <?= $order_row ['deli_address'] ?></p>
                    </div>
                    <div class="p" style="color:green;" >
                        <p>จัดส่งที่ : ''''''''''''''''''-----------------</p>
                    </div>
                </div>
            </div>
            <div class="detail-food">
                <div class="detail-product" style="border-bottom: 1px solid green;">
                    <h4 >รายละเอียดสินค้า</h4>
                </div>
                <div class="list-food mt-4" style="border-bottom: 1px solid green;">
                    <div class="row mb-2">
                        <div class="col d-flex flex-column">
                            <div class="p" style="font-weight: 700; color: green;">
                                แป้งหนานุ่ม ถาดกลาง
                            </div>
                            <div class="p">
                                ซีฟู้ดค็อกเทล (439)
                            </div>
                        </div>
                        <div class="col text-center">
                            <p> x 1</p>
                        </div>
                        <div class="col text-end ">
                            <p> 439 ฿</p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col d-flex flex-column">
                            <div class="p" style="font-weight: 700; color: green;">
                                โค้ก 1.25 ลิตร
                            </div>
                        </div>
                        <div class="col text-center">
                            <p> x 1</p>
                        </div>
                        <div class="col  text-end">
                            <p> 0 ฿</p>
                        </div>
                    </div>
                </div>
                <div class="row pt-2" >
                    <div class="col-4 text-end">
                        <p>รวม</p>
                    </div>
                    <div class="col-8 text-end">
                        <p>999 ฿</p>
                    </div>
                </div>
                <div class="row" style="border-bottom: 1px solid green;">
                    <div class="col-4 text-end">
                        <p>ค่าจัดส่ง</p>
                    </div>
                    <div class="col-8 text-end">
                        <p>+50 ฿</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-end">
                        <p>ราคารวม</p>
                    </div>
                    <div class="col-8 text-end">
                        <p>14999 ฿</p>
                    </div>
                </div>
                

            </div>
            
        </div>
    </body>
    </div>
</html>