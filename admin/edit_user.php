<?php
session_start();

require_once "../components/connect.php";

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: ../pages/login.php");
    exit();
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

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = :id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(!isset($_GET["id"])) {
    header("Location: user_management.php");
    exit;
}

if(!$user) {
    header("Location: user_management.php");
    exit;
}

if(isset($_POST['edit'])) {
    // echo "test";
    // if(isset($_POST["update_customer"])) {
        $fname = $_POST["us_fname"];
        $lname = $_POST["us_lname"];
        $phone = $_POST["us_phone"];
        $birthdate = $_POST["us_birthdate"];
        $gender = $_POST["us_gender"];
        $email = $_POST["us_email"];
        $password = $_POST["us_password"];

        $stmt = $pdo->prepare("UPDATE user SET us_fname = :fname, us_lname = :lname, us_phone = :phone, us_birthdate = :birthdate, us_gender = :gender, us_email = :email, us_password = :password WHERE user_id = :id");
        $stmt->bindValue(":fname", $fname);
        $stmt->bindValue(":lname", $lname);
        $stmt->bindValue(":phone", $phone);
        $stmt->bindValue(":birthdate", $birthdate);
        $stmt->bindValue(":gender", $gender);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt){
            $_SESSION['success'] = "Menu has been edited Successfully";
            header("location: user_management.php");
        } else {
            $_SESSION['error'] = "Menu has not been edited Successfully";
            header("location: user_management.php");
        }

        header("Location: user_management.php");
        exit;
    // }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Customer</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                        <h6 class="collapse-header">Custom Menu:</h6>
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
                            <h1 class="h3 mb-0 text-gray-800">Edit Customer</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Form Content -->
                                <form method="POST" action="">
									<div class="form-group">
										<label for="us_fname">First Name</label>
										<input type="text" value="<?= $user['us_fname']; ?>" name="us_fname" class="form-control" maxlength="50" required>
									</div>
									<div class="form-group">
										<label for="us_lname">Last Name</label>
										<input type="text" value="<?= $user['us_lname']; ?>" name="us_lname" class="form-control" maxlength="50" required>
									</div>
									<div class="form-group">
										<label for="us_phone">Phone</label>
										<input type="tel" value="<?= $user['us_phone']; ?>" name="us_phone" class="form-control" maxlength="10" required>
									</div>
									<div class="form-group">
										<label for="us_birthdate">Birthdate</label>
										<input type="date" value="<?= $user['us_birthdate']; ?>" name="us_birthdate" class="form-control" min="1923-01-01" max="<?php echo date("Y-m-d",time()) ?>" required>
									</div>
									<div class="form-group">
										<label for="us_gender">Gender</label>
										<select name="us_gender" class="form-control" required>
											<option selected disabled value=""><?= $user['us_gender']; ?></option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="None">None</option>
										</select>
									</div>
									<div class="form-group">
										<label for="us_email">Email</label>
										<input type="email" value="<?= $user['us_email']; ?>" name="us_email" class="form-control" maxlength="50" required>
									</div>
									<div class="form-group">
										<label for="us_password">Password</label>
										<input type="password" value="<?= $user['us_password']; ?>" name="us_password" class="form-control" maxlength="20" required>
									</div>
									<div class="form-group">
										<!-- <button type="submit" class="btn btn-success">Update Customer</button> -->
										<br>
										<a href="user_management.php" class="btn btn-primary">Back</a>
										<input type="submit" name="edit" value="Update Customer" class="btn btn-success">
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
