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

    $lan = 51.257522777765885;
    $long = 4.371170240157178;
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <title>Document</title>

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
            <a href="logout.php"><img src="../images/logout.png"></a>
            <h3>Dashboard</h3>
            <a href="jacket.php"><img src="../images/settings.png"></a>
        </div>
        <div class="devider"></div>
        <div class="alarmen">
        <h3>Alarmen</h3>
            <?php foreach($user as $u){
                if($u['active'] == 1 && $u['alarm'] == 1){
                    echo "<p><img src='" . $u['avatar'] . "' class='icon_user'>" .$u['firstname']. " " .$u['lastname'] . "<img src='../images/alarm.png' class='danger'></p>";
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
    </section>
<!-- einde sidebar -->
<div class="bouderies">
    <div id="mapid"></div>
</div>
    <script>
        const mymap = L.map('mapid').setView([51.257522777765885, 4.371170240157178], 13);
        const marker = L.marker([51.257522777765885, 4.371170240157178]).addTo(mymap);

        const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const tiles = L.tileLayer(tileUrl, { attribution });
        tiles.addTo(mymap);
        const api_url = 'https://api.wheretheiss.at/v1/satellites/25544';

        async function getISS() {
            const response = await fetch(api_url);
            const data = await response.json();
            const { latitude, longitude } = data;

           // marker.setLatLng([latitude, longitude]);
            //marker.bindPopup("<b>Help!</b><br>I am in pain.").openPopup();
            marker.bindPopup("<?php include_once('markerInfo.php');?>").openPopup();

            document.getElementById('lat').textContent = latitude.toFixed(2);
            document.getElementById('lon').textContent = longitude.toFixed(2);
        }

        getISS();
        
    </script>
</body>
</html>