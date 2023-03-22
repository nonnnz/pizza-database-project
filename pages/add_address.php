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

// Get province
$stmt = $pdo->prepare("SELECT `provinces`.`code`, `provinces`.`name_th`
FROM `provinces`;");
$stmt->execute();
$provinces = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])) {
    $buildingNo = $_POST['buildingNo'];
    $street = $_POST['street'];
    $prov = $_POST['province'];
    $dist = $_POST['district'];
    $subdist = $_POST['subdistrict'];
    // get zipcode
    $query = $pdo->prepare("SELECT `subdistrict`.`zip_code`
    FROM `subdistrict` WHERE `subdistrict`.`code` = :code;");
    $query->bindParam(':code', $subdist);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $zipcode = $row['zip_code'];
    $phone = $_POST['phone'];

    $insert_addb = $pdo->prepare("INSERT INTO address_book (user_id, addb_buildingNo, addb_street, addb_prov,
     addb_dist, addb_subdist, addb_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_addb->execute([$user_id ,$buildingNo, $street, $prov, $dist, $subdist, $phone]);
    

    // get lastest id
    $query2 = $pdo->prepare("SELECT `address_book`.`addb_id`
    FROM `address_book` WHERE `address_book`.`user_id` = :id ORDER BY `address_book`.`addb_id` DESC");
    $query2->bindParam(':id', $user_id);
    $query2->execute();
    $row2 = $query2->fetch(PDO::FETCH_ASSOC);
    // echo $row2;
    $addb_id = $row2['addb_id'];

    // echo $zipcode;

    // for null
    if(isset($_POST['directionguide']) && $_POST["directionguide"] != "") {
            $directionguide = $_POST["directionguide"];
            $stmt = $pdo->prepare("UPDATE address_book SET addb_directionguide = :directionguide WHERE user_id = :id AND addb_id = :addb_id");
            $stmt->bindValue(":directionguide", $directionguide);
            $stmt->bindValue(":id", $user_id);
            $stmt->bindValue(":addb_id", $addb_id);
            $stmt->execute();
        }
    if(isset($_POST['buildingName']) && $_POST["buildingName"] != "") {
        $buildingName = $_POST["buildingName"];
        $stmt = $pdo->prepare("UPDATE address_book SET addb_buildingName = :buildingName WHERE user_id = :id AND addb_id = :addb_id");
        $stmt->bindValue(":buildingName", $buildingName);
        $stmt->bindValue(":id", $user_id);
        $stmt->bindValue(":addb_id", $addb_id);
        $stmt->execute();
    }
    if($_POST["name"] != "") {
        $name = $_POST["name"];
        $stmt = $pdo->prepare("UPDATE address_book SET addb_name = :addb_name WHERE user_id = :id AND addb_id = :addb_id");
        $stmt->bindValue(":addb_name", $name);
        $stmt->bindValue(":id", $user_id);
        $stmt->bindValue(":addb_id", $addb_id);
        $stmt->execute();
    } else {
        $name = $_POST["buildingNo"] . ' ' . $_POST["street"];
        $stmt = $pdo->prepare("UPDATE address_book SET addb_name = :addb_name WHERE user_id = :id AND addb_id = :addb_id");
        $stmt->bindValue(":addb_name", $name);
        $stmt->bindValue(":id", $user_id);
        $stmt->bindValue(":addb_id", $addb_id);
        $stmt->execute();
    }

    $message = 'Success!';
    echo "<script>
        alert('". $message ."');
        window.location.href='address-book.php';
    </script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add_address_book</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

     <!-- custom css file link  -->
     <link rel="stylesheet" type="text/css" href="css/style12.css">
    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- select2  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous">
 
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

<?php require_once '../components/user_header_new.php'; ?>


    <div class="profile-menu d-flex justify-content-center ">
        <div class="d-flex flex-row justify-content-between" style="width: 800px; ">
            <div class="p">
                <a class="item-name text-center" href="" style="text-decoration: none; align-items: center;">
                    <div class="item-icon hw" style=" min-height:20vh; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; " class="btn btn-1"> <img
                                src="https://www.1112.com/images/my-profile_menu.svg" width="70%" height="70%"></button>
                        <div class="item-name" "><font color =" #009966">My Profile</font>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p">
                <a class="item-name text-center" href="" style="text-decoration: none;">
                    <div class="item-icon hw" style=" min-height:20vh; ">
                        <button style="border-radius: 50%; width: 80px; height: 80px;" class="btn btn-1"> <img
                                src="https://www.1112.com/images/tax-information_menu.svg" width="70%"
                                height="70%"></button>
                        <div class="item-name">
                            <font color="#009966">Tax Information</font>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p">
                <a class="item-name text-center" href="" style="text-decoration: none;">
                    <div class="item-icon hw" style=" min-height:20vh;">
                        <button style="border: 1px solid green; border-radius: 50%; width: 80px; height: 80px; "
                            class="btn btn-1"> <img src="https://www.1112.com/images/address-book_menu.svg" width="70%"
                                height="70%"></button>
                        <div class="item-name">
                            <font color="#009966">Address Book</font>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p">
                <a class="item-name text-center" href="" style="text-decoration: none;">
                    <div class="item-icon hw" style=" min-height:20vh;     ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; " class="btn btn-1"> <img
                                src="https://www.1112.com/images/credit-card_menu.svg" width="70%"
                                height="70%"></button>
                        <div class="item-name">
                            <font color="#009966">Credit Card</font>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p">
                <a class="item-name text-center" href="" style="text-decoration: none;">
                    <div class="item-icon hw" style=" min-height:20vh;     ">
                        <button style="border-radius: 50%; width: 80px; height: 80px; " class="btn btn-1"> <img
                                src="https://www.1112.com/images/Tracker_menu.svg" width="70%" height="70%"></button>
                        <div class="item-name">
                            <font color="#009966">Pizza Tracker</font>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <h2 class="text-center" style="margin-top: 1em;">ADD ADDRESS</h2>
    <div style=" display: flex; justify-content: center; align-items: center; padding-bottom:100px;">
        <div class="address-container "
            style="width: 1000px; border: 1px solid green; border-radius: 12px; padding: 2em;">
            <!-- <div class="search-address">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="map pt-2 pb-2">
                <h1>add map here</h1>
            </div>
            <div class="alert alert-info d-flex justify-content-center text-center"
                style="border: 1px solid black; border-radius: 12px;">
                <i class="fa fa-info-circle "
                    style="display: flex; justify-content: center ;align-items: center; padding-right: 5px;"></i>
                We will deliver to the address that pinned on the map, please recheck and reconfirm your pinned
                location.
            </div> -->
            <form action="" method="post">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="p" style="display: flex; justify-content: center; align-items: center;">
                            <img class="" src="https://cdn-icons-png.flaticon.com/512/263/263115.png" alt="home"
                                style="width:30px ;">
                        </div>
                        <div class="p form-group" style="padding-left: 5px; width: 100%;">
                            <input type="text" class="form-control" placeholder="Number" name="buildingNo" style="width: 100%;" required>
                        </div>
                        <p style="color: red ; padding-left: 2px;">*</p>
                    </div>
                    <div class="col d-flex flex-row">
                        <div class="p form-group" style="display: flex; justify-content: center; align-items: center;">

                            <img src="https://cdn-icons-png.flaticon.com/512/916/916771.png" alt="home"
                                style="width:30px ;">

                        </div>
                        <div class="p form-group" style="padding-left: 5px; width: 100%;">

                            <input type="text" class="form-control" placeholder="Building/Village" name="buildingName" style="width: 100%;">
                        </div>
                        <p style="color: white ; padding-left: 2px;">*</p>

                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col d-flex flex-row">
                        <div class="p form-group" style="display: flex; justify-content: center; align-items: center;">
                            <img class="" src="https://cdn-icons-png.flaticon.com/512/2957/2957382.png" alt="home"
                                style="width:30px ;">
                        </div>
                        <div class="p" style="padding-left: 5px; width: 100%;">

                            <input type="text" class="form-control" placeholder="Street/soi" name="street" style="width: 100%;" required>
                        </div>
                        <p style="color: red ; padding-left: 2px;">*</p>
                    </div>
                    <div class="col d-flex flex-row">
                        <div class="p form-group" style="display: flex; justify-content: center; align-items: center;">

                            <img src="https://cdn-icons-png.flaticon.com/512/876/876205.png" alt="home"
                                style="width:30px ;">

                        </div>
                    
                        <div class="p form-group " style="padding-left: 5px; width: 100%;">
                            <select class="p form-select" name="province" id="province" required>
                                <option selected disabled>Select a province</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province['code'] ?>"><?= $province['name_th'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <input type="text" class="form-control" placeholder="city" name="search" style="width: 100%;"> -->
                        </div>
                        <p style="color: red ; padding-left: 2px;">*</p>


                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col d-flex flex-row">
                        <div class="p" style="display: flex; justify-content: center; align-items: center;">
                            <img class="" src="" alt=""
                                style="width:30px ;">
                        </div>
                        <div class="p" style="padding-left: 5px; width: 100%;">
                            <select class="p form-select" name="district" id="district" required>
                                <!-- <option selected disabled>Select a district</option> -->
                            </select>
                            <!-- <input type="text" class="form-control" placeholder="canton" name="search" style="width: 100%;"> -->
                        </div>
                        <p style="color: red ; padding-left: 2px;">*</p>
                    </div>
                    <div class="col d-flex flex-row">
                        <div class="p " style="display: flex; justify-content: center; align-items: center;">

                            <img src="" alt=""
                                style="width:30px ;">

                        </div>
                        <div class="p" style="padding-left: 5px; width: 100%;">
                            <select class="p form-select" name="subdistrict" id="subdistrict" required>
                                <!-- <option selected disabled>Select a subdistrict</option> -->
                            </select>
                            <!-- <input type="text" class="form-control" placeholder="soi" name="search" style="width: 100%;"> -->
                        </div>
                        <p style="color: red ; padding-left: 2px;">*</p>

                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col d-flex flex-row">
                        <div class="p" style="padding-left: 5px;">
                            <img style="width:30px ;" src="https://cdn-icons-png.flaticon.com/512/2814/2814368.png" alt="">
                        </div>
                        <div class="p" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Directions Ex. Floor or Room Number" name="directionguide" style="height: 100px;">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col d-flex flex-row">
                        <div class="p" style="padding-left: 5px; display: flex; justify-content: center; align-items: center;">
                            <img style="width:30px ;" src="https://cdn-icons-png.flaticon.com/512/15/15874.png" alt="">
                        </div>
                        <div class="p" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Phone Number Ex. 021234567 or 0812345678" name="phone"  maxlength="10" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col d-flex flex-row">
                        <div class="p" style="padding-right: 5px; display: flex; justify-content: center; align-items: center;">
                            <img style="width:30px ;" src="https://cdn-icons-png.flaticon.com/512/481/481874.png" alt="">
                        </div>
                        <div class="p" style="width: 100%;">
                            <input type="text" class="form-control" placeholder="Address Name Ex. Home, Work and Others" name="name" >
                        </div>
                    </div>
                </div>
                <div class="button-add text-center mt-5">
                    <input type="submit" name="submit" value="Add New Address" class="btn btn-success p" style="font-weight: bold; margin-top: 1em; padding-left: 4em; padding-right: 4em;"></input>
                    <!-- <button type="submit" class="btn btn-success" style="border-radius: 12px; padding-left: 2.5em; padding-right: 2.5em; font-weight: bold;">Add New Address </button> -->
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.form-select').select2();
            $('#province').on('change', function(){
                var province_id = $(this).val();
                if(province_id){
                    $.ajax({
                        url: 'location-data.php',
                        type: 'POST',
                        data: {province_id: province_id},
                        dataType: "JSON",
                        success: function(data){
                            $('#district').html(data);
                            $('#subdistrict').html('<option value="" selected disabled>Select District First</option>');
                        }
                    });
                }else{
                    $('#state').html('<option value="" selected disabled>Select province first</option>');
                }
            });

            $("#district").on("change", function(){
				var district_id = $(this).val();
				$.ajax({
					url: "location-data.php",
					type: "POST",
					data: {district_id: district_id},
					dataType: "JSON",
					success:function(data){
						$("#subdistrict").html(data);
					}
				});
			});
        });
    </script>
</body>

</html>