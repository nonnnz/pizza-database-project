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

   <!-- bootstrap  -->
   
</head>
<body>
   
<!-- header section starts  
php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">
    <div style="display: flex; justify-content: center;">
        <form method="post" action="">
            <fieldset name="register">
            <legend>Register</legend>
            <div class="form-group" style="text-align:center;" >
                <input type="text" name="fname" required placeholder="First name" class="box" maxlength="50">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="text" name="lname" required placeholder="Last name" class="box" maxlength="50">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="tel" name="phone" required placeholder="Phone number" class="box" maxlength="10">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="date" name="birthdate" required placeholder="Date of birth" class="box">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="radio" name="gender" value="male" required>
                <span>Male</span>
                <input type="radio" name="gender" value="female" required>
                <span>Female</span>
                <input type="radio" name="gender" value="none" required>
                <span>None</span>
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="email" name="email" required placeholder="Email address" class="box" maxlength="50">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="password" name="password" required placeholder="Password" class="box" maxlength="20">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="password" name="confirm_password" required placeholder="Confirm password" class="box" maxlength="20">
            </div>
            <div class="form-group" style="text-align:center;">
                <input type="checkbox" name="agree" required>
                <span>I have read and accepted terms & conditions and privacy statement of The Pizza Company</span>
                <br>
                <input type="checkbox" name="receive_info">
                <span>I agree to receive the information including other marketing activities from The Pizza Company<br>and affiliated companies. We will keep your data confidential. Learn more about privacy statement from<br>company’s website.</span>
            </div>
            <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center;">
                <input type="submit" name="submit" value="Register" class="button">
            </div>
            </fieldset>
        </form>
    </div>
</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>