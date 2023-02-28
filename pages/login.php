<?php
session_start();
// Include the database connection file

if (isset($_SESSION['email'])) {
  // Unset all session variables
  $_SESSION = array();

  // Destroy the session
  session_destroy();
}

require_once "../components/connect.php";

// if (isset($_POST['submit'])) {
//   header("Location: home.php");
// }



if (isset($_POST['submit'])) {
  
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query database for user
  $stmt = $pdo->prepare("SELECT * FROM user WHERE us_email = :email AND us_password = :password");
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if user exists and password is correct
  if($user) {

    // binary to hex
    $user_id_binary = $user['user_id'];
    $user_id_hex = bin2hex($user_id_binary);
    
    
    // Set user ID in session
    $_SESSION['user_id'] = $user_id_hex;
    $_SESSION['us_fname'] = $user['us_fname'];
    $_SESSION['role_id'] = $user['role_id'];

    // echo $_SESSION['user_id'];

    // // set roles
    // // $roleID = $user['role_id'];
    // // $role = $_POST[$roleID];
    // // $stmt = $db->prepare("SELECT * FROM user WHERE us_email = :email AND us_password = :password");
    // // $stmt->bindParam(':email', $email);
    // // $stmt->bindParam(':password', $password);
    // // $stmt->execute();
    // // $user = $stmt->fetch();

    // Check if user is an admin
    if($_SESSION['role_id'] != 3) {
        // Redirect to admin page
        // echo "pass.";
        header("Location: /pizza-database-project/admin/admin.php");
        // exit;
    } else {
        // Redirect to home page
        header("Location: home.php");
        // exit;
    }
  } else {
      // Login failed, show error message
      echo "Invalid email or password.";
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
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

<?php require_once '../components/user_header.php'; ?>
  
    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4 bg-white rounded border border-success  p-4 shadow">
                <div class="row justify-content-center mb-4">
                    <h1 class="heading text-center">Login</h1>
                </div>
                <form method="post" action="">
                    <div class="mb-4">
                        <label for="email" class="form-label">Email </label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp">
                    </div>
                    <input type="submit" class="btn btn-success w-100" style="padding: 10px 50px;" name="submit" value="Login" >
                    <!-- <button type="submit" name="submit" class="btn btn-success w-100">Login</button> -->
                </form>
                <p class = "mb-0 text-center">Not registered yet? <a href="signup.php" class="text-decoration-none">Signup here</a></p>
            </div>
        </div>
    </div>

</body>

</html>