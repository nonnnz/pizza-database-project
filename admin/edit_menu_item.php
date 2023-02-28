<?php
require_once "../components/connect.php";

if(isset($_GET['id'])) {
  $id = $_GET['id'];
  
  // Fetch the menu item by ID
  $stmt = $pdo->prepare("SELECT * FROM food WHERE fd_id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $item = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if(!$item) {
    // Item not found
    header("Location: menu_management.php");
    exit;
  }
  
  if(isset($_POST['submit'])) {
    // Update the menu item
    // $fd_des = $_POST['fd_des'];
    // $pz_id = $_POST['pz_id'];
    // $fd_image = $_POST['fd_image'];
    
    // $stmt = $pdo->prepare("UPDATE food SET fd_des = :fd_des, pz_id = :pz_id, fd_image = :fd_image WHERE fd_id = :id");
    // $stmt->bindParam(':fd_des', $fd_des);
    // $stmt->bindParam(':pz_id', $pz_id);
    // $stmt->bindParam(':fd_image', $fd_image);
    // $stmt->bindParam(':id', $id);
    // $stmt->execute();
    
    header("Location: menu_management.php");
    exit;
  }
} else {
  // No ID specified
  header("Location: menu_management.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu Item</title>
</head>
<body>
    <h1>Edit Menu Item</h1>
    <form action="edit_menu_item.php" method="post">
 
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
