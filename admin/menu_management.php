<?php

session_start();
// Include the database connection file
require_once "../components/connect.php";

// array
$menu_items = array();

// Query the database for the menu items
$stmt = $pdo->query("SELECT f.fd_id, c.cat_name, f.fd_name, f.fd_price, f.fd_image 
                    FROM food f JOIN category c ON f.cat_id = c.cat_id");
$stmt->execute();

// Handle deleting a user
// if (isset($_POST['delete_user'])) {
//   $user_id = $_POST['delete_user'];
//   // echo $_POST['delete_user'];
//   $stmt = $pdo->prepare('DELETE FROM user WHERE user_id = UNHEX(?)');
//   $stmt->execute([$user_id]);
// }

// Delete Data from Database food_id
if (isset($_POST['delete_food'])){
  $delete_id = $_POST['delete_food'];
  $deletestmt = $pdo->prepare("DELETE FROM food WHERE fd_id = ?");
  $deletestmt->execute(['delete_id']);
  // alert message
  if ($deletestmt){
    echo "<script>alert('Data has been deleted successfully!')</script>";
    $_SESSION['success'] = "Data has been deleted successfully!";
    header("refresh:2; url=menu_management.php");
  }
}

// Fetch the menu items
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $menu_item = array(
    'fd_id' => $row['fd_id'],
    'fd_image' => $row['fd_image'],
    'fd_name' => $row['fd_name'],
    'fd_price' => $row['fd_price'],
    'cat_name' => $row['cat_name']
  );
  
  array_push($menu_items, $menu_item);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Management</title>
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<!-- Header -->
<?php require_once '../components/admin_header.php'; ?> 
  
  <!-- Add Menu Modal -->
  <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="add_menu.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="foodname" class="col-form-label">Food name :</label>
              <input type="text" required class="form-control" name="menuname">
            </div>
            <div class="mb-3">
              <label for="price" class="col-form-label">Price :</label>
              <input type="text" required class="form-control" name="price" pattern="\d*\.?\d+">
            </div>
            <div class="mb-3">
              
              <select class="form-select" aria-label=".form-select-lg example" name="category" required>
                <option value="" selected disabled>Category</option>
                <?php
                  $catsql = "SELECT * FROM `category`";
                  $catstmt = $pdo->query($catsql);
                  $cat = $catstmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($cat as $categories){
                    echo '<option value="' . $categories['cat_id'] . '">' . $categories['cat_name'] . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="img" class="col-form-label">Image :</label>
              <input type="file" required class="form-control" id="imgInput" name="img">
              <img loading="lazy" width="100%" id="previewImg" alt="">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <h1>Menu Management</h1>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal">Add Menu</button>
      </div>
    </div>
    <hr>
    
    
    <!-- Alert success or not -->
    <?php if(isset($_SESSION['success'])) {?>
      <div class="alert alert-success">
        <?php 
          echo $_SESSION['success']; 
          unset($_SESSION['success']);
        ?>
      </div>
    <?php } ?>
    <?php if(isset($_SESSION['error'])) {?>
      <div class="alert alert-danger">
        <?php 
          echo $_SESSION['error']; 
          unset($_SESSION['error']);
        ?>
      </div>
    <?php } ?>
  </div> 

  <!-- Menu Data (table by bootstrap 5) -->
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Food Image</th>
          <th scope="col">Food Name</th>
          <th scope="col">Price</th>
          <th scope="col">Category</th>
          <th scope="col">Action</th>
          <th scope="col"> </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menu_items as $item): ?>
          <tr>
            <td><?php echo $item['fd_id']; ?></td>
            <td><img src="<?php echo $item['fd_image']; ?>" alt="<?php echo $item['fd_name']; ?>" width="100px"></td>
            <td><?php echo $item['fd_name']; ?></td>
            <td><?php echo $item['fd_price']; ?></td>
            <td><?php echo $item['cat_name']; ?></td>
            <td><a href="edit_menu_item.php?id=<?php echo $item['fd_id']; ?>" class="btn btn-warning">Edit</a></td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="delete_food" value="<?php echo $item['fd_id']; ?>" />
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                <!-- <a href="?delete=<?php echo $item['fd_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a> -->
              </form>
            </td>          
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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