<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBogo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/script.js"></script>
    <script src="https://kit.fontawesome.com/f8a584406d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://kit.fontawesome.com/f8a584406d.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-cF1nBvxbnU27eJm6YM8U6mGx6p7MTdZtwmk9df8VoyW5Jv0yzw5y5c5sw2V5Wx0vNo2tZzM9RZhK8V+dWUGrOQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <h4 style = "text-align: center; padding-top : 1em;">SELECT FIRST PIZZA</h4>
    <div class="pizza-item-container" >
        <div class="row">
            <div class="col text-center">
                <img src="https://cdn.1112.com/1112/public/images/products/pizza/Oct2021/162216_MCT.png" alt="Cheese" style="height: 315px; width: 400px;">
            </div>
            <div class="col">
                
                <select class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6; font-weight: bold; ">
                    <option value="1">DOUBLE CHEESE</option>
                    <option value="2">DOUBLE PEPPERONI</option>
                    <option value="3">SEAFOOD BACON</option>
                    <option value="4">GRILLED HAWAIIAN</option>
                </select>
                <p class="pt-3">Extra Cheese and Pizza Sauce</p>
                <h3>Price 279 ฿ </h3>
                <div class="row  pt-3">
                    <div class="col-4">
                        <h5 >Select <br> Size</h5>
                    </div>
                    <div class="col-8 d-flex flex-row">
                        <div class="row">
                            <div class="col bottom-0">
                                <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                                <label class="btn btn-outline-success " for="success-outlined" style="border-radius: 100%; ">M</label>
                            </div>
                            <div class="col">
                                <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                                <label class="btn btn-outline-success" for="danger-outlined" style="border-radius: 100% ; display : flex ; justify-content: center; width: 50px; height: 50px; text-align: center; align-items: center;">L</label>
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
                            <select class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6 ;font-weight: bold;">
                                <option value="1">Crispy Thin Medium</option>
                                <option value="2">Extreme Giant Crab Stick Medium</option>
                                <option value="3">Pan Medium</option>
                                <option value="4">Extreme Cheese Medium</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div style="text-align: center;">
            <button id="toggle-button" class="button1" onclick="toggleButton()">Select 2nd Pizza</button>
        </div>
        <div style="text-align: center; margin-top: 2em;">
            <button id="toggle-button-ingredients" onclick="IngredientsButton()"><img src="https://1112.com/images/cutlery_pizza_custom.svg" alt="knife"> 
                Customize Pizza <br> * Up to 7 extra ingredients</button>
        </div>

        <div id="Ingredients-container" style="display: none;">
            <p>Select Sauce</p>
            <select class="form-select bg- text-success" aria-label="Default select example" style="background-color: #f2f9f6 ;font-weight: bold; width: 30%;">
                <option disabled selected>Pizza Sauce</option>
                <option value="2">Extreme Giant Crab Stick Medium</option>
                <option value="3">Pan Medium</option>
                <option value="4">Extreme Cheese Medium</option>
            </select>
            <p style="color : green ; margin : 1em ;">Ingredients in this pizza</p>
            <div class="card border border-success"  style="width: 13rem; display: flex; justify-content: center; align-items: center; text-align: center; border-radius: 15px;" >
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
            </div>
        </div>

    </div>


    </body>
    </html>