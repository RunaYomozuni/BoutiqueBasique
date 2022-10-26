-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 oct. 2022 à 15:01
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutiquebasique`
--
CREATE DATABASE IF NOT EXISTS `boutiquebasique` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boutiquebasique`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `CLIENT_ID` int(11) NOT NULL,
  `CLIENT_PRENOM` varchar(50) NOT NULL,
  `CLIENT_NOM` varchar(50) NOT NULL,
  `CLIENT_NAISSANCE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`CLIENT_ID`, `CLIENT_PRENOM`, `CLIENT_NOM`, `CLIENT_NAISSANCE`) VALUES
(1, 'TOTO', 'DUPONT', '2002-09-29'),
(3, 'Hugo', 'DECRYPT', '2000-09-29'),
(4, 'Daniel', 'GAGNANT', '1994-07-25'),
(5, 'Melchior', 'CHEVALIER', '1989-02-27'),
(10, 'JEAN', 'PEUPLUS', '1921-10-02'),
(11, 'Mathias', 'GHANEM', '1969-06-07');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `COMMANDE_ID` int(11) NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `COMMANDE_DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`COMMANDE_ID`, `CLIENT_ID`, `COMMANDE_DATE`) VALUES
(1, 3, '2016-09-01'),
(2, 3, '2018-07-04'),
(3, 4, '2019-09-04'),
(4, 4, '2022-06-05');

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

CREATE TABLE `lignecommande` (
  `COMMANDE_ID` int(11) NOT NULL,
  `PRODUIT_ID` int(11) NOT NULL,
  `QUANTITE` int(11) NOT NULL,
  `PRIX` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `lignecommande`
--

INSERT INTO `lignecommande` (`COMMANDE_ID`, `PRODUIT_ID`, `QUANTITE`, `PRIX`) VALUES
(1, 1, 1, '1801'),
(1, 4, 1, '550'),
(2, 2, 2, '50'),
(3, 3, 2, '900'),
(4, 1, 1, '1801');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `PRODUIT_ID` int(11) NOT NULL,
  `PRODUIT_NOM` varchar(50) NOT NULL,
  `PRODUIT_PRIX` decimal(10,0) NOT NULL,
  `PRODUIT_IMAGE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`PRODUIT_ID`, `PRODUIT_NOM`, `PRODUIT_PRIX`, `PRODUIT_IMAGE`) VALUES
(1, 'super ordinateur', '1218', 'superordi.webp'),
(2, 'souris ergonomique', '40', 'sourisergo.jfif'),
(3, 'ecran plat 2m x 2m', '990', 'ecranplat.jpg'),
(4, 'enceinte sono ultra puissante', '580', 'enceintesono.jpg'),
(13, 'CLAVIER RETROECLAIRE', '190', 'clavier.webp'),
(19, 'SuperSouris', '27', 'supersouris.webp'),
(22, 'clef usb 20 go', '55', 'clefusbpro.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`CLIENT_ID`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`COMMANDE_ID`),
  ADD KEY `FK_CLIENT_COMMANDE` (`CLIENT_ID`);

--
-- Index pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD PRIMARY KEY (`COMMANDE_ID`,`PRODUIT_ID`),
  ADD KEY `FK_LIGNECOMMANDE_PRODUIT` (`PRODUIT_ID`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`PRODUIT_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `CLIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `COMMANDE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `PRODUIT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_CLIENT_COMMANDE` FOREIGN KEY (`CLIENT_ID`) REFERENCES `client` (`CLIENT_ID`);

--
-- Contraintes pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD CONSTRAINT `FK_LIGNECOMMANDE_COMMANDE` FOREIGN KEY (`COMMANDE_ID`) REFERENCES `commande` (`COMMANDE_ID`),
  ADD CONSTRAINT `FK_LIGNECOMMANDE_PRODUIT` FOREIGN KEY (`PRODUIT_ID`) REFERENCES `produit` (`PRODUIT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
