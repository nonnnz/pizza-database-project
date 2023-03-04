<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in
$name = "Guest";
if(isset($_SESSION['email'])){
    $name = $_SESSION["fname"];
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
    <link rel="stylesheet" href="css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head> -->

    <!-- bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<?php require_once '../components/user_header.php'; ?>


        <!-- My Profile -->
            <div class="row" style = "margin-top: 80px">
                <div class="col">
                    <div class="promote-tab text-center"style="display: flex; justify-content: center; align-items:center; min-height:20vh;padding-Top: 3rem; ">
                            <a class="item-name" href="" style="text-decoration: none;">
                                <div class="item-icon hw" style=" min-height:20vh;padding-right: 3.5rem; ">
                                    <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/my-profile_menu.svg" width= "70%" height="70%"  ></button>
                                    <div class="item-name" "><font color ="#009966">My Profile</font></div>
                                </div>
                            </a>
                        
                            <!-- Tax Information -->
                            <a class="item-name" href=""style="text-decoration: none;">
                                 <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                                    <button style="border-radius: 50%; width: 80px; height: 80px;"class="btn btn-1" > <img src="https://www.1112.com/images/tax-information_menu.svg" width= "70%" height="70%"  ></button>
                                    <div class="item-name"><font color ="#009966">Tax Information</font></div>
                                </div>
                            </a>

                            <!-- >Address Book -->
                            <a class="item-name" href=""style="text-decoration: none;">
                                <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                                    <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/address-book_menu.svg" width= "70%" height="70%"  ></button>
                                    <div class="item-name"><font color ="#009966">Address Book</font></div>
                                </div>
                            </a>

                            <!-- >Credit Card -->
                            <a class="item-name" href=""style="text-decoration: none;">
                                <div class="item-icon hw"style=" min-height:20vh;padding-right: 3.5rem; ">
                                    <button style="border-radius: 50%; width: 80px; height: 80px; "class="btn btn-1" > <img src="https://www.1112.com/images/credit-card_menu.svg" width= "70%" height="70%"  ></button>
                                    <div class="item-name"><font color ="#009966">Credit Card</font></div>
                                </div>
                            </a>
                             
                            <!-- >Pizza Tracker -->
                            <a class="item-name" href=""style="text-decoration: none;">
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






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>