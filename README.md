📧 Module de Gestion des Emails
Projet : PRJ3_1 | Branche : mail
Ce module centralise toute la logique d'envoi de courriels automatique pour l'application. Il a été conçu pour offrir une alternative fiable et sécurisée à l'envoi d'emails standard.

🛠️ Composants Principaux
Le système repose sur deux piliers majeurs situés dans le dossier /includes :

Moteur d'envoi (PHPMailer) : Intégration d'une bibliothèque professionnelle pour garantir que les messages arrivent en boîte de réception et non en spams.

Script de Configuration (mail.php) : Le point central qui gère la connexion au serveur de messagerie (SMTP).

✨ Fonctionnalités Clés
Authentification Sécurisée : Support des protocoles de sécurité modernes pour protéger les identifiants d'envoi.

Formatage Riche : Capacité d'envoyer des emails personnalisés avec du texte mis en forme (HTML).

Polyvalence : Utilisable partout dans le projet, que ce soit pour les notifications d'administration ou les confirmations clients.

📖 Guide d'Installation Rapide
Vérification : S'assurer que le dossier PHPMailer est bien présent dans /includes.

Paramétrage : Renseigner les informations de votre fournisseur mail (Hôte, Port, Identifiants) dans le fichier de configuration.

Déploiement : Appeler le module dans les pages souhaitées (ex: formulaires de contact ou gestion des réservations).
