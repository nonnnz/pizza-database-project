<?php
include '../components/connect.php';

// Check if user is logged in and is an admin
session_start();
if (!isset($_SESSION['email']) || $_SESSION['type'] != 'admin') {
    header('Location: login.php');
    exit;
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
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Page</h1>
        <p>Welcome, admin!</p>
        <a href="logout.php" class="button">Logout</a>

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
