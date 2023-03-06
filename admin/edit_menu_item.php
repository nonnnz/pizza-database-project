<?php

session_start();
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

<!-- <!DOCTYPE html>
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
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu Item</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    .container{
      max-width: 550px;
    }
  </style>

</head>
<body>

  <div class="container mt-5">
    <h1>Edit Data</h1>
    <hr>

    <form action="edit_menu_item.php" method="post" enctype="multipart/form-data">
      <?php 
    
      ?>
      <div class="mb-3">
        <label for="foodname" class="col-form-label">Food name :</label>
        <input type="text" required class="form-control" name="foodname">
      </div>
      <div class="mb-3">
        <label for="des" class="col-form-label">Description :</label>
        <input type="text" required class="form-control" name="des">
      </div>
      <div class="mb-3">
          <label for="price" class="col-form-label">Price :</label>
          <input type="text" required class="form-control" name="price" pattern="\d*\.?\d+">
      </div>
      <div class="mb-3">
        <!-- <label for="category" class="col-form-label">Category :</label> -->
        <select class="form-select" aria-label=".form-select-lg example" name="category" required>
          <option value="" selected disabled>Category</option>
          <option value="1">Pizza</option>
          <option value="2">Appetizer</option>
          <option value="3">Chicken</option>
          <option value="4">Pasta</option>
          <option value="5">Salad &amp; Steak</option>
          <option value="6">Drinks &amp; Desserts</option>
        </select>
      </div>
      <div class="mb-3">
        <!-- <label for="size" class="col-form-label">Size :</label> -->
        <select class="form-select" aria-label=".form-select-lg example" name="category" required>
          <option value="" selected disabled>Size</option>
          <option value="1">M</option>
          <option value="2">L</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="img" class="col-form-label">Image :</label>
        <input type="file" required class="form-control" id="imgInput" name="img">
        <img width="100%" id="previewImg" alt="">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
        <button type="submit" name="submit" class="btn btn-success">Edit</button>
      </div>
    </form>
  </div>
    
    

  <!-- bootstrap.bundle.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
  <script>
    let imgInput = document.getElementById('imgInput');
    let previewInput = document.getElementById('previewImg');

    imgInput.onchange = evt => {
      const [file] = imgInput.files;
      if (file) {
        previewImg.src = URL.createObjectURL(file);
      }
    }
  </script>

</body>
</html>