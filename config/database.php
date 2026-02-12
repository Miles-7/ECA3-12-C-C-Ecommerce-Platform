<?php

// PDO = PhP Database Objects
try{
    $db = new PDO('sqlite:' .__DIR__ .'/../database/e-commerce.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}

?>