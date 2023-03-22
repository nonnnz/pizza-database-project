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

$user_id = $_SESSION['user_id'];

// get all address
$query = $pdo->prepare("SELECT `address_book`.*
FROM `address_book` WHERE `address_book`.`user_id` = :id");
$query->bindParam(':id', $user_id);
$query->execute();
$adds = $query->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['delete_add'])) {
    // echo $_POST['delete_add'];
    $addb_id = $_POST['delete_add'];
    $stmt = $pdo->prepare('DELETE FROM address_book WHERE addb_id = ?');
    $stmt->execute([$addb_id]);
    header('Location: address-book.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADDRESS BOOK</title>

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
                    <h2 class="text-left mt10 mb10">Address Book</h2>
                </div>
                <div class="col-xs-6 text-right">
                    <div class="button-add text-center">
                        <a href="add_address.php">
                            <button type="button" class="btn btn-success" style="border-radius: 12px; font-weight: bold;"><i class="fa fa-plus size-12"></i> Add Address </button>
                        </a>
                        
                    </div>
                </div>
                <!-- <div style="display: flex; justify-content: left; align-items:center; padding-left:80px;">
                    <h2 class="text-center">ADDRESS BOOK</h2>
                </div> -->
            </div>
            

    
            <!-- address status --> 
            <section class="form-container ">
                <div style="display: flex; justify-content: center; align-items: center; min-height: 30vh; margin: auto;">
                    
                        <fieldset name="address list">
                            <?php if($query->rowCount() == 0) { ?>
                                <div style="border:1px solid black; padding: 3rem; border-radius : 1rem ; border-color: green ;min-width:65rem; margin-bottom:45px;" class="shadow">
                                    <h3 class='text-center' style='padding-bottom:1rem'>You don't have any Address Book!</h3>
                                </div>
                                <?php
                            } else {
                                foreach ($adds as $add): ?>
                                <form method="post" action="" >
                                    <div >
                                        <div class="address-box shadow" style="padding: 3rem;  min-width:65rem; margin-bottom:45px;">
                                            <div class="address-detail" style="border-bottom: 0.7px solid black;">
                                                <div class="head-detail">
                                                    <h4><?= $add['addb_name'] ?></h4>
                                                </div>
                                                <div class="detail">
                                                    <p><?php echo $add['addb_buildingNo'] . ' ' . $add['addb_street'] . ' ,' . $add['addb_subdist'] . ' ,' . $add['addb_dist'] . ' ,' . $add['addb_prov'] . ' ' . $add['addb_zipcode'] ?></p>
                                                </div>
                                                <div>
                                                    <p>Directions : <?= $add['addb_directionguide'] ?></p>
                                                </div>
                                                <div class="phonenumber">
                                                    <h5>Phone Number : <?= $add['addb_phone'] ?></h5>
                                                </div>
                                            </div>
                                            <div class="row pt-4">
                                                <!-- <div class="col-1">
                                                    <button type="button" class="btn btn-success" style="padding-left: 1rem; padding-right: 1rem;">
                                                        Edit
                                                    </button>
                                                </div> -->
                                                <div class="col-1">
                                                    <input type="hidden" name="delete_add" value="<?php echo $add['addb_id'] ?>">
                                                    <button class="btn btn-inline btn-small remove"><img class="img-profile"
                                                            src="https://1112.com/images/remove_icons.svg" style="width : 17px;"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </form>                                
                                <?php endforeach;
                            }
                            ?>
                        </fieldset>
                    
                </div>    
            </section>

            <!-- display detail -->
            <div class="address-box" style = "display :none">
                <div class="address-detail" style="border-bottom: 0.7px solid black;">
                    <div class="head-detail">
                        <p>316/70 ซ.วงศ์สว่าง11 ถ.วงศสว่าง</p>
                    </div>
                    <div class="detail">
                        <p>--------------------------, Wong Sawang , Bang Sue , Bangkok 10800</p>
                    </div>
                    <div class="phonenumber">
                        <p>Phone Number : 09xxxxxxxx</p>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            This is your default address
                        </label>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-success" style="padding-left: 1rem; padding-right: 1rem;">
                            Edit

                        </button>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-inline btn-small remove"><img class="img-profile"
                                src="https://1112.com/images/remove_icons.svg" style="width : 17px;"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</body>