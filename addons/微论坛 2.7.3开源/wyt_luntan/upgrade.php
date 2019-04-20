<?php 
$sql="CREATE TABLE IF NOT EXISTS `ims_wyt_dayusms_base` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned DEFAULT NULL,
  `appkey` varchar(100) DEFAULT NULL,
  `secretKey` varchar(100) DEFAULT NULL,
  `format` varchar(100) DEFAULT NULL,
  `freesignname` varchar(100) DEFAULT NULL,
  `templatecode` varchar(100) DEFAULT NULL,
  `safetycode` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `display` int(11) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `title` varchar(32) NOT NULL COMMENT '广告标题',
  `images` text NOT NULL COMMENT '广告图片',
  `url` varchar(128) NOT NULL COMMENT '广告链接',
  `place` varchar(32) NOT NULL COMMENT '广告位置',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_browse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(40) NOT NULL,
  `add_time` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_collection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) NOT NULL COMMENT '用户openid',
  `thread_id` int(11) NOT NULL COMMENT '收藏的帖子的id',
  `date` varchar(32) NOT NULL COMMENT '收藏的时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `settings` text NOT NULL,
  `other_setting` text NOT NULL,
  `share_setting` text NOT NULL,
  `poster_setting` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_guanzhu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(32) NOT NULL COMMENT '用户openid',
  `bopenid` varchar(32) NOT NULL COMMENT '被关注的用户id',
  `date` varchar(32) NOT NULL COMMENT '关注的时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_huifu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pl_id` int(11) NOT NULL COMMENT '评论id',
  `user_id` varchar(64) NOT NULL COMMENT '回复人的openid',
  `buser_id` varchar(64) NOT NULL COMMENT '被回复人的openid',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_information` (
  `id` int(11) unsigned NOT NULL COMMENT 'id',
  `fangwen` int(11) NOT NULL COMMENT '站点访问统计',
  `send` int(11) NOT NULL COMMENT '发帖数统计',
  `user` int(11) NOT NULL COMMENT '用户统计',
  `acid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `logo` text NOT NULL COMMENT 'logo',
  `url` text NOT NULL COMMENT 'url',
  `xuhao` int(11) NOT NULL COMMENT '序号',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_looked` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(32) NOT NULL COMMENT '用户openid',
  `thread_id` int(11) NOT NULL COMMENT '帖子id',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(32) NOT NULL COMMENT '模块名称',
  `images` text NOT NULL COMMENT '模块图标',
  `admin` varchar(32) NOT NULL COMMENT '管理员',
  `send` int(11) NOT NULL COMMENT '发帖权限',
  `reply` int(11) NOT NULL COMMENT '回帖权限',
  `jifen` int(11) NOT NULL COMMENT '发帖积分',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(32) NOT NULL COMMENT '公告标题',
  `info` varchar(64) NOT NULL COMMENT '公告内容',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_opinion` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `info` varchar(256) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `acid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_pay` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `topenid` varchar(64) NOT NULL COMMENT '发表文章的人的openid',
  `dopenid` varchar(64) NOT NULL COMMENT '打赏的人',
  `thread_id` int(11) NOT NULL COMMENT '帖子的id',
  `money` float NOT NULL COMMENT '打赏的金额',
  `serial` varchar(32) NOT NULL COMMENT '订单号',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态',
  `time` varchar(32) NOT NULL COMMENT '支付时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_pinglun` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `thread_id` int(11) NOT NULL COMMENT '帖子id',
  `user_id` varchar(64) NOT NULL COMMENT '用户openid',
  `info` varchar(64) NOT NULL COMMENT '评论内容',
  `images` text NOT NULL COMMENT '评论的图片',
  `avatar` text NOT NULL COMMENT '评论用户的头像',
  `nickname` varchar(32) NOT NULL COMMENT '评论用户的昵称',
  `hname` varchar(32) NOT NULL,
  `hid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `time` varchar(32) NOT NULL COMMENT '评论的时间',
  `zan` int(11) NOT NULL COMMENT '点赞人数',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_qiandao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(64) NOT NULL COMMENT '用户标识',
  `time` varchar(32) NOT NULL COMMENT '时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `msg` text NOT NULL,
  `add_time` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_self` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(32) NOT NULL COMMENT '广告标题',
  `images` text NOT NULL COMMENT '广告图片',
  `url` varchar(128) NOT NULL COMMENT '广告链接',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `credit1` int(11) NOT NULL,
  `name` varchar(32) NOT NULL COMMENT '论坛名称',
  `jianjie` text NOT NULL COMMENT '论坛简介',
  `member` int(11) NOT NULL COMMENT '会员数',
  `thread` int(11) NOT NULL COMMENT '帖子数',
  `logo` text NOT NULL COMMENT '论坛logo',
  `beij` text NOT NULL COMMENT '背景图',
  `send` int(11) NOT NULL COMMENT '发帖积分',
  `reply` int(11) NOT NULL COMMENT '回复积分',
  `state` int(11) NOT NULL COMMENT '审核状态',
  `vstate` int(11) NOT NULL COMMENT '视频状态',
  `admin` text NOT NULL COMMENT '管理员',
  `sign1` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `biz_id` varchar(50) NOT NULL,
  `follow` tinyint(4) NOT NULL,
  `mobiletime` int(11) NOT NULL,
  `postauth` varchar(100) NOT NULL,
  `nickname` varchar(32) NOT NULL COMMENT '管理员昵称',
  `avatar` text NOT NULL COMMENT '管理员头像',
  `address` varchar(64) NOT NULL COMMENT '管理员地址',
  `openid` varchar(64) NOT NULL COMMENT '管理员openid',
  `shouxu` int(10) NOT NULL COMMENT '手续费比例',
  `mes` text NOT NULL COMMENT '模版消息ID',
  `erwei` text NOT NULL COMMENT '二维码',
  `dingdan` int(1) NOT NULL COMMENT '11',
  `zengjia` varchar(128) NOT NULL COMMENT '11',
  `uid` int(11) NOT NULL,
  `partnerkey` varchar(128) NOT NULL,
  `mch_id` varchar(128) NOT NULL,
  `appsecret` varchar(128) NOT NULL,
  `tstate` int(10) NOT NULL,
  `acid` int(11) NOT NULL,
  `tixian_limit` float NOT NULL COMMENT '最低提现金额',
  `dashang_limit` float NOT NULL COMMENT '最低打赏金额',
  `dashang_moneys` varchar(128) NOT NULL COMMENT '打赏页面默认金额列表(6个)',
  `award_days` int(11) NOT NULL COMMENT '悬赏回复有效时间',
  `qq_address_key` varchar(255) DEFAULT NULL COMMENT '腾讯地图key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_thread` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `fengmian` text,
  `mobile` varchar(100) NOT NULL,
  `title` varchar(32) NOT NULL COMMENT '帖子标题',
  `info` text NOT NULL COMMENT '帖子内容',
  `images` text NOT NULL COMMENT '文章图片',
  `nickname` varchar(32) NOT NULL,
  `openid` varchar(64) NOT NULL COMMENT '用户标识',
  `lv` int(11) NOT NULL COMMENT '等级',
  `uid` int(11) NOT NULL,
  `avatar` text NOT NULL COMMENT '头像',
  `time` varchar(32) NOT NULL,
  `address` varchar(32) NOT NULL COMMENT '发帖位置',
  `fenlei` varchar(32) NOT NULL COMMENT '类别',
  `zan` int(11) NOT NULL COMMENT '点赞人数',
  `share` int(11) NOT NULL COMMENT '转发次数',
  `pl` int(11) NOT NULL COMMENT '评论的数量',
  `pl_time` varchar(64) NOT NULL COMMENT '评论的最新时间',
  `looks` int(11) NOT NULL COMMENT '访问量',
  `money` float NOT NULL COMMENT '打赏金额',
  `biaoshi` int(11) NOT NULL,
  `shstate` int(11) NOT NULL,
  `zdstate` int(11) NOT NULL,
  `ggstate` int(10) NOT NULL,
  `video` text NOT NULL COMMENT '视频',
  `tbiaoshi` int(10) NOT NULL,
  `zengjia` varchar(128) NOT NULL,
  `acid` int(11) NOT NULL COMMENT '公众号',
  `checkp` int(11) NOT NULL,
  `checkd` int(11) NOT NULL,
  `award` decimal(10,2) NOT NULL COMMENT '悬赏金额',
  `award_id` int(11) NOT NULL DEFAULT '0' COMMENT '获得悬赏用户id',
  `award_time` datetime NOT NULL COMMENT '悬赏到期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_tixian` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `openid` varchar(64) NOT NULL COMMENT '用户openid',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `money` float NOT NULL COMMENT '提现金额',
  `zhanghao` varchar(32) NOT NULL COMMENT '提现账号',
  `time` varchar(64) NOT NULL COMMENT '时间',
  `state` int(11) NOT NULL COMMENT '提现状态',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(11) NOT NULL,
  `uid` int(10) NOT NULL COMMENT 'uid',
  `openid` varchar(64) NOT NULL COMMENT '用户标识',
  `nickname` varchar(32) NOT NULL COMMENT '昵称',
  `avatar` text NOT NULL COMMENT '头像',
  `send` int(11) NOT NULL COMMENT '发帖数',
  `jifen` int(11) NOT NULL COMMENT '积分数',
  `lv` int(11) NOT NULL COMMENT '等级',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_luntan_zan` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` varchar(32) NOT NULL COMMENT '用户openid',
  `thread_id` int(11) NOT NULL COMMENT '帖子id',
  `pl_id` int(11) NOT NULL COMMENT '评论id',
  `time` varchar(32) NOT NULL COMMENT '点赞时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_mm_set` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `images` text NOT NULL COMMENT '图片',
  `info` text NOT NULL COMMENT '内容',
  `acid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_mm_yuyue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `diqu` varchar(20) NOT NULL COMMENT '地区',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  `acid` int(11) NOT NULL COMMENT '公众号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wyt_zoulang_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tu` text NOT NULL,
  `rank` int(10) NOT NULL,
  `wen` text NOT NULL,
  `acid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists("wyt_dayusms_base", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "weid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `weid` int(11) unsigned DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "appkey")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `appkey` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "secretKey")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `secretKey` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "format")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `format` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "freesignname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `freesignname` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "templatecode")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `templatecode` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_dayusms_base", "safetycode")) {
 pdo_query("ALTER TABLE ".tablename("wyt_dayusms_base")." ADD   `safetycode` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_ads", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_ads", "display")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `display` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_ads", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `mobile` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_ads", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `title` varchar(32) NOT NULL COMMENT '广告标题';");
}
if(!pdo_fieldexists("wyt_luntan_ads", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `images` text NOT NULL COMMENT '广告图片';");
}
if(!pdo_fieldexists("wyt_luntan_ads", "url")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `url` varchar(128) NOT NULL COMMENT '广告链接';");
}
if(!pdo_fieldexists("wyt_luntan_ads", "place")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `place` varchar(32) NOT NULL COMMENT '广告位置';");
}
if(!pdo_fieldexists("wyt_luntan_ads", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_ads")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_browse", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_browse")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_browse", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_browse")." ADD   `openid` varchar(40) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_browse", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_browse")." ADD   `add_time` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_browse", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_browse")." ADD   `thread_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_browse", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_browse")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_collection", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_collection")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_collection", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_collection")." ADD   `openid` varchar(32) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_collection", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_collection")." ADD   `thread_id` int(11) NOT NULL COMMENT '收藏的帖子的id';");
}
if(!pdo_fieldexists("wyt_luntan_collection", "date")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_collection")." ADD   `date` varchar(32) NOT NULL COMMENT '收藏的时间';");
}
if(!pdo_fieldexists("wyt_luntan_collection", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_collection")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_config", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_config", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_config", "settings")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `settings` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_config", "other_setting")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `other_setting` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_config", "share_setting")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `share_setting` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_config", "poster_setting")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_config")." ADD   `poster_setting` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_guanzhu", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_guanzhu")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_guanzhu", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_guanzhu")." ADD   `openid` varchar(32) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_guanzhu", "bopenid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_guanzhu")." ADD   `bopenid` varchar(32) NOT NULL COMMENT '被关注的用户id';");
}
if(!pdo_fieldexists("wyt_luntan_guanzhu", "date")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_guanzhu")." ADD   `date` varchar(32) NOT NULL COMMENT '关注的时间';");
}
if(!pdo_fieldexists("wyt_luntan_guanzhu", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_guanzhu")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_huifu", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_huifu")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_huifu", "pl_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_huifu")." ADD   `pl_id` int(11) NOT NULL COMMENT '评论id';");
}
if(!pdo_fieldexists("wyt_luntan_huifu", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_huifu")." ADD   `user_id` varchar(64) NOT NULL COMMENT '回复人的openid';");
}
if(!pdo_fieldexists("wyt_luntan_huifu", "buser_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_huifu")." ADD   `buser_id` varchar(64) NOT NULL COMMENT '被回复人的openid';");
}
if(!pdo_fieldexists("wyt_luntan_huifu", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_huifu")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_information", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_information")." ADD   `id` int(11) unsigned NOT NULL COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_information", "fangwen")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_information")." ADD   `fangwen` int(11) NOT NULL COMMENT '站点访问统计';");
}
if(!pdo_fieldexists("wyt_luntan_information", "send")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_information")." ADD   `send` int(11) NOT NULL COMMENT '发帖数统计';");
}
if(!pdo_fieldexists("wyt_luntan_information", "user")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_information")." ADD   `user` int(11) NOT NULL COMMENT '用户统计';");
}
if(!pdo_fieldexists("wyt_luntan_information", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_information")." ADD   `acid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_list", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_list", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `title` varchar(128) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("wyt_luntan_list", "logo")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `logo` text NOT NULL COMMENT 'logo';");
}
if(!pdo_fieldexists("wyt_luntan_list", "url")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `url` text NOT NULL COMMENT 'url';");
}
if(!pdo_fieldexists("wyt_luntan_list", "xuhao")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `xuhao` int(11) NOT NULL COMMENT '序号';");
}
if(!pdo_fieldexists("wyt_luntan_list", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_list")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_looked", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_looked")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_looked", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_looked")." ADD   `openid` varchar(32) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_looked", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_looked")." ADD   `thread_id` int(11) NOT NULL COMMENT '帖子id';");
}
if(!pdo_fieldexists("wyt_luntan_looked", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_looked")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_module", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_module", "name")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `name` varchar(32) NOT NULL COMMENT '模块名称';");
}
if(!pdo_fieldexists("wyt_luntan_module", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `images` text NOT NULL COMMENT '模块图标';");
}
if(!pdo_fieldexists("wyt_luntan_module", "admin")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `admin` varchar(32) NOT NULL COMMENT '管理员';");
}
if(!pdo_fieldexists("wyt_luntan_module", "send")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `send` int(11) NOT NULL COMMENT '发帖权限';");
}
if(!pdo_fieldexists("wyt_luntan_module", "reply")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `reply` int(11) NOT NULL COMMENT '回帖权限';");
}
if(!pdo_fieldexists("wyt_luntan_module", "jifen")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `jifen` int(11) NOT NULL COMMENT '发帖积分';");
}
if(!pdo_fieldexists("wyt_luntan_module", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_module")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_notice", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_notice")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_notice", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_notice")." ADD   `title` varchar(32) NOT NULL COMMENT '公告标题';");
}
if(!pdo_fieldexists("wyt_luntan_notice", "info")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_notice")." ADD   `info` varchar(64) NOT NULL COMMENT '公告内容';");
}
if(!pdo_fieldexists("wyt_luntan_notice", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_notice")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_opinion", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_opinion")." ADD   `id` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_opinion", "info")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_opinion")." ADD   `info` varchar(256) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_opinion", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_opinion")." ADD   `openid` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_opinion", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_opinion")." ADD   `acid` int(10) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_pay", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "topenid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `topenid` varchar(64) NOT NULL COMMENT '发表文章的人的openid';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "dopenid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `dopenid` varchar(64) NOT NULL COMMENT '打赏的人';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `thread_id` int(11) NOT NULL COMMENT '帖子的id';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "money")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `money` float NOT NULL COMMENT '打赏的金额';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "serial")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `serial` varchar(32) NOT NULL COMMENT '订单号';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "state")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `state` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `time` varchar(32) NOT NULL COMMENT '支付时间';");
}
if(!pdo_fieldexists("wyt_luntan_pay", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pay")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `thread_id` int(11) NOT NULL COMMENT '帖子id';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `user_id` varchar(64) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "info")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `info` varchar(64) NOT NULL COMMENT '评论内容';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `images` text NOT NULL COMMENT '评论的图片';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `avatar` text NOT NULL COMMENT '评论用户的头像';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `nickname` varchar(32) NOT NULL COMMENT '评论用户的昵称';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "hname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `hname` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "hid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `hid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "pid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `pid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `time` varchar(32) NOT NULL COMMENT '评论的时间';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "zan")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `zan` int(11) NOT NULL COMMENT '点赞人数';");
}
if(!pdo_fieldexists("wyt_luntan_pinglun", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_pinglun")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_qiandao", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_qiandao")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_qiandao", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_qiandao")." ADD   `openid` varchar(64) NOT NULL COMMENT '用户标识';");
}
if(!pdo_fieldexists("wyt_luntan_qiandao", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_qiandao")." ADD   `time` varchar(32) NOT NULL COMMENT '时间';");
}
if(!pdo_fieldexists("wyt_luntan_qiandao", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_qiandao")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_report", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `id` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_report", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `openid` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_report", "msg")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `msg` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_report", "add_time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `add_time` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_report", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `thread_id` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_report", "uniacid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_report")." ADD   `uniacid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_self", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_self")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_self", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_self")." ADD   `title` varchar(32) NOT NULL COMMENT '广告标题';");
}
if(!pdo_fieldexists("wyt_luntan_self", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_self")." ADD   `images` text NOT NULL COMMENT '广告图片';");
}
if(!pdo_fieldexists("wyt_luntan_self", "url")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_self")." ADD   `url` varchar(128) NOT NULL COMMENT '广告链接';");
}
if(!pdo_fieldexists("wyt_luntan_self", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_self")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_set", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_luntan_set", "credit1")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `credit1` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "name")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `name` varchar(32) NOT NULL COMMENT '论坛名称';");
}
if(!pdo_fieldexists("wyt_luntan_set", "jianjie")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `jianjie` text NOT NULL COMMENT '论坛简介';");
}
if(!pdo_fieldexists("wyt_luntan_set", "member")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `member` int(11) NOT NULL COMMENT '会员数';");
}
if(!pdo_fieldexists("wyt_luntan_set", "thread")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `thread` int(11) NOT NULL COMMENT '帖子数';");
}
if(!pdo_fieldexists("wyt_luntan_set", "logo")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `logo` text NOT NULL COMMENT '论坛logo';");
}
if(!pdo_fieldexists("wyt_luntan_set", "beij")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `beij` text NOT NULL COMMENT '背景图';");
}
if(!pdo_fieldexists("wyt_luntan_set", "send")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `send` int(11) NOT NULL COMMENT '发帖积分';");
}
if(!pdo_fieldexists("wyt_luntan_set", "reply")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `reply` int(11) NOT NULL COMMENT '回复积分';");
}
if(!pdo_fieldexists("wyt_luntan_set", "state")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `state` int(11) NOT NULL COMMENT '审核状态';");
}
if(!pdo_fieldexists("wyt_luntan_set", "vstate")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `vstate` int(11) NOT NULL COMMENT '视频状态';");
}
if(!pdo_fieldexists("wyt_luntan_set", "admin")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `admin` text NOT NULL COMMENT '管理员';");
}
if(!pdo_fieldexists("wyt_luntan_set", "sign1")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `sign1` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "sign")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `sign` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "biz_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `biz_id` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "follow")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `follow` tinyint(4) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "mobiletime")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `mobiletime` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "postauth")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `postauth` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `nickname` varchar(32) NOT NULL COMMENT '管理员昵称';");
}
if(!pdo_fieldexists("wyt_luntan_set", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `avatar` text NOT NULL COMMENT '管理员头像';");
}
if(!pdo_fieldexists("wyt_luntan_set", "address")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `address` varchar(64) NOT NULL COMMENT '管理员地址';");
}
if(!pdo_fieldexists("wyt_luntan_set", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `openid` varchar(64) NOT NULL COMMENT '管理员openid';");
}
if(!pdo_fieldexists("wyt_luntan_set", "shouxu")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `shouxu` int(10) NOT NULL COMMENT '手续费比例';");
}
if(!pdo_fieldexists("wyt_luntan_set", "mes")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `mes` text NOT NULL COMMENT '模版消息ID';");
}
if(!pdo_fieldexists("wyt_luntan_set", "erwei")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `erwei` text NOT NULL COMMENT '二维码';");
}
if(!pdo_fieldexists("wyt_luntan_set", "dingdan")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `dingdan` int(1) NOT NULL COMMENT '11';");
}
if(!pdo_fieldexists("wyt_luntan_set", "zengjia")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `zengjia` varchar(128) NOT NULL COMMENT '11';");
}
if(!pdo_fieldexists("wyt_luntan_set", "uid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "partnerkey")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `partnerkey` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "mch_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `mch_id` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "appsecret")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `appsecret` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "tstate")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `tstate` int(10) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `acid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_set", "tixian_limit")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `tixian_limit` float NOT NULL COMMENT '最低提现金额';");
}
if(!pdo_fieldexists("wyt_luntan_set", "dashang_limit")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `dashang_limit` float NOT NULL COMMENT '最低打赏金额';");
}
if(!pdo_fieldexists("wyt_luntan_set", "dashang_moneys")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `dashang_moneys` varchar(128) NOT NULL COMMENT '打赏页面默认金额列表(6个)';");
}
if(!pdo_fieldexists("wyt_luntan_set", "award_days")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `award_days` int(11) NOT NULL COMMENT '悬赏回复有效时间';");
}
if(!pdo_fieldexists("wyt_luntan_set", "qq_address_key")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_set")." ADD   `qq_address_key` varchar(255) DEFAULT NULL COMMENT '腾讯地图key';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "fengmian")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `fengmian` text;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "mobile")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `mobile` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `title` varchar(32) NOT NULL COMMENT '帖子标题';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "info")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `info` text NOT NULL COMMENT '帖子内容';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `images` text NOT NULL COMMENT '文章图片';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `nickname` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `openid` varchar(64) NOT NULL COMMENT '用户标识';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "lv")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `lv` int(11) NOT NULL COMMENT '等级';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "uid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `uid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `avatar` text NOT NULL COMMENT '头像';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `time` varchar(32) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "address")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `address` varchar(32) NOT NULL COMMENT '发帖位置';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "fenlei")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `fenlei` varchar(32) NOT NULL COMMENT '类别';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "zan")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `zan` int(11) NOT NULL COMMENT '点赞人数';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "share")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `share` int(11) NOT NULL COMMENT '转发次数';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "pl")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `pl` int(11) NOT NULL COMMENT '评论的数量';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "pl_time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `pl_time` varchar(64) NOT NULL COMMENT '评论的最新时间';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "looks")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `looks` int(11) NOT NULL COMMENT '访问量';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "money")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `money` float NOT NULL COMMENT '打赏金额';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "biaoshi")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `biaoshi` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "shstate")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `shstate` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "zdstate")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `zdstate` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "ggstate")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `ggstate` int(10) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "video")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `video` text NOT NULL COMMENT '视频';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "tbiaoshi")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `tbiaoshi` int(10) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "zengjia")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `zengjia` varchar(128) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "checkp")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `checkp` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "checkd")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `checkd` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_thread", "award")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `award` decimal(10,2) NOT NULL COMMENT '悬赏金额';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "award_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `award_id` int(11) NOT NULL DEFAULT '0' COMMENT '获得悬赏用户id';");
}
if(!pdo_fieldexists("wyt_luntan_thread", "award_time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_thread")." ADD   `award_time` datetime NOT NULL COMMENT '悬赏到期时间';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `openid` varchar(64) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "uid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `uid` int(11) NOT NULL COMMENT '用户uid';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "money")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `money` float NOT NULL COMMENT '提现金额';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "zhanghao")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `zhanghao` varchar(32) NOT NULL COMMENT '提现账号';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `time` varchar(64) NOT NULL COMMENT '时间';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "state")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `state` int(11) NOT NULL COMMENT '提现状态';");
}
if(!pdo_fieldexists("wyt_luntan_tixian", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_tixian")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_user", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_user", "pid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `pid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_luntan_user", "uid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `uid` int(10) NOT NULL COMMENT 'uid';");
}
if(!pdo_fieldexists("wyt_luntan_user", "openid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `openid` varchar(64) NOT NULL COMMENT '用户标识';");
}
if(!pdo_fieldexists("wyt_luntan_user", "nickname")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `nickname` varchar(32) NOT NULL COMMENT '昵称';");
}
if(!pdo_fieldexists("wyt_luntan_user", "avatar")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `avatar` text NOT NULL COMMENT '头像';");
}
if(!pdo_fieldexists("wyt_luntan_user", "send")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `send` int(11) NOT NULL COMMENT '发帖数';");
}
if(!pdo_fieldexists("wyt_luntan_user", "jifen")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `jifen` int(11) NOT NULL COMMENT '积分数';");
}
if(!pdo_fieldexists("wyt_luntan_user", "lv")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `lv` int(11) NOT NULL COMMENT '等级';");
}
if(!pdo_fieldexists("wyt_luntan_user", "state")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `state` int(11) NOT NULL DEFAULT '0' COMMENT '状态';");
}
if(!pdo_fieldexists("wyt_luntan_user", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_user")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "user_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `user_id` varchar(32) NOT NULL COMMENT '用户openid';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "thread_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `thread_id` int(11) NOT NULL COMMENT '帖子id';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "pl_id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `pl_id` int(11) NOT NULL COMMENT '评论id';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `time` varchar(32) NOT NULL COMMENT '点赞时间';");
}
if(!pdo_fieldexists("wyt_luntan_zan", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_luntan_zan")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_mm_set", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_set")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_mm_set", "title")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_set")." ADD   `title` varchar(20) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists("wyt_mm_set", "images")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_set")." ADD   `images` text NOT NULL COMMENT '图片';");
}
if(!pdo_fieldexists("wyt_mm_set", "info")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_set")." ADD   `info` text NOT NULL COMMENT '内容';");
}
if(!pdo_fieldexists("wyt_mm_set", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_set")." ADD   `acid` int(11) NOT NULL;");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id';");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "name")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `name` varchar(20) NOT NULL COMMENT '姓名';");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "phone")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `phone` varchar(20) NOT NULL COMMENT '电话';");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "diqu")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `diqu` varchar(20) NOT NULL COMMENT '地区';");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "time")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间';");
}
if(!pdo_fieldexists("wyt_mm_yuyue", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_mm_yuyue")." ADD   `acid` int(11) NOT NULL COMMENT '公众号';");
}
if(!pdo_fieldexists("wyt_zoulang_set", "id")) {
 pdo_query("ALTER TABLE ".tablename("wyt_zoulang_set")." ADD   `id` int(10) unsigned NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists("wyt_zoulang_set", "tu")) {
 pdo_query("ALTER TABLE ".tablename("wyt_zoulang_set")." ADD   `tu` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_zoulang_set", "rank")) {
 pdo_query("ALTER TABLE ".tablename("wyt_zoulang_set")." ADD   `rank` int(10) NOT NULL;");
}
if(!pdo_fieldexists("wyt_zoulang_set", "wen")) {
 pdo_query("ALTER TABLE ".tablename("wyt_zoulang_set")." ADD   `wen` text NOT NULL;");
}
if(!pdo_fieldexists("wyt_zoulang_set", "acid")) {
 pdo_query("ALTER TABLE ".tablename("wyt_zoulang_set")." ADD   `acid` int(10) NOT NULL;");
}

 ?>