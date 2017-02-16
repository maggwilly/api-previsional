
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `point_vente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `point_vente` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomGerant` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telGerant` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quartier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2BBFAADFA76ED395` (`user_id`),
  CONSTRAINT `FK_2BBFAADFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `visite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visite` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `point_vente_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `map` tinyint(1) DEFAULT NULL,
  `pre` tinyint(1) DEFAULT NULL,
  `aff` tinyint(1) DEFAULT NULL,
  `exc` tinyint(1) DEFAULT NULL,
  `vpt` tinyint(1) DEFAULT NULL,
  `sapp` tinyint(1) DEFAULT NULL,
  `commentaire` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fp` int(11) DEFAULT NULL,
  `rpp` tinyint(1) DEFAULT NULL,
  `rpd` tinyint(1) DEFAULT NULL,
  `date` date NOT NULL,
  `week` int(11) NOT NULL,
  `week_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B09C8CBBEFA24D68` (`point_vente_id`),
  KEY `IDX_B09C8CBBA76ED395` (`user_id`),
  CONSTRAINT `FK_B09C8CBBEFA24D68` FOREIGN KEY (`point_vente_id`) REFERENCES `point_vente` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `situation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `situation` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `produit_id` int(11) NOT NULL,
  `visite_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `map` tinyint(1) DEFAULT NULL,
  `pre` tinyint(1) DEFAULT NULL,
  `aff` tinyint(1) DEFAULT NULL,
  `rpp` tinyint(1) DEFAULT NULL,
  `rpd` tinyint(1) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stockg` int(11) DEFAULT NULL,
  `mvj` int(11) DEFAULT NULL,
  `ecl` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EC2D9ACAF347EFB` (`produit_id`),
  KEY `IDX_EC2D9ACAC1C5DC59` (`visite_id`),
  CONSTRAINT `FK_EC2D9ACAC1C5DC59` FOREIGN KEY (`visite_id`) REFERENCES `visite` (`id`),
  CONSTRAINT `FK_EC2D9ACAF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `produit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `concurent_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dossier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_29A5EC276C6E55B5` (`nom`),
  UNIQUE KEY `UNIQ_29A5EC27D1D4B111` (`concurent_id`),
  CONSTRAINT `FK_29A5EC27D1D4B111` FOREIGN KEY (`concurent_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `etape`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etape` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `suivant_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(5,2) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_285F75DD9C2BB0CC` (`suivant_id`),
  KEY `IDX_285F75DDA76ED395` (`user_id`),
  CONSTRAINT `FK_285F75DD9C2BB0CC` FOREIGN KEY (`suivant_id`) REFERENCES `etape` (`id`),
  CONSTRAINT `FK_285F75DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

