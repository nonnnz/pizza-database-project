<?php

include($_SERVER['DOCUMENT_ROOT'] . '/pizza-database-project/components/connect.php');

/* session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};
*/

if(isset($_POST['submit'])){

    $fname = $_POST['fname'];
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = $_POST['lname'];
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $birthdate = $_POST['birthdate'];
    $birthdate = filter_var($birthdate, FILTER_SANITIZE_STRING);
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $confirm_password = sha1($_POST['confirm_password']);
    $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `customer` WHERE cus_email = ? OR cus_phone = ?");
    $select_user->execute([$email, $phone]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'email or number already exists!';
    }else{
        if($password != $confirm_password){
            $message[] = 'confirm password not matched!';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `customer` (cus_fname, cus_lname, cus_phone, cus_birthdate, cus_gender, cus_email, cus_password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_user->execute([$fname, $lname, $phone, $birthdate, $gender, $email, $password]);
            $select_user = $conn->prepare("SELECT * FROM `customer` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $password]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
            header('Location: home.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>

    <!-- bootstrap  -->

</head>
<body>

<!-- header section starts  
php include 'components/user_header.php'; ?> -->
<!-- header section ends -->

<section class="form-container">
    <div style="display: flex; justify-content: center;">
        <form method="post" action="">
            <fieldset name="register">
            <legend>Register</legend>
            <hr>

            <!-- F/L name -->
            <label for="firstname" class="form-label">Name</label>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="First name" aria-label="First name">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
                </div>
            </div>
            
            <div class="mb-3"> <!-- Phone number -->
                <label for="phonenumber" class="form-label">Phone number</label>
                <input type="text" class="form-control" name="tel" placeholder="+66">
            </div>

            <div class="mb-3"> <!-- Date of birth -->
                <label for="startDate">Date of birthday</label>
                <input id="startDate" class="form-control" type="date" />
            </div>

            <!-- Gender -->
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">Female</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">None</label>
            </div>

            <div class="mb-3"> <!-- Email -->
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3"> <!-- Password -->
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3"> <!-- Confirm Password -->
                <label for="confirm password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="c_password">
            </div>
            
            <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center;">
                <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
            </div>
            
            </fieldset>
        </form>
    </div>
</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>