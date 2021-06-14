<?php
var $time = 0;
if($fallTime === Null){
    $fallSeconds = 'persoon is niet gevallen';
}else{
   $time = $fallTime/10;
   $fallSeconds = 'de persoon is ' . $time . ' seconden gevallen';
}

echo json_encode($fallSeconds);