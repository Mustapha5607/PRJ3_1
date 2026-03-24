//Ajouter / supprimer / modifier créneaux
Vérifier si un créneau est déjà réservé avant suppression

<?php
include "../includes/securite.php";
include "../includes/connexion.php";

// Ajouter créneau
if(isset($_POST['ajouter'])) {
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    $stmt = $pdo->prepare("INSERT INTO disponibilites (date,heure,disponible) VALUES (?,?,1)");
    $stmt->execute([$date,$heure]);
}

// Liste
$dispos = $pdo->query("SELECT * FROM disponibilites")->fetchAll(PDO::FETCH_ASSOC);
?