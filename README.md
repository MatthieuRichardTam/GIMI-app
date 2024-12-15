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

## Captures d'écran et explication des pages

### Page de connexion
![Page de connexion](screenshots/login_page.png)
La page de connexion permet aux utilisateurs de s'authentifier avec leur nom d'utilisateur et mot de passe. Une fois connectés, ils sont redirigés vers le tableau de bord principal.

### Tableau de bord
![Tableau de bord](screenshots/dashboard.png)
Le tableau de bord présente les perfusions en cours, classées par priorité. Les patients avec des perfusions urgentes apparaissent en haut de la liste. Les injections sont colorées selon leur statut :
- **Vert** : Injection récemment commencée.
- **Jaune** : Injection proche de sa fin.
- **Rouge** : Injection nécessitant une intervention immédiate.

### Page de test de compatibilité
![Test de compatibilité](screenshots/compatibility_page.png)
Cette page permet de vérifier les incompatibilités entre plusieurs médicaments. Les utilisateurs sélectionnent les médicaments via un menu déroulant, et le système affiche les incompatibilités détectées.

### Page d'ajout de patients
![Ajout de patients](screenshots/add_patient.png)
Cette page permet d'ajouter de nouveaux patients à la base de données. Les utilisateurs renseignent le nom, prénom, date de naissance, chambre et lit du patient.

### Page d'ajout d'injections
![Ajout d'injections](screenshots/add_injection.png)
Les utilisateurs peuvent ajouter des injections pour un patient en précisant les détails tels que le médicament, le dosage, et le débit. Le système vérifie automatiquement les incompatibilités potentielles.

### Page des notifications
![Page des notifications](screenshots/notifications.png)
Cette page affiche les injections les plus urgentes, nécessitant une intervention immédiate. Les soignants peuvent prendre en charge une alarme et finaliser son traitement une fois terminé.
