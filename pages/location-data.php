<?php

    require_once "../components/connect.php";

    if(isset($_POST['province_id'])) {
        // get the province id from the AJAX request
        $province_id = $_POST['province_id'];

        // query to get districts for the selected province
        $query = $pdo->prepare("SELECT * FROM `district` WHERE `district`.`province_code` = :province;");
        $query->bindParam(':province', $province_id);
        $query->execute();

        // create an array of options for the select element
        $options = '<option selected disabled>Select a district</option>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $options .= '<option value="'.$row['code'].'">'.$row['name_th'].'</option>';
        }

        // return the options as a JSON response
        echo json_encode($options);
    }
    else if(isset($_POST['district_id'])) {
        // get the district id from the AJAX request
        $district_id = $_POST['district_id'];

        // query to get subdistricts for the selected district
        $query = $pdo->prepare("SELECT * FROM `subdistrict` WHERE `subdistrict`.`district_code` = :district;");
        $query->bindParam(':district', $district_id);
        $query->execute();

        // create an array of options for the select element
        $options = '<option selected disabled>Select a subdistrict</option>';
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $options .= '<option value="'.$row['code'].'">'.$row['name_th'].'</option>';
        }

        // return the options as a JSON response
        echo json_encode($options);
    }
?>
