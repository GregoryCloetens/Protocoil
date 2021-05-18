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
        <div class="menuNav">
            <a href="logout.php"><img src="../images/logout.png"></a>
            <h3>Dashboard</h3>
            <a href="jacket.php"><img src="../images/settings.png"></a>
        </div>
        <div class="devider"></div>
        <div class="alarmen">
        <h3>Alarmen</h3>
            <?php foreach($user as $u){
                if($u['active'] == 1 && $u['alarm'] == 1){
                    echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "<img src='../images/alarm.png'></p>";
                }
            }; ?>
        </div>
        <div class="devider"></div>
        <div class="online">
        <h3>Online</h3>
            <?php foreach($user as $u){
                if($u['active'] == 1 && $u['alarm'] == 0){
                    echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "</p>";
                }
            }; ?>
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
   
    
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=520&amp;height=392&amp;hl=en&amp;q=Zaha%20Hadidplein%20Antwerpen+(Dokken)&amp;t=&amp;z=12&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe> <a href='https://www.embedmap.net/'>embedded google map</a> <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=e0b40614b4ee22c9f3ef6fdf2bd7547a69028a35'></script>
    <a href='https://www.embedmap.net/'>embed google map</a>
    <script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=c5992930a8dc591d4a8c0fd26c64a5d3a3a8ea45'></script>
    
    
    <div class="credit"><p>© OpenStreetMaps</p></div>
</body>
</html>