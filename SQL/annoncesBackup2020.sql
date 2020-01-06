/*
SQLyog Community v12.16 (32 bit)
MySQL - 5.7.26 : Database - annonces
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`annonces` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `annonces`;

/*Table structure for table `annonce` */

DROP TABLE IF EXISTS `annonce`;

CREATE TABLE `annonce` (
  `annonce_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rubrique_id` int(11) NOT NULL,
  `en_tete` varchar(80) NOT NULL,
  `corps` text NOT NULL,
  `date_limite` datetime DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `date_modif` datetime DEFAULT NULL,
  `visites` bigint(20) DEFAULT '0',
  PRIMARY KEY (`annonce_id`),
  KEY `I_FK_ANNONCE_UTILISATEUR` (`user_id`),
  KEY `I_FK_ANNONCE_RUBRIQUE` (`rubrique_id`),
  CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`rubrique_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

/*Data for the table `annonce` */

insert  into `annonce`(`annonce_id`,`user_id`,`rubrique_id`,`en_tete`,`corps`,`date_limite`,`date_creation`,`date_modif`,`visites`) values 
(63,50,14,'tyr  ytry re t  ytre yre y',' ytry ye yte ytre yre ytre yte','2020-01-30 08:29:08','2020-01-02 09:29:08','2020-01-02 09:29:08',2),
(64,51,14,'juyyjuy','yfyjyhu ufr utr  yt  yt ','2020-01-30 08:52:54','2020-01-02 09:52:54','2020-01-02 09:52:54',2),
(65,53,12,'auto1','auto1\r\nblabla','2020-01-30 11:58:05','2020-01-02 12:58:05','2020-01-02 13:04:21',0);

/*Table structure for table `image` */

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `annonce_id` int(11) NOT NULL,
  `image_src` varchar(50) NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `image_ibfk_1` (`annonce_id`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`annonce_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `image` */

insert  into `image`(`image_id`,`annonce_id`,`image_src`) values 
(6,63,'img/lune2.jpg'),
(7,63,'img/lune1.jpg'),
(8,64,'img/Chien.jpg'),
(9,64,'img/lune1.jpg'),
(12,65,'img/lune2.jpg'),
(14,65,'img/Chien.jpg'),
(15,65,'img/lune1.jpg');

/*Table structure for table `rubrique` */

DROP TABLE IF EXISTS `rubrique`;

CREATE TABLE `rubrique` (
  `rubrique_id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) NOT NULL,
  PRIMARY KEY (`rubrique_id`),
  UNIQUE KEY `LIBELLE` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `rubrique` */

insert  into `rubrique`(`rubrique_id`,`libelle`) values 
(14,' animaux'),
(22,'auto'),
(12,'bébé'),
(11,'electro-Ménager'),
(24,'emploi'),
(18,'high-tech'),
(2,'immobilier'),
(8,'jardin'),
(5,'maison déco'),
(23,'mode beauté'),
(16,'rencontre'),
(17,'service');

/*Table structure for table `utilisateur` */

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE `utilisateur` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `mot_de_passe` varchar(128) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `est_admin` tinyint(4) NOT NULL DEFAULT '0',
  `confirmation_token` varchar(60) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

/*Data for the table `utilisateur` */

insert  into `utilisateur`(`user_id`,`nom`,`mot_de_passe`,`mail`,`est_admin`,`confirmation_token`,`created_at`,`confirmed_at`,`reset_token`,`reset_at`) values 
(40,'yjdfuydutdyu','$2y$10$ilNIX0gPq3kgnljADKvuHOrFSlQ86CNw07kcpfmEKd1eiubVCWv7S','tyes@hgf.jhgc',0,'5dfa15f43b1f5','2020-01-01 00:00:00','2019-12-18 12:14:45',NULL,NULL),
(41,'hjfcjhgjhgc','$2y$10$HqbBdfM59hW9KPTdKbtwhuzsvWDAgR8/mlhC9lb7D0LcC0o8T9R2m','htfxhjf@uyc.kuc',0,'5dfa185582012','2020-01-01 00:00:00','2019-12-18 12:15:39',NULL,NULL),
(42,'jytjtyu','$2y$10$iweWKzqgldfMepHtrlS/Iu18DAvI2ZIfd4vAIO4Ofug2oultUiXAW','hgdx@jhfx.jygfc',0,'5dfa230b5dee4','2019-12-18 13:00:59','2019-12-18 13:01:22',NULL,NULL),
(45,'rezrezrerez','$2y$10$o8fLn1MbHehhcmegVD8WGu1UbZxADNXQUAqGbbrpfHU9OjaqLv6dK','a@fds.jhfc',0,'5dfb74b420f66','2019-12-19 13:01:40','2019-12-19 13:18:06',NULL,NULL),
(46,'trtr','$2y$10$tsAUH8LA3fRJ0AfLGQgVzubSDaul7CXewpKO/hH7y6DHICnekH7zO','tresgtrdq@gdesgdf.com',0,'5dfb7b546f9bf','2019-12-19 13:29:56','2019-12-19 13:36:34',NULL,NULL),
(50,'tutu','$2y$10$YHFP1TStKVHYaoMNeEzV5uqRWiO3zi/PpuQsXWl4ObPtopMq1ifoC','tutu@tutu.tutu',0,'5e0da84acd3e3','2020-01-02 08:22:34','2020-01-02 08:27:09','5e0ddeedac590','2020-01-02 13:15:41'),
(51,'ruru','$2y$10$S/dXXpD0u07y9aQXk5mgNuJDg.pKxm.KueKuaJHB5uMoZ7jyuVjWi','ruru@ruru.ruru',1,'5e0daa8abdb99','2020-01-02 08:32:10','2020-01-02 08:33:33','5e0dab11ad6e4','2020-01-02 09:34:25'),
(52,'rere','$2y$10$Etuz1vNmhNQ8C30ZDblrYeB9yJ13wUT/acf/1JB1leiFYFxwzZMeC','rere@rere.rere',0,'5e0db3442386d','2020-01-02 09:09:24','2020-01-02 09:11:06',NULL,NULL),
(53,',:;ùl;:!;,gts','$2y$10$hrLM8wfcy95kIJ2Nmu0vD.FVM4e0b6JJQExl9yJISIF5JPI992C9i','zed@zed.com',0,'5e0dd9dadd29c','2020-01-02 11:54:02','2020-01-02 11:55:22',NULL,NULL);

/* Trigger structure for table `annonce` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_annonce_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_annonce_insert` BEFORE INSERT ON `annonce` FOR EACH ROW BEGIN
	IF (NEW.date_creation IS NULL) THEN 
    SET NEW.date_creation = NOW();
    END IF;
    IF (NEW.date_limite IS NULL) THEN 
    SET NEW.date_limite = ADDDATE(CURDATE(), INTERVAL 21 DAY);
    END IF;
    END */$$


DELIMITER ;

/* Procedure structure for procedure `insertUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `insertUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `insertUser`(IN `in_nom` VARCHAR(30), IN `in_prenom` VARCHAR(30), IN `in_mdp` VARCHAR(128))
    NO SQL
INSERT INTO utilisateur (NOM, PRENOM, MDP)
VALUES (in_nom, in_prenom, in_mdp) */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
