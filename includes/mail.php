<?php
// includes/mail.php  → Version PHPMailer (recommandée)

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

function envoyerEmailConfirmation($nom_client, $email_client, $service_nom, $date_rdv, $heure_rdv) {
    
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yacine.antitene@gmail.com';     // ← Ton email Gmail
        $mail->Password   = 'rdvpmxliauioksne';          // ← À créer (voir ci-dessous)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('yacine.antitene@gmail.com', 'IT Beauty');
        $mail->CharSet = 'UTF-8';

        // === Email au CLIENT ===
        $mail->clearAddresses();
        $mail->addAddress($email_client, $nom_client);

        $template = file_get_contents(__DIR__ . '/../admin/templates/email_template.html');
        $template = str_replace('{{nom_client}}', htmlspecialchars($nom_client), $template);
        $template = str_replace('{{service}}', htmlspecialchars($service_nom), $template);
        $template = str_replace('{{date_rdv}}', htmlspecialchars($date_rdv), $template);
        $template = str_replace('{{heure_rdv}}', htmlspecialchars($heure_rdv), $template);

        $mail->isHTML(true);
        $mail->Subject = "Confirmation de votre réservation - IT Beauty";
        $mail->Body    = $template;

        $mail->send();

        // === Email de notification au SALON ===
        $mail->clearAddresses();
        $mail->addAddress('yacine.antitene@gmail.com', 'IT Beauty Salon');

        $mail->Subject = "Nouvelle réservation - $nom_client - $date_rdv $heure_rdv";
        $mail->Body    = str_replace(
            "Confirmation de votre réservation", 
            "Nouvelle réservation reçue", 
            $template
        );

        $mail->send();

        return true;

    } catch (Exception $e) {
        error_log("Erreur PHPMailer : " . $mail->ErrorInfo);
        return false;
    }
}
?>