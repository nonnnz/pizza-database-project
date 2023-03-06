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
    <title>Add New Card</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head> -->

    <!-- bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<?php require_once '../components/user_header.php'; ?>


        
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
        <h2 class="text-center">ADD NEW CARD</h2>
    </div>


<!--Add Card --> 
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items:flex-start; padding-top:1rem;padding-bottom:3rem ">
        <form method="post" action="" style="border:1px solid black; padding: 3rem; border-radius : 1rem ; border-color: green;height:27rem;" class="p-4 shadow">
            

            <!-- Card info -->
            <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;padding-top: 1rem;" >
                <img src="https://1112.com/images/credit-card_menu.svg" style="padding: .75em;width:3em; ">
                <div style="width: 25em;">
                    <input type="text" name="card_num" class="form-control" style="margin-bottom :1rem" placeholder="Card Number" minlength="12" maxlength="12" required >
                    
                </div>
                
            </div>
            
            <div style="width: 100%;">
                <input type="text" name="card_name"class="form-control" style="margin-bottom :1rem" placeholder="Card Name"  maxlength="20" required >
                <p>Expiration Date</p>
                <select name="xmonth"style="height:2.5rem;width:100%;margin-bottom :1rem;color:#939393;" required>
                    <option value="" selected disabled>Month</option>
                    <option value="1">01<br>
                    <option value="2">02<br>
                    <option value="3">03<br>
                    <option value="4">04<br>
                    <option value="5">05<br>
                    <option value="6">06<br>
                    <option value="7">07<br>
                    <option value="8">08<br>
                    <option value="9">09<br>
                    <option value="10">10<br>
                    <option value="11">11<br>
                    <option value="12">12<br>
                </select>

                <select name="xyear"style="height:2.5rem;width:100%;margin-bottom :1rem;;color:#939393" required>
                    <option value="" selected disabled>Year</option>
                    <option value="1">2023<br>
                    <option value="2">2024<br>
                    <option value="3">2025<br>
                    <option value="4">2026<br>
                    <option value="5">2027<br>
                    <option value="6">2028<br>
                    <option value="7">2029<br>
                    <option value="8">2030<br>
                    <option value="9">2031<br>
                    <option value="10">2032<br>
                    <option value="11">2033<br>
                </select>
                
                <input type="text" class="form-control"   name="cvc_cvv" placeholder="CVC/CVV" style="margin-bottom :1rem" minlength="3" maxlength="3" required >
            </div>    
                    
            <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center;">
                <!-- <button type="submit" name="AddCard" class="btn btn-primary">Register</button> -->
                <input type="submit" class="btn btn-success " style="padding: 10px 50px;" name="AddCard" value="Add New Card" >
            </div>
            
            </fieldset>
        </form>
    </div>
</section>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>