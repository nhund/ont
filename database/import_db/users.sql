/*
Navicat MySQL Data Transfer

Source Server         : lop_cua_toi
Source Server Version : 50642
Source Host           : 159.65.34.155:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2018-12-20 12:03:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1: active 2:block 0:deactive',
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `level` int(11) DEFAULT NULL COMMENT '1:student 2:teacher 6:admin',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `school_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_full_name_unique` (`full_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'thanhdv193@gmail.com', 'Đỗ Văn Thanh', '01647519202', '2', '1542844800', '1', 'public/images/user/avatar/1/1542813691_test 1.jpg', '6', '$2y$10$MarMeF8y8B6vu9glC7TrG.qEif41Jp0spi4XahvkwF57eg27h8vt6', '1542255502','1542255502', 'uCjoviu8ulnEbax6YrPSXygyTj6j02CD3VD5QLYOBHIHLF7hdrLmcLTRcE05', 'xxxxxx', null);
INSERT INTO `users` VALUES ('3', 'daicadoibung', 'gb91lpt@gmail.com', 'hoang', null, null, null, '1', '', '6', '$2y$10$F/Hrd2QAVelGTDKKaLrDt.0HT/eWZjncP4jxuN9TS/rd4iXhEAcU6', '1542708921','1542708921', 'jj0f8B3D1V7cRMJhs3WH3YVogTHPRfYQQfzpP5prPyNdXiz7chiw8ndMsXIF', null, null);
INSERT INTO `users` VALUES ('6', null, 'nguyenhoanganh.hht@gmail.com', 'Ôn thi EZ', '036.9999.123', null, '1545066000', '1', 'public/images/user/avatar/6/1545125919_.png', '6', '$2y$10$FeGpWXonFL6ZOuCRpGqpXO.MdPos.b20hhL95vzZ2NrCoNZm1J/9i', '1542990329','1542990329', 'l7Qb4Ww6kIUFsfBEZGXuBrW8hIolRfHzGCHJqpTEDX7K3MspIziUcgIeMox4', null, null);
INSERT INTO `users` VALUES ('7', null, 'tungiosha@gmail.com', null, null, null, null, '1', '', '1', '$2y$10$Mqq4XTifm58pkpjoJwV.EOpUrLhXGeaws1oIAXx5CctSLCHT2cCcO', '1544869397','1544869397', 'e9JXd1rAqSyeo7k3WlnLoIr99pdDqK0zOG0g3U9rGgS4Hkpc4ga62WXTApfJ', null, null);
INSERT INTO `users` VALUES ('8', null, 'info.hocthongminh@gmail.com', null, null, null, null, '1', '', '1', '$2y$10$VmSXr0IelnmR5zvG.aFICuqOsZ4/aEMLtvHNa.VDmghHa2VXFQv52', '1544977051','1544977051', 'wFss6aO9owjUmFj1GJKAalbqXeKh3uJYmvUlvSddbNuZNlviICYQ2dopSAEI', null, null);
