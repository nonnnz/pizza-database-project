<?php

session_start();
require_once "../components/connect.php";

if (isset($_GET['id'])){
  $id = $_GET['id'];
  $stmt = $pdo->prepare("SELECT f.fd_id, f.fd_name, f.fd_price, f.fd_image, c.cat_name
                      FROM food f JOIN category c ON f.cat_id = c.cat_id WHERE f.fd_id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $item = $stmt->fetch(PDO::FETCH_ASSOC);

  // Get the list of categories for the drop-down menu
  $catstmt = $pdo->query("SELECT * FROM `category`");
  $catstmt->execute();
  $cat = $catstmt->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST['edit'])){
  $id = $_POST['id'];
  $fd_name = $_POST['foodname'];
  $price = $_POST['price'];
  $cat = $_POST['category'];
  $img = $_FILES['img'];

  $img2 = $_POST['img2'];
  $upload = $_FILES['img']['name'];

  if ($upload != ''){
    $allow = array('jpg', 'jpeg', 'png');
    // separate name and file extension
    $extension = explode(".", $img['name']);
    // convert file extension to small
    $fileActExt = strtolower(end($extension));
    // upload to folder images
    $filePath = "../images/product/pizza/" . $fileActExt;

    if (in_array($fileActExt, $allow)){
      $fileNew = $img['name'];
      $filePath = "../images/product/pizza/" . $fileNew;
      // check size
      if ($img['size'] > 0 && $img['error'] == 0){
        move_uploaded_file($img['tmp_name'], $fileNew);
      }
    }
  } else {
    $fileNew = $img2;
  }

  $sql = $pdo->prepare("UPDATE food SET fd_name = :fd_name, fd_price = :price, cat_id = :cat, fd_image = :img WHERE fd_id = :id");
  $sql->bindParam(":id", $id);
  $sql->bindParam(":fd_name", $fd_name);
  $sql->bindParam(":price", $price);
  $sql->bindParam(":cat", $cat);
  $sql->bindParam(":img", $fileNew);
  $sql->execute();

  if ($sql){
    $_SESSION['success'] = "Menu has been edited Successfully";
    header("location: menu_management.php");
  } else {
    $_SESSION['error'] = "Menu has not been edited Successfully";
    header("location: menu_management.php");
  }
  
}


// if(isset($_POST['edit'])){
//   $id = $_POST['id'];
//   $fd_name = $_POST['foodname'];
//   $price = $_POST['price'];
//   $cat = $_POST['category'];
//   $img = $_FILES['img'];

//   $img2 = $_POST['img2'];
//   $upload = $_FILES['img']['name'];

//   if ($upload != ''){
//     $allow = array('jpg', 'jpeg', 'png');
//     // separate name and file extension
//     $extension = explode(".", $img['name']);
//     // convert file extension to small
//     $fileActExt = strtolower(end($extension));
//     // upload to folder images
//     $filePath = "../images/product/pizza/" . $fileActExt;

//     if (in_array($fileActExt, $allow)){
//       $fileNew = $img['name'];
//       $filePath = "../images/product/pizza/" . $fileNew;
//       // check size
//       if ($img['size'] > 0 && $img['error'] == 0){
//         move_uploaded_file($img['tmp_name'], $fileNew);
//       }
//     }
//   } else {
//     $fileNew = $img2;
//   }

//   $sql = $pdo->prepare("UPDATE food SET fd_name = :fd_name, fd_price = :price, cat_id = :cat, fd_image = :img WHERE fd_id = :id");
//   $sql->bindParam(":id", $id);
//   $sql->bindParam(":fd_name", $food_name);
//   $sql->bindParam(":price", $price);
//   $sql->bindParam(":cat", $cat);
//   $sql->bindParam(":img", $fileNew);
//   $sql->execute();

//   if ($sql){
//     $_SESSION['success'] = "Menu has been edited Successfully";
//     header("location: menu_management.php");
//   } else {
//     $_SESSION['error'] = "Menu has not been edited Successfully";
//     header("location: menu_management.php");
//   }
  
// }
// if(isset($_GET['id'])) {
//   $id = $_GET['id'];
  
//   // Fetch the menu item by ID
//   $stmt = $pdo->prepare("SELECT * FROM food WHERE fd_id = :id");
//   $stmt->bindParam(':id', $id);
//   $stmt->execute();
//   $item = $stmt->fetch(PDO::FETCH_ASSOC);
  
//   if(!$item) {
//     // Item not found
//     header("Location: menu_management.php");
//     exit;
//   }
  
//   if(isset($_POST['submit'])) {
//     // Update the menu item
//     // $fd_des = $_POST['fd_des'];
//     // $pz_id = $_POST['pz_id'];
//     // $fd_image = $_POST['fd_image'];
    
//     // $stmt = $pdo->prepare("UPDATE food SET fd_des = :fd_des, pz_id = :pz_id, fd_image = :fd_image WHERE fd_id = :id");
//     // $stmt->bindParam(':fd_des', $fd_des);
//     // $stmt->bindParam(':pz_id', $pz_id);
//     // $stmt->bindParam(':fd_image', $fd_image);
//     // $stmt->bindParam(':id', $id);
//     // $stmt->execute();
    
//     header("Location: menu_management.php");
//     exit;
//   }
// } else {
//   // No ID specified
//   header("Location: menu_management.php");
//   exit;
// } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    .container{
      max-width: 500px;
    }
    #previewImg{
      display: block;
      margin: auto;
    }
  </style>

</head>
<body>

  <div class="container mt-5">
    <h1>Edit Food</h1>
    <hr>
    <form action="edit_menu_item.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <input type="text" readonly value="<?= $item['fd_id']; ?>" required class="form-control" name="id">
        <label for="foodname" class="col-form-label">Food name :</label>
        <input type="text" value="<?= $item['fd_name']; ?>" required class="form-control" name="foodname">
        <input type="hidden" value="<?= $item['fd_image']; ?>" required class="form-control" name="img2">
      </div>
      <div class="mb-3">
          <label for="price" class="col-form-label">Price :</label>
          <input type="text" value="<?= $item['fd_price']; ?>" required class="form-control" name="price" pattern="\d*\.?\d+">
      </div>
      <div class="mb-3">
        <select class="form-select" aria-label=".form-select-lg example" name="category">
          <option value=""><?php echo $item['cat_name']; ?></option>
          <?php foreach ($cat as $categories){
              echo '<option value="' . $categories['cat_id'] . '">' . $categories['cat_name'] . '</option>';
            }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="img" class="col-form-label">Image :</label>
        <input type="file" class="form-control" id="imgInput" name="img">
        <img width="50%" src="<?php echo $item['fd_image']; ?>" id="previewImg" alt="<?php echo $item['fd_name']; ?>" >
      </div>

      <div class="modal-footer">
        <a class="btn btn-secondary" href="menu_management.php">Back</a>
        <button type="submit" name="edit" class="btn btn-success">Edit</button>
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