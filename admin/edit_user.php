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



if(!isset($_GET["id"])) {
    header("Location: admin.php");
    exit;
}

$id = $_GET["id"];
// user WHERE user_id = UNHEX(?)'
$stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = UNHEX(:id)");
$stmt->bindValue(":id", $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user) {
    header("Location: admin.php");
    exit;
}
if(isset($_POST['submit'])) {
    // echo "test";
    // if(isset($_POST["update_customer"])) {
        $fname = $_POST["us_fname"];
        $lname = $_POST["us_lname"];
        $phone = $_POST["us_phone"];
        $birthdate = $_POST["us_birthdate"];
        $gender = $_POST["us_gender"];
        $email = $_POST["us_email"];
        $password = $_POST["us_password"];

        $stmt = $pdo->prepare("UPDATE user SET us_fname = :fname, us_lname = :lname, us_phone = :phone, us_birthdate = :birthdate, us_gender = :gender, us_email = :email, us_password = :password WHERE user_id = UNHEX(:id)");
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
				<label for="us_fname">First Name</label>
				<input type="text" name="us_fname" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="us_lname">Last Name</label>
				<input type="text" name="us_lname" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="us_phone">Phone</label>
				<input type="tel" name="us_phone" class="form-control" maxlength="10" required>
			</div>
			<div class="form-group">
				<label for="us_birthdate">Birthdate</label>
				<input type="date" name="us_birthdate" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="us_gender">Gender</label>
				<select name="us_gender" class="form-control" required>
					<option value="">Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="None">None</option>
				</select>
			</div>
			<div class="form-group">
				<label for="us_email">Email</label>
				<input type="email" name="us_email" class="form-control" maxlength="50" required>
			</div>
			<div class="form-group">
				<label for="us_password">Password</label>
				<input type="password" name="us_password" class="form-control" maxlength="20" required>
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
