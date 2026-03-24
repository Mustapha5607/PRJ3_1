//Sécurité et authentification admin : protège toutes les pages de l’admin.
<?php
// auth.php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>