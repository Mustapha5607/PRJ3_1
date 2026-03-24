<?php
// reservation.php — Calendrier futur + créneaux pris non cliquables

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'connexion.php'; // ton $pdo

$errors  = [];
$success = false;

// Aujourd'hui
$today = date('Y-m-d');

// Services
try {
    $services = $pdo->query("SELECT id, nom FROM services ORDER BY nom")
                    ->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    $errors[] = "Erreur services : " . $e->getMessage();
}

// Créneaux de base
$base_creneaux = ['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'];

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmer'])) {
    $service_id = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
    $date       = trim($_POST['date_rdv']   ?? '');
    $heure      = trim($_POST['heure_rdv']  ?? '');
    $prenom     = trim($_POST['prenom']     ?? '');
    $nom        = trim($_POST['nom']        ?? '');
    $email      = trim($_POST['email']      ?? '');
    $tel        = trim($_POST['tel']        ?? '');

    if (!$service_id || !$date || !$heure || !$prenom || !$nom || !$email) {
        $errors[] = "Tous les champs * obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE date_rdv = ? AND heure_rdv = ?");
        $stmt->execute([$date, $heure]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Créneau déjà pris.";
        } else {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO reservations 
                    (service_id, date_rdv, heure_rdv, nom_client, email_client, telephone, statut)
                    VALUES (?, ?, ?, ?, ?, ?, 'en_attente')
                ");
                $stmt->execute([$service_id, $date, $heure, "$prenom $nom", $email, $tel ?: null]);

                // ====================== AJOUT POUR LES EMAILS ======================
                $insertion_ok = true;   // car on vient de réussir l'insert

                if ($insertion_ok) {
                    // Récupérer le nom du service
                    $stmt_service = $pdo->prepare("SELECT nom FROM services WHERE id = ?");
                    $stmt_service->execute([$service_id]);
                    $service_nom = $stmt_service->fetchColumn() ?: "Prestation";

                    // Envoi des emails
                    require_once "includes/mail.php";

                    $email_envoye = envoyerEmailConfirmation(
                        "$prenom $nom",
                        $email,
                        $service_nom,
                        $date,
                        $heure
                    );

                    if ($email_envoye) {
                        $success_message = "Réservation enregistrée avec succès ! Un email de confirmation vous a été envoyé.";
                    } else {
                        $success_message = "Réservation enregistrée, mais problème lors de l'envoi de l'email.";
                    }
                }
                // ===================================================================

                $success = true;
                header("Location: reservation.php?success=1");
                exit;
            } catch (PDOException $e) {
                $errors[] = "Erreur : " . $e->getMessage();
            }
        }
    }
}

if (isset($_GET['success'])) $success = true;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver – IT Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f8fbff; font-family:system-ui,sans-serif; }
        .title { color:#0066cc; font-weight:700; font-size:2.1rem; }
        .creneau-btn { 
            min-width:90px; margin:0.4rem; padding:0.6rem 1rem; border-radius:8px; font-size:0.95rem; 
        }
        .creneau-btn.libre:hover { background:#e6f0ff; border-color:#0066cc; }
        .creneau-btn.pris { 
            opacity:0.35; background:#f8f9fa; color:#adb5bd; cursor:not-allowed; pointer-events:none; 
        }
        .sidebar { background:white; border-radius:12px; box-shadow:0 4px 16px rgba(0,0,0,0.08); padding:1.5rem; }
        .confirmation { background:#d4edda; border:1px solid #badbcc; color:#0f5132; border-radius:12px; padding:2rem; margin-bottom:2.5rem; text-align:center; }
    </style>
</head>
<body>

<div class="container my-5">

    <?php if ($success): ?>
        <div class="confirmation">
            <h2 class="h3 fw-bold mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> Réservation envoyée !
            </h2>
            <p class="mb-4">La confirmation de votre réservation vous sera transmise par email.</p>
            <a href="index.html" class="btn btn-outline-primary btn-lg px-5">Retour à la page d'accueil</a>
        </div>

    <?php else: ?>

        <?php if ($errors): ?>
            <div class="alert alert-danger mb-4">
                <ul class="mb-0"><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <h1 class="title text-center mb-5">Prendre rendez-vous</h1>

        <div class="row g-5">

            <!-- Choix jour + créneaux -->
            <div class="col-lg-8">
                <h2 class="h4 fw-bold mb-4">Choisissez votre jour</h2>
                <input type="date" id="date-picker" class="form-control mb-4" min="<?= $today ?>" required>

                <div id="creneaux-container" class="d-none">
                    <h3 class="h5 mb-3">Créneaux disponibles</h3>
                    <div id="creneaux-list" class="d-flex flex-wrap gap-2"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar position-sticky" style="top:1.5rem;">
                    <h3 class="h5 fw-bold mb-4 text-center">Votre rendez-vous</h3>

                    <div class="mb-4">
                        <label class="form-label">Prestation *</label>
                        <select id="select-service" class="form-select">
                            <option value="">Choisir...</option>
                            <?php foreach ($services as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Prénom *</label>
                        <input type="text" id="input-prenom" class="form-control" placeholder="Votre prénom">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nom *</label>
                        <input type="text" id="input-nom" class="form-control" placeholder="Votre nom">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email *</label>
                        <input type="email" id="input-email" class="form-control" placeholder="votre@email.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" id="input-tel" class="form-control" placeholder="06XXXXXXXX">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Date & heure *</label><br>
                        <span id="recap-dh" class="text-muted">— non sélectionné —</span>
                    </div>

                    <hr>

                    <button type="button" id="btn-confirmer" class="btn btn-primary w-100 py-3 fw-bold" disabled>
                        Confirmer le rendez-vous
                    </button>
                </div>
            </div>
        </div>

        <!-- Formulaire caché -->
        <form id="form-rdv" method="post">
            <input type="hidden" name="service_id"   id="hidden-service">
            <input type="hidden" name="date_rdv"     id="hidden-date">
            <input type="hidden" name="heure_rdv"    id="hidden-heure">
            <input type="hidden" name="prenom"       id="hidden-prenom">
            <input type="hidden" name="nom"          id="hidden-nom">
            <input type="hidden" name="email"        id="hidden-email">
            <input type="hidden" name="tel"          id="hidden-tel">
            <input type="hidden" name="confirmer"    value="1">
        </form>

    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const datePicker = document.getElementById('date-picker');
    const container  = document.getElementById('creneaux-container');
    const list       = document.getElementById('creneaux-list');
    const btnConfirm = document.getElementById('btn-confirmer');
    const recap      = document.getElementById('recap-dh');

    const inputs = {
        service: document.getElementById('select-service'),
        prenom:  document.getElementById('input-prenom'),
        nom:     document.getElementById('input-nom'),
        email:   document.getElementById('input-email'),
        tel:     document.getElementById('input-tel')
    };

    let selDate  = null;
    let selHeure = null;

    datePicker.addEventListener('change', () => {
        selDate = datePicker.value;
        if (!selDate) return;

        const base = ['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'];
        const pris = [];

        list.innerHTML = '';
        base.forEach(h => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline-secondary creneau-btn';
            btn.textContent = h;
            btn.dataset.date = selDate;
            btn.dataset.heure = h;

            if (pris.includes(h)) {
                btn.classList.add('pris');
                btn.disabled = true;
            } else {
                btn.classList.add('libre');
                btn.onclick = () => {
                    document.querySelectorAll('.creneau-btn').forEach(b => b.classList.remove('btn-primary','active'));
                    btn.classList.add('btn-primary','active');
                    selHeure = h;
                    const dateFr = new Date(selDate).toLocaleDateString('fr-FR', {weekday:'long',day:'numeric',month:'long',year:'numeric'});
                    recap.textContent = dateFr + ' à ' + h;
                    checkReady();
                };
            }
            list.appendChild(btn);
        });

        container.classList.remove('d-none');
        checkReady();
    });

    Object.values(inputs).forEach(inp => {
        inp.addEventListener('input', checkReady);
        inp.addEventListener('change', checkReady);
    });

    function checkReady() {
        const ok = 
            selDate && selHeure &&
            inputs.service.value !== "" &&
            inputs.prenom.value.trim() !== "" &&
            inputs.nom.value.trim() !== "" &&
            inputs.email.value.trim() !== "";

        btnConfirm.disabled = !ok;

        if (ok) {
            document.getElementById('hidden-service').value = inputs.service.value;
            document.getElementById('hidden-date').value    = selDate;
            document.getElementById('hidden-heure').value   = selHeure;
            document.getElementById('hidden-prenom').value  = inputs.prenom.value.trim();
            document.getElementById('hidden-nom').value     = inputs.nom.value.trim();
            document.getElementById('hidden-email').value   = inputs.email.value.trim();
            document.getElementById('hidden-tel').value     = inputs.tel.value.trim();
        }
    }

    btnConfirm.onclick = () => document.getElementById('form-rdv').submit();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>