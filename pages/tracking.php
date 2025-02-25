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


    </body>
    </div>
</html>