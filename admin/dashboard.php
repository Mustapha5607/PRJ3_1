//nclure auth.php pour protéger la page
Afficher agenda complet des réservations
Boutons pour valider / annuler

<?php
include "../includes/securite.php";
include "../includes/connexion.php";

$sql = "SELECT r.id_reservation, r.nom_client, r.email_client, r.date_reservation, r.heure_reservation, s.nom_service, r.statut
        FROM reservations r
        JOIN services s ON r.id_service = s.id_service
        ORDER BY r.date_reservation, r.heure_reservation";

$stmt = $pdo->query($sql);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Dashboard Admin</h1>
<table border="1">
<tr>
<th>Date</th>
<th>Heure</th>
<th>Client</th>
<th>Email</th>
<th>Service</th>
<th>Statut</th>
<th>Action</th>
</tr>

<?php foreach($reservations as $r): ?>
<tr>
    <td><?= $r['date_reservation'] ?></td>
    <td><?= $r['heure_reservation'] ?></td>
    <td><?= $r['nom_client'] ?></td>
    <td><?= $r['email_client'] ?></td>
    <td><?= $r['nom_service'] ?></td>
    <td><?= $r['statut'] ?></td>
    <td>
        <a href="reservations.php?action=valider&id=<?= $r['id_reservation'] ?>">Valider</a>
        <a href="reservations.php?action=annuler&id=<?= $r['id_reservation'] ?>">Annuler</a>
    </td>
</tr>
<?php endforeach; ?>
</table>