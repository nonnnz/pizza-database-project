<!-- Select Pizza --> 
<?php 

session_start();
require_once "../components/connect.php";

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: ../pages/login.php");
    exit();
}

if(isset($_POST['add_cart'])) {
    $user_id = $_SESSION['user_id'];
    $food_id = $_POST['pizza'];
    $size_id = $_POST['size'];
    $crust_id = $_POST['crust'];
    $quantity = 1;
    
    // Get cart session or create new one
    if (isset($_SESSION['cart_session_id'])) {
        $cart_session_id = $_SESSION['cart_session_id'];
    } else {
        $cart_session_query = $pdo->prepare("INSERT INTO cart_session (user_id, created_at, expires_at) VALUES (:user_id, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY))");
        $cart_session_query->execute(['user_id' => $user_id]);
        $cart_session_id = $pdo->lastInsertId();
        $_SESSION['cart_session_id'] = $cart_session_id;
    }
    
    // Check if cart item already exists
    $cart_item_query = $pdo->prepare("SELECT * FROM cart_item WHERE cart_session_id = :cart_session_id AND food_id = :food_id AND size_id = :size_id AND crust_id = :crust_id");
    $cart_item_query->execute(['cart_session_id' => $cart_session_id, 'food_id' => $food_id, 'size_id' => $size_id, 'crust_id' => $crust_id]);
    $cart_item = $cart_item_query->fetch();
    
    if ($cart_item) {
        // Update quantity
        $cart_item_id = $cart_item['cart_item_id'];
        $quantity = $cart_item['quantity'] + 1;
        $cart_update_query = $pdo->prepare("UPDATE cart_item SET quantity = :quantity, created_at = NOW() WHERE cart_item_id = :cart_item_id");
        $cart_update_query->execute(['quantity' => $quantity, 'cart_item_id' => $cart_item_id]);
    } else {
        // Insert new cart item
        $cart_item_insert_query = $pdo->prepare("INSERT INTO cart_item (cart_session_id, food_id, size_id, crust_id, quantity, created_at) VALUES (:cart_session_id, :food_id, :size_id, :crust_id, :quantity, NOW())");
        $cart_item_insert_query->execute(['cart_session_id' => $cart_session_id, 'food_id' => $food_id, 'size_id' => $size_id, 'crust_id' => $crust_id, 'quantity' => $quantity]);
    }
    
    // Redirect to cart page
    header("Location: ../pages/cart.php");
    exit();
}

// Prepare the SQL queries
$pizza_query = $pdo->prepare("SELECT * FROM pizza");
$pizza_query->execute();
$pizzas = $pizza_query->fetchAll();

$crust_query = $pdo->prepare("SELECT * FROM crust");
$crust_query->execute();
$crusts = $crust_query->fetchAll();

$size_query = $pdo->prepare("SELECT * FROM size");
$size_query->execute();
$sizes = $size_query->fetchAll();

$image_query = $pdo->prepare("SELECT * FROM food");
$image_query->execute();
$images = $image_query->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form method="POST" action="../pages/cart.php">
            <div class="form-group"> <!-- Select pizza -->
                <label for="pizza-select">Pizza Name:</label>
                <select class="form-select form-select-sm" name="pizza" method="post" id="pizza-select" aria-label="Select a Pizza">
                    <?php foreach($pizzas as $pizza) { ?>
                        <option value="<?php echo $pizza['pz_id']; ?>"><?php echo $pizza['pz_name']; ?></option>
                    <?php } ?>
                </select>
            </div> <br>

            <div class="form-group"> <!-- Select Size -->
                <label for="size-select">Size:</label>
                <select class="form-select form-select-sm" name="size" method="post" id="size-select" aria-label="Select a Size">
                    <?php foreach($sizes as $size) { ?>
                        <option value="<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></option>
                    <?php } ?>
                </select> 
            </div> <br>
            
            <div class="form-group"> <!-- Select crust -->
                <label for="crust-select">Crust:</label>
                <select class="form-select form-select-sm" name="crust" method="post" id="crust-select" aria-label="Select a Crust">
                    <?php foreach($crusts as $crust) { ?>
                        <option value="<?php echo $crust['crust_id']; ?>"><?php echo $crust['crust_name']; ?></option>
                    <?php } ?>
                </select>
            </div> <br>

            <div class="form-group"> <!-- image -->
                <img src="<?php echo $images[0]['fd_image']; ?>" id="fd-img" width="200" height="200">
            </div>

            <!-- button add to cart --> <!-- Do select second pizza mai pen (wai edit na) -->
            <div class="form-group"> 
                <input type="submit" name="add_cart" value="Add to cart" class="btn btn-success">
                <a href="bogo.php" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>

    <!-- jQuery -->
    
    <!-- JS -->
    <script src="script.js"></script>
    
</body>
</html>