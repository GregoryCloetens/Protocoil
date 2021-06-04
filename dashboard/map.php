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
               
            </div>    
        </div>
        <div class="devider"></div>
        <div class="online">
            <h3>Online</h3>
            <div id="onlineLijst">
            
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    </section>
<!-- einde sidebar -->
<div class="bouderies">
    <div id="mapid"></div>
</div>
    <script>
        const mymap = L.map('mapid').setView([51.257522777765885, 4.371170240157178], 13);

       

        const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        const tiles = L.tileLayer(tileUrl, { attribution });
        tiles.addTo(mymap);
        
        const markers = {}
        const alarmList = document.querySelector("#alarmLijst")
        const onlineList = document.querySelector("#onlineLijst")

        function initMarkers(){
            $.ajax({    
                    type: "GET",
                    url: "../ajax/getUpdate.php",             
                    dataType: "JSON"                 
                    
                }).done(function(res){
                    let users = res
                    users.forEach(user => {
                        let newMarker = L.marker([user.GPSX,user.GPSY]);
                        let wet
                        if(user.wet == 1){
                            wet = "Water gedetecteerd!"
                        } else {
                            wet = "Geen water gedetecteerd!"
                        }
                        newMarker.bindPopup("<h2>"+user.firstname + " " + user.lastname+"</h2><span>GPSX: "+ user.GPSX +"</span><br><span>GPSY: "+ user.GPSY +"</span><br><span>Wet: "+ wet +"</span>")
                        markers[user.jacket_id] = newMarker

                        if(user.alert == 1 && user.active == 1){
                            newMarker.addTo(mymap)
                            let listElement = "<p><img src='" + user.avatar + "' class='icon_user'>" + user.firstname + " " + user.lastname + "<img src='../images/alarm.png' class='danger'></p>"
                            alarmList.innerHTML += listElement
                        } else {
                            let listElement = "<p><img src='" + user.avatar + "' class='icon_user'>" + user.firstname + " " + user.lastname + "</p>"
                            if(user.active == 1){
                                onlineList.innerHTML += listElement
                            }
                        }
                    });
                });
        }   
        initMarkers()

        setInterval(updateData, 1000);
            function updateData(){
                $.ajax({    
                    type: "GET",
                    url: "../ajax/getUpdate.php",             
                    dataType: "JSON"                 
                    
                }).done(function(res){
                    let users = res
                    alarmList.innerHTML = ""
                    onlineList.innerHTML = ""
                    users.forEach(user => {
                        marker = markers[user.jacket_id]
                        marker.setLatLng([user.GPSX,user.GPSY])
                        let wet
                        if(user.wet == 1){
                            wet = "Water gedetecteerd!"
                        } else {
                            wet = "Geen water gedetecteerd!"
                        }
                        marker.bindPopup("<h2>"+user.firstname + " " + user.lastname+"</h2><span>GPSX: "+ user.GPSX +"</span><br><span>GPSY: "+ user.GPSY +"</span><br><span>Wet: "+ wet +"</span>")

                        if(user.alert == 1 && user.active == 1){
                            marker.addTo(mymap)
                            let listElement = "<p><img src='" + user.avatar + "' class='icon_user'>" + user.firstname + " " + user.lastname + "<img src='../images/alarm.png' class='danger'></p>"
                            alarmList.innerHTML += listElement
                            
                        } else {
                            mymap.removeLayer(marker)
                            let listElement = "<p><img src='" + user.avatar + "' class='icon_user'>" + user.firstname + " " + user.lastname + "</p>"
                            if(user.active == 1){
                                onlineList.innerHTML += listElement
                            }
                        }
                    });
                });
                

            }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>
</html>