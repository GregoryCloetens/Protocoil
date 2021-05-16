<?php
    include_once( __DIR__ . '/../classes/User.php' );
    session_start();
    if(isset($_SESSION['admin'])){
        $conn = Db::getConnection();
        $query = $conn->prepare('select * from user');
        $query->execute();
        $user = $query->fetchAll( PDO::FETCH_ASSOC );
    } else {
        header("location: logout.php");
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <section id="sidebar" class="glass">
        <div>
            <a href="logout.php">#</a>
            <h3>Dashboard</h3>
        </div>
        <div class="devider"></div>
        <div class="alarmen">
        <h3>Alarmen</h3>
                <p><img src="../images/user.png" class='icon_user'>david peeters</p>
                <p><img src="../images/user.png" class='icon_user'>david peeters</p>
        </div>
        <div class="devider"></div>
        <div class="online">
        <h3>Online</h3>
        <?php foreach($user as $u){
            echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "</p>";
        }; ?>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
                <p><img src="../images/user.png" class='icon_user'>patrick star</p>
        </div>
        <div class="devider"></div>
        <div class="charging">
        <h3>Opladen</h3>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
        </div>
    </section>
    <div id="map"></div>
</body>
</html>