- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 11 fév. 2024 à 13:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
starting_date TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gimi`
--

-- --------------------------------------------------------

--
-- Structure de la table `injections`
--

CREATE TABLE `injections` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `hardware_id` varchar(16) NOT NULL,
  `volume` float NOT NULL,
  `flow_rate` float NOT NULL,
  `medication` varchar(64) NOT NULL,
  `concentration` float NOT NULL,
  `date` datetime NOT NULL,
  `moderate_threshold` float NOT NULL,
  `severe_threshold` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `injections`
--

INSERT INTO `injections` (`id`, `patient_id`, `user_id`, `hardware_id`, `volume`, `flow_rate`, `medication`, `concentration`, `date`, `moderate_threshold`, `severe_threshold`) VALUES
(1, '1', 'antoinewauthier08', '1', 1000, 5000, 'ACYCLOVIR', 1, '2024-02-11 13:10:00', 0.25, 0.1),
(2, '1', 'antoinewauthier08', '10', 11000, 1000, 'CEFUROXIME', 10000, '2024-02-11 13:10:00', 0.25, 0.1);

-- --------------------------------------------------------

--
-- Structure de la table `medications`
--

CREATE TABLE `medications` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medications`
--

INSERT INTO `medications` (`id`, `name`) VALUES
(1, 'ACYCLOVIR'),
(2, 'CEFUROXIME'),
(3, 'METRONIDAZOLE');

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `room` varchar(16) NOT NULL,
  `bed` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `room`, `bed`) VALUES
(1, 'R', 'D', '1', '1');

-- --------------------------------------------------------

--
-- Structure de la table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `injection_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tasks`
--

INSERT INTO `tasks` (`id`, `injection_id`, `type`, `done`, `user_id`) VALUES
(4, 1, 'danger', 0, 'antoinewauthier08');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `wing` varchar(64) NOT NULL,
  `sector` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `wing`, `sector`) VALUES
('antoinewauthier08', 'abc', 'Antoine', 'Wauthier', 'A', 'B');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `injections`
--
ALTER TABLE `injections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `injections`
--
ALTER TABLE `injections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
