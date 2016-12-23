-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: gothic
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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

--
-- Table structure for table `active_equipment`
--

DROP TABLE IF EXISTS `active_equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `active_equipment` (
  `user_id` int(11) NOT NULL,
  `weapon_object_id` int(11) DEFAULT NULL,
  `armor_object_id` int(11) DEFAULT NULL,
  `rune_object_id` int(11) DEFAULT NULL,
  `boots_object_id` int(11) DEFAULT NULL,
  `gloves_object_id` int(11) DEFAULT NULL,
  `helmet_object_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `active_equipment`
--

LOCK TABLES `active_equipment` WRITE;
/*!40000 ALTER TABLE `active_equipment` DISABLE KEYS */;
/*!40000 ALTER TABLE `active_equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `trigger_type` varchar(45) DEFAULT NULL,
  `trigger_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (14,'I\'m …',NULL,NULL),(15,'Okay, what do I need to know about this place?',NULL,NULL),(16,'Why did you help me?',NULL,NULL),(17,'I have a letter for the High Magician of the Circle of Fire.',NULL,NULL),(18,'How do I get to the Old Camp?',NULL,NULL),(19,'A suggestion?',NULL,NULL),(20,'Where`s Bullit now?',NULL,NULL),(21,'I was given it by a mage shortly before they threw me in here.',NULL,NULL),(22,'Thanks for your help!',NULL,NULL),(23,'Continue',NULL,NULL),(24,'Explore mine','AddObjectToInventory',1),(25,'Go down the path',NULL,NULL),(26,'Attack!','Fight',1),(27,'Where do I get a weapon?',NULL,NULL),(28,'Try to pass unnoticed',NULL,NULL),(29,'Eat meat','Treatment',1),(30,'I\'m vegeterian',NULL,NULL);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `character`
--

DROP TABLE IF EXISTS `character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `health` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `agility` int(11) NOT NULL,
  `plus_experience_for_win` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character`
--

LOCK TABLES `character` WRITE;
/*!40000 ALTER TABLE `character` DISABLE KEYS */;
INSERT INTO `character` VALUES (1,'Diego',500,100,100,0),(2,'Young wolf',100,5,10,100);
/*!40000 ALTER TABLE `character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemy_attack_type`
--

DROP TABLE IF EXISTS `enemy_attack_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemy_attack_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `character_id` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `probability` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `message` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemy_attack_type`
--

LOCK TABLES `enemy_attack_type` WRITE;
/*!40000 ALTER TABLE `enemy_attack_type` DISABLE KEYS */;
INSERT INTO `enemy_attack_type` VALUES (1,'Press down to the ground',2,'',10,10,''),(2,'Cheating. Bite back',2,'',5,20,''),(3,'A deafening howl',2,'',10,10,''),(4,'Simple bite',2,'\'\'',75,5,NULL);
/*!40000 ALTER TABLE `enemy_attack_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enemy_damage_type`
--

DROP TABLE IF EXISTS `enemy_damage_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enemy_damage_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `class` varchar(45) NOT NULL,
  `probability` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `kick_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`kick_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enemy_damage_type`
--

LOCK TABLES `enemy_damage_type` WRITE;
/*!40000 ALTER TABLE `enemy_damage_type` DISABLE KEYS */;
INSERT INTO `enemy_damage_type` VALUES (1,'lose paw','',10,0,1),(2,'Stun','',30,0,1);
/*!40000 ALTER TABLE `enemy_damage_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fight`
--

DROP TABLE IF EXISTS `fight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `health` int(11) NOT NULL,
  `loose_attacks` varchar(45) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index3` (`user_id`,`answer_id`),
  KEY `index2` (`user_id`,`character_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fight`
--

LOCK TABLES `fight` WRITE;
/*!40000 ALTER TABLE `fight` DISABLE KEYS */;
/*!40000 ALTER TABLE `fight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`object_id`),
  KEY `index3` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object`
--

DROP TABLE IF EXISTS `object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `damage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object`
--

LOCK TABLES `object` WRITE;
/*!40000 ALTER TABLE `object` DISABLE KEYS */;
INSERT INTO `object` VALUES (1,'weapon','Rusty one-handed sword',10);
/*!40000 ALTER TABLE `object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `start` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_question_1_idx` (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (113,1,'Im Diego',1),(114,1,' I\'m not interested in who you are. You\'ve just arrived. I look after the new arrivals. That\'s all for new. If you plan to stay alive for a while, you should talk to me. But of course I won\'t keep you from choosing your own destruction. Well, what do you think?',NULL),(115,1,'We call it the colony. You\'ll know already that we produce ore for the King. Well, at least we do in the Old Camp. There are three camps within the Barrier. The Old Camp is the biggest. And it was the first.',NULL),(116,1,'You just follow this path. The Old Camp is the next reasonably safe-looking place you\'ll come across. There are a lot of wild beasts between the camps. You\'d be mad to walk around without a weapon.',NULL),(117,1,'When you get to the Old Mine. Have a look around . I\'m sure you\'ll find something useful. The mine is easy to find. It\'s just a few meters along the canyon.',NULL),(118,1,'Because you needed help. Otherwise Bullit and his boys might have killed you. And I couldn\'t just stand by and watch. \'Cos I came all this way to make a suggestion.',NULL),(119,1,'Yes. After this little incident with Bullit and his guys, you should be aware now that you need protection. Everyone who arrives here has a choice. There are three camps in the colony. And you\'ll have to join one of them. I\'m here to show the new ones that  the Old Camp is the best place for them.',NULL),(120,1,'He and the others bring the goods from the outside world into the Camp. You\'ll find him there. But if you plan to fight him, be careful. He\'s an experienced warrior.',NULL),(121,1,'Really?',NULL),(122,1,'You\'re lucky I can\'t afford to show my face around the mages any more. Anyone else would gladly slit your throal for that letter. That\'s because the mages pay their couriers a lot and most people here don\'t have anything. If I were you I\'d shut up until I met one of the mages. Although, in your situation. That\'s not likely to happen.',NULL),(123,1,'We\'ll meet in the Old Camp.',NULL),(124,0,'Turning the hill you hear someone\'s swarming. You carefully look around and see a young wolf. He\'s absolutely alone. Strangely, since wolves live in packs. Do you want to attack it or try to ignore?',NULL),(125,0,'You\'ve found the rusty one-handed sword. He\'s pretty blunt, but it\'s better than to fight with your bare hands. Select a sword in your inventory as a weapon to use it further.',NULL),(126,0,'You follow along the only trail leading, as Diego said, to the Old Camp. Above your head is shining dome of the barrier. This place looks pretty safely. But you should not forget about the wild animals living here. You come to the abandoned mine. Whether you want to explore an abandoned mine or pass?',NULL),(127,0,'Wolf was defeated! And it\'s your first victory! You\'re getting +100 to you  experience and moved to the next level. You got badly damaged in the combat. A little food will heal your wounds. You can get some meat from the wolf. It will increase you health.',NULL),(128,0,'Now you are ready to continue your journey. It is a pity that it is not created. But you know... Imagination - the greatest game you can ever play. Enjoy yourself and play in your life. Every day. Good luck!',NULL);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_answer`
--

DROP TABLE IF EXISTS `question_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_answer` (
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `next_question_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`question_id`,`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_answer`
--

LOCK TABLES `question_answer` WRITE;
/*!40000 ALTER TABLE `question_answer` DISABLE KEYS */;
INSERT INTO `question_answer` VALUES (113,14,114),(114,15,115),(114,16,118),(114,17,121),(115,16,118),(115,17,121),(115,18,116),(116,16,118),(116,17,121),(116,27,117),(117,16,118),(117,17,121),(118,19,119),(119,17,121),(119,20,120),(120,17,121),(121,21,122),(122,22,123),(123,23,126),(124,26,127),(124,28,128),(125,25,124),(126,24,125),(126,25,124),(127,29,128),(127,30,128);
/*!40000 ALTER TABLE `question_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trigger_add_object_to_inventory`
--

DROP TABLE IF EXISTS `trigger_add_object_to_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trigger_add_object_to_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trigger_add_object_to_inventory`
--

LOCK TABLES `trigger_add_object_to_inventory` WRITE;
/*!40000 ALTER TABLE `trigger_add_object_to_inventory` DISABLE KEYS */;
INSERT INTO `trigger_add_object_to_inventory` VALUES (1,1);
/*!40000 ALTER TABLE `trigger_add_object_to_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trigger_fight`
--

DROP TABLE IF EXISTS `trigger_fight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trigger_fight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `start_combat_message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trigger_fight`
--

LOCK TABLES `trigger_fight` WRITE;
/*!40000 ALTER TABLE `trigger_fight` DISABLE KEYS */;
INSERT INTO `trigger_fight` VALUES (1,2,'Wolf has noticed you and is running to you now! All that you have to - to strike first!');
/*!40000 ALTER TABLE `trigger_fight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trigger_treatment`
--

DROP TABLE IF EXISTS `trigger_treatment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trigger_treatment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `health_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trigger_treatment`
--

LOCK TABLES `trigger_treatment` WRITE;
/*!40000 ALTER TABLE `trigger_treatment` DISABLE KEYS */;
INSERT INTO `trigger_treatment` VALUES (1,100);
/*!40000 ALTER TABLE `trigger_treatment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `question_id` int(11) NOT NULL DEFAULT '0',
  `health` int(11) NOT NULL DEFAULT '100',
  `max_health` int(11) NOT NULL DEFAULT '100',
  `damage` int(11) NOT NULL DEFAULT '10',
  `agility` int(11) NOT NULL DEFAULT '10',
  `level` int(11) NOT NULL DEFAULT '1',
  `experience` int(11) NOT NULL DEFAULT '0',
  `auth_key` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attack_type`
--

DROP TABLE IF EXISTS `user_attack_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attack_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `class` varchar(45) NOT NULL,
  `probability` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `index2` (`character_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attack_type`
--

LOCK TABLES `user_attack_type` WRITE;
/*!40000 ALTER TABLE `user_attack_type` DISABLE KEYS */;
INSERT INTO `user_attack_type` VALUES (1,'Hit the paw','',20,20,2,NULL),(2,'Hit the head','',15,50,2,NULL),(3,'Hit the back','',40,30,2,NULL),(4,'Simple hit','',70,10,2,NULL);
/*!40000 ALTER TABLE `user_attack_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-23  2:27:05
