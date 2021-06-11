<?php

session_start();
include_once( __DIR__ . '/../classes/User.php' );

    $conn = Db::getConnection();
    $query = $conn->prepare('select * from user');
    $query->execute();
    $user = $query->fetchAll( PDO::FETCH_ASSOC );

echo json_encode( $user );
