# Documentation de la branche : mail
## Projet : PRJ3_1

Cette branche est dédiée à l'intégration et à la gestion du système d'envoi de courriels au sein de l'application. Elle remplace les méthodes d'envoi standards par une solution plus robuste et compatible avec les serveurs de messagerie modernes.

---

### Architecture du module
La structure est centralisée dans le répertoire des ressources partagées du projet. Elle se compose de deux éléments principaux :

* **Bibliothèque de gestion SMTP** : Intégration de PHPMailer pour assurer la compatibilité avec les protocoles de sécurité actuels.
* **Interface de configuration** : Le fichier mail.php regroupe l'ensemble des paramètres nécessaires à la connexion.

---

### Fonctionnalités implémentées
* **Authentification sécurisée** : Support complet des chiffrements TLS et SSL.
* **Compatibilité HTML** : Capacité à générer des messages structurés avec mise en forme.
* **Gestion des erreurs** : Suivi pour identifier les échecs d'envoi liés au réseau ou aux identifiants.

---

### Guide d'utilisation
1. **Initialisation** : Vérifier la présence du dossier PHPMailer dans le répertoire des inclusions.
2. **Paramétrage** : Éditer les variables d'hôte, de port et les identifiants dans le fichier principal.
3. **Appel du module** : Inclure le fichier de configuration dans les scripts de notification.
