<?php

session_start();

if (!isset($_SESSION["admin"])) {

    header("Location: login.php");
    exit;

}

require_once "../connexion.php";


if (isset($_GET["valider"])) {

    $id = $_GET["valider"];

    $pdo->prepare("
    UPDATE reservations
    SET statut='confirme'
    WHERE id=?
    ")->execute([$id]);

}

if (isset($_GET["annuler"])) {

    $id = $_GET["annuler"];

    $pdo->prepare("
    UPDATE reservations
    SET statut='annule'
    WHERE id=?
    ")->execute([$id]);

}


$res = $pdo->query("
SELECT r.*, s.nom AS services
FROM reservations r
LEFT JOIN services s ON s.id = r.service_id
ORDER BY date_rdv DESC
")->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>

<title>Admin</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h1>Admin réservations</h1>

<a href="logout.php">Déconnexion</a>


<table class="table">

<tr>

<th>Date</th>
<th>Heure</th>
<th>Client</th>
<th>Service</th>
<th>Statut</th>
<th>Action</th>

</tr>

<?php foreach ($res as $r): ?>

<tr>

<td><?= $r["date_rdv"] ?></td>

<td><?= $r["heure_rdv"] ?></td>

<td><?= $r["nom_client"] ?></td>

<td><?= $r["services"] ?></td>

<td><?= $r["statut"] ?></td>

<td>

<a
href="?valider=<?= $r["id"] ?>"
class="btn btn-success btn-sm">

Valider

</a>

<a
href="?annuler=<?= $r["id"] ?>"
class="btn btn-danger btn-sm">

Annuler

</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>