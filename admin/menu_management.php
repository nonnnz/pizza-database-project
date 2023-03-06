<?php

session_start();
// Include the database connection file
require_once "../components/connect.php";

// array
$menu_items = array();

// Query the database for the menu items
$stmt = $pdo->query("SELECT f.fd_id, f.fd_des, f.fd_image, p.pz_name, p.pz_des, p.pz_price, c.cat_name, s.size_name, s.size_price, cr.crust_name, cr.crust_price, d.dip_name, d.dip_price, sa.sauce_name 
                     FROM food f 
                     INNER JOIN pizza p ON f.pz_id = p.pz_id 
                     INNER JOIN category c ON p.cat_id = c.cat_id 
                     INNER JOIN size s ON p.size_id = s.size_id 
                     INNER JOIN crust cr ON p.crust_id = cr.crust_id 
                     INNER JOIN dipping_sauce d ON p.dip_id = d.dip_id 
                     INNER JOIN sauce sa ON p.sauce_id = sa.sauce_id");

$stmt->execute();

// Delete Data
if (isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $deletestmt = $conn->query("DELETE FROM `` WHERE  = $delete_id");
  $deletestmt->execute();
  if ($deletestmt){
    echo "<script>alert('Data has been deleted successfully!')</script>";
    $_SESSION['success'] = "Data has been deleted successfully!";
    header("refresh:1; url=menu_management.php");
  }
}

// Fetch the query results and build an array of menu items
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $menu_item = array(
        'fd_id' => $row['fd_id'],
        'fd_des' => $row['fd_des'],
        'fd_image' => $row['fd_image'],
        'pz_name' => $row['pz_name'],
        'pz_des' => $row['pz_des'],
        'pz_price' => $row['pz_price'],
        'cat_name' => $row['cat_name'],
        'size_name' => $row['size_name'],
        'size_price' => $row['size_price'],
        'crust_name' => $row['crust_name'],
        'crust_price' => $row['crust_price'],
        'dip_name' => $row['dip_name'],
        'dip_price' => $row['dip_price'],
        'sauce_name' => $row['sauce_name']
    );

    array_push($menu_items, $menu_item);
}
// Display the menu items in a table
// echo "<table>";
// echo "<tr><th>Food ID</th><th>Food Description</th><th>Pizza Name</th><th>Pizza Description</th><th>Pizza Price</th><th>Category</th><th>Size</th><th>Size Price</th><th>Crust</th><th>Crust Price</th><th>Dipping Sauce</th><th>Dipping Sauce Price</th><th>Sauce</th></tr>";
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     echo "<tr>";
//     echo "<td>" . $row['fd_id'] . "</td>";
//     echo "<td>" . $row['fd_des'] . "</td>";
//     echo "<td>" . $row['pz_name'] . "</td>";
//     echo "<td>" . $row['pz_des'] . "</td>";
//     echo "<td>" . $row['pz_price'] . "</td>";
//     echo "<td>" . $row['cat_name'] . "</td>";
//     echo "<td>" . $row['size_name'] . "</td>";
//     echo "<td>" . $row['size_price'] . "</td>";
//     echo "<td>" . $row['crust_name'] . "</td>";
//     echo "<td>" . $row['crust_price'] . "</td>";
//     echo "<td>" . $row['dip_name'] . "</td>";
//     echo "<td>" . $row['dip_price'] . "</td>";
//     echo "<td>" . $row['sauce_name'] . "</td>";
//     echo "</tr>";
// }
// echo "</table>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Management</title>
  <!-- CSS -->
  <!-- <link rel="stylesheet" type="text/css" href="../css/style.css"> -->
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<!-- <?php require_once '../components/admin_header.php'; ?> -->

  <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="edit_menu_item.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="menuname" class="col-form-label">Food name :</label>
              <input type="text" required class="form-control" name="menuname">
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
                <!-- <option value="2">Appetizer</option>
                <option value="3">Chicken</option>
                <option value="4">Pasta</option>
                <option value="5">Salad &amp; Steak</option>
                <option value="6">Drinks &amp; Desserts</option> -->
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
    <!-- <?php if(isset($_SESSION['success'])) {?>
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
  </div> -->

  <!-- Menu Data (table by bootstrap 5) -->
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Food Name</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">Category</th>
          <th scope="col">Size</th>
          <th scope="col">Crust</th>
          <th scope="col">Dipping Sauce</th>
          <th scope="col">Sauce</th>
          <th scope="col">Food Image</th>
          <th scope="col">Action</th>
          <th scope="col"> </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menu_items as $item): ?>
          <tr>
            <td><?php echo $item['pz_name']; ?></td>
            <td><?php echo $item['pz_des']; ?></td>
            <td><?php echo $item['pz_price']; ?></td>
            <td><?php echo $item['cat_name']; ?></td>
            <td><?php echo $item['size_name']; ?></td>
            <td><?php echo $item['crust_name']; ?></td>
            <td><?php echo $item['dip_name']; ?></td>
            <td><?php echo $item['sauce_name']; ?></td>
            <td><img src="<?php echo $item['fd_image']; ?>" alt="<?php echo $item['pz_name']; ?>" width="100px"></td>
            <td><a href="edit_menu_item.php?id=<?php echo $item['fd_id']; ?>" class="btn btn-warning">Edit</a></td>
            <td><a href="#" <?php ?> class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- <style>
  table {
    border-collapse: separate;
    border-spacing: 45px;
  }
  </style>

  <div class="container" >
    <table>
      <thead>
        <tr>
          <th>Food Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Category</th>
          <th>Size</th>
          <th>Crust</th>
          <th>Dipping Sauce</th>
          <th>Sauce</th>
          <th>Food Image</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menu_items as $item): ?>
          <tr>
            <td><?php echo $item['pz_name']; ?></td>
            <td><?php echo $item['pz_des']; ?></td>
            <td><?php echo $item['pz_price']; ?></td>
            <td><?php echo $item['cat_name']; ?></td>
            <td><?php echo $item['size_name']; ?></td>
            <td><?php echo $item['crust_name']; ?></td>
            <td><?php echo $item['dip_name']; ?></td>
            <td><?php echo $item['sauce_name']; ?></td>
            <td><img src="<?php echo $item['fd_image']; ?>" alt="<?php echo $item['pz_name']; ?>" width="100px"></td>
            <td><a href="edit_menu_item.php?id=<?php echo $item['fd_id']; ?>">Edit</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div> -->

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