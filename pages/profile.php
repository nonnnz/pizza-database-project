<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
    $id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_id = :id");
    $stmt->bindValue(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} else {
    header('Location: login.php');
    exit;
}

if(isset($_POST['submit'])) {
    // echo $_POST["us_email"] . $_POST["gender"];
    $id = $_SESSION['user_id'];
    // echo $id;
    $fname = $_POST["us_fname"];
    $lname = $_POST["us_lname"];
    $phone = $_POST["us_phone"];
    $birthdate = $_POST["us_birthdate"];
    $gender = $_POST["gender"];
    // echo $gender;
    $email = $user["us_email"];
    $stmt = $pdo->prepare("UPDATE user SET us_fname = :fname, us_lname = :lname, us_phone = :phone, us_birthdate = :birthdate, us_gender = :gender WHERE user_id = :id");
    $stmt->bindValue(":fname", $fname);
    $stmt->bindValue(":lname", $lname);
    $stmt->bindValue(":phone", $phone);
    $stmt->bindValue(":birthdate", $birthdate);
    $stmt->bindValue(":gender", $gender);
    $stmt->bindValue(":id", $id);
    $stmt->execute();


    if(isset($_POST["us_password"]) && $_POST["us_password"] != "") {
        if(!isset($_POST["Repeat_password"]) || $_POST["us_password"] != $_POST["Repeat_password"]) {
            $message = 'Repeat password not matched!';
            // phpAlert($message);
            echo "<script>
            alert('". $message ."');
            window.location.href='profile.php';
            </script>";
            // header("Location: profile.php");
        }
        $password = $_POST["us_password"];
        $stmt = $pdo->prepare("UPDATE user SET us_email = :email, us_password = :password WHERE user_id = :id");
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $message = 'Success!';
        echo "<script>
            alert('". $message ."');
            window.location.href='profile.php';
        </script>";
        // echo "done";
    } else {
        $message = 'Success!';
        echo "<script>
            alert('". $message ."');
            window.location.href='profile.php';
        </script>";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

     <!-- custom css file link  -->
     <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

<?php require_once '../components/user_header_new.php'; ?>


        <!-- My Profile -->
    <div class="row" style="--bs-gutter-x: 0rem;" >
        <div class="col">
            <div class="promote-tab text-center"style="display: flex; justify-content: center; align-items:center; min-height:20vh;">
                <a class="item-name" href="profile.php" style="text-decoration: none;">
                    <div class="item-icon hw" style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/my-profile_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name" "><font color ="#009966">My Profile</font></div>
                    </div>
                </a>
            
                <!-- Tax Information -->
                <!-- <a class="item-name" href="tax_information.php"style="text-decoration: none;">
                        <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px;"class="btn btn-1" > <img src="https://www.1112.com/images/tax-information_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name"><font color ="#009966">Tax Information</font></div>
                    </div>
                </a> -->

                <!-- >Address Book -->
                <a class="item-name" href="address-book.php"style="text-decoration: none;">
                    <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/address-book_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name"><font color ="#009966">Address Book</font></div>
                    </div>
                </a>

                <!-- >Credit Card -->
                <a class="item-name" href="credit-card.php"style="text-decoration: none;">
                    <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/credit-card_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name"><font color ="#009966">Credit Card</font></div>
                    </div>
                </a>
                    
                <!-- >Pizza Tracker -->
                <a class="item-name" href="tracker.php"style="text-decoration: none;">
                    <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/Tracker_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name"><font color ="#009966">Pizza Tracker</font></div>
                    </div>
                </a>
            </div>
        </div>
    </div>




        
    <div style="display: flex; justify-content: center; align-items:center; min-height:15vh; ">
        <h2 class="text-center">MY PROFILE</h2>
    </div>

<form method="POST" action="" autocomplete="off">
    <!--MY PROFILE --> 
    <section class="form-container ">
        <div style="display: flex; justify-content: center; align-items: center; min-height: 30vh; ">
            <div style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
                <fieldset name="MY PROFILE">


                <!-- F/L name --> 
                <div class="row ">
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                        <img src="https://1112.com/images/form/name_form.svg" style="padding: .75em; ">
                            <div class="col">
                                <input type="text" value="<?= $user['us_fname']; ?>" name="us_fname" class="form-control" maxlength="50" style = " margin:auto;width:95%" required>
                            </div>
                            <div class="col ">
                                <input type="text" value="<?= $user['us_lname']; ?>" name="us_lname" class="form-control" maxlength="50" style = " margin:auto;width:95%" required>
                            </div>
                    </div>
                </div>

                <!-- Phone number \\ Date of birth  -->

                <div class="row ">
                    <div class="form-icon" style="display: flex; align-items: center; justify-content: space-between;padding-top:1.5rem;">
                        <img src="https://1112.com/images/form/phone_form.svg" style ="padding: 1.2rem; margin:auto;">
                            <div class="col">
                                <input type="tel" value="<?= $user['us_phone']; ?>" name="us_phone" class="form-control" maxlength="10" style = " width:105%" required> 
                            </div>

                        <img src="https://1112.com/images/form/birthday_form.svg" style ="padding-left: 2.7rem; margin:auto;" >
                            <div class="col ">
                            <input type="date" value="<?= $user['us_birthdate']; ?>" name="us_birthdate" class="form-control" min="1923-01-01" max="<?php echo date("Y-m-d",time()) ?>" style = " margin:auto; width:95%;" required>
                            </div>
                    </div>
                </div>

                <!-- Gender -->
                <div class="form-gender" style="display: flex; align-items: start; justify-content: start;padding-top:2rem;">
                    <div class="form-icon">
                        <img class="gender_form" src="https://1112.com/images/form/gender_form.svg" style = "padding-left: .5em;  margin:auto;">
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="" type="radio" name="gender" id="inlineRadio1" value="Male" required <?php if($user['us_gender'] == "Male") echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                        
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="" type="radio" name="gender" id="inlineRadio2" value="Female" required <?php if($user['us_gender'] == "Female") echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio1">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="" type="radio" name="gender" id="inlineRadio3" value="None" required <?php if($user['us_gender'] == "None") echo "checked" ?>>
                        <label class="form-check-label" for="inlineRadio1">None</label>
                    </div>
                </div>  
                



                <!-- F/L name -->
                </fieldset>
            </div>
        </div>
    </section> 


    <div style="display: flex; justify-content: center; align-items:center; min-height:20vh; ">
        <h2 class="text-center">RESET PASSWORD</h2>
    </div>


    <!--RESET PASSWORD --> 
    <section class="form-container ">
        <div style="display: flex; justify-content: center; align-items: center; min-height: 10vh; padding-bottom: 5rem  ">
            <div style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
                <fieldset name="RESET PASSWORD">

                <!--Email -->
                <div class="mb-3"> 
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between; " >
                        <img src="https://www.1112.com/images/form/mail_form.svg" style="padding: .75em; ">
                            <div style="width: 100%;">
                                <p class="form-control" style="border:0px;"><?= $user['us_email']; ?></p>
                                <!-- <input type="email" class="form-control" id="us_email" placeholder="Email" name="us_email" value="<?= $user['us_email']; ?>" readonly>  -->
                            </div>
                    </div>
                </div>
                
                <!--Password -->
                <div class="mb-3" "> 
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                        <img src="https://1112.com/images/form/password_form.svg" style="padding: .75em;  ">
                        <div style="width: 100%;">
                            <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="New Password (6-15 characters)" name="us_password" maxlength="20" autocomplete="off">
                            <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="Repeat New Password" name="Repeat_password" maxlength="20" autocomplete="off" >
                        </div>
                        
                    </div>
                </div>
                
                </fieldset>
            </div>
        </div>
    </section> 

    <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center; ">
        <!-- <button type="submit" name="submit" class="btn btn-primary">Register</button> -->
        
            <input type="submit" class="btn btn-success " style="padding: 10px 50px; margin-bottom :3rem " name="submit" value="Save Changes" >
    
    </div>
</form>



<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>