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
} else {
    // User is not an admin, redirect to home page
    header("Location: ../pages/login.php");
    exit();
}


if(!isset($_GET["id"])) {
    header("Location: admin.php");
    exit;
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM customer WHERE cus_id = :id");
$stmt->bindValue(":id", $id);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$customer) {
    header("Location: admin.php");
    exit;
}
if(isset($_POST['submit'])) {
    // echo "test";
    // if(isset($_POST["update_customer"])) {
        $fname = $_POST["cus_fname"];
        $lname = $_POST["cus_lname"];
        $phone = $_POST["cus_phone"];
        $birthdate = $_POST["cus_birthdate"];
        $gender = $_POST["cus_gender"];
        $email = $_POST["cus_email"];
        $password = $_POST["cus_password"];

        $stmt = $pdo->prepare("UPDATE customer SET cus_fname = :fname, cus_lname = :lname, cus_phone = :phone, cus_birthdate = :birthdate, cus_gender = :gender, cus_email = :email, cus_password = :password WHERE cus_id = :id");
        $stmt->bindValue(":fname", $fname);
        $stmt->bindValue(":lname", $lname);
        $stmt->bindValue(":phone", $phone);
        $stmt->bindValue(":birthdate", $birthdate);
        $stmt->bindValue(":gender", $gender);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        header("Location: admin.php");
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>
</head>
<body>
	<div class="container">
		<h1 class="text-center mt-5">Edit Customer</h1>
		<hr>
		<form method="POST" action="">
			<div class="form-group">
				<label for="cus_fname">First Name</label>
				<input type="text" name="cus_fname" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="cus_lname">Last Name</label>
				<input type="text" name="cus_lname" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="cus_phone">Phone</label>
				<input type="tel" name="cus_phone" class="form-control" maxlength="10" required>
			</div>
			<div class="form-group">
				<label for="cus_birthdate">Birthdate</label>
				<input type="date" name="cus_birthdate" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="cus_gender">Gender</label>
				<select name="cus_gender" class="form-control" required>
					<option value="">Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="None">None</option>
				</select>
			</div>
			<div class="form-group">
				<label for="cus_email">Email</label>
				<input type="email" name="cus_email" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="cus_password">Password</label>
				<input type="password" name="cus_password" class="form-control" maxlength="20" required>
			</div>
			<div class="form-group">
				<!-- <button type="submit" class="btn btn-success">Update Customer</button> -->
                <input type="submit" name="submit" value="Update Customer" class="btn btn-success">
				<a href="admin.php" class="btn btn-primary">Back</a>
			</div>
		</form>
	</div>
</body>
</html>
