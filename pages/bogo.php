<?php

session_start();
// Include the database connection file
require_once "../components/connect.php";

// retrieve data from the database
$sql = "SELECT pizza.pz_id, pizza.pz_name, food.fd_image, food.fd_price
        FROM pizza
        INNER JOIN pizza_detail ON pizza.pz_id = pizza_detail.pz_id
        INNER JOIN food ON pizza_detail.fd_id = food.fd_id";
$result = $pdo->query($sql);

// display data in a table
echo "<table>";
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["pz_name"] . "</td>";
    echo "<td><img src='" . $row["fd_image"] . "'></td>";
    echo "<td>$" . $row["fd_price"] . "</td>";
    echo "<td><a href='product.php?food_id=" . $row["fd_id"] . "'>Select</a></td>";
    echo "</tr>";
}

echo "</table>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bogo</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<?php require_once '../components/user_header.php'; ?>

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
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Oct2021/102216_MP.png" alt="Cheese" style = "width : 100% ;  height : 217px ;">
                   
                </div>
                <div class="item-footer">
                    <h5>Double Cheese</h5>
                    <button type="button" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                        <span>439 ฿</span>
                        <span>
                            <i class="fa fa-plus right txt" style="margin-right: 5px;"></i>Select
                        </span>
                    </button>
                </div>
            </div>
            
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Oct2021/102217_MP.png" alt="Cheese" style = "width : 100% ;  height : 217px ;">
                    
                </div>
                <div class="item-footer">
                    <h5>Double Pepperoni</h5>
                    <button type="button" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                        <span>439 ฿</span>
                        <span>
                            <i class="fa fa-plus right txt" style="margin-right: 5px;"></i>Select
                        </span>
                    </button>
                </div>
            </div>
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Oct2021/102208_MP.png" alt="Cheese" style = "width : 100% ; height : 217px ;">
                    
                </div>
                <div class="item-footer">
                    <h5>Seafood Cocktail</h5>
                    <button type="button" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                        <span>439 ฿</span>
                        <span>
                            <i class="fa fa-plus right txt" style="margin-right: 5px;"></i>Select
                        </span>
                    </button>
                </div>
            </div>
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Dec2021/102734.png" alt="Cheese" style = "width : 100% ; height : 217px  ;">
                </div>
                <div class="item-footer">
                    <h5>Spicy Super Seafood</h5>
                    <button type="button" class="btn btn-success d-flex justify-content-between" style ="width: 80%;height: 40px;  margin-left: 0.5rem; padding: 0.5rem;">
                        <span>439 ฿</span>
                        <span>
                            <i class="fa fa-plus right txt" style="margin-right: 5px;"></i>Select
                        </span>
                    </button>
                </div>
            </div>
            
            
            
        </div>
    </div>
        
    </body>
    </html>