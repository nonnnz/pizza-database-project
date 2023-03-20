  
<?php

$select_store = $pdo->query("SELECT * FROM `store`");
$select_store->execute();
$store_rows = $select_store->fetchAll(PDO::FETCH_ASSOC);


?>
  
<ul class="nav justify-content-center align-items-center shadow-sm  mb-5 w-100">
  <li class="nav-item">
    <a class="nav-link active" href="home.php"><img src="https://cdn.1112.com/1112/public/images/web/logo.svg"
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
    <ul class="dropdown-menu" style="background-color: white; height: 250px; width: auto; overflow-y: auto;">
      <?php foreach ($store_rows as $store_row): ?>
        <li><button class="dropdown-item" type="button" style="color: green; font-weight: normal; letter-spacing: -1px;"><?php echo $store_row['st_name_en'] ?></button></li>
      <?php endforeach; ?>
      <!-- <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold;">Pizza Com 304 PlazaSrimahapho</button></li>
      <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold;">Pizza ComAmata</button></li>
      <li><button class="dropdown-item" type="button" style="color: green; font-weight: bold;">Pizza ComAmnatcharoen</button></li> -->
      <!-- Add more items here -->
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
  <div class="cart position-relative">
    <a href="#" class="position-relative" id="cartDropdown">
      <i><img src="https://1112.com/images/icon_PizzaBoxII.svg" alt="cart">
      </i>
      
      <span class="position-absolute top-100 start-100 translate-middle badge rounded-pill bg-danger">
        1
      </span>
    </a>
    <div id="cartContent" class="position-absolute p-4 shadow p-3 mb-5 bg-white" style="display:none; width: 360px; height: 518px; border-radius: 12px; background-color: rgb(255, 255, 255); transform: translate(-50%, 50px);">
        <div class="cart-head">
          <h4>MY BASKET (2)</h4>
        </div>
        <div class="cart-body" style="overflow: scroll; height: 320px;">
          <div class="row d-flex justify-content-around">
            <div class="" style="padding: 0!important ; width: 80px;">
              <img src="https://cdn.1112.com/1112/public/images/products/pizza/Nov2022/199446.png" style="width: 70px; height: 53px;" alt="">
            </div>
            <div class="" style="padding: 0!important ; width: 160px;">
              <p style="font-size: 11px;">
                1 × GRILLED HAWAIIAN (+509) <br>
                NEW YORK PIZZA THIN & SOFT <br>
                LARGE
              </p> <br>
            </div>
            <div class=""  style="padding: 0!important ; width: 30px;">
              <p style="font-size: 11px;">
                ฿ 509
              </p>
            </div>
          </div>
          <div class="basket-item">
            <div class="row d-flex justify-content-around">
              <div class="" style="padding: 0!important ; width: 80px;">
                <img src="https://cdn.1112.com/1112/public/images/products/pizza/Oct2021/162216_MCT.png" style="width: 70px; height: 53px;" alt="">
              </div>
              <div class="" style="padding: 0!important ; width: 160px;">
                <p style="font-size: 11px;">
                  1 × DOUBLE CHEESE (+279) <br>
                  CRISPY THIN MEDIUM
                  
                </p> <br>
              </div>
              <div class=""  style="padding: 0!important ; width: 30px;">
                <p style="font-size: 11px;">
                  Free
                </p>
              </div>
            </div>
            <div class="remove-button d-flex justify-content-end border-bottom pb-2" >
              <button type="button" class="btn btn-outline-danger " style="border-radius: 25px; font-weight: bold; height: 25px; padding: 0px; padding-left: 10px; padding-right: 10px;"><img src="https://1112.com/images/remove_icons.svg" class="pb-1" style="width: 14px;" alt=""> Remove</button>
            </div>
          </div>
          <div class="basket-item pt-2">
            <div class="row d-flex justify-content-around">
              <div class="" style="padding: 0!important ; width: 80px;">
                <img src="https://cdn.1112.com/1112/public/images/products/chicken/116758.png" style="width: 70px; height: 53px;" alt="">
              </div>
              <div class="" style="padding: 0!important ; width: 160px;">
                <p style="font-size: 11px;">
                  1 × HONEY CHICKEN WINGS 6 PCS. 
                  
                  
                </p> <br>
              </div>
              <div class=""  style="padding: 0!important ; width: 30px;">
                <p style="font-size: 11px;">
                  ฿ 149
                </p>
              </div>
            </div>
            <div class="remove-button d-flex justify-content-end border-bottom pb-2" >
              <button type="button" class="btn btn-outline-danger " style="border-radius: 25px; font-weight: bold; height: 25px; padding: 0px; padding-left: 10px; padding-right: 10px;"><img src="https://1112.com/images/remove_icons.svg" class="pb-1" style="width: 14px;" alt=""> Remove</button>
            </div>
          </div>
          <div class="basket-item pt-2">
            <div class="row d-flex justify-content-around">
              <div class="" style="padding: 0!important ; width: 80px;">
                <img src="https://cdn.1112.com/1112/public/images/products/chicken/116758.png" style="width: 70px; height: 53px;" alt="">
              </div>
              <div class="" style="padding: 0!important ; width: 160px;">
                <p style="font-size: 11px;">
                  1 × HONEY CHICKEN WINGS 6 PCS. 
                  
                  
                </p> <br>
              </div>
              <div class=""  style="padding: 0!important ; width: 30px;">
                <p style="font-size: 11px;">
                  ฿ 149
                </p>
              </div>
            </div>
            <div class="remove-button d-flex justify-content-end border-bottom pb-2" >
              <button type="button" class="btn btn-outline-danger " style="border-radius: 25px; font-weight: bold; height: 25px; padding: 0px; padding-left: 10px; padding-right: 10px;"><img src="https://1112.com/images/remove_icons.svg" class="pb-1" style="width: 14px;" alt=""> Remove</button>
            </div>
          </div>
        </div>
        <div class="cart-footer mt-2">
          <div class="row">
            <div class="col">
              <h5>Total Price</h5>
              
            </div>
            <div class="col d-flex justify-content-end">
              <h5>฿ 1,145</h5>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-success " style="width: 100%; border-radius: 12px; font-weight: bold;">Checkout</button>
        </div>
      </div>
  </div>
  <h5 style="color: green; margin-left:1em ; ">ENG</h5>
  <div class="profile position-relative">
            <a href="#" id="profile-dropdown">
              <?php if(isset($_SESSION['user_id'])): ?>
                <div class="Username p-3" style="margin-left: 1em; color: green; background-color: #E8E8E8; text-align: center;">
                  <p>Hello,<br></p>
                  <p style="font-weight: bold;"><?php echo $name; ?></p>
                </div>
              <?php else: ?>
                <a  href="login.php" class="Username p-3" style="margin-left: 1em; color: green; background-color: #E8E8E8; text-align: center;">
                  <p>Login</p>
                </a>
              <?php endif; ?>
            </a>
            <div id="profileContent" class="position-absolute p-2 shadow p-3 mb-5 bg-white" style="display : none;width: 270px; height: 280px; border-radius: 12px; background-color: rgb(248, 246, 246)!important; transform: translate(-170px, 10px);">
                <div class="d-flex flex-column">
                    <div class="p-1 ">
                      <a href="profile.php">
                        <button type="button" class="btn btn-success w-100 fill">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/my-profile.svg" alt=""> 
                            </div>
                            <div class="col">
                              My Profile
                            </div>
                          </div>
                        </button>
                      </a>    
                      </div>
                    <!-- <div class="p-1 ">
                      <a href="tax_information.php">
                        <button type="button" class="btn btn-success w-100">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/tax-information.svg" alt=""> 
                            </div>
                            <div class="col">
                              Tax Information
                            </div>
                          </div>
                        </button>
                      </a>
                    </div> -->
                    <div class="p-1 ">
                      <a href="address_book.php">
                        <button type="button" class="btn btn-success w-100">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/address-book.svg" alt=""> 
                            </div>
                            <div class="col">
                              Address Book
                            </div>
                          </div>
                        </button>
                      </a>
                    </div>
                    <div class="p-1 ">
                      <a href="credit-card.php">
                        <button type="button" class="btn btn-success w-100">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/credit-card.svg" alt=""> 
                            </div>
                            <div class="col">
                              Credit Card
                            </div>
                          </div>
                        </button>
                      </a>
                    </div>
                    <div class="p-1 ">
                      <a href="tracker.php">
                        <button type="button" class="btn btn-success w-100">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/Tracker.svg" alt=""> 
                            </div>
                            <div class="col">
                              Pizza Tracker
                            </div>
                          </div>
                        </button>
                      </a>
                    </div>
                    <div class="p-1 ">
                        <button type="button" class="btn btn-success w-100">
                          <div class="row">
                            <div class="col-1">
                              <img src="https://1112.com/images/logout.svg" alt=""> 
                            </div>
                            <div class="col">
                              LOGOUT
                            </div>
                          </div>
                        </button>
                    </div>
                </div>
            </div>

  </div>

</ul>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script lang="js">
    $(document).ready(() => {
      $('#cartDropdown').click((e) => {
        $('#cartContent').toggle();
      })
    });
  </script>
  <script lang="js">
        $(document).ready(() => {
            $('#profile-dropdown').click((e) => {
                $('#profileContent').toggle();
            })
        });
    </script>

    <style>   
    #profileContent button {
        background-color: white;
        color: green;
        font-weight: bold;
        display: flex;
        text-align: center;
        align-items: center;
    }
    #profileContent img {
        width: 40px;
        height: 26px;
    }
    </style>