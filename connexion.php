<?php

$host = "localhost";
$dbname = "salon_reservation";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "";

} catch (PDOException $e) {

    echo "Erreur : " . $e->getMessage();

}
?>