<?php
session_start();

require_once "../components/connect.php";

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header("Location: ../pages/login.php");
    exit();
}

// Check if user is logged in and is an admin
if (isset($_SESSION['email']) && strpos($_SESSION['email'], "@admin.com")) {
    // User is logged in and is an admin
    // Display the admin content here
    $name = $_SESSION["fname"];
} else {
    // User is not an admin, redirect to home page
    header("Location: ../pages/login.php");
    exit();
}


// Handle deleting a customer
if (isset($_POST['delete_customer'])) {
    $cus_id = $_POST['delete_customer'];
    $stmt = $pdo->prepare('DELETE FROM customer WHERE cus_id = ?');
    $stmt->execute([$cus_id]);
}

// Fetch all customers from database
$stmt = $pdo->prepare('SELECT * FROM customer');
$stmt->execute();
$customers = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
</head>
</head>
<body>
    <div class="container">
        <h1>Admin Page</h1>
        <p>Welcome, admin <?php echo $name; ?>!</p>
        <a href="../pages/login.php" class="button">Logout</a>

        <h2>Customers</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer['cus_id'] ?></td>
                        <td><?php echo $customer['cus_fname'] ?></td>
                        <td><?php echo $customer['cus_lname'] ?></td>
                        <td><?php echo $customer['cus_phone'] ?></td>
                        <td><?php echo $customer['cus_email'] ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="delete_customer" value="<?php echo $customer['cus_id'] ?>">
                                <button type="submit" class="button">Delete</button>
                            </form>
                            <a href="edit_customer.php?id=<?php echo $customer['cus_id'] ?>" class="button">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
