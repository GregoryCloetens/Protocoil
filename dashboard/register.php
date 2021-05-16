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
    <title>Document</title>
</head>
<body>
<form action="" method="post">
      <div class="form-group">
        <label for="firstname">firstname</label>
        <input type="firstname" placeholder="Enter firstname" name="firstname" id="firstname" class="form-control">
      </div>
      <div class="form-group">
        <label for="lastname">lastname</label>
        <input type="lastname" placeholder="Enter lastname" name="lastname" id="lastname" class="form-control">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" placeholder="Enter email" name="email" id="email" class="form-control">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password" class="form-control">
      </div>
      <input type="submit" value="Sign up" class="btn btn-primary btnu">

    </form>
</body>
</html>