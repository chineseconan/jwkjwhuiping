/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : jwkjwxmps2

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-10 09:13:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dic
-- ----------------------------
DROP TABLE IF EXISTS `dic`;
CREATE TABLE `dic` (
  `dic_id` varchar(100) NOT NULL,
  `dic_name` varchar(100) NOT NULL,
  `dic_value` varchar(100) NOT NULL,
  `dic_type` varchar(100) NOT NULL,
  `dic_createtime` varchar(100) DEFAULT NULL,
  `dic_createuser` varchar(100) DEFAULT NULL,
  `dic_lastmodifytime` varchar(100) DEFAULT NULL,
  `dic_lastmodifyuser` varchar(100) DEFAULT NULL,
  `dic_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`dic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dic
-- ----------------------------
INSERT INTO `dic` VALUES ('T1243E0EF74794FBBA0FA9FD9', '2019', '2019', 'TA066C9BBE4A044EAB338C445', '1528437668', 'safe', null, null, null);
INSERT INTO `dic` VALUES ('T398ECC79EA6041D2A9D46FDE', '价值分数', '价值分数', 'TDB51C4BB878945A8887FFB08', '1546849420', 'safe', null, null, null);
INSERT INTO `dic` VALUES ('T718BBE91EABE46038251018F', '创新分数', '创新分数', 'TDB51C4BB878945A8887FFB08', '1528436107', 'safe', '1546849394', 'safe', null);
INSERT INTO `dic` VALUES ('T71E4A0A5D3BD4E0DAB9E2BB0', '潜力分数', '潜力分数', 'TDB51C4BB878945A8887FFB08', '1528436130', 'safe', '1546849398', 'safe', null);
INSERT INTO `dic` VALUES ('T88B89ED074074DB18AFEF458', '成绩分数', '成绩分数', 'TDB51C4BB878945A8887FFB08', '1528436090', 'safe', '1546849390', 'safe', null);
INSERT INTO `dic` VALUES ('TF43ACD0958EB4443AF3D062A', '2018', '2018', 'TA066C9BBE4A044EAB338C445', '1528437657', 'safe', '1528437661', 'safe', null);

-- ----------------------------
-- Table structure for dic_type
-- ----------------------------
DROP TABLE IF EXISTS `dic_type`;
CREATE TABLE `dic_type` (
  `dic_type_id` varchar(200) NOT NULL,
  `type_name` varchar(200) DEFAULT NULL,
  `dic_type_createtime` varchar(30) DEFAULT NULL,
  `dic_type_createuser` varchar(200) DEFAULT NULL,
  `dic_type_lastmodifytime` varchar(30) DEFAULT NULL,
  `dic_type_lastmodifyuser` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`dic_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dic_type
-- ----------------------------
INSERT INTO `dic_type` VALUES ('T939567124D0C41ADBECA780E', '分组', '1528355323', 'safe', null, null);
INSERT INTO `dic_type` VALUES ('TA066C9BBE4A044EAB338C445', '年度', '1528437644', 'safe', null, null);
INSERT INTO `dic_type` VALUES ('TDB51C4BB878945A8887FFB08', '评价指标', '1546849345', 'safe', null, null);

-- ----------------------------
-- Table structure for modelinfo
-- ----------------------------
DROP TABLE IF EXISTS `modelinfo`;
CREATE TABLE `modelinfo` (
  `mi_id` varchar(100) NOT NULL,
  `mi_name` varchar(100) DEFAULT NULL,
  `mi_createtime` varchar(100) DEFAULT NULL,
  `mi_createuser` varchar(100) DEFAULT NULL,
  `mi_lastmodifytime` varchar(100) DEFAULT NULL,
  `mi_lastmodifyuser` varchar(100) DEFAULT NULL,
  `mi_sort` int(11) DEFAULT NULL,
  `mi_url` varchar(200) DEFAULT NULL,
  `mi_issystem` varchar(100) DEFAULT NULL,
  `mi_type` varchar(100) DEFAULT NULL,
  `mi_pid` varchar(100) DEFAULT NULL,
  `mi_isdefault` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modelinfo
-- ----------------------------
INSERT INTO `modelinfo` VALUES ('T0EE42FEACC26401D8935EBA6', '地方项目投票', '1551769057', 'T07DF7457A5AE44A38FAF3C89', null, null, '111', 'Admin/Vote/index?type=地方', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('T25CEB0646ADA4EC4ACDDA253', '投票设置', '1533535673', 'system', null, null, '80', 'Admin/VoteSetting/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('T2857459C8ACA4AF18ACEA755', '进度查询', '1528418343', 'safe', null, null, '81', 'Admin/MxQuery/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('T3A62E07E49B94413BF9C8E5E', '模块授权', '1522202442', 'safe', null, null, '82', 'Admin/RoleAuth/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T68588C53EC674BB389EFE3BB', '用户授权', '1522202454', 'safe', null, null, '78', 'Admin/UserAuth/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T6CBD13D50B8B4DF5946A29CE', '专家管理', '1522202403', 'safe', null, null, '79', 'Admin/User/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T6E10703BB0B34742A58F6B3B', '军队项目投票', '1533618876', 'T19425D2CA59F4F01B51923A1', '1551769028', 'T07DF7457A5AE44A38FAF3C89', '110', 'Admin/Vote/index?type=军队', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('T73ED91364FC84B81979F3FC0', '用户状态管理', '1522202430', 'safe', null, null, '75', 'Admin/UserSafe/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T8A86398AC5FC4F39944FDBA1', '日志查询', '1522202465', 'safe', null, null, '84', 'Admin/LogManage/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T8FF84931BD364BB6B0D5FD5C', '字典类型管理页面', '1522372818', 'safe', null, null, '15', 'Admin/DicType/index', '是', '页面类型', '2', '否');
INSERT INTO `modelinfo` VALUES ('T94277F330BAE48E0AE1C9BFA', '角色管理', '1522202373', 'safe', null, null, '76', 'Admin/RoleInfo/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('T97BE16E9CDEA42E49F719D76', '地方项目打分', '1551764766', 'T07DF7457A5AE44A38FAF3C89', '1551767498', 'T07DF7457A5AE44A38FAF3C89', '103', 'Admin/Xmps/index?type=地方', '', '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('TB1F58C240D2A4C47AD58E377', '数据交互', '1528967210', 'safe', null, null, '201', 'Admin/DataCollect/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('TBBEE81C030EA4D529920AAE8', '评分统计', '1528418383', 'safe', null, null, '91', 'Admin/JdQuery/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('TD2E907966B824F72ACE07E55', '字典管理页面', '1522371879', 'safe', null, null, '100', 'Admin/Dictionary/index', '是', '页面类型', '1', '否');
INSERT INTO `modelinfo` VALUES ('TD6B35D17E00D45A8805FEA79', '模块管理', '1522202360', 'safe', null, null, '73', 'Admin/ModelInfo/index', '是', null, null, '否');
INSERT INTO `modelinfo` VALUES ('TDD1FDBBBAF1049AA955054E1', '投票统计', '1533619039', 'T19425D2CA59F4F01B51923A1', null, null, '95', 'Admin/Result/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('TE7FC3A0E1FA54D4DAE429497', '项目打分', '1528355636', 'safe', '1552533183', 'safe', '102', 'Admin/Xmps/index', null, '页面类型', '', '否');
INSERT INTO `modelinfo` VALUES ('TF250F0BCDF5D42F8AAF5802C', '项目管理', '1528355499', 'safe', null, null, '10', 'Admin/XM/index', null, '页面类型', '', '否');

-- ----------------------------
-- Table structure for oplog
-- ----------------------------
DROP TABLE IF EXISTS `oplog`;
CREATE TABLE `oplog` (
  `opl_id` varchar(100) NOT NULL,
  `opl_user` varchar(100) DEFAULT NULL,
  `opl_ip` varchar(100) DEFAULT NULL,
  `opl_time` varchar(100) DEFAULT NULL,
  `opl_type` varchar(100) DEFAULT NULL,
  `opl_object` varchar(100) DEFAULT NULL,
  `opl_content` varchar(2000) DEFAULT NULL,
  `opl_result` varchar(100) DEFAULT NULL,
  `opl_firstcontent` varchar(2000) DEFAULT NULL,
  `opl_logtype` varchar(100) DEFAULT NULL,
  `opl_logcode` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oplog
-- ----------------------------
INSERT INTO `oplog` VALUES ('TBC9992FD3F1F404EA21B01BB', '系统管理员(sysadmin)', '0.0.0.0', '1546846933', null, '', null, '成功', '访问用户管理', '用户访问日志', 'bbbb077191a434222a5fc738481c0496');
INSERT INTO `oplog` VALUES ('T020E52463F09499E9856C1EA', '系统管理员(sysadmin)', '0.0.0.0', '1546846934', null, '', null, '成功', '访问明细查询', '用户访问日志', '2ef45b253edee78bec09b8f6d93f8466');
INSERT INTO `oplog` VALUES ('TDE78A567E4864E30B3CBBF51', '系统管理员(sysadmin)', '0.0.0.0', '1546846936', null, '', null, '成功', '访问评分统计', '用户访问日志', 'd2cf5e9e1929a496edf95b5743497bf6');
INSERT INTO `oplog` VALUES ('T5CBC5E27092146958D868F98', '系统管理员(sysadmin)', '0.0.0.0', '1546846937', null, '', null, '成功', '访问数据交互', '用户访问日志', '243087c5ec5adb3f37843a5ec621815f');
INSERT INTO `oplog` VALUES ('T1371F51FB9824A1BAFE09E23', '系统管理员(sysadmin)', '0.0.0.0', '1546846938', null, '', null, '成功', '访问评分统计', '用户访问日志', '8df0d70fa48eb46c9c0e0f9acf740a0d');
INSERT INTO `oplog` VALUES ('T13F80A1B05824E638A4F6A7E', '系统管理员(sysadmin)', '0.0.0.0', '1546846940', null, '', null, '成功', '访问明细查询', '用户访问日志', '7c095aac048afac28c085cb5a05b9957');
INSERT INTO `oplog` VALUES ('TBD4D01C5F3984FD08B1AD0CE', '系统管理员(sysadmin)', '0.0.0.0', '1551940919', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T71674DCED9F744F6BFBF29CA', '系统管理员(sysadmin)', '0.0.0.0', '1551940974', null, '', null, '成功', '访问用户管理', '用户访问日志', '881ff0133abeea55d3e728bbd76d5712');
INSERT INTO `oplog` VALUES ('TE93613798B6E481EB8B0D4B7', '系统管理员(sysadmin)', '0.0.0.0', '1551940975', null, '', null, '成功', '访问明细查询', '用户访问日志', '115405a07a469edf931d97c51485c2fb');
INSERT INTO `oplog` VALUES ('TE7CB6C157D2241449BF7C3F7', '系统管理员(sysadmin)', '0.0.0.0', '1551940976', null, '', null, '成功', '访问投票统计', '用户访问日志', '9d423fbf080ee0a5dd99c5645741ec63');
INSERT INTO `oplog` VALUES ('T1B231A7F81A742B1AFD36F48', '系统管理员(sysadmin)', '0.0.0.0', '1551940977', null, '', null, '成功', '访问数据交互', '用户访问日志', '1eb62b55cd100bd0bd892452081f1ffe');
INSERT INTO `oplog` VALUES ('TB6A3216197174366A21965F0', '系统管理员(sysadmin)', '0.0.0.0', '1551941213', null, '', null, '成功', '访问用户管理', '用户访问日志', '705f02d3e299136a4162b4f144686b31');
INSERT INTO `oplog` VALUES ('TE0C6986C012745459220B628', '系统管理员(sysadmin)', '0.0.0.0', '1551941217', null, '', null, '成功', '导出用户列表', '对象修改日志', '67be2c6ed29819f1945534faa79518da');
INSERT INTO `oplog` VALUES ('TF29D4A0E12F1435CBE2CE74F', '系统管理员(sysadmin)', '0.0.0.0', '1551941314', null, '', null, '成功', '访问明细查询', '用户访问日志', '1f939ed684c9100ed7309a7d0aba79ce');
INSERT INTO `oplog` VALUES ('T85156F83B86F4F648412F8BD', '系统管理员(sysadmin)', '0.0.0.0', '1551941322', null, '', null, '成功', '访问明细查询', '用户访问日志', '7ed2ed8a687fd1d7d80913be74df12a6');
INSERT INTO `oplog` VALUES ('TD6D806B0A3F544BFA658B67B', '系统管理员(sysadmin)', '0.0.0.0', '1551941333', null, '', null, '成功', '访问用户管理', '用户访问日志', '0b7a6501ed985698d49ffa05925243fa');
INSERT INTO `oplog` VALUES ('T96B2CACEFCDC4718B6B417F9', '系统管理员(sysadmin)', '0.0.0.0', '1551941343', null, 'sysuser', null, '成功', '修改用户专家006', '三员操作日志', '3fea7eb68ffdec3fb324c01b020c1987');
INSERT INTO `oplog` VALUES ('T39055352C23A42AAB91E9E96', '系统管理员(sysadmin)', '0.0.0.0', '1551941357', null, '', null, '成功', '访问明细查询', '用户访问日志', '9d171b6eb906480cff1e07dd878153a6');
INSERT INTO `oplog` VALUES ('TE76A61B0BC0D4165BE453671', '系统管理员(sysadmin)', '0.0.0.0', '1551941362', null, '', null, '成功', '访问用户管理', '用户访问日志', 'f20b6432818690e43eb5782d8c5c47dc');
INSERT INTO `oplog` VALUES ('T1C70C00C667E4F87A2D982F4', '系统管理员(sysadmin)', '0.0.0.0', '1551941365', null, '', null, '成功', '访问评分统计', '用户访问日志', '7930a1af15bc7b33e13ffb75c9c6646b');
INSERT INTO `oplog` VALUES ('T37D69EB0887C4A3795D7DF96', '系统管理员(sysadmin)', '0.0.0.0', '1551941369', null, '', null, '成功', '访问投票统计', '用户访问日志', '776eb2509e3cb630f6048dbd491a4a4c');
INSERT INTO `oplog` VALUES ('TE1A2652776E246A7A334FEB2', '专家001(1)', '0.0.0.0', '1551941376', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T26B72AD50D9F4758B5B82E38', '专家001(1)', '0.0.0.0', '1551941376', null, '', null, '成功', '访问项目评审', '用户访问日志', '8b83db9dbb7e57173ec1e5b6722cd917');
INSERT INTO `oplog` VALUES ('TCC74CADAC67B497787F12454', '专家001(1)', '0.0.0.0', '1551942288', null, '', null, '成功', '访问项目评审', '用户访问日志', '1b71c07bf5bbd03de6ac44f4a085da50');
INSERT INTO `oplog` VALUES ('TF9563A25213F44EE9B23CF74', '专家001(1)', '0.0.0.0', '1551942324', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ddc9b02275e61f09332f114ccf741ef6');
INSERT INTO `oplog` VALUES ('T0BEF89C4572B4C45AF2D376E', '专家001(1)', '0.0.0.0', '1551942407', null, '', null, '成功', '访问项目评审', '用户访问日志', '5b0d0580bebc3d722fb1ebc077862d88');
INSERT INTO `oplog` VALUES ('TA617C2D377DF406AA5E541C4', '专家001(1)', '0.0.0.0', '1551942475', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ddef281e6cb05f1b002d92392aad71ed');
INSERT INTO `oplog` VALUES ('T605A1783E86B42BF91161652', '专家001(1)', '0.0.0.0', '1551942495', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd3fa6ae68466321a9fafa95939fd9e72');
INSERT INTO `oplog` VALUES ('T9413E4A1FD7B429F87CC0298', '专家001(1)', '0.0.0.0', '1551942568', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ac524dc782ccd70e97611bf98595be10');
INSERT INTO `oplog` VALUES ('TACFCBEC7E8D04474B86CEE1F', '专家001(1)', '0.0.0.0', '1551942586', null, '', null, '成功', '访问项目评审', '用户访问日志', '11fb41bdd783c301b24f0f5609b73a82');
INSERT INTO `oplog` VALUES ('T84D11785A99242D8BD119F38', '专家001(1)', '0.0.0.0', '1551942618', null, '', null, '成功', '访问项目评审', '用户访问日志', '11109bef3c69507c8d11d25f40419e7c');
INSERT INTO `oplog` VALUES ('T61C02404247A423F820FEF45', '专家001(1)', '0.0.0.0', '1551942678', null, '', null, '成功', '访问项目评审', '用户访问日志', '39e3a67b2d4b8f69855f3df754ccd2eb');
INSERT INTO `oplog` VALUES ('T42C2959453574796808EB0A0', '专家001(1)', '0.0.0.0', '1551942699', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd58832a83ec8eaf0f0adf3177854b37e');
INSERT INTO `oplog` VALUES ('T5174CCBEBDA04D05AE9B483D', '专家001(1)', '0.0.0.0', '1551942796', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c5a5245d231c1fe7175f5e20f6d017ed');
INSERT INTO `oplog` VALUES ('T61240CA70A7F4158822A9BB4', '专家001(1)', '0.0.0.0', '1551942838', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c3ac842b468aed1f19b23c09476f86e0');
INSERT INTO `oplog` VALUES ('TCDFA9EDA21594B1CA202133E', '专家001(1)', '0.0.0.0', '1551942852', null, '', null, '成功', '访问项目评审', '用户访问日志', '2cf817d6947f6232c1fa314666774f79');
INSERT INTO `oplog` VALUES ('T40A8E51508C74062B211114B', '专家001(1)', '0.0.0.0', '1551942865', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fac1ceafa72ec6003cdea4793c878e3b');
INSERT INTO `oplog` VALUES ('T481E4233A2D2480CAAE8B353', '专家001(1)', '0.0.0.0', '1551942866', null, '', null, '成功', '访问项目评审', '用户访问日志', '72dacc066ce1fa70dc1986aa81cd7915');
INSERT INTO `oplog` VALUES ('TFC62EC5C796C4AEB8BC63F93', '专家001(1)', '0.0.0.0', '1551942867', null, '', null, '成功', '访问项目评审', '用户访问日志', '0481620a642414ddde747f98ff0d13f1');
INSERT INTO `oplog` VALUES ('T47E4B05ECF78431D915B3CA7', '专家001(1)', '0.0.0.0', '1551942868', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ef065a2962276f807b5574840b0ec33f');
INSERT INTO `oplog` VALUES ('T982D88316BEE47479A237F70', '专家002(2)', '0.0.0.0', '1551942873', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T22339281D1644599AA262FC3', '专家002(2)', '0.0.0.0', '1551942873', null, '', null, '成功', '访问项目评审', '用户访问日志', '4a23d4061dd4f9435ffcf2490ddb4051');
INSERT INTO `oplog` VALUES ('TBC1F9A4E6A114F408F31EE93', '专家002(2)', '0.0.0.0', '1551944330', null, '', null, '成功', '访问项目评审', '用户访问日志', '2ac5180fe55ca2f5a7858f1b39add51d');
INSERT INTO `oplog` VALUES ('T93AF36B72CE84F21BCD4474C', '专家002(2)', '0.0.0.0', '1551944330', null, '', null, '成功', '访问项目评审', '用户访问日志', '4124edfd8cdee607091adab25822f390');
INSERT INTO `oplog` VALUES ('T3315ADE7BE9C45A48E2B8B06', '专家002(2)', '0.0.0.0', '1551944332', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c48e482a3062f4099cca7e4a1bac2c68');
INSERT INTO `oplog` VALUES ('TFBF306D6161B4EBCB57B07F4', '专家002(2)', '0.0.0.0', '1551944334', null, '', null, '成功', '访问项目评审', '用户访问日志', '85120b73299705cd9abbb46ee18bc067');
INSERT INTO `oplog` VALUES ('TE90EFD4515AA4EB4BB1DF651', '专家002(2)', '0.0.0.0', '1551944339', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c8dc9652e3783abbfb5251727b642a15');
INSERT INTO `oplog` VALUES ('TB2F0C4BA0F314DEE94E39789', '专家002(2)', '0.0.0.0', '1551944340', null, '', null, '成功', '访问项目评审', '用户访问日志', '353504ac7f18ba2659e1b861640c4f96');
INSERT INTO `oplog` VALUES ('T6DD6A4547D8747B182B6C4AA', '专家002(2)', '0.0.0.0', '1551944347', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd86bd9ba6bb1f8759a61359bd09398ee');
INSERT INTO `oplog` VALUES ('T11E9A1EF9054420284B2239E', '专家002(2)', '0.0.0.0', '1551944349', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f4b37413effaf8d77577dddc2bd12501');
INSERT INTO `oplog` VALUES ('TA71C8CE6D89E4CE8A1696513', '专家002(2)', '0.0.0.0', '1551944351', null, '', null, '成功', '访问项目评审', '用户访问日志', '92908ad472e5ec4d1bfed5805b258fdc');
INSERT INTO `oplog` VALUES ('T78A37C0FF7FC40028882CAEF', '专家002(2)', '0.0.0.0', '1551944382', null, '', null, '成功', '访问项目评审', '用户访问日志', '870a707592f6b82373b73d001adacc22');
INSERT INTO `oplog` VALUES ('T111DC9ACFF964DE28F7A17D4', '专家002(2)', '0.0.0.0', '1551944427', null, '', null, '成功', '访问项目评审', '用户访问日志', '2e13ed0efcdfd71bc0d6eaddb84e4bb3');
INSERT INTO `oplog` VALUES ('T37DBC4681053432589069D62', '专家002(2)', '0.0.0.0', '1551944431', null, '', null, '成功', '访问项目评审', '用户访问日志', '47f004131c91b90768f9e29b4abd09d2');
INSERT INTO `oplog` VALUES ('T90127CFD118D442696E5165D', '专家002(2)', '0.0.0.0', '1551944450', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e5f67b89480de39787c39ab5597471db');
INSERT INTO `oplog` VALUES ('T49E9717B231E4D50B6A38AE9', '专家002(2)', '0.0.0.0', '1551944493', null, '', null, '成功', '访问项目评审', '用户访问日志', '75438e9d8cd9f2a76f8a688c2912f59d');
INSERT INTO `oplog` VALUES ('T281092F3FE3747C199160644', '专家001(1)', '0.0.0.0', '1551944498', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC0EE7DC1613D431A8A66CA8B', '专家001(1)', '0.0.0.0', '1551944498', null, '', null, '成功', '访问项目评审', '用户访问日志', '30db37e6cc6fb2c68dd9b040ca3671e8');
INSERT INTO `oplog` VALUES ('T884D61AF1A774CB98CE61B13', '专家002(2)', '0.0.0.0', '1551944523', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC33B9647C6B445E2BAEF94AB', '专家002(2)', '0.0.0.0', '1551944524', null, '', null, '成功', '访问项目评审', '用户访问日志', '0ff96370e69d10fc257e26494c792e14');
INSERT INTO `oplog` VALUES ('T0E1DC045CA814E03A44D55C4', '专家002(2)', '0.0.0.0', '1551944537', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ccb23a61be360bcec3fa1e4875b84049');
INSERT INTO `oplog` VALUES ('T3A309F8EBD9D4A32B2F2A5B6', '专家002(2)', '0.0.0.0', '1551944738', null, '', null, '成功', '访问项目评审', '用户访问日志', '8cb058f81d39b32c27466aa41fba817e');
INSERT INTO `oplog` VALUES ('T5CD4A3FD1E914A1B9D8723E6', '专家002(2)', '0.0.0.0', '1551945026', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f8be03a52d495f458f8a748a37f777ca');
INSERT INTO `oplog` VALUES ('TA8DAF73F55C840828BBA4D8F', '专家002(2)', '0.0.0.0', '1551945034', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f9b02d80fe4481c938b861bb77d938e9');
INSERT INTO `oplog` VALUES ('T028D019BD1C84F89A455DF2E', '专家002(2)', '0.0.0.0', '1551945126', null, '', null, '成功', '访问项目评审', '用户访问日志', '4dea531dacb892f34df901b13636a921');
INSERT INTO `oplog` VALUES ('T7B12473D23A640C08D753B42', '专家002(2)', '0.0.0.0', '1551945191', null, '', null, '成功', '访问项目评审', '用户访问日志', '30e0da7152ea52bccb1b53a8810229d9');
INSERT INTO `oplog` VALUES ('TB869980D3FC246299DC746B5', '专家002(2)', '0.0.0.0', '1551945200', null, '', null, '成功', '访问项目评审', '用户访问日志', '32a98ecc04113bc372259183b47a2512');
INSERT INTO `oplog` VALUES ('TBD28A9A4E9FB4A089FD385EA', '专家002(2)', '0.0.0.0', '1551945252', null, '', null, '成功', '访问项目评审', '用户访问日志', '9842f730cd73b2d001481675083c62e8');
INSERT INTO `oplog` VALUES ('TDAD6FCA35E0048FB946733AE', '专家002(2)', '0.0.0.0', '1551945262', null, '', null, '成功', '访问项目评审', '用户访问日志', '2955500dff494224397efa8e8e368219');
INSERT INTO `oplog` VALUES ('TDEE6AA2B92404880B87EAC97', '专家002(2)', '0.0.0.0', '1551945320', null, '', null, '成功', '访问项目评审', '用户访问日志', '1ae9a3b0331f0921edb7c7d0423e9f07');
INSERT INTO `oplog` VALUES ('TFAF69CBFA29A4443829B944E', '专家002(2)', '0.0.0.0', '1551945344', null, '', null, '成功', '访问项目评审', '用户访问日志', '542556ff3c1664eadc1a79556cd23db2');
INSERT INTO `oplog` VALUES ('T75141C02086A43AE943A4476', '专家002(2)', '0.0.0.0', '1551945374', null, '', null, '成功', '访问项目评审', '用户访问日志', 'cbbd50e3d6efb2f890f0977a50c00333');
INSERT INTO `oplog` VALUES ('T5B32A6B5B7F840A7A6084919', '专家002(2)', '0.0.0.0', '1551945484', null, '', null, '成功', '访问项目评审', '用户访问日志', '61ed9a2fc9f25f8612f7f2d9e39c141e');
INSERT INTO `oplog` VALUES ('T34E8C9B89B02447186EFD4C6', '专家002(2)', '0.0.0.0', '1551945486', null, '', null, '成功', '访问项目评审', '用户访问日志', '843e897ee75564508b3c768d7daac91b');
INSERT INTO `oplog` VALUES ('TE36A55C9FCB34A2CAA846E79', '专家002(2)', '0.0.0.0', '1551945486', null, '', null, '成功', '访问项目评审', '用户访问日志', '7ca176b26d3548fcf08fe7363fae39dc');
INSERT INTO `oplog` VALUES ('TFEDBE86472964EE2921C40F4', '专家002(2)', '0.0.0.0', '1551945554', null, '', null, '成功', '访问项目评审', '用户访问日志', '65a7737722e376b285ef9dcd82fb8409');
INSERT INTO `oplog` VALUES ('TC531D064A6EF48FDADCFC0B3', '专家002(2)', '0.0.0.0', '1551946109', null, '', null, '成功', '访问项目评审', '用户访问日志', '4df42bb60d0659d9651f760e1297e6cd');
INSERT INTO `oplog` VALUES ('T7569E36DAA89437E933A6614', '专家002(2)', '0.0.0.0', '1551946126', null, '', null, '成功', '访问项目评审', '用户访问日志', '98b2f43aa869915bb077d5673306f121');
INSERT INTO `oplog` VALUES ('T6D97AB8AD84443628F9A5BA8', '专家002(2)', '0.0.0.0', '1551946137', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd6212d214af4ceaad588bdfd59f2a785');
INSERT INTO `oplog` VALUES ('T5CBDF1776711432EB7F5AD84', '专家002(2)', '0.0.0.0', '1551946286', null, '', null, '成功', '访问项目评审', '用户访问日志', '18cbc22760b031e2d31f9e4ad24841cc');
INSERT INTO `oplog` VALUES ('T2AA708EB7F9A448E9B21B26E', '专家002(2)', '0.0.0.0', '1551946302', null, '', null, '成功', '访问项目评审', '用户访问日志', '37a85ea2a6b7a27d36bfc0e6d8a48e36');
INSERT INTO `oplog` VALUES ('TB932C1993D454796A23DF548', '专家002(2)', '0.0.0.0', '1551946323', null, '', null, '成功', '访问项目评审', '用户访问日志', '95b5f442e3c390349b2fede83dea8702');
INSERT INTO `oplog` VALUES ('T830F9C1137A4431C90BD053C', '专家002(2)', '0.0.0.0', '1551946348', null, '', null, '成功', '访问项目评审', '用户访问日志', '5d3d2aca4c7f25744c525511dd4046d4');
INSERT INTO `oplog` VALUES ('TE7B2E6E047C941BCB854FE07', '专家002(2)', '0.0.0.0', '1551946370', null, '', null, '成功', '访问项目评审', '用户访问日志', '06e2b942a9e84034109719b6d3b30df3');
INSERT INTO `oplog` VALUES ('TC2533D3E91E4425E94FD1953', '专家002(2)', '0.0.0.0', '1551946394', null, '', null, '成功', '访问项目评审', '用户访问日志', '8029c93e79806ee66bb955c38a13ca29');
INSERT INTO `oplog` VALUES ('T9A56DBBA715C499586A0333C', '专家002(2)', '0.0.0.0', '1551946439', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ad7fa23f007415af1077b9af34f835d1');
INSERT INTO `oplog` VALUES ('T987DA3A626D34458B567183F', '专家002(2)', '0.0.0.0', '1551946442', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd58de9e8c9c40dc0cb89c3f671c381f8');
INSERT INTO `oplog` VALUES ('T44F1426992E543839C462B7E', '专家001(1)', '0.0.0.0', '1551946452', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB4FAF9A126B54033888588E4', '专家001(1)', '0.0.0.0', '1551946452', null, '', null, '成功', '访问项目评审', '用户访问日志', '94e9d3142717cba36a39d03a240d64b2');
INSERT INTO `oplog` VALUES ('T50C717B01FE84D729935BB5A', '专家001(1)', '0.0.0.0', '1551946458', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd32cea8f21335aeed66f13d8b8e97df0');
INSERT INTO `oplog` VALUES ('T358BFAC482614DA8A60E62B4', '专家001(1)', '0.0.0.0', '1551946459', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b8aab3e59fe38220c881f79ca9a76b67');
INSERT INTO `oplog` VALUES ('T4A4D0D7077F045129CEE2100', '专家001(1)', '0.0.0.0', '1551946473', null, '', null, '成功', '访问项目评审', '用户访问日志', '7903834d167432cb51e4e76b4e1a9e64');
INSERT INTO `oplog` VALUES ('T1FFCB3724AC6400497B3537F', '专家001(1)', '0.0.0.0', '1551946479', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e07ba62e33c8098f0680b4640738f404');
INSERT INTO `oplog` VALUES ('TA3FB9BEB05544FC5A35A5F52', '专家001(1)', '0.0.0.0', '1551946482', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ef79a50b2557322574db334f1507f48e');
INSERT INTO `oplog` VALUES ('T6ADA0069342042EBA38F95BB', '系统管理员(sysadmin)', '0.0.0.0', '1551946490', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TF28723E9149845A694EC6A9F', '系统管理员(sysadmin)', '0.0.0.0', '1551946492', null, '', null, '成功', '访问用户管理', '用户访问日志', '47b9fc127a4ddf5b4a74923612ec7cba');
INSERT INTO `oplog` VALUES ('TED4DABCD6BB24614881D5544', '系统管理员(sysadmin)', '0.0.0.0', '1551946498', null, '', null, '成功', '访问明细查询', '用户访问日志', '52b63993b5cacdd0947b853b9c759a31');
INSERT INTO `oplog` VALUES ('T23B77BDC26054DD39E8DA7F2', '系统管理员(sysadmin)', '0.0.0.0', '1551946504', null, '', null, '成功', '访问评分统计', '用户访问日志', '1e864ed9be2cfd80c60d49aaaa66fe77');
INSERT INTO `oplog` VALUES ('TE9477AB7E5464AF1877F3704', '专家002(2)', '0.0.0.0', '1551946522', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T426F5885F75548508EF66FD4', '专家002(2)', '0.0.0.0', '1551946522', null, '', null, '成功', '访问项目评审', '用户访问日志', '95dbdc5bfce57e032a483305508c5ad7');
INSERT INTO `oplog` VALUES ('T0686BEF8687C48A88E2CBAA9', '专家002(2)', '0.0.0.0', '1551946594', null, '', null, '成功', '访问项目评审', '用户访问日志', '646e5ddddfe1f8114cb6da540b82a5fd');
INSERT INTO `oplog` VALUES ('T023B336B824A485FAA0FEF7A', '专家002(2)', '0.0.0.0', '1551946603', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd589a13287cc39fb01892d85eba5e9ea');
INSERT INTO `oplog` VALUES ('T0693E1D9FEF04D3EAC6A4B0C', '专家002(2)', '0.0.0.0', '1551946608', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fa05e6762696cf7cfc82e58f5a2cc684');
INSERT INTO `oplog` VALUES ('T812088B3AFC74ECA8BDA53ED', '专家003(3)', '0.0.0.0', '1551946613', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T224B4EE04A82449F9E4DA411', '专家003(3)', '0.0.0.0', '1551946613', null, '', null, '成功', '访问项目评审', '用户访问日志', '05ee2c2f4f538268ede4e9d8b5aa69e9');
INSERT INTO `oplog` VALUES ('T1745F40438254CB3BA55E7FE', '专家004(4)', '0.0.0.0', '1551946674', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD4B22BACE7A548BA8355FEBF', '专家004(4)', '0.0.0.0', '1551946675', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f96072c5e9ffb4faa7368ca6d51b4c8d');
INSERT INTO `oplog` VALUES ('T7B7813A4DE484E8DB3694583', '专家004(4)', '0.0.0.0', '1551946696', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c5c6d131e75dd39339b925d8ccfa8740');
INSERT INTO `oplog` VALUES ('T23B072836D2B4192BA200FE7', '专家005(5)', '0.0.0.0', '1551946701', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T2001FE4C9642472EBDDDD596', '专家005(5)', '0.0.0.0', '1551946701', null, '', null, '成功', '访问项目评审', '用户访问日志', '6451e00defeaca2a2b5aa8f6e3282f25');
INSERT INTO `oplog` VALUES ('T8E91E95C74DD4852AD0F8A89', '专家005(5)', '0.0.0.0', '1551946733', null, '', null, '成功', '访问项目评审', '用户访问日志', '5b03d93fb5fe2e7d02a7f12aa7b34b0f');
INSERT INTO `oplog` VALUES ('TA353FADE61264F488CC2D28B', '系统管理员(sysadmin)', '0.0.0.0', '1551946742', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T57736538FD824CF4860084F6', '系统管理员(sysadmin)', '0.0.0.0', '1551946745', null, '', null, '成功', '访问明细查询', '用户访问日志', '3d6ce3aff2d179f236525f3e6a96aad2');
INSERT INTO `oplog` VALUES ('TC13EEAD63CE346DB99616C8D', '专家006(6)', '0.0.0.0', '1551946763', null, '', null, '成功', '账号(6)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T3E0B5648F3BF45B3948042CC', '专家006(6)', '0.0.0.0', '1551946763', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ab4662d4b03862dfc291648cf4367f6a');
INSERT INTO `oplog` VALUES ('T1E3838ADFCD14840871616E0', '专家006(6)', '0.0.0.0', '1551946798', null, '', null, '成功', '访问项目评审', '用户访问日志', '39729e258d86200ab48496a30a3d9179');
INSERT INTO `oplog` VALUES ('T1ACDDB3AF31A4F32A0A3046F', '系统管理员(sysadmin)', '0.0.0.0', '1551946804', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T3843065192AE41BA8006283C', '系统管理员(sysadmin)', '0.0.0.0', '1551946807', null, '', null, '成功', '访问明细查询', '用户访问日志', '49308c29bb5b943453e3b2b786c7239d');
INSERT INTO `oplog` VALUES ('T9FE8405F61434C12970BFCB1', '系统管理员(sysadmin)', '0.0.0.0', '1551946847', null, '', null, '成功', '访问评分统计', '用户访问日志', '822f552447105cac7dfa0adfaef77225');
INSERT INTO `oplog` VALUES ('TEFC30D08263747608E8873F5', '系统管理员(sysadmin)', '0.0.0.0', '1551946926', null, '', null, '成功', '访问评分统计', '用户访问日志', 'a08039bf3f1639421bd29e92b83609f4');
INSERT INTO `oplog` VALUES ('T93E7E60B88924451A05F4B10', '系统管理员(sysadmin)', '0.0.0.0', '1551947050', null, '', null, '成功', '访问明细查询', '用户访问日志', '0caa89842ee70a353a4890219c8ef721');
INSERT INTO `oplog` VALUES ('T42B9350F3A7C4206BD739A69', '系统管理员(sysadmin)', '0.0.0.0', '1551947051', null, '', null, '成功', '访问评分统计', '用户访问日志', '2737f3382be9e9fef2efedca67a480f7');
INSERT INTO `oplog` VALUES ('TF21161466CAB4095938CEAAB', '系统管理员(sysadmin)', '0.0.0.0', '1551947086', null, '', null, '成功', '导出', '明细查询', '59c837cabf1a98f28161730a40b0f635');
INSERT INTO `oplog` VALUES ('T0C2BC6C2DE43442591045A84', '系统管理员(sysadmin)', '0.0.0.0', '1551947150', null, '', null, '成功', '访问明细查询', '用户访问日志', 'a4fdb96b9bf6102001b9b58829712e50');
INSERT INTO `oplog` VALUES ('T91B779BCA01547958F82D901', '专家001(1)', '0.0.0.0', '1551947159', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T8EE820FFB44843F690757D40', '专家001(1)', '0.0.0.0', '1551947159', null, '', null, '成功', '访问项目评审', '用户访问日志', '069fd1e5fa0dcf25ca828e1f2e933b26');
INSERT INTO `oplog` VALUES ('T0FF8572825F941499C98CAEE', '专家001(1)', '0.0.0.0', '1551947162', null, '', null, '成功', '访问项目评审', '用户访问日志', '0927ba0397822caf944863d125d5a896');
INSERT INTO `oplog` VALUES ('T19DAAD65E6C4432E829D5EB0', '系统管理员(sysadmin)', '0.0.0.0', '1551947181', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC3622D268061432885547CA6', '专家001(1)', '0.0.0.0', '1551947206', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T604B3276A5344B56A5DCB5C6', '专家001(1)', '0.0.0.0', '1551947206', null, '', null, '成功', '访问项目评审', '用户访问日志', '4ba6963f067c5397453cbfa6085c9403');
INSERT INTO `oplog` VALUES ('T6FC7713DB93F41E19F1B62D8', '专家001(1)', '0.0.0.0', '1551947306', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c5f6f485427ee38b18f2e4d0b6e53bae');
INSERT INTO `oplog` VALUES ('TAA702AB6DCF24A249F0438AF', '专家002(2)', '0.0.0.0', '1551947797', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6A1066A64E704572A4AF0881', '专家002(2)', '0.0.0.0', '1551947797', null, '', null, '成功', '访问项目评审', '用户访问日志', '1bcf1a4d6f9a33db9dcb15f2d586106e');
INSERT INTO `oplog` VALUES ('TEE75F2C1C4DE46189022C5F8', '专家003(3)', '0.0.0.0', '1551947810', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB37F424405694F98BCEE89F5', '专家003(3)', '0.0.0.0', '1551947810', null, '', null, '成功', '访问项目评审', '用户访问日志', '564dc466f8345575ae7e5d63841003d0');
INSERT INTO `oplog` VALUES ('T9DE8BAFA24114B1E85B820A4', '专家004(4)', '0.0.0.0', '1551947822', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T8DAA79E6BE3F4FA09F8C4A63', '专家004(4)', '0.0.0.0', '1551947822', null, '', null, '成功', '访问项目评审', '用户访问日志', '3451a7a54d1ff4eb004215d071e9f9e4');
INSERT INTO `oplog` VALUES ('T23DB502F5A49484BA24F69E5', '专家005(5)', '0.0.0.0', '1551947835', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T4AFF838124F245EF94563F94', '专家005(5)', '0.0.0.0', '1551947835', null, '', null, '成功', '访问项目评审', '用户访问日志', '90d17b90aa12c447c948ecb4e22d9c01');
INSERT INTO `oplog` VALUES ('T917CAD36753C40FFA7DD47CB', '专家006(6)', '0.0.0.0', '1551947849', null, '', null, '成功', '账号(6)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TBF51957E4CF348B1A92C0783', '专家006(6)', '0.0.0.0', '1551947849', null, '', null, '成功', '访问项目评审', '用户访问日志', '852de5fefc161524887ec3c570640d0d');
INSERT INTO `oplog` VALUES ('T4FC9542036CA4E5FA97A1B85', '系统管理员(sysadmin)', '0.0.0.0', '1551947861', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T31D7E64498504E97A182F676', '系统管理员(sysadmin)', '0.0.0.0', '1551947863', null, '', null, '成功', '访问投票统计', '用户访问日志', '5c8d8dd9d61df79ccb6952f5630eb254');
INSERT INTO `oplog` VALUES ('TF340DD3AF88A42B1BD45DA4D', '系统管理员(sysadmin)', '0.0.0.0', '1551947872', null, '', null, '成功', '访问评分统计', '用户访问日志', '7f8e1043438d52a40e4f8c81fc4dd979');
INSERT INTO `oplog` VALUES ('T2A07E8389F3B46CB965A9242', '系统管理员(sysadmin)', '0.0.0.0', '1551947875', null, '', null, '成功', '访问明细查询', '用户访问日志', 'c82663150d4db229192e1a572e9c7c16');
INSERT INTO `oplog` VALUES ('T16015073D2814F6A8BDFA8A9', '系统管理员(sysadmin)', '0.0.0.0', '1551947901', null, '', null, '成功', '访问投票统计', '用户访问日志', 'dfeef09d576bc812e1b6284bf10654e6');
INSERT INTO `oplog` VALUES ('T0E348095B4D24BC9A82DC258', '系统管理员(sysadmin)', '0.0.0.0', '1551947921', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd5d2753354f4fa9774549b5606230b5b');
INSERT INTO `oplog` VALUES ('TD647030164C94218B68D9A7C', '系统管理员(sysadmin)', '0.0.0.0', '1551947983', null, '', null, '成功', '访问评分统计', '用户访问日志', '75cd516965793fc51d0d4100bfe1fac2');
INSERT INTO `oplog` VALUES ('T3263E8AA6D544F239CBB256D', '系统管理员(sysadmin)', '0.0.0.0', '1551948013', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7D1727825B844A769D8893D7', '系统管理员(sysadmin)', '0.0.0.0', '1551948014', null, '', null, '成功', '访问评分统计', '用户访问日志', '7604dc915756360985c8a7f437ade839');
INSERT INTO `oplog` VALUES ('T14BEF1F3C85440288B5B0BED', '系统管理员(sysadmin)', '0.0.0.0', '1551948018', null, '', null, '成功', '访问投票统计', '用户访问日志', '74a9c62c4dfdd7545efdf3c01ae9c80a');
INSERT INTO `oplog` VALUES ('T1B807C14F8AD46C19F7EF277', '系统管理员(sysadmin)', '0.0.0.0', '1551948020', null, '', null, '成功', '访问明细查询', '用户访问日志', '3d0ca980bfead8bdcc130d1382a54c2b');
INSERT INTO `oplog` VALUES ('T21BA93DDB7794ABF89BB9B17', '系统管理员(sysadmin)', '0.0.0.0', '1551948021', null, '', null, '成功', '访问评分统计', '用户访问日志', '44ca5d4a0235caac19bc0e81adf6b98d');
INSERT INTO `oplog` VALUES ('TA0C8C744A9DF453EB2AC5AED', '系统管理员(sysadmin)', '0.0.0.0', '1551948026', null, '', null, '成功', '访问明细查询', '用户访问日志', '8df4286e41727b6a4722cbabe244fc1c');
INSERT INTO `oplog` VALUES ('T8314F60AA55E4CDFACA0B5DC', '专家006(6)', '0.0.0.0', '1551948033', null, '', null, '成功', '账号(6)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7DAB2AB2C742444BA94BAF2B', '专家006(6)', '0.0.0.0', '1551948033', null, '', null, '成功', '访问项目评审', '用户访问日志', 'af201e7fe1cd28f7af2797590dd942b2');
INSERT INTO `oplog` VALUES ('TC944820483F14314800AE8E3', '系统管理员(sysadmin)', '0.0.0.0', '1551948072', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC5FA64CE78A2454FACC3579A', '系统管理员(sysadmin)', '0.0.0.0', '1551948107', null, '', null, '成功', '访问评分统计', '用户访问日志', '48a71b34f63dc945338ca9ce113f8c2b');
INSERT INTO `oplog` VALUES ('TABA64038E737478EA23ACFD4', '系统管理员(sysadmin)', '0.0.0.0', '1551948107', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd0ece6c8eef043e55bcd383542b1975b');
INSERT INTO `oplog` VALUES ('TCA18A1ADE0E848E98536A0AB', '系统管理员(sysadmin)', '0.0.0.0', '1551948131', null, '', null, '成功', '访问明细查询', '用户访问日志', '824d3e42b4cad10fc13e322d4071f1a4');
INSERT INTO `oplog` VALUES ('T1F0EAEBB6648485DBD03A86C', '系统管理员(sysadmin)', '0.0.0.0', '1551948165', null, '', null, '成功', '访问投票统计', '用户访问日志', '1f18633a578b73cfec56ae58e176e002');
INSERT INTO `oplog` VALUES ('TDFDA0CE6FD724273AEBC5980', '系统管理员(sysadmin)', '0.0.0.0', '1551948170', null, '', null, '成功', '访问评分统计', '用户访问日志', '99e804aad6b755f5118405590156c950');
INSERT INTO `oplog` VALUES ('T0E11E96AB8EE44F8A2382A88', '系统管理员(sysadmin)', '0.0.0.0', '1551948172', null, '', null, '成功', '访问投票统计', '用户访问日志', '9608b5556abf4f63fc0cf910065fc8cd');
INSERT INTO `oplog` VALUES ('T2B0906989DF2416B8E2B05D5', '系统管理员(sysadmin)', '0.0.0.0', '1551948184', null, '', null, '成功', '访问评分统计', '用户访问日志', 'ab78f501676fab91beea65b910c3d37f');
INSERT INTO `oplog` VALUES ('T3216067B951A479081732662', '系统管理员(sysadmin)', '0.0.0.0', '1551948223', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T877631B9DDB14A91AECED0D6', '系统管理员(sysadmin)', '0.0.0.0', '1551948239', null, '', null, '成功', '访问明细查询', '用户访问日志', 'e3f77221da8c5e803674ac4220b5fc25');
INSERT INTO `oplog` VALUES ('T8A07C74F65A4478F9E08E78B', '系统管理员(sysadmin)', '0.0.0.0', '1551948241', null, '', null, '成功', '访问评分统计', '用户访问日志', 'f7a918acd3f2253d97ed70d179ceba75');
INSERT INTO `oplog` VALUES ('T01BC80BCAD75445783062A20', '系统管理员(sysadmin)', '0.0.0.0', '1551948243', null, '', null, '成功', '访问投票统计', '用户访问日志', '20617bd76d14ecb50535b3856f4b5ce8');
INSERT INTO `oplog` VALUES ('TDBF0911732E24C8890033DAD', '系统管理员(sysadmin)', '0.0.0.0', '1551948245', null, '', null, '成功', '访问评分统计', '用户访问日志', 'f04962cff28566fa7cf7be268bff4e59');
INSERT INTO `oplog` VALUES ('TEBCC2B9BC12D4573A38E0C1E', '系统管理员(sysadmin)', '0.0.0.0', '1551948276', null, '', null, '成功', '访问评分统计', '用户访问日志', '0d8333167211128645bb336692d68b25');
INSERT INTO `oplog` VALUES ('TDE08603C5129446C913AB177', '系统管理员(sysadmin)', '0.0.0.0', '1551948404', null, '', null, '成功', '访问投票统计', '用户访问日志', 'c21b72f5ac979721452c3704d0d80340');
INSERT INTO `oplog` VALUES ('T6411BB1B080B483185681594', '系统管理员(sysadmin)', '0.0.0.0', '1551948497', null, '', null, '成功', '访问评分统计', '用户访问日志', '1b213c1cdf5db4a2564b6b48fc534bef');
INSERT INTO `oplog` VALUES ('T3142985382444DF29C9A32E6', '系统管理员(sysadmin)', '0.0.0.0', '1551948498', null, '', null, '成功', '访问投票统计', '用户访问日志', '9808076dafcfdf7f91d739b3c6547ec6');
INSERT INTO `oplog` VALUES ('T3C47D24F33544B4ABD5655D6', '系统管理员(sysadmin)', '0.0.0.0', '1551948638', null, '', null, '成功', '访问投票统计', '用户访问日志', '759b1a336603749a65aa8d89dfa733d6');
INSERT INTO `oplog` VALUES ('T0B5F2467FE3F4CFF966B244C', '系统管理员(sysadmin)', '0.0.0.0', '1551948749', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b1f1805a60bf6b75d8ebbdb7ea13d17f');
INSERT INTO `oplog` VALUES ('T1F3B5D45740940F0BF343EAD', '系统管理员(sysadmin)', '0.0.0.0', '1551948750', null, '', null, '成功', '访问明细查询', '用户访问日志', '4dffb58b4d49c9017b00e000506d2b53');
INSERT INTO `oplog` VALUES ('T3CB84D1B61B14FC499227E1A', '系统管理员(sysadmin)', '0.0.0.0', '1551948754', null, '', null, '成功', '访问评分统计', '用户访问日志', '11d6a5825cc257d692b3991dbc3a1b49');
INSERT INTO `oplog` VALUES ('T4987AF254B214B02B85DD354', '系统管理员(sysadmin)', '0.0.0.0', '1551948806', null, '', null, '成功', '访问评分统计', '用户访问日志', 'acfcafbeac3dd76b1f32251fa05f5db8');
INSERT INTO `oplog` VALUES ('T5DEFB84253FA466BB64401AE', '系统管理员(sysadmin)', '0.0.0.0', '1551949494', null, '', null, '成功', '访问投票统计', '用户访问日志', 'c7a90ddfca7541de219ebaf7cddf5115');
INSERT INTO `oplog` VALUES ('TA8B830F09B4B4D84B491EA19', '系统管理员(sysadmin)', '0.0.0.0', '1551949514', null, '', null, '成功', '访问投票统计', '用户访问日志', '676880ff500bd4408576a567e4a5ba2c');
INSERT INTO `oplog` VALUES ('TA0D61A80191C4D83B4D51352', '系统管理员(sysadmin)', '0.0.0.0', '1551949554', null, '', null, '成功', '访问评分统计', '用户访问日志', '46fce9ec419130339f62fb9aced645d8');
INSERT INTO `oplog` VALUES ('T39CD9F368B6F4CD1A53F8573', '系统管理员(sysadmin)', '0.0.0.0', '1551949634', null, '', null, '成功', '访问投票统计', '用户访问日志', '8b36e8d9f2a35eb0576ec22b9e3cd65c');
INSERT INTO `oplog` VALUES ('T25EFA2D3B6AC49C69E23459C', '系统管理员(sysadmin)', '0.0.0.0', '1551949655', null, '', null, '成功', '访问投票统计', '用户访问日志', 'f18238ec1117e1626fa39e0dcfd1da17');
INSERT INTO `oplog` VALUES ('TBD0C378A0EBD4D2F80C87D82', '系统管理员(sysadmin)', '0.0.0.0', '1551949676', null, '', null, '成功', '访问投票统计', '用户访问日志', '2b56b27c2f516f0a1618eb9809860ac1');
INSERT INTO `oplog` VALUES ('T5A4BA95756FE40548C0DACE6', '系统管理员(sysadmin)', '0.0.0.0', '1551949686', null, '', null, '成功', '访问投票统计', '用户访问日志', 'a0b920360a602676501f6a6c3cb0e676');
INSERT INTO `oplog` VALUES ('T7C56D226BE4240CD94AFB40C', '系统管理员(sysadmin)', '0.0.0.0', '1551949717', null, '', null, '成功', '访问投票统计', '用户访问日志', '27e66bcf7f9f4ed64e76e951b294f1ba');
INSERT INTO `oplog` VALUES ('TE83E5E2EB9464E488E91DAFE', '系统管理员(sysadmin)', '0.0.0.0', '1551949732', null, '', null, '成功', '访问投票统计', '用户访问日志', '0d74e79b99e9805cf7168996e1ec022c');
INSERT INTO `oplog` VALUES ('TCC21C8A210F645D898070AD1', '系统管理员(sysadmin)', '0.0.0.0', '1551949738', null, '', null, '成功', '访问投票统计', '用户访问日志', 'e08729c8cf7fbafc559683df258d80c5');
INSERT INTO `oplog` VALUES ('T40D7C73DCFE54F63A67AEC0C', '系统管理员(sysadmin)', '0.0.0.0', '1551949911', null, '', null, '成功', '访问投票统计', '用户访问日志', '68b923cbb62b524f133b321e70e4c92f');
INSERT INTO `oplog` VALUES ('T78C61D33E0874F64A170EDF2', '系统管理员(sysadmin)', '0.0.0.0', '1551949942', null, '', null, '成功', '访问投票统计', '用户访问日志', 'cb71737a0d5fd5458e8c4311c68e25b7');
INSERT INTO `oplog` VALUES ('TD18327CEE6CB4D17AB8751A4', '系统管理员(sysadmin)', '0.0.0.0', '1551950430', null, '', null, '成功', '访问投票统计', '用户访问日志', '1f50f2c055b76d12975da07d46d00a68');
INSERT INTO `oplog` VALUES ('T79EE4D2F0C5645639F5D9F1B', '系统管理员(sysadmin)', '0.0.0.0', '1551950474', null, '', null, '成功', '访问投票统计', '用户访问日志', '510d6736ba3ffd80f0af91cb835fef20');
INSERT INTO `oplog` VALUES ('TF51939EE2B6E4D64B009F00F', '系统管理员(sysadmin)', '0.0.0.0', '1551950644', null, '', null, '成功', '访问投票统计', '用户访问日志', 'df0228fcf010f8d105acaa340aefc499');
INSERT INTO `oplog` VALUES ('TCA85F1D4B88F4BFF8A192F10', '系统管理员(sysadmin)', '0.0.0.0', '1551950931', null, '', null, '成功', '访问评分统计', '用户访问日志', 'c33b7b307bfd67922533cdf03fe955f9');
INSERT INTO `oplog` VALUES ('T3A821981065E4D1390936EAB', '系统管理员(sysadmin)', '0.0.0.0', '1551950941', null, '', null, '成功', '访问评分统计', '用户访问日志', '78ef76495626f084ada3b45a94e74658');
INSERT INTO `oplog` VALUES ('T76AB9C66CF174B87871D352D', '系统管理员(sysadmin)', '0.0.0.0', '1551951009', null, '', null, '成功', '访问评分统计', '用户访问日志', '01e16f836f6c1d2950215551cc415c13');
INSERT INTO `oplog` VALUES ('T67D00CE68E884845A68D0314', '系统管理员(sysadmin)', '0.0.0.0', '1551951212', null, '', null, '成功', '访问评分统计', '用户访问日志', '7fa9498363539f47ea68a9bc56296e42');
INSERT INTO `oplog` VALUES ('TBF454FF11A944D9181215CEC', '系统管理员(sysadmin)', '0.0.0.0', '1551951298', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b63c48bad3bf306aaeee19d2137e5267');
INSERT INTO `oplog` VALUES ('T426F5EF9356640B59E344CDD', '系统管理员(sysadmin)', '0.0.0.0', '1551951305', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd3d7447c90bcad70bf1f4288c420f128');
INSERT INTO `oplog` VALUES ('T67639D3A71DE415EBA017BDB', '专家001(1)', '0.0.0.0', '1551951359', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T80291BD2BE0B486986145F6E', '专家001(1)', '0.0.0.0', '1551951359', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e69d96af9ea78d734e91aaf9ddc07d4f');
INSERT INTO `oplog` VALUES ('TDE37318F5A26450E90DD1BA8', '系统管理员(sysadmin)', '0.0.0.0', '1551951533', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB0B414276F954C50ABC6EA34', '系统管理员(sysadmin)', '0.0.0.0', '1551951534', null, '', null, '成功', '访问评分统计', '用户访问日志', '5239ebafe71d80c7f3d5ccf6a2b57bb9');
INSERT INTO `oplog` VALUES ('TFF9CED3463BD442E981B680B', '专家001(1)', '0.0.0.0', '1551951549', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCA121C3D9DD848B8A4DA6D98', '专家001(1)', '0.0.0.0', '1551951549', null, '', null, '成功', '访问项目评审', '用户访问日志', '864350cddf6a6af29090b24002c831be');
INSERT INTO `oplog` VALUES ('TDE68560873BC44AF98D44772', '专家001(1)', '0.0.0.0', '1551951556', null, '', null, '成功', '访问项目评审', '用户访问日志', '4a10266cad56d7c4b9f56d848ec0401b');
INSERT INTO `oplog` VALUES ('T656DFF3C8341485F866054E4', '系统管理员(sysadmin)', '0.0.0.0', '1551951579', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TEB481CB0D5544673870033DE', '系统管理员(sysadmin)', '0.0.0.0', '1551951580', null, '', null, '成功', '访问投票统计', '用户访问日志', '69a73d98785aaa3eefc66f5cccfab701');
INSERT INTO `oplog` VALUES ('T434CEC840D224FFA9F0662C5', '系统管理员(sysadmin)', '0.0.0.0', '1551951600', null, '', null, '成功', '访问投票统计', '用户访问日志', '8a3ec016ae676d1f7470fd73809d7196');
INSERT INTO `oplog` VALUES ('T5E7060C9224D4CC8A1DD0B9A', '专家001(1)', '0.0.0.0', '1551951609', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T97140976A5AC4B8EB6583169', '专家001(1)', '0.0.0.0', '1551951609', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c667ad41981217830b14c5a0f5a6883a');
INSERT INTO `oplog` VALUES ('T480B6A69CDDE477A943D5F77', '专家002(2)', '0.0.0.0', '1551951643', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6214A777208343F7AF05C50E', '专家002(2)', '0.0.0.0', '1551951643', null, '', null, '成功', '访问项目评审', '用户访问日志', '78b343b0de5a58a722c3f0d1e8a8f04a');
INSERT INTO `oplog` VALUES ('T8A15713AF0B143EBBFF8DDF9', '专家003(3)', '0.0.0.0', '1551951666', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T67AEF33E26D1427EBC22EBFF', '专家003(3)', '0.0.0.0', '1551951666', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd40e13c9c91296cbd48472c030aa0e99');
INSERT INTO `oplog` VALUES ('T93563D4675DD496684822E5C', '专家004(4)', '0.0.0.0', '1551951693', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TF3B147A8CBEC48B08C264E7C', '专家004(4)', '0.0.0.0', '1551951694', null, '', null, '成功', '访问项目评审', '用户访问日志', 'aa2c550ae35d1670a011668263e1057a');
INSERT INTO `oplog` VALUES ('TF3A7F949340E4DE18395DCF5', '专家005(5)', '0.0.0.0', '1551951705', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TEBC0DA4D957C4121BD621F1F', '专家005(5)', '0.0.0.0', '1551951706', null, '', null, '成功', '访问项目评审', '用户访问日志', '4d93d54fcce4e80ced8d849726466467');
INSERT INTO `oplog` VALUES ('T61FEFFDEF22542109EC8DC3F', '专家006(6)', '0.0.0.0', '1551951719', null, '', null, '成功', '账号(6)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TF441A1F344B64E509B28AEFB', '专家006(6)', '0.0.0.0', '1551951719', null, '', null, '成功', '访问项目评审', '用户访问日志', '30e4473bde81cdb479daea15edde8ae8');
INSERT INTO `oplog` VALUES ('TEDC706F3D9BC4661B285DD6B', '系统管理员(sysadmin)', '0.0.0.0', '1551951744', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T375713DB1140493794F2DF32', '系统管理员(sysadmin)', '0.0.0.0', '1551951746', null, '', null, '成功', '访问数据交互', '用户访问日志', '7b88145e229f4b32d9e9b77feebb376c');
INSERT INTO `oplog` VALUES ('T74777D34D420467E9855F5F4', '系统管理员(sysadmin)', '0.0.0.0', '1551951747', null, '', null, '成功', '访问投票统计', '用户访问日志', '2a0aa098eb0a598ba479abdca63853b3');
INSERT INTO `oplog` VALUES ('T969F696D248442B2BAE7C078', '系统管理员(sysadmin)', '0.0.0.0', '1551951795', null, '', null, '成功', '访问投票统计', '用户访问日志', '2b4601bd1601cf1418ee79c87dee6675');
INSERT INTO `oplog` VALUES ('TA5F2F7C2357B4684A6369772', '系统管理员(sysadmin)', '0.0.0.0', '1551951817', null, '', null, '成功', '访问评分统计', '用户访问日志', '482b5a85f8f1aa3df30c39c7599aa2a3');
INSERT INTO `oplog` VALUES ('TEB9CE9817BCC406E8984D733', '系统管理员(sysadmin)', '0.0.0.0', '1551951818', null, '', null, '成功', '访问明细查询', '用户访问日志', '866d3e77cfd1c54ff09150e7aaec1f55');
INSERT INTO `oplog` VALUES ('T2EF8BC4B317F470EA184AFCB', '系统管理员(sysadmin)', '0.0.0.0', '1552005680', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB9AAF6C987E64FC9BA2D700A', '系统管理员(sysadmin)', '0.0.0.0', '1552005687', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd466db2a681d55a8813bfaff05a204b6');
INSERT INTO `oplog` VALUES ('T577B18C118A74038A568E985', '系统管理员(sysadmin)', '0.0.0.0', '1552005700', null, '', null, '成功', '访问投票统计', '用户访问日志', '9b744969d7cd46ad905e51c827a5e4c8');
INSERT INTO `oplog` VALUES ('T5BB9D52491B44811A275150F', '系统管理员(sysadmin)', '0.0.0.0', '1552005902', null, '', null, '成功', '访问投票统计', '用户访问日志', '6580af07735376b2baf02dc09435305f');
INSERT INTO `oplog` VALUES ('T0E756F1F12A641F7AAB47C7A', '系统管理员(sysadmin)', '0.0.0.0', '1552007287', null, '', null, '成功', '访问数据交互', '用户访问日志', 'd08f1a32a3a4dc1a774a2ce99736e8e5');
INSERT INTO `oplog` VALUES ('T9D32C97B3C9944D0A3F17B63', '系统管理员(sysadmin)', '0.0.0.0', '1552264143', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T1D8D70E0A4A649CC900FB39A', '系统管理员(sysadmin)', '0.0.0.0', '1552264146', null, '', null, '成功', '访问用户管理', '用户访问日志', 'a27f16a8248ca7c1257006dbdad304be');
INSERT INTO `oplog` VALUES ('TBD7717B3D91540DEB919B873', '系统管理员(sysadmin)', '0.0.0.0', '1552264148', null, '', null, '成功', '访问明细查询', '用户访问日志', '85cffc9017ebf1583de3d943ce4eecbc');
INSERT INTO `oplog` VALUES ('T11DC378D6EE84DABA1752300', '系统管理员(sysadmin)', '0.0.0.0', '1552264149', null, '', null, '成功', '访问评分统计', '用户访问日志', 'baa467edaecf120aa14243552023472e');
INSERT INTO `oplog` VALUES ('TA6E4E47DE449484A80D536F4', '系统管理员(sysadmin)', '0.0.0.0', '1552264150', null, '', null, '成功', '访问投票统计', '用户访问日志', '15e6aa25546317058dc0ad9bd2c71175');
INSERT INTO `oplog` VALUES ('TD46C061F0EAE452CADAD6AB6', '系统管理员(sysadmin)', '0.0.0.0', '1552264153', null, '', null, '成功', '访问数据交互', '用户访问日志', '8681e596681a4db05c1571e24bae03a4');
INSERT INTO `oplog` VALUES ('T502535DB9DE8494F8E692DE3', '系统管理员(sysadmin)', '0.0.0.0', '1552264155', null, '', null, '成功', '访问投票统计', '用户访问日志', '8b9448fd340bdb09fb90af3159ca92d9');
INSERT INTO `oplog` VALUES ('TDB1DB606DE744C02A779AB49', '系统管理员(sysadmin)', '0.0.0.0', '1552351122', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB86E8DC22A434826A1DB59F1', '系统管理员(sysadmin)', '0.0.0.0', '1552351126', null, '', null, '成功', '访问明细查询', '用户访问日志', '0def7fca2a492854454a0f35be938765');
INSERT INTO `oplog` VALUES ('T356A58A1493E4D0895A91B16', '系统管理员(sysadmin)', '0.0.0.0', '1552351138', null, '', null, '成功', '访问评分统计', '用户访问日志', '55e1bbaf9932b54c2eca11da9d747f93');
INSERT INTO `oplog` VALUES ('T18B648840495467BB879F362', '系统管理员(sysadmin)', '0.0.0.0', '1552351140', null, '', null, '成功', '访问投票统计', '用户访问日志', '288e14a2a5d89f8e0a96767870f93b2d');
INSERT INTO `oplog` VALUES ('T34324FA70C24403996216720', '系统管理员(sysadmin)', '0.0.0.0', '1552351141', null, '', null, '成功', '访问数据交互', '用户访问日志', 'e68f59df854e42e525531537723e1bde');
INSERT INTO `oplog` VALUES ('TCEF6337DEC424EE69DAD09E0', '系统管理员(sysadmin)', '0.0.0.0', '1552351142', null, '', null, '成功', '访问投票统计', '用户访问日志', 'b27ec41621f42023454a0c4a41030884');
INSERT INTO `oplog` VALUES ('TCD40074FCF2A4559831EF4A6', '系统管理员(sysadmin)', '0.0.0.0', '1552351143', null, '', null, '成功', '访问评分统计', '用户访问日志', '350a2133d1b12567634242baaaaa770d');
INSERT INTO `oplog` VALUES ('TA3A60B4899504BEFA174D244', '系统管理员(sysadmin)', '0.0.0.0', '1552351143', null, '', null, '成功', '访问明细查询', '用户访问日志', '1c4179785db3046fd782a1a555e7160d');
INSERT INTO `oplog` VALUES ('T96F91E1A2F0C45469DF889C3', '系统管理员(sysadmin)', '0.0.0.0', '1552351414', null, '', null, '成功', '访问用户管理', '用户访问日志', '7ebc355826391f6630fa51e9fb629100');
INSERT INTO `oplog` VALUES ('T23D460A54E1C4300AF38AF22', '系统管理员(sysadmin)', '0.0.0.0', '1552351418', null, '', null, '成功', '访问明细查询', '用户访问日志', 'e7d0095e60f5f84c4aad429e8b294fa6');
INSERT INTO `oplog` VALUES ('T96D8CB5DD64745E8B83B4A05', '系统管理员(sysadmin)', '0.0.0.0', '1552351418', null, '', null, '成功', '访问明细查询', '用户访问日志', 'd186c0113a2cb6bdf1f0a19d439ecedd');
INSERT INTO `oplog` VALUES ('T9B9B53B08C6D47E5B01ED41A', '系统管理员(sysadmin)', '0.0.0.0', '1552351422', null, '', null, '成功', '访问投票统计', '用户访问日志', 'dd23e10dbede89dd525e28dfe780b96b');
INSERT INTO `oplog` VALUES ('T5B5FFB8669E24BCABA288ABE', '系统管理员(sysadmin)', '0.0.0.0', '1552351423', null, '', null, '成功', '访问数据交互', '用户访问日志', '684a1e76b68a21b7ce7b18cf02d51c4b');
INSERT INTO `oplog` VALUES ('TADF998D89A7A4F42A90E4942', '系统管理员(sysadmin)', '0.0.0.0', '1552351424', null, '', null, '成功', '访问评分统计', '用户访问日志', '2fa1da8e6bdf95266df7cca28b6722c6');
INSERT INTO `oplog` VALUES ('TEFF7AFB9C2A748F79A610D65', '系统管理员(sysadmin)', '0.0.0.0', '1552351436', null, '', null, '成功', '访问用户管理', '用户访问日志', 'cedb75369ce5ad2d8d6c1f46d74cdddb');
INSERT INTO `oplog` VALUES ('T96D13CF1544A400584E1FB36', '系统管理员(sysadmin)', '0.0.0.0', '1552351438', null, '', null, '成功', '访问明细查询', '用户访问日志', '8159c9dc2a199837915a1b9dd8f7a835');
INSERT INTO `oplog` VALUES ('TCA84A81C386246DF9F1FC631', '系统管理员(sysadmin)', '0.0.0.0', '1552351439', null, '', null, '成功', '访问评分统计', '用户访问日志', '1554899765bc6471eea03fb3ad043f11');
INSERT INTO `oplog` VALUES ('TC1ED887E7B4C4BCFB0EC8867', '系统管理员(sysadmin)', '0.0.0.0', '1552351440', null, '', null, '成功', '访问投票统计', '用户访问日志', 'c2a400c032a02108814021b3aebe71c3');
INSERT INTO `oplog` VALUES ('TC0FEE9CA34FA4A8FA26FE140', '系统管理员(sysadmin)', '0.0.0.0', '1552351441', null, '', null, '成功', '访问数据交互', '用户访问日志', '1b6b2f0ba8b8c24f3b3410bc703a4398');
INSERT INTO `oplog` VALUES ('T0C2E3A6CFB9F4A0B9830233E', '系统管理员(sysadmin)', '0.0.0.0', '1552351442', null, '', null, '成功', '访问投票统计', '用户访问日志', '0f097654505a5b62b6c510ea7ed223cb');
INSERT INTO `oplog` VALUES ('TA6B5E4E980EC402F9FEC1E8A', '系统管理员(sysadmin)', '0.0.0.0', '1552351946', null, '', null, '成功', '访问用户管理', '用户访问日志', 'c141116f0a506a6840e00e8922a7982c');
INSERT INTO `oplog` VALUES ('T86DC6D9D87D24A8C9289AB1D', '系统管理员(sysadmin)', '0.0.0.0', '1552352169', null, '', null, '成功', '访问明细查询', '用户访问日志', 'fecbf2f4bdbd57f42d26fcefea4e69e3');
INSERT INTO `oplog` VALUES ('T1B5099FB55144E58B6F59C96', '系统管理员(sysadmin)', '0.0.0.0', '1552352174', null, '', null, '成功', '访问评分统计', '用户访问日志', 'e9c19d68ce4dca8cdfacb3a4f227f0e9');
INSERT INTO `oplog` VALUES ('T55911EAF3F2244B9975B7FFD', '系统管理员(sysadmin)', '0.0.0.0', '1552352176', null, '', null, '成功', '访问投票统计', '用户访问日志', 'ccd6ee48247d91a02c662f1c0331241e');
INSERT INTO `oplog` VALUES ('T56430840370A493D87E9AEB9', '系统管理员(sysadmin)', '0.0.0.0', '1552352177', null, '', null, '成功', '访问数据交互', '用户访问日志', '2a540337a8881d07802420d8e99323f7');
INSERT INTO `oplog` VALUES ('T213BAFBB71874DCC8D1581C2', '系统管理员(sysadmin)', '0.0.0.0', '1552352179', null, '', null, '成功', '访问用户管理', '用户访问日志', '42b68d2849a14eea9d190901985d58da');
INSERT INTO `oplog` VALUES ('TA1DF897E65CF4A048D42769D', '专家1(1)', '0.0.0.0', '1552352185', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB538AFD1CE3D42DCA8FF2757', '专家1(1)', '0.0.0.0', '1552352194', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE16CD917E4B0435A9BB89934', '专家1(1)', '0.0.0.0', '1552352228', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TDF18959653714C7785600A82', '专家1(1)', '0.0.0.0', '1552352322', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE6890E5229294D86B29CDC34', '专家1(1)', '0.0.0.0', '1552352323', null, '', null, '成功', '访问项目评审', '用户访问日志', '8aeb09fc4f5e590448dfb3eee7b40a3e');
INSERT INTO `oplog` VALUES ('T3D1D113045AC47EE95F942A5', '安全管理员(secadmin)', '0.0.0.0', '1552352361', null, '', null, '成功', '账号(secadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE58E5255CC084692B5E5C195', '安全管理员(secadmin)', '0.0.0.0', '1552352361', null, '', null, '成功', '访问字典类型管理页面', '用户访问日志', '811f88ba95342848aef5de6095959606');
INSERT INTO `oplog` VALUES ('TE4D90F1C174E4571A5679F7E', '安全管理员(secadmin)', '0.0.0.0', '1552352367', null, '', null, '成功', '访问用户授权管理', '用户访问日志', '5b807c2a60bdcba9f54df46598a24c50');
INSERT INTO `oplog` VALUES ('T1FD8C5C99ABB44AA9A89B74C', '安全管理员(secadmin)', '0.0.0.0', '1552352373', null, '', null, '成功', '访问模块授权管理', '用户访问日志', '62a9301c3b2e8db977a7415f51ba891c');
INSERT INTO `oplog` VALUES ('T843E237DDC35440E92A6EA7C', '安全管理员(secadmin)', '0.0.0.0', '1552352389', null, 'roleauth', null, '成功', '删除角色()的军队项目投票模块权限', '三员操作日志', 'e1a087a0510edee6040bad31a37aadbf');
INSERT INTO `oplog` VALUES ('TF09401E805994E7A865403F3', '安全管理员(secadmin)', '0.0.0.0', '1552352389', null, 'roleauth', null, '成功', '给角色(专家)赋予军队项目投票的模块权限', '三员操作日志', '39ff54b96d5a7dbf433d9aba694dc074');
INSERT INTO `oplog` VALUES ('TDC6D246B69AA44C995BEBAD9', '安全管理员(secadmin)', '0.0.0.0', '1552352394', null, 'roleauth', null, '成功', '删除角色()的地方项目打分模块权限', '三员操作日志', '31797106b8ac31e0c590af65723deece');
INSERT INTO `oplog` VALUES ('T964E23232809449C9BAD2D43', '安全管理员(secadmin)', '0.0.0.0', '1552352394', null, 'roleauth', null, '成功', '给角色(专家)赋予地方项目打分的模块权限', '三员操作日志', '86f1864e458baa08a16de9f40796d205');
INSERT INTO `oplog` VALUES ('T0F3B2CEE45174662825E1B83', '安全管理员(secadmin)', '0.0.0.0', '1552352398', null, 'roleauth', null, '成功', '删除角色()的地方项目投票模块权限', '三员操作日志', '984f9304dda9ad7050d4ca32451f5fa6');
INSERT INTO `oplog` VALUES ('T8001ECE04F134F21ACCA23C2', '安全管理员(secadmin)', '0.0.0.0', '1552352398', null, 'roleauth', null, '成功', '给角色(专家)赋予地方项目投票的模块权限', '三员操作日志', 'b69936d72f16e5063f35f3c81f59f8ef');
INSERT INTO `oplog` VALUES ('TEE75405B8E8A42368AA6CF46', '系统管理员(sysadmin)', '0.0.0.0', '1552352417', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T086C4ACFEA6842B38147353C', '系统管理员(sysadmin)', '0.0.0.0', '1552352422', null, '', null, '成功', '访问用户管理', '用户访问日志', '0d510015b7ad24f649b381374c42f253');
INSERT INTO `oplog` VALUES ('T06407AF195484C3C84B4D9E2', '系统管理员(sysadmin)', '0.0.0.0', '1552352423', null, '', null, '成功', '访问明细查询', '用户访问日志', '25f36ce2d6a4cb1680bf734c8360c1aa');
INSERT INTO `oplog` VALUES ('TD30239DBCFCE4CAC8CDF940A', '系统管理员(sysadmin)', '0.0.0.0', '1552352423', null, '', null, '成功', '访问评分统计', '用户访问日志', '27e3c2d05724776bd52938419aaec541');
INSERT INTO `oplog` VALUES ('T97059CEBEC0348EA8E050A04', '安全管理员(secadmin)', '0.0.0.0', '1552352435', null, '', null, '成功', '账号(secadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T3BE0DA617CFB4E04AAA48657', '安全管理员(secadmin)', '0.0.0.0', '1552352435', null, '', null, '成功', '访问字典类型管理页面', '用户访问日志', '7d10d1e1ea5e2159f1b78f202aca1c66');
INSERT INTO `oplog` VALUES ('T2AA3426350E04932A81D6502', '安全管理员(secadmin)', '0.0.0.0', '1552352446', null, '', null, '成功', '访问安全管理', '用户访问日志', 'd0da76e2eca9f6c2280f30e7e7dd4a04');
INSERT INTO `oplog` VALUES ('T17027A3F350042D3941290E3', '安全管理员(secadmin)', '0.0.0.0', '1552352449', null, '', null, '成功', '访问用户授权管理', '用户访问日志', 'b0cac681a23763f733f9e131f8075bc4');
INSERT INTO `oplog` VALUES ('T8780F99A2E544B90812FD0F6', '安全管理员(secadmin)', '0.0.0.0', '1552352450', null, '', null, '成功', '访问模块授权管理', '用户访问日志', 'bd869a89f85bceef7e5a50a344242b92');
INSERT INTO `oplog` VALUES ('T3A9A3DDE0D1542B38285CEF4', '安全管理员(secadmin)', '0.0.0.0', '1552352451', null, '', null, '成功', '访问字典管理', '用户访问日志', '31fc26af659a6f1aba9329fc62367009');
INSERT INTO `oplog` VALUES ('TD25A819D89074A6F9EEEA262', '安全管理员(secadmin)', '0.0.0.0', '1552352522', null, '', null, '成功', '访问字典类型管理页面', '用户访问日志', '881a7e460c0bef0558a6cbbec94156fd');
INSERT INTO `oplog` VALUES ('TBC762CB5D4814AE79A455454', '系统管理员(sysadmin)', '0.0.0.0', '1552352533', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD96AF8670AF342A0A577881A', '安全管理员(secadmin)', '0.0.0.0', '1552352548', null, '', null, '成功', '账号(secadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE729134A951742D4B6E8C7B7', '安全管理员(secadmin)', '0.0.0.0', '1552352548', null, '', null, '成功', '访问字典类型管理页面', '用户访问日志', '94ae92be26bb9d7df2c4776d62c57b6b');
INSERT INTO `oplog` VALUES ('T448B1E41CF0546CF93A08244', '安全管理员(secadmin)', '0.0.0.0', '1552352565', null, '', null, '成功', '访问模块授权管理', '用户访问日志', 'dcfb700280e202cf5c131730ff3a17c7');
INSERT INTO `oplog` VALUES ('TC69E0B9204D8458BAA98068F', '安全管理员(secadmin)', '0.0.0.0', '1552352581', null, 'roleauth', null, '成功', '删除角色()的投票统计模块权限', '三员操作日志', '5ebb7c54fd1364e4b69ef8ef507e90c7');
INSERT INTO `oplog` VALUES ('TF5D30188C98742099EC979B0', '安全管理员(secadmin)', '0.0.0.0', '1552352581', null, 'roleauth', null, '成功', '给角色(系统管理员)赋予投票统计的模块权限', '三员操作日志', 'a27505b09238ed5cda0f3fcf8c9e4d64');
INSERT INTO `oplog` VALUES ('T259BCBE5D4034ED092BA9E45', '安全管理员(secadmin)', '0.0.0.0', '1552352589', null, 'roleauth', null, '成功', '删除角色()的投票设置模块权限', '三员操作日志', 'ce6445dc8bc7831a95eae76f1627b6b6');
INSERT INTO `oplog` VALUES ('T9D8356F2C8094EDAA1C1B42F', '安全管理员(secadmin)', '0.0.0.0', '1552352589', null, 'roleauth', null, '成功', '给角色(系统管理员)赋予投票设置的模块权限', '三员操作日志', '62d24f2da04f7cf0cd9f1a7e7963fc7b');
INSERT INTO `oplog` VALUES ('T6340B43E2A2B4D228EB9B3FC', '安全管理员(secadmin)', '0.0.0.0', '1552352591', null, '', null, '成功', '访问模块授权管理', '用户访问日志', 'fdfebd266cb36203c09cee1816504f1c');
INSERT INTO `oplog` VALUES ('T522039D199674C81988DB8B5', '安全管理员(secadmin)', '0.0.0.0', '1552352598', null, '', null, '成功', '访问用户授权管理', '用户访问日志', '930bda217f9467296f31932991fce8e3');
INSERT INTO `oplog` VALUES ('TFF85E57EBCAB4962A9667F5D', '安全管理员(secadmin)', '0.0.0.0', '1552352600', null, '', null, '成功', '访问安全管理', '用户访问日志', '33010428dc6411f25f23494e7e8535e6');
INSERT INTO `oplog` VALUES ('TB94D526D9C004C6E88DF39B6', '专家1(1)', '0.0.0.0', '1552352627', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB35F6C19154C423F9B2BA2A6', '专家1(1)', '0.0.0.0', '1552352627', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e6de7aa050c93f89a397a1d161e535d5');
INSERT INTO `oplog` VALUES ('T713E3606AC8844A1AED9A04B', '系统管理员(sysadmin)', '0.0.0.0', '1552352634', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T1071CDF6673B427792F71A20', '系统管理员(sysadmin)', '0.0.0.0', '1552352641', null, '', null, '成功', '访问明细查询', '用户访问日志', '7e8eca8316f1b4b1449b0753fe03ef63');
INSERT INTO `oplog` VALUES ('T70384F2C07A1494F996DB4C8', '系统管理员(sysadmin)', '0.0.0.0', '1552352642', null, '', null, '成功', '访问评分统计', '用户访问日志', 'f6f7d3d2b817dee79227750baa7dc814');
INSERT INTO `oplog` VALUES ('T971F479AC7F74B99B4EF6B36', '系统管理员(sysadmin)', '0.0.0.0', '1552352644', null, '', null, '成功', '访问投票统计', '用户访问日志', '2b1d06804d5f5d9e4900dde839586d0d');
INSERT INTO `oplog` VALUES ('T5309D5388FC348C7A9335B36', '系统管理员(sysadmin)', '0.0.0.0', '1552352645', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b083fa9d2643c2dd5846d7a2a8a0e7a2');
INSERT INTO `oplog` VALUES ('TFE31BC21FD4E4108935519E6', '系统管理员(sysadmin)', '0.0.0.0', '1552352647', null, '', null, '成功', '访问明细查询', '用户访问日志', '9bee3a6f09c7f65935a390438a367d98');
INSERT INTO `oplog` VALUES ('TAF27E4A1E40C4039A578BCB8', '系统管理员(sysadmin)', '0.0.0.0', '1552352648', null, '', null, '成功', '访问用户管理', '用户访问日志', 'c54a034e29413649f72a8a048e62b0b9');
INSERT INTO `oplog` VALUES ('TAFB3076541D24E70A79F764A', '系统管理员(sysadmin)', '0.0.0.0', '1552352649', null, '', null, '成功', '访问明细查询', '用户访问日志', '684ac0292a33348cd8010b9d642b943e');
INSERT INTO `oplog` VALUES ('T9053DE517B494050BE5C151C', '系统管理员(sysadmin)', '0.0.0.0', '1552352650', null, '', null, '成功', '访问评分统计', '用户访问日志', '8d8d03ca9f2601f7f21b97079ad40a6a');
INSERT INTO `oplog` VALUES ('T876560A45288475294B40AC1', '系统管理员(sysadmin)', '0.0.0.0', '1552352650', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd5481b3514cd2a6af6b96d8cd1895986');
INSERT INTO `oplog` VALUES ('T823A505105204060A4F9E32B', '系统管理员(sysadmin)', '0.0.0.0', '1552352651', null, '', null, '成功', '访问数据交互', '用户访问日志', 'fe86899c57dde2b010742ff5b9280a8d');
INSERT INTO `oplog` VALUES ('TC0A0EFCC7A97456A8744065E', '系统管理员(sysadmin)', '0.0.0.0', '1552352652', null, '', null, '成功', '访问明细查询', '用户访问日志', 'ae8b5b0526683654c1c7b8b0c87e3ec7');
INSERT INTO `oplog` VALUES ('T47E8A3EF43BC41E798504CA6', '系统管理员(sysadmin)', '0.0.0.0', '1552352667', null, '', null, '成功', '访问用户管理', '用户访问日志', 'e082a9d8859a6fa803d58df1252fbe18');
INSERT INTO `oplog` VALUES ('T1F61FABC35C14CCE89074242', '系统管理员(sysadmin)', '0.0.0.0', '1552352669', null, '', null, '成功', '访问用户管理', '用户访问日志', '7fd0dd09515b3f30d4905b7d0d865ba7');
INSERT INTO `oplog` VALUES ('T8ED9CF6B94A5415288D6D655', '专家1(1)', '0.0.0.0', '1552352761', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T15CC661E385F4023BF428C16', '专家1(1)', '0.0.0.0', '1552352762', null, '', null, '成功', '访问项目评审', '用户访问日志', '756546c80478443342b360f4424f36af');
INSERT INTO `oplog` VALUES ('TA844AE9F272844FBA108BE65', '专家1(1)', '0.0.0.0', '1552352773', null, '', null, '成功', '访问项目评审', '用户访问日志', 'aa3c589bfe9295d71d1c8eb4ce7d3eea');
INSERT INTO `oplog` VALUES ('T05DEBEE700634867BAA69D8A', '专家1(1)', '0.0.0.0', '1552353029', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fca7b1ce83e8aec2119d3998ddef6a4e');
INSERT INTO `oplog` VALUES ('T6A7754E047C041B0B2239964', '专家1(1)', '0.0.0.0', '1552353078', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f1f1180b83ea0bc917b28314bbe92a09');
INSERT INTO `oplog` VALUES ('T67687B52E6AA4E9FA93E48E1', '专家1(1)', '0.0.0.0', '1552353085', null, '', null, '成功', '访问项目评审', '用户访问日志', '4e7fad801af28479414ed8c132827e08');
INSERT INTO `oplog` VALUES ('T29360A7D2A294CC4A5DA4482', '专家1(1)', '0.0.0.0', '1552353088', null, '', null, '成功', '访问项目评审', '用户访问日志', '2c943a6ed5aa04d0d74f8e57775d049a');
INSERT INTO `oplog` VALUES ('T070CB237138340999BB917E2', '专家2(2)', '0.0.0.0', '1552353116', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T3C49E7669A034672800F8DB1', '专家2(2)', '0.0.0.0', '1552353116', null, '', null, '成功', '访问项目评审', '用户访问日志', '35a23c0ac9d07c7a7853b432e115f606');
INSERT INTO `oplog` VALUES ('T25F7A2C376DF4C3BA94AA24C', '专家2(2)', '0.0.0.0', '1552353165', null, '', null, '成功', '访问项目评审', '用户访问日志', '527c61fc4749e4d885a398c46af4b9fc');
INSERT INTO `oplog` VALUES ('T79BD9CB0B30D4B2F81EA7E96', '专家3(3)', '0.0.0.0', '1552353170', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCED1420456E74ABDA3D90EFF', '专家3(3)', '0.0.0.0', '1552353170', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ff95cca24d2db2f4e73294a2be91b4db');
INSERT INTO `oplog` VALUES ('T2F6F8A5A12D84DAC827D9996', '系统管理员(sysadmin)', '0.0.0.0', '1552367161', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAA5347DFA50A456A887EC72A', '系统管理员(sysadmin)', '0.0.0.0', '1552367165', null, '', null, '成功', '访问用户管理', '用户访问日志', '7e5504564cf88a46f9f19f2af46760f2');
INSERT INTO `oplog` VALUES ('TBBF9195BAB2F4D2F83242089', '系统管理员(sysadmin)', '0.0.0.0', '1552367168', null, '', null, '成功', '访问明细查询', '用户访问日志', '237e2fd8cb92f9031689a67e44e1103a');
INSERT INTO `oplog` VALUES ('T475A07C9359D496BADE9A264', '系统管理员(sysadmin)', '0.0.0.0', '1552367221', null, '', null, '成功', '访问评分统计', '用户访问日志', '1428d2687bbb3a022e26818213ccac33');
INSERT INTO `oplog` VALUES ('T0C86FD9380D9497392D9E38A', '系统管理员(sysadmin)', '0.0.0.0', '1552367621', null, '', null, '成功', '访问明细查询', '用户访问日志', '6692a94f922f78b15646719d5ae68bb0');
INSERT INTO `oplog` VALUES ('T4ED70E0B8F704EC3A7C26D4C', '系统管理员(sysadmin)', '0.0.0.0', '1552367628', null, '', null, '成功', '访问评分统计', '用户访问日志', '038f50b2514f035b288923e6e01e2bce');
INSERT INTO `oplog` VALUES ('T69C1D5AE40EE4100BF781FCF', '系统管理员(sysadmin)', '0.0.0.0', '1552367633', null, '', null, '成功', '访问明细查询', '用户访问日志', 'fefec7d864816762ed1322b76d358651');
INSERT INTO `oplog` VALUES ('T20A6C47440CD4B66A6DCEAE7', '系统管理员(sysadmin)', '0.0.0.0', '1552367672', null, '', null, '成功', '访问评分统计', '用户访问日志', 'e16607b5d08709fce1cc820f35995de2');
INSERT INTO `oplog` VALUES ('T4AA98CAFD44E411FB45CFAD5', '系统管理员(sysadmin)', '0.0.0.0', '1552367705', null, '', null, '成功', '访问投票统计', '用户访问日志', '853250f03ecd39b3fc27e2e19ed27aa6');
INSERT INTO `oplog` VALUES ('TFA79B0377FAF480B8DE81A05', '系统管理员(sysadmin)', '0.0.0.0', '1552367711', null, '', null, '成功', '访问数据交互', '用户访问日志', '4abcd2f43b4bca2604f77a6c34f11dbb');
INSERT INTO `oplog` VALUES ('TD1A338A8E1F74F5B911A87D9', '系统管理员(sysadmin)', '0.0.0.0', '1552367713', null, '', null, '成功', '访问用户管理', '用户访问日志', '031791b5bb05ee97a7fbde2533aeb13a');
INSERT INTO `oplog` VALUES ('T6665876973684CE5B34788E0', '系统管理员(sysadmin)', '0.0.0.0', '1552367714', null, '', null, '成功', '访问明细查询', '用户访问日志', '20ec360a479736cc373a85dd283a13b8');
INSERT INTO `oplog` VALUES ('TEAD7B139A4954FE29709C69C', '系统管理员(sysadmin)', '0.0.0.0', '1552373632', null, '', null, '成功', '访问明细查询', '用户访问日志', '9f3cb2adc9cbfee45a5a87ac8aa5cc29');
INSERT INTO `oplog` VALUES ('TF618EE9895D94BEBBB1E90EA', '系统管理员(sysadmin)', '0.0.0.0', '1552373634', null, '', null, '成功', '访问评分统计', '用户访问日志', '0ad830c2d86d0924436b9f5dbbe5d3ce');
INSERT INTO `oplog` VALUES ('T1B295534AF4F4435B0389FFC', '系统管理员(sysadmin)', '0.0.0.0', '1552373636', null, '', null, '成功', '访问投票统计', '用户访问日志', '0475b177b19d4e407a3971cf95dc037f');
INSERT INTO `oplog` VALUES ('T1022B39EAAB5479486A88F2F', '系统管理员(sysadmin)', '0.0.0.0', '1552373637', null, '', null, '成功', '访问数据交互', '用户访问日志', '4c1544bf56f68109da90f165bb7b6600');
INSERT INTO `oplog` VALUES ('TE8623B7F35004F98894DCC7A', '系统管理员(sysadmin)', '0.0.0.0', '1552373664', null, '', null, '成功', '访问用户管理', '用户访问日志', 'e0586d30daf8d34b5b2e0b762bed2e51');
INSERT INTO `oplog` VALUES ('T3E79BB2CF1AC4D2A878B48F9', '系统管理员(sysadmin)', '0.0.0.0', '1552373679', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b6102234d8ac2b5e13974fcf53a49773');
INSERT INTO `oplog` VALUES ('T9CA7C6292F2D4E879CC4260D', '系统管理员(sysadmin)', '0.0.0.0', '1552373680', null, '', null, '成功', '访问评分统计', '用户访问日志', '055eae845de45d60ac140c8e5c8d26f6');
INSERT INTO `oplog` VALUES ('TC750118DCCEA4D299284D2D9', '系统管理员(sysadmin)', '0.0.0.0', '1552373682', null, '', null, '成功', '访问投票统计', '用户访问日志', '8ca04518396a1d2d229f93dda2edb25c');
INSERT INTO `oplog` VALUES ('TC201278C0D69420682DEC4D1', '专家4(4)', '0.0.0.0', '1552373688', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCF76D06BA43E46E591D7CE59', '专家4(4)', '0.0.0.0', '1552373689', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a3209e03de58411aa817ac6925e586f1');
INSERT INTO `oplog` VALUES ('T58BB12200D9B41ACBB0847FE', '专家4(4)', '0.0.0.0', '1552373692', null, '', null, '成功', '访问项目评审', '用户访问日志', 'bca64ce399ac767beb934e49facbe780');
INSERT INTO `oplog` VALUES ('TD5BFC7F84EA64002B62F19D6', '专家4(4)', '0.0.0.0', '1552373695', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd9618aef975aa7a02dbe3b613fefb848');
INSERT INTO `oplog` VALUES ('TFCBF748C5AF14278A61439CC', '专家4(4)', '0.0.0.0', '1552373724', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ddb09d7d1c0c8611f020b5f6c6d10c0d');
INSERT INTO `oplog` VALUES ('TDDEE80BBF6E94E5889BF261E', '系统管理员(sysadmin)', '0.0.0.0', '1552375366', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA1D70841CFA641E89C6D65B7', '系统管理员(sysadmin)', '0.0.0.0', '1552375723', null, '', null, '成功', '访问用户管理', '用户访问日志', '6344478b9411dfb10aef8f20245ce2b1');
INSERT INTO `oplog` VALUES ('TD1FD33CF1FAC4BF396E133B4', '系统管理员(sysadmin)', '0.0.0.0', '1552375785', null, '', null, '成功', '访问用户管理', '用户访问日志', 'b48fe2554844bba13a30491ed229a2f3');
INSERT INTO `oplog` VALUES ('T0AFA331A86784ACBBF8C9818', '专家4(4)', '0.0.0.0', '1552375797', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T1B581A552B7545AE8ABF1D50', '专家4(4)', '0.0.0.0', '1552375797', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd2040a1e1400c8f9820cea1ce5fa5222');
INSERT INTO `oplog` VALUES ('T5E624897928F48ECAD8F0121', '专家4(4)', '0.0.0.0', '1552375815', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a07c8b7904cc6ce373f52c6d7e81752b');
INSERT INTO `oplog` VALUES ('TE8429BED0755431CA4208C63', '专家4(4)', '0.0.0.0', '1552375861', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f366270fc12ce3d44be9a62964fb80d3');
INSERT INTO `oplog` VALUES ('T38F2396717644DC7AD344076', '系统管理员(sysadmin)', '0.0.0.0', '1552375951', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA788825CCB1F4CFEA38B143A', '系统管理员(sysadmin)', '0.0.0.0', '1552376014', null, '', null, '成功', '访问评分统计', '用户访问日志', 'cefe5fd28bce522e7e71014ed1cc0f0b');
INSERT INTO `oplog` VALUES ('T1237E6BBFAD94C85B7B048ED', '系统管理员(sysadmin)', '0.0.0.0', '1552376306', null, '', null, '成功', '访问明细查询', '用户访问日志', '565753a75dcb7bd20a61564bef66b8f3');
INSERT INTO `oplog` VALUES ('TE246018212FB4C9FAC9B269B', '系统管理员(sysadmin)', '0.0.0.0', '1552376307', null, '', null, '成功', '访问评分统计', '用户访问日志', '65a01db71611dfd6c2cdf61b06eda314');
INSERT INTO `oplog` VALUES ('TE181617DD5354431AB18886A', '系统管理员(sysadmin)', '0.0.0.0', '1552376308', null, '', null, '成功', '访问投票统计', '用户访问日志', '1967edc5d898754f3773213ff2d677fd');
INSERT INTO `oplog` VALUES ('T7FF3C4C3C4E54E2B9A127C33', '系统管理员(sysadmin)', '0.0.0.0', '1552376309', null, '', null, '成功', '访问评分统计', '用户访问日志', '31cf0dd95aeffd12cc70bd2836ca1d33');
INSERT INTO `oplog` VALUES ('T709B4DF9BE8C4B0FB77E08CF', '系统管理员(sysadmin)', '0.0.0.0', '1552376310', null, '', null, '成功', '访问明细查询', '用户访问日志', '92fc6fecd71f3e13837461c407975cb7');
INSERT INTO `oplog` VALUES ('T3B6E74904F3A44B48E9278AD', '系统管理员(sysadmin)', '0.0.0.0', '1552376310', null, '', null, '成功', '访问评分统计', '用户访问日志', '48bb8baf13b030b1858f4baa2c8d74df');
INSERT INTO `oplog` VALUES ('T186D6E634FC940D6B781FF9A', '专家4(4)', '0.0.0.0', '1552376342', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD73B53BDF52E4C2EADD12CC6', '专家4(4)', '0.0.0.0', '1552376343', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b70a11d3d0bd3b46ea98e6e084045606');
INSERT INTO `oplog` VALUES ('T9175DED11B6B4D51A854A99A', '系统管理员(sysadmin)', '0.0.0.0', '1552376399', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T1038701168424976AB314B30', '系统管理员(sysadmin)', '0.0.0.0', '1552376400', null, '', null, '成功', '访问明细查询', '用户访问日志', '71aeea95e417fb29b95ac3f51f33bea4');
INSERT INTO `oplog` VALUES ('T423DBA494CED4F959CCD3D7D', '专家4(4)', '0.0.0.0', '1552376472', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T60A67CBC558643708B846CC9', '专家4(4)', '0.0.0.0', '1552376473', null, '', null, '成功', '访问项目评审', '用户访问日志', '6170c5e4d8f9632de4de3a808365afba');
INSERT INTO `oplog` VALUES ('T6236F2D0282F497E87A2AFEA', '专家4(4)', '0.0.0.0', '1552376475', null, '', null, '成功', '访问项目评审', '用户访问日志', '7f9b9dde307a53240e204465fa55fa02');
INSERT INTO `oplog` VALUES ('T022836D8E07D4FC69CDB5426', '专家4(4)', '0.0.0.0', '1552376568', null, '', null, '成功', '访问项目评审', '用户访问日志', '3a109939a8168a66dd24aac274bf8e76');
INSERT INTO `oplog` VALUES ('T7F5305236C3747BD9386B572', '专家4(4)', '0.0.0.0', '1552376660', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b275eb07fced72d03fbcdaeac968099d');
INSERT INTO `oplog` VALUES ('TD9C27A4972B04590B968F2E4', '专家4(4)', '0.0.0.0', '1552376691', null, '', null, '成功', '访问项目评审', '用户访问日志', 'cfa8dadd871dc5c1477fb7ec9daa0009');
INSERT INTO `oplog` VALUES ('T64A3AD06AF63424A96198709', '专家4(4)', '0.0.0.0', '1552376692', null, '', null, '成功', '访问项目评审', '用户访问日志', '8d7f1a6cba0046c5550abcd4a9ba6651');
INSERT INTO `oplog` VALUES ('T493C9AC4BEE1417199C35F2B', '系统管理员(sysadmin)', '0.0.0.0', '1552376755', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T55B2EE0FE73A45DEA2DA8635', '系统管理员(sysadmin)', '0.0.0.0', '1552376762', null, '', null, '成功', '访问投票统计', '用户访问日志', 'dfb1a37c4273167dce9e858c76a6760f');
INSERT INTO `oplog` VALUES ('T936F5BF12F9A48C19B466C6A', '专家4(4)', '0.0.0.0', '1552376922', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T10F4F8E76E334721A28DD5F4', '专家4(4)', '0.0.0.0', '1552376922', null, '', null, '成功', '访问项目评审', '用户访问日志', '9ae0801d36592879642ec7747d824abf');
INSERT INTO `oplog` VALUES ('T47D837050413486EB93CACFF', '专家4(4)', '0.0.0.0', '1552376923', null, '', null, '成功', '访问项目评审', '用户访问日志', '4e4c1d4f5b7581e4da2dd4104e4637c6');
INSERT INTO `oplog` VALUES ('TE4480E0405B74F6A9EE22E44', '专家4(4)', '0.0.0.0', '1552376924', null, '', null, '成功', '访问项目评审', '用户访问日志', '85c141baa51943e4bd70741074d40ec0');
INSERT INTO `oplog` VALUES ('T7FD4318E263C4AEE9DE51076', '专家4(4)', '0.0.0.0', '1552377096', null, '', null, '成功', '访问项目评审', '用户访问日志', '76f065f98f9a026418a434385f919599');
INSERT INTO `oplog` VALUES ('TE75640EFE29F4596914B06C4', '系统管理员(sysadmin)', '0.0.0.0', '1552377140', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T2065C3B682D24D1A8B7DA51E', '系统管理员(sysadmin)', '0.0.0.0', '1552377193', null, '', null, '成功', '访问投票统计', '用户访问日志', '68c91cdc84ad9909345a602aa54ffc5c');
INSERT INTO `oplog` VALUES ('T3A23E51FD34E4E61A96150E6', '专家4(4)', '0.0.0.0', '1552377259', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T483DC2F9BD374D1D82658B03', '专家4(4)', '0.0.0.0', '1552377260', null, '', null, '成功', '访问项目评审', '用户访问日志', '332450548e5d370e78df33d935bbb144');
INSERT INTO `oplog` VALUES ('T22D5A4DD94CC44D98DB89D6E', '系统管理员(sysadmin)', '0.0.0.0', '1552377282', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T852CE7B817B64592B0F813E4', '系统管理员(sysadmin)', '0.0.0.0', '1552377381', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T9CCA44B037F3440EA73BD4D9', '系统管理员(sysadmin)', '0.0.0.0', '1552377566', null, '', null, '成功', '访问评分统计', '用户访问日志', 'eb1ac83293b1b23155f1059ec9bcc9d6');
INSERT INTO `oplog` VALUES ('TC50158B5D5C94AA5A8BDFB93', '专家4(4)', '0.0.0.0', '1552377629', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T58E0C6C18A9A48CDA38CDE77', '专家4(4)', '0.0.0.0', '1552377629', null, '', null, '成功', '访问项目评审', '用户访问日志', '581068756db0f219571b7bb905ecb21c');
INSERT INTO `oplog` VALUES ('T69F91904A4CF49A8B200953D', '系统管理员(sysadmin)', '0.0.0.0', '1552525928', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAD680C96859842BEA5003B91', '系统管理员(sysadmin)', '0.0.0.0', '1552525937', null, '', null, '成功', '访问用户管理', '用户访问日志', '0d4b1f05cec13f0ca52b8c72e89da0b8');
INSERT INTO `oplog` VALUES ('TBCD6D6D65C7846008BDF2824', '系统管理员(sysadmin)', '0.0.0.0', '1552526136', null, '', null, '成功', '访问明细查询', '用户访问日志', '584b13524ac2f5d34794c76142e12713');
INSERT INTO `oplog` VALUES ('T44103C1C2EFF49D2B9B3E8F1', '系统管理员(sysadmin)', '0.0.0.0', '1552526140', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd1b330c34899823cc5f8397ee606ddb6');
INSERT INTO `oplog` VALUES ('TFCFB38DF8B8D4142A051F64A', '系统管理员(sysadmin)', '0.0.0.0', '1552526145', null, '', null, '成功', '访问评分统计', '用户访问日志', '3517074b7c5c09ae5104f5205cefce5a');
INSERT INTO `oplog` VALUES ('T4D5C103C7B75478AB8128BC2', '系统管理员(sysadmin)', '0.0.0.0', '1552526157', null, '', null, '成功', '访问明细查询', '用户访问日志', '8be358084431f4142b1b54dbd3a2f9a7');
INSERT INTO `oplog` VALUES ('T1E4A09DC8D5F413B96C14247', '专家4(4)', '0.0.0.0', '1552526231', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T81617258011748E7B40BC03C', '专家4(4)', '0.0.0.0', '1552526231', null, '', null, '成功', '访问项目评审', '用户访问日志', '61b1fc2b0f59380dacc5fd380d1146ef');
INSERT INTO `oplog` VALUES ('T91477EF4DCBB478085874311', '专家4(4)', '0.0.0.0', '1552526305', null, '', null, '成功', '访问项目评审', '用户访问日志', 'db3bb82480c977fc1f869346eeb83244');
INSERT INTO `oplog` VALUES ('TAA4B0C1EA5D0476E85F998DA', '专家4(4)', '0.0.0.0', '1552526306', null, '', null, '成功', '访问项目评审', '用户访问日志', '7075f57088549cb48034975f16a1b913');
INSERT INTO `oplog` VALUES ('T863CD67FBF5D417B8EA4C737', '专家4(4)', '0.0.0.0', '1552526306', null, '', null, '成功', '访问项目评审', '用户访问日志', '7c30dbf8c700b0e402d431a53b0679ae');
INSERT INTO `oplog` VALUES ('T713A56E1C0074F70BBA412EC', '专家4(4)', '0.0.0.0', '1552526307', null, '', null, '成功', '访问项目评审', '用户访问日志', '65155d026644493866fe346c308309c6');
INSERT INTO `oplog` VALUES ('T9894FC0F3B6C485BA3CF3901', '专家4(4)', '0.0.0.0', '1552526317', null, '', null, '成功', '访问项目评审', '用户访问日志', '8b1871609d238f5aeba0ea0f5b852640');
INSERT INTO `oplog` VALUES ('T9E8F91228BAF4146917B85A3', '专家4(4)', '0.0.0.0', '1552526317', null, '', null, '成功', '访问项目评审', '用户访问日志', '829dfd474ef0cb0470436a55e70151bc');
INSERT INTO `oplog` VALUES ('T2A2B4EBD1F2D4AFA8FAA7D92', '专家4(4)', '0.0.0.0', '1552526318', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd269b669f41dcf209ce71d7a5604d42e');
INSERT INTO `oplog` VALUES ('T82723FD237774E3DBFBC007D', '专家4(4)', '0.0.0.0', '1552526374', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e78d0d09021b7a6f5b19fb8c6efec5d7');
INSERT INTO `oplog` VALUES ('T15C61CE3FAEB45EDB4C5989C', '系统管理员(sysadmin)', '0.0.0.0', '1552527412', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD97803153F8B44C5AA72F2AE', '系统管理员(sysadmin)', '0.0.0.0', '1552527417', null, '', null, '成功', '访问用户管理', '用户访问日志', '275ec2ce39866f5c19eea72df515007f');
INSERT INTO `oplog` VALUES ('T3E544BE64EB64BF189D367CA', '系统管理员(sysadmin)', '0.0.0.0', '1552527421', null, '', null, '成功', '访问明细查询', '用户访问日志', '2dbcc46746475027317a091d3777e581');
INSERT INTO `oplog` VALUES ('TB12D86DD6E344C8FBBFCC20B', '系统管理员(sysadmin)', '0.0.0.0', '1552527422', null, '', null, '成功', '访问评分统计', '用户访问日志', '551bc929f1392017b796804e963f5394');
INSERT INTO `oplog` VALUES ('T6CF24BCB3FEE4A7C83183C2C', '系统管理员(sysadmin)', '0.0.0.0', '1552527423', null, '', null, '成功', '访问投票统计', '用户访问日志', 'eb981bb9eac319489cd6731b5f429ae7');
INSERT INTO `oplog` VALUES ('TD193AB3BFD6641398100A4BC', '系统管理员(sysadmin)', '0.0.0.0', '1552527424', null, '', null, '成功', '访问数据交互', '用户访问日志', '6e26753a0ae0d71e7c2da8a62c1049fc');
INSERT INTO `oplog` VALUES ('TF971F884F6984C86B94F4708', '系统管理员(sysadmin)', '0.0.0.0', '1552527425', null, '', null, '成功', '访问投票统计', '用户访问日志', 'ee73940b3cff7c1db588beafb0f0e854');
INSERT INTO `oplog` VALUES ('T2A1352CB0C9142A7A5030BC2', '系统管理员(sysadmin)', '0.0.0.0', '1552527427', null, '', null, '成功', '访问评分统计', '用户访问日志', '739c5b7c240a6314990c2718d259f87a');
INSERT INTO `oplog` VALUES ('T70730B2DDED147CABDCC0A5F', '专家4(4)', '0.0.0.0', '1552527435', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T0B77ABF81F5F42D2BCDA6B6F', '专家4(4)', '0.0.0.0', '1552527435', null, '', null, '成功', '访问项目评审', '用户访问日志', '475c180933fcd8bf0bd18c51e919ebed');
INSERT INTO `oplog` VALUES ('TBE2306BDF21F4F9CA87A358E', '专家4(4)', '0.0.0.0', '1552527440', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ab72080423ef0f398ffee6f37923253e');
INSERT INTO `oplog` VALUES ('TA9657878B38041B99AF29241', '系统管理员(sysadmin)', '0.0.0.0', '1552527452', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T315412C70E5E4A3F87AC5463', '专家1(1)', '0.0.0.0', '1552527891', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T9EC0777C1C5849EA894ABA8F', '专家1(1)', '0.0.0.0', '1552527892', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e0eb5296c91580bee169b26f4e975034');
INSERT INTO `oplog` VALUES ('T710CC0F1F6F7463EAE4784A2', '专家1(1)', '0.0.0.0', '1552528038', null, '', null, '成功', '访问项目评审', '用户访问日志', '090fb33deb3d6492b009a81634a055c2');
INSERT INTO `oplog` VALUES ('T764504034A8B4D2CAA85E12A', '专家4(4)', '0.0.0.0', '1552528061', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCB4B9600068C4986988EB4EB', '专家4(4)', '0.0.0.0', '1552528062', null, '', null, '成功', '访问项目评审', '用户访问日志', '86254b416b88612ea93ed2b17d70f1ff');
INSERT INTO `oplog` VALUES ('T1CFF2862703349A3AED4D8AD', '系统管理员(sysadmin)', '0.0.0.0', '1552528094', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD93FE1F1EABF4D84975D014A', '系统管理员(sysadmin)', '0.0.0.0', '1552528724', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T61BB7EC1E1334B5BAFFA5D59', '系统管理员(sysadmin)', '0.0.0.0', '1552530218', null, '', null, '成功', '访问明细查询', '用户访问日志', 'c9cd386ea220c215cc788fc2e9b633a5');
INSERT INTO `oplog` VALUES ('T7BAD5C8A6ADB4003903312E1', '系统管理员(sysadmin)', '0.0.0.0', '1552530221', null, '', null, '成功', '访问评分统计', '用户访问日志', '1c7e1a618d69e7cbd72a8ff7a3b3261e');
INSERT INTO `oplog` VALUES ('TCD46D1C24FCF4C899353261D', '系统管理员(sysadmin)', '0.0.0.0', '1552530225', null, '', null, '成功', '访问投票统计', '用户访问日志', 'f08f95239144f990b4919e5e6a598819');
INSERT INTO `oplog` VALUES ('T228EA6B94A74447CBE37320E', '系统管理员(sysadmin)', '0.0.0.0', '1552531308', null, '', null, '成功', '访问明细查询', '用户访问日志', 'a6f014636666d75bbeb38e8b7436e1e2');
INSERT INTO `oplog` VALUES ('T991E2B8382EB4903BEA718C7', '系统管理员(sysadmin)', '0.0.0.0', '1552531324', null, '', null, '成功', '访问明细查询', '用户访问日志', '20cad68901131bbd1ccedaf7063da87e');
INSERT INTO `oplog` VALUES ('T75A48E8AFE794BF5977A4834', '系统管理员(sysadmin)', '0.0.0.0', '1552531379', null, '', null, '成功', '访问明细查询', '用户访问日志', '35890a1bfe5759bc870181e450065d99');
INSERT INTO `oplog` VALUES ('T5B01E5E142BB477CBD7102E8', '系统管理员(sysadmin)', '0.0.0.0', '1552531454', null, '', null, '成功', '访问投票统计', '用户访问日志', '34f236603b1fdb9ace88059ef30e8091');
INSERT INTO `oplog` VALUES ('T058B3E79B1D440EFB5789E8D', '系统管理员(sysadmin)', '0.0.0.0', '1552531461', null, '', null, '成功', '访问投票统计', '用户访问日志', 'bd8a23a06670ffd4a6213a5e1c88c736');
INSERT INTO `oplog` VALUES ('TBF149A382BCF4D85BEC39DE2', '系统管理员(sysadmin)', '0.0.0.0', '1552531593', null, '', null, '成功', '访问投票统计', '用户访问日志', 'a4f0e6d7bdd59d7ec5ee0fd8a47383aa');
INSERT INTO `oplog` VALUES ('TD055C33495FD4F1E9C7E502A', '系统管理员(sysadmin)', '0.0.0.0', '1552531659', null, '', null, '成功', '访问投票统计', '用户访问日志', '5f8bf9a335a0327a60fe46bf5396f708');
INSERT INTO `oplog` VALUES ('TCAE1F27FD017472A93BFE4D8', '系统管理员(sysadmin)', '0.0.0.0', '1552531746', null, '', null, '成功', '访问投票统计', '用户访问日志', '25914f5effa93c215db2385702dd3539');
INSERT INTO `oplog` VALUES ('T29CC2D101C3B4E67BE615B17', '系统管理员(sysadmin)', '0.0.0.0', '1552531748', null, '', null, '成功', '访问投票统计', '用户访问日志', '4a3ca6333c764918b3144309d5d12ecb');
INSERT INTO `oplog` VALUES ('TE55F949C25E14562A0206A5D', '系统管理员(sysadmin)', '0.0.0.0', '1552531749', null, '', null, '成功', '访问评分统计', '用户访问日志', '02096b1c9050ce6de486982774a76490');
INSERT INTO `oplog` VALUES ('T9D7B7BC03ECC485B8DA80338', '系统管理员(sysadmin)', '0.0.0.0', '1552531929', null, '', null, '成功', '访问评分统计', '用户访问日志', '6032e87be03d324656e5c3671111f2b8');
INSERT INTO `oplog` VALUES ('T751D8AD994D84A5C8B1EDA9B', '系统管理员(sysadmin)', '0.0.0.0', '1552531935', null, '', null, '成功', '访问评分统计', '用户访问日志', '0b1aa2e98e5dee5ae8ccd9476ba3bc25');
INSERT INTO `oplog` VALUES ('TE9E9E8ED80EA4C7699BCE748', '系统管理员(sysadmin)', '0.0.0.0', '1552532456', null, '', null, '成功', '访问用户管理', '用户访问日志', 'aea85772d7e469387605704ea876cbbe');
INSERT INTO `oplog` VALUES ('T7FA152B211464E39AB12A3E8', '专家4(4)', '0.0.0.0', '1552532465', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD9F1456D4FCF48A8B89DB73F', '专家4(4)', '0.0.0.0', '1552532465', null, '', null, '成功', '访问项目评审', '用户访问日志', '648a003a1dd1db1511fa34a0cd45b0f9');
INSERT INTO `oplog` VALUES ('T0AD03AE17BA44CF1A1B6E2FD', '专家4(4)', '0.0.0.0', '1552532502', null, '', null, '成功', '访问项目评审', '用户访问日志', 'de4f3d5ae71deb588041884333f2a721');
INSERT INTO `oplog` VALUES ('TB402AA3229F644F4900AEA2B', '专家4(4)', '0.0.0.0', '1552532503', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a1472c298c004afdf370dbc7805ff109');
INSERT INTO `oplog` VALUES ('TCD151C30BE5140A683DA159A', '专家4(4)', '0.0.0.0', '1552532526', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ed265f0adfc26c86e25de43df03d44ae');
INSERT INTO `oplog` VALUES ('TED2E7B045FC848BD8E3026E3', '专家5(5)', '0.0.0.0', '1552532535', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB573366DAA55440E93C66054', '专家5(5)', '0.0.0.0', '1552532536', null, '', null, '成功', '访问项目评审', '用户访问日志', '16f58d696a40073555947cd60b838492');
INSERT INTO `oplog` VALUES ('TA579B08E0F6C46C79D60F7FF', '专家5(5)', '0.0.0.0', '1552532545', null, '', null, '成功', '访问项目评审', '用户访问日志', '0464c3e72c258b277e68f9d090da6b38');
INSERT INTO `oplog` VALUES ('T7ED79BDE31B54E2BB66736FA', '专家5(5)', '0.0.0.0', '1552532560', null, '', null, '成功', '访问项目评审', '用户访问日志', '561dafd8d548472353864078239e8fec');
INSERT INTO `oplog` VALUES ('T46C2C4827D9442E488430D9B', '专家5(5)', '0.0.0.0', '1552532595', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd304dae2733a9503711a75e48e1a2be4');
INSERT INTO `oplog` VALUES ('T2D3671D1140A48F7AFC4AD0D', '专家5(5)', '0.0.0.0', '1552532600', null, '', null, '成功', '访问项目评审', '用户访问日志', '1d68b663beca036d4009a03371c20e54');
INSERT INTO `oplog` VALUES ('T0F7C97DB611F4EAAAEB44235', '系统管理员(sysadmin)', '0.0.0.0', '1552532678', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA5449E0B988149D8A478153F', '系统管理员(sysadmin)', '0.0.0.0', '1552532679', null, '', null, '成功', '访问投票统计', '用户访问日志', '945038469b230f7f1b4f14169b308483');
INSERT INTO `oplog` VALUES ('TB5727982A1D14619BBE0AA5D', '专家1(1)', '0.0.0.0', '1552532831', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TB4C083559F0A4DF9A0ACA6B7', '专家1(1)', '0.0.0.0', '1552532831', null, '', null, '成功', '访问项目评审', '用户访问日志', '2cf4b93e784ebf4af7c15ec7e800b26e');
INSERT INTO `oplog` VALUES ('TA257C2E9C027434B97BB6009', '专家1(1)', '0.0.0.0', '1552532832', null, '', null, '成功', '访问项目评审', '用户访问日志', '9da5f451ce84201bc664c0a02ec134f9');
INSERT INTO `oplog` VALUES ('TAE235EF1AA1541CB88D93D98', '专家1(1)', '0.0.0.0', '1552532833', null, '', null, '成功', '访问项目评审', '用户访问日志', '797e7e5d5c1b139af9e0083c3721fcec');
INSERT INTO `oplog` VALUES ('T7EF8A00D389747E6BD64AB07', '专家1(1)', '0.0.0.0', '1552532834', null, '', null, '成功', '访问项目评审', '用户访问日志', '801a6b13d13ec1d695cde84109e29808');
INSERT INTO `oplog` VALUES ('T91A8E6A00C9B463FBF5411BD', '专家1(1)', '0.0.0.0', '1552532834', null, '', null, '成功', '访问项目评审', '用户访问日志', '40cae8dd9a592bcb65b15eeb70f99f8f');
INSERT INTO `oplog` VALUES ('T863E156BF2B04B77AB0AC28D', '专家1(1)', '0.0.0.0', '1552532835', null, '', null, '成功', '访问项目评审', '用户访问日志', '9e037f841496372d14f21a1509f317c4');
INSERT INTO `oplog` VALUES ('T572C3657B0854CE4A7975912', '专家1(1)', '0.0.0.0', '1552532836', null, '', null, '成功', '访问项目评审', '用户访问日志', '76e7dcd810af4b0d57cb88035022bc69');
INSERT INTO `oplog` VALUES ('T0B3530D2C1884390B76A3D66', '()', '0.0.0.0', '1552533090', null, '', null, '失败', '账号(secadmin)登录,密码错误', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE87D9A8ADAA849488BB95E8E', '安全管理员(secadmin)', '0.0.0.0', '1552533095', null, '', null, '成功', '账号(secadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T9BEB654F588C4876833552DB', '安全管理员(secadmin)', '0.0.0.0', '1552533096', null, '', null, '成功', '访问字典类型管理页面', '用户访问日志', '5f517af0668524bb5e5c0b4f4e1a6a33');
INSERT INTO `oplog` VALUES ('T35399B44BDED4DE19F93BB10', '安全管理员(secadmin)', '0.0.0.0', '1552533100', null, '', null, '成功', '访问模块授权管理', '用户访问日志', '8cd8fff564a022628f0f012e5cbe284d');
INSERT INTO `oplog` VALUES ('T09F2BEBDAC354CA6B681D6EF', '专家1(1)', '0.0.0.0', '1552533147', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T3EB01F88DD2D4D11945C54D9', '专家1(1)', '0.0.0.0', '1552533148', null, '', null, '成功', '访问项目评审', '用户访问日志', '61d98dd4e8eb2deb84faae3cace9d435');
INSERT INTO `oplog` VALUES ('TEF75D7C4A19342F0A5FD9C0D', '安全管理员(secadmin)', '0.0.0.0', '1552533155', null, 'roleauth', null, '成功', '删除角色(专家)的地方项目打分模块权限', '三员操作日志', 'e8ebd42585aa93dedb97e76f547a580b');
INSERT INTO `oplog` VALUES ('T4FFFF0B4BB2F44C28E09E889', '安全管理员(secadmin)', '0.0.0.0', '1552533155', null, 'roleauth', null, '成功', '给角色()赋予地方项目打分的模块权限', '三员操作日志', '0e6eeb51b6d398c59ec69e03a1d77bea');
INSERT INTO `oplog` VALUES ('T28522325FAD54C1DBAEF08EC', '()', '0.0.0.0', '1552533194', null, '', null, '失败', '账号(1)登录,密码错误', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD4AC44A35CA2435CA99CE00C', '专家1(1)', '0.0.0.0', '1552533194', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T8AD3A89AF5F24895ABA9A75F', '专家1(1)', '0.0.0.0', '1552533195', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b2788e0720d2da5a0ae53c60e3f73cdb');
INSERT INTO `oplog` VALUES ('T718E37694F37483F90DBD87A', '专家1(1)', '0.0.0.0', '1552533199', null, '', null, '成功', '访问项目评审', '用户访问日志', '6e8cb84907c1b40e5eef1dede683d389');
INSERT INTO `oplog` VALUES ('TF804F6D7DBD84DF9A6059FFE', '专家1(1)', '0.0.0.0', '1552533206', null, '', null, '成功', '访问项目评审', '用户访问日志', 'aecc2480318aaa72827a4a10fe4ab994');
INSERT INTO `oplog` VALUES ('T6B43A3703A3C4B3799A8DF5C', '专家1(1)', '0.0.0.0', '1552533303', null, '', null, '成功', '访问项目评审', '用户访问日志', '8775e51b0b6acee211b26a20adde9d7a');
INSERT INTO `oplog` VALUES ('T9006C9EA66194057A38EF3AF', '专家1(1)', '0.0.0.0', '1552533444', null, '', null, '成功', '访问项目评审', '用户访问日志', '1907c759f3463e818be6732e9b4a38ea');
INSERT INTO `oplog` VALUES ('TCA8317D28BE74363A45B29F9', '专家1(1)', '0.0.0.0', '1552533458', null, '', null, '成功', '访问项目评审', '用户访问日志', '7be9b8d7d457ffbc9a3533b33d7e62a6');
INSERT INTO `oplog` VALUES ('T9BB6FD5C38F04CC78069C2CE', '专家1(1)', '0.0.0.0', '1552533479', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd943e3e26f7567bb75db7a6794ccc201');
INSERT INTO `oplog` VALUES ('T9234DFB4C2B9409390ECBB41', '系统管理员(sysadmin)', '0.0.0.0', '1552533588', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T594E964927D54F708DABF766', '专家1(1)', '0.0.0.0', '1552534245', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TBE9096DF483B486CB596B6E5', '专家1(1)', '0.0.0.0', '1552534245', null, '', null, '成功', '访问项目评审', '用户访问日志', '9a97a8d5bda226d3282587eac441449a');
INSERT INTO `oplog` VALUES ('T80D914F928734532BF63A100', '专家1(1)', '0.0.0.0', '1552541226', null, '', null, '成功', '访问项目评审', '用户访问日志', '6ade1393710ba76f3a5c34d1132ee6c6');
INSERT INTO `oplog` VALUES ('T7EA1C30D457046FC8070137B', '专家1(1)', '0.0.0.0', '1552541989', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f6fb70f44976c0f8bebba79697f4de90');
INSERT INTO `oplog` VALUES ('T34B25255F70649C7A3335952', '专家1(1)', '0.0.0.0', '1552542035', null, '', null, '成功', '访问项目评审', '用户访问日志', '31068af558f0f5b6426f4d94ffdb6a03');
INSERT INTO `oplog` VALUES ('T32F80586CCDB46C78911E8BF', '专家1(1)', '0.0.0.0', '1552542039', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f58e2a08a0277f52e3a6b5b297022977');
INSERT INTO `oplog` VALUES ('TEA2180485A684A3EA9597CAD', '专家1(1)', '0.0.0.0', '1552542053', null, '', null, '成功', '访问项目评审', '用户访问日志', '9fa0d8af88e1d63166d875d69e45d547');
INSERT INTO `oplog` VALUES ('T2CEC96766E12419D84FA8842', '专家1(1)', '0.0.0.0', '1552542060', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ee52de40aa689b0ec02d7fca13ee384a');
INSERT INTO `oplog` VALUES ('TA65F261E13D34F82818E2083', '专家1(1)', '0.0.0.0', '1552542562', null, '', null, '成功', '访问项目评审', '用户访问日志', '2775102ebc8d87c4a30022cb71a4f8ff');
INSERT INTO `oplog` VALUES ('TFEB99D6C6B8344CDB946A704', '专家1(1)', '0.0.0.0', '1552542617', null, '', null, '成功', '访问项目评审', '用户访问日志', '650149a9b04ff2f4a1ddde1a84605fb4');
INSERT INTO `oplog` VALUES ('TF0F191C1AC3B4BED89DBEFF6', '专家1(1)', '0.0.0.0', '1552543384', null, '', null, '成功', '访问项目评审', '用户访问日志', 'af06967ddc1801c64b0c4ad01cf29395');
INSERT INTO `oplog` VALUES ('TBF678380044E4846B1AE5057', '专家1(1)', '0.0.0.0', '1552543387', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b1e4ab387585f07f6e99788fca048a6d');
INSERT INTO `oplog` VALUES ('TD3C19543D6134B9DA75F057E', '专家1(1)', '0.0.0.0', '1552543391', null, '', null, '成功', '访问项目评审', '用户访问日志', '8f40efe9a14639c9d2ff6ef76e4c9fc6');
INSERT INTO `oplog` VALUES ('TE57A011A4E35479CBDF218D2', '专家1(1)', '0.0.0.0', '1552543461', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c653d2ec9773f5144aeb5f910061caa0');
INSERT INTO `oplog` VALUES ('TE54098EA0A48486CAAF095B9', '专家1(1)', '0.0.0.0', '1552543462', null, '', null, '成功', '访问项目评审', '用户访问日志', '78e3a2a17039eb434c0159bb8aecf877');
INSERT INTO `oplog` VALUES ('T1E6BB1E93BBB48F4BD68D568', '专家1(1)', '0.0.0.0', '1552543470', null, '', null, '成功', '访问项目评审', '用户访问日志', '9107ad5473ac79258ba760c328c7d274');
INSERT INTO `oplog` VALUES ('T63774C76A72D486197687062', '系统管理员(sysadmin)', '0.0.0.0', '1552543905', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T03FC4270E14944FCA0C98FD9', '专家1(1)', '0.0.0.0', '1552543955', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T76E5232C155E4572A67F91F0', '专家1(1)', '0.0.0.0', '1552543955', null, '', null, '成功', '访问项目评审', '用户访问日志', '666087a8fecba99eabae080d6aa18dcc');
INSERT INTO `oplog` VALUES ('T1209E852AA40418BB89A5BC7', '专家1(1)', '0.0.0.0', '1552543958', null, '', null, '成功', '访问项目评审', '用户访问日志', '75030ac7d81f1488673782d40bf8b298');
INSERT INTO `oplog` VALUES ('T3D5456A586D44EABB0340CC5', '专家1(1)', '0.0.0.0', '1552543962', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd00069a8094e693dc56dfffd3162192d');
INSERT INTO `oplog` VALUES ('T71461A985FB14EB9BDEF2A32', '专家1(1)', '0.0.0.0', '1552543972', null, '', null, '成功', '访问项目评审', '用户访问日志', '19604c6aac624ebd7fb4f3bdf2778396');
INSERT INTO `oplog` VALUES ('T93E3EB4E69284C47AE89CF8E', '专家1(1)', '0.0.0.0', '1552544001', null, '', null, '成功', '访问项目评审', '用户访问日志', '395dc4c59abab03e37697261a343be89');
INSERT INTO `oplog` VALUES ('T945372CF588F4402B4336B7E', '专家1(1)', '0.0.0.0', '1552544014', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a1eb9590b0486c13e9cd440a17fb2808');
INSERT INTO `oplog` VALUES ('TFF661EB4BE104A958C13EE3B', '专家2(2)', '0.0.0.0', '1552544026', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCE6BF6E5653742F29F437190', '专家2(2)', '0.0.0.0', '1552544026', null, '', null, '成功', '访问项目评审', '用户访问日志', '4bd5ec299fd6102f458c1ca1430c1573');
INSERT INTO `oplog` VALUES ('T705C34E6C7654DF697591FC5', '专家2(2)', '0.0.0.0', '1552544029', null, '', null, '成功', '访问项目评审', '用户访问日志', '0483990a0a0c1dd9ef606b1d22e72bb6');
INSERT INTO `oplog` VALUES ('T753303DA4CD34713BA8AE237', '专家2(2)', '0.0.0.0', '1552544051', null, '', null, '成功', '访问项目评审', '用户访问日志', '84526fb16c3bc02d8a46fa4f58b11377');
INSERT INTO `oplog` VALUES ('T03D05AC7459541538F4586EB', '专家2(2)', '0.0.0.0', '1552544058', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c22bd6f93aef0ee5deea28060daaa86b');
INSERT INTO `oplog` VALUES ('T0FD96DCD67834FC482FCBDD3', '专家3(3)', '0.0.0.0', '1552544065', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T890DC0E5B9CF4680838AA54C', '专家3(3)', '0.0.0.0', '1552544065', null, '', null, '成功', '访问项目评审', '用户访问日志', '863762fde50b841f7047dc6e6f802463');
INSERT INTO `oplog` VALUES ('TDE980B4DE33F408083E3AC1A', '系统管理员(sysadmin)', '0.0.0.0', '1552544084', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAFA1B9BBBF724634A2ED0C8A', '专家3(3)', '0.0.0.0', '1552544135', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ad51e03a47ca7a02d73b8924fc71729e');
INSERT INTO `oplog` VALUES ('T3C34197397AB427D83EC94F4', '专家4(4)', '0.0.0.0', '1552544144', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T141D0B84F0604C03B8C1061F', '专家4(4)', '0.0.0.0', '1552544144', null, '', null, '成功', '访问项目评审', '用户访问日志', '6369d17403d1d5e3c12a16e74a8d3ef6');
INSERT INTO `oplog` VALUES ('TE5912A7F35C948EB8E9AE18F', '专家4(4)', '0.0.0.0', '1552544170', null, '', null, '成功', '访问项目评审', '用户访问日志', '84007c3dd7f58192a2a1cfbbc7d96794');
INSERT INTO `oplog` VALUES ('T2857D37560284ED48DF4C3D8', '专家5(5)', '0.0.0.0', '1552544186', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TFA45EB8560D2481AAAADFF00', '专家5(5)', '0.0.0.0', '1552544186', null, '', null, '成功', '访问项目评审', '用户访问日志', 'cc0d7a6f901be7b7245f9929636c99eb');
INSERT INTO `oplog` VALUES ('T02F62BD858084FE09638A5F5', '专家5(5)', '0.0.0.0', '1552544203', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c5ac226746c2eda8b3b5f669fccba90c');
INSERT INTO `oplog` VALUES ('T0798A7578A6D40189311391B', '专家5(5)', '0.0.0.0', '1552544206', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f23ec7a814b506c6c78bfffe69dcc386');
INSERT INTO `oplog` VALUES ('T13EA9D16CDB34EAF94E67804', '专家5(5)', '0.0.0.0', '1552544211', null, '', null, '成功', '访问项目评审', '用户访问日志', '648debcf91d628c2512ea684bb4fe228');
INSERT INTO `oplog` VALUES ('T810D6208DBF64084935132D7', '专家5(5)', '0.0.0.0', '1552544219', null, '', null, '成功', '访问评分统计', '用户访问日志', '1046af5b9b804bb4eeb2fdc2a5969e42');
INSERT INTO `oplog` VALUES ('TE1ABADF59247417E86978F28', '专家5(5)', '0.0.0.0', '1552544311', null, '', null, '成功', '访问项目评审', '用户访问日志', '17d864e89d739d2aa7ba8d56c878d7fe');
INSERT INTO `oplog` VALUES ('TCC4EDC9495404523A2952780', '专家4(4)', '0.0.0.0', '1552544323', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TEE3599C5B7A1460AA2F130A5', '专家4(4)', '0.0.0.0', '1552544323', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f1a2fcd63ac4f2b37c8391264d86143c');
INSERT INTO `oplog` VALUES ('T66DEC17C8E954AC4A2F358A1', '专家5(5)', '0.0.0.0', '1552544354', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC50BD0124F194231BCE77202', '专家5(5)', '0.0.0.0', '1552544354', null, '', null, '成功', '访问项目评审', '用户访问日志', '590094ee4e9774c2c341c7a688c2fd54');
INSERT INTO `oplog` VALUES ('T86062E99101F459F83649D6C', '专家3(3)', '0.0.0.0', '1552544365', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T5012BC00DEE94E9B89D92F2F', '专家3(3)', '0.0.0.0', '1552544365', null, '', null, '成功', '访问项目评审', '用户访问日志', '30b9be5b3ff720520285918308fc8f87');
INSERT INTO `oplog` VALUES ('T8A4082E2A66441708A58AE42', '专家2(2)', '0.0.0.0', '1552544405', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T4395CF0B281B4556B91C0BF2', '专家2(2)', '0.0.0.0', '1552544406', null, '', null, '成功', '访问项目评审', '用户访问日志', '62fbd5e083969ae285e0cbed53a52c95');
INSERT INTO `oplog` VALUES ('T076171F6E9E2458FA0F671A4', '专家1(1)', '0.0.0.0', '1552544418', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T16AF3F3338DF4D0AABFA22A4', '专家1(1)', '0.0.0.0', '1552544419', null, '', null, '成功', '访问项目评审', '用户访问日志', '9e170278aebf36f6c4b838c41ad29d82');
INSERT INTO `oplog` VALUES ('T394B04EF97EA4704954FACAD', '系统管理员(sysadmin)', '0.0.0.0', '1552544445', null, '', null, '成功', '访问投票统计', '用户访问日志', 'e42c2706184e9ef399793e9e11f2d9aa');
INSERT INTO `oplog` VALUES ('TE364F07253F44DDFBA567AC8', '专家1(1)', '0.0.0.0', '1552544480', null, '', null, '成功', '访问项目评审', '用户访问日志', '9e64b1b8711d74e85ee47237ca5e0af6');
INSERT INTO `oplog` VALUES ('TCA094C60D7FD46198314A3D5', '专家1(1)', '0.0.0.0', '1552544678', null, '', null, '成功', '访问项目评审', '用户访问日志', 'da7bf8bef117e4a391dcdf2789d86b38');
INSERT INTO `oplog` VALUES ('T8505C7D08CAE4B1A895CC4B0', '专家1(1)', '0.0.0.0', '1552544901', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e142057c78b9eaad586ead587ad09e53');
INSERT INTO `oplog` VALUES ('T56CC2C1F690642ED95CEFEA8', '专家1(1)', '0.0.0.0', '1552544942', null, '', null, '成功', '访问项目评审', '用户访问日志', '0ac2e2d00f984bffe8066df10951a0e5');
INSERT INTO `oplog` VALUES ('T08C2AA31796E46AE998B3A62', '专家1(1)', '0.0.0.0', '1552544958', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f69917b9861ebe6966f60dd4ad1bb02a');
INSERT INTO `oplog` VALUES ('T0F1FCB61D46E4AA0A3117402', '专家1(1)', '0.0.0.0', '1552544992', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a147884ec601a41cc9e8fad5c03b840f');
INSERT INTO `oplog` VALUES ('TD5A477EABBB44C3DB522AC2B', '专家1(1)', '0.0.0.0', '1552545028', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f4fb938cfad45fbba81ceb29d0f8a879');
INSERT INTO `oplog` VALUES ('TB0507DE58DDA4A7E9ABAD91E', '专家1(1)', '0.0.0.0', '1552545068', null, '', null, '成功', '访问项目评审', '用户访问日志', '8b4429763f726810c43850afd17ca0a8');
INSERT INTO `oplog` VALUES ('TD4698637A4F242D384B23E6F', '专家1(1)', '0.0.0.0', '1552545114', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b827c704f47ec2a177e0d04c6dfc8551');
INSERT INTO `oplog` VALUES ('TE27BE42CB6EB4C5398C33D37', '专家1(1)', '0.0.0.0', '1552545138', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a67100bf8cefaa8b98f6d0e64076e015');
INSERT INTO `oplog` VALUES ('TCE434B59F1EC45C3AC5D1E5D', '系统管理员(sysadmin)', '0.0.0.0', '1552545151', null, '', null, '成功', '访问投票统计', '用户访问日志', 'b43bf7cfddb949bde7f1d8bbd902aa48');
INSERT INTO `oplog` VALUES ('T0AA90D0708C848CF9C1EB4AE', '系统管理员(sysadmin)', '0.0.0.0', '1552545153', null, '', null, '成功', '访问投票统计', '用户访问日志', '9fb4c40fde68e39d0ddde134332ec2d9');
INSERT INTO `oplog` VALUES ('T269435C703144A5480F225AD', '专家2(2)', '0.0.0.0', '1552545198', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE0130A8388F541FAA6570022', '专家2(2)', '0.0.0.0', '1552545199', null, '', null, '成功', '访问项目评审', '用户访问日志', '6a5eb17a85958090e963fb52af04c68b');
INSERT INTO `oplog` VALUES ('T0563F7F47087464982B9AD27', '专家2(2)', '0.0.0.0', '1552545226', null, '', null, '成功', '访问项目评审', '用户访问日志', '2a0aefaef16385de35e2cd0cc52189bf');
INSERT INTO `oplog` VALUES ('T57785A8F7A7240B99C4D8EC1', '()', '0.0.0.0', '1552545269', null, '', null, '失败', '账号(3)登录,密码错误', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCA54E2BF9AEA405C82C6949C', '专家3(3)', '0.0.0.0', '1552545272', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAD4A01837323411CAD98D155', '专家3(3)', '0.0.0.0', '1552545272', null, '', null, '成功', '访问项目评审', '用户访问日志', '7f9e89432615ed5ea452325614c07b80');
INSERT INTO `oplog` VALUES ('T086069F7C9D14355A2FD872E', '专家3(3)', '0.0.0.0', '1552545323', null, '', null, '成功', '访问评分统计', '用户访问日志', 'a40ff2ed9ab7da2b89a62a6cff841d4f');
INSERT INTO `oplog` VALUES ('T8617375933E044DF947AEC62', '专家3(3)', '0.0.0.0', '1552545324', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a1504de631488b06cf7fd38d3a65440f');
INSERT INTO `oplog` VALUES ('TB663FAA4A8AB4054A3B5983E', '专家3(3)', '0.0.0.0', '1552545467', null, '', null, '成功', '访问项目评审', '用户访问日志', '987790191c8c550309df5e6b607a7b67');
INSERT INTO `oplog` VALUES ('TD485AE2BB62E46DD946F902B', '专家3(3)', '0.0.0.0', '1552545472', null, '', null, '成功', '访问项目评审', '用户访问日志', '04b3205a6c36fa598cacb22223ce5029');
INSERT INTO `oplog` VALUES ('T821B57BA44A6412CB4F7AF32', '系统管理员(sysadmin)', '0.0.0.0', '1552545494', null, '', null, '成功', '访问投票统计', '用户访问日志', '15e44cd8ca73775d63897ef5c3da67ac');
INSERT INTO `oplog` VALUES ('TCF00A8BAD615421CBEEE8785', '系统管理员(sysadmin)', '0.0.0.0', '1552545534', null, '', null, '成功', '访问明细查询', '用户访问日志', 'e116613cead50c281f04cb7bd239198f');
INSERT INTO `oplog` VALUES ('T8B4E00C63B6142F6B1000F86', '专家1(1)', '0.0.0.0', '1552545613', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T847D43AFBA1D4B938144FA41', '专家1(1)', '0.0.0.0', '1552545614', null, '', null, '成功', '访问项目评审', '用户访问日志', '7deea1fbbcf51d046dbd4e7e77604dd8');
INSERT INTO `oplog` VALUES ('T5D602AFF5D8F4534A02484EF', '系统管理员(sysadmin)', '0.0.0.0', '1552545686', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b4e6f4d06cae845ecdb3f8e9e934377e');
INSERT INTO `oplog` VALUES ('T88AAA722A33144B78EEC9F45', '系统管理员(sysadmin)', '0.0.0.0', '1552545719', null, '', null, '成功', '访问评分统计', '用户访问日志', '6e2641170c767575a1b7189b79c81912');
INSERT INTO `oplog` VALUES ('T65CBE43E6B164BE08223CE25', '系统管理员(sysadmin)', '0.0.0.0', '1552545721', null, '', null, '成功', '访问投票统计', '用户访问日志', 'cfd57414347a728317e74996d721927a');
INSERT INTO `oplog` VALUES ('T7B41E748BAB844ADBD77C76E', '系统管理员(sysadmin)', '0.0.0.0', '1552545748', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b43c22bd45cf7abbc9e15217f369148d');
INSERT INTO `oplog` VALUES ('T2D39FC505FC2483C9BB4BF7D', '专家2(2)', '0.0.0.0', '1552545775', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6B6E298D41F645EC8C5B45B5', '专家2(2)', '0.0.0.0', '1552545776', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c98f4aadba316955beb60ff05f46c3a5');
INSERT INTO `oplog` VALUES ('T4D0953978C854803BD61BEA7', '专家3(3)', '0.0.0.0', '1552545791', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T0152837150F1445CA5CF77C5', '专家3(3)', '0.0.0.0', '1552545792', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c49d8f2be8fe14c56c1e14b4f727bbeb');
INSERT INTO `oplog` VALUES ('TEEFCF9BF3DBC41F59F19CDA0', '专家4(4)', '0.0.0.0', '1552545808', null, '', null, '成功', '账号(4)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T9F0AC1672B9742879F403FF3', '专家4(4)', '0.0.0.0', '1552545809', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a478a60ab79ca2b47c0ce06586b0dfa6');
INSERT INTO `oplog` VALUES ('TBDCD1FD08D514510A5D61D8A', '专家5(5)', '0.0.0.0', '1552545820', null, '', null, '成功', '账号(5)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TFE48B0D7AB90479B9652CEC2', '专家5(5)', '0.0.0.0', '1552545820', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c3fa9ded0d3d4e7992d8c13d9fab6136');
INSERT INTO `oplog` VALUES ('TE6EFC581D9694B7982E5E673', '系统管理员(sysadmin)', '0.0.0.0', '1552545832', null, '', null, '成功', '访问投票统计', '用户访问日志', 'e8cc70bf8da597675d5958d3fae38931');
INSERT INTO `oplog` VALUES ('T7082CC8309E5408092B10C06', '系统管理员(sysadmin)', '0.0.0.0', '1552545835', null, '', null, '成功', '访问评分统计', '用户访问日志', '13ddadb880baa27f52cf6d2fd99a9790');
INSERT INTO `oplog` VALUES ('T13ABDA8786034D93BA54C2FC', '系统管理员(sysadmin)', '0.0.0.0', '1552545837', null, '', null, '成功', '访问明细查询', '用户访问日志', '1498720791092970ae844333a36cc83a');
INSERT INTO `oplog` VALUES ('TA6D9BEE47E184D42983D68F0', '系统管理员(sysadmin)', '0.0.0.0', '1552545856', null, '', null, '成功', '访问投票统计', '用户访问日志', '0bcf7aa1ee9697585d8df52b9513a175');
INSERT INTO `oplog` VALUES ('T567CB68AEF5448FEBDB6FBE3', '专家1(1)', '0.0.0.0', '1552545945', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE5A11545946E445AA06F70FB', '专家1(1)', '0.0.0.0', '1552545945', null, '', null, '成功', '访问项目评审', '用户访问日志', '0e2eb0fb43b4e47fc4a5879deb227afe');
INSERT INTO `oplog` VALUES ('TB4A5FE73EF714C97BF2DA1C8', '专家1(1)', '0.0.0.0', '1552546037', null, '', null, '成功', '访问项目评审', '用户访问日志', '2e41afa872384d9656652bf0c5d425f9');
INSERT INTO `oplog` VALUES ('T033607672E414EDF90A1E135', '系统管理员(sysadmin)', '0.0.0.0', '1552546104', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T0316886255D646CBA874C787', '系统管理员(sysadmin)', '0.0.0.0', '1552546106', null, '', null, '成功', '访问用户管理', '用户访问日志', '5227d72ce47a62b3393d94e9bb1650da');
INSERT INTO `oplog` VALUES ('TF72F11A809544468A6518EBB', '系统管理员(sysadmin)', '0.0.0.0', '1552546158', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b0f195c716e2286570a68f99d69eef7d');
INSERT INTO `oplog` VALUES ('T667C3B9E785E4EA38E217F92', '系统管理员(sysadmin)', '0.0.0.0', '1552546160', null, '', null, '成功', '访问评分统计', '用户访问日志', 'e4d6110d1d3a5717e271a1dfbbe9b93a');
INSERT INTO `oplog` VALUES ('T8BE251E085CC41E68046EF14', '系统管理员(sysadmin)', '0.0.0.0', '1552546231', null, '', null, '成功', '访问投票统计', '用户访问日志', '3a7be1edd46a01074a2c9dd440f3b86d');
INSERT INTO `oplog` VALUES ('T81B3CD472BEC49FB95F259F7', '系统管理员(sysadmin)', '0.0.0.0', '1552546240', null, '', null, '成功', '访问数据交互', '用户访问日志', 'a6928f6caf7c05f54485eecc5a318052');
INSERT INTO `oplog` VALUES ('TAB54289662C8410C9778A479', '系统管理员(sysadmin)', '0.0.0.0', '1552546242', null, '', null, '成功', '访问用户管理', '用户访问日志', '78cc09eab1124f6aa06daa08f85a5826');
INSERT INTO `oplog` VALUES ('T0E9C75E19F784F31BA603D05', '系统管理员(sysadmin)', '0.0.0.0', '1552546250', null, '', null, '成功', '访问用户管理', '用户访问日志', '55254f764186f2c99db82c3e1bf7e4b5');
INSERT INTO `oplog` VALUES ('T3EE9DFC27DD24FFF8040E04A', '系统管理员(sysadmin)', '0.0.0.0', '1552546280', null, '', null, '成功', '访问数据交互', '用户访问日志', '595e2f416e7a6aa7f25914b96a6c064b');
INSERT INTO `oplog` VALUES ('TB348C94BD2C74A20B4890FD7', '系统管理员(sysadmin)', '0.0.0.0', '1552546281', null, '', null, '成功', '访问投票统计', '用户访问日志', '0a045d2fd9d38e8dd2d9077efc98a64c');
INSERT INTO `oplog` VALUES ('T0EBDB409441F407B87F6EE55', '系统管理员(sysadmin)', '0.0.0.0', '1552546290', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b38a41ca956da0834d1722ff6741ccae');
INSERT INTO `oplog` VALUES ('T00E7B78EF1EC42ADBE0EB218', '系统管理员(sysadmin)', '0.0.0.0', '1554688658', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T04D15F0C581544E9B328258E', '专家1(1)', '0.0.0.0', '1554688807', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T2F229A71000E4306A9DD2915', '专家1(1)', '0.0.0.0', '1554688809', null, '', null, '成功', '访问项目评审', '用户访问日志', '2ab644543f5d968779ab433d5c5b3f18');
INSERT INTO `oplog` VALUES ('T1CD3D28A1C98411B8C28103D', '专家1(1)', '0.0.0.0', '1554688881', null, '', null, '成功', '访问项目评审', '用户访问日志', '2775488490f29f9fd0f5a69b6d42fcbf');
INSERT INTO `oplog` VALUES ('T9D458303CECE4DF8B51C734A', '系统管理员(sysadmin)', '0.0.0.0', '1554688888', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD2394CFBAA7B4FA09110ADDF', '系统管理员(sysadmin)', '0.0.0.0', '1554688890', null, '', null, '成功', '访问用户管理', '用户访问日志', '92046ec803c800b408445aec5793d0a7');
INSERT INTO `oplog` VALUES ('T25EC497F43F54AAC8C68D6A1', '系统管理员(sysadmin)', '0.0.0.0', '1554688925', null, '', null, '成功', '访问明细查询', '用户访问日志', '8d31df931adb8807c5a8380dd4317c31');
INSERT INTO `oplog` VALUES ('T95102B2DEFA64810AEEA0411', '系统管理员(sysadmin)', '0.0.0.0', '1554688953', null, '', null, '成功', '访问明细查询', '用户访问日志', '6c3a7bf03d0f7fab837acde77965d141');
INSERT INTO `oplog` VALUES ('TF68CBFE5926642B081CEBEA9', '系统管理员(sysadmin)', '0.0.0.0', '1554688980', null, '', null, '成功', '访问评分统计', '用户访问日志', 'd7a2be986f5c963168ca1df7a375d727');
INSERT INTO `oplog` VALUES ('T21C4E84218C2492B97A8A38B', '系统管理员(sysadmin)', '0.0.0.0', '1554689005', null, '', null, '成功', '访问投票统计', '用户访问日志', 'afe7144fa2d0ea801c689abd161ea79d');
INSERT INTO `oplog` VALUES ('T18370B20006B44C691ECF996', '系统管理员(sysadmin)', '0.0.0.0', '1554689012', null, '', null, '成功', '访问数据交互', '用户访问日志', 'd6f04301915cf2d858d9d2a28a19638e');
INSERT INTO `oplog` VALUES ('TFD078F9649FE43DF80EAC27B', '系统管理员(sysadmin)', '0.0.0.0', '1554689025', null, '', null, '成功', '访问明细查询', '用户访问日志', 'd12b6d46ec6202222a47915b6b4726bf');
INSERT INTO `oplog` VALUES ('T80510C92180E434F8E8D5C2C', '系统管理员(sysadmin)', '0.0.0.0', '1554689027', null, '', null, '成功', '访问用户管理', '用户访问日志', '4ddec14c285ace40de3a5ae8f93d78d0');
INSERT INTO `oplog` VALUES ('T9F818958F5814310993362E7', '系统管理员(sysadmin)', '0.0.0.0', '1554689030', null, '', null, '成功', '访问明细查询', '用户访问日志', '2ce74ceed57eb2155a45ed521e5cd54f');
INSERT INTO `oplog` VALUES ('T573B61D2845744D1BDA1F4E2', '系统管理员(sysadmin)', '0.0.0.0', '1554689033', null, '', null, '成功', '访问评分统计', '用户访问日志', 'db8578572a56965c090926c797e92c93');
INSERT INTO `oplog` VALUES ('TAFCCB35293CE40E190D54AD6', '专家1(1)', '0.0.0.0', '1554689067', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAD71B54D73C141A1AA0EAD2A', '专家1(1)', '0.0.0.0', '1554689068', null, '', null, '成功', '访问项目评审', '用户访问日志', '58226475936265c1683a79c9cdf5ab9b');
INSERT INTO `oplog` VALUES ('T522CCECF4EE54495A220235E', '专家1(1)', '0.0.0.0', '1554689075', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c0af0256b6c20fc6a7bf1c3081f12cdd');
INSERT INTO `oplog` VALUES ('T250F5C749F6C49D2905E468E', '系统管理员(sysadmin)', '0.0.0.0', '1554689082', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T184D8BF5121E43109AF5CE9A', '系统管理员(sysadmin)', '0.0.0.0', '1554689084', null, '', null, '成功', '访问评分统计', '用户访问日志', '639bae0a837b59007e914ed83d1f2239');
INSERT INTO `oplog` VALUES ('T8FF2A6CC07E14AB78B53D474', '系统管理员(sysadmin)', '0.0.0.0', '1554689193', null, '', null, '成功', '访问投票统计', '用户访问日志', 'c218acc178280803c2edf3cc3f0c06ca');
INSERT INTO `oplog` VALUES ('T71E9A8177E11469882A0026C', '系统管理员(sysadmin)', '0.0.0.0', '1554689279', null, '', null, '成功', '访问评分统计', '用户访问日志', '938fbb267f85369ee7338833c1dad31e');
INSERT INTO `oplog` VALUES ('T5D8F4A8B199C41888EC24BB0', '系统管理员(sysadmin)', '0.0.0.0', '1554689331', null, '', null, '成功', '访问投票统计', '用户访问日志', '25d0330b80a42190c47e6b9e61e29e94');
INSERT INTO `oplog` VALUES ('TA120A091D09E4FBA95F5B23E', '系统管理员(sysadmin)', '0.0.0.0', '1554689379', null, '', null, '成功', '访问评分统计', '用户访问日志', 'e1e19c026ba887542f8da8e0325da8bc');
INSERT INTO `oplog` VALUES ('T0681220344374716BE9E776D', '系统管理员(sysadmin)', '0.0.0.0', '1554689380', null, '', null, '成功', '访问明细查询', '用户访问日志', '8edfefe6319e68ab94cc6f2658922a32');
INSERT INTO `oplog` VALUES ('T0AB9C04E8DD24498B7F7E1B4', '系统管理员(sysadmin)', '0.0.0.0', '1554689434', null, '', null, '成功', '访问投票统计', '用户访问日志', '400882dab8432a1662b431896bc9af67');
INSERT INTO `oplog` VALUES ('T55E94B2567B6478F8ABC4DC3', '系统管理员(sysadmin)', '0.0.0.0', '1554689443', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCCE5C2AE0C9F44D4B2C690E6', '系统管理员(sysadmin)', '0.0.0.0', '1554689444', null, '', null, '成功', '访问明细查询', '用户访问日志', '9004e15b8b9879c913d84fbdc76a6abc');
INSERT INTO `oplog` VALUES ('T976859271298455CB91E6443', '系统管理员(sysadmin)', '0.0.0.0', '1554689448', null, '', null, '成功', '访问评分统计', '用户访问日志', 'df95f8feea8e9b6ec338c906c37daa08');
INSERT INTO `oplog` VALUES ('T8E6EBD6EBDBD4F2686A4EA72', '系统管理员(sysadmin)', '0.0.0.0', '1554689450', null, '', null, '成功', '导出', '明细查询', '92a63c4a1b961bfccc58eddf379ff64b');
INSERT INTO `oplog` VALUES ('TE57041DD6E1240259260B1FC', '系统管理员(sysadmin)', '0.0.0.0', '1554689452', null, '', null, '成功', '导出', '明细查询', '8395d8a4c1764e3aac072c4601c0f1b0');
INSERT INTO `oplog` VALUES ('T570237DD74FE483B92138855', '系统管理员(sysadmin)', '0.0.0.0', '1554689470', null, '', null, '成功', '访问明细查询', '用户访问日志', '65360de67b37fb43d40583d971acb937');
INSERT INTO `oplog` VALUES ('TE6A30BCEFAB14091A252AF48', '系统管理员(sysadmin)', '0.0.0.0', '1554689578', null, '', null, '成功', '访问数据交互', '用户访问日志', 'f9f13ae01b73f02c65f5c2e6205b6fc0');
INSERT INTO `oplog` VALUES ('T41789C0D2F654FA49C740D75', '系统管理员(sysadmin)', '0.0.0.0', '1554689579', null, '', null, '成功', '访问投票统计', '用户访问日志', '0a7c4c5ead569b9250b7c479ac80b68b');
INSERT INTO `oplog` VALUES ('TF9AB83E35FC84A46B98FD5B9', '系统管理员(sysadmin)', '0.0.0.0', '1554689579', null, '', null, '成功', '访问评分统计', '用户访问日志', '36a2fd8c647c9733f79a82aa1134cf8a');
INSERT INTO `oplog` VALUES ('TC5C7F4C4218A4224BF148743', '专家1(1)', '0.0.0.0', '1554689589', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7A968C7B573548C3A10DC9E0', '专家1(1)', '0.0.0.0', '1554689589', null, '', null, '成功', '访问项目评审', '用户访问日志', '6318928f8944e5d4bc72a4d28d1cc9c6');
INSERT INTO `oplog` VALUES ('T8BEBC3E0B1EB441FACBF84AD', '专家1(1)', '0.0.0.0', '1554689695', null, '', null, '成功', '访问项目评审', '用户访问日志', '2b4b41c3a7bec6149e586314bb6f9e0d');
INSERT INTO `oplog` VALUES ('T9389668DBFCB43FCBA13497B', '系统管理员(sysadmin)', '0.0.0.0', '1554689737', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T151284F719A34FD885713026', '系统管理员(sysadmin)', '0.0.0.0', '1554689741', null, '', null, '成功', '访问投票统计', '用户访问日志', 'c28b2e638da3c5c0c2c051c4e5b6949a');
INSERT INTO `oplog` VALUES ('T21C6E3717B8749DBA527B220', '系统管理员(sysadmin)', '0.0.0.0', '1554689744', null, '', null, '成功', '访问评分统计', '用户访问日志', 'cef8b3493eaad86e60f43f9a87e836be');
INSERT INTO `oplog` VALUES ('TA286A9FBF84240A29475E008', '专家1(1)', '0.0.0.0', '1554689762', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE5412EC452134CFC8DB3D5FC', '专家1(1)', '0.0.0.0', '1554689762', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd4bf15a03013294d0a99788832728f69');
INSERT INTO `oplog` VALUES ('T9A36C60202124A40AC095EA9', '专家1(1)', '0.0.0.0', '1554689797', null, '', null, '成功', '访问项目评审', '用户访问日志', '37c9098bbc3e1b6ceebe4a64ea39d48d');
INSERT INTO `oplog` VALUES ('T714930D57B974B62A99DDB39', '专家1(1)', '0.0.0.0', '1554690104', null, '', null, '成功', '访问项目评审', '用户访问日志', '3e06b88ce1ee95d8f73f9f2964ec9e62');
INSERT INTO `oplog` VALUES ('T63D675E7CDAC4B458EC9E3E5', '专家1(1)', '0.0.0.0', '1554690133', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c8d9c994e7f38e01b78514abd3034b30');
INSERT INTO `oplog` VALUES ('T7F93D834BB784B369B74816D', '系统管理员(sysadmin)', '0.0.0.0', '1554690296', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T69A067AD300B418899DC337A', '系统管理员(sysadmin)', '0.0.0.0', '1554690298', null, '', null, '成功', '访问投票统计', '用户访问日志', '1fa3d7b55d2a18bc820e8c9db0c4069c');
INSERT INTO `oplog` VALUES ('TEB952C3354CA4D4D96B8C5DA', '系统管理员(sysadmin)', '0.0.0.0', '1554690304', null, '', null, '成功', '访问明细查询', '用户访问日志', 'a0d1be7f9d256cf0582442257774c139');
INSERT INTO `oplog` VALUES ('T9DC9A98AB95044FB8DA0261C', '系统管理员(sysadmin)', '0.0.0.0', '1554690328', null, '', null, '成功', '访问明细查询', '用户访问日志', 'e293f887cae83fe30ec2c52f095ff037');
INSERT INTO `oplog` VALUES ('TC2FCF5B5A33F45949130EFC1', '系统管理员(sysadmin)', '0.0.0.0', '1554690366', null, '', null, '成功', '访问明细查询', '用户访问日志', '67d5e56e83f1b218602823dfa1d3f566');
INSERT INTO `oplog` VALUES ('TC2609F6F6D20484C99D96D1B', '系统管理员(sysadmin)', '0.0.0.0', '1554690425', null, '', null, '成功', '访问明细查询', '用户访问日志', '4749026ef1518ce8358c9a3184eed374');
INSERT INTO `oplog` VALUES ('TDA0A296FE5BB49FD916593CC', '系统管理员(sysadmin)', '0.0.0.0', '1554690483', null, '', null, '成功', '访问明细查询', '用户访问日志', 'b0be3e49988e4d8245358f72e2e40231');
INSERT INTO `oplog` VALUES ('T97066B8CBF134F9EAE2EC993', '专家1(1)', '0.0.0.0', '1554786971', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TF3D3D99BA60D4364A5990461', '专家1(1)', '0.0.0.0', '1554786971', null, '', null, '成功', '访问项目评审', '用户访问日志', '62d6e1abb5e38102b1d31df80773d79f');
INSERT INTO `oplog` VALUES ('TB2EFBAAE53A64DE689420A4F', '系统管理员(sysadmin)', '0.0.0.0', '1554786980', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TFD79B7D2CE1549D8A5023B7A', '系统管理员(sysadmin)', '0.0.0.0', '1554786982', null, '', null, '成功', '访问投票统计', '用户访问日志', '72b6099a33650e7018ea52836013840e');
INSERT INTO `oplog` VALUES ('T8FDBDA46D9434F70BAA5208E', '系统管理员(sysadmin)', '0.0.0.0', '1554786984', null, '', null, '成功', '访问评分统计', '用户访问日志', '00029d3ff13e3241f2ddfe5becb4e2c5');
INSERT INTO `oplog` VALUES ('T1B813513872A4305861C55D0', '专家1(1)', '0.0.0.0', '1554787020', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6EDFB795BA1F44E3A2200BA2', '专家1(1)', '0.0.0.0', '1554787021', null, '', null, '成功', '访问项目评审', '用户访问日志', '9f0dc2b49fcb7848ac0d54cdadd0d87d');
INSERT INTO `oplog` VALUES ('TF6E6A91ECEF54B60AB01A8C3', '专家1(1)', '0.0.0.0', '1554788300', null, '', null, '成功', '访问项目评审', '用户访问日志', 'af16d5c05316f4d962718d8f3847dd82');
INSERT INTO `oplog` VALUES ('TBD18B4C3AEB042FC90F3735D', '系统管理员(sysadmin)', '0.0.0.0', '1554788351', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TD4E90367587243258A789E3A', '专家1(1)', '0.0.0.0', '1554788501', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T0C5A6F21E4394DB896E72113', '专家1(1)', '0.0.0.0', '1554788501', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b362dff9c816534bb7cb19a1488ba684');
INSERT INTO `oplog` VALUES ('TDDDF8CD43E6F4E2197D7C5D2', '系统管理员(sysadmin)', '0.0.0.0', '1554788518', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE6448907EBD5469A86696B0E', '系统管理员(sysadmin)', '0.0.0.0', '1554788566', null, '', null, '成功', '访问明细查询', '用户访问日志', 'ae89ffa0b15a7a6063d005fdfbb6eea7');
INSERT INTO `oplog` VALUES ('T73DBB8C5782C48A6A2C6C39A', '系统管理员(sysadmin)', '0.0.0.0', '1554788569', null, '', null, '成功', '访问评分统计', '用户访问日志', '4f0498dd6973bcd88f2e65d2731de6fe');
INSERT INTO `oplog` VALUES ('TD2AF1BB9C88448B1A70304EC', '系统管理员(sysadmin)', '0.0.0.0', '1554788572', null, '', null, '成功', '导出', '明细查询', '9f5c5c3d94254419e5e0b8ad01af7fb4');
INSERT INTO `oplog` VALUES ('TDF799BFA198A463E8B7BDB0C', '系统管理员(sysadmin)', '0.0.0.0', '1554788611', null, '', null, '成功', '访问投票统计', '用户访问日志', '4b02fd8a7b745ea9caf5f3b479387223');
INSERT INTO `oplog` VALUES ('T73DBB8C5782C48A6A2C6C39A', '系统管理员(sysadmin)', '0.0.0.0', '1554788613', null, '', null, '成功', '导出', '明细查询', 'a0be215902e619659831a2219dc481cb');
INSERT INTO `oplog` VALUES ('T8A0DDA351BD2446C8AACD490', '系统管理员(sysadmin)', '0.0.0.0', '1554788683', null, '', null, '成功', '访问用户管理', '用户访问日志', 'e2c5308cf6158f64196442a04355d218');
INSERT INTO `oplog` VALUES ('T484E4F5BB58C48AB83D5D873', '系统管理员(sysadmin)', '0.0.0.0', '1554788685', null, '', null, '成功', '访问明细查询', '用户访问日志', '82700a6c023b1cc9c421e2f557e956c0');
INSERT INTO `oplog` VALUES ('T5570E1CB6D48436A8C9CE19C', '专家1(1)', '0.0.0.0', '1554788791', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TC0A7B12363644F55B5347DD1', '专家1(1)', '0.0.0.0', '1554788791', null, '', null, '成功', '访问项目评审', '用户访问日志', '250b0b477ad2213ef17bce7fc0c7df62');
INSERT INTO `oplog` VALUES ('TD005B82E7DDD40BBA6A24042', '专家1(1)', '0.0.0.0', '1554788803', null, '', null, '成功', '访问项目评审', '用户访问日志', 'eee9ecb489922afb38b669317e14a0fd');
INSERT INTO `oplog` VALUES ('T4D5046D7154D4EBEBFBCC79C', '专家1(1)', '0.0.0.0', '1554788874', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f8fe3d229beedba95df19da8d306fb3e');
INSERT INTO `oplog` VALUES ('T4E0326FCD6784046BE82C9A2', '专家2(2)', '0.0.0.0', '1554788979', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7B187AEDB3D94C798D6B0F8C', '专家2(2)', '0.0.0.0', '1554788979', null, '', null, '成功', '访问项目评审', '用户访问日志', '5b329dee15f77aafd8c7f20af698cb58');
INSERT INTO `oplog` VALUES ('T12320C4EBBCF477B86B7491C', '专家2(2)', '0.0.0.0', '1554788981', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fde4f4275af0bbe17860cd2933a9a335');
INSERT INTO `oplog` VALUES ('TB946EA3DE5004E74BFE84F4E', '专家3(3)', '0.0.0.0', '1554788989', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T257376D3FC5C4C3AA9FACDB6', '专家3(3)', '0.0.0.0', '1554788989', null, '', null, '成功', '访问项目评审', '用户访问日志', '3ada5ea5de710634a43c3a4212ff8d29');
INSERT INTO `oplog` VALUES ('T4F65903DDA084073B6F76AC7', '系统管理员(sysadmin)', '0.0.0.0', '1554789076', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T37677F06B3444A26818C8AE7', '系统管理员(sysadmin)', '0.0.0.0', '1554789579', null, '', null, '成功', '访问明细查询', '用户访问日志', '1c8772bcc08fa6b06bd27eb94fe28b8b');
INSERT INTO `oplog` VALUES ('TA2E810357DAD43D7955B6278', '系统管理员(sysadmin)', '0.0.0.0', '1554789582', null, '', null, '成功', '访问评分统计', '用户访问日志', 'bcd056768dbc89d6c3b34eb1f916f348');
INSERT INTO `oplog` VALUES ('TF8D21C37AD0447C2A9EFBE07', '系统管理员(sysadmin)', '0.0.0.0', '1554789584', null, '', null, '成功', '访问投票统计', '用户访问日志', '189d4849c56e53272abed78db3439429');
INSERT INTO `oplog` VALUES ('T664E954DF7E94F998B6FADBA', '系统管理员(sysadmin)', '0.0.0.0', '1554789586', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b9682699926e593e027b9b3e10e45210');
INSERT INTO `oplog` VALUES ('T17761F20C78542BD8DF8C4D6', '专家1(1)', '0.0.0.0', '1554789594', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA9A76EF82B3C44D4A70630B8', '专家1(1)', '0.0.0.0', '1554789594', null, '', null, '成功', '访问项目评审', '用户访问日志', 'da03052693dfbcce8e1455da8760d66e');
INSERT INTO `oplog` VALUES ('T49034F93A1E341329801CC40', '专家1(1)', '0.0.0.0', '1554789602', null, '', null, '成功', '访问项目评审', '用户访问日志', '34f8b0dd58789a2358dfeb19f6e2afbf');
INSERT INTO `oplog` VALUES ('T8FAB2FA9D14041E2915FD666', '专家1(1)', '0.0.0.0', '1554789604', null, '', null, '成功', '访问项目评审', '用户访问日志', '7b2c30ae8a7849d15657be595c86cf65');
INSERT INTO `oplog` VALUES ('T7C96939074A343349260EFDF', '专家1(1)', '0.0.0.0', '1554789607', null, '', null, '成功', '访问项目评审', '用户访问日志', '26e62822dee0de66147cdd7967c6a594');
INSERT INTO `oplog` VALUES ('TFC4DE14A907D405D86E1BB1A', '专家1(1)', '0.0.0.0', '1554789616', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7131EE5FA3D7492F8EC3FE4D', '专家1(1)', '0.0.0.0', '1554789617', null, '', null, '成功', '访问项目评审', '用户访问日志', '01caff2c80820ec3d2d9346cc24a3fe8');
INSERT INTO `oplog` VALUES ('T3C39318AE1A442C38BD2B26E', '系统管理员(sysadmin)', '0.0.0.0', '1554789621', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA86A5F5F0A7F4025917B3CC4', '系统管理员(sysadmin)', '0.0.0.0', '1554789623', null, '', null, '成功', '访问评分统计', '用户访问日志', '8a72e364fb4c794b484f07b12f0c0c7f');
INSERT INTO `oplog` VALUES ('TBEEB76D730454E748B5AF700', '专家1(1)', '0.0.0.0', '1554789636', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T799EAD01D4784D27B304BD2E', '专家1(1)', '0.0.0.0', '1554789636', null, '', null, '成功', '访问项目评审', '用户访问日志', 'c4e34ff74298041a5505e378009a384f');
INSERT INTO `oplog` VALUES ('T7919735381714E2187473FCB', '专家1(1)', '0.0.0.0', '1554789675', null, '', null, '成功', '访问项目评审', '用户访问日志', 'ead7d8af3262375a37ea37680e628128');
INSERT INTO `oplog` VALUES ('T4AA0D5D0AC274798936A9986', '专家1(1)', '0.0.0.0', '1554789716', null, '', null, '成功', '访问项目评审', '用户访问日志', '711ca725edb33c4d54b05c9daf08ce84');
INSERT INTO `oplog` VALUES ('T9D11BB2FCEAE45278E3F6113', '专家1(1)', '0.0.0.0', '1554789728', null, '', null, '成功', '访问项目评审', '用户访问日志', '01939bd118153c53ab281d2cdac18edb');
INSERT INTO `oplog` VALUES ('TDB7164AF34A3456CBF44537E', '专家1(1)', '0.0.0.0', '1554789732', null, '', null, '成功', '访问项目评审', '用户访问日志', '8fd8759f12d9bd059355e9d36d288d9b');
INSERT INTO `oplog` VALUES ('TA29AB0627BD24D5480284AC2', '专家1(1)', '0.0.0.0', '1554789996', null, '', null, '成功', '访问项目评审', '用户访问日志', '86b71da71064240c547e7c2e85e85e4d');
INSERT INTO `oplog` VALUES ('TAF79A3F50BF748C88A2BCF07', '专家1(1)', '0.0.0.0', '1554790222', null, '', null, '成功', '访问项目评审', '用户访问日志', '51c03c96a52bef4f2af7fbdc2c5ccbe6');
INSERT INTO `oplog` VALUES ('TAC496461AB244483A2033995', '专家1(1)', '0.0.0.0', '1554790223', null, '', null, '成功', '访问项目评审', '用户访问日志', '26fea834690907bf5b11d1f3fbd61401');
INSERT INTO `oplog` VALUES ('T547FB9A7FC284910BEA7A016', '专家1(1)', '0.0.0.0', '1554790490', null, '', null, '成功', '访问项目评审', '用户访问日志', '3eff82db924a311e17c32ca177ab3a64');
INSERT INTO `oplog` VALUES ('T39717A713CBA4D148355352E', '专家1(1)', '0.0.0.0', '1554790508', null, '', null, '成功', '访问项目评审', '用户访问日志', '9a49644654a5b3002f08e1559d884d73');
INSERT INTO `oplog` VALUES ('T35E9E79E6BF8405C871D6D1A', '专家1(1)', '0.0.0.0', '1554790779', null, '', null, '成功', '访问项目评审', '用户访问日志', '07253e1e7244dea8c7ec769a251ad036');
INSERT INTO `oplog` VALUES ('TD722FE218C854B3895568640', '专家1(1)', '0.0.0.0', '1554790880', null, '', null, '成功', '访问项目评审', '用户访问日志', '2cdb12255ed2f9486ff5446e95d27ec5');
INSERT INTO `oplog` VALUES ('T295602D7E2AB4659AFC9B48A', '专家1(1)', '0.0.0.0', '1554790909', null, '', null, '成功', '访问项目评审', '用户访问日志', '3fa172e15bb26f01d852886fe41e587c');
INSERT INTO `oplog` VALUES ('T902FD26A08884E4A9893F357', '专家1(1)', '0.0.0.0', '1554791044', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e95c170939093f3a3925abb0f2d3dd6d');
INSERT INTO `oplog` VALUES ('TA924CF5E255E4AF882DD36B5', '专家1(1)', '0.0.0.0', '1554791069', null, '', null, '成功', '访问项目评审', '用户访问日志', '60469a5fcb126cf041499c2f1eb59082');
INSERT INTO `oplog` VALUES ('TFAE776F1D688410B918D3F2F', '专家1(1)', '0.0.0.0', '1554791106', null, '', null, '成功', '访问项目评审', '用户访问日志', 'cfd95deeb74542b1d2d604283812b9de');
INSERT INTO `oplog` VALUES ('TC59BE886967A4BA194A3D882', '专家1(1)', '0.0.0.0', '1554791137', null, '', null, '成功', '访问项目评审', '用户访问日志', 'b6b92dd85dd002e343d52f8fca5bb28d');
INSERT INTO `oplog` VALUES ('T90A7A52FA16E4B5081B1BBAB', '专家1(1)', '0.0.0.0', '1554791235', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fd00f1f72326c38416f44b794598818e');
INSERT INTO `oplog` VALUES ('TE1CF803E77794DF09B766434', '专家1(1)', '0.0.0.0', '1554791925', null, '', null, '成功', '访问项目评审', '用户访问日志', 'bbf9dbb7fbf08ea23e6ec54207eb524c');
INSERT INTO `oplog` VALUES ('T019C413FE3254CFE81C0A3A1', '专家1(1)', '0.0.0.0', '1554792471', null, '', null, '成功', '访问项目评审', '用户访问日志', '2a8a411804b9d2f9d5c3aa6dd44b701a');
INSERT INTO `oplog` VALUES ('TB7DC5021485240EBB77B2E27', '专家1(1)', '0.0.0.0', '1554792522', null, '', null, '成功', '访问项目评审', '用户访问日志', '83df828df1f069fdeadd329c03ae32c7');
INSERT INTO `oplog` VALUES ('TDF1BC2CD746746709996C96D', '专家1(1)', '0.0.0.0', '1554792603', null, '', null, '成功', '访问项目评审', '用户访问日志', '99a2cf8a57328e51a4e4f409103173c9');
INSERT INTO `oplog` VALUES ('TBFDC3BE6751B45B48F4FBBB1', '系统管理员(sysadmin)', '0.0.0.0', '1554793685', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA05A8F3FD9094397A9B4231B', '专家1(1)', '0.0.0.0', '1554794043', null, '', null, '成功', '访问项目评审', '用户访问日志', '63a216fb69c15bb675a8286bbe71a5e8');
INSERT INTO `oplog` VALUES ('T04AC1F8D2F3748B1B064DA9C', '专家1(1)', '0.0.0.0', '1554794088', null, '', null, '成功', '访问项目评审', '用户访问日志', '40cb7da0c5513be0ddcbf09c1e11ea7f');
INSERT INTO `oplog` VALUES ('TEED4FB29395646E6851BA110', '专家1(1)', '0.0.0.0', '1554794107', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd281532cc2a75eac2763c6af745e1157');
INSERT INTO `oplog` VALUES ('T0D9F0F8C1D0E490DB04016A2', '专家1(1)', '0.0.0.0', '1554794148', null, '', null, '成功', '访问项目评审', '用户访问日志', '84dfbb8f9147128a0e3e05948673ef37');
INSERT INTO `oplog` VALUES ('T0F10598D07484F4383A12A32', '专家1(1)', '0.0.0.0', '1554794989', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd3294910fdef730bfa00eb65351c1504');
INSERT INTO `oplog` VALUES ('T4E8748A4622D4D51B16A48FB', '专家1(1)', '0.0.0.0', '1554795029', null, '', null, '成功', '访问项目评审', '用户访问日志', '4e849dfd35fd1b50bf6116347480d8fa');
INSERT INTO `oplog` VALUES ('T2C4D821C3BAD443B812F6A34', '专家1(1)', '0.0.0.0', '1554795267', null, '', null, '成功', '访问项目评审', '用户访问日志', '8ab4305645c253946f4b054ee739a91a');
INSERT INTO `oplog` VALUES ('T77E05D79059F4B51B1F54033', '专家1(1)', '0.0.0.0', '1554795459', null, '', null, '成功', '访问项目评审', '用户访问日志', '1d172d72391da66755f4a02e46cd7a88');
INSERT INTO `oplog` VALUES ('T3AADD7DF90BE4BD7B570901C', '专家1(1)', '0.0.0.0', '1554795502', null, '', null, '成功', '访问项目评审', '用户访问日志', '421b58dec8ab7828746c467689b1a25a');
INSERT INTO `oplog` VALUES ('T2A2E5B8BCC274B1CAF127506', '专家1(1)', '0.0.0.0', '1554795548', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e0c9dea0df349cd0d1d4e0a8ef3cc9ad');
INSERT INTO `oplog` VALUES ('T493AED24AB064B4BB02520DB', '专家1(1)', '0.0.0.0', '1554795822', null, '', null, '成功', '访问项目评审', '用户访问日志', 'be3ae483eec6c21b9061875d09c7e504');
INSERT INTO `oplog` VALUES ('TF1214A16C6DD4EF79FF4A691', '专家1(1)', '0.0.0.0', '1554795846', null, '', null, '成功', '访问项目评审', '用户访问日志', '70f4496b0d62b8fdbf6811388be4057f');
INSERT INTO `oplog` VALUES ('TB6C49B4273CA462283F0ADCC', '专家1(1)', '0.0.0.0', '1554795905', null, '', null, '成功', '访问项目评审', '用户访问日志', '502cdac20d2e966f1389c598aab0d76f');
INSERT INTO `oplog` VALUES ('T79647E7C611647C5A09133F1', '专家1(1)', '0.0.0.0', '1554796058', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f151b1b57278930c2d2c9266944b1f81');
INSERT INTO `oplog` VALUES ('TDA4BF1F84F494F2DABFCDD21', '专家1(1)', '0.0.0.0', '1554796094', null, '', null, '成功', '访问项目评审', '用户访问日志', '85c0f29f906de122574d3fd66a1b6ef9');
INSERT INTO `oplog` VALUES ('T6D49CAC4A2FD4C41A627E1CC', '专家1(1)', '0.0.0.0', '1554796138', null, '', null, '成功', '访问项目评审', '用户访问日志', '0c28c92040fd60517af43de23b4720b5');
INSERT INTO `oplog` VALUES ('TDE60D9F26FDD48C1BAAB6F75', '专家1(1)', '0.0.0.0', '1554796241', null, '', null, '成功', '访问项目评审', '用户访问日志', '637d97e78cd726e1c0df6088a409e611');
INSERT INTO `oplog` VALUES ('TD8AFE7FA6F594280A3756B86', '专家1(1)', '0.0.0.0', '1554796474', null, '', null, '成功', '访问项目评审', '用户访问日志', '202f4c3a3e2c31b4b569459a26d1f88e');
INSERT INTO `oplog` VALUES ('T638EF950519944719496F914', '专家1(1)', '0.0.0.0', '1554796515', null, '', null, '成功', '访问项目评审', '用户访问日志', '994a64ff0ccb1e496b4567eef02f5dd6');
INSERT INTO `oplog` VALUES ('T2C784F6B079C47D9B27BC4C1', '专家1(1)', '0.0.0.0', '1554796535', null, '', null, '成功', '访问项目评审', '用户访问日志', 'dc8456dc95d418445c02c8ad08add3c2');
INSERT INTO `oplog` VALUES ('TFFB1E82C34344FDBB4A60F65', '专家1(1)', '0.0.0.0', '1554796554', null, '', null, '成功', '访问项目评审', '用户访问日志', '97bd39fac494004fcda87f3f96c815a8');
INSERT INTO `oplog` VALUES ('T82627ED9DF014AAFB030D408', '系统管理员(sysadmin)', '0.0.0.0', '1554796572', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TFB585852378C4EB9A268FE63', '系统管理员(sysadmin)', '0.0.0.0', '1554796575', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b96c812c8098e7308c20f16ba03e99af');
INSERT INTO `oplog` VALUES ('T6FCE4A04139A4D99BB98416A', '专家1(1)', '0.0.0.0', '1554796588', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TFCEF724B4F6445049E37AE45', '专家1(1)', '0.0.0.0', '1554796588', null, '', null, '成功', '访问项目评审', '用户访问日志', '01a13aaa22a843e2bc1a98d0f4074c95');
INSERT INTO `oplog` VALUES ('T49EB5B1C560742CC8B117214', '专家1(1)', '0.0.0.0', '1554797132', null, '', null, '成功', '访问项目评审', '用户访问日志', '95f8ad7c34947bdf5453b7520804769f');
INSERT INTO `oplog` VALUES ('T688172ABCC274C7D8C9B1CCE', '专家1(1)', '0.0.0.0', '1554797163', null, '', null, '成功', '访问项目评审', '用户访问日志', 'd2fcc779245cab0d0fa541a9f16c4eca');
INSERT INTO `oplog` VALUES ('TA2997CB61C624FFDBD2FF66F', '专家1(1)', '0.0.0.0', '1554797217', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a360562af252b6d9036ddd8f3df778e1');
INSERT INTO `oplog` VALUES ('TF253A78CCF644CD39B79378F', '专家1(1)', '0.0.0.0', '1554797246', null, '', null, '成功', '访问项目评审', '用户访问日志', '13da744edda8094275774956850a8587');
INSERT INTO `oplog` VALUES ('T41FD5E16B6C643E882EEFFC7', '专家1(1)', '0.0.0.0', '1554797271', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fd78a5aaa45606b39434745be038d563');
INSERT INTO `oplog` VALUES ('TCD909D9CEAF84F88AE2D1E30', '专家1(1)', '0.0.0.0', '1554797413', null, '', null, '成功', '访问项目评审', '用户访问日志', '80778210c9aaf70dd817a9700e3c2276');
INSERT INTO `oplog` VALUES ('T3DC7C46E2550405D888276FF', '专家1(1)', '0.0.0.0', '1554797459', null, '', null, '成功', '访问项目评审', '用户访问日志', '02a9a57dc02773e4eb9c1b434059468a');
INSERT INTO `oplog` VALUES ('TA6C131A6EA09462E95F1BE37', '系统管理员(sysadmin)', '0.0.0.0', '1554797469', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TAA6B346DA72A4DF081ED5164', '系统管理员(sysadmin)', '0.0.0.0', '1554797471', null, '', null, '成功', '访问评分统计', '用户访问日志', 'a0c97d1d71fb6abbbb9b97d2ada1105c');
INSERT INTO `oplog` VALUES ('T531D751C0C4E451AA2FBA3BF', '专家1(1)', '0.0.0.0', '1554797480', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T90E0378A2C5141679BA7722F', '专家1(1)', '0.0.0.0', '1554797481', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e3e973e319630b6e37530d2f9ed4f904');
INSERT INTO `oplog` VALUES ('T6DD2328AF1FC47AB8AF0B475', '专家1(1)', '0.0.0.0', '1554797503', null, '', null, '成功', '访问项目评审', '用户访问日志', '737960ea694550ea39e8bcb6e9471eaa');
INSERT INTO `oplog` VALUES ('TCBC806124D4544B3A6DF96D1', '系统管理员(sysadmin)', '0.0.0.0', '1554797564', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T208B2938E3D74700B86DD777', '系统管理员(sysadmin)', '0.0.0.0', '1554797566', null, '', null, '成功', '访问评分统计', '用户访问日志', '7eee7c0a127fe42ac61ac749f3a48d49');
INSERT INTO `oplog` VALUES ('T1E3B5867343C4BF19D869D35', '专家1(1)', '0.0.0.0', '1554797576', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE95A7EA7A62144D29C504B42', '专家1(1)', '0.0.0.0', '1554797577', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f247ae596ce483bc406faa865c837ed2');
INSERT INTO `oplog` VALUES ('T61F04838F70641DDA3FE9836', '专家1(1)', '0.0.0.0', '1554797862', null, '', null, '成功', '访问项目评审', '用户访问日志', 'f8f082d657ccc7fff8a6ec3ea21a85bc');
INSERT INTO `oplog` VALUES ('T93EDF03F16B5436FAA744B88', '专家1(1)', '0.0.0.0', '1554797931', null, '', null, '成功', '访问项目评审', '用户访问日志', '01c2f5e39476d70ad9febee306285def');
INSERT INTO `oplog` VALUES ('T40CB940E216E4E2FAA766C7F', '系统管理员(sysadmin)', '0.0.0.0', '1554797940', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TEE5B3C3A64634B7A8EEAAF39', '系统管理员(sysadmin)', '0.0.0.0', '1554797942', null, '', null, '成功', '访问投票统计', '用户访问日志', 'aa79ac27cf77cf5ba4ec8627973cdde3');
INSERT INTO `oplog` VALUES ('TE9AA40D3A39D4F6F900E4840', '系统管理员(sysadmin)', '0.0.0.0', '1554797953', null, '', null, '成功', '访问明细查询', '用户访问日志', '383ef123e89accd484c45c5824ebf942');
INSERT INTO `oplog` VALUES ('T5830004D45214EDE81CF7A31', '专家2(2)', '0.0.0.0', '1554797974', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T5B2374FFF1F345D3A05B2691', '专家2(2)', '0.0.0.0', '1554797974', null, '', null, '成功', '访问项目评审', '用户访问日志', '343391baf17bb56dafe8685bf7aed56d');
INSERT INTO `oplog` VALUES ('TFEF66E02D7F546B0AE834183', '专家2(2)', '0.0.0.0', '1554797977', null, '', null, '成功', '访问项目评审', '用户访问日志', '0d2af54a265095a0a59743d5128ee21e');
INSERT INTO `oplog` VALUES ('T7C6C62C052004064B9C61414', '系统管理员(sysadmin)', '0.0.0.0', '1554798351', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6B100799680F4D459440C002', '系统管理员(sysadmin)', '0.0.0.0', '1554798356', null, '', null, '成功', '访问评分统计', '用户访问日志', 'eb7734ae72461b68241f6c396680540a');
INSERT INTO `oplog` VALUES ('T651F9ABBE9244A1DBC9DD0EE', '专家1(1)', '0.0.0.0', '1554798368', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T2DFB2BD5617D4182A13E850B', '专家1(1)', '0.0.0.0', '1554798368', null, '', null, '成功', '访问项目评审', '用户访问日志', '43547db210e7f04c84ade48ad48144bc');
INSERT INTO `oplog` VALUES ('T6856B9AA354D428D96CAB8EA', '系统管理员(sysadmin)', '0.0.0.0', '1554798383', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCD37BA77217244EB96F9C8AE', '系统管理员(sysadmin)', '0.0.0.0', '1554798385', null, '', null, '成功', '访问投票统计', '用户访问日志', '959793330907984c0b6a60ce29925d6d');
INSERT INTO `oplog` VALUES ('T4806EBEAA8AD4BC3931C94BA', '系统管理员(sysadmin)', '0.0.0.0', '1554798385', null, '', null, '成功', '访问评分统计', '用户访问日志', '1dc37db65e88642f46d3c20197dfaa7b');
INSERT INTO `oplog` VALUES ('TDD51A8C5D96D4D5CAB58D158', '专家1(1)', '0.0.0.0', '1554798394', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T29245CCEED314061B98F9316', '专家1(1)', '0.0.0.0', '1554798395', null, '', null, '成功', '访问项目评审', '用户访问日志', 'efc2994f0a44872bd81baf969f9349b3');
INSERT INTO `oplog` VALUES ('TF896B79BBB204F9FB5756572', '专家1(1)', '0.0.0.0', '1554798410', null, '', null, '成功', '访问项目评审', '用户访问日志', '68a51db5ddca99bedc613c2b66262550');
INSERT INTO `oplog` VALUES ('T93008AD627ED43CEAB1C8B25', '系统管理员(sysadmin)', '0.0.0.0', '1554798427', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T6C4DECDBCAB34E7DB28EE5DB', '系统管理员(sysadmin)', '0.0.0.0', '1554798429', null, '', null, '成功', '访问投票统计', '用户访问日志', '2b084b5acea17cf03698f93faf05f91b');
INSERT INTO `oplog` VALUES ('T38D647669CA3461C8EBF69F3', '专家1(1)', '0.0.0.0', '1554798455', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA3F108064B8B4BE99B8B2343', '专家1(1)', '0.0.0.0', '1554798455', null, '', null, '成功', '访问项目评审', '用户访问日志', '9f9713b4b962781b62b6345fac177e99');
INSERT INTO `oplog` VALUES ('T8B558D7BACD24C2C81878D21', '系统管理员(sysadmin)', '0.0.0.0', '1554798477', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7303478C094A4F2680D75C99', '系统管理员(sysadmin)', '0.0.0.0', '1554798478', null, '', null, '成功', '访问评分统计', '用户访问日志', 'f6e9b093a1554d14d31025ff5fe8051b');
INSERT INTO `oplog` VALUES ('TDB74C5A55727465EB7D31626', '系统管理员(sysadmin)', '0.0.0.0', '1554798480', null, '', null, '成功', '访问评分统计', '用户访问日志', 'b6c379575695d4b5605e488eeddfdd25');
INSERT INTO `oplog` VALUES ('T7CAF2163CA7143F994B0CE52', '系统管理员(sysadmin)', '0.0.0.0', '1554798493', null, '', null, '成功', '访问评分统计', '用户访问日志', 'd4c617ab26a558e63bf46b6634ea4500');
INSERT INTO `oplog` VALUES ('T6A1E21B66DE54F03B5F12AB8', '系统管理员(sysadmin)', '0.0.0.0', '1554798512', null, '', null, '成功', '访问评分统计', '用户访问日志', '3517ade57afdbe7407be45ae5a3cb116');
INSERT INTO `oplog` VALUES ('TB4F23A8E54EB48539593198D', '系统管理员(sysadmin)', '0.0.0.0', '1554798514', null, '', null, '成功', '访问评分统计', '用户访问日志', '839d0e706470c3c90443becb12018ed1');
INSERT INTO `oplog` VALUES ('T3FF027E9DB0345D28143B8E5', '系统管理员(sysadmin)', '0.0.0.0', '1554798516', null, '', null, '成功', '访问投票统计', '用户访问日志', '6d896af38d8fcac098320797d3e6026f');
INSERT INTO `oplog` VALUES ('T5FFAB2D647FB4A62A16A4B81', '系统管理员(sysadmin)', '0.0.0.0', '1554798532', null, '', null, '成功', '访问投票统计', '用户访问日志', '4ec7fdc13dfa73df84c82514a9c0ec85');
INSERT INTO `oplog` VALUES ('T718A7F41F2064F15BDDD0E73', '系统管理员(sysadmin)', '0.0.0.0', '1554798538', null, '', null, '成功', '访问评分统计', '用户访问日志', '553458830fbcfe6bd8ccf0b88d0e3703');
INSERT INTO `oplog` VALUES ('T4ECFFDF1288646F8BE25998C', '系统管理员(sysadmin)', '0.0.0.0', '1554798540', null, '', null, '成功', '访问投票统计', '用户访问日志', 'd8d088cb934052f974b10fb1a8119218');
INSERT INTO `oplog` VALUES ('TB3568DD6B43648939D882C0C', '系统管理员(sysadmin)', '0.0.0.0', '1554798547', null, '', null, '成功', '访问投票统计', '用户访问日志', 'dde8145737b77d3c29d0e308b2608fbb');
INSERT INTO `oplog` VALUES ('T41806ACDDDC147EEBC7FF157', '专家1(1)', '0.0.0.0', '1554798657', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TA9D8FB9BA94342F3AF0EC7BF', '专家1(1)', '0.0.0.0', '1554798658', null, '', null, '成功', '访问项目评审', '用户访问日志', 'fe5e652f33eba04a887bd2350dae2c1b');
INSERT INTO `oplog` VALUES ('T145E492E025F4B478ADEB872', '专家1(1)', '0.0.0.0', '1554798716', null, '', null, '成功', '访问项目评审', '用户访问日志', '28e30d8e3fd60c3c14a9bb70571cd357');
INSERT INTO `oplog` VALUES ('TC33343BB4B7141CB9EE31401', '专家3(3)', '0.0.0.0', '1554798737', null, '', null, '成功', '账号(3)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TE0517748FE6248AC8E5A2347', '专家3(3)', '0.0.0.0', '1554798737', null, '', null, '成功', '访问项目评审', '用户访问日志', 'acd571d64fe94eefe8965046094ac1cc');
INSERT INTO `oplog` VALUES ('T8741375BCED341F8AE26EE5F', '专家3(3)', '0.0.0.0', '1554798773', null, '', null, '成功', '访问项目评审', '用户访问日志', '6c92d1e4f332288d4b125798db7f738a');
INSERT INTO `oplog` VALUES ('T3908237C44784A548920857F', '系统管理员(sysadmin)', '0.0.0.0', '1554798908', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T622922A89DB04BE1A0C548FF', '系统管理员(sysadmin)', '0.0.0.0', '1554798909', null, '', null, '成功', '访问评分统计', '用户访问日志', '9e33bde725c201e74c5c80264522c076');
INSERT INTO `oplog` VALUES ('TBA3DA7B1C1294533A43C2CE5', '专家2(2)', '0.0.0.0', '1554798917', null, '', null, '成功', '账号(2)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T115CC0973826456A8F26AC97', '专家2(2)', '0.0.0.0', '1554798918', null, '', null, '成功', '访问项目评审', '用户访问日志', '48135f04cf86f558cf35d76f0cded3ef');
INSERT INTO `oplog` VALUES ('TCC97BB4F678D4AB7B5AF2685', '专家2(2)', '0.0.0.0', '1554798954', null, '', null, '成功', '访问项目评审', '用户访问日志', 'a15f959f46fa8a8e60ce057fc1cccdc9');
INSERT INTO `oplog` VALUES ('TA7D49AA982574611B8A868BA', '系统管理员(sysadmin)', '0.0.0.0', '1554799078', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T4A88799CFA124707A9253496', '系统管理员(sysadmin)', '0.0.0.0', '1554799104', null, '', null, '成功', '访问评分统计', '用户访问日志', '720342e65f591abda4383e3bb107cff9');
INSERT INTO `oplog` VALUES ('T5A621B963B684AAB802B8617', '系统管理员(sysadmin)', '0.0.0.0', '1554799105', null, '', null, '成功', '访问投票统计', '用户访问日志', '35f1fa4ac2cb3c16c24bb32e52720e9a');
INSERT INTO `oplog` VALUES ('TE929363AF1684E6C8F2E03FA', '系统管理员(sysadmin)', '0.0.0.0', '1554799159', null, '', null, '成功', '访问评分统计', '用户访问日志', '84c59ea99730a77b305e27b3e9036774');
INSERT INTO `oplog` VALUES ('TD7869389F82040CABE62EE7D', '专家1(1)', '0.0.0.0', '1554799169', null, '', null, '成功', '账号(1)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('TCB7C901D7D6E4A848F0EF331', '专家1(1)', '0.0.0.0', '1554799170', null, '', null, '成功', '访问项目评审', '用户访问日志', 'e942d1b576099ee66a41b74b04ae2c77');
INSERT INTO `oplog` VALUES ('T7B8D003612B14F1FAEFBE584', '系统管理员(sysadmin)', '0.0.0.0', '1554799262', null, '', null, '成功', '账号(sysadmin)登录', '用户登录日志', null);
INSERT INTO `oplog` VALUES ('T7360BB3E371E4A1D814FEF0E', '系统管理员(sysadmin)', '0.0.0.0', '1554799266', null, '', null, '成功', '访问明细查询', '用户访问日志', 'bb35e8f702c45cf5868c3ac779053c10');
INSERT INTO `oplog` VALUES ('T1649B6AFE4784DAE8D08C953', '系统管理员(sysadmin)', '0.0.0.0', '1554799272', null, '', null, '成功', '访问明细查询', '用户访问日志', 'a8f172db2c0896f1e59d8da8f2fb77be');
INSERT INTO `oplog` VALUES ('T71CC2C9CCA9B403AB84F1DE3', '系统管理员(sysadmin)', '0.0.0.0', '1554799717', null, '', null, '成功', '访问明细查询', '用户访问日志', '33afb9a2f00abdfcf4b3621330b6442c');
INSERT INTO `oplog` VALUES ('T49F3B36394B5477E993023FF', '系统管理员(sysadmin)', '0.0.0.0', '1554799848', null, '', null, '成功', '访问明细查询', '用户访问日志', '99829fa234b7f229899c6310ce5083f0');

-- ----------------------------
-- Table structure for roleauth
-- ----------------------------
DROP TABLE IF EXISTS `roleauth`;
CREATE TABLE `roleauth` (
  `ra_id` varchar(100) NOT NULL,
  `ra_roleid` varchar(100) DEFAULT NULL,
  `ra_miid` varchar(100) DEFAULT NULL,
  `ra_createtime` varchar(100) DEFAULT NULL,
  `ra_createuser` varchar(100) DEFAULT NULL,
  `ra_lastmodifytime` varchar(100) DEFAULT NULL,
  `ra_lastmodifyuser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roleauth
-- ----------------------------
INSERT INTO `roleauth` VALUES ('T0A5E41DDA1304400BF97BA22', '1', 'TB1F58C240D2A4C47AD58E377', '1528967243', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('T0AE33FD423C445478A1E23E4', '', 'T97BE16E9CDEA42E49F719D76', '1552533155', 'safe', null, null);
INSERT INTO `roleauth` VALUES ('T1B48D9EADA7C4C7FBA367FED', '3', 'TD6B35D17E00D45A8805FEA79', '1528354759', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('T34FA869FC9C942BCB1DEAEE1', 'TCAAB0FF33F1D45348204EB46', 'TE7FC3A0E1FA54D4DAE429497', '1528355698', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('T47C3F8EBFE1F4CB6B33D6C15', '3', 'T73ED91364FC84B81979F3FC0', '1528356339', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('T47FFBC8AE1994A1AB14AF0A6', 'TCAAB0FF33F1D45348204EB46', 'T0EE42FEACC26401D8935EBA6', '1552352398', 'safe', null, null);
INSERT INTO `roleauth` VALUES ('T4998556F2D1F44AAB5532B4F', 'TCAAB0FF33F1D45348204EB46', 'T6E10703BB0B34742A58F6B3B', '1552352389', 'safe', null, null);
INSERT INTO `roleauth` VALUES ('T6D36C7E7DD1845BE863817DC', '1', 'T25CEB0646ADA4EC4ACDDA253', '1552352589', 'safe', null, null);
INSERT INTO `roleauth` VALUES ('T7EAC2BE133084ED193EF50CB', '', 'T8A86398AC5FC4F39944FDBA1', '1528355293', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('T9F441B2ADD31470184863E7C', '3', 'T8FF84931BD364BB6B0D5FD5C', '1528436064', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TA4777F9CB90544E9A2EBF77D', '3', 'T3A62E07E49B94413BF9C8E5E', '1528354752', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TB08B00E0990340E9B7BD32AF', '1', 'T6CBD13D50B8B4DF5946A29CE', '1528356375', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TB3B51452804F405591B09879', '1', 'T2857459C8ACA4AF18ACEA755', '1528418423', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TCC20A141DD7F4C82A68E6F49', '', 'T94277F330BAE48E0AE1C9BFA', '1528355281', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TD3D455415853482DA1C4AB32', '3', 'T68588C53EC674BB389EFE3BB', '1528355827', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TE256462534EB4EFA82B45FFE', '1', 'TBBEE81C030EA4D529920AAE8', '1528418433', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TE9C0B313BB3248A883E875F5', '1', 'TDD1FDBBBAF1049AA955054E1', '1552352581', 'safe', null, null);
INSERT INTO `roleauth` VALUES ('TEA545AF7035F43D6BB10214D', '1', 'TF250F0BCDF5D42F8AAF5802C', '1528355691', 'safe', '', '');
INSERT INTO `roleauth` VALUES ('TF690FFDF86C14E2486FA7313', '3', 'TD2E907966B824F72ACE07E55', '1528436061', 'safe', '', '');

-- ----------------------------
-- Table structure for sysconfig
-- ----------------------------
DROP TABLE IF EXISTS `sysconfig`;
CREATE TABLE `sysconfig` (
  `sc_id` varchar(100) NOT NULL,
  `sc_itemname` varchar(200) DEFAULT NULL,
  `sc_itemvalue` varchar(100) DEFAULT NULL,
  `sc_itemcode` varchar(200) DEFAULT NULL,
  `sc_itemtype` varchar(100) DEFAULT NULL,
  `sc_itemclass` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sysconfig
-- ----------------------------
INSERT INTO `sysconfig` VALUES ('1', '密码复杂度检测', '0', 'SEC_PWDCHECK', '0', '保密配置');
INSERT INTO `sysconfig` VALUES ('2', '超时登录（时间）', '600', 'SEC_LOGINTIMEOUTTIME', '1', '保密配置');
INSERT INTO `sysconfig` VALUES ('3', '七天修改密码', '0', 'SEC_CHANGEPWD', '0', '保密配置');
INSERT INTO `sysconfig` VALUES ('4', '超时登录（检测）', '0', 'SEC_LOGINTIMEOUTCHECK', '0', '保密配置');
INSERT INTO `sysconfig` VALUES ('5', '系统LOGO', '总体部职称评审系统', 'SYS_LOGO', null, '系统配置');
INSERT INTO `sysconfig` VALUES ('6', '系统名称', '总体部职称评审系统', 'SYS_NAME', null, '系统配置');
INSERT INTO `sysconfig` VALUES ('7', '背景图', null, 'SYS_BGIMG', null, '系统配置');
INSERT INTO `sysconfig` VALUES ('8', '安全管理员被锁定时长', '1800', 'SEC_LOCKTIME', null, '保密配置');
INSERT INTO `sysconfig` VALUES ('9', '系统是否涉密', '0', 'SEC_ISSECRET', null, '系统配置');

-- ----------------------------
-- Table structure for sysrole
-- ----------------------------
DROP TABLE IF EXISTS `sysrole`;
CREATE TABLE `sysrole` (
  `role_id` varchar(100) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_createtime` varchar(100) DEFAULT NULL,
  `role_createuser` varchar(100) DEFAULT NULL,
  `role_lastmodifytime` varchar(100) DEFAULT NULL,
  `role_lastmodifyuser` varchar(100) DEFAULT NULL,
  `role_isdefault` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sysrole
-- ----------------------------
INSERT INTO `sysrole` VALUES ('TCAAB0FF33F1D45348204EB46', '专家', '1528110552', 'system', '1528349453', 'system', '否');
INSERT INTO `sysrole` VALUES ('2', '审计管理员', null, null, null, null, '否');
INSERT INTO `sysrole` VALUES ('3', '安全管理员', null, null, null, null, '否');
INSERT INTO `sysrole` VALUES ('1', '系统管理员', null, null, null, null, '否');

-- ----------------------------
-- Table structure for sysuser
-- ----------------------------
DROP TABLE IF EXISTS `sysuser`;
CREATE TABLE `sysuser` (
  `user_id` varchar(100) NOT NULL,
  `user_realusername` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_role` varchar(100) DEFAULT NULL,
  `user_secretlevel` varchar(100) DEFAULT NULL,
  `user_orgid` varchar(100) DEFAULT NULL,
  `user_enable` varchar(100) DEFAULT NULL,
  `user_issystem` varchar(100) DEFAULT NULL,
  `user_secretlevelcode` varchar(100) DEFAULT NULL,
  `user_firstuse` varchar(100) DEFAULT NULL,
  `user_passwordlastmodifytime` varchar(100) DEFAULT NULL,
  `user_passworderrornum` varchar(100) DEFAULT NULL,
  `user_passworderrortime` varchar(100) DEFAULT NULL,
  `user_createtime` varchar(100) DEFAULT NULL,
  `user_createuser` varchar(100) DEFAULT NULL,
  `user_lastmodifytime` varchar(100) DEFAULT NULL,
  `user_lastmodifyuser` varchar(100) DEFAULT NULL,
  `user_frozentime` int(11) DEFAULT '0',
  `user_isdelete` varchar(100) DEFAULT '0',
  `user_iszj` varchar(100) DEFAULT NULL,
  `user_sid` varchar(100) DEFAULT NULL,
  `user_class` varchar(100) DEFAULT NULL,
  `user_zhiwu` varchar(100) DEFAULT NULL,
  `user_zhicheng` varchar(100) DEFAULT NULL,
  `user_mobile` varchar(100) DEFAULT NULL,
  `user_sessionid` varchar(100) DEFAULT NULL,
  `user_ip` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sysuser
-- ----------------------------
INSERT INTO `sysuser` VALUES ('system', '系统管理员', 'sysadmin', '1', '1', '绝密', null, '启用', '是', null, null, null, '0', '1533693455', null, null, '1528354890', 'safe', '1528348089', '0', null, null, null, null, null, null, '0johvgfeipcbmu36lsa1u6s2so', '::1');
INSERT INTO `sysuser` VALUES ('audit', '审计管理员', 'auditadmin', '1', '2', '绝密', null, '启用', '是', '07b3c32099f3f28b0a9c92ae6dd035e3', '否', null, '0', '1526548169', null, null, '1526548202', 'audit', '1525913729', '0', null, null, null, null, null, null, '', '::1');
INSERT INTO `sysuser` VALUES ('safe', '安全管理员', 'secadmin', 'Guanli2018', '3', '绝密', null, '启用', '是', '61f88b780aa1682ed6d1545d69c9d0b9', '否', null, '0', '1528626025', null, null, '1528110584', 'safe', null, '0', null, null, null, null, null, null, '', '::1');
INSERT INTO `sysuser` VALUES ('T92FEDFF8454A4F7D9D4FDA98', '专家1', '1', '1', 'TCAAB0FF33F1D45348204EB46', null, '单位1', '启用', '否', null, null, null, '0', null, '1552352165', 'system', null, null, '0', '0', null, null, '制造', '院士', null, '88888888', '', '::1');
INSERT INTO `sysuser` VALUES ('T8D61E19283FC46D8A8AA775E', '专家2', '2', '1', 'TCAAB0FF33F1D45348204EB46', null, '单位2', '启用', '否', null, null, null, '0', null, '1552352165', 'system', null, null, '0', '0', null, null, '制造', '院士', null, '88888889', '', '::1');
INSERT INTO `sysuser` VALUES ('TD246ADA4F7FA404EB6244B96', '专家3', '3', '1', 'TCAAB0FF33F1D45348204EB46', null, '单位3', '启用', '否', null, null, null, '0', null, '1552352165', 'system', null, null, '0', '0', null, null, '制造', '院士', null, '88888890', '', '::1');
INSERT INTO `sysuser` VALUES ('T0CBF596EEC0D4487B4A6CB84', '专家4', '4', '1', 'TCAAB0FF33F1D45348204EB46', null, '单位4', '启用', '否', null, null, null, '0', null, '1552352165', 'system', null, null, '0', '0', null, null, '制造', '院士', null, '88888891', '', '::1');
INSERT INTO `sysuser` VALUES ('T83878552D7E2425CAA7B1BA9', '专家5', '5', '1', 'TCAAB0FF33F1D45348204EB46', null, '单位5', '启用', '否', null, null, null, '0', null, '1552352166', 'system', null, null, '0', '0', null, null, '制造', '院士', null, '88888892', '', '::1');

-- ----------------------------
-- Table structure for userauth
-- ----------------------------
DROP TABLE IF EXISTS `userauth`;
CREATE TABLE `userauth` (
  `ua_id` varchar(100) NOT NULL,
  `ua_roleid` varchar(100) DEFAULT NULL,
  `ua_userid` varchar(100) DEFAULT NULL,
  `ua_createtime` varchar(100) DEFAULT NULL,
  `ua_createuser` varchar(100) DEFAULT NULL,
  `ua_lastmodifytime` varchar(100) DEFAULT NULL,
  `ua_lastmodifyuser` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ua_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of userauth
-- ----------------------------
INSERT INTO `userauth` VALUES ('safe', '3', 'safe', null, null, null, null);
INSERT INTO `userauth` VALUES ('system', '1', 'system', null, null, null, null);
INSERT INTO `userauth` VALUES ('T67BAF5FC13DB4CB5BFEDEBB9', 'TCAAB0FF33F1D45348204EB46', 'TD246ADA4F7FA404EB6244B96', '1552352165', null, null, null);
INSERT INTO `userauth` VALUES ('T79EEC9C93E1A45DAAA21BB4E', 'TCAAB0FF33F1D45348204EB46', 'T92FEDFF8454A4F7D9D4FDA98', '1552352165', null, null, null);
INSERT INTO `userauth` VALUES ('TE23112B613A641D89C1958C5', 'TCAAB0FF33F1D45348204EB46', 'T0CBF596EEC0D4487B4A6CB84', '1552352166', null, null, null);
INSERT INTO `userauth` VALUES ('TF09A78509B0E465E9CD6A8B1', 'TCAAB0FF33F1D45348204EB46', 'T8D61E19283FC46D8A8AA775E', '1552352165', null, null, null);
INSERT INTO `userauth` VALUES ('TF54E105CCF964AB9BDF0D7FA', 'TCAAB0FF33F1D45348204EB46', 'T83878552D7E2425CAA7B1BA9', '1552352166', null, null, null);

-- ----------------------------
-- Table structure for votesetting
-- ----------------------------
DROP TABLE IF EXISTS `votesetting`;
CREATE TABLE `votesetting` (
  `v_id` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL COMMENT '分组',
  `round` varchar(255) DEFAULT NULL COMMENT '第几轮',
  `maxnum` int(11) DEFAULT NULL COMMENT '最大投票数',
  `xmtype` varchar(255) DEFAULT NULL COMMENT '类别',
  `xmgroup` varchar(255) DEFAULT NULL COMMENT '小组',
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of votesetting
-- ----------------------------
INSERT INTO `votesetting` VALUES ('T4AFDD5610B44407581B7C810', '制造', '1', '2', '军队', null, '0');
INSERT INTO `votesetting` VALUES ('T605CA5B1BA844209B27403B1', '制造', '1', '1', '地方', null, '0');
INSERT INTO `votesetting` VALUES ('TA274447FC0D848C892EA8A87', '制造', '2', '1', '军队', null, '1');

-- ----------------------------
-- Table structure for xmps_xm
-- ----------------------------
DROP TABLE IF EXISTS `xmps_xm`;
CREATE TABLE `xmps_xm` (
  `xm_id` varchar(255) NOT NULL,
  `xm_code` varchar(255) DEFAULT NULL,
  `xm_name` varchar(255) DEFAULT NULL,
  `xm_company` varchar(255) DEFAULT NULL,
  `xm_createuser` varchar(255) DEFAULT NULL,
  `xm_class` varchar(255) DEFAULT NULL,
  `xm_year` decimal(8,0) DEFAULT NULL,
  `xm_status` varchar(255) DEFAULT NULL,
  `xm_tmfs` varchar(255) DEFAULT '',
  `xm_ordernum` int(10) DEFAULT '0' COMMENT '排序号',
  `xm_oldfenzu` varchar(255) DEFAULT NULL COMMENT '原分组',
  `xm_oldscore` decimal(8,2) DEFAULT NULL COMMENT '原得分',
  `xm_oldrank` int(10) DEFAULT NULL COMMENT '原排名',
  `xm_oldcommand` varchar(1024) DEFAULT NULL COMMENT '原资助意见',
  `vote1option` varchar(8) DEFAULT '1' COMMENT '投票阶段可选',
  `vote2option` varchar(8) DEFAULT '0' COMMENT '投票阶段可选',
  `vote3option` varchar(8) DEFAULT '0' COMMENT '投票阶段可选',
  `vote4option` varchar(8) DEFAULT '0' COMMENT '投票阶段可选（差额投票）',
  `xm_type` varchar(255) DEFAULT NULL COMMENT '项目类别',
  `xm_group` varchar(255) DEFAULT NULL COMMENT '项目小组',
  PRIMARY KEY (`xm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xmps_xm
-- ----------------------------
INSERT INTO `xmps_xm` VALUES ('T37E34F91283D48398B80A091', 'xm008', 'name008', '单位008', '8', '制造', '2019', '正常', '专家推荐', '1', '1', '88.00', '8', null, '1', '0', '0', '0', '地方', '下');
INSERT INTO `xmps_xm` VALUES ('T384D0786173E4A3699BE5EF6', '编号001', '项目001', '单位001', '申请人001', '制造', '2019', '正常', '专家推荐', '8', '制造', '90.00', '1', '通过', '1', '1', '0', '0', '军队', '航空');
INSERT INTO `xmps_xm` VALUES ('T4B3534C2FB7049EE9AD51894', '编号004', '项目004', '单位004', '申请人004', '制造', '2019', '正常', '专家推荐', '6', '制造', '90.00', '4', '通过', '1', '0', '0', '0', '军队', '航空');
INSERT INTO `xmps_xm` VALUES ('T685E65420691495C977C0677', '编号005', '项目005', '单位005', '申请人005', '制造', '2019', '正常', '专家推荐', '2', '制造', '90.00', '5', '通过', '1', '0', '0', '0', '地方', '航空');
INSERT INTO `xmps_xm` VALUES ('T79D7609B18B749998FB8804D', 'xm007', 'name007', '单位007', '7', '制造', '2019', '正常', '专家推荐', '4', '1', '77.00', '7', null, '1', '1', '0', '0', '军队', '上');
INSERT INTO `xmps_xm` VALUES ('T902910E2D08F4C86B8BC06D2', '编号006', '项目006', '单位006', '申请人006', '制造', '2019', '正常', '专家推荐', '7', '制造', '90.00', '6', '通过', '1', '0', '0', '0', '地方', '航空');
INSERT INTO `xmps_xm` VALUES ('TDB02CE35923C4647A54B6681', '编号002', '项目002', '单位002', '申请人002', '制造', '2019', '正常', '专家推荐', '3', '制造', '90.00', '2', '通过', '1', '1', '0', '0', '军队', '航空');
INSERT INTO `xmps_xm` VALUES ('TE1CC1FBAAE434FBC92469560', '编号003', '项目003', '单位003', '申请人003', '制造', '2019', '正常', '专家推荐', '5', '制造', '90.00', '3', '通过', '1', '0', '0', '0', '军队', '航空');

-- ----------------------------
-- Table structure for xmps_xmrelation
-- ----------------------------
DROP TABLE IF EXISTS `xmps_xmrelation`;
CREATE TABLE `xmps_xmrelation` (
  `xr_id` varchar(255) DEFAULT NULL,
  `xr_user_id` varchar(50) NOT NULL,
  `xr_xm_id` varchar(50) NOT NULL,
  `xr_status` varchar(255) DEFAULT NULL,
  `ps_cj` decimal(8,0) DEFAULT NULL,
  `ps_ql` decimal(8,0) DEFAULT NULL,
  `ps_jz` decimal(8,0) DEFAULT NULL,
  `ps_cx` decimal(8,0) DEFAULT NULL,
  `ps_zz` varchar(255) DEFAULT NULL,
  `ps_detail` varchar(500) DEFAULT NULL,
  `ps_time` varchar(255) DEFAULT NULL,
  `ps_total` decimal(8,0) DEFAULT NULL,
  `ishuibi` varchar(255) DEFAULT NULL,
  `vote1` varchar(8) DEFAULT NULL COMMENT '投票结果',
  `vote2` varchar(8) DEFAULT NULL COMMENT 'maxNum1',
  `vote3` varchar(8) DEFAULT NULL COMMENT 'maxNum1',
  `vote4` varchar(8) DEFAULT NULL COMMENT '投票结果',
  `vote1status` varchar(255) DEFAULT '未开始' COMMENT '投票状态',
  `vote2status` varchar(255) DEFAULT '未开始' COMMENT '投票状态',
  `vote3status` varchar(255) DEFAULT '未开始' COMMENT '投票状态',
  `vote4status` varchar(255) DEFAULT '未开始' COMMENT '投票状态',
  `avgvalue` float(8,3) DEFAULT NULL,
  `vote1rate` float(8,3) DEFAULT NULL,
  `vote2rate` float(8,3) DEFAULT NULL,
  `vote3rate` float(8,3) DEFAULT NULL,
  `vote4rate` float(8,3) DEFAULT NULL,
  PRIMARY KEY (`xr_user_id`,`xr_xm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xmps_xmrelation
-- ----------------------------
INSERT INTO `xmps_xmrelation` VALUES ('TF4753DCA4A00489AA3EC2E4C', 'T0CBF596EEC0D4487B4A6CB84', 'T37E34F91283D48398B80A091', '完成', null, '35', '32', '18', '', null, null, '85', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '84.333', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T5858563693F94D30A061DB07', 'T0CBF596EEC0D4487B4A6CB84', 'T384D0786173E4A3699BE5EF6', '完成', null, '25', '29', '17', '', null, null, '71', '', null, null, null, null, '已完成', '进行中', '未开始', '未开始', '71.000', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TD13E9662E20E450A93C037B2', 'T0CBF596EEC0D4487B4A6CB84', 'T4B3534C2FB7049EE9AD51894', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '未开始', '未开始', '未开始', null, '33.333', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T573D543694CC43CD86FF14D9', 'T0CBF596EEC0D4487B4A6CB84', 'T685E65420691495C977C0677', '完成', null, '33', '31', '13', '', null, null, '77', '', '1', null, null, null, '已完成', '未开始', '未开始', '未开始', '74.333', '60.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T785D23D6567A495A82FA038E', 'T0CBF596EEC0D4487B4A6CB84', 'T79D7609B18B749998FB8804D', '完成', null, '33', '33', '14', '', null, null, '80', '', '1', null, null, null, '已完成', '进行中', '未开始', '未开始', '75.500', '66.667', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TB49A1180884043A195EC01CF', 'T0CBF596EEC0D4487B4A6CB84', 'T902910E2D08F4C86B8BC06D2', '完成', null, '27', '36', '17', '', null, null, '80', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '79.000', '20.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T7B80EDC99FB44030B20CEF3B', 'T0CBF596EEC0D4487B4A6CB84', 'TDB02CE35923C4647A54B6681', '完成', null, '26', '27', '13', '', null, null, '66', '', '1', null, null, null, '已完成', '进行中', '未开始', '未开始', '77.500', '75.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T6039E0998501425D84E02D87', 'T0CBF596EEC0D4487B4A6CB84', 'TE1CC1FBAAE434FBC92469560', '完成', null, '31', '32', '12', '', null, null, '75', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '75.000', '25.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TD88848BD603E4F2BAE33F535', 'T83878552D7E2425CAA7B1BA9', 'T37E34F91283D48398B80A091', '完成', null, '39', '25', '20', '', null, null, '84', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '84.333', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TA9670D5C31D842CA9B697964', 'T83878552D7E2425CAA7B1BA9', 'T384D0786173E4A3699BE5EF6', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '进行中', '未开始', '未开始', '71.000', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TB9A5092551834A00A8C19DA8', 'T83878552D7E2425CAA7B1BA9', 'T4B3534C2FB7049EE9AD51894', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '未开始', '未开始', '未开始', null, '33.333', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T836FD5348EE04FE49360BF21', 'T83878552D7E2425CAA7B1BA9', 'T685E65420691495C977C0677', '完成', null, '27', '26', '16', '', null, null, '69', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '74.333', '60.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T8A92779A4024463FAC480A5F', 'T83878552D7E2425CAA7B1BA9', 'T79D7609B18B749998FB8804D', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '进行中', '未开始', '未开始', '75.500', '66.667', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T52BE231548BE4AFD99B91A2F', 'T83878552D7E2425CAA7B1BA9', 'T902910E2D08F4C86B8BC06D2', '完成', null, '27', '28', '17', '', null, null, '72', '', '1', null, null, null, '已完成', '未开始', '未开始', '未开始', '79.000', '20.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TF655642E9A5B4CD1A700891E', 'T83878552D7E2425CAA7B1BA9', 'TDB02CE35923C4647A54B6681', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '进行中', '未开始', '未开始', '77.500', '75.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T6BA25F5D76D14D8CA758F787', 'T83878552D7E2425CAA7B1BA9', 'TE1CC1FBAAE434FBC92469560', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '未开始', '未开始', '未开始', '75.000', '25.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T658E56B91EFE413793C4F7C1', 'T8D61E19283FC46D8A8AA775E', 'T37E34F91283D48398B80A091', '完成', null, '27', '38', '19', '', null, null, '84', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '84.333', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T2CD850A7534B46E8A68F65F9', 'T8D61E19283FC46D8A8AA775E', 'T384D0786173E4A3699BE5EF6', '完成', null, '34', '25', '12', '', null, null, '71', '0', null, null, null, null, '已完成', '已完成', '未开始', '未开始', '71.000', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T6B57389FE8FD4BBD88D02D96', 'T8D61E19283FC46D8A8AA775E', 'T4B3534C2FB7049EE9AD51894', '完成', null, '35', '34', '16', '', null, null, '85', '0', null, null, null, null, '已完成', '已完成', '未开始', '未开始', null, '33.333', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T66F37C9EFAE6498C98D5F3E4', 'T8D61E19283FC46D8A8AA775E', 'T685E65420691495C977C0677', '完成', null, '28', '24', '12', '', null, null, '64', '0', '1', null, null, null, '已完成', '未开始', '未开始', '未开始', '74.333', '60.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TD01A75EB2A3449BAA6DDDC9B', 'T8D61E19283FC46D8A8AA775E', 'T79D7609B18B749998FB8804D', '完成', null, '25', '36', '17', '', null, null, '78', '', '1', '1', null, null, '已完成', '已完成', '未开始', '未开始', '75.500', '66.667', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T1BFF6310999E41E58128EC5E', 'T8D61E19283FC46D8A8AA775E', 'T902910E2D08F4C86B8BC06D2', '完成', null, '33', '33', '12', '', null, null, '78', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '79.000', '20.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T7DF3E8BDFDBC4B5394DC0C67', 'T8D61E19283FC46D8A8AA775E', 'TDB02CE35923C4647A54B6681', '完成', null, '34', '26', '14', '', null, null, '74', '0', '1', null, null, null, '已完成', '已完成', '未开始', '未开始', '77.500', '75.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TD7B441A8E3924718826A7BCD', 'T8D61E19283FC46D8A8AA775E', 'TE1CC1FBAAE434FBC92469560', '完成', null, '25', '27', '15', '', null, null, '67', '0', null, null, null, null, '已完成', '已完成', '未开始', '未开始', '75.000', '25.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TC457234558EE43579AF96C40', 'T92FEDFF8454A4F7D9D4FDA98', 'T37E34F91283D48398B80A091', '进行中', null, '31', '33', '15', '', null, null, '79', '0', null, '', '', '-1', '已完成', '未开始', '未开始', '未开始', '84.333', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T738E630F9C324F34A66CCA7B', 'T92FEDFF8454A4F7D9D4FDA98', 'T384D0786173E4A3699BE5EF6', '进行中', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '进行中', '已完成', '未开始', '未开始', '71.000', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T0060304988F140CA9C424951', 'T92FEDFF8454A4F7D9D4FDA98', 'T4B3534C2FB7049EE9AD51894', '进行中', null, '35', '35', '20', '', null, null, '90', '0', null, null, null, null, '进行中', '已完成', '未开始', '未开始', null, '33.333', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T951AF45C0BAE4D9088A67E91', 'T92FEDFF8454A4F7D9D4FDA98', 'T685E65420691495C977C0677', '进行中', null, '25', '37', '19', '', null, null, '81', '0', '1', null, null, null, '已完成', '未开始', '未开始', '未开始', '74.333', '60.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T53519CF163DE429684EBCB9D', 'T92FEDFF8454A4F7D9D4FDA98', 'T79D7609B18B749998FB8804D', '进行中', null, '26', '31', '16', '', null, null, '73', '0', '', null, '', '-1', '进行中', '已完成', '未开始', '未开始', '75.500', '66.667', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TE2FAF2D2970C45C9B0461F80', 'T92FEDFF8454A4F7D9D4FDA98', 'T902910E2D08F4C86B8BC06D2', '进行中', null, '33', '33', '13', '', null, null, '79', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '79.000', '20.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TBFFEC7C5804B48489B5C1A69', 'T92FEDFF8454A4F7D9D4FDA98', 'TDB02CE35923C4647A54B6681', '进行中', null, '35', '34', '12', '', null, null, '81', '0', null, '1', null, null, '进行中', '已完成', '未开始', '未开始', '77.500', '75.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T1673A689F59F42D28A5E9B3C', 'T92FEDFF8454A4F7D9D4FDA98', 'TE1CC1FBAAE434FBC92469560', '进行中', null, '40', '34', '20', '', null, null, '94', '0', '1', null, null, null, '进行中', '已完成', '未开始', '未开始', '75.000', '25.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TECACC4BCD69E444EB0014CB9', 'TD246ADA4F7FA404EB6244B96', 'T37E34F91283D48398B80A091', '完成', null, '24', '35', '18', '', null, null, '77', '', null, null, null, null, '已完成', '未开始', '未开始', '未开始', '84.333', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TC741F18F277E4495B1D80D05', 'TD246ADA4F7FA404EB6244B96', 'T384D0786173E4A3699BE5EF6', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '进行中', '未开始', '未开始', '71.000', '0.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TC5859666445342739E5CA1CA', 'TD246ADA4F7FA404EB6244B96', 'T4B3534C2FB7049EE9AD51894', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '未开始', '未开始', '未开始', null, '33.333', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T6BE23E8F20024091B26A3015', 'TD246ADA4F7FA404EB6244B96', 'T685E65420691495C977C0677', '完成', null, '26', '37', '14', '', null, null, '77', '0', '', '', '', '-1', '已完成', '未开始', '未开始', '未开始', '74.333', '60.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TB7137EC8C0C048E883AEC7F6', 'TD246ADA4F7FA404EB6244B96', 'T79D7609B18B749998FB8804D', '完成', null, '25', '26', '17', '', null, null, '68', '', null, null, null, null, '已完成', '进行中', '未开始', '未开始', '75.500', '66.667', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TB2D6D5C340294563B4DE94EA', 'TD246ADA4F7FA404EB6244B96', 'T902910E2D08F4C86B8BC06D2', '完成', null, '33', '36', '20', '', null, null, '89', '0', '', '', '', '-1', '已完成', '未开始', '未开始', '未开始', '79.000', '20.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('T65991759840A455F8D5709DE', 'TD246ADA4F7FA404EB6244B96', 'TDB02CE35923C4647A54B6681', '完成', null, '29', '39', '19', '', null, null, '87', '0', '', '', '', '-1', '已完成', '进行中', '未开始', '未开始', '77.500', '75.000', null, null, null);
INSERT INTO `xmps_xmrelation` VALUES ('TECD984C829B2491F9AFAF4A4', 'TD246ADA4F7FA404EB6244B96', 'TE1CC1FBAAE434FBC92469560', '完成', null, '-1', '-1', '-1', '', null, null, '-1', '1', '-1', '-1', '-1', '-1', '已完成', '未开始', '未开始', '未开始', '75.000', '25.000', null, null, null);
