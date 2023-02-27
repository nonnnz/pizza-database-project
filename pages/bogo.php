<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bogo</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="header" >
        <div class="inner_header">
            <div class="logo_container">
                <h1>112Pizza</h1>
            </div>
            <ul class = "navigation">
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
        </div>
    </div>
    <div class="home-category" style = "margin-top: 80px ">

        <h5 style = "margin-left : 6em;">Menu</h5>
        <div class="category_container" style = "font-size : 10px;">
            
            <div class="bcate cate1" >
                <h6 id="bottom">Pizza</h6>
            </div>
            <div class="bcate cate2">
                <h6 id="bottom">Pizza of the<br>month</h6>
            </div>
            <div class="bcate cate3">
                <h6 id="bottom">Appetizer</h6>
            </div>
            <div class="bcate cate4">
                <h6 id="bottom">Chicken</h6>
            </div>
            <div class="bcate cate5">
                <h6 id="bottom">Pasta</h6>
            </div>
            <div class="bcate cate6">
                <h6 id="bottom">Salad & Steak</h6>
            </div>
            
        </div>
    </div>
    
    <h3 style = "text-align: center; padding-top : 1em;">SPECIAL DEAL BUY 1 GET 1 FREE</h3>
    <div class="container">

        <div class="product_container" >
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Oct2021/102216_MP.png" alt="Cheese" style = "width : 100% ; height : 100% ;">
                    <h5>Double Cheese</h5>
                </div>
                
                <div class="p_footer">
                    <a href="#" style = "text-decoration: none;">
                        <div class="price_left">
                            <span class="left price" style = "color : white;">299 ฿</span>
                        </div>
                    </a>
                    <a href="#" style = "text-decoration: none;">
                        <div class="select_right">
                            <span class="right txt" style = "color : white;"><i class="fa fa-plus"></i> Select</span>
                        </div>
                    </a>
                    
                </div>
                
            </div>
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Oct2021/102217_MP.png" alt="Cheese" style = "width : 100% ; height : 100% ;">
                    <h5>Double Pepperoni</h5>
                </div>
                
                <div class="p_footer">
                    <a href="#" style = "text-decoration: none;">
                        <div class="price_left">
                            <span class="left price" style = "color : white;">299 ฿</span>
                        </div>
                    </a>
                    <a href="#" style = "text-decoration: none;">
                        <div class="select_right">
                            <span class="right txt" style = "color : white;"><i class="fa fa-plus"></i> Select</span>
                        </div>
                    </a>
                    
                </div>
                
            </div>
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Feb2023/216296_EGM_1.png" alt="Cheese" style = "width : 258.67px ; height : 185.72px ;">
                    <h5>Seafood Bacon</h5>
                </div>
                
                <div class="p_footer">
                    <a href="#" style = "text-decoration: none;">
                        <div class="price_left">
                            <span class="left price" style = "color : white;">539 ฿</span>
                        </div>
                    </a>
                    <a href="#" style = "text-decoration: none;">
                        <div class="select_right">
                            <span class="right txt" style = "color : white;"><i class="fa fa-plus"></i> Select</span>
                        </div>
                    </a>
                    
                </div>
                
            </div>
            <div class="product">
                <div class="product_item">
                    <img src="https://cdn.1112.com/1112/public//images/products/pizza/Nov2022/199446.png" alt="Cheese" style = "width : 100% ; height : 185.72px ;">
                    <h5>Grilled Hawaiian</h5>
                </div>
                
                <div class="p_footer">
                    <a href="#" style = "text-decoration: none;">
                        <div class="price_left">
                            <span class="left price" style = "color : white;">509 ฿</span>
                        </div>
                    </a>
                    <a href="#" style = "text-decoration: none;">
                        <div class="select_right">
                            <span class="right txt" style = "color : white;"><i class="fa fa-plus"></i> Select</span>
                        </div>
                    </a>
                    
                </div>
                
            </div>
            
            
        </div>
    </div>
        
    </body>
    </html>