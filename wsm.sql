-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 23 jan. 2026 à 20:02
-- Version du serveur : 9.1.0
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wsm`
--

-- --------------------------------------------------------

--
-- Structure de la table `addons`
--

DROP TABLE IF EXISTS `addons`;
CREATE TABLE IF NOT EXISTS `addons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `version` varchar(255) DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `timestamp` int NOT NULL DEFAULT '0',
  `data` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('7o5tvh9dtid5pldrdkror4vbq1uqfujk', '127.0.0.1', 1766403242, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430333234323b6163746976655f7363686f6f6c5f69647c733a313a2232223b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('f1ldrsrudne2ajie80tiobgdngoqdos8', '127.0.0.1', 1766403337, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430333234323b),
('8ut94ciu5ngntok61vj8r1phbelf40ov', '127.0.0.1', 1766403697, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430333639373b),
('ulaqmibk4rtgcmcm8t57dusjbp7a91f8', '127.0.0.1', 1766404193, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430343139333b),
('rm4k4qt2644egrjln3v3dn0p593v2oqk', '127.0.0.1', 1766404338, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430343139333b6c616e67756167657c733a373a22656e676c697368223b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('anhsn1bs1eba852jaqen8hhq9dsn2a9r', '127.0.0.1', 1766404699, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430343639393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('eah5gk5e6othqrvfjejvqdak61sv2am9', '127.0.0.1', 1766405364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430353336343b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('tnkfqd5dri5ihr18g6o4jn7o99gcg50u', '127.0.0.1', 1766405672, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430353637323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('988mi2qrtk5aufe83r5ueu3s5q7a3c60', '127.0.0.1', 1766405974, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430353937343b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('ok1gtlppt9c3mgg291bnagc58tjefdpu', '127.0.0.1', 1766407333, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430373333333b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('j9dnvbkes73h90fcq0scqekks7valba9', '127.0.0.1', 1766407850, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430373835303b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('k0fgjmkeh354gp06763tuodp2ci2e2e8', '127.0.0.1', 1766408171, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430383137313b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('1fri07v2ta2b3v1cbc8i34g3o6p5qcd6', '127.0.0.1', 1766408529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430383532393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('67rlugeplbpk8fkm0u0i96bi1bm3atj4', '127.0.0.1', 1766409022, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430393032323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('qvo4ud6kcho1ukbtdh9f9fsh8fndvkri', '127.0.0.1', 1766409550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430393535303b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('c4f56sopbc90ib41j5b8m522iptb5ju9', '127.0.0.1', 1766409859, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363430393835393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('s7ismtophqmtp473t8rp5cfsn8g5e1u1', '127.0.0.1', 1766410165, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431303136353b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('fgrh02qm004cf2tmvkdks6q5feom1soi', '127.0.0.1', 1766410487, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431303438373b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('evmu4t1l9k4hto64vmmnistpqc5e6ksd', '127.0.0.1', 1766411099, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431313039393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('iv0s78bnnriuemt5fvm6m5jfumsc87qr', '127.0.0.1', 1766411982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431313938323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('ifh8v1n9v1e77k421s3oee594soco1bu', '127.0.0.1', 1766412346, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431323334363b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('30poudhb8audvirfg4fp4aifqo9irrn8', '127.0.0.1', 1766412822, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431323832323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('i7dq4movjobbe06vtf4vkbt22rsa087t', '127.0.0.1', 1766414779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431343737393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('7en8fv1hddfji53n2ru3shuarnsbe9mo', '127.0.0.1', 1766415142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431353134323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('4l8cphus4blbi63mir9uf7d62p8nbu63', '127.0.0.1', 1766415492, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431353439323b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('vkkb8vgmflarktd2ccop6gdaem4pq7vg', '127.0.0.1', 1766415805, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431353830353b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('noh2if468h3iknubta4d9ii94geukcoh', '127.0.0.1', 1766416588, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431363538383b757365725f6c6f67696e5f747970657c623a313b646f6e6f725f6c6f67696e7c623a313b757365725f69647c733a323a223131223b7363686f6f6c5f69647c733a313a2233223b757365725f6e616d657c733a32323a224d6f68616d656420656c686166656420436865696b68223b757365725f747970657c733a353a22646f6e6f72223b),
('71527pe026j4b1kok1pi23rb108h1vos', '127.0.0.1', 1766417456, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431373435363b757365725f6c6f67696e5f747970657c623a313b646f6e6f725f6c6f67696e7c623a313b757365725f69647c733a323a223131223b7363686f6f6c5f69647c733a313a2233223b757365725f6e616d657c733a32323a224d6f68616d656420656c686166656420436865696b68223b757365725f747970657c733a353a22646f6e6f72223b),
('f13k6vct6nno5dkuumljemjl8k0v1hvu', '127.0.0.1', 1766417776, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431373737363b757365725f6c6f67696e5f747970657c623a313b646f6e6f725f6c6f67696e7c623a313b757365725f69647c733a323a223131223b7363686f6f6c5f69647c733a313a2233223b757365725f6e616d657c733a32323a224d6f68616d656420656c686166656420436865696b68223b757365725f747970657c733a353a22646f6e6f72223b),
('41ij0go0170bf36ltnc07v4313rtnjll', '127.0.0.1', 1766418119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363431373939363b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('65j6erdgak9lb27grvdkv8iv9fftr608', '127.0.0.1', 1766526988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363532363933383b6163746976655f7363686f6f6c5f69647c733a313a2232223b757365725f6c6f67696e5f747970657c623a313b61646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b737570657261646d696e5f6c6f67696e7c623a313b),
('jumsnp91cv7bm0jpkup25i6q2oqj0liv', '127.0.0.1', 1766618368, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736363631383336333b6c616e67756167657c733a373a22656e676c697368223b666c6173685f6d6573736167657c733a32393a224c616e6775616765206368616e676564207375636365737366756c6c79223b5f5f63695f766172737c613a313a7b733a31333a22666c6173685f6d657373616765223b733a333a226f6c64223b7d),
('8k7k4q1u2v2impreibrrolfval6moku6', '127.0.0.1', 1768077879, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383037373837393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('qnjmun4ucmfvja6k8ug3mqs0v8nafb19', '127.0.0.1', 1768078375, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383037383337353b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('j3tss3a1gph42h8ji4fce4pm2uur6pba', '127.0.0.1', 1768078977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383037383937373b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('e9e0n38qo3m6e987g2vk2clko4j162cb', '127.0.0.1', 1768079204, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383037383937373b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('ta4ailrdp6iu6o8ne3ul7kei49fagd3i', '127.0.0.1', 1769001053, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313035333b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('hfg0538qet4kqhdpgvmlug90r79jo5pm', '127.0.0.1', 1769001056, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313035333b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('31b2e3cdo12hgarnv7u71tarha6q38qa', '127.0.0.1', 1769001471, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313437313b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('3v7o8ktrp80lj0p113024hfnhb7kvmrp', '127.0.0.1', 1769001475, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313437313b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('dideaf4fchthk58p3tqse3fnef2qmhhp', '127.0.0.1', 1769001684, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313438303b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('30kkaua4son43i7cvlqia9hhrot3n2ji', '127.0.0.1', 1769001819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030313639313b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('9ata4o4kkvgkv3g6pehm5aben0shehb3', '127.0.0.1', 1769002796, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030323739363b6163746976655f7363686f6f6c5f69647c733a313a2232223b),
('gg4fpmd7k260o4isoaq2v5mm107lj42u', '127.0.0.1', 1769002935, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030323739363b6163746976655f7363686f6f6c5f69647c733a313a2232223b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('09vbvppscj3q89n7uh0f65p1cg672ck5', '127.0.0.1', 1769003536, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030333533363b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('sctrf11e7qkak5llhhl6lpij8mvutvfg', '127.0.0.1', 1769003025, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030333032353b),
('9ulh1gg3ij1ev6a1devfpfl8crc4hlip', '127.0.0.1', 1769003536, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030333533363b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('1luhqh3bb3dpb1hdb7bpin78jg4c5e4n', '127.0.0.1', 1769004023, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393030333735393b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b),
('brv4rg31ucnjvf9kmsind4uavp6gs4t5', '127.0.0.1', 1769180707, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393138303637383b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a353a2261646d696e223b757365725f747970657c733a31303a22737570657261646d696e223b666c6173685f6d6573736167657c733a31323a2257656c636f6d65206261636b223b5f5f63695f766172737c613a313a7b733a31333a22666c6173685f6d657373616765223b733a333a226f6c64223b7d),
('uvl9th19o76qd6k65p500597nearhn3p', '127.0.0.1', 1769197961, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393139373936313b),
('at5h38aonabddbcids318djbjfcr646d', '127.0.0.1', 1769198458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393139383435383b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a393a2261646d696e31323334223b757365725f747970657c733a31303a22737570657261646d696e223b),
('g2olh18i5dipu5cdv9kludtftn9of9iq', '127.0.0.1', 1769198466, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736393139383435383b757365725f6c6f67696e5f747970657c623a313b737570657261646d696e5f6c6f67696e7c623a313b757365725f69647c733a313a2231223b7363686f6f6c5f69647c733a313a2231223b757365725f6e616d657c733a393a2261646d696e31323334223b757365725f747970657c733a31303a22737570657261646d696e223b);

-- --------------------------------------------------------

--
-- Structure de la table `common_settings`
--

DROP TABLE IF EXISTS `common_settings`;
CREATE TABLE IF NOT EXISTS `common_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `common_settings`
--

INSERT INTO `common_settings` (`id`, `type`, `description`) VALUES
(1, 'recaptcha_status', '0'),
(2, 'recaptcha_sitekey', 'enter-your-recaptcha-sitekey'),
(3, 'recaptcha_secretkey', 'enter-your-recaptcha-secretkey');

-- --------------------------------------------------------

--
-- Structure de la table `event_calendars`
--

DROP TABLE IF EXISTS `event_calendars`;
CREATE TABLE IF NOT EXISTS `event_calendars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `starting_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ending_date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `school_id` int DEFAULT NULL,
  `session` int DEFAULT NULL,
  `link` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `location` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `event_calendars`
--

INSERT INTO `event_calendars` (`id`, `title`, `starting_date`, `ending_date`, `school_id`, `session`, `link`, `location`) VALUES
(1, 'reunion 18', '17-12-2025', '17-12-2025', 1, 1, NULL, NULL),
(6, 'اجتماع مشروع الصحة', '12/20/2025 00:00:1', '12/20/2025 23:59:59', 2, 1, 'http://localhost/platformagg/superadmin/dashboard', 'افتراضي'),
(7, 'اجتماع أمس', '12/18/2025 00:00:1', '12/18/2025 23:59:59', 2, 1, '', 'انواكشوط');

-- --------------------------------------------------------

--
-- Structure de la table `frontend_events`
--

DROP TABLE IF EXISTS `frontend_events`;
CREATE TABLE IF NOT EXISTS `frontend_events` (
  `frontend_events_id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `timestamp` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0-inactive, 1-active',
  `school_id` int NOT NULL,
  `created_by` int NOT NULL,
  PRIMARY KEY (`frontend_events_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `frontend_events`
--

INSERT INTO `frontend_events` (`frontend_events_id`, `title`, `timestamp`, `status`, `school_id`, `created_by`) VALUES
(1, 'reunion', 1765994400, 1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `frontend_gallery`
--

DROP TABLE IF EXISTS `frontend_gallery`;
CREATE TABLE IF NOT EXISTS `frontend_gallery` (
  `frontend_gallery_id` int NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `date_added` int DEFAULT NULL,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `show_on_website` int NOT NULL DEFAULT '0' COMMENT '0-no 1-yes',
  `school_id` int DEFAULT NULL,
  PRIMARY KEY (`frontend_gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `frontend_gallery_image`
--

DROP TABLE IF EXISTS `frontend_gallery_image`;
CREATE TABLE IF NOT EXISTS `frontend_gallery_image` (
  `frontend_gallery_image_id` int NOT NULL AUTO_INCREMENT,
  `frontend_gallery_id` int DEFAULT NULL,
  `title` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`frontend_gallery_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `frontend_settings`
--

DROP TABLE IF EXISTS `frontend_settings`;
CREATE TABLE IF NOT EXISTS `frontend_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `about_us` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `terms_conditions` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `privacy_policy` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `social_links` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `copyright_text` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `about_us_image` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `slider_images` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `theme` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `homepage_note_title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `homepage_note_description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `website_title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `frontend_settings`
--

INSERT INTO `frontend_settings` (`id`, `about_us`, `terms_conditions`, `privacy_policy`, `social_links`, `copyright_text`, `about_us_image`, `slider_images`, `theme`, `homepage_note_title`, `homepage_note_description`, `website_title`) VALUES
(1, '&lt;h1&gt;About Our Schools&lt;/h1&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&amp;nbsp;&lt;span&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Our school historys&lt;/h3&gt;&lt;span&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Something interesting about our schools&lt;/h3&gt;&lt;span&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage&lt;br&gt;&lt;/span&gt;&lt;br&gt;&lt;ul&gt;&lt;li&gt;making this the first true generator&lt;/li&gt;&lt;li&gt;to generate Lorem Ipsum which&lt;/li&gt;&lt;li&gt;but the majority have suffered alteratio&lt;/li&gt;&lt;li&gt;is that it has a more-or-less&lt;/li&gt;&lt;/ul&gt;All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.&lt;br&gt;&lt;br&gt;&lt;br&gt;', '&lt;h1&gt;Terms of our school&lt;/h1&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&amp;nbsp;&lt;span&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Our school history&lt;/h3&gt;&lt;span&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Something interesting about our school&lt;/h3&gt;&lt;span&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage&lt;br&gt;&lt;/span&gt;&lt;br&gt;&lt;ul&gt;&lt;li&gt;making this the first true generator&lt;/li&gt;&lt;li&gt;to generate Lorem Ipsum which&lt;/li&gt;&lt;li&gt;but the majority have suffered alteratio&lt;/li&gt;&lt;li&gt;is that it has a more-or-less&lt;/li&gt;&lt;/ul&gt;All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.&lt;br&gt;&lt;br&gt;&lt;br&gt;', '&lt;h1&gt;Privacy policy of our school&lt;/h1&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&amp;nbsp;&lt;span&gt;It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#039;Content here, content here&#039;, making it look like readable English.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Our school history&lt;/h3&gt;&lt;span&gt;Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.&lt;br&gt;&lt;/span&gt;&lt;h3&gt;Something interesting about our school&lt;/h3&gt;&lt;span&gt;There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage&lt;br&gt;&lt;/span&gt;&lt;br&gt;&lt;ul&gt;&lt;li&gt;making this the first true generator&lt;/li&gt;&lt;li&gt;to generate Lorem Ipsum which&lt;/li&gt;&lt;li&gt;but the majority have suffered alteratio&lt;/li&gt;&lt;li&gt;is that it has a more-or-less&lt;/li&gt;&lt;/ul&gt;All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.&lt;br&gt;&lt;br&gt;&lt;br&gt;', '[{\"facebook\":\"http:\\/\\/www.facebook.com\\/ekattor\",\"twitter\":\"http:\\/\\/www.twitter.com\\/ekattor\",\"linkedin\":\"http:\\/\\/www.linkedin.com\\/ekattor\",\"google\":\"http:\\/\\/www.google.com\\/ekattor\",\"youtube\":\"http:\\/\\/www.youtube.com\\/ekattor\",\"instagram\":\"http:\\/\\/www.instagram.com\\/ekattor\"}]', 'All the rights reserved to Creativeitem', NULL, '[{\"title\":\"Education is the most powerful weapon\",\"description\":\"&quot;You can use education to change the world&quot; - &lt;i&gt;Nelson Mandela&lt;\\/i&gt;\",\"image\":\"slider1.jpg\"},{\"title\":\"Knowledge is power\",\"description\":\"&quot;Education is the premise of progress, in every society, in every family&quot; - &lt;i&gt;Kofi Annan&lt;\\/i&gt;\",\"image\":\"2.jpg\"},{\"title\":\"Have an aim in life, continuously acquire knowledge\",\"description\":\"&quot;Never stop fighting until you arrive at your destined place&quot; - &lt;i&gt;A.P.J. Abdul Kalam&lt;\\/i&gt;\",\"image\":\"1.jpg\"}]', 'ultimate', 'Welcome to Ekattor High School', 'Ekattor High School (NHS) is a public secondary school in Bellevue, Washington. It serves students in grades 9–12 in the southern part of the Bellevue School District, including the neighborhoods of Eastgate, Factoria, Newport Hills, Newport Shores, Somerset, The Summit, and Sunset. As of the 2014-2015 school year, the principal is Dion Yahoudy. The mascot is the Knight, and the school colors are scarlet and gold.', 'ekattor');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `displayed_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `route_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `parent` int DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int DEFAULT '1',
  `superadmin_access` int NOT NULL DEFAULT '0',
  `admin_access` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL,
  `is_addon` int NOT NULL DEFAULT '0' COMMENT 'If the value is 1 that means its an addon.',
  `unique_identifier` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'It is mandatory for addons',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `displayed_name`, `route_name`, `parent`, `icon`, `status`, `superadmin_access`, `admin_access`, `sort_order`, `is_addon`, `unique_identifier`) VALUES
(1, 'users', NULL, 0, 'dripicons-user', 1, 1, 0, 10, 0, 'users'),
(2, 'admin', 'admin', 1, NULL, 1, 1, 0, 9, 0, 'admin'),
(33, 'settings', NULL, 0, 'dripicons-cutlery', 0, 1, 1, 60, 0, 'settings'),
(34, 'system_settings', 'system_settings', 33, NULL, 1, 1, 0, 10, 0, 'system-settings'),
(37, 'language_settings', 'language', 33, NULL, 1, 1, 0, 30, 0, 'language-settings'),
(38, 'session_manager', 'session_manager', 28, NULL, 1, 1, 0, 0, 0, 'session-manager'),
(41, 'addon_manager', 'addon_manager', 28, NULL, 1, 1, 0, 0, 0, 'addon-manager'),
(47, 'messaging', NULL, 1, NULL, 0, 1, 0, 110, 0, 'messaging'),
(48, 'role_permission', 'role.index', 1, NULL, 0, 1, 0, 100, 0, 'role-permission'),
(49, 'form_builder', NULL, 32, NULL, 1, 1, 0, 0, 0, 'form-builder'),
(56, 'SMTP_settings', 'smtp_settings', 33, NULL, 1, 1, 0, 50, 0, 'smtp-settings'),
(57, 'school_settings', 'school_settings', 33, NULL, 1, 1, 1, 12, 0, 'school-settings'),
(58, 'about', 'about', 33, NULL, 1, 1, 0, 51, 0, 'about'),
(115, 'website_settings', 'website_settings', 33, NULL, 1, 1, 0, 11, 0, 'website-settings'),
(116, 'noticeboard', 'noticeboard', 28, NULL, 1, 1, 1, 0, 0, 'noticeboard');

-- --------------------------------------------------------

--
-- Structure de la table `noticeboard`
--

DROP TABLE IF EXISTS `noticeboard`;
CREATE TABLE IF NOT EXISTS `noticeboard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notice_title` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `notice` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `date` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int DEFAULT '1',
  `show_on_website` int DEFAULT '0',
  `image` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `school_id` int NOT NULL,
  `session` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `noticeboard`
--

INSERT INTO `noticeboard` (`id`, `notice_title`, `notice`, `date`, `status`, `show_on_website`, `image`, `school_id`, `session`) VALUES
(2, 'Project update: Projet Énergie Solaire2', 'OPEC Fund for International Development (OFID) Commented: test', '12/17/2025', 1, 0, '', 2, 1),
(3, 'Project update: Projet Énergie Solaire2', 'OPEC Fund for International Development (OFID) Commented: test2', '12/17/2025', 1, 0, '', 2, 1),
(4, 'Project update: Projet Énergie Solaire2', 'OPEC Fund for International Development (OFID) Commented: test', '12/17/2025', 1, 0, '', 2, 1),
(6, 'تحديث المشروع: مشروع الرابعة', 'ahmed علق: test', '12/18/2025', 1, 0, '', 2, 1),
(7, 'Project update: Projet Énergie Solaire', 'OPEC Fund for International Development (OFID) Commented: test ', '12/18/2025', 1, 0, '', 2, 1),
(8, 'Project update: Projet Énergie Solaire', 'admin Commented: tesr 531', '12/20/2025', 1, 0, '', 2, 1),
(9, 'Project update: Projet Énergie Solaire', 'admin Commented: test reply', '12/20/2025', 1, 0, '', 2, 1),
(10, 'Project update: Projet Énergie Solaire', 'sidi2 Commented: test ministry', '12/21/2025', 1, 0, '', 2, 1),
(11, 'Project update: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem Commented: test donor', '12/21/2025', 1, 0, '', 2, 1),
(12, 'Project update: Projet Énergie Solaire', 'sidi2 Commented: replay from minstry', '12/21/2025', 1, 0, '', 2, 1),
(13, 'Project update: Projet Énergie Solaire', 'sidi2 Commented: comment from ministy', '12/21/2025', 1, 0, '', 2, 1),
(14, 'Project update: Projet Énergie Solaire', 'admin Commented: test from super admin', '12/21/2025', 1, 0, '', 2, 1),
(15, 'Project update: Projet Énergie Solaire', 'admin Commented: test', '12/21/2025', 1, 0, '', 2, 1),
(16, 'Project update: Projet Énergie Solaire', 'admin Commented: test 836', '12/21/2025', 1, 0, '', 2, 1),
(17, 'Project update: Projet Énergie Solaire', 'admin Commented: test 837', '12/21/2025', 1, 0, '', 2, 1),
(18, 'Project update: Projet Énergie Solaire', 'admin Commented: 838', '12/21/2025', 1, 0, '', 2, 1),
(19, 'Project update: Projet Énergie Solaire', 'admin Commented: 841', '12/21/2025', 1, 0, '', 2, 1),
(20, 'Project update: Projet Énergie Solaire', 'admin Commented: 846', '12/21/2025', 1, 0, '', 2, 1),
(21, 'Project update: Projet Énergie Solaire', 'admin Commented: 847', '12/21/2025', 1, 0, '', 2, 1),
(22, 'Project update: Projet Énergie Solaire', 'admin Commented: 848', '12/21/2025', 1, 0, '', 2, 1),
(23, 'Project update: Projet Énergie Solaire', 'admin Commented: 852', '12/21/2025', 1, 0, '', 2, 1),
(24, 'Project update: Projet Énergie Solaire', 'admin Commented: 857', '12/21/2025', 1, 0, '', 2, 1),
(25, 'Project update: Projet Énergie Solaire', 'admin Commented: 857', '12/21/2025', 1, 0, '', 2, 1),
(26, 'Project update: Projet Énergie Solaire', 'admin Commented: 859', '12/21/2025', 1, 0, '', 2, 1),
(27, 'Project update: Projet Énergie Solaire', 'admin Commented: 900', '12/21/2025', 1, 0, '', 2, 1),
(28, 'Project update: Projet Énergie Solaire', 'admin Commented: test 901', '12/21/2025', 1, 0, '', 2, 1),
(29, 'Project update: Projet Énergie Solaire', 'admin Commented: test 903', '12/21/2025', 1, 0, '', 2, 1),
(30, 'Project update: Projet Énergie Solaire', 'admin Commented: test 910', '12/21/2025', 1, 0, '', 2, 1),
(31, 'تحديث المشروع: Projet Énergie Solaire', 'admin علق: 914\r\n', '12/21/2025', 1, 0, '', 2, 1),
(32, 'تحديث المشروع: Projet Énergie Solaire', 'admin علق: ردي', '12/21/2025', 1, 0, '', 2, 1),
(33, 'تحديث المشروع: Projet Énergie Solaire', 'admin علق: رد الان', '12/21/2025', 1, 0, '', 2, 1),
(34, 'Project update: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem Commented: 923', '12/21/2025', 1, 0, '', 2, 1),
(35, 'Project update: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem Commented: 923', '12/21/2025', 1, 0, '', 2, 1),
(36, 'Project update: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem Commented: re', '12/21/2025', 1, 0, '', 2, 1),
(37, 'تحديث المشروع: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem علق: ok', '12/21/2025', 1, 0, '', 2, 1),
(38, 'تحديث المشروع: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem علق: ok', '12/21/2025', 1, 0, '', 2, 1),
(39, 'تحديث المشروع: Projet Énergie Solaire', 'sidi2 علق: test', '12/21/2025', 1, 0, '', 1, 1),
(40, 'تحديث المشروع: Projet Énergie Solaire', 'admin علق: test', '12/21/2025', 1, 0, '', 2, 1),
(41, 'تحديث المشروع: Projet Énergie Solaire', 'admin علق: test2', '12/21/2025', 1, 0, '', 2, 1),
(42, 'تحديث المشروع: Projet Énergie Solaire', 'sidi2 علق: test', '12/21/2025', 1, 0, '', 1, 1),
(43, 'تحديث المشروع: Projet Énergie Solaire', 'sidi2 علق: test', '12/21/2025', 1, 0, '', 1, 1),
(44, 'تحديث المشروع: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem علق: الرجاء مشاركة الدراسة المالية للمشروع', '12/21/2025', 1, 0, '', 2, 1),
(45, 'تحديث المشروع: Projet Énergie Solaire', 'Ganem Ahmed Elhaganem علق: الرجاء الرد', '12/21/2025', 1, 0, '', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `notice_id` int DEFAULT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `status` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notice_id`, `message`, `status`, `created_at`) VALUES
(13, 2, 3, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(11, 12, 2, 'Project update: Projet Énergie Solaire2', '0', '0000-00-00 00:00:00'),
(12, 1, 3, 'Project update: Projet Énergie Solaire2', 'read', '0000-00-00 00:00:00'),
(10, 5, 2, 'Project update: Projet Énergie Solaire2', '0', '0000-00-00 00:00:00'),
(9, 4, 2, 'Project update: Projet Énergie Solaire2', '0', '0000-00-00 00:00:00'),
(7, 1, 2, 'Project update: Projet Énergie Solaire2', '0', '0000-00-00 00:00:00'),
(8, 2, 2, 'Project update: Projet Énergie Solaire2', '0', '0000-00-00 00:00:00'),
(14, 4, 3, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(15, 5, 3, 'Project update: Projet Énergie Solaire2', 'read', '0000-00-00 00:00:00'),
(16, 12, 3, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(17, 1, 4, 'Project update: Projet Énergie Solaire2', 'read', '0000-00-00 00:00:00'),
(18, 2, 4, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(19, 4, 4, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(20, 5, 4, 'Project update: Projet Énergie Solaire2', 'read', '0000-00-00 00:00:00'),
(21, 12, 4, 'Project update: Projet Énergie Solaire2', 'unread', '0000-00-00 00:00:00'),
(22, 2, 5, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(23, 4, 5, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(24, 5, 5, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(25, 11, 5, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(26, 12, 5, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(27, 1, 6, 'تحديث المشروع: مشروع الرابعة', 'read', '0000-00-00 00:00:00'),
(28, 2, 6, 'تحديث المشروع: مشروع الرابعة', 'unread', '0000-00-00 00:00:00'),
(29, 4, 6, 'تحديث المشروع: مشروع الرابعة', 'unread', '0000-00-00 00:00:00'),
(30, 5, 6, 'تحديث المشروع: مشروع الرابعة', 'read', '0000-00-00 00:00:00'),
(31, 11, 6, 'تحديث المشروع: مشروع الرابعة', 'read', '0000-00-00 00:00:00'),
(32, 12, 6, 'تحديث المشروع: مشروع الرابعة', 'unread', '0000-00-00 00:00:00'),
(33, 1, 7, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(34, 2, 7, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(35, 4, 7, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(36, 5, 7, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(37, 12, 7, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(38, 13, 7, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(39, 14, 7, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(40, 2, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(41, 4, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(42, 5, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(43, 11, 8, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(44, 12, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(45, 13, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(46, 19, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(47, 20, 8, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(48, 2, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(49, 4, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(50, 5, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(51, 11, 9, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(52, 12, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(53, 13, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(54, 19, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(55, 20, 9, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(56, 1, 10, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(57, 2, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(58, 4, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(59, 11, 10, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(60, 12, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(61, 13, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(62, 19, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(63, 20, 10, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(64, 1, 11, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(65, 2, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(66, 4, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(67, 5, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(68, 12, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(69, 13, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(70, 19, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(71, 20, 11, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(72, 1, 12, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(73, 2, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(74, 4, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(75, 11, 12, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(76, 12, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(77, 13, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(78, 19, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(79, 20, 12, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(80, 1, 13, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(81, 2, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(82, 4, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(83, 11, 13, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(84, 12, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(85, 13, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(86, 19, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(87, 20, 13, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(88, 2, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(89, 4, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(90, 5, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(91, 11, 14, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(92, 12, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(93, 13, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(94, 19, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(95, 20, 14, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(96, 2, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(97, 4, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(98, 5, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(99, 11, 15, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(100, 12, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(101, 13, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(102, 19, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(103, 20, 15, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(104, 2, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(105, 4, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(106, 5, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(107, 11, 16, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(108, 12, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(109, 13, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(110, 19, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(111, 20, 16, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(112, 2, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(113, 4, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(114, 5, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(115, 11, 17, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(116, 12, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(117, 13, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(118, 19, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(119, 20, 17, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(120, 2, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(121, 4, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(122, 5, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(123, 11, 18, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(124, 12, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(125, 13, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(126, 19, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(127, 20, 18, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(128, 2, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(129, 4, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(130, 5, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(131, 11, 19, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(132, 12, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(133, 13, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(134, 19, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(135, 20, 19, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(136, 2, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(137, 4, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(138, 5, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(139, 11, 20, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(140, 12, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(141, 13, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(142, 19, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(143, 20, 20, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(144, 2, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(145, 4, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(146, 5, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(147, 11, 21, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(148, 12, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(149, 13, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(150, 19, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(151, 20, 21, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(152, 2, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(153, 4, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(154, 5, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(155, 11, 22, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(156, 12, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(157, 13, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(158, 19, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(159, 20, 22, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(160, 2, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(161, 4, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(162, 5, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(163, 11, 23, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(164, 12, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(165, 13, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(166, 19, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(167, 20, 23, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(168, 2, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(169, 4, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(170, 5, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(171, 11, 24, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(172, 12, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(173, 13, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(174, 19, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(175, 20, 24, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(176, 2, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(177, 4, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(178, 5, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(179, 11, 25, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(180, 12, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(181, 13, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(182, 19, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(183, 20, 25, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(184, 2, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(185, 4, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(186, 5, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(187, 11, 26, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(188, 12, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(189, 13, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(190, 19, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(191, 20, 26, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(192, 2, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(193, 4, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(194, 5, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(195, 11, 27, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(196, 12, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(197, 13, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(198, 19, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(199, 20, 27, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(200, 2, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(201, 4, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(202, 5, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(203, 11, 28, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(204, 12, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(205, 13, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(206, 19, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(207, 20, 28, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(208, 2, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(209, 4, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(210, 5, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(211, 11, 29, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(212, 12, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(213, 13, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(214, 19, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(215, 20, 29, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(216, 2, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(217, 4, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(218, 5, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(219, 11, 30, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(220, 12, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(221, 13, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(222, 19, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(223, 20, 30, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(224, 2, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(225, 4, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(226, 5, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(227, 11, 31, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(228, 12, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(229, 13, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(230, 19, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(231, 20, 31, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(232, 2, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(233, 4, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(234, 5, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(235, 11, 32, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(236, 12, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(237, 13, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(238, 19, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(239, 20, 32, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(240, 2, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(241, 4, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(242, 5, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(243, 11, 33, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(244, 12, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(245, 13, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(246, 19, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(247, 20, 33, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(248, 1, 34, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(249, 2, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(250, 4, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(251, 5, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(252, 12, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(253, 13, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(254, 19, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(255, 20, 34, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(256, 1, 35, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(257, 2, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(258, 4, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(259, 5, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(260, 12, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(261, 13, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(262, 19, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(263, 20, 35, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(264, 1, 36, 'Project update: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(265, 2, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(266, 4, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(267, 5, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(268, 12, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(269, 13, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(270, 19, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(271, 20, 36, 'Project update: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(272, 1, 37, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(273, 2, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(274, 4, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(275, 5, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(276, 12, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(277, 13, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(278, 19, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(279, 20, 37, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(280, 1, 38, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(281, 2, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(282, 4, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(283, 5, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(284, 12, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(285, 13, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(286, 19, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(287, 20, 38, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(288, 1, 39, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(289, 2, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(290, 4, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(291, 11, 39, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(292, 12, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(293, 13, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(294, 19, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(295, 20, 39, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(296, 2, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(297, 4, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(298, 5, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(299, 11, 40, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(300, 12, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(301, 13, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(302, 19, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(303, 20, 40, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(304, 2, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(305, 4, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(306, 5, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(307, 11, 41, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(308, 12, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(309, 13, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(310, 19, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(311, 20, 41, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(312, 1, 42, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(313, 2, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(314, 4, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(315, 11, 42, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(316, 12, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(317, 13, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(318, 19, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(319, 20, 42, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(320, 1, 43, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(321, 2, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(322, 4, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(323, 11, 43, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(324, 12, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(325, 13, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(326, 19, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(327, 20, 43, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(328, 1, 44, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(329, 2, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(330, 4, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(331, 5, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(332, 12, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(333, 13, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(334, 19, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(335, 20, 44, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(336, 1, 45, 'تحديث المشروع: Projet Énergie Solaire', 'read', '0000-00-00 00:00:00'),
(337, 2, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(338, 4, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(339, 5, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(340, 12, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(341, 13, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(342, 19, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00'),
(343, 20, 45, 'تحديث المشروع: Projet Énergie Solaire', 'unread', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `payment_settings`
--

DROP TABLE IF EXISTS `payment_settings`;
CREATE TABLE IF NOT EXISTS `payment_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `value` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `key`, `value`) VALUES
(12, 'stripe_settings', '[{\"stripe_active\":\"yes\",\"stripe_mode\":\"on\",\"stripe_test_secret_key\":\"1234\",\"stripe_test_public_key\":\"1234\",\"stripe_live_secret_key\":\"1234\",\"stripe_live_public_key\":\"1234\",\"stripe_currency\":\"USD\"}]'),
(17, 'paypal_settings', '[{\"paypal_active\":\"yes\",\"paypal_mode\":\"sandbox\",\"paypal_client_id_sandbox\":\"1234\",\"paypal_client_id_production\":\"1234\",\"paypal_currency\":\"USD\"}]');

-- --------------------------------------------------------

--
-- Structure de la table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `phone` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `schools`
--

INSERT INTO `schools` (`id`, `name`, `address`, `phone`) VALUES
(1, 'Platformagg', 'School Address', '+123123123123'),
(2, 'platformagg', 'School Address', '+123123123123');

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `status`) VALUES
(1, '2025', 1),
(2, '2025', 1);

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_id` int DEFAULT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `system_title` varchar(255) DEFAULT NULL,
  `system_email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` longtext,
  `purchase_code` varchar(255) DEFAULT NULL,
  `system_currency` varchar(255) DEFAULT NULL,
  `currency_position` varchar(255) DEFAULT NULL,
  `running_session` varchar(255) DEFAULT '',
  `language` varchar(255) DEFAULT NULL,
  `student_email_verification` varchar(255) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `footer_link` varchar(255) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `date_of_last_updated_attendance` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `youtube_api_key` varchar(255) DEFAULT NULL,
  `vimeo_api_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `school_id`, `system_name`, `system_title`, `system_email`, `phone`, `address`, `purchase_code`, `system_currency`, `currency_position`, `running_session`, `language`, `student_email_verification`, `footer_text`, `footer_link`, `version`, `fax`, `date_of_last_updated_attendance`, `timezone`, `youtube_api_key`, `vimeo_api_key`) VALUES
(1, 2, 'Joint Coordination Platform ', 'Joint Coordination Platform ', 'contact@jcp.gov.mr', '+8801234567890', 'Nouakchott,Mauritania', '1234', 'USD', 'left', '2', 'english', NULL, 'By HafedMih', 'http://HafedMih.com/', '7.7', '1234567890', '1652735250', 'Asia/Dhaka', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `smtp_settings`
--

DROP TABLE IF EXISTS `smtp_settings`;
CREATE TABLE IF NOT EXISTS `smtp_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mail_sender` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_protocol` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_host` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_secure` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_set_from` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_debug` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_show_error` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `smtp_crypto` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `mail_sender`, `smtp_protocol`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`, `smtp_set_from`, `smtp_debug`, `smtp_show_error`, `smtp_crypto`) VALUES
(1, 'contact@jcp.gov.mr', 'smtp', 'smtp1.office365.com', 'contact@jcp.gov.mr', 'Y&729754777256ax', '587', '', 'Joint Coordination Platform', NULL, 'yes', 'ssl');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_id` int DEFAULT NULL,
  `authentication_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `watch_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL COMMENT '0=deactive, 1= active, 3=new admission',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `address`, `phone`, `remember_token`, `birthday`, `gender`, `blood_group`, `school_id`, `authentication_key`, `watch_history`, `status`) VALUES
(1, 'admin1234', 'gm@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'superadmin', '', '', NULL, NULL, NULL, NULL, 1, NULL, '[]', 1),
(5, 'sidi1234', 'admin@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin', 'minisre', '36696730', NULL, NULL, NULL, NULL, 1, NULL, '[]', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
