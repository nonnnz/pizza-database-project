<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";

// check if the user is logged in
// $name = "Guest";
// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//     if($_SESSION["email"] == "admin@gmail.com") {
//         $name = "Admin";
//     } else {
//         $name = $_SESSION["fname"];
//     }
// }

// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['email'])){
    $name = $_SESSION["fname"];
}

// if (isset($_SESSION['email'])) {
//     // Redirect to login page
//     $name = $_SESSION["fname"];
// }

?>


<!DOCTYPE html>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
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
        </nav>
        <div class="main-content">
            <?php if(isset($_SESSION['email'])): ?>
                <h1>Welcome, <?php echo $name; ?>!</h1>
            <?php else: ?>
                <h1>Welcome to The Pizza Company!</h1>
            <?php endif; ?>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ac libero quis massa suscipit tristique ac a urna. Fusce iaculis sit amet nunc eu laoreet. Vivamus blandit laoreet turpis, nec blandit justo iaculis id. Pellentesque congue tortor et dolor suscipit, at hendrerit dui aliquam. Quisque dignissim purus vel sapien dignissim aliquet. Aliquam dignissim convallis dolor ac iaculis. In euismod pellentesque convallis. Aliquam erat volutpat. Integer posuere vel elit a elementum. Fusce posuere, augue quis pulvinar vulputate, ipsum tellus congue magna, id tempus velit sapien sed dolor. Pellentesque non lobortis felis. Aliquam et sem ut nibh ultricies bibendum nec ut nunc. Integer eu interdum odio. Ut laoreet iaculis faucibus.</p>
        </div>
    </div>
</body>
</html>