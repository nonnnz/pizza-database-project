<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
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
                <a class="item-name" href="tax_information.php"style="text-decoration: none;">
                        <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px;"class="btn btn-1" > <img src="https://www.1112.com/images/tax-information_menu.svg" width= "70%" height="70%"  ></button>
                        <div class="item-name"><font color ="#009966">Tax Information</font></div>
                    </div>
                </a>

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


<!--MY PROFILE --> 
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 30vh; ">
        <form method="post" action="" style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
            <fieldset name="MY PROFILE">


            <!-- F/L name --> 
            <div class="row ">
                <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                    <img src="https://1112.com/images/form/name_form.svg" style="padding: .75em; ">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="First name" style = " margin:auto;width:95%">
                        </div>
                        <div class="col ">
                            <input type="text" class="form-control" placeholder="Last name" style = " margin:auto;width:95%" >
                        </div>
                </div>
            </div>

            <!-- Phone number \\ Date of birth  -->

            <div class="row ">
                <div class="form-icon" style="display: flex; align-items: center; justify-content: space-between;padding-top:1.5rem;">
                    <img src="https://1112.com/images/form/phone_form.svg" style ="padding: 1.2rem; margin:auto;">
                        <div class="col">
                            <input type="text" class="form-control" stlye =  name="phone" placeholder="+66" maxlength="10" style = " width:105%" >
                        </div>

                    <img src="https://1112.com/images/form/birthday_form.svg" style ="padding-left: 2.7rem; margin:auto;" >
                        <div class="col ">
                            <input id="startDate" name="birthdate" class="form-control" type="date" style = " margin:auto; width:95%;" />
                        </div>
                </div>
            </div>

            <!-- Gender -->
            <div class="form-gender" style="display: flex; align-items: start; justify-content: start;padding-top:2rem;">
                <div class="form-icon">
                    <img class="gender_form" src="https://1112.com/images/form/gender_form.svg" style = "padding-left: .5em;  margin:auto;">
                </div>

                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio1" value="male" required>
                    <label class="form-check-label" for="inlineRadio1">Male</label>
                    
                </div>
                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio2" value="female" required>
                    <label class="form-check-label" for="inlineRadio1">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="" type="radio" name="gender" id="inlineRadio3" value="none" required checked>
                    <label class="form-check-label" for="inlineRadio1">None</label>
                </div>
            </div>  
            



            <!-- F/L name -->
            </fieldset>
        </form>
    </div>
</section> 


    <div style="display: flex; justify-content: center; align-items:center; min-height:20vh; ">
        <h2 class="text-center">RESET PASSWORD</h2>
    </div>

<!--RESET PASSWORD --> 
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 10vh; padding-bottom: 5rem  ">
        <form method="post" action="" style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
            <fieldset name="RESET PASSWORD">

            <!--Email -->
            <div class="mb-3"> 
                <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between; " >
                    <img src="https://www.1112.com/images/form/mail_form.svg" style="padding: .75em; ">
                        <div style="width: 100%;">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email"style="padding-right: 40em; "> 
                        </div>
                </div>
            </div>
            
            <!--Password -->
            <div class="mb-3" "> 
                <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                    <img src="https://1112.com/images/form/password_form.svg" style="padding: .75em;  ">
                    <div style="width: 100%;">
                        <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="New Password (6-15 characters)" name="new Password" maxlength="20" required >
                        <input type="password" class="form-control" style="margin-bottom :1rem" placeholder="Repeat New Password" name="Repeat New Password" maxlength="20" required >
                    </div>
                    
                </div>
            </div>
            
            </fieldset>
        </form>
    </div>
</section> 

<div class="form-group" style="text-align:center;" style="display: flex; justify-content: center; ">
    <!-- <button type="submit" name="submit" class="btn btn-primary">Register</button> -->
    <input type="submit" class="btn btn-success " style="padding: 10px 50px; margin-bottom :3rem " name="submit" value="submit" >
</div>




<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>