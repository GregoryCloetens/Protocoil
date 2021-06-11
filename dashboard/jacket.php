<?php
    include_once( __DIR__ . '/../classes/User.php' );
    session_start();
    if(isset($_SESSION['admin'])){
        $conn = Db::getConnection();
        if(!empty($_POST)){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $jacket_id = $_POST['jacket_id'];

            $query = $conn->prepare("insert into user (firstname, lastname, email, jacket_id) values (:firstname, :lastname, :email, :jacket_id)");
            $query->bindValue(":firstname", $firstname);
            $query->bindValue(":lastname", $lastname);
            $query->bindValue(":email", $email);
            $query->bindValue(":jacket_id", $jacket_id);
            $query->execute();
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
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div class="glass">
    <h1>Nieuwe persoon toevoegen</h1>
    <form class="formulier" action="" method="post">
        <div class="form-group">
            <span class="icon icon_user"></span><input type="text" placeholder="Enter firstname" name="firstname" id="firstname" class="form-control">
        </div>
        <div class="form-group">
            <span class="icon icon_user"></span><input type="text" placeholder="Enter lastname" name="lastname" id="lastname" class="form-control">
        </div>
        <div class="form-group">
            <span class="icon icon_email"></span><input type="email" placeholder="Enter email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <span class="icon icon_jacket"></span><input type="number" placeholder="Enter jacket id" name="jacket_id" id="jacket_id" class="form-control">
        </div>
        <input type="submit" value="Toevoegen" class="btn btn-primary btnu">
        <a href="logout.php" id="logoutBtn">Logout</a>
    </form>
</div>
</body>
</html>