<?php 

session_start();
require_once "../components/connect.php";

// first create pz_id and fd_id and insert to food, pizza_ingredient and pizza_sauece
// then redirect to nextadd_pizza.php
if(isset($_POST['add'])){
    $cat = 1; // Fixed category id for pizza
    $pzname = $_POST['pizzaname'];
    $pzsize = $_POST['pzsize'];
    $pzsauce = $_POST['pzsauce'];
    $crust = $_POST['pzcrust'];
    $dip = $_POST['pzdip'];
    $ing1 = $_POST['ing1'];

    if (isset($_POST['ing2'])) {
        $ing2 = $_POST['ing2'];
    } else {
        $ing2 = 0;
    }
    if (isset($_POST['ing3'])) {
        $ing3 = $_POST['ing3'];
    } else {
        $ing3 = 0;
    }

    $pzprice = $_POST['price'];

    $img = $_FILES['img'];

    $allow = array('jpg', 'jpeg', 'png');
    // separate name and file extension
    $extension = explode(".", $img['name']);
    // convert file extension to small
    $fileActExt = strtolower(end($extension));
    // upload to folder images
    $filePath = "../admin/" . $fileActExt;

    if (in_array($fileActExt, $allow)) {
        $fileNew = $img['name'];
        $filePath = "../admin/" . $fileNew;
        // check size
        if ($img['size'] > 0 && $img['error'] == 0){
            //upload
            if (move_uploaded_file($img['tmp_name'], $filePath)){
                // insert table food (fd_id)
                $fdsql = $pdo->prepare("INSERT INTO food (fd_name, cat_id, fd_price, fd_image) VALUES (:fd_name, :cat_id, :fd_price, :fd_img)");
                $fdsql->bindParam(':fd_name', $pzname);
                $fdsql->bindParam(':cat_id', $cat);
                $fdsql->bindParam(':fd_price', $pzprice);
                $fdsql->bindParam(':fd_img', $fileNew);
                $fdsql->execute();
                // use the ID of the last inserted row
                $fdid = $pdo->lastInsertId();
                
                // Create pz_id
                $instpz = "INSERT INTO pizza (pz_name) VALUES (:pzname)";
                $stmtpz = $pdo->prepare($instpz);
                $stmtpz->bindParam(':pzname', $pzname);
                $stmtpz->execute();
                // use the ID of the last inserted row
                $pzid = $pdo->lastInsertId();
                // echo $pzid;
                // echo $pzsauce;
                // echo $ing1;
                // echo $ing2;
                // echo $ing3;

                // Insert to pizza_sauce by using pz_id that just created
                $instsauce = "INSERT INTO pizza_sauce (pz_id, sauce_id) VALUES (:pzid, :pzsauce)";
                $stmtsauce = $pdo->prepare($instsauce);
                $stmtsauce->bindParam(':pzid', $pzid);
                $stmtsauce->bindParam(':pzsauce', $pzsauce);
                $stmtsauce->execute();

                // Insert to pizza_ingredient
                $insting1 = "INSERT INTO pizza_ingredient (pz_id, ing_id) VALUES (:pzid, :ing1)";
                $stmting1 = $pdo->prepare($insting1);
                $stmting1->bindParam(':pzid', $pzid);
                $stmting1->bindParam(':ing1', $ing1);
                $stmting1->execute();

                if ($ing2 != 0) {
                    $insting2 = "INSERT INTO pizza_ingredient (pz_id, ing_id) VALUES (:pzid, :ing2)";
                    $stmting2 = $pdo->prepare($insting2);
                    $stmting2->bindParam(':pzid', $pzid);
                    $stmting2->bindParam(':ing2', $ing2);
                    $stmting2->execute();
                }

                if ($ing3 != 0) {
                    $insting3 = "INSERT INTO pizza_ingredient (pz_id, ing_id) VALUES (:pzid, :ing3)";
                    $stmting3 = $pdo->prepare($insting3);
                    $stmting3->bindParam(':pzid', $pzid);
                    $stmting3->bindParam(':ing3', $ing3);
                    $stmting3->execute();
                }

                // Insert to pizza_detail
                $instpzdetail = "INSERT INTO pizza_detail (pz_id, size_id, crust_id, dip_id, fd_id) VALUES (:pzid, :pzsize, :crust, :dip, :fdid)";
                $stmtpzdetail = $pdo->prepare($instpzdetail);
                $stmtpzdetail->bindParam(':pzid', $pzid);
                $stmtpzdetail->bindParam(':pzsize', $pzsize);
                $stmtpzdetail->bindParam(':crust', $crust);
                $stmtpzdetail->bindParam(':dip', $dip);
                $stmtpzdetail->bindParam(':fdid', $fdid);
                $stmtpzdetail->execute();
            } 
        }
    }

    header("Location: menu_management.php");
    exit();
}

// Fetch Size
$sizesql = "SELECT * FROM size";
$sizestmt = $pdo->query($sizesql);
$size = $sizestmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Dipping
$dipsql = "SELECT * FROM dipping_sauce";
$dipstmt = $pdo->query($dipsql);
$dip = $dipstmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Crust
$crustsql = "SELECT * FROM crust";
$cruststmt = $pdo->query($crustsql);
$crust = $cruststmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Sauce
$saucesql = "SELECT * FROM sauce";
$saucestmt = $pdo->query($saucesql);
$sauce = $saucestmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Ingredient
$ingsql = "SELECT * FROM ingredient";
$ingstmt = $pdo->query($ingsql);
$ing = $ingstmt->fetchAll(PDO::FETCH_ASSOC);



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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pizza</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Custom fonts for template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom styles for template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                            <h1 class="h3 mb-0 text-gray-800">Add Pizza</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Form Content -->
                                <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="pizzaname" class="col-form-label">Pizza name :</label>
                                    <input type="text" value="" required class="form-control" name="pizzaname">
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="pzsauce" required>
                                    <option value="" selected disabled>Sauce</option>
                                    <?php foreach ($sauce as $sa):
                                        echo '<option value="' . $sa['sauce_id'] . '">' . $sa['sauce_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="pzsize" required>
                                    <option value="" selected disabled>Size</option>
                                    <?php foreach ($size as $s):
                                        echo '<option value="' . $s['size_id'] . '">' . $s['size_name'] . '</option>';
                                    endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="pzcrust" required>
                                    <option value="" selected disabled>Crust</option>
                                    <?php foreach ($crust as $c):
                                        echo '<option value="' . $c['crust_id'] . '">' . $c['crust_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="pzdip" required>
                                    <option value="" selected disabled>Dipping</option>
                                    <?php foreach ($dip as $d):
                                        echo '<option value="' . $d['dip_id'] . '">' . $d['dip_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="ing" class="col-form-label">Ingredient :</label>
                                    <select class="form-select" aria-label=".form-select-lg example" name="ing1" required>
                                    <option value="" selected disabled>Ingredient 1</option>
                                    <?php foreach ($ing as $i):
                                        echo '<option value="' . $i['ing_id'] . '">' . $i['ing_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="ing2" >
                                    <option value="" selected disabled>Ingredient 2</option>
                                    <?php foreach ($ing as $i):
                                        echo '<option value="' . $i['ing_id'] . '">' . $i['ing_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" aria-label=".form-select-lg example" name="ing3" >
                                    <option value="" selected disabled>Ingredient 3</option>
                                    <?php foreach ($ing as $i):
                                        echo '<option value="' . $i['ing_id'] . '">' . $i['ing_name'] . '</option>';
                                    endforeach ; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="col-form-label">Price :</label>
                                    <input type="text" value="" required class="form-control" name="price" pattern="\d*\.?\d+">
                                </div>
                                <div class="mb-3">
                                    <label for="img" class="col-form-label">Image :</label>
                                    <input type="file" required class="form-control" id="imgInput" name="img">
                                    <img loading="lazy" width="100%" id="previewImg" alt="">
                                </div>

                                <div class="modal-footer">
                                    <a class="btn btn-secondary" href="admin.php">Back</a>
                                    <button type="submit" name="add" class="btn btn-success">Submit</button>
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