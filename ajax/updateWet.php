<?php
session_start();
include_once( __DIR__ . '/../classes/User.php' );
$conn = Db::getConnection();
$jacket_id = $_POST['jacket_id'];
$query = $conn->prepare('update user set active = 1 where jacket_id = '.$jacket_id);
$query->execute();
echo "succes";