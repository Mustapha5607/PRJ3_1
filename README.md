# 1PRJ3
1PRJ3 (Projet Unité 2 - B1 Ecole-IT)

# Projet ITbeauty: Application Web de Réservation de Services

## Présentation du projet

ItBeauty est une application web de réservation pour un salon de beauté. Elle permet aux clients de réserver des services, et au personnel administratif de gérer les réservations via un espace admin sécurisé.
L’application est développée en PHP avec une base de données MySQL, et utilise XAMPP pour le serveur local. Un système de notifications par email est intégré avec des templates HTML professionnels.

***Ce projet a été réalisé dans le cadre du module 1PRJ3 du Bachelor 1 de l'Ecole-IT de Valenciennes afin de mettre en pratique les notions fondamentales de programmation web côté client et côté serveur.***

## Objectifs pédagogiques

Les principaux objectifs de ce projet sont :

- Comprendre la structure d’une application web simple
- Manipuler HTML et CSS pour la création d’une interface utilisateur
- Utiliser PHP pour traiter les données côté serveur
- Mettre en place une connexion à une base de données MySQL
- Enregistrer et récupérer des informations depuis une base de données
- Utiliser Git et GitHub pour le suivi des versions du projet

## Technologies utilisées

- Visual studio code : environnement de programation
- HTML : structure des pages web
- CSS : mise en forme et design de l’interface
- PHP : gestion de la logique applicative et des réservations
- MySQL : stockage des données (services, disponibilités, réservations)
- XAMPP : environnement de développement local (Apache + MySQL)
- Git / GitHub : gestion de version et partage du projet

## Structure du projet
````
itbeauty/                     # Nom du fichier du projet
│
├─ index.html                 # Page d’accueil / réservation
├─ reservation.php            # Traitement des réservations
├─ style.css                  # Styles CSS du site
├─ connexion.php              # Connexion à la base de données
├─ salon_reservation.sql      # Script SQL pour créer la BDD
│
├─ admin/                     # Dossier Admin
│   ├─ index.php              # Page principale admin (tableau de réservations)
│   ├─ login.php              # Page de connexion admin
│   ├─ logout.php             # Déconnexion
│   ├─ admin.php              # Gestion des actions (valider/annuler)
│   ├─ config.php             # Configuration des identifiants de connexion
│   ├─ dashboard.php          # Page dashboard (statistiques, accueil admin)
│   ├─ disponibilites.php     # Gestion des disponibilités
│   ├─ mail.php               # Envoi d’emails
│   ├─ securite.php           # Gestion des sessions et sécurités
│   └─ templates/
│       └─ email_template.html # Template HTML email
````
## Structure de la base de données SQL
````
┌───────────────┐      ┌───────────────────────┐      ┌─────────────────────┐
│   services    │      │    reservations       │      │   disponibilites    │
├───────────────┤      ├───────────────────────┤      ├─────────────────────┤
│ id  (PK)      │<-----│ service_id  (FK)      │      │ id  (PK)           │
│ nom           │      │ date_rdv              │      │ jour_semaine        │
│ description   │      │ heure_rdv             │      │ heure_debut         │
│ duree_minutes │      │ nom_client            │      │ heure_fin           │
│ prix_euros    │      │ email_client          │      │ actif               │
└───────────────┘      │ telephone             │      └─────────────────────┘
                       |    statut             |   
                        └───────────────────────┘
````
### Installation et utilisation
1. Installer XAMPP (Apache + MySQL + PHP).

2. Copier le dossier itbeauty dans le dossier htdocs de XAMPP  : ````C:\xampp\htdocs\itbeauty````

3.Créer la base de données :
Importer le fichier ````salon_reservation.sql```` via phpMyAdmin.

4. Modifier ````connexion.php````et ````admin/config.php```` si nécessaire pour adapter le nom de la BDD, utilisateur et mot de passe.

5. Lancer XAMPP et démarrer Apache et MySQL.

6. Accéder à l’application :
Client : http://localhost/itbeauty/index.html
Admin : http://localhost/itbeauty/admin/login.php

## Fonctionnalités principales

**Pour les clients:**
- Page de réservation avec choix du service, date et heure.
- confirmation de réservation
- Réception automatique d’un email de confirmation (template HTML avec logo, détails de la réservation).

**Pour l’administrateur:**

- Page login sécurisée
- Gestion des sessions admin.
- Tableau de bord avec toutes les réservations.
- Actions sur les réservations :
Valider ou Annuler
- Déconnexion avec retour à la page d’accueil.
- Email de confirmation au client.
- Email de notification au salon
- Template HTML professionnel (admin/templates/email_template.html) avec logo et informations complètes (client, service, date, heure).
  
# Auteur

Projet réalisé par Aboubakr Sidick Sidibe et Mustapha-Yacine Antitene.
