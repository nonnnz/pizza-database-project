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

// Check if user is logged in and is an admin
if ($_SESSION['role_id'] != 3) {
  // User is logged in and is an admin
  // Display the admin content here
  $name = $_SESSION["us_fname"];
  } else {
  // User is not an admin, redirect to home page
  header("Location: ../pages/login.php");
  exit();
  }

// Fetch all users from database
$userstmt = $pdo->prepare('SELECT * FROM user WHERE role_id = 3');
$userstmt->execute();
$users = $userstmt->fetchAll();


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
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- Custom fonts for template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Custom styles for template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    #previewImg{
      display: block;
      margin: auto;
    }
  </style>

</head>
<body>
  <!-- Page Wrapper -->
  <div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../admin/admin.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">112 Pizza </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="../admin/admin.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Add Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Menu :</h6>
                <a class="collapse-item" href="../admin/add_pizza.php">Add Pizza</a>
                <a class="collapse-item" href="../admin/add_menu.php">Add Menu</a>
                <a class="collapse-item" href="../admin/add_cat.php">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Management</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User :</h6>
                <a class="collapse-item" href="../admin/user_management.php">User Management</a>
                <a class="collapse-item" href="../admin/admin_management.php">Admin Management</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Order :</h6>
                <a class="collapse-item" href="#">Order Management</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Menu :</h6>
                <a class="collapse-item" href="../admin/menu_management.php">Menu Management</a>
                <a class="collapse-item" href="../admin/cat_management.php">Category Management</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Screens:</h6>
                <a class="collapse-item" href="../pages/logout.php">Logout</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                    
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name; ?></span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                        </a>
                    </div>
                </li>

            </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="container">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Edit Menu</h1>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Form Content -->
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
                            <select class="form-select" aria-label=".form-select-lg example" name="category" required>
                              <option value="" selected disabled><?php echo $item['cat_name']; ?></option>
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

                </div>
            </div>
        </div>

    </div>
    <!-- End of Main Content -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Logout" if you are ready to end your current session.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="../pages/logout.php">Logout</a>
        </div>
    </div>
</div>
</div>
  
    

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

  <!-- bootstrap.bundle.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>
</html>