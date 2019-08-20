/*
Navicat MySQL Data Transfer

Source Server         : lop_cua_toi
Source Server Version : 50642
Source Host           : 159.65.34.155:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2018-12-20 12:09:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user_wallet
-- ----------------------------
DROP TABLE IF EXISTS `user_wallet`;
CREATE TABLE `user_wallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `xu` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1:active 0:deactive',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_wallet
-- ----------------------------
INSERT INTO `user_wallet` VALUES ('1', '5', '0', '1', '1542945922', null);
INSERT INTO `user_wallet` VALUES ('2', '1', '9950000', '1', '1542945922', null);
INSERT INTO `user_wallet` VALUES ('4', '3', '0', '1', '1542945922', null);
INSERT INTO `user_wallet` VALUES ('5', '6', '750000', '1', '1542990329', null);
INSERT INTO `user_wallet` VALUES ('6', '7', '0', '1', '1544869397', null);
INSERT INTO `user_wallet` VALUES ('7', '8', '0', '1', '1544977051', null);
