<?php 
    include_once( __DIR__ . '/classes/User.php' );

    if(!empty($_POST)){
        try {
            $user = new User();
            $user->setEmail( $_POST['email'] );
            $user->setPassword( $_POST['password'] );


        } catch ( \Throwable $th ) {
            $error = $th->getMessage();
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="glass">
        <img src="../images/logo.png" class="logo" alt="logo">
        <form class="formulier" action="" method="post">
            <div class="form-group">
                <span class="icon_user"></span><input type="email" placeholder="Enter email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <span class="icon_password"></span><input type="password" placeholder="Password" name="password" id="password" class="form-control">
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>