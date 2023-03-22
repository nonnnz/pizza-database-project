<?php
session_start();

// Include the database connection file
require_once "../components/connect.php";


// check if the user is logged in

if(isset($_SESSION['user_id'])){
    $name = $_SESSION["us_fname"];
} else {
    header('Location: login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREDIT CARD</title>

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

    <div class="profile-container">
        <div class="profile-row">
            <div class="profile-row-head">
                <div class="col-xs-6">
                    <h2 class="text-left mt10 mb10">CREDIT CARD</h2>
                </div>
                <div class="col-xs-6 text-right">
                    <div class="button-add text-center">
                        <button type="button" class="btn btn-success" style="border-radius: 12px; font-weight: bold;"><i class="fa fa-plus size-12"></i> Add Credit Card </button>
                    </div>
                </div>
                <!-- <div style="display: flex; justify-content: left; align-items:center; padding-left:80px;">
                    <h2 class="text-center">ADDRESS BOOK</h2>
                </div> -->
            </div>
            

    
            <!--address status --> 
            <section class="form-container ">
                <div style="display: flex; justify-content: center; align-items: center; min-height: 30vh; margin: auto;">
                    <form method="post" action="" style="border:1px solid black; padding: 3rem; border-radius : 1rem ; border-color: green ;min-width:65rem" class="shadow">
                        <fieldset name="Order Status">
                            <h3 class="text-center" style="padding-bottom:1rem">You don't have any Credit Card!</h3>
                        </fieldset>
                    </form>    
                </div>    
            </section>
        </div>
    </div>

    <div class="credit_container " style = "display : none">
        <div class="adress-head d-flex justify-content-between ">
            <h2>CREDIT CARD</h2>
            <button type="button " class="btn btn-success " style="height: 40px; margin-left: 0.5rem; padding: 0.5rem; ">
                <i class="fa fa-plus right txt " style="margin-right: 5px; "></i>Add New Card

            </button>
        </div>

        <div class="credit-box ">
            <div class="address-detail ">
                <div class="d-flex flex-column ">
                    <div class="p d-flex ">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAgCAMAAABq4atUAAAAhFBMVEX3nhvrABv/////XwD+7/D958XsDyj5tlT82qn/+fDwP1P+8+L+awXyIxD7zozwFxT5r7f1f4zyX2/uL0X9bwb+7dT3pCn93+ L3mRn6hhD+WQH81Jr5vGHtHzb4r0X94Lf7z9T1Lw35QQj8egv0b376v8X2kJv2X0P6wnD5ihL4bE74nyWXYNIuAAABPklEQVQ4jZ2V61KDMBCFFwIkBEWgAloubZXWqu//fnInJSd2yvnFZPLNHnaTE7IXRYncWVYlm2heSouSE2WcF4GykaaPPLEWebHTrR1aYFYt1pATW7fyLnagIp24ewPlO0vT1y9pEgp09HTmmT296dR1hhzIMEiFI+QAby+s06sO0WGA1j3otO8h9q5Dmd9BOTB3GhiTQbITnZkK4VJBCxm6MJYCf1XYFIFCHzPEgD9uE3K3MMgf+SRN/R70CSCXjENixlG5BNzdg8ItULHN3qZGNMDffoFwyx8fbrnxGD1+YP0WQvf29E+h8N4l/IaF+owwjgr2OxVDsFS4F+jeiiXCIGUMozEsUSD96GGZqWHZKl710ItALKfrB8BJFKy69A+AWypIPSW5ArU6N1J6npTxeV4KxJXXVPNS+MrGP15ME2pz0EKIAAAAAElFTkSuQmCC
                            " alt=" ">
                    <h4 style="padding-left: 10px;display: flex; justify-content: center; text-align: center; margin-bottom: 0 !important; ">xxxx xxxx xxxx xxxx</h4>
                    </div>
                </div>
            </div>
            <div class="row pt-4 ">
                <p>Card Name : PEERASIN SRISRI</p>
            </div>
            <div class="row ">
                <p>Expiration Date : 01/01/01</p>
            </div>
            <div class="row pt-2 ">
                <div class="col ">
                    <input class="form-check-input " type="checkbox " value=" " id="flexCheckDefault ">
                    <label class="form-check-label " for="flexCheckDefault " style="font-weight: bold; ">
                        This is your default credit card
                    </label>
                </div>
                
                <div class="col-1 ">
                    <a class="btn btn-inline btn-small remove "><img class="img-profile "
                            src="https://1112.com/images/remove_icons.svg " style="width : 17px; "></a>
                </div>
            </div>
        </div>
    </div>

    

</body>