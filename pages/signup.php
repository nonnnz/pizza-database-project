<?php

session_start();

require_once "../components/connect.php";

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

// check if the user is logged in
// sent to home
if(isset($_SESSION['user_id'])){
    header('Location: home.php');
    // $name = $_SESSION["us_fname"];
}

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};



if(isset($_POST['submit'])){

    $fname = $_POST['fname'];
    $fname = filter_var($fname);
    $lname = $_POST['lname'];
    $lname = filter_var($lname);
    $phone = $_POST['phone'];
    $phone = filter_var($phone);
    $birthdate = $_POST['birthdate'];
    $birthdate = filter_var($birthdate);
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $email = filter_var($email);
    $password = ($_POST['password']);
    $password = filter_var($password);
    $confirm_password = ($_POST['confirm_password']);
    $confirm_password = filter_var($confirm_password);

    $user_id = time() . mt_rand(1000000000, 9999999999);
    echo $user_id;

    $select_user = $pdo->prepare("SELECT * FROM `user` WHERE us_email = ? OR us_phone = ?");
    $select_user->execute([$email, $phone]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message = 'email or number already exists!';
        phpAlert($message);
    }else{
        if($password != $confirm_password){
            $message = 'confirm password not matched!';
            phpAlert($message);
        }else{
            $insert_user = $pdo->prepare("INSERT INTO `user` (user_id, us_fname, us_lname, us_phone, us_birthdate, us_gender, us_email, us_password, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_user->execute([$user_id ,$fname, $lname, $phone, $birthdate, $gender, $email, $password, 3]);
            // $select_user = $pdo->prepare("SELECT * FROM `customer` WHERE cus_email = ? AND cus_password = ?");
            // $select_user->execute([$email, $password]);
            // $row = $select_user->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

<?php require_once '../components/user_header_new.php'; ?>
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items: center; ">
        <form method="post" action="" style="border:1px solid black; padding: 3rem; border-radius : 1rem ; border-color: green" class="p-4 shadow">
            <fieldset name="register">
            <h2 class="text-center">Register</h2>
            <hr>

            <!-- F/L name -->
            
            <div class="row g-3">
                <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                        <img src="https://1112.com/images/form/name_form.svg" style="padding: .75em; ">
                        <div style="width: 45em;">
                            <input type="text" name="fname" class="form-control" style="margin-bottom :1rem" placeholder="First name" aria-label="First name" maxlength="50" required >
                            <input type="text" name="lname"class="form-control" style="margin-bottom :1rem" placeholder="Last name" aria-label="Last name" maxlength="50" required >
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="mb-3"> <!-- Phone number -->
                <div class="form-icon" style="display: flex; align-items: center; justify-content: space-between;" >
                    <img src="https://1112.com/images/form/phone_form.svg" style ="padding: .75em; margin:auto;">
                    <div style="width: 45em;">
                        <input type="tel" class="form-control"  pattern="\d+" name="phone" placeholder="+66" maxlength="10" required >
                    </div>
                </div>
            </div>
            
            <div class="mb-3"> <!-- Date of birth limit 100 y-->
                <div class="form-icon" style="display: flex; align-items: center; justify-content: center;" >
                    <img src="https://1112.com/images/form/birthday_form.svg" style ="padding: .5em; " >
                    <div style="width: 45em;">
                        <input id="startDate" name="birthdate" class="form-control" type="date" min="1923-01-01" max="<?php echo date("Y-m-d",time()) ?>" required />
                    </div>
                </div>
            </div>

            <!-- Gender -->
            <div class="form-gender" style="display: flex; align-items: start; justify-content: start;">
                <div class="form-icon">
                    <img class="gender_form" src="https://1112.com/images/form/gender_form.svg" style = "padding-left: .5em;  margin:auto;">
                </div>

                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio1" value="Male" required>
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                    
                </div>
                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio2" value="Female" required>
                    <label class="form-check-label" for="inlineRadio1">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio3" value="None" required checked>
                    <label class="form-check-label" for="inlineRadio1">None</label>
                </div>
            </div>
        <!-- Email -->
            <div class="mb-3" style="display: flex; align-items: center; justify-content: space-between; padding-top:1rem;"> 
                <div class="form-icon">
                    <img src="https://1112.com/images/form/mail_form.svg" style = "padding: .75em; margin:auto;">
                </div>
                <div class="form-email" >
                <div style="width: 45em;">
                    <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="Email" maxlength="50" required >
                </div>
                </div>
            </div>

        <!-- Password -->
            <div class="mb-3"> 
                <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                    <img src="https://1112.com/images/form/password_form.svg" style="padding: .75em; ">
                    <div style="width: 45em;">
                        <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="Password" name="password" maxlength="20" required >
                        <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="Confirm password" name="confirm_password" maxlength="20" required >
                    </div>
                    
                </div>
            </div>
            
            <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center;">
                <!-- <button type="submit" name="submit" class="btn btn-primary">Register</button> -->
                <input type="submit" class="btn btn-success " style="padding: 10px 50px;" name="submit" value="Register" >
            </div>
            
            </fieldset>
        </form>
    </div>
</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>