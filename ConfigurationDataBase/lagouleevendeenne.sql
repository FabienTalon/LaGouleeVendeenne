-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3307
-- Généré le : lun. 22 mai 2023 à 18:55
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lagouleevendeenne`
--

-- --------------------------------------------------------

--
-- Structure de la table `infospratiques`
--

CREATE TABLE `infospratiques` (
  `id` int(11) NOT NULL,
  `weekend_day` tinyint(1) DEFAULT NULL,
  `horairesmatin` varchar(255) NOT NULL,
  `horairessoir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `infospratiques`
--

INSERT INTO `infospratiques` (`id`, `weekend_day`, `horairesmatin`, `horairessoir`) VALUES
(1, 0, '12h00 - 14h00', '19h00-22h00'),
(2, 1, '12h00 - 14h00', '19h00-22h30');

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

CREATE TABLE `plats` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `nature_plats` varchar(10) NOT NULL,
  `prix` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `titre`, `description`, `nature_plats`, `prix`) VALUES
(1, 'Soupe des Mariés', 'Soupe à l\'oignon traditionnelle vendéenne, gratinée à l\'emmental, jarret de porc et cive.', 'entrees', '4.30 euros'),
(2, 'Préfou', 'Ail / Chèvre / Chorizo / Roquefort / Tomates séchées.', 'entrees', '3.50 euros'),
(3, 'Fressure de porc et salade', 'Fressure de porc, accompagnée de sa salade fraicheur, graines de pin.', 'entrees', '3.70 euros'),
(4, 'Briochine vendéenne, cœur de foie gras', 'Briochine coeur de foie gras grillé, pomme rôtie, gelée de coing ou de figue.', 'entrees', '4.20 euros'),
(5, 'Grimâte et huîtres de vendées', 'Fraise de porc cuite en friture, huitres de Noirmoutier.', 'entrees', '8.20 euros'),
(6, 'Grillons Vendéens', 'Grillons de porc, revenus au saindoux, salé et poivrés.', 'entrees', '3.40 euros'),
(7, 'La Boudine', 'Boudine grillée accompagnée de potirons gris rôtis / Pommes / Pommes de terres de Noirmoutier', 'plats', '12.50 euros'),
(8, 'Mouclade', 'Moules de bouchot marinières, sauce au vin blanc, crème fraiche, jaune d’oeuf et curry.', 'plats', '16.80 euros'),
(9, 'Potée Vendéenne', 'Potée de choux vert, carottes, oignons, Pommes de terre de Noirmoutier, poitrine et jarets de porc.', 'plats', '12.50 euros'),
(10, 'Jambon de Vendée et mogettes', 'Jambon de Vendée grillé à la poêle accompagné de ses mogettes.', 'plats', '13.70 euros'),
(11, 'Sardines de saint gilles Croix de Vie grillées', 'Sardines à la plancha accompagnées de pommes de terre grenailles.', 'plats', '14.60 euros'),
(12, 'Poularde au pot', 'Poule au pot, crevettes grillées, poêlé de légumes.', 'plats', '16.50 euros'),
(13, 'La Bignaïe', 'Crêpe épaisse garnie au lard, accompagnée de ses légumes de saison, percil, cive.', 'plats', '14.20 euros'),
(14, 'Gâche ou Brioche Vendéenne', 'Gâche Vendéenne ou brioche Vendéenne tressée, dorée au jaune d’oeuf.', 'desserts', '3.70 euros'),
(15, 'Tourtisseaux', 'Beignets Vendéens, saupoudrés de sucre glace et cannelle.', 'desserts', '3.50 euros'),
(16, 'Fion Vendéen', 'Flan cuit au pot, vanille Bourbon, zeste de citron, cannelle. Miel / caramel / gelée de coing / fruits rouges.', 'desserts', '3.40 euros'),
(17, 'Gateau minute', 'Gateau minute, vanille Bourbon, cannelle.', 'desserts', '2.70 euros'),
(18, 'Tarte aux Pruneaux', 'Garniture au pruneaux et à l\'eau de vie de mirabelle, saupoudré de sucre semoule.', 'desserts', '3.60 euros'),
(19, 'Caillebotte Vendéenne', 'Caillebotte au lait de vache, cives, canelle, miel.', 'desserts', '3.40 euros'),
(20, 'Moelleux Kamok', 'Moelleux au Kamok (liqueur de café Vendéenne) façon tiramisu.', 'desserts', '4.10 euros'),
(21, 'Les Vins Rouges et Blancs', 'Vins de Mareuil rouges / rosés, vins de Brem blancs / rosés, vins de Chantonnay rouges / rosés / blancs, vin de Vix rouges, vins de Pissote rosés / blancs .', 'boissons', 'Voir Prix à la carte'),
(22, 'Les Apéritifs et Digestifs de Vendée', 'Troussepinette, Chouanette, Liqueur des Chouans, Kamok, Bières locales : Brasserie Mélusine / Brasserie de la Cibulle.', 'boissons', 'Voir Prix à la carte'),
(23, 'Les Softs', 'Pepsi / Pepsi Max / Sans sucre (33cl), Ice Tea (25cl), Schweppes agrumes (25cl), Schweppes  Tonic(25cl), Orangina (25cl), Jus de Fruits Orange/ Ananas/ Pomme/ Fraise (25cl), Thé glacé maison.', 'boissons', '3,50 euros'),
(24, 'Les Boissons Chaudes', 'Café, Café Gourmand, Thé Citron / Menthe / Fruits Rouges, Chocolat Chaud.', 'boissons', '1,50 euros'),
(25, 'Formule de la mer', 'Grimâte et huîtres de vendées / Sardines de saint gilles Croix de Vie grillées / Moelleux Kamok. (Du lundi au samedi soir)', 'formules', '22 euros'),
(26, 'Formule d\'antan', 'Soupe des Mariés / Boudine / Tarte aux Pruneaux. (Du lundi au samedi soir)', 'formules', '20 euros'),
(27, 'Formule tradition', 'Grillons Vendéens / Jambon de Vendée et mogettes / Caillebotte Vendéenne. (Du lundi au samedi soir)', 'formules', '18 euros');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `heure` varchar(5) NOT NULL,
  `nombre_personnes` int(11) NOT NULL,
  `allergie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  `est_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `infospratiques`
--
ALTER TABLE `infospratiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plats`
--
ALTER TABLE `plats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `infospratiques`
--
ALTER TABLE `infospratiques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `plats`
--
ALTER TABLE `plats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
