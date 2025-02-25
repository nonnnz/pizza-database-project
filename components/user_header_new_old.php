  
<?php

$select_store = $pdo->query("SELECT * FROM `store`");
$select_store->execute();
$store_rows = $select_store->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT `shopping_cart`.`cart_id`, `shopping_cart`.`cart_total`, `cart_item`.`cart_itemid`, `cart_item`.`quantity`, `cart_item`.`cartit_total`, `food`.`fd_name`, `category`.`cat_id`, `pizza`.`pz_name`, `crust`.`crust_name`, `food`.`fd_price`, `food`.`fd_image`
FROM `shopping_cart` 
	LEFT JOIN `cart_item` ON `cart_item`.`cart_id` = `shopping_cart`.`cart_id` 
	LEFT JOIN `food` ON `cart_item`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `category` ON `food`.`cat_id` = `category`.`cat_id`
	LEFT JOIN `pizza_detail` ON `pizza_detail`.`fd_id` = `food`.`fd_id` 
	LEFT JOIN `pizza` ON `pizza_detail`.`pz_id` = `pizza`.`pz_id` 
	LEFT JOIN `crust` ON `pizza_detail`.`crust_id` = `crust`.`crust_id`
    WHERE `shopping_cart`.`cart_id` = ?;";
$result = $pdo->prepare($sql);
$result->execute([$cart_id]);

// echo $result->rowCount();
// Fetch the query results and build an array of menu items
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        // 'fd_id' => $row['fd_id'],
        'fd_name' => $row['fd_name'],
        'fd_price' => $row['fd_price'],
        'fd_image' => $row['fd_image'],
        'cat_id' => $row['cat_id'],
        // 'pz_id' => $row['pz_id'],
        'pz_name' => $row['pz_name'],
        'cart_itemid' => $row['cart_itemid'],
        'quantity' => $row['quantity'],
        'crust_name' => $row['crust_name'],
        'cartit_total' => $row['cartit_total'],
    );

    array_push($menu_items, $menu_item);
}


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
    <div id="cartContent" class="position-absolute p-4 shadow p-3 mb-5 bg-white" style="display:none; width: 360px; height: 518px; border-radius: 12px; background-color: rgb(255, 255, 255); transform: translate(-50%, 50px); z-index: 1;">
        <div class="cart-head">
          <h4>MY BASKET (2)</h4>
        </div>
        <div class="cart-body" style="overflow: scroll; height: 320px;">
        <?php foreach ($menu_items as $menu_item): ?>
          <?php   if($menu_item['cat_id'] == 1) {?>
            <div class="row d-flex justify-content-around">
              <div class="" style="padding: 0!important ; width: 80px;">
                <img src="<?php echo $menu_item['fd_image']; ?>" style="width: 70px; height: 53px;" alt="">
              </div>
              <div class="" style="padding: 0!important ; width: 160px;">
                <p style="font-size: 11px;">
                <?php echo $menu_item['quantity']; ?> × <?php echo $menu_item['pz_name']; ?> (+<?php echo $menu_item['fd_price']; ?>) <br>
                  <?php echo $menu_item['crust_name']; ?>
                </p> <br>
              </div>
              <div class=""  style="padding: 0!important ; width: 30px;">
                <p style="font-size: 11px;">
                  ฿ <?php echo $menu_item['fd_price']; ?>
                </p>
              </div>
              <div class="remove-button d-flex justify-content-end border-bottom pb-2" >
                <button type="button" class="btn btn-outline-danger " style="border-radius: 25px; font-weight: bold; height: 25px; padding: 0px; padding-left: 10px; padding-right: 10px;"><img src="https://1112.com/images/remove_icons.svg" class="pb-1" style="width: 14px;" alt=""> Remove</button>
              </div>
            </div>  
          <?php } else { ?>
            <div class="basket-item pt-2">
              <div class="row d-flex justify-content-around">
                <div class="" style="padding: 0!important ; width: 80px;">
                  <img src="<?php echo $menu_item['fd_image']; ?>" style="width: 70px; height: 53px;" alt="">
                </div>
                <div class="" style="padding: 0!important ; width: 160px;">
                  <p style="font-size: 11px;">
                  <?php echo $menu_item['quantity']; ?> × <?php echo $menu_item['fd_name']; ?>. 
                    
                    
                  </p> <br>
                </div>
                <div class=""  style="padding: 0!important ; width: 30px;">
                  <p style="font-size: 11px;">
                    ฿ <?php echo $menu_item['cartit_total']; ?>
                  </p>
                </div>
              </div>
              <div class="remove-button d-flex justify-content-end border-bottom pb-2" >
                <button type="button" class="btn btn-outline-danger " style="border-radius: 25px; font-weight: bold; height: 25px; padding: 0px; padding-left: 10px; padding-right: 10px;"><img src="https://1112.com/images/remove_icons.svg" class="pb-1" style="width: 14px;" alt=""> Remove</button>
              </div>
            </div>
          <?php }?>
        <?php endforeach; ?>
        </div>
        <div class="cart-footer mt-2">
          <div class="row">
            <div class="col">
              <h5>Total Price</h5>
              
            </div>
            <div class="col d-flex justify-content-end">
              <h5>฿ <?= $cart_total ?></h5>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-success " style="width: 100%; border-radius: 12px; font-weight: bold;">Checkout</button>
        </div>
      </div>
  </div>
  <h5 style="color: green; margin-left:1em ; ">ENG</h5>
  <div class="profile position-relative">
            
              <?php if(isset($_SESSION['user_id'])): ?>
                <a href="#" id="profile-dropdown">
                <div class="Username p-3" style="margin-left: 1em; color: green; background-color: #E8E8E8; text-align: center;">
                  <p>Hello,<br></p>
                  <p style="font-weight: bold;"><?php echo $name; ?></p>
                </div>
              <?php else: ?>
                <div style="background-color:#E8E8E8;padding-left: 10px;padding-right: 10px;margin-left: 10px;margin-right: 0px;display: block;padding-bottom: 10px;padding-top: 10px;">
                  <a  href="login.php" class="Username" style=" color: green; background-color: #E8E8E8; text-align: center;">
                    <p>Login</p>
                  </a>
                </div>
              <?php endif; ?>
            </a>
            <div id="profileContent" class="position-absolute p-2 shadow p-3 mb-5 bg-white" style="display : none;width: 270px; height: 280px; border-radius: 12px; background-color: rgb(248, 246, 246)!important; transform: translate(-170px, 10px);  z-index: 2;">
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
                      <a href="address-book.php">
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
                      <a href="logout.php">
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
                      </a>
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