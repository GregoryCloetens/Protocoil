<?php
include_once( __DIR__ . '/../classes/User.php' );
session_start();
if(isset($_SESSION['admin'])){
    $conn = Db::getConnection();
    $query = $conn->prepare('select * from user where active = 1');
    $query->execute();
    $user = $query->fetchAll( PDO::FETCH_ASSOC );
} else {
    header("location: logout.php");
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

</head>
<body>
<!-- sidebar -->
<section id="sidebar" class="glass">
        <div class="menuNav">
            <h3>Dashboard</h3>
            <a href="jacket.php"><img src="../images/settings.png"></a>
        </div>
        <div class="devider"></div>
        <div class="alarmen">
        <h3>Alarmen</h3>
            <div id="alarmLijst">
                <?php 
                    foreach($user as $u){
                        if( $u['alert'] == 1){
                            echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "<img src='../images/alarm.png' class='danger'></p>";
                        }
                    };
                ?>
            </div>    
        </div>
        <div class="devider"></div>
        <div class="online">
            <h3>Online</h3>
            <div id="onlineLijst">
                <?php 
                    foreach($user as $u){
                        if ( $u['alert'] == 0) {
                            echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "</p>";
                        } 
                    }; 
                ?>
            </div>
        </div>
        <script>
            if(document.getElementById('onlineLijst').innerHTML.trim().length == 0) {
                document.getElementById('onlineLijst').innerHTML += '<p>Niemand online</p>';
            };
            if(document.getElementById('alarmLijst').innerHTML.trim().length == 0) {
                document.getElementById('alarmLijst').innerHTML += '<p>Alles in orde!</p>';
            };
        </script>
        <!--
        <div class="devider"></div>
        <div class="charging">
        <h3>Opladen</h3>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
                <p><img src="../images/user.png" class='icon_user'>90%</p>
        </div> -->
    </section>
<!-- einde sidebar -->
<div class="bouderies">
    <div id="mapid"></div>
</div>
    <script>
        const mymap = L.map('mapid').setView([51.257522777765885, 4.371170240157178], 13);
        //const marker = L.marker([51.257291, 4.360752]).addTo(mymap);
        //marker.bindPopup("<?php //include_once('markerInfo.php');?>").openPopup();

        <?php foreach($user as $u){
                if($u['wet'] == 1){
                    $wet = 'Water gedetecteerd';
                } else {
                    $wet = 'Geen water gedetecteerd';
                };
                if ($u['alert'] == 1) {
                    echo "const marker" . $u['jacket_id'] . " = L.marker([" . $u['GPSX'] . ", " . $u['GPSY'] . "]).addTo(mymap);
                    marker" . $u['jacket_id'] . ".bindPopup('". "<h2>" . $u['firstname'] . " " . $u['lastname'] . "</h2><span>GPSX: ". $u['GPSX'] ."</span><br><span>GPSY: ". $u['GPSY'] ."</span><br><span>Wet: ". $wet ."</span>" ."').openPopup();";
                    
                }
        } ?>

        const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const tiles = L.tileLayer(tileUrl, { attribution });
        tiles.addTo(mymap);
        
    </script>
</body>
</html>