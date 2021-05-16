<?php 
    include_once( __DIR__ . '/../classes/User.php' );

    function canLogin($email, $password){
        $conn = Db::getConnection();
        $statement = $conn->prepare("select * from admin where email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetch();
        if (!$user) {
            return false;
        }

        $hash = $user['password'];
        if(password_verify($password, $hash)){
            return true;
        } else {
            return false;
        }
    }

    if ( !empty( $_POST ) ) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (canLogin($email, $password)){
            session_start();
            $_SESSION['admin'] = $email;
            header("Location: dashboard.php");
        } else {
            $error = true;
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
    <?php if (isset($error)): ?>
        <div class="alert">Foutief wachtwoord</div>
    <?php endif; ?>
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