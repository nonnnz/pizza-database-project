<div class="header" >
   <div class="inner_header">
      <div class="logo_container">
            <h1>112Pizza</h1>
      </div>
      <ul class = "navigation">
            <li><a href="home.php">Menu</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
               <li><a href="#">Orders</a></li>
               <li><a href="profile.php">Profile</a></li>
               <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
               <li><a href="login.php">Login</a></li>
            <?php endif; ?>
      </ul>
   </div>
</div>