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
    <title>ADD ADDRESS</title>

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
        <h2 class="text-center">ADD ADDRESS</h2>
</div>

  <!--ADD ADDRESS --> 
<section class="form-container ">
    <div style="display: flex; justify-content: center; align-items: center; min-height: 30vh;padding-bottom: 2rem; ">
        <form method="post" action="" style="border:1px solid black; padding: 5rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
            <fieldset name="ADD ADDRESS">

              <!--Number/Building/Village --> 
                <div class="row ">
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;" >
                        <img src="https://1112.com/images/address-book_menu.svg" style="padding: .35em; ">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Number" style = " margin:auto;width:95%">
                            </div>
                            <div class="col ">
                                <input type="text" class="form-control" placeholder="Building/Village" style = " margin:auto;width:95%" >
                            </div>
                    </div>
                </div>

                <!--Street/Soi/Select Province --> 
                <div class="row ">
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between; padding-left:3.3rem;padding-top:0.5rem" >
                            <div class="col" >
                                <input type="text" class="form-control" placeholder="Street/Soi" style = " margin:auto;width:95% ;">
                            </div>
                            <div class="col ">
                                <input type="text" class="form-control" placeholder="Select Province" style = " margin:auto;width:95% " >
                            </div>
                    </div>
                </div>

                <!--Select District/Select Subdistrict --> 
                <div class="row ">
                    <div class="form-icon" style="display: flex; align-items: start; justify-content: space-between;padding-left:3.3rem;padding-top:1rem;" >
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Select District" style = " margin:auto;width:95%">
                            </div>
                            <div class="col ">
                                <input type="text" class="form-control" placeholder="Select Subdistrict" style = " margin:auto;width:95% " >
                            </div>
                    </div>
                </div>

                <!--Directions/Phone Number/Address Name --> 
                <div class="mb-3" "> 
                    <div style="width: 99%; padding-left:3.2rem;padding-top:1rem">
                        <input type="text" class="form-control" placeholder="Directions Ex. Flooe or Room Number"style="margin-bottom :1rem" maxlength="20" required>
                        <input type="text" class="form-control" placeholder="Phone Number" style="margin-bottom :1rem" maxlength="20" required>               
                        <input type="text" class="form-control" placeholder="Address Name Ex. Work,Home"style="margin-bottom :4rem" maxlength="20" required > 
                    </div>
                </div>


                    <div class="form-group" style="text-align:center;" style="display: flex; justify-content: center;">
                        <!-- <button type="submit" name="Save_New_Address" class="btn btn-primary">Save Changes</button> -->
                        <input type="submit" class="btn btn-success " style="padding: 10px 50px; " name="Save_New_Address" value="Save New Address" >
                    </div>
                

            </fieldset>
        </form>
    </div>
</section> 