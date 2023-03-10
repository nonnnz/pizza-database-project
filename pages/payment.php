<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
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

    <!-- <ul class="nav justify-content-center align-items-center shadow-sm  mb-5 w-100">
        <li class="nav-item">
          <a class="nav-link active" href="#"><img src="https://cdn.1112.com/1112/public/images/web/logo.svg"
              alt="Pizza_logo"></a>
        </li>
        <ul class="nav nav-pills nav-fill border border-green p-1  gap-2 p-1.5 small bg-white rounded-5 shadow-sm"
          id="pillNav2" role="tablist"
          style="--bs-nav-link-color: var(--bs-black); --bs-nav-pills-link-active-color: var(--bs-white); --bs-nav-pills-link-active-bg: var(--bs-green);">
          <li class="nav-item" role="presentation">
            <button  class="nav-link active rounded-5" id="home-tab2" data-bs-toggle="tab"
              type="button" role="tab" aria-selected="true"
              style="font-size: 15px; padding-left:2em; padding-right:2em;">Delivery</button>
          </li>
          <li class="nav-item" role="presentation">
            <button  class="nav-link rounded-5" id="profile-tab2" data-bs-toggle="tab"
              type="button" role="tab" aria-selected="false"
              style="font-size: 15px; padding-left:2em; padding-right:2em;">Pick Up</button>
          </li>
        </ul>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle px-3 rounded-5" type="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            style="padding-right: 8rem!important; margin-left: 1em; margin-right: 1em; background-color: white; color: black;">
            <img src="https://1112.com/images/location_icon.svg"> Select Address
          </button>
          <ul class="dropdown-menu" style="background-color: white;">
            <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold; ">Pizza Com 304 PlazaSrimahapho</button></li>
            <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold;">Pizza ComAmata</button></li>
            <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold;">Pizza ComAmnatcharoen</button></li>
          </ul>
        </div>
        
        <a href="#" style="text-decoration: none;">
          <div class="point" style="margin-left: 1em;  margin-right : 1em;color: green;text-align: center;">
            <img src="https://1112.com/images/ta-card_new.svg" alt="point">
            <p>0 point</p>
          </div>
        </a>
        <a href="#" style="text-decoration: none;">
          <div class="point" style="margin-left: 1em;  margin-right : 2em;color: green;text-align: center;">
            <img src="https://1112.com/images/loyalty_new.svg" alt="card">
            <p>TA card</p>
          </div>
        </a>
        <div class="cart">
          <a href="#" class="position-relative">
            <i><img src="https://1112.com/images/icon_PizzaBoxII.svg" alt="cart">
            </i>
            <span class="position-absolute top-100 start-100 translate-middle badge rounded-pill bg-danger">
              1
            </span>
          </a>
        </div>
        <h5 style="color: green; margin-left:1em ; ">ENG</h5>
        <div class="Username p-3" style="margin-left: 1em; color: green; background-color: #E8E8E8; text-align: center;">
          <p>Hello,<br></p>
          <p style="font-weight: bold;">Peerasin</p>
        </div>
      </ul> -->
    <div class="pickup-container" >
        <h4>PICKUP STORE</h4>
        <div class="store" style="display: flex;  border-top: 1px solid #008556; padding-top: 1em;">
            <img src="https://1112.com/images/selectstore_review.svg" alt="STORE" style="margin-right: 1em;">
            Pizza Com 304 Plaza Srimahapho
        </div>
        <div class="pickup-time"  style="display: flex;  padding-top: 1em;" >
            <img src="https://1112.com/images/deliverytime_review.svg" alt="clock" style="margin-right: 1em;">
            Pickup Now
        </div>
    </div>

    <div class="order-review">
        <h4>ORDER REVIEW</h4>

        <div class="order-bill" style="border-top: 1px solid #008556;" >
            <div class="row" style="margin-top: 1em;">
                <div class="col">
                    <h6>Crispy Thin Large</h6>
                    <p>Seafood Deluxe (519 ฿)</p>
                </div> 
                <div class="col" style="text-align: center;">
                    <p> x 1</p>
                </div>
                <div class="col" style="text-align: end;">
                     519 ฿

                </div> 
            </div>
            <div class="row">
                <div class="col">
                    <h6>Crispy Thin Large</h6>
                    <p>Double Pepperoni (399 ฿)</p>
                </div> 
                <div class="col" style="text-align: center;">
                    <p> x 1</p>
                </div>
                <div class="col" style="text-align: end;">
                    Free            
                </div>                 
            </div>
            <div class="row" style="margin-top: 1em; border-top: 1px solid #008556; padding-top: 1em;">
                <div class="col"></div>
                <div class="col"style="text-align: end;">
                    Total
                </div>
                <div class="col" style="text-align: end;">
                    519 ฿

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
    <div class="payment-options" style="padding-left: 3em; padding-right: 3em;">
        <h4>PAYMENT OPTIONS</h4>
        <div class="payment-button" style="border-top: 1px solid green; border-bottom: 1px solid green; padding-top: 1em; padding-bottom: 2em;">
            <div class="row">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group" >
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-success d-flex flex-column" for="btnradio1" style="text-align: center; align-items: center;  height: 80px; border-radius: 12px;">
                        <img class ="p" src="https://1112.com/images/cash_payment.svg" alt="cash" style="width: 40px; background-color: white; border: 1px solid white; border-radius: 5px; width:15%;">
                        <p class="p">Cash On Delivery</p>
                    </label>
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-success d-flex flex-column" for="btnradio2" style="padding-top: 1em; text-align: center; display: flex; justify-content: center; align-items: center;  height: 80px; margin-left: 10px; margin-right: 10px; border-radius: 12px;  width:15%;">
                        <img class ="p" src="https://1112.com/images/credit-card_payment.svg" alt="cash" style="width: 40px; border: 1px solid white; background-color: white; border-radius: 5px; clip-path: inset(5px 1px 5px 1px);">
                        <p class="p">Credit Card</p>
                    </label>
                  
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-success d-flex flex-column" for="btnradio3" style="padding-top: 1em; text-align: center; display: flex; justify-content: center; align-items: center; height: 80px;  border-radius: 12px; width:15%;">
                        <img class ="p" src="https://1112.com/images/truemoney_payment.svg" alt="cash" style="width: 40px; border: 1px solid white; background-color: white; border-radius: 5px; clip-path: inset(5px 1px 5px 1px);">
                        <p class="p">TrueMoney Wallet</p>
                    </label>
                </div>  
            </div>
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
        </div>
        <div class="d-flex align-items-end flex-column" >
            <button type="button" class="btn btn-success p" style="font-weight: bold; margin-top: 1em; padding-left: 4em; padding-right: 4em;">Place Order</button>
        </div>

    </div>
</body>
</html>