# GIMI - Gestion Intelligente des Médicaments Injectables

## Description
GIMI est une application web développée pour améliorer la gestion des perfusions médicamenteuses dans les services hospitaliers. Ce projet a été mené par 12 étudiants de l'École Centrale de Lille en collaboration avec le CHU de Lille et le laboratoire CRIStAL. L'objectif est de réduire les nuisances sonores liées aux alarmes et de limiter les incompatibilités médicamenteuses lors d'injections multiples.

## Fonctionnalités principales

### 1. Réduction des alarmes
- **Tableau de bord des injections** : Visualisation en temps réel des perfusions en cours, hiérarchisées par priorité (couleurs : vert, jaune, rouge, blanc, bleu).
- **Notifications proactives** : Alertes sur les fins d'injection imminentes.

### 2. Gestion des incompatibilités médicamenteuses
- **Test de compatibilité** : Vérification des interactions potentielles entre plusieurs médicaments.
- **Avertissements en cas d'incompatibilité** : Signalisation lors de l'ajout d'une injection incompatible.

## Installation et configuration

### Prérequis
- [XAMPP](https://www.apachefriends.org/fr/index.html) (serveur Apache et MySQL).

### Étapes d'installation

#### 1. Installer XAMPP
- Télécharger et installer XAMPP.
- Lancer Apache et MySQL depuis le panneau de contrôle de XAMPP.

#### 2. Configurer les fichiers de l'application
- Copier les fichiers du projet dans `C:\xampp\htdocs\GIMI`.

#### 3. Initialiser la base de données
- Accéder à [phpMyAdmin](http://localhost/phpmyadmin).
- Créer une base de données nommée `gimi`.
- Importer le fichier `gimi.sql` situé dans `assets`.
#### 4. Lancer l'application
- Ouvrir un navigateur et accéder à `http://localhost/GIMI`.
- Utiliser les identifiants définis dans la table `users` pour se connecter.

## Structure technique

### Front-End
- Langages : HTML, CSS (via Tailwind), JavaScript (AJAX).
- Composants réutilisables : `head.php`, `sidebar.php`, etc.

### Back-End
- Langages : PHP, SQL.
- Programmation orientée objet : Classes `Patient`, `Injection`, et `PdoMySQL`.

### Base de données
- Tables principales :
  - `users` : Gestion des utilisateurs.
  - `patients` : Informations sur les patients.
  - `injections` : Données des perfusions.
  - `compatibilities` : Gestion des compatibilités médicamenteuses.
