<?php

session_start();
require_once "../components/connect.php";

if(isset($_POST['submit'])){
    $fd_name = $_POST['menuname'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $img = $_FILES['img'];

    $allow = array('jpg', 'jpeg', 'png');
    // separate name and file extension
    $extension = explode(".", $img['name']);
    // convert file extension to small
    $fileActExt = strtolower(end($extension));
    // upload to folder images
    $filePath = "../images/product/pizza/" . $fileActExt;

    // check file extension 
    if (in_array($fileActExt, $allow)){
        $fileNew = $img['name'];
        $filePath = "../images/product/pizza/" . $fileNew;
        // check size
        if ($img['size'] > 0 && $img['error'] == 0){
            // upload
            if (move_uploaded_file($img['tmp_name'], $filePath)){
                $sql = $pdo->prepare("INSERT INTO food (fd_name, fd_price, cat_id, fd_image) VALUES (:fd_name, :price, :cat, :img) ");
                $sql->bindParam(":fd_name", $fd_name);
                $sql->bindParam(":price", $price);
                $sql->bindParam(":cat", $cat);
                $sql->bindParam(":img", $filePath);
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