Markdown
# Système d'Envoi d'Emails (Branche: mail)

Ce module permet d'intégrer une fonctionnalité d'envoi d'emails robuste au sein du projet **PRJ3_1**, en remplaçant la fonction native `mail()` de PHP par la bibliothèque **PHPMailer**.

## 🚀 Fonctionnalités
* **Support SMTP :** Envoi d'emails via des serveurs externes (Gmail, Outlook, Mailtrap, etc.).
* **Sécurité :** Support du chiffrement TLS/SSL.
* **Formatage :** Gestion native des emails au format HTML et des pièces jointes.
* **Fiabilité :** Gestion des erreurs et logs d'envoi.

## 📁 Structure du module
Le code est organisé dans le dossier `includes/` :
* `includes/PHPMailer/` : Fichiers sources de la bibliothèque.
* `includes/mail.php` : Script de configuration principal où sont définis les paramètres du serveur.

## ⚙️ Configuration
Pour activer l'envoi, modifiez les variables suivantes dans `includes/mail.php` :

```php
$mail->Host       = 'votre_serveur_smtp'; 
$mail->SMTPAuth   = true;
$mail->Username   = 'votre_email@exemple.com';
$mail->Password   = 'votre_mot_de_passe';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
[!IMPORTANT]
Ne poussez jamais vos identifiants réels (mots de passe) sur un dépôt public. Utilisez des variables d'environnement ou ignorez le fichier de config.

🛠 Utilisation
Pour envoyer un mail depuis un autre script (ex: dans admin/), utilisez l'importation suivante :

PHP
require_once '../includes/mail.php';
// Appelez ensuite votre fonction d'envoi personnalisée
📈 État du développement
[x] Intégration de PHPMailer.

[x] Création du script de base mail.php.

[ ] Liaison avec le formulaire de contact/réservation.

[ ] Test de réception sur différentes boîtes mail.


---

### Comment l'ajouter sur GitHub ?
1.  Clique sur le bouton vert **"Add a README"** que l'on voit sur ta première capture d'écran.
2.  Colle le texte ci-dessus dans l'éditeur.
3.  Descends en bas de la page, écris un message de commit (ex: "docs: add README for mail functionality") et clique sur **"Commit changes"**.

**Est-ce que tu veux que j'ajoute une section spécifique sur la manière de configurer un compte Gmail ou Outlook pour ce script ?**
