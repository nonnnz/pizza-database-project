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


// Handle deleting a user
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['delete_user'];
    // echo $_POST['delete_user'];
    $stmt = $pdo->prepare('DELETE FROM user WHERE user_id = UNHEX(?)');
    $stmt->execute([$user_id]);
}

// Fetch all users from database
$stmt = $pdo->prepare('SELECT * FROM user WHERE role_id = 3');
$stmt->execute();
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
</head>
</head>
<body>

<?php require_once '../components/admin_header.php'; ?>

    <div class="container">
        <h1>Admin Page</h1>
        <p>Welcome, admin <?php echo $name; ?>!</p>
        <!-- <a href="../pages/login.php" class="button">Logout</a> -->

        <h2>Dashboard</h2>
 
    </div>
</body>
</html>
