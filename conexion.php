<?php
try {
    $mbd = new PDO('mysql:host=localhost;dbname=iweek4', 'root', '');
  
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>