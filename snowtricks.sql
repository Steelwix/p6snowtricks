-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 23 août 2022 à 10:24
-- Version du serveur : 8.0.29
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220629195523', '2022-07-06 12:51:03', 260),
('DoctrineMigrations\\Version20220630095129', '2022-07-06 12:51:46', 98),
('DoctrineMigrations\\Version20220704132210', '2022-07-06 12:53:36', 61),
('DoctrineMigrations\\Version20220706170435', '2022-07-06 17:04:42', 105),
('DoctrineMigrations\\Version20220706181657', '2022-07-06 18:17:02', 62),
('DoctrineMigrations\\Version20220711121635', '2022-07-11 12:17:00', 520),
('DoctrineMigrations\\Version20220713133118', '2022-07-13 13:31:32', 213),
('DoctrineMigrations\\Version20220719224749', '2022-07-19 22:48:16', 214),
('DoctrineMigrations\\Version20220720144635', '2022-07-20 14:46:47', 208),
('DoctrineMigrations\\Version20220721150709', '2022-07-21 15:07:19', 268),
('DoctrineMigrations\\Version20220722144710', '2022-07-22 14:47:23', 208),
('DoctrineMigrations\\Version20220812215038', '2022-08-12 21:50:46', 707),
('DoctrineMigrations\\Version20220815171223', '2022-08-15 17:12:30', 513);

-- --------------------------------------------------------

--
-- Structure de la table `illustration`
--

DROP TABLE IF EXISTS `illustration`;
CREATE TABLE IF NOT EXISTS `illustration` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_trick_id` int DEFAULT NULL,
  `id_media_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D67B9A42E25A52BB` (`id_trick_id`),
  UNIQUE KEY `UNIQ_D67B9A42BA4431E0` (`id_media_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `illustration`
--

INSERT INTO `illustration` (`id`, `id_trick_id`, `id_media_id`) VALUES
(40, 2, 102),
(41, 8, 103),
(42, 9, 104),
(43, 6, 105),
(44, 4, 106),
(45, 49, 107),
(46, 10, 108),
(47, 1, 109),
(48, 7, 110),
(49, 5, 111),
(79, 98, 205),
(80, 102, 206),
(81, 100, 207),
(82, 103, 208),
(83, 105, 209),
(84, 101, 210),
(85, 99, 211);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_trick_id` int NOT NULL,
  `media_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10CE25A52BB` (`id_trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `id_trick_id`, `media_name`) VALUES
(102, 2, '9cc9be4436053a28a0b9ba51e32dd063.jpg'),
(103, 8, 'e2e27a9ea5d3201ecbdb93511850574d.jpg'),
(104, 9, 'c69b40d30000e376948349d96f53044e.jpg'),
(105, 6, '0bf17e2cecb50021f182344038af49be.png'),
(106, 4, 'f71e59fdac3fb96c2221d17ae4807f25.jpg'),
(107, 49, '0d78af0e7e3b34906b68dae615489c71.jpg'),
(108, 10, '5ee5c322d894cb570682d51fa0ca1bbc.jpg'),
(109, 1, '12dc90ffd237ebd8fc16d086fd5550a7.jpg'),
(110, 7, '1d83f2dc6f010e357c410c55c95262fa.jpg'),
(111, 5, 'a1835db0f126273497aedd405f5f6043.jpg'),
(205, 98, '4c54c90cb96dc684c63c451acb909529.jpg'),
(206, 102, 'cf454ea624b5eb3ca19c63a5f122767a.jpg'),
(207, 100, 'c906da8f7081b1f867d1ecc9a4c6bd8c.jpg'),
(208, 103, '4eeb68187ff917b53e7052cb30d86c70.jpg'),
(209, 105, '5b5993ec28c88e936e240fdf9e3611e9.jpg'),
(210, 101, '9d11282443d3e39c0ce8439bae003802.jpg'),
(211, 99, '22603ae59332dbf2b8b244222c363707.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int NOT NULL,
  `content` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_trick_id` int NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF675F31B` (`author_id`),
  KEY `IDX_B6BD307FE25A52BB` (`id_trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `author_id`, `content`, `id_trick_id`, `date`) VALUES
(1, 1, 'J\'ai mangé la neige en essayant', 2, '2022-07-14 11:27:58'),
(2, 1, 'Mute comme dans R6?', 1, '2022-07-14 11:28:30'),
(5, 1, 'Ca me paraissait dur mais j\'ai réussi', 5, '2022-07-14 11:28:30'),
(6, 1, 'J\'ai pas compris je me suis coincé la main dans le toaster', 6, '2022-07-14 11:28:30'),
(7, 1, 'EZ', 7, '2022-07-14 11:28:30'),
(8, 1, 'no scope', 8, '2022-07-14 11:28:30'),
(9, 1, 'Le classicos', 9, '2022-07-14 11:28:30'),
(10, 1, 'giga oldschool', 10, '2022-07-14 11:28:30'),
(11, 1, 'oui', 2, '2022-07-14 16:59:07'),
(13, 1, 'Je comprends pas', 4, '2022-07-14 17:00:27'),
(14, 1, 'Qui a réussi?', 4, '2022-07-14 17:14:37'),
(15, 1, 'Tellement complexe', 4, '2022-07-14 17:18:23'),
(16, 1, 'Ca marhce la?', 4, '2022-07-14 17:26:19'),
(24, 1, 'ZEBACKFLI¨P', 9, '2022-07-15 06:31:10'),
(25, 1, 'Et la?', 9, '2022-07-15 06:32:30'),
(53, 26, 'Vraiment ez', 2, '2022-08-23 09:47:05'),
(54, 1, 'En vrai c\'est pas si simple', 2, '2022-08-23 10:09:39'),
(55, 26, 'Pour débuter, il faut déjà bien comprendre comment gerer son équilibre', 2, '2022-08-23 10:10:22'),
(56, 26, 'Après c\'est bien de s\'entrainer à l\'arret sur du plat', 2, '2022-08-23 10:10:51'),
(57, 1, 'J\'y arrive sur du plat mais j\'ai essayé après une bosse', 2, '2022-08-23 10:12:36'),
(58, 1, 'J\'ai vu un gars le faire en sautant, il a failli se prendre un arbre', 2, '2022-08-23 10:14:26'),
(59, 26, 'Je crois que c\'était moi mdr, t\'es ou la? Cauterets?', 2, '2022-08-23 10:14:50'),
(60, 1, 'Oui ptdrr on va a la taverne de l\'aubergiste a 18h?', 2, '2022-08-23 10:15:23'),
(61, 26, 'Lets go', 2, '2022-08-23 10:15:39'),
(62, 26, 'Snowtricks nouveau vecteur d\'amitié', 2, '2022-08-23 10:16:15');

-- --------------------------------------------------------

--
-- Structure de la table `profile_picture`
--

DROP TABLE IF EXISTS `profile_picture`;
CREATE TABLE IF NOT EXISTS `profile_picture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C5659115A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profile_picture`
--

INSERT INTO `profile_picture` (`id`, `user_id`, `name`) VALUES
(18, 26, '2c3610ac0451020b2adc0f7b7a626d34.jpg'),
(19, 1, '3bda65218aaa9f0e1c5ea55ebd146b25.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trick_group_id` int NOT NULL,
  `author_id` int NOT NULL,
  `trick_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL,
  `modification_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8F0A91E9B875DF8` (`trick_group_id`),
  KEY `IDX_D8F0A91EF675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `trick_group_id`, `author_id`, `trick_name`, `description`, `slug`, `creation_date`, `modification_date`) VALUES
(1, 1, 26, 'Mute', 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant', 'mute', '2022-08-01', '2022-08-17'),
(2, 2, 26, '180', 'Un demi-tour, soit 180 degrés d\'angle', '180', '2022-08-02', '2022-08-17'),
(4, 4, 26, 'Corkscrew', '...', 'corkscrew', '2022-08-03', '2022-08-17'),
(5, 5, 26, 'Nose slide', 'Glisser sur une barre de slide avec l\'avant de la planche .', 'nose slide', '2022-08-04', '2022-08-22'),
(6, 7, 26, 'Backside Air', '...', 'backside air', '2022-08-05', '2022-08-17'),
(7, 1, 26, 'Nose grab', 'Saisie de la partie avant de la planche, avec la main avant', 'nose grab', '2022-08-06', '2022-08-17'),
(8, 2, 26, '360', '\"Trois six\" pour un tour complet', '360', '2022-08-07', '2022-08-17'),
(9, 3, 26, 'Back flip', 'Rotation verticale en arrière', 'back-flip', '2022-08-08', '2022-08-22'),
(10, 7, 26, 'Method Air', '...', 'method air', '2022-08-09', '2022-08-17'),
(49, 1, 26, 'Front flip', 'Rotation verticale avant', 'front-flip', '2022-08-10', '2022-08-22'),
(98, 5, 1, '50 - 50', 'The 50-50 introduces you to snowboard slide tricks. When you approach a rail or box, jump to land on it and ride it until you come off at the other end. Start with short rails until you build the balance you need to ride longer ones.', '50---50', '2022-08-23', '2022-08-23'),
(99, 1, 1, 'Tail Press', 'Practice the tail press on a flat surface where you feel comfortable. Get a little speed going before you lean backward to shift your weight to your back leg. You can lift your front leg to emphasize the bend in your snowboard.\r\n\r\nOnce you get the hang of tail presses on flat surfaces, you can take them just about anywhere. Eventually, try adding them to a 50-50.', 'tail-press', '2022-08-23', '2022-08-23'),
(100, 2, 1, 'Butter', 'The butter takes a little more core strength than the frontside 180 and backside 180. Instead of bringing your back leg forward during a jump, you do it while maintaining contact with the snow. The snow creates a little more friction, so prepare to put some muscle into it.', 'butter', '2022-08-23', '2022-08-23'),
(101, 1, 1, 'Tail Grab', 'The next time you catch some air, reach back to grab the tail of your snowboard.', 'tail-grab', '2022-08-23', '2022-08-23'),
(102, 5, 1, 'Boardslide', 'The boardslide is like a 50-50, except you turn your board perpendicular to the rail so you can slide down it sideways.', 'boardslide', '2022-08-23', '2022-08-23'),
(103, 4, 1, 'Front Roll', 'The front roll moves your body in a forward motion, but it tilts a little to the side. Master it before moving on to a full front flip.', 'front-roll', '2022-08-23', '2022-08-23'),
(104, 7, 1, 'Tripod', 'The tripod is a fun intermediate trick to learn. To perform one, you need to lift one end of your board off the snow and reach down with both hands to contact the ground. When you do it correctly, you make a three-point connection with the ground, just like a tripod!', 'tripod', '2022-08-23', NULL),
(105, 1, 1, 'Indy', 'You can perform an Indy by doing an Ollie off of a jump and reaching down to grab your board’s toe edge. Let go and reposition yourself for a smooth landing.', 'indy', '2022-08-23', '2022-08-23');

-- --------------------------------------------------------

--
-- Structure de la table `trick_group`
--

DROP TABLE IF EXISTS `trick_group`;
CREATE TABLE IF NOT EXISTS `trick_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trick_group_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_group`
--

INSERT INTO `trick_group` (`id`, `trick_group_name`) VALUES
(1, 'Grab'),
(2, 'Rotation'),
(3, 'Flip'),
(4, 'Rotation désaxé'),
(5, 'Slide'),
(6, 'One foot trick'),
(7, 'Old school');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` longblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`, `image`, `is_verified`, `reset_token`, `avatar`) VALUES
(1, 'Steelwix', '[]', '$2y$13$cqY4ZvuxqI89Pu9LQrUih.OYjFs7pcNsj0xlXKj1aB4FXS0APg83i', 'mhunmael@hotmail.com', '', 1, NULL, NULL),
(26, 'Mael', '[]', '$2y$13$Hc8110kWIexcmz4vhBkaA.B9497SeEx5jwJAIIL6ZYlZ2XrAwqWMS', 'maelmhun@gmail.com', NULL, 1, NULL, NULL),
(29, 'BadOmen', '[]', '$2y$13$2FgLU448qyZapkekBH261uXVQIvNUdCmfZe7j3xEdLs141uFI/IES', 'exagon3D@gmail.com', NULL, 1, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_trick_id` int NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CE25A52BB` (`id_trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `illustration`
--
ALTER TABLE `illustration`
  ADD CONSTRAINT `FK_D67B9A42BA4431E0` FOREIGN KEY (`id_media_id`) REFERENCES `media` (`id`),
  ADD CONSTRAINT `FK_D67B9A42E25A52BB` FOREIGN KEY (`id_trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10CE25A52BB` FOREIGN KEY (`id_trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FE25A52BB` FOREIGN KEY (`id_trick_id`) REFERENCES `trick` (`id`),
  ADD CONSTRAINT `FK_B6BD307FF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `profile_picture`
--
ALTER TABLE `profile_picture`
  ADD CONSTRAINT `FK_C5659115A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E9B875DF8` FOREIGN KEY (`trick_group_id`) REFERENCES `trick_group` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CE25A52BB` FOREIGN KEY (`id_trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
