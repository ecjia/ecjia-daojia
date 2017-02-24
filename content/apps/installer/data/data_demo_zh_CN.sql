# ************************************************************
#
# 到家数据库安装脚本
# 插入 演示数据
#
# ************************************************************

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_store_franchisee` 演示店铺
--

INSERT INTO `ecjia_store_franchisee` 
VALUES (62, 4, 1, 'self', '天天果园', '水果，进口水果，时令，国产', 1, 0, '张三', '', 'xxx@ecmoban.com', '15012345678', 1478741085, 1478741104, '普陀区中山北路3553号', '1', 'xxxxxxxxxxxxxxxxxxxxx', '', '', '', 2, '', '', '', '', '', '', '', 1, '', '121.41618102314', '31.235278361951', 'wtw3dyhwdj', 50, 25, 321, 2709);

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_region` 店长
--

INSERT INTO `ecjia_staff_user` VALUES ('1', '15012345678', '62', '张三', '向日葵', 'SC001', 'xxxx@ecmoban.com', '6c59d1130f20b75a1a685fc46d3eea39', '2016', '1440558624', '0', '0.0.0.0', 'all', '', null, '0', '', '好品质，好店铺！', '4');

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_category` 商品分类
--

INSERT INTO `ecjia_category` VALUES ('924', '猪禽', '', '', '', '1055', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('933', '鲜花', '', '', '', '1191', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('953', '西瓜', '', '', '', '1038', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('994', '水产', '', '', '', '1058', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1032', '水果蔬菜', 'data/category/1459454069433195862.png', '', '', '0', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1033', '水果', 'data/category/1459099587459021592.jpg', '', '', '1032', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1034', '蔬菜', 'data/category/1458865195914261363.jpg', '', '', '1032', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1035', '苹果', '', '', '', '1033', '1', '', '', '0', '', '1', '0', '883');
INSERT INTO `ecjia_category` VALUES ('1036', '梨', '', '', '', '1033', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1037', '其他水果', '', '', '', '1033', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1038', '瓜类', '', '', '', '1033', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1039', '猕猴桃', '', '', '', '1033', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1040', '桔柚', '', '', '', '1033', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1041', '根茎类', '', '', '', '1034', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1042', '叶菜类', '', '', '', '1034', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1044', '瓜果类', '', '', '', '1034', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1045', '菇菌类', '', '', '', '1034', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1046', '调味类', '', '', '', '1034', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1047', '肉禽蛋奶', 'data/category/1459458216777256123.png', '', '', '0', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1048', '牛羊猪禽', 'data/category/1458865390542758527.jpg', '', '', '1047', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1049', '水产海鲜', 'data/category/1458865342069809919.jpg', '', '', '1047', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1050', '奶制品', 'data/category/1458865358019369414.jpg', '', '', '1047', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1051', '牛肉类', '', '', '', '1048', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1052', '羊肉', '', '', '', '1048', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1053', '猪肉', '', '', '', '1048', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1054', '内脏', '', '', '', '1048', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1055', '禽类', '', '', '', '1048', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1056', '鱼类', '', '', '', '1049', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1057', '虾蟹类', '', '', '', '1049', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1058', '其他水产', '', '', '', '1049', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1059', '牛奶', '', '', '', '1050', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1060', '酸奶', '', '', '', '1050', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1061', '乳酪类', '', '', '', '1050', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1062', '加味奶', '', '', '', '1050', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1063', '豆浆豆奶', '', '', '', '1050', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1064', '冷热速食', 'data/category/1459465496683224975.png', '', '', '0', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1065', '低温速食', 'data/category/1458865449861715783.jpg', '', '', '1064', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1066', '高温速食', 'data/category/1458865527439462801.jpg', '', '', '1064', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1067', '火锅丸类', '', '', '', '1065', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1068', '汤圆', '', '', '', '1065', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1069', '水饺/混沌', '', '', '', '1065', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1070', '速食肉类', '', '', '', '1065', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1071', '冷藏面制品', '', '', '', '1065', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1072', '方便面/粉', '', '', '', '1066', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1073', '酱菜类', '', '', '', '1066', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1074', '火腿肠', '', '', '', '1066', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1075', '罐头', '', '', '', '1066', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1076', '八宝粥', '', '', '', '1066', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1077', '果酱', '', '', '', '1066', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1078', '休闲食品', 'data/category/1459461890866804359.png', '', '', '0', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1079', '零食', 'data/category/1458865649384560215.jpg', '', '', '1078', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1080', '饼干/糕点', 'data/category/1458865692179514745.jpg', '', '', '1078', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1081', '膨化食品', '', '', '', '1079', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1082', '果干蜜饯', '', '', '', '1079', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1083', '肉感肉脯', '', '', '', '1079', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1084', '坚果', '', '', '', '1079', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1085', '巧克力', '', '', '', '1079', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1086', '果冻', '', '', '', '1079', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1087', '糖果', '', '', '', '1079', '7', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1088', '口香糖', '', '', '', '1079', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1089', '面包', '', '', '', '1080', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1090', '饼干/威化', '', '', '', '1080', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1091', '糕点', '', '', '', '1080', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1092', '酒水饮料', 'data/category/1459460778180533114.png', '', '', '0', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1093', '酒', 'data/category/1458865720134241958.jpg', '', '', '1092', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1094', '饮料', 'data/category/1458865766156077800.jpg', '', '', '1092', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1095', '冲调类', 'data/category/1458866243376641634.png', '', '', '1092', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1096', '啤酒', '', '', '', '1093', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1097', '白酒', '', '', '', '1093', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1098', '洋酒', '', '', '', '1093', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1099', '红酒', '', '', '', '1093', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1100', '黄酒', '', '', '', '1093', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1101', '其他酒', '', '', '', '1093', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1102', '水', '', '', '', '1094', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1103', '碳酸饮料', '', '', '', '1094', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1104', '功能性饮料', '', '', '', '1094', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1105', '茶饮料', '', '', '', '1094', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1106', '果汁', '', '', '', '1094', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1107', '其他饮料', '', '', '', '1094', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1108', '茶叶', '', '', '', '1095', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1109', '咖啡', '', '', '', '1095', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1110', '麦片谷物类', '', '', '', '1095', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1111', '成人奶粉', '', '', '', '1095', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1112', '果珍', '', '', '', '1095', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1113', '其他冲调类', '', '', '', '1095', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1114', '粮油调味', 'data/category/1459460131280159213.png', '', '', '0', '7', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1115', '米面杂粮', 'data/category/1458865896397146029.jpg', '', '', '1114', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1116', '油', 'data/category/1458865941015476647.jpg', '', '', '1114', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1117', '调味品', 'data/category/1458865990382084901.jpg', '', '', '1114', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1118', '干货', 'data/category/1458866031702406638.jpg', '', '', '1114', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1119', '大米', '', '', '', '1115', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1120', '面粉', '', '', '', '1115', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1121', '挂面', '', '', '', '1115', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1122', '杂粮', '', '', '', '1115', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1123', '调和油', '', '', '', '1116', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1124', '花生油', '', '', '', '1116', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1125', '大豆油', '', '', '', '1116', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1126', '橄榄油', '', '', '', '1116', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1127', '葵花油', '', '', '', '1116', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1128', '其他油', '', '', '', '1116', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1129', '盐/糖/味精', '', '', '', '1117', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1130', '其他调味', '', '', '', '1117', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1131', '酱料/醋', '', '', '', '1117', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1132', '南北干货', '', '', '', '1118', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1133', '水产干货', '', '', '', '1118', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1134', '粉丝/粉条', '', '', '', '1118', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1135', '清洁日化', 'data/category/1459461396005330093.png', '', '', '0', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1136', '面部护理', 'data/category/1458877041877528103.png', '', '', '1135', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1137', '身体护理', 'data/category/1458866498644836847.png', '', '', '1135', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1138', '洗发染发', 'data/category/1458866667694559214.png', '', '', '1135', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1139', '口腔洗浴', 'data/category/1458866687524419547.png', '', '', '1135', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1140', '衣物护理', 'data/category/1458866708212180282.png', '', '', '1135', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1141', '厨卫清洁', 'data/category/1458866736501578418.png', '', '', '1135', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1142', '洁面', 'data/category/1458866429770650501.png', '', '', '1136', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1143', '护肤', '', '', '', '1136', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1144', '面膜', '', '', '', '1136', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1145', '剃须', '', '', '', '1136', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1146', '美妆', '', '', '', '1136', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1147', '眼部保养', '', '', '', '1136', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1148', '沐浴露', '', '', '', '1137', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1149', '身体保养', '', '', '', '1137', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1150', '身体清洁', '', '', '', '1137', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1151', '洗发', '', '', '', '1138', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1152', '染发定型', '', '', '', '1138', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1153', '牙膏', '', '', '', '1139', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1154', '牙刷', '', '', '', '1139', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1155', '牙齿护理', '', '', '', '1139', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1156', '洗衣液', '', '', '', '1140', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1157', '洗衣粉', '', '', '', '1140', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1158', '柔顺剂', '', '', '', '1140', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1159', '洗衣皂', '', '', '', '1140', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1160', '衣物除菌剂', '', '', '', '1140', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1161', '消毒液', '', '', '', '1141', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1162', '杀虫用品', '', '', '', '1141', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1163', '地板清洁', '', '', '', '1141', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1164', '洗洁精', '', '', '', '1141', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1165', '油烟净', '', '', '', '1141', '255', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1166', '其他清洁工具', '', '', '', '1141', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1167', '家居用品', 'data/category/1459462285259394728.png', '', '', '0', '9', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1168', '家用电器', 'data/category/1458866944516490134.png', '', '', '1167', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1169', '厨具', 'data/category/1458866961527540453.png', '', '', '1167', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1170', '宠物生活', 'data/category/1458866988626895776.png', '', '', '1167', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1171', '纸品湿巾', 'data/category/1458867009449848674.png', '', '', '1167', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1172', '一次性用品', 'data/category/1458867032748076802.png', '', '', '1167', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1173', '家用电器', '', '', '', '1168', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1174', '电池', '', '', '', '1168', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1175', '餐具', '', '', '', '1169', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1176', '水杯/水壶', '', '', '', '1169', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1177', '狗粮', '', '', '', '1170', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1178', '猫粮', '', '', '', '1170', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1179', '宠物用品', '', '', '', '1170', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1180', '卫生纸', '', '', '', '1171', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1181', '湿巾', '', '', '', '1171', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1182', '抽纸', '', '', '', '1171', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1183', '垃圾袋', '', '', '', '1172', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1184', '纸杯', '', '', '', '1172', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1185', '一次性餐具', '', '', '', '1172', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1186', '鲜花蛋糕', 'data/category/1459462895864322155.png', '', '', '0', '10', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1187', '鲜花', 'data/category/1458867200348290600.png', '', '', '1186', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1188', '绿植多肉', 'data/category/1458867217995412503.png', '', '', '1186', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1189', '蛋糕', 'data/category/1458867235365628830.png', '', '', '1186', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1190', '外带美食', 'data/category/1458869434871096941.png', '', '', '1186', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1191', '礼品鲜花', '', '', '', '1187', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1192', '家庭鲜花', '', '', '', '1187', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1193', '庆典用花', '', '', '', '1187', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1194', '创意鲜花', '', '', '', '1187', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1195', '绿植', '', '', '', '1188', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1196', '多肉', '', '', '', '1188', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1197', '奶油蛋糕', '', '', '', '1189', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1198', '水果蛋糕', '', '', '', '1189', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1199', '其他蛋糕', '', '', '', '1189', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1200', '西式简餐', '', '', '', '1190', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1201', '炸品', '', '', '', '1190', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1202', '风味小吃', '', '', '', '1190', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1203', '其他面食', '', '', '', '1190', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1204', '医药健康', '', '', '', '0', '11', '', '', '0', '', '0', '0', '');
INSERT INTO `ecjia_category` VALUES ('1205', '中西药品', 'data/category/1458867647664425998.png', '', '', '1204', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1206', '营养保健', 'data/category/1458867669719464254.png', '', '', '1204', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1207', '家用器械', 'data/category/1458867692209140640.png', '', '', '1204', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1208', '计生用品', 'data/category/1458867709791540906.png', '', '', '1204', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1209', '眼镜', 'data/category/1458867729382793505.png', '', '', '1204', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1210', '健康服务', 'data/category/1458867770681406185.png', '', '', '1204', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1211', '感冒用药', '', '', '', '1205', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1212', '补益安神', '', '', '', '1205', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1213', '儿科用药', '', '', '', '1205', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1214', '呼吸道药', '', '', '', '1205', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1215', '男科用药', '', '', '', '1205', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1216', '胃肠用药', '', '', '', '1205', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1217', '耳鼻喉科', '', '', '', '1205', '7', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1218', '外科骨科', '', '', '', '1205', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1219', '心血管药', '', '', '', '1205', '9', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1220', '眼科用药', '', '', '', '1205', '10', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1221', '皮肤用药', '', '', '', '1205', '11', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1222', '妇科用药', '', '', '', '1205', '12', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1223', '肝胆胰类', '', '', '', '1205', '13', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1224', '精神抑郁', '', '', '', '1205', '14', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1225', '男性健康', '', '', '', '1206', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1226', '女性健康', '', '', '', '1206', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1227', '中老年健康', '', '', '', '1206', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1228', '青少儿童健康', '', '', '', '1206', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1229', '日常检测', '', '', '', '1207', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1230', '辅助器械', '', '', '', '1207', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1231', '日常护理', '', '', '', '1207', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1232', '特殊护理', '', '', '', '1207', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1233', '轮椅拐杖', '', '', '', '1207', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1234', '避孕用品', '', '', '', '1208', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1235', '性福辅助', '', '', '', '1208', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1236', '隐形眼睛', '', '', '', '1209', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1237', '框架眼睛', '', '', '', '1209', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1238', '眼睛附件', '', '', '', '1209', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1239', '健康体检', '', '', '', '1210', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1240', '上门服务', 'data/category/1459464791734452461.jpg', '', '', '0', '12', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1241', '家政保洁', 'data/category/1458868212808252812.png', '', '', '1240', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1242', '家电清洗', 'data/category/1458868276532812407.png', '', '', '1240', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1243', '洗衣洗鞋', 'data/category/1458868300684763629.png', '', '', '1240', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1244', '生活周边', 'data/category/1458868335876839764.png', '', '', '1240', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1245', '母婴护理', 'data/category/1458876645108152499.png', '', '', '1240', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1246', '按摩美业', 'data/category/1458868371918731191.png', '', '', '1240', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1247', '安装维修', 'data/category/1458868395900985882.png', '', '', '1240', '7', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1248', '汽车服务', 'data/category/1458868414366255990.png', '', '', '1240', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1249', '日常保洁', '', '', '', '1241', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1250', '深度保洁', '', '', '', '1241', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1251', '除尘除螨', '', '', '', '1241', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1252', '组合套餐', '', '', '', '1242', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1253', '空调清洗', '', '', '', '1242', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1254', '冰箱清洗', '', '', '', '1242', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1255', '抽油烟机', '', '', '', '1242', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1256', '洗衣机', '', '', '', '1242', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1257', '饮水机', '', '', '', '1242', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1258', '微波炉', '', '', '', '1242', '7', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1259', '其他家电清洗', '', '', '', '1242', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1260', '洗衣', '', '', '', '1243', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1261', '洗鞋', '', '', '', '1243', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1262', '家居家纺', '', '', '', '1243', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1263', '奢侈品护理', '', '', '', '1243', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1264', '宠物服务', '', '', '', '1244', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1265', '厨师', '', '', '', '1244', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1266', '月嫂', '', '', '', '1245', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1267', '育儿护理', '', '', '', '1245', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1268', '中医推拿', '', '', '', '1246', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1269', 'spa/足疗', '', '', '', '1246', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1270', '小儿/刮痧', '', '', '', '1246', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1271', '美容/美体', '', '', '', '1246', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1272', '美甲/美妆', '', '', '', '1246', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1273', '上门维修', '', '', '', '1247', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1279', '冷冻蔬菜', 'data/category/1459099779639967502.jpg', '', '', '1032', '8', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1280', '蛋', 'data/category/1459099868560307722.jpg', '', '', '1047', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1281', '特色禽类', 'data/category/1459099929218432413.jpg', '', '', '1047', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1282', '海产干货', 'data/category/1459100054924779845.jpg', '', '', '1047', '6', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1283', '冷冻点心', 'data/category/1459100123821288425.jpg', '', '', '1064', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1284', '冷餐熟食', 'data/category/1459100187060184473.jpg', '', '', '1064', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1285', '中式主食', 'data/category/1459100308487419292.jpg', '', '', '1064', '5', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1286', '甜品', 'data/category/1459100497724915472.jpg', '', '', '1078', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1287', '稀奶油', 'data/category/1459100608316391911.jpg', '', '', '1078', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1289', '茄果瓜果类', 'data/category/1459100860099879676.jpg', '', '', '1032', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1290', '水', 'data/category/1459101040213914235.jpg', '', '', '1092', '4', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1291', '茄子', '', '', '', '1289', '1', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1292', '番茄', '', '', '', '1289', '2', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1293', '黄瓜', '', '', '', '1289', '3', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1295', '鱼', '', '', '', '1056', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1296', '肉禽', '', '', '', '1055', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1301', '梨', '', '', '', '1036', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1302', '瓜', '', '', '', '1038', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1303', '其他水果', '', '', '', '1037', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1304', '猕猴桃', '', '', '', '1039', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1305', '牛肉', '', '', '', '1051', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1306', '羊肉', '', '', '', '1052', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1308', '猪肉', '', '', '', '1053', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1309', '禽类', '', '', '', '1055', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1310', '鱼类', '', '', '', '1056', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1311', '虾蟹贝类', '', '', '', '1057', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1312', '其他水产', '', '', '', '1058', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1313', '水果', '', '', '', '1037', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1314', '瓜果类', '', '', '', '1044', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1315', '叶菜类', '', '', '', '1042', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1316', '根茎类', '', '', '', '1041', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1317', '肉类', '', '', '', '1055', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1318', '水产海鲜', '', '', '', '1057', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1319', '桔柚', '', '', '', '1040', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1320', '进口水果', '', '', '', '1037', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1321', '蛋糕', '', '', '', '1197', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1322', '盆栽', '', '', '', '1195', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1324', '其他', '', '', '', '1289', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1325', '牛排', '', '', '', '1051', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1326', '火锅片', '', '', '', '1052', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1327', '蔬菜类', '', '', '', '1042', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1328', '佐料类', '', '', '', '1046', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1329', '口腔类', '', '', '', '1153', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1330', '洗发染发', '', '', '', '1151', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1331', '面部护理', '', '', '', '1142', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1334', '国产水果', '', '', '', '1037', '50', '', '', '0', '', '1', '0', '');
INSERT INTO `ecjia_category` VALUES ('1335', '热带水果', '', '', '', '1037', '50', '', '', '0', '', '1', '0', '');

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_merchants_category` 商店商品分类
--

INSERT INTO `ecjia_merchants_category` (`cat_id`, `store_id`, `cat_name`, `cat_desc`, `parent_id`, `sort_order`, `is_show`)
VALUES
	(2,62,'国产水果','',0,50,1),
	(4,62,'热带水果','',0,50,1),
	(8,62,'进口水果','',0,50,1),
	(10,62,'苹果','',2,50,1),
	(11,62,'梨','',2,50,1),
	(12,62,'时令水果','',0,50,1),
	(13,62,'猕猴桃','',2,50,1),
	(14,62,'柑桔橙柚','',2,50,1),
	(63,62,'礼品果篮','',0,50,1),
	(64,62,'葡萄','',8,50,1),
	(65,62,'李','',2,50,1);

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_goods` 商品
--

INSERT INTO `ecjia_goods` VALUES ('393', '62', '1037', '8', 'ECS000393', '越南红心火龙果2.5kg', '', '284', '0', '', '969', '0.000', '0', '82.80', '69.00', '0.00', '0', '0', '10', '火龙果,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551176470.jpg\\\" title=\\\"14591551176470.jpg\\\" alt=\\\"9288683649867572.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551245816.jpg\\\" title=\\\"14591551245816.jpg\\\" alt=\\\"9288683649933112.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551294935.jpg\\\" title=\\\"14591551294935.jpg\\\" alt=\\\"9288683649998647.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551328003.jpg\\\" title=\\\"14591551328003.jpg\\\" alt=\\\"9288683650064184.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551367529.jpg\\\" title=\\\"14591551367529.jpg\\\" alt=\\\"9288683650129717.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591551399722.jpg\\\" title=\\\"14591551399722.jpg\\\" alt=\\\"9288683650195250-1.jpg\\\"/></p>', 'images/201610/goods_img/393_G_1459126348866.jpg', 'images/201610/goods_img/393_G_1459126348866.jpg', 'images/201610/goods_img/393_G_1459126348866.jpg', '1', '', '1', '1', '0', '1', '1440530899', '64', '0', '0', '1', '0', '1', '0', '0', '1486346013', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('395', '62', '1037', '2', 'ECS000395', '精品红霞草莓32粒约30g/个', '', '337', '0', '', '985', '0.000', '0', '93.60', '78.00', '0.00', '0', '0', '1', '草莓,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591562627136.jpg\\\" title=\\\"14591562627136.jpg\\\" alt=\\\"513691849549291415_880x519.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591562675336.jpg\\\" title=\\\"14591562675336.jpg\\\" alt=\\\"513691849549356951_880x715-1.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591562709453.jpg\\\" title=\\\"14591562709453.jpg\\\" alt=\\\"513691849549389719_880x591.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591562743134.jpg\\\" title=\\\"14591562743134.jpg\\\" alt=\\\"513691849549422487_880x714.jpg\\\"/></p>', 'images/201610/goods_img/395_G_1459127479481.jpg', 'images/201610/goods_img/395_G_1459127479481.jpg', 'images/201610/goods_img/395_G_1459127479481.jpg', '1', '', '1', '1', '0', '1', '1440531389', '62', '0', '0', '0', '0', '1', '0', '0', '1486346013', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('430', '62', '1319', '8', 'ECS000430', '以色列葡萄柚4个约250g/个', '', '3660', '0', '', '772', '0.000', '0', '48.00', '40.00', '30.00', '1461916800', '1514707200', '1', '水果,葡萄柚', '葡萄柚 果汁带有苦味，口感舒适', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591542928275.jpg\\\" title=\\\"14591542928275.jpg\\\" alt=\\\"513691849730695204_880x667.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591542989606.jpg\\\" title=\\\"14591542989606.jpg\\\" alt=\\\"513691849730564132_880x513.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591543015872.jpg\\\" title=\\\"14591543015872.jpg\\\" alt=\\\"513691849730596900_880x468.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591543106000.jpg\\\" title=\\\"14591543106000.jpg\\\" alt=\\\"513691849730662436_880x596.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591543199222.jpg\\\" title=\\\"14591543199222.jpg\\\" alt=\\\"513691849730629668_880x190.jpg\\\"/></p>', 'images/201610/goods_img/430_G_1459971655294.jpg', 'images/201610/goods_img/430_G_1459971655294.jpg', 'images/201610/goods_img/430_G_1459971655294.jpg', '1', '', '1', '1', '0', '0', '1440545347', '51', '0', '0', '1', '1', '0', '1', '0', '1479230914', '129', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('433', '62', '1037', '8', 'ECS000433', '菲律宾凤梨2个', '', '247', '0', '', '962', '0.000', '0', '34.80', '29.00', '0.00', '0', '0', '1', '菠萝,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591561375209.jpg\\\" title=\\\"14591561375209.jpg\\\" alt=\\\"02.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591561489940.jpg\\\" title=\\\"14591561489940.jpg\\\" alt=\\\"03.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591561594652.jpg\\\" title=\\\"14591561594652.jpg\\\" alt=\\\"04.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591561712715.jpg\\\" title=\\\"14591561712715.jpg\\\" alt=\\\"05.jpg\\\"/></p>', 'images/201610/goods_img/433_G_1459127377813.jpg', 'images/201610/goods_img/433_G_1459127377813.jpg', 'images/201610/goods_img/433_G_1459127377813.jpg', '1', '', '1', '1', '0', '0', '1440546068', '61', '0', '0', '1', '0', '1', '0', '0', '1477690757', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('460', '62', '1037', '4', 'ECS000460', '菲律宾香蕉约1.5kg', '', '180', '0', '', '982', '0.000', '0', '35.87', '29.90', '0.00', '0', '0', '1', '香蕉,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591554887650.jpg\\\" title=\\\"14591554887650.jpg\\\" alt=\\\"513691850109591603_880x506.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591554942572.jpg\\\" title=\\\"14591554942572.jpg\\\" alt=\\\"513691850109624371_880x508.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591554962213.jpg\\\" title=\\\"14591554962213.jpg\\\" alt=\\\"513691850109689907_880x537.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591555105175.jpg\\\" title=\\\"14591555105175.jpg\\\" alt=\\\"513691850109755443_880x519.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591555139468.jpg\\\" title=\\\"14591555139468.jpg\\\" alt=\\\"513691850109722675_880x635.jpg\\\"/></p>', 'images/201610/goods_img/460_G_1459126720606.jpg', 'images/201610/goods_img/460_G_1459126720606.jpg', 'images/201610/goods_img/460_G_1459126720606.jpg', '1', '', '1', '1', '0', '0', '1440711762', '55', '0', '0', '0', '1', '1', '0', '0', '1477614951', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('461', '62', '1037', '8', 'ECS000461', '泰国龙眼2KG装', '', '628', '0', '', '895', '0.000', '0', '66.00', '55.00', '29.90', '1462608000', '1514707200', '1', '龙眼,水果,热带', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591558449807.jpg\\\" title=\\\"14591558449807.jpg\\\" alt=\\\"02.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591558505859.jpg\\\" title=\\\"14591558505859.jpg\\\" alt=\\\"03.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591558543759.jpg\\\" title=\\\"14591558543759.jpg\\\" alt=\\\"04.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591558572671.jpg\\\" title=\\\"14591558572671.jpg\\\" alt=\\\"05.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591558613148.jpg\\\" title=\\\"14591558613148.jpg\\\" alt=\\\"06.jpg\\\"/></p>', 'images/201610/goods_img/461_G_1459127072318.jpg', 'images/201610/goods_img/461_G_1459127072318.jpg', 'images/201610/goods_img/461_G_1459127072318.jpg', '1', '', '1', '1', '0', '1', '1440712060', '59', '0', '0', '0', '1', '1', '1', '0', '1477690730', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('466', '62', '1037', '64', 'ECS000466', '智利蜜甜珍珠无籽红提1kg', '', '288', '0', '', '888', '0.000', '0', '70.80', '59.00', '0.00', '0', '0', '1', '红提,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545179726.jpg\\\" title=\\\"14591545179726.jpg\\\" alt=\\\"513691851332132983_880x970.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545226284.jpg\\\" title=\\\"14591545226284.jpg\\\" alt=\\\"513691851332067447_880x651.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545337358.jpg\\\" title=\\\"14591545337358.jpg\\\" alt=\\\"513691851332198519_880x452.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545428036.jpg\\\" title=\\\"14591545428036.jpg\\\" alt=\\\"513691851332264055_880x1049.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545538249.jpg\\\" title=\\\"14591545538249.jpg\\\" alt=\\\"513691851332165751_880x348.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591545706777.jpg\\\" title=\\\"14591545706777.jpg\\\" alt=\\\"513691851332231287_880x228.jpg\\\"/></p>', 'images/201610/goods_img/466_G_1459125813221.jpg', 'images/201610/goods_img/466_G_1459125813221.jpg', 'images/201610/goods_img/466_G_1459125813221.jpg', '1', '', '1', '1', '0', '1', '1440982292', '52', '0', '0', '0', '1', '1', '0', '0', '1486405442', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('468', '62', '1037', '8', 'ECS000468', '法国青蛇果20个约190g/个', '', '348', '0', '', '906', '0.000', '0', '94.80', '79.00', '0.00', '0', '0', '1', '青蛇果,苹果,水果', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591559533459.jpg\\\" title=\\\"14591559533459.jpg\\\" alt=\\\"513691851160854638_880x505.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591559609836.jpg\\\" title=\\\"14591559609836.jpg\\\" alt=\\\"513691851160821870_880x430.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591559762344.jpg\\\" title=\\\"14591559762344.jpg\\\" alt=\\\"513691851160887406_880x477.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591559879392.jpg\\\" title=\\\"14591559879392.jpg\\\" alt=\\\"513691851160952942_880x514.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591559997782.jpg\\\" title=\\\"14591559997782.jpg\\\" alt=\\\"513691851160920174_880x483.jpg\\\"/></p>', 'images/201610/goods_img/468_G_1459127208058.jpg', 'images/201610/goods_img/468_G_1459127208058.jpg', 'images/201610/goods_img/468_G_1459127208058.jpg', '1', '', '1', '1', '0', '1', '1440983529', '60', '0', '0', '1', '0', '1', '0', '0', '1477690697', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('617', '62', '1324', '0', 'ECS000617', '精选菜薹300g', '', '33', '0', '', '996', '0.000', '0', '9.48', '7.90', '5.00', '1462694400', '1514707200', '1', '青菜,蔬菜', '', '<p><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591574228136.jpg\\\" title=\\\"14591574228136.jpg\\\" alt=\\\"513691851257061490_880x506.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591574263199.jpg\\\" title=\\\"14591574263199.jpg\\\" alt=\\\"513691851257127026_880x688.jpg\\\"/><img src=\\\"https://cityo2o.ecjia.com/content/uploads/data/descimg/20160328/14591574295483.jpg\\\" title=\\\"14591574295483.jpg\\\" alt=\\\"513691851257094258_880x526.jpg\\\"/></p>', 'images/201610/goods_img/617_G_1459128638678.jpg', 'images/201610/goods_img/617_G_1459128638678.jpg', 'images/201610/goods_img/617_G_1459128638678.jpg', '1', '', '1', '1', '0', '0', '1459128638', '100', '0', '0', '1', '1', '1', '1', '0', '1486346013', '0', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '3', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('1046', '62', '1035', '10', '2161014103', '陕西富士苹果', '', '130', '0', '', '65527', '5.000', '0', '49.90', '42.90', '39.90', '1478073600', '1514707200', '1', '', '', '<p><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/1476673150874.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/1476673150874.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/1476673150874.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731523662.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731523662.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731523662.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731535192.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731535192.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731535192.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731557088.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731557088.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731557088.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731573256.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731573256.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731573256.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731583729.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731583729.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731583729.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731612390.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731612390.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731612390.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731627906.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731627906.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731627906.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731648366.jpg\\\" data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731648366.jpg\\\" _data-original=\\\"http://imgws3.fruitday.com/up_images/20161017/14766731648366.jpg\\\" style=\\\"display: inline;\\\"/><br/></p>', 'images/201610/thumb_img/1046_G_1476914172243.jpg', 'images/201610/goods_img/1046_G_1476914172243.jpg', 'images/201610/source_img/1046_G_1476914172243.jpg', '1', '', '1', '1', '0', '0', '1476914172', '100', '100', '0', '0', '0', '0', '1', '0', '1482085627', '129', '', '-1', '-1', '0', null, '0', '0', '1', '0', '0', '0', '0', '0', '5', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('1082', '62', '1320', '8', '61510', '美国加州花色恐龙蛋8个约90g/个', '', '658', '0', '', '1000', '3.300', '0', '72.00', '65.00', '0.00', '0', '0', '1', '李，进口', '', '<p><img src=\\\"http://img09.yiguoimg.com/e/images/2016/160622/513691853304144086_880x448.jpg\\\"/></p><p><img src=\\\"http://img12.yiguoimg.com/e/images/2016/160622/513691853304209622_880x463.jpg\\\"/></p><p><img src=\\\"http://img11.yiguoimg.com/e/images/2016/160622/513691853304176854_880x471.jpg\\\"/></p><p><img src=\\\"http://img09.yiguoimg.com/e/images/2016/160622/513691853304275158_880x558.jpg\\\"/></p>', 'images/201610/thumb_img/1082_G_1477690514985.jpg', 'images/201610/goods_img/1082_G_1477690514985.jpg', 'images/201610/source_img/1082_G_1477690514985.jpg', '1', '', '1', '1', '0', '0', '1477690514', '100', '100', '0', '0', '0', '0', '0', '0', '1477690569', '129', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '5', '', '', '0', '0', '0', '0', '0', '0.00', null, null);
INSERT INTO `ecjia_goods` VALUES ('1103', '62', '1033', '63', '2160723102', '温馨祝福鲜果礼盒', '', '361', '0', '', '1000', '10.000', '0', '280.00', '268.00', '0.00', '0', '0', '1', '礼品，果篮', '', '<p><img class=\\\"lazy\\\" src=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892813336.jpg\\\" data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892813336.jpg\\\" _data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892813336.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892839844.jpg\\\" data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892839844.jpg\\\" _data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892839844.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892857429.jpg\\\" data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892857429.jpg\\\" _data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892857429.jpg\\\" style=\\\"display: inline;\\\"/><img class=\\\"lazy\\\" src=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892874378.jpg\\\" data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892874378.jpg\\\" _data-original=\\\"http://imgws1.fruitday.com/up_images/20161024/14772892874378.jpg\\\" style=\\\"display: inline;\\\"/><br/></p>', 'images/201610/thumb_img/1103_G_1477698555092.jpg', 'images/201610/goods_img/1103_G_1477698555092.jpg', 'images/201610/source_img/1103_G_1477698555092.jpg', '1', '', '1', '1', '0', '0', '1477698555', '100', '100', '0', '0', '0', '0', '0', '0', '1486402282', '129', '', '-1', '-1', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '5', '', '', '0', '0', '0', '0', '0', '0.00', null, null);

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_goods_gallery` 商品相册
--

INSERT INTO `ecjia_goods_gallery` VALUES ('1650', '617', 'images/201610/goods_img/617_P_1459128638008.jpg', '9288692936286320_300.jpg', 'images/201610/goods_img/617_P_1459128638008.jpg', 'images/201610/goods_img/617_P_1459128638008.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1871', '466', 'images/201610/goods_img/466_P_1459217956197.jpg', '9288693067817079_500.jpg', 'images/201610/goods_img/466_P_1459217956197.jpg', 'images/201610/goods_img/466_P_1459217956197.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1872', '466', 'images/201610/goods_img/466_P_1459217957133.jpg', '9288693067849847_500.jpg', 'images/201610/goods_img/466_P_1459217957133.jpg', 'images/201610/goods_img/466_P_1459217957133.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1880', '460', 'images/201610/goods_img/460_P_1459218374020.jpg', '9288691846881331_500.jpg', 'images/201610/goods_img/460_P_1459218374020.jpg', 'images/201610/goods_img/460_P_1459218374020.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1881', '460', 'images/201610/goods_img/460_P_1459218374758.jpg', '9288691846914099_500.jpg', 'images/201610/goods_img/460_P_1459218374758.jpg', 'images/201610/goods_img/460_P_1459218374758.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1886', '461', 'images/201610/goods_img/461_P_1459218616992.jpg', '151010141737717_10957_500.jpg', 'images/201610/goods_img/461_P_1459218616992.jpg', 'images/201610/goods_img/461_P_1459218616992.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1887', '461', 'images/201610/goods_img/461_P_1459218616392.jpg', '151010141736843_10957_500.jpg', 'images/201610/goods_img/461_P_1459218616392.jpg', 'images/201610/goods_img/461_P_1459218616392.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1888', '468', 'images/201610/goods_img/468_P_1459218724322.jpg', '9288692894343278_500.jpg', 'images/201610/goods_img/468_P_1459218724322.jpg', 'images/201610/goods_img/468_P_1459218724322.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1889', '468', 'images/201610/goods_img/468_P_1459218725630.jpg', '9288692894310510_500.jpg', 'images/201610/goods_img/468_P_1459218725630.jpg', 'images/201610/goods_img/468_P_1459218725630.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1890', '433', 'images/201610/goods_img/433_P_1459218758797.jpg', '1510220245069750.jpg', 'images/201610/goods_img/433_P_1459218758797.jpg', 'images/201610/goods_img/433_P_1459218758797.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1891', '433', 'images/201610/goods_img/433_P_1459218760341.jpg', '1510220245045032.jpg', 'images/201610/goods_img/433_P_1459218760341.jpg', 'images/201610/goods_img/433_P_1459218760341.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1892', '395', 'images/201610/goods_img/395_P_1459218832155.jpg', '9288691275014038_500.jpg', 'images/201610/goods_img/395_P_1459218832155.jpg', 'images/201610/goods_img/395_P_1459218832155.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1893', '395', 'images/201610/goods_img/395_P_1459218832027.jpg', '9288691274981270_500.jpg', 'images/201610/goods_img/395_P_1459218832027.jpg', 'images/201610/goods_img/395_P_1459218832027.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1894', '617', 'images/201610/goods_img/617_P_1459218982585.jpg', '9288692936351856_500.jpg', 'images/201610/goods_img/617_P_1459218982585.jpg', 'images/201610/goods_img/617_P_1459218982585.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('1895', '617', 'images/201610/goods_img/617_P_1459218984856.jpg', '9288692936384624_500.jpg', 'images/201610/goods_img/617_P_1459218984856.jpg', 'images/201610/goods_img/617_P_1459218984856.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('2989', '430', 'images/201610/goods_img/430_P_1459971655453.jpg', '9288691428761503_500.jpg', 'images/201610/goods_img/430_P_1459971655453.jpg', 'images/201610/goods_img/430_P_1459971655453.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('2990', '430', 'images/201610/goods_img/430_P_1459971660784.jpg', '9288691428827039_500.jpg', 'images/201610/goods_img/430_P_1459971660784.jpg', 'images/201610/goods_img/430_P_1459971660784.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('2991', '430', 'images/201610/goods_img/430_P_1459971660723.jpg', '9288691428794271_500.jpg', 'images/201610/goods_img/430_P_1459971660723.jpg', 'images/201610/goods_img/430_P_1459971660723.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('3444', '1046', 'images/201610/goods_img/1046_P_1476914172383.jpg', '1-370x370-13738-23CKHT1U.jpg', 'images/201610/thumb_img/1046_P_1476914172383.jpg', 'images/201610/source_img/1046_P_1476914172383.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3503', '1082', 'images/201610/goods_img/1082_P_1477690581028.jpg', '9288695038550230_500.jpg', 'images/201610/thumb_img/1082_P_1477690581028.jpg', 'images/201610/source_img/1082_P_1477690581028.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3504', '1082', 'images/201610/goods_img/1082_P_1477690594283.jpg', '9288695038615766_500.jpg', 'images/201610/thumb_img/1082_P_1477690594283.jpg', 'images/201610/source_img/1082_P_1477690594283.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3560', '1103', 'images/201610/goods_img/1103_P_1477698555019.jpg', '1-270x270-12249-9XUK3KKT.jpg', 'images/201610/thumb_img/1103_P_1477698555019.jpg', 'images/201610/source_img/1103_P_1477698555019.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3561', '1103', 'images/201610/goods_img/1103_P_1477698610958.jpg', '1-370x370-12249-393U54AX.jpg', 'images/201610/thumb_img/1103_P_1477698610958.jpg', 'images/201610/source_img/1103_P_1477698610958.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3589', '1046', 'images/201611/goods_img/1046_P_1477960890510.jpg', '2-370x370-13738-C2XY61W1.jpg', 'images/201611/thumb_img/1046_P_1477960890510.jpg', 'images/201611/source_img/1046_P_1477960890510.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3590', '1046', 'images/201611/goods_img/1046_P_1477960893217.jpg', '3-370x370-13738-C2XY61W1.jpg', 'images/201611/thumb_img/1046_P_1477960893217.jpg', 'images/201611/source_img/1046_P_1477960893217.jpg?999');
INSERT INTO `ecjia_goods_gallery` VALUES ('3692', '393', 'images/201610/goods_img/393_P_1478818603045.jpg', '1-370x370-4394-9Y2YD8RY.jpg', 'images/201610/goods_img/393_P_1478818603045.jpg', 'images/201610/goods_img/393_P_1478818603045.jpg');
INSERT INTO `ecjia_goods_gallery` VALUES ('3693', '393', 'images/201610/goods_img/393_P_1478818607871.jpg', '3-370x370-12059-XSFUA856.jpg', 'images/201610/goods_img/393_P_1478818607871.jpg', 'images/201610/goods_img/393_P_1478818607871.jpg');

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_goods_attr` 商品属性
--

INSERT INTO `ecjia_goods_attr` VALUES ('2393', '466', '884', '蜜甜珍珠无籽红提', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2394', '466', '886', '智利', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2395', '466', '887', '1kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2396', '466', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2397', '466', '889', '002', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2398', '466', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2410', '460', '884', '香蕉', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2411', '460', '886', '菲律宾', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2412', '460', '887', '约1.5kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2413', '460', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2414', '460', '889', '004', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2415', '460', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2427', '461', '884', '龙眼', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2428', '461', '886', '泰国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2429', '461', '887', '2KG装', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2430', '461', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2431', '461', '889', '006', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2432', '461', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2433', '468', '884', '青蛇果20个', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2434', '468', '886', '法国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2435', '468', '887', '约190g/个', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2436', '468', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2437', '468', '889', '007', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2438', '468', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2439', '433', '884', '凤梨2个', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2440', '433', '886', '菲律宾', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2441', '433', '887', '200g', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2442', '433', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2443', '433', '889', '008', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2444', '433', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2445', '395', '884', '精品红霞草莓32粒', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2446', '395', '886', '中国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2447', '395', '887', '约30g/个', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2448', '395', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2449', '395', '889', '008', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2450', '395', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2457', '393', '884', '红心火龙果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2458', '393', '886', '越南', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2459', '393', '887', '2.5kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2460', '393', '888', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2461', '393', '889', '010', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2462', '393', '890', '水果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2468', '617', '893', '精选菜薹', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2469', '617', '894', '中国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2470', '617', '895', '300g', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2471', '617', '896', '2016', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('2472', '617', '897', '蔬菜', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3864', '1082', '884', '美国加州花色恐龙蛋', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3865', '1082', '886', '美国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3866', '1082', '887', '3.3kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3867', '1082', '888', '2106-10-28', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3868', '1082', '889', '61510', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3869', '1082', '890', '李', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3870', '1082', '891', '上海', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3983', '1103', '884', '温馨祝福鲜果礼盒', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3984', '1103', '886', '中国', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3985', '1103', '887', '15kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3986', '1103', '888', '2016-10-29', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3987', '1103', '889', '2160723102', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3988', '1103', '890', '礼品 果篮', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('3989', '1103', '891', '上海', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4032', '1046', '884', '陕西富士苹果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4033', '1046', '886', '陕西', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4034', '1046', '887', '5kg', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4035', '1046', '888', '2016-11-01', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4036', '1046', '889', '2161025101', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4037', '1046', '890', '苹果', '', '0', '0', '', '', '', '0');
INSERT INTO `ecjia_goods_attr` VALUES ('4038', '1046', '891', '上海', '', '0', '0', '', '', '', '0');

-- --------------------------------------------------------

--
-- 插入数据 `ecjia_goods_cat` 商品扩展分类
--

INSERT INTO `ecjia_goods_cat` VALUES ('224', '363');
INSERT INTO `ecjia_goods_cat` VALUES ('393', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('393', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('393', '1277');
INSERT INTO `ecjia_goods_cat` VALUES ('393', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('393', '1338');
INSERT INTO `ecjia_goods_cat` VALUES ('395', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('395', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('395', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('430', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('430', '1040');
INSERT INTO `ecjia_goods_cat` VALUES ('430', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('433', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('433', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('433', '1276');
INSERT INTO `ecjia_goods_cat` VALUES ('433', '1277');
INSERT INTO `ecjia_goods_cat` VALUES ('433', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('460', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('460', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('460', '1277');
INSERT INTO `ecjia_goods_cat` VALUES ('460', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1276');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1277');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1278');
INSERT INTO `ecjia_goods_cat` VALUES ('461', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('466', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('466', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1033');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1035');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1037');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1277');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1323');
INSERT INTO `ecjia_goods_cat` VALUES ('468', '1336');
INSERT INTO `ecjia_goods_cat` VALUES ('617', '1034');
INSERT INTO `ecjia_goods_cat` VALUES ('617', '1041');
INSERT INTO `ecjia_goods_cat` VALUES ('617', '1042');
INSERT INTO `ecjia_goods_cat` VALUES ('617', '1324');
INSERT INTO `ecjia_goods_cat` VALUES ('617', '1339');