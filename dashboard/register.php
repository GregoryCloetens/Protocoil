<?php
  include_once( __DIR__ . '/../classes/User.php' );

  if(!empty($_POST)){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
      $options = [
        'cost' => 14,
      ];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);

      $conn = Db::getConnection();
      
      $query = $conn->prepare("insert into admin (firstname, lastname, email, password) values (:firstname, :lastname, :email, :password)");
      $query->bindValue(":firstname", $firstname);
      $query->bindValue(":lastname", $lastname);
      $query->bindValue(":email", $email);
      $query->bindValue(":password", $password);
      $query->execute();
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
  <h1>Registreer</h1>     
        <form class="formulier" action="" method="post">
        <div class="form-group">
                <span class="icon icon_user"></span><input type="firstname" placeholder="Enter firstname" name="firstname" id="firstname" class="form-control">
          </div>
          <div class="form-group">
                <span class="icon icon_user"></span><input type="lastname" placeholder="Enter lastname" name="lastname" id="lastname" class="form-control">
          </div>
            <div class="form-group">
                <span class="icon icon_email"></span><input type="email" placeholder="Enter email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <span class="icon icon_password"></span><input type="password" placeholder="Password" name="password" id="password" class="form-control">
            </div>
            <input type="submit" value="Sign up">
        </form>
    </div>
</body>
</html>