/*
Navicat MySQL Data Transfer

Source Server         : lop_cua_toi
Source Server Version : 50642
Source Host           : 159.65.34.155:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2018-12-20 12:38:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for question_answer
-- ----------------------------
DROP TABLE IF EXISTS `question_answer`;
CREATE TABLE `question_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_at` int(11) DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of question_answer
-- ----------------------------
INSERT INTO `question_answer` VALUES ('1', '5', '8', 'có', '2', '1544416140', null);
INSERT INTO `question_answer` VALUES ('2', '5', '9', 'châu á', '2', '1544416140', null);
INSERT INTO `question_answer` VALUES ('3', '5', '11', 'sai mất rồi', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('4', '5', '11', 'lại sai rồi', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('5', '5', '11', 'rất sai', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('6', '5', '11', 'Đúng vậy', '2', '1544416298', null);
INSERT INTO `question_answer` VALUES ('7', '5', '12', 'câu trả lời sai nhé', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('8', '5', '12', 'câu trả lời sai nhé', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('9', '5', '12', 'câu trả lời sai', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('10', '5', '12', 'câu trả lời đúng', '2', '1544416298', null);
INSERT INTO `question_answer` VALUES ('11', '5', '13', 'lào', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('12', '5', '13', 'thái lan', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('13', '5', '13', 'hoa kỳ', '1', '1544416298', null);
INSERT INTO `question_answer` VALUES ('14', '5', '13', 'việt nam', '2', '1544416298', null);
INSERT INTO `question_answer` VALUES ('15', '1', '17', 'Hà nội', '2', '1544621987', null);
INSERT INTO `question_answer` VALUES ('16', '1', '18', '64', '2', '1544621987', null);
INSERT INTO `question_answer` VALUES ('17', '1', '19', 'ko biết', '2', '1544621987', null);
INSERT INTO `question_answer` VALUES ('18', '1', '21', 'đáp án sai', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('19', '1', '21', 'đáp án sai 1', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('20', '1', '21', 'đáp án sai 2', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('21', '1', '21', 'đáp án 1', '2', '1544622091', null);
INSERT INTO `question_answer` VALUES ('22', '1', '22', 'đáp án sai 2', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('23', '1', '22', 'đáp án sai 3', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('24', '1', '22', 'đáp án 2', '2', '1544622091', null);
INSERT INTO `question_answer` VALUES ('25', '1', '23', 'trả lời sai 3', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('26', '1', '23', 'trả lời sai 4', '1', '1544622091', null);
INSERT INTO `question_answer` VALUES ('27', '1', '23', 'đáp án 3', '2', '1544622091', null);
INSERT INTO `question_answer` VALUES ('28', '1', '25', 'sai', '1', '1544871461', null);
INSERT INTO `question_answer` VALUES ('29', '1', '25', 'sai tiếp', '1', '1544871461', null);
INSERT INTO `question_answer` VALUES ('30', '1', '25', 'lại sai', '1', '1544871461', null);
INSERT INTO `question_answer` VALUES ('31', '1', '25', 'đúng', '2', '1544622189', null);
INSERT INTO `question_answer` VALUES ('32', '1', '26', 'sai 2', '1', '1544871461', null);
INSERT INTO `question_answer` VALUES ('33', '1', '26', 'sai 3', '1', '1544871461', null);
INSERT INTO `question_answer` VALUES ('34', '1', '26', 'đúng 1', '2', '1544622189', null);
INSERT INTO `question_answer` VALUES ('35', '1', '28', 'đúng rồi', '2', '1544622237', null);
INSERT INTO `question_answer` VALUES ('36', '1', '29', 'sai nhé', '2', '1544622237', null);
INSERT INTO `question_answer` VALUES ('37', '1', '32', 'sai', '1', '1544622347', null);
INSERT INTO `question_answer` VALUES ('38', '1', '32', 'sai 1', '1', '1544622347', null);
INSERT INTO `question_answer` VALUES ('39', '1', '32', 'đúng', '2', '1544622347', null);
INSERT INTO `question_answer` VALUES ('40', '1', '33', 'đúng', '1', '1544622347', null);
INSERT INTO `question_answer` VALUES ('41', '1', '33', 'đúng 1', '1', '1544622347', null);
INSERT INTO `question_answer` VALUES ('42', '1', '33', 'sai', '2', '1544622347', null);
INSERT INTO `question_answer` VALUES ('43', '1', '35', 'sai 1', '1', '1544622418', null);
INSERT INTO `question_answer` VALUES ('44', '1', '35', 'sai 2', '1', '1544622418', null);
INSERT INTO `question_answer` VALUES ('45', '1', '35', 'hà nội', '2', '1544622418', null);
INSERT INTO `question_answer` VALUES ('46', '1', '36', 'sai nhé', '1', '1544622418', null);
INSERT INTO `question_answer` VALUES ('47', '1', '36', 'hạ long', '2', '1544622418', null);
INSERT INTO `question_answer` VALUES ('48', '1', '38', 'sai nhé', '1', '1544622651', null);
INSERT INTO `question_answer` VALUES ('49', '1', '38', 'sai nhá', '1', '1544622651', null);
INSERT INTO `question_answer` VALUES ('50', '1', '38', 'đúng rồi', '2', '1544622651', null);
INSERT INTO `question_answer` VALUES ('51', '1', '39', 'sai sai', '1', '1544622651', null);
INSERT INTO `question_answer` VALUES ('52', '1', '39', 'sai sao', '1', '1544622651', null);
INSERT INTO `question_answer` VALUES ('53', '1', '39', 'đúng rồi', '2', '1544622651', null);
INSERT INTO `question_answer` VALUES ('54', '1', '42', 'đúng', '2', '1544622811', null);
INSERT INTO `question_answer` VALUES ('55', '1', '43', 'sai', '2', '1544622811', null);
INSERT INTO `question_answer` VALUES ('56', '1', '55', 'uu', '1', '1544930889', null);
INSERT INTO `question_answer` VALUES ('57', '1', '55', 'yy', '2', '1544930875', null);
