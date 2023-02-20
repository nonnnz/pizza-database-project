<?php
session_start();
// Include the database connection file
include '../components/connect.php';

if(isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM customer WHERE cus_email = :email AND cus_password = :password";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->execute();

  $row_count = $stmt->rowCount();

  if($row_count == 1) {
    $_SESSION['email'] = $email;
    header("Location: home.php");
  } else {
    $query = "SELECT * FROM employee WHERE emp_email = :email AND emp_password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $row_count = $stmt->rowCount();

    if($row_count == 1) {
      $_SESSION['email'] = $email;
      header("Location: ../admin/admin.php"); 
    } else {
      echo "Invalid login credentials";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="post" action="">
      <input type="email" name="email" required placeholder="Enter your email"><br><br>
      <input type="password" name="password" required placeholder="Enter your password"><br><br>
      <input type="submit" name="submit" value="Login">
    </form>
  </body>
</html>
