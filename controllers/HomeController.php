<?php

function homeCtrl($conn){
    $medicines = getMedicines($conn);
    require 'views/home.php';
}
?>