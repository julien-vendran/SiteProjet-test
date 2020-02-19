-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 11 oct. 2019 à 17:23
-- Version du serveur :  5.5.47-0+deb8u1
-- Version de PHP :  7.2.22-1+0~20190902.26+debian8~1.gbpd64eb7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rouzest`
--

-- --------------------------------------------------------

--
-- Structure de la table `Disponibilites`
--

CREATE TABLE `Disponibilites` (
  `Enseignant` varchar(32) NOT NULL,
  `Disponibilites` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `GroupeProjet`
--

CREATE TABLE `GroupeProjet` (
  `idGroupe` int(11) NOT NULL,
  `chefGroupe` varchar(32) NOT NULL,
  `idProjet` varchar(32) DEFAULT NULL,
  `dateSoutenance` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Planning`
--

CREATE TABLE `Planning` (
  `id` int(11) NOT NULL,
  `Titre` varchar(1000) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Description` varchar(1000) NOT NULL,
  `idPromo` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Projets`
--

CREATE TABLE `Projets` (
  `idProjet` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `remarques` text,
  `tuteur` varchar(32) NOT NULL,
  `tuteur_bis` varchar(32) DEFAULT NULL,
  `actif` tinyint(4) NOT NULL,
  `idPromo` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `login` varchar(32) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `idGroupe` int(11) DEFAULT NULL,
  `idClasse` varchar(32) DEFAULT NULL,
  `idPromo` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Voeux`
--

CREATE TABLE `Voeux` (
  `idGroupe` int(16) NOT NULL,
  `idProjet` int(16) NOT NULL,
  `classement` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Disponibilites`
--
ALTER TABLE `Disponibilites`
  ADD KEY `idUtilisateur` (`Enseignant`);

--
-- Index pour la table `GroupeProjet`
--
ALTER TABLE `GroupeProjet`
  ADD PRIMARY KEY (`idGroupe`),
  ADD KEY `chefGroupe` (`chefGroupe`,`idProjet`),
  ADD KEY `chefGroupe_2` (`chefGroupe`),
  ADD KEY `idProjet` (`idProjet`);

--
-- Index pour la table `Planning`
--
ALTER TABLE `Planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPromo` (`idPromo`);

--
-- Index pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD PRIMARY KEY (`idProjet`),
  ADD KEY `tuteur` (`tuteur`),
  ADD KEY `tuteur_2` (`tuteur`),
  ADD KEY `tuteur_bis` (`tuteur_bis`),
  ADD KEY `idPromo` (`idPromo`),
  ADD KEY `idPromo_2` (`idPromo`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`login`),
  ADD KEY `idGroupe` (`idGroupe`),
  ADD KEY `idGroupe_2` (`idGroupe`),
  ADD KEY `idGroupe_3` (`idGroupe`),
  ADD KEY `idPromo` (`idPromo`);

--
-- Index pour la table `Voeux`
--
ALTER TABLE `Voeux`
  ADD KEY `idProjet` (`idProjet`),
  ADD KEY `idGroupe` (`idGroupe`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `GroupeProjet`
--
ALTER TABLE `GroupeProjet`
  MODIFY `idGroupe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Planning`
--
ALTER TABLE `Planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Projets`
--
ALTER TABLE `Projets`
  MODIFY `idProjet` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Disponibilites`
--
ALTER TABLE `Disponibilites`
  ADD CONSTRAINT `fk_dispo` FOREIGN KEY (`Enseignant`) REFERENCES `Utilisateurs` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `GroupeProjet`
--
ALTER TABLE `GroupeProjet`
  ADD CONSTRAINT `fk_idProjet` FOREIGN KEY (`idProjet`) REFERENCES `Utilisateurs` (`idPromo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_GroupChiefUser` FOREIGN KEY (`chefGroupe`) REFERENCES `Utilisateurs` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Planning`
--
ALTER TABLE `Planning`
  ADD CONSTRAINT `Planning_ibfk_1` FOREIGN KEY (`idPromo`) REFERENCES `Utilisateurs` (`idPromo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD CONSTRAINT `fk_promoId` FOREIGN KEY (`idPromo`) REFERENCES `Utilisateurs` (`idPromo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_creator` FOREIGN KEY (`tuteur`) REFERENCES `Utilisateurs` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tutor_bis` FOREIGN KEY (`tuteur_bis`) REFERENCES `Utilisateurs` (`login`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD CONSTRAINT `fk_appartientGroupe` FOREIGN KEY (`idGroupe`) REFERENCES `GroupeProjet` (`idGroupe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Voeux`
--
ALTER TABLE `Voeux`
  ADD CONSTRAINT `Voeux_ibfk_2` FOREIGN KEY (`idProjet`) REFERENCES `Projets` (`idProjet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Voeux_ibfk_1` FOREIGN KEY (`idGroupe`) REFERENCES `GroupeProjet` (`idGroupe`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
