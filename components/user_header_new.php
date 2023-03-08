  
<?php

$select_store = $pdo->query("SELECT * FROM `store`");
$select_store->execute();
$store_rows = $select_store->fetchAll(PDO::FETCH_ASSOC);


?>
  
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
</ul>