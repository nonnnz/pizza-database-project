<?php

session_start();
require_once "../components/connect.php";

if(isset($_POST['submit'])){
    $menu_name = $_POST['menuname'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $img = $_FILES['img'];

    $allow = array('jpg', 'jpeg', 'png');
    // separate name and file extension
    $extension = explode(".", $img['name']);
    // convert file extension to small
    $fileActExt = strtolower(end($extension));
    // random file name 
    // $fileNew = rand() . "." . $fileActExt;
    // upload to folder images
    $filePath = "images/" . $fileNew;

    // check file extension 
    if (in_array($fileActExt, $allow)){
    // check size
    if ($img['size'] > 0 && $img['error'] == 0){
      // upload
        if (move_uploaded_file($img['temp_name'], $filePath)){
        // $sql = $conn->prepare("INSERT INTO `pizza` () VAULES ()");
        // $sql->bindParam(":menu_name", $menu_name);
        // $sql->bindParam(":price", $price);
        // $sql->bindParam(":cat", $cat);
        // $sql->bindParam(":img", $fileNew);
        $sql->execute();

        if ($sql){
            $_SESSION['success'] = "Menu has been added Successfully";
            header("location: menu_management.php");
        } else {
            $_SESSION['error'] = "Menu has not been added Successfully";
            header("location: menu_management.php");
        }
        }
    }  
    }
}
?>