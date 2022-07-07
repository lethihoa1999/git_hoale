<?php
    $conn=  new PDO('mysql:host=db;port=3306;dbname=sampleDB; charset=utf8', 'root', 'root');
    if($conn->connect_error){
        die("Kết nối không thành công:". $conn->connect_error);
    }
?>