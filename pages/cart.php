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

</head>

<body>
  <ul class="nav justify-content-center align-items-center shadow-sm  mb-5 w-100">
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
  </ul>

    <div class="order-container">
        <div class="row" >
            <h4>Order review</h4>
        </div>
        <div class="order-item" style="border-bottom: 1px solid #008556; border-top: 1px solid #008556;">
            <div class="row" style="margin-top: 1em;">
                <div class="col">
                    <h6>Crispy Thin Large</h6>
                    <p>Seafood Deluxe (519 ฿)</p>
                </div> 
                <div class="col" style="text-align: center;">
                    <p> x 1</p>
                </div>
                <div class="col" style="text-align: end;">
                    279 B
                </div> 
                <div class="col-1">
                    <a href="#">
                        <i class="fa fa-close" style="color: red;"></i>
                    </a>
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
                <div class="col-1">
                   
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 1em;">
            <div class="col"style="text-align: end;">
                sub - Total
            </div>
            <div class="col" style="text-align: end;">
                519 B
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
                <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                <label class="btn btn-outline-success" for="success-outlined" style="width: 100%; height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;" >30 Minutes Delivery</label>
            </div>
            <div class="col">
                <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
                <label class="btn btn-outline-success" for="danger-outlined" style="width: 100%;  height: 80px; display: flex; justify-content: center; align-items: center; text-align: center; font-weight: bold;">Pick Up 0 B</label>
            </div>
        </div>
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
        <div class="row" style="margin-top: 3em;border-bottom: 1px solid #008556; ">
            <div class="col">
                <h4>Sub - Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                519 B
            </div>
            <div class="col-1">

            </div>
        </div>
        <div class="row" style="margin-top: 2em;" >
            <div class="col" style="text-align: end;">
                <h4>Total</h4>
            </div>
            <div class="col" style="text-align: end; ">
                519 B
            </div>
            <div class="col-1">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="d-grid d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-success" style="padding-left: 4em; padding-right: 4em; font-weight:bold; margin-top: 1em;">Success</button>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</body>

</html>