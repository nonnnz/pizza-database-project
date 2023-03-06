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
    <title>Tax Information</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head> -->

    <!-- bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


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
        <h2 class="text-center">TAX INFORMATION</h2>
    </div>


<!--TAX INFORMATION --> 
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 10vh; padding-bottom: 2rem  ">
        <form method="post" action="" style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:40rem ;" class="shadow">
            <fieldset name="TAX INFORMATION">

            <div class="mb-3" "> 
                    <div style="width: 100%;">
                        <input type="text" class="form-control" placeholder="Name/Company"style="margin-bottom :1rem" maxlength="20" required>
                        <input type="text" class="form-control" placeholder="Tax ID" style="margin-bottom :1rem" maxlength="20" required>               
                        <input type="text" class="form-control" placeholder="Branch ID"style="margin-bottom :1rem" maxlength="20" required >
                        <input type="text" class="form-control" placeholder="Address" style="margin-bottom :4rem" maxlength="20" required >   
                    </div>
                </div>
                

                <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center; ">
                    <!-- <button type="submit" name="Save_Changes" class="btn btn-primary">Save Changes</button> -->
                    <input type="submit" class="btn btn-success " style="padding: 10px 50px; " name="Save_Changes" value="Save Changes" >
                </div>
                
            </fieldset>
        </form>
    </div>
</section> 



        



<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>