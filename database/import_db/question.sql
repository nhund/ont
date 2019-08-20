/*
Navicat MySQL Data Transfer

Source Server         : lop_cua_toi
Source Server Version : 50642
Source Host           : 159.65.34.155:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2018-12-20 12:45:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for question
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `img_before` text CHARACTER SET utf8,
  `img_after` text CHARACTER SET utf8,
  `type` int(11) DEFAULT NULL COMMENT '1:flashcard',
  `parent_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `explain_before` text CHARACTER SET utf8,
  `explain_after` text CHARACTER SET utf8,
  `question` text CHARACTER SET utf8,
  `question_after` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1', 'test', null, null, '1', null, '6', '2', '1543885656', null, null, null, null, null);
INSERT INTO `question` VALUES ('2', 'fsfsafsa', null, null, '1', '1', '6', '2', '1543885656', null, null, null, null, null);
INSERT INTO `question` VALUES ('3', 'Hướng dẫn làm', null, null, '1', null, '13', '6', '1543984744', null, null, null, null, null);
INSERT INTO `question` VALUES ('4', 'có bao nhiêu người', null, null, '1', '3', '13', '6', '1543984744', null, null, null, null, null);
INSERT INTO `question` VALUES ('5', 'Tài liệu tòa án Canada cho thấy bà Mạnh Vãn Chu, giám đốc tài chính tập đoàn Huawei, Trung Quốc, người bị bắt tại Vancouver hồi tuần trước, giữ đến 7 hộ chiếu, trong đó có 4 hộ chiếu Trung Quốc và ba hộ chiếu Hong Kong, South China Morning Post ngày 9/12 đưa tin.\r\n\r\n\"Trong 11 năm qua, bà Mạnh được cấp không dưới 7 hộ chiếu khác nhau từ cả Trung Quốc và Hong Kong\", một bức thư gửi từ Bộ Tư pháp Mỹ cho Canada viết, cảnh báo về rủi ro giám đốc Huawei có thể bỏ trốn nếu được bảo lãnh. Bức thư cũng nêu cụ thể số của từng hộ chiếu.', '/images/exercise/anh111544415848.jpg', '/images/exercise/anh121544415853.jpg', '1', '0', '17', '5', '1544415874', null, 'đây là gợi ý cho ảnh 1', 'đây là gợi ý cho ảnh 2', 'Đây là cô giáo đúng không?', null);
INSERT INTO `question` VALUES ('6', 'Người phát ngôn Cơ quan Nhập cư Hong Kong từ chối bình luận về các trường hợp đơn lẻ song xác nhận những người được cấp hộ chiếu của đặc khu chỉ có thể sở hữu một hộ chiếu có hiệu lực trong mỗi lần cấp. Có trường hợp người sở hữu hộ chiếu sẽ nộp đơn xin giữ một hộ chiếu cũ và không còn hiệu lực do hết hạn hay hư hỏng. Hộ chiếu này có khả năng vẫn còn visa hiệu lực nên sẽ dùng kết hợp với hộ chiếu mới. Tuy nhiên, bản thân hộ chiếu cũ vẫn không có giá trị sử dụng riêng rẽ.', null, null, '2', '0', '17', '5', '1544416002', null, null, null, null, null);
INSERT INTO `question` VALUES ('7', 'VFF khẳng định đây là trang giả mạo, không có liên hệ với ban tổ chức, đồng thời nhấn mạnh chỉ hợp tác với Công ty Cổ phần GMO-Z.com RUNSYSTEM để bán vé online các trận đấu tại AFF Cup 2018 và sẽ không chịu trách nhiệm với các giao dịch được thực hiện trên các trang web giả mạo.\r\n\r\nLường trước nguy cơ có thể xuất hiện các trang web bán vé giả mạo khác, VFF đề nghị người hâm mộ nếu phát hiện những trường hợp này, có thể thông báo cho ban tổ chức qua địa chỉ email info@vff.org.vn. VFF cũng khuyến cáo người hâm mộ nên truy cập trang chủ của VFF ở địa chỉ http://www.vff.org.vn để liên kết tới trang bán vé nhằm tránh nhầm lẫn.\r\n\r\nVé của trận chung kết lượt về giữa Việt Nam và Malaysia sẽ được bán qua đường online theo bốn đợt: 10h, 16h, 22h ngày 10/12 và 10h ngày 11/12. Sau khi mua thành công, khách hàng có thể nhận theo hai cách dưới đây:\r\n\r\n- Thứ nhất, chuyển trực tiếp qua dịch vụ bưu c', null, null, '3', '0', '17', '5', '1544416140', null, null, null, null, null);
INSERT INTO `question` VALUES ('8', null, null, null, '3', '7', '17', '5', '1544416140', null, 'gợi ý cho câu hỏi 1', null, 'Việt nam có vô địch aff ___ ?', null);
INSERT INTO `question` VALUES ('9', null, null, null, '3', '7', '17', '5', '1544416140', null, 'châu á nhé', null, 'Việt nam là đất nước ở châu __ ?', null);
INSERT INTO `question` VALUES ('10', 'VFF khẳng định đây là trang giả mạo, không có liên hệ với ban tổ chức, đồng thời nhấn mạnh chỉ hợp tác với Công ty Cổ phần GMO-Z.com RUNSYSTEM để bán vé online các trận đấu tại AFF Cup 2018 và sẽ không chịu trách nhiệm với các giao dịch được thực hiện trên các trang web giả mạo.\r\n\r\nLường trước nguy cơ có thể xuất hiện các trang web bán vé giả mạo khác, VFF đề nghị người hâm mộ nếu phát hiện những trường hợp này, có thể thông báo cho ban tổ chức qua địa chỉ email info@vff.org.vn. VFF cũng khuyến cáo người hâm mộ nên truy cập trang chủ của VFF ở địa chỉ http://www.vff.org.vn để liên kết tới trang bán vé nhằm tránh nhầm lẫn.\r\n\r\nVé của trận chung kết lượt về giữa Việt Nam và Malaysia sẽ được bán qua đường online theo bốn đợt: 10h, 16h, 22h ngày 10/12 và 10h ngày 11/12. Sau khi mua thành công, khách hàng có thể nhận theo hai cách dưới đây:\r\n\r\n- Thứ nhất, chuyển trực tiếp qua dịch vụ bưu chính cho khách hàng có địa chỉ thuộc 12 quận nội thành Hà Nội, với điều kiện phải có thẻ Chứng minh Nhân dân hoặc thẻ Căn cước gốc để đối chiếu.\r\n\r\n- Thứ hai, trả tại trụ sở VFF từ 9h đến 16h30 ngày 13/12 và 14/12 cho những CĐV ngoại tỉnh hoặc không nhận qua chuyển phát.', null, null, '4', '0', '17', '5', '1544416298', null, null, null, null, null);
INSERT INTO `question` VALUES ('11', null, null, null, '4', '10', '17', '5', '1544416298', null, null, null, 'Kutty Abba, 21 tuổi, nhận rất nhiều chỉ trích ở trong nước sau những trận đầu tiên của Malaysia tại giải năm nay', null);
INSERT INTO `question` VALUES ('12', null, null, null, '4', '10', '17', '5', '1544416298', null, null, null, 'Ở giai đoạn đầu, rất nhiều người chỉ trích chúng tôi ?', null);
INSERT INTO `question` VALUES ('13', null, null, null, '4', '10', '17', '5', '1544416298', null, null, null, 'Trước đây, theo Hiệp định này, hai nước thống nhất những người Việt đến Mỹ trước ngày 12/7/1995', null);
INSERT INTO `question` VALUES ('14', 'Đoạn văn cho flashcard', '/images/exercise/upload_111313a21648419a8d5de78fdef6965b_large1544621769.jpg', '/images/exercise/upload_fa49b8602229425b953cd171778c8249_large1544621772.jpg', '1', '0', '21', '1', '1544621793', '1544871530', 'gợi ý cho mặt trước', 'gợi ý cho mặt sau', 'đây là ảnh của cô giáo ?', null);
INSERT INTO `question` VALUES ('15', 'Người ta thường nói \"biết mình biết người, trăm trận trăm thắng\". Mấu chốt vấn đề là ông Park rất hiểu cầu thủ. Ông ấy thuyết phục được từng VĐV rằng ai nên đá trước, ai nên đá sau, và chứng minh bằng kết quả thực tiễn trên sân. Khi có trong tay những kết quả thuận lợi, HLV vừa có thêm tự tin để toan tính những trận kế tiếp, vừa có sự nể phục từ cầu thủ. Ví dụ trận gặp Malaysia vừa rồi, ai cũng nghĩ là Đức Chinh dứt điểm không tốt, nhưng đặt một người khác thay cậu ấy, chắc gì người đó đã nhìn thấy cơ hội hoặc đủ tốc độ băng lên từ những đường chuyền tuyến dưới. Nhiệm vụ của tiền đạo là ghi bàn, nhưng ở một trận đấu cụ thể, có thể họ sẽ phải sắm những vai khác', null, null, '2', '0', '21', '1', '1544621885', null, null, null, null, null);
INSERT INTO `question` VALUES ('16', 'ĐNgày 12/12, ông Nguyễn Văn Huy - Trưởng phòng Giáo dục và Đào tạo huyện Hà Trung (Thanh Hóa) cho hay, cơ quan chức năng đang làm rõ việc một bé trai 10 tuổi bị sư trụ trì nuôi dưỡng bạo hành.\r\n\r\nTrước đó, cô giáo Phạm Thị Nhuần, giáo viên trường Tiểu học Hà Hải, huyện Hà Trung tố cáo, nhiều lần phát hiện học trò bị đánh đập thậm tệ.', null, null, '3', '0', '21', '1', '1544621987', null, null, null, null, null);
INSERT INTO `question` VALUES ('17', null, null, null, '3', '16', '21', '1', '1544621987', null, 'là thành phố', null, 'thủ đô của viejt nam là ___ ?', null);
INSERT INTO `question` VALUES ('18', null, null, null, '3', '16', '21', '1', '1544621987', null, 'gợi ý dân tộc', null, 'việt nam có ___ dân tộc ?', null);
INSERT INTO `question` VALUES ('19', null, null, null, '3', '16', '21', '1', '1544621987', null, 'gựi ý', null, 'câu cuối này là gi __ ?', null);
INSERT INTO `question` VALUES ('20', 'đề bài cho câu hỏi trác nghiệm ?', null, null, '4', '0', '21', '1', '1544622091', null, null, null, null, null);
INSERT INTO `question` VALUES ('21', null, null, null, '4', '20', '21', '1', '1544622091', null, null, null, 'câu hỏi 1', null);
INSERT INTO `question` VALUES ('22', null, null, null, '4', '20', '21', '1', '1544622091', null, null, null, 'câu hỏi 2', null);
INSERT INTO `question` VALUES ('23', null, null, null, '4', '20', '21', '1', '1544622091', null, null, null, 'câu hỏi 3', null);
INSERT INTO `question` VALUES ('24', 'Theo đó, các đơn vị chuyên môn đánh giá có 3 nhóm nguyên nhân gây nứt dầm thép CB6 trên đỉnh trụ P29 cầu Vàm Cống là tập trung ứng suất, ứng suất dư và chất lượng đường hàn ráp nối các cấu kiện', null, null, '4', '0', '23', '1', '1544622189', '1544871461', null, null, null, null);
INSERT INTO `question` VALUES ('25', null, null, null, '4', '24', '23', '1', '1544622189', '1544871461', null, null, 'Không muốn học, muốn xem đá bóng', null);
INSERT INTO `question` VALUES ('26', null, null, null, '4', '24', '23', '1', '1544622189', '1544871461', null, null, 'Trước đó, cô giáo Phạm Thị Nhuần, giáo viên trường Tiểu học Hà Hải, huyện Hà Trung tố cáo, nhiều lần phát hiện học trò bị đánh đập thậm tệ.', null);
INSERT INTO `question` VALUES ('27', 'Bộ Giao thông Vận tải đã kiểm định, đánh giá độc lập. Bộ đồng thời phối hợp với Hội đồng Nghiệm thu nhà nước các công trình xây dựng (Bộ Xây dựng) và các chuyên gia đầu ngành đánh giá nguyên nhân, lựa chọn giải pháp khắc phục.\r\n\r\nTheo đó, các đơn vị chuyên môn đánh giá có 3 nhóm nguyên nhân gây nứt dầm thép CB6 trên đỉnh trụ P29 cầu Vàm Cống là tập trung ứng suất, ứng suất dư và chất lượng đường hàn ráp nối các cấu kiện.', null, null, '3', '0', '23', '1', '1544622237', null, null, null, null, null);
INSERT INTO `question` VALUES ('28', null, null, null, '3', '27', '23', '1', '1544622237', null, 'gợi ý nhé', null, 'câu hỏi tiếp theo __ ?', null);
INSERT INTO `question` VALUES ('29', null, null, null, '3', '27', '23', '1', '1544622237', null, 'gợi ý 3', null, 'câu hỏi số 2', null);
INSERT INTO `question` VALUES ('30', 'Bộ Giao thông Vận tải đã kiểm định, đánh giá độc lập. Bộ đồng thời phối hợp với Hội đồng Nghiệm thu nhà nước các công trình xây dựng (Bộ Xây dựng) và các chuyên gia đầu ngành đánh giá nguyên nhân, lựa chọn giải pháp khắc phục.\r\n\r\nTheo đó, các đơn vị chuyên môn đánh giá có 3 nhóm nguyên nhân gây nứt dầm thép CB6 trên đỉnh trụ P29 cầu Vàm Cống là tập trung ứng suất, ứng suất dư và chất lượng đường hàn ráp nối các cấu kiện.', '/images/exercise/Rectangleflash_demo1544622272.png', '/images/exercise/upload_0c844e6fb48a476a931189cd8f690e2e_large1544622276.jpg', '1', '0', '24', '1', '1544622289', null, 'gợi sy 1', 'gợi ý 2', 'đây là ảnh đẹp', null);
INSERT INTO `question` VALUES ('31', 'Trong văn bản tham mưu gửi UBND TP HCM, Sở Quy hoạch - Kiến trúc đề nghị loại bỏ sân golf Tân Sơn Nhất khỏi quy hoạch của thành phố.\r\n\r\nViệc này dựa trên quyết định hồi tháng 8 của Bộ GTVT về điều chỉnh quy hoạch chi tiết Cảng hàng không quốc tế Tân Sơn Nhất. Phần diện tích sân golf sẽ được làm nhà ga, khu hangar và một phần cây xanh hồ điều tiết.\r\n\r\nSân golf trong sân bay Tân Sơn Nhất có quy mô gần 160 ha, 36 lỗ, kết hợp các dịch vụ vui chơi giải trí cao cấp, trung tâm hội nghị, khách sạn 5 sao, khu nhà ở cho thuê và công trình công cộng.', null, null, '4', '0', '24', '1', '1544622347', null, null, null, null, null);
INSERT INTO `question` VALUES ('32', null, null, null, '4', '31', '24', '1', '1544622347', null, null, null, 'đây là đoạn văn ngắn ?', null);
INSERT INTO `question` VALUES ('33', null, null, null, '4', '31', '24', '1', '1544622347', null, null, null, 'đây là đoạn văn dài?', null);
INSERT INTO `question` VALUES ('34', 'Theo quyết định năm 2014 của Thủ tướng về điều chỉnh bổ sung danh mục sân golf dự kiến phát triển đến năm 2020, TP HCM định hướng quy hoạch 5 dự án tại: sân GS Củ Chi (xã Tân Thông Hội), Sing - Việt (Bình Chánh), Lâm Viên (quận 9), khu sân golf và dịch vụ tại sân bay Tân Sơn Nhất (quận Tân Bình), khu hỗn hợp sân golf thể thao, nhà ở tại phường An Phú (quận 2).\r\n\r\nTrong đó, dự án sân golf ở quận 2 đã chuyển công năng thành khu đô thị Sài Gòn Bình An từ năm 2015; sân GS Củ Chi đã điều chỉnh giảm quy mô từ 36 lỗ (200 ha) xuống còn 18 lỗ (90 ha); sân golf Sing - Việt có quy mô 70 ha tại xã Lê Minh Xuân đang trong quá trình nghiên cứu lập quy hoạch 1/500. Sân Lâm Viên có quy mô 300 ha đang hoạt động.', null, null, '4', '0', '25', '1', '1544622418', null, null, null, null, null);
INSERT INTO `question` VALUES ('35', null, null, null, '4', '34', '25', '1', '1544622418', null, null, null, 'Trong đó, dự án sân golf ở quận 2 đã chuyển công năng thành khu đô', null);
INSERT INTO `question` VALUES ('36', null, null, null, '4', '34', '25', '1', '1544622418', null, null, null, 'Gòn Bình An từ năm 2015; sân GS Củ Chi đã điều chỉnh giảm quy mô từ 36 lỗ (200 ha) xuống còn 18 lỗ (90 ha)', null);
INSERT INTO `question` VALUES ('37', 'Hồi đầu năm, trong kỳ họp thứ 23 từ 12 đến 13/3, Ủy ban Kiểm tra Trung ương đã xem xét, thi hành kỷ luật ông Trần Quốc Cường - Ủy viên Trung ương Đảng, Phó bí thư Tỉnh ủy Đắk Lắk, nguyên Bí thư Đảng ủy, Cục trưởng Cục Chính trị - Hậu cần B41 (hàm thiếu tướng), Tổng cục V, Bộ Công an.', null, null, '4', '0', '28', '1', '1544622651', null, null, null, null, null);
INSERT INTO `question` VALUES ('38', null, null, null, '4', '37', '28', '1', '1544622651', null, null, null, 'Theo đó, trong thời gian giữ cương vị Bí thư Đảng ủy, Cục trưởng Cục B41', null);
INSERT INTO `question` VALUES ('39', null, null, null, '4', '37', '28', '1', '1544622651', null, null, null, 'Theo đó, trong thời gian giữ cương vị Bí thư Đảng ủy, Cục trưởng Cục B41 Theo đó, trong thời gian giữ cương vị Bí thư Đảng ủy, Cục trưởng Cục B41', null);
INSERT INTO `question` VALUES ('40', 'Đoạn văn cho câu hỏi số 1', '/images/exercise/Rectangleflash_demo1544622732.png', '/images/exercise/Beetle-Bug-Origami-Design-215433843801544622735.jpg', '1', '0', '28', '1', '1544622747', null, 'gợi ý 1', 'gợi ý 2', 'đây là con bọ cạp ?', null);
INSERT INTO `question` VALUES ('41', 'Theo ghi nhận, các diện tích lúa non bán cho thương lái tại xã Đại Hòa Lộc (Bình Đại). Sau khi cắt bán hết bông lúa non trên ruộng, hiện cây lúa tiếp tục cho bông mới (dân địa phương gọi là bông chét), sắp thu hoạch đợt hai.\r\n\r\nÔng Nguyễn Văn Tuấn, người vừa bán 2.300 m2 lúa non cho biết, đây là diện tích lúa mùa mỗi năm chỉ thu hoạch một vụ. Những năm trước ông đều đợi lúa chín rồi mới thu hoạch như các đám ruộng khác. Vụ năm nay, khoảng một tháng trước, khi lúa vừa trổ bông, một người đàn ông đang tạm trú trên địa bàn đến ruộng ông đặt vấn đề mua bông lúa non.', null, null, '3', '0', '29', '1', '1544622811', null, null, null, null, null);
INSERT INTO `question` VALUES ('42', null, null, null, '3', '41', '29', '1', '1544622811', null, 'gợi ý 1', null, 'Sau khi thống nhất giá 10.000 đồng mỗi kg, người ___ đàn ông nói trên cho hai nhân công đến cắt bông lúa non rồi chở về TP HCM ?', null);
INSERT INTO `question` VALUES ('43', null, null, null, '3', '41', '29', '1', '1544622811', null, 'gợi ý 2', null, 'Ông Tuấn cho biết đã bán tổng cộng 500 kg bông lúa non __ ?', null);
INSERT INTO `question` VALUES ('44', '1.1 Khái niệm chủ nghĩa Mác-Lênin?', null, null, '2', '0', '33', '6', '1544869935', '1544957158', null, null, null, null);
INSERT INTO `question` VALUES ('45', 'đoạn văn xxx', '/images/exercise/47574849_1057642111076216_1833987229081403392_n1544870874.jpg', '/images/exercise/47683378_1058671274306633_897824700904767488_n1544870878.jpg', '1', '0', '23', '1', '1544870886', null, 'ttt', 'tttyyy', 'hhh', 'uuuu');
INSERT INTO `question` VALUES ('46', 'Việt Nam vô địch', null, null, '2', '0', '36', '6', '1544871372', null, null, null, null, null);
INSERT INTO `question` VALUES ('47', 'đoạn văn 1', '/images/exercise/banner1544871981.jpg', '/images/exercise/banner1544871986.jpg', '1', '0', '36', '6', '1544872006', null, 'gợi ý 1', 'gợi y2', 'nội dung mặt trước 1', 'nội dung mặt sau');
INSERT INTO `question` VALUES ('48', 'ádasd', null, null, '1', '0', '23', '1', '1544872161', null, 'sieu nhân', 'khong dươc', 'mặt trước', 'mặt sau');
INSERT INTO `question` VALUES ('49', 'Hướng dẫn sử dụng', null, null, '2', '0', '23', '1', '1544872262', null, null, null, null, null);
INSERT INTO `question` VALUES ('50', null, null, null, '1', '0', '23', '1', '1544872308', null, null, null, 'Đây là mặt trước', 'Đây là mặt sau');
INSERT INTO `question` VALUES ('51', 'đoạn văn xxx', null, null, '2', '0', '23', '1', '1544872430', null, null, null, null, null);
INSERT INTO `question` VALUES ('52', 'xxxx55555555', null, null, '2', '0', '23', '1', '1544874997', '1544890495', null, null, null, null);
INSERT INTO `question` VALUES ('53', 'chuoi 1 doan van', null, null, '2', '0', '23', '1', '1544890683', null, null, null, null, null);
INSERT INTO `question` VALUES ('54', 'yyy', null, null, '4', '0', '21', '1', '1544930875', '1544930889', 'yyyttt', null, null, null);
INSERT INTO `question` VALUES ('55', null, null, null, '4', '54', '21', '1', '1544930875', '1544930889', 'tt', null, 'ttt', null);
INSERT INTO `question` VALUES ('56', 'Khái niệm chủ nghĩa Mác-Lênin?', null, null, '2', '0', '41', '6', '1544960236', '1544974128', null, null, null, null);
INSERT INTO `question` VALUES ('58', 'Những điều kiện và tiền đề ra đời chủ nghĩa Mác - Lênin', null, null, '2', '0', '41', '6', '1544976074', null, null, null, null, null);
INSERT INTO `question` VALUES ('60', 'Khái niệm chủ nghĩa Mác-Lênin?', null, null, '2', '0', '43', '6', '1545042161', '1545047478', null, null, null, null);
INSERT INTO `question` VALUES ('61', 'Những điều kiện và tiền đề ra đời chủ nghĩa Mác - Lênin?', null, null, '2', '0', '43', '6', '1545046481', null, null, null, null, null);
INSERT INTO `question` VALUES ('63', 'Câu 1.1 Khái niệm chủ nghĩa Mác-Lênin', null, null, '2', '0', '44', '6', '1545051145', '1545217494', null, null, null, null);
INSERT INTO `question` VALUES ('64', 'Câu 1.2 Những điều kiện và tiền đề ra đời chủ nghĩa Mác - Lênin?', null, null, '2', '0', '44', '6', '1545051545', '1545060845', null, null, null, null);
INSERT INTO `question` VALUES ('65', 'Câu 1.3 Mối quan hệ biện chứng giữa 3 bộ phận cấu thành của CNMLN?', null, null, '2', '0', '44', '6', '1545052510', '1545061318', null, null, null, null);
INSERT INTO `question` VALUES ('66', 'Câu 2.1 Nội dung vấn đề cơ bản của triết học?', null, null, '2', '0', '44', '6', '1545061634', null, null, null, null, null);
INSERT INTO `question` VALUES ('67', 'Câu 2.2 Sự đối lập của chủ nghĩa duy vật và duy tâm trong vấn đề giải quyết vấn đề cơ bản của triết học?', null, null, '2', '0', '44', '6', '1545061951', '1545062230', null, null, null, null);
INSERT INTO `question` VALUES ('68', 'Câu 2.3 Các trường phái triết học lịch sử?', null, null, '2', '0', '44', '6', '1545124400', '1545124441', null, null, null, null);
INSERT INTO `question` VALUES ('69', 'Câu 3.1: Khái niệm chủ nghĩa duy vật?', null, null, '1', '0', '44', '6', '1545124677', '1545124943', 'trường phái lớn, lập trường duy vật,', null, 'Khái niệm chủ nghĩa duy vật?', '- Chủ nghĩa duy vật là một trong những trường phái triết học lớn trong lịch sử, bao gồm trong đó toàn bộ các học thuyết triết học được xây dựng trên lập trường duy vật trong việc giải quyết vấn đề cơ bản của triết học: vật chất là tính thứ nhất, ý thức là tính thứ hai của mọi tồn tại trên thế giới; cũng tức là thừa nhận và minh chứng rằng: suy đến cùng, bản chất và cơ sở của mọi tồn tại trong thế giới tự nhiên và xã hội chính là vật chất.');
INSERT INTO `question` VALUES ('70', 'Câu 3.2 Hình thức cơ bản của chủ nghĩa duy vật?', null, null, '2', '0', '44', '6', '1545125098', null, null, null, null, null);
INSERT INTO `question` VALUES ('71', 'Câu 3.3 Khẳng định chủ nghĩa duy vật là hình thức phát triển cao nhất của chủ nghĩa duy vật lịch sử?', null, null, '2', '0', '44', '6', '1545125503', '1545125551', null, null, null, null);
INSERT INTO `question` VALUES ('72', null, null, null, '5', '0', '21', '1', '1545151755', null, null, null, null, null);
INSERT INTO `question` VALUES ('73', null, null, null, '5', '72', '21', '1', '1545151755', null, null, null, '<p>đoạn văn xxx <a class=\"clozetip\" title=\"xxx\" href=\"#\">xxx</a></p>', null);
INSERT INTO `question` VALUES ('74', null, null, null, '5', '72', '21', '1', '1545151755', null, null, null, '<p><a class=\"cloze\" href=\"#mce_temp_url#\">czczx</a> ádasd</p>', null);
INSERT INTO `question` VALUES ('76', null, null, null, '5', '75', '46', '6', '1545194184', '1545194629', null, null, '<p>I. Phần 1<br />Câu 1: <br />1.1: Đối tượng nghiên cứu<br />- Bao gồm hệ thống các <a class=\"clozetip\" title=\"chán chẳng buồn nói\" href=\"#\">quan điểm</a>, <a class=\"clozetip\" title=\"có bao nhiêu\" href=\"#\">quan niệm</a>, <a class=\"clozetip\" title=\"lý luận\" href=\"#\">lý luận</a> được thể hiện trong toàn bộ di sản của Người. Di sản của Người gồm cuộc đời, sự nghiệp, các bài nói, bài viết,...<br />- Còn là quá trình vận động, hiện thực hóa các quan điểm, lý luận đó trong thực tiễn CMVN. Đó là quá trình mang tính quy luật bao gồm 2 mặt thống nhất biện chứng: <a class=\"clozetip\" title=\"cứ mỗi khi\" href=\"#\">sản sinh </a>tư tưởng và <a class=\"clozetip\" title=\"siêu nhân hành động\" href=\"#\">hiện thực</a> hóa tư tưởng theo mục tiêu độc lập dân tộc, dân chủ, chủ nghĩa xã hội, giải phóng dân tộc, gp giai cấp, gp con người<br />1.2: Nhiệm vụ<br />- Cơ sở hình thành TTHCM qua đó khẳng định sự ra đời của TTHCM là tất yếu khách quan và giải quyết các vấn đề lịch sử dân tộc đặt ra<br />+ Cơ sở khách quan<br />+ Cơ sở chủ quan<br />- Các giai đoạn hình thành, phát triển TTHCM<br />- ND, bản chất CM, đặc điểm của các quan điểm trong hệ thống TTHCM<br />- Vai trò, nền tảng tư tưởng, kim chỉ nam hành động của TTHCM đối với CMVN<br />- Quá trình nhận thức, vận dụng, phát triển TTHCM qua các giai đoạn CM của Đảng và Nhà nước ta<br />- Các giá trị tư tưởng lý luận của TTHCM đối với kho tàng tư tưởng lý luận CM thế giới của thời đại</p>', null);
INSERT INTO `question` VALUES ('77', '1.1 Đối tượng nghiên cứu của môn học Tư Tưởng Hồ Chí Minh?', null, null, '2', '0', '46', '6', '1545212540', null, null, null, null, null);
INSERT INTO `question` VALUES ('78', '1.2 Nhiệm vụ của môn học?', null, null, '2', '0', '46', '6', '1545212824', null, null, null, null, null);
INSERT INTO `question` VALUES ('79', 'Câu 2.1  Nội dung quan điểm thực tiễn và nguyên tắc lý luận gắn liền với thực tiễn?', null, null, '2', '0', '46', '6', '1545214495', null, null, null, null, null);
INSERT INTO `question` VALUES ('80', 'Câu 2.2 Nguyễn tắc kết hợp nghiên cứu tác phẩm với thực tiễn chỉ đạo CM?', null, null, '2', '0', '46', '6', '1545214617', null, null, null, null, null);
INSERT INTO `question` VALUES ('81', 'Câu 3. Các phương pháp cụ thể được áp dụng trong nghiên cứu TTHCM?', null, null, '2', '0', '46', '6', '1545214719', null, null, null, null, null);
INSERT INTO `question` VALUES ('82', 'Câu 4.1 ND quan điểm lịch sử cụ thể?', null, null, '2', '0', '46', '6', '1545215181', null, null, null, null, null);
INSERT INTO `question` VALUES ('83', 'Câu 4.1 Trình bày quan điểm vật chất của các nhà triết học trước Mác?', null, null, '2', '0', '44', '6', '1545218360', null, null, null, null, null);
