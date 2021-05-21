<?php
    include_once( __DIR__ . '/../classes/User.php' );
    session_start();
    if(isset($SESSION['admin'])){
        $conn = Db::getConnection();
        if(!empty($_POST)){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $jacket_id = $_POST['jacket_id'];
        }
    } else {
        header('Location: logout.php');
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>