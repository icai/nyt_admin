-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-03-20 13:23:20
-- 服务器版本： 5.5.59-log
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql47`
--

-- --------------------------------------------------------

--
-- 表的结构 `ims_account`
--

CREATE TABLE IF NOT EXISTS `ims_account` (
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `hash` varchar(8) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `isconnect` tinyint(4) NOT NULL,
  `isdeleted` tinyint(3) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_account`
--

INSERT INTO `ims_account` (`acid`, `uniacid`, `hash`, `type`, `isconnect`, `isdeleted`, `endtime`) VALUES
(1, 1, 'uRr8qvQV', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_aliapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_aliapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `key` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_baiduapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_baiduapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appid` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_phoneapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_phoneapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_toutiaoapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_toutiaoapp` (
  `acid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appid` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  `secret` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_webapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_webapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_wechats`
--

CREATE TABLE IF NOT EXISTS `ims_account_wechats` (
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(255) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `country` varchar(10) NOT NULL,
  `province` varchar(3) NOT NULL,
  `city` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `subscribeurl` varchar(120) NOT NULL,
  `auth_refresh_token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_account_wechats`
--

INSERT INTO `ims_account_wechats` (`acid`, `uniacid`, `token`, `encodingaeskey`, `level`, `name`, `account`, `original`, `signature`, `country`, `province`, `city`, `username`, `password`, `lastupdate`, `key`, `secret`, `styleid`, `subscribeurl`, `auth_refresh_token`) VALUES
(1, 1, 'omJNpZEhZeHj1ZxFECKkP48B5VFbk1HP', '', 1, 'we7team', '', '', '', '', '', '', '', '', 0, '', '', 1, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_wxapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_wxapp` (
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(43) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `account` varchar(30) NOT NULL,
  `original` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `secret` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `appdomain` varchar(255) NOT NULL,
  `auth_refresh_token` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_account_xzapp`
--

CREATE TABLE IF NOT EXISTS `ims_account_xzapp` (
  `acid` int(11) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `original` varchar(50) NOT NULL,
  `lastupdate` int(10) NOT NULL,
  `styleid` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `token` varchar(32) NOT NULL,
  `encodingaeskey` varchar(255) NOT NULL,
  `xzapp_id` varchar(30) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL,
  `key` varchar(80) NOT NULL,
  `secret` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_clerks`
--

CREATE TABLE IF NOT EXISTS `ims_activity_clerks` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_clerk_menu`
--

CREATE TABLE IF NOT EXISTS `ims_activity_clerk_menu` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `displayorder` int(4) NOT NULL,
  `pid` int(6) NOT NULL,
  `group_name` varchar(20) NOT NULL,
  `title` varchar(20) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `permission` varchar(50) NOT NULL,
  `system` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_exchange`
--

CREATE TABLE IF NOT EXISTS `ims_activity_exchange` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `extra` varchar(3000) NOT NULL DEFAULT '',
  `credit` int(10) unsigned NOT NULL,
  `credittype` varchar(10) NOT NULL,
  `pretotal` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_exchange_trades`
--

CREATE TABLE IF NOT EXISTS `ims_activity_exchange_trades` (
  `tid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `exid` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_exchange_trades_shipping`
--

CREATE TABLE IF NOT EXISTS `ims_activity_exchange_trades_shipping` (
  `tid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `exid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `district` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_activity_stores`
--

CREATE TABLE IF NOT EXISTS `ims_activity_stores` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) unsigned NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `open_time` varchar(50) NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `source` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `message` varchar(500) NOT NULL,
  `sosomap_poi_uid` varchar(50) NOT NULL DEFAULT '',
  `license_no` varchar(30) NOT NULL DEFAULT '',
  `license_name` varchar(100) NOT NULL DEFAULT '',
  `other_files` text NOT NULL,
  `audit_id` varchar(50) NOT NULL DEFAULT '',
  `on_show` tinyint(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_article_category`
--

CREATE TABLE IF NOT EXISTS `ims_article_category` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_article_comment`
--

CREATE TABLE IF NOT EXISTS `ims_article_comment` (
  `id` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `parentid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `content` varchar(500) DEFAULT NULL,
  `is_like` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `like_num` int(10) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_article_news`
--

CREATE TABLE IF NOT EXISTS `ims_article_news` (
  `id` int(10) unsigned NOT NULL,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_article_notice`
--

CREATE TABLE IF NOT EXISTS `ims_article_notice` (
  `id` int(10) unsigned NOT NULL,
  `cateid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `style` varchar(200) NOT NULL,
  `group` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_article_unread_notice`
--

CREATE TABLE IF NOT EXISTS `ims_article_unread_notice` (
  `id` int(10) unsigned NOT NULL,
  `notice_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `is_new` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_attachment_group`
--

CREATE TABLE IF NOT EXISTS `ims_attachment_group` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_basic_reply`
--

CREATE TABLE IF NOT EXISTS `ims_basic_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_business`
--

CREATE TABLE IF NOT EXISTS `ims_business` (
  `id` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dist` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `lng` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `industry1` varchar(10) NOT NULL,
  `industry2` varchar(10) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_attachment`
--

CREATE TABLE IF NOT EXISTS `ims_core_attachment` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `module_upload_dir` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_core_attachment`
--

INSERT INTO `ims_core_attachment` (`id`, `uniacid`, `uid`, `filename`, `attachment`, `type`, `createtime`, `module_upload_dir`, `group_id`) VALUES
(1, 1, 1, '150-150.jpg', 'images/1/2019/03/JNJqsdmwmdj190iOm81Ijq6nfTT62n.jpg', 1, 1553059207, '', -1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_cache`
--

CREATE TABLE IF NOT EXISTS `ims_core_cache` (
  `key` varchar(100) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_core_cache`
--

INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('we7:setting', 'a:6:{s:9:"copyright";a:1:{s:6:"slides";a:3:{i:0;s:58:"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg";i:1;s:58:"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg";i:2;s:58:"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg";}}s:8:"authmode";i:1;s:5:"close";a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}s:8:"register";a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}s:4:"site";a:5:{s:3:"key";s:9:"229155853";s:5:"token";s:32:"g5zhijnotw18fry60bq7sv239cxdpk4e";s:3:"url";s:14:"47.104.103.199";s:7:"version";s:5:"2.0.0";s:15:"profile_perfect";s:1:"1";}s:7:"cloudip";a:2:{s:2:"ip";s:13:"123.206.45.56";s:6:"expire";i:1553062173;}}'),
('we7:system_frame:0', 'a:21:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:3:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:7:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_founder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"副站长";s:3:"url";s:32:"./index.php?c=founder&a=display&";s:15:"permission_name";s:19:"user_manage_founder";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:4:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:24:"permission_founder_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:21:"副站长权限组合";s:3:"url";s:30:"./index.php?c=founder&a=group&";s:15:"permission_name";s:24:"permission_founder_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:31:"./index.php?c=article&a=notice&";s:7:"section";a:5:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:14:"system_welcome";a:3:{s:5:"title";s:12:"系统首页";s:4:"menu";a:2:{s:14:"system_welcome";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统首页应用";s:3:"url";s:60:"./index.php?c=module&a=manage-system&support=welcome_support";s:15:"permission_name";s:14:"system_welcome";s:4:"icon";s:20:"wi wi-system-welcome";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:11:"system_news";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统新闻";s:3:"url";s:29:"./index.php?c=article&a=news&";s:15:"permission_name";s:11:"system_news";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:13:"新闻列表 ";s:15:"permission_name";s:24:"system_article_news_list";}i:1;a:2:{s:5:"title";s:13:"新闻分类 ";s:15:"permission_name";s:28:"system_article_news_category";}}}}s:7:"founder";b:1;}s:17:"system_statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:23:"system_account_analysis";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"访问统计";s:3:"url";s:35:"./index.php?c=statistics&a=account&";s:15:"permission_name";s:23:"system_account_analysis";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:28:"./index.php?c=system&a=site&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:5:{s:8:"platform";a:3:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:3:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";i:0;}s:7:"profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:7:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:19:"profile_bind_domain";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"域名绑定";s:3:"url";s:36:"./index.php?c=profile&a=bind-domain&";s:15:"permission_name";s:19:"profile_bind_domain";s:4:"icon";s:17:"wi wi-bind-domain";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_bind_domain";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:18:"域名访问设置";s:3:"url";s:35:"./index.php?c=webapp&a=bind-domain&";s:15:"permission_name";s:18:"webapp_bind_domain";s:4:"icon";s:17:"wi wi-bind-domain";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";i:0;}s:10:"statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:2:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:16:"statistics_visit";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}s:15:"statistics_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:0;s:5:"title";s:12:"用户统计";s:3:"url";s:32:"./index.php?c=statistics&a=fans&";s:15:"permission_name";s:15:"statistics_fans";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:3:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:3:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:10:"is_display";i:0;}s:13:"wxapp_profile";a:2:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:15:"下载程序包";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}}s:10:"statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:5:"store";a:7:{s:5:"title";s:6:"商城";s:4:"icon";s:11:"wi wi-store";s:3:"url";s:43:"./index.php?c=home&a=welcome&do=ext&m=store";s:7:"section";a:6:{s:11:"store_goods";a:2:{s:5:"title";s:12:"商品分类";s:4:"menu";a:6:{s:18:"store_goods_module";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"应用模块";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-apply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_goods_account";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台个数";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=2";s:15:"permission_name";N;s:4:"icon";s:13:"wi wi-account";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:25:"store_goods_account_renew";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台续费";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=7";s:15:"permission_name";N;s:4:"icon";s:21:"wi wi-appjurisdiction";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_goods_package";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=5";s:15:"permission_name";N;s:4:"icon";s:21:"wi wi-appjurisdiction";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"store_goods_users_package";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"用户权限组";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=9";s:15:"permission_name";N;s:4:"icon";s:22:"wi wi-userjurisdiction";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:15:"store_goods_api";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:23:"应用访问流量(API)";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=6";s:15:"permission_name";N;s:4:"icon";s:9:"wi wi-api";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:12:"store_manage";a:3:{s:5:"title";s:12:"商城管理";s:7:"founder";b:1;s:4:"menu";a:4:{s:18:"store_manage_goods";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"添加商品";s:3:"url";s:58:"./index.php?c=site&a=entry&do=goodsSeller&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:15:"wi wi-goods-add";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:20:"store_manage_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"商城设置";s:3:"url";s:54:"./index.php?c=site&a=entry&do=setting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-store";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_manage_payset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"支付设置";s:3:"url";s:57:"./index.php?c=site&a=entry&do=paySetting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-money";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:23:"store_manage_permission";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"商城访问权限";s:3:"url";s:57:"./index.php?c=site&a=entry&do=permission&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:15:"wi wi-blacklist";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:12:"store_orders";a:2:{s:5:"title";s:12:"订单管理";s:4:"menu";a:2:{s:15:"store_orders_my";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"我的订单";s:3:"url";s:53:"./index.php?c=site&a=entry&do=orders&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:17:"wi wi-sale-record";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:17:"store_cash_orders";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"分销订单";s:3:"url";s:71:"./index.php?c=site&a=entry&do=cash&m=store&operate=cash_orders&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-order";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:14:"store_payments";a:2:{s:5:"title";s:12:"收入明细";s:4:"menu";a:1:{s:8:"payments";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"收入明细";s:3:"url";s:55:"./index.php?c=site&a=entry&do=payments&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:17:"wi wi-sale-record";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:17:"store_cash_manage";a:2:{s:5:"title";s:12:"分销管理";s:4:"menu";a:2:{s:25:"store_manage_cash_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"分销设置";s:3:"url";s:58:"./index.php?c=site&a=entry&do=cashsetting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:16:"store_check_cash";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"提现审核";s:3:"url";s:73:"./index.php?c=site&a=entry&do=cash&m=store&operate=consume_order&direct=1";s:15:"permission_name";N;s:4:"icon";s:18:"wi wi-check-select";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:10:"store_cash";a:2:{s:5:"title";s:12:"佣金管理";s:4:"menu";a:1:{s:8:"payments";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"我的佣金";s:3:"url";s:66:"./index.php?c=site&a=entry&do=cash&m=store&operate=mycash&direct=1";s:15:"permission_name";N;s:4:"icon";s:10:"wi wi-list";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}}');
INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('we7:userbasefields', 'a:46:{s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:6:"mobile";s:12:"手机号码";s:5:"email";s:12:"电子邮箱";s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"gender";s:6:"性别";s:5:"birth";s:6:"生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:6:"地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:6:"reside";s:9:"居住地";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:8:"password";s:6:"密码";s:12:"pay_password";s:12:"支付密码";}'),
('we7:usersfields', 'a:47:{s:8:"realname";s:12:"真实姓名";s:8:"nickname";s:6:"昵称";s:6:"avatar";s:6:"头像";s:2:"qq";s:5:"QQ号";s:6:"mobile";s:12:"手机号码";s:3:"vip";s:9:"VIP级别";s:6:"gender";s:6:"性别";s:9:"birthyear";s:12:"出生生日";s:13:"constellation";s:6:"星座";s:6:"zodiac";s:6:"生肖";s:9:"telephone";s:12:"固定电话";s:6:"idcard";s:12:"证件号码";s:9:"studentid";s:6:"学号";s:5:"grade";s:6:"班级";s:7:"address";s:12:"邮寄地址";s:7:"zipcode";s:6:"邮编";s:11:"nationality";s:6:"国籍";s:14:"resideprovince";s:12:"居住地址";s:14:"graduateschool";s:12:"毕业学校";s:7:"company";s:6:"公司";s:9:"education";s:6:"学历";s:10:"occupation";s:6:"职业";s:8:"position";s:6:"职位";s:7:"revenue";s:9:"年收入";s:15:"affectivestatus";s:12:"情感状态";s:10:"lookingfor";s:13:" 交友目的";s:9:"bloodtype";s:6:"血型";s:6:"height";s:6:"身高";s:6:"weight";s:6:"体重";s:6:"alipay";s:15:"支付宝帐号";s:3:"msn";s:3:"MSN";s:5:"email";s:12:"电子邮箱";s:6:"taobao";s:12:"阿里旺旺";s:4:"site";s:6:"主页";s:3:"bio";s:12:"自我介绍";s:8:"interest";s:12:"兴趣爱好";s:7:"uniacid";s:17:"同一公众号id";s:7:"groupid";s:8:"分组id";s:7:"credit1";s:6:"积分";s:7:"credit2";s:6:"余额";s:7:"credit3";s:19:"预留积分类型3";s:7:"credit4";s:19:"预留积分类型4";s:7:"credit5";s:19:"预留积分类型5";s:7:"credit6";s:19:"预留积分类型6";s:10:"createtime";s:12:"加入时间";s:8:"password";s:12:"用户密码";s:12:"pay_password";s:12:"支付密码";}'),
('we7:module_receive_enable', 'a:0:{}'),
('we7:user_modules:1', 'a:0:{}'),
('upgrade', 'a:3:{s:7:"upgrade";b:1;s:4:"data";a:5:{s:7:"schemas";a:2:{i:0;a:5:{s:9:"tablename";s:18:"ims_mc_card_record";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:6:"fields";a:10:{s:2:"id";a:7:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;s:7:"default";N;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:3:"uid";a:7:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:5:"model";a:7:{s:4:"name";s:5:"model";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"1";}s:3:"fee";a:7:{s:4:"name";s:3:"fee";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:4:"0.00";}s:3:"tag";a:7:{s:4:"name";s:3:"tag";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:4:"note";a:7:{s:4:"name";s:4:"note";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:6:"remark";a:7:{s:4:"name";s:6:"remark";s:4:"type";s:7:"varchar";s:6:"length";s:3:"200";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:7:"addtime";a:7:{s:4:"name";s:7:"addtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}}s:7:"indexes";a:4:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}s:3:"uid";a:3:{s:4:"name";s:3:"uid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:3:"uid";}}s:7:"addtime";a:3:{s:4:"name";s:7:"addtime";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"addtime";}}}}i:1;a:5:{s:9:"tablename";s:19:"ims_paycenter_order";s:7:"charset";s:15:"utf8_general_ci";s:6:"engine";s:6:"MyISAM";s:6:"fields";a:27:{s:2:"id";a:7:{s:4:"name";s:2:"id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:1;s:7:"default";N;}s:7:"uniacid";a:7:{s:4:"name";s:7:"uniacid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:3:"uid";a:7:{s:4:"name";s:3:"uid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:3:"pid";a:7:{s:4:"name";s:3:"pid";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:8:"clerk_id";a:7:{s:4:"name";s:8:"clerk_id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:8:"store_id";a:7:{s:4:"name";s:8:"store_id";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:10:"clerk_type";a:7:{s:4:"name";s:10:"clerk_type";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"2";}s:8:"uniontid";a:7:{s:4:"name";s:8:"uniontid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"40";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:14:"transaction_id";a:7:{s:4:"name";s:14:"transaction_id";s:4:"type";s:7:"varchar";s:6:"length";s:2:"40";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:4:"type";a:7:{s:4:"name";s:4:"type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:10:"trade_type";a:7:{s:4:"name";s:10:"trade_type";s:4:"type";s:7:"varchar";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:4:"body";a:7:{s:4:"name";s:4:"body";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:3:"fee";a:7:{s:4:"name";s:3:"fee";s:4:"type";s:7:"varchar";s:6:"length";s:2:"15";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:9:"final_fee";a:7:{s:4:"name";s:9:"final_fee";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:4:"0.00";}s:7:"credit1";a:7:{s:4:"name";s:7:"credit1";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:11:"credit1_fee";a:7:{s:4:"name";s:11:"credit1_fee";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:4:"0.00";}s:7:"credit2";a:7:{s:4:"name";s:7:"credit2";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:4:"0.00";}s:4:"cash";a:7:{s:4:"name";s:4:"cash";s:4:"type";s:7:"decimal";s:6:"length";s:4:"10,2";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:4:"0.00";}s:6:"remark";a:7:{s:4:"name";s:6:"remark";s:4:"type";s:7:"varchar";s:6:"length";s:3:"255";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:9:"auth_code";a:7:{s:4:"name";s:9:"auth_code";s:4:"type";s:7:"varchar";s:6:"length";s:2:"30";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:6:"openid";a:7:{s:4:"name";s:6:"openid";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:8:"nickname";a:7:{s:4:"name";s:8:"nickname";s:4:"type";s:7:"varchar";s:6:"length";s:2:"50";s:4:"null";b:0;s:6:"signed";b:1;s:9:"increment";b:0;s:7:"default";N;}s:6:"follow";a:7:{s:4:"name";s:6:"follow";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:6:"status";a:7:{s:4:"name";s:6:"status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:13:"credit_status";a:7:{s:4:"name";s:13:"credit_status";s:4:"type";s:7:"tinyint";s:6:"length";s:1:"3";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:7:"paytime";a:7:{s:4:"name";s:7:"paytime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}s:10:"createtime";a:7:{s:4:"name";s:10:"createtime";s:4:"type";s:3:"int";s:6:"length";s:2:"10";s:4:"null";b:0;s:6:"signed";b:0;s:9:"increment";b:0;s:7:"default";s:1:"0";}}s:7:"indexes";a:2:{s:7:"PRIMARY";a:3:{s:4:"name";s:7:"PRIMARY";s:4:"type";s:7:"primary";s:6:"fields";a:1:{i:0;s:2:"id";}}s:7:"uniacid";a:3:{s:4:"name";s:7:"uniacid";s:4:"type";s:5:"index";s:6:"fields";a:1:{i:0;s:7:"uniacid";}}}}}s:5:"files";a:0:{}s:7:"version";s:6:"X2.0.0";s:7:"release";s:14:"(201903170006)";s:7:"upgrade";b:1;}s:10:"lastupdate";i:1553059216;}');
INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('we7:system_frame:1', 'a:21:{s:7:"welcome";a:7:{s:5:"title";s:6:"首页";s:4:"icon";s:10:"wi wi-home";s:3:"url";s:48:"./index.php?c=home&a=welcome&do=system&page=home";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:2;}s:8:"platform";a:8:{s:5:"title";s:12:"平台入口";s:4:"icon";s:14:"wi wi-platform";s:9:"dimension";i:2;s:3:"url";s:44:"./index.php?c=account&a=display&do=platform&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:3;}s:6:"module";a:8:{s:5:"title";s:12:"应用入口";s:4:"icon";s:11:"wi wi-apply";s:9:"dimension";i:2;s:3:"url";s:53:"./index.php?c=module&a=display&do=switch_last_module&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:4;}s:14:"account_manage";a:8:{s:5:"title";s:12:"平台管理";s:4:"icon";s:21:"wi wi-platform-manage";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=account&a=manage&";s:7:"section";a:1:{s:14:"account_manage";a:2:{s:5:"title";s:12:"平台管理";s:4:"menu";a:3:{s:22:"account_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台列表";s:3:"url";s:31:"./index.php?c=account&a=manage&";s:15:"permission_name";s:22:"account_manage_display";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:1:{i:0;a:2:{s:5:"title";s:12:"帐号停用";s:15:"permission_name";s:19:"account_manage_stop";}}}s:22:"account_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:32:"./index.php?c=account&a=recycle&";s:15:"permission_name";s:22:"account_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"帐号删除";s:15:"permission_name";s:21:"account_manage_delete";}i:1;a:2:{s:5:"title";s:12:"帐号恢复";s:15:"permission_name";s:22:"account_manage_recover";}}}s:30:"account_manage_system_platform";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:19:" 微信开放平台";s:3:"url";s:32:"./index.php?c=system&a=platform&";s:15:"permission_name";s:30:"account_manage_system_platform";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:5;}s:13:"module_manage";a:8:{s:5:"title";s:12:"应用管理";s:4:"icon";s:19:"wi wi-module-manage";s:9:"dimension";i:2;s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:7:"section";a:1:{s:13:"module_manage";a:2:{s:5:"title";s:12:"应用管理";s:4:"menu";a:5:{s:23:"module_manage_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已安装列表";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=installed&";s:15:"permission_name";s:23:"module_manage_installed";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:20:"module_manage_stoped";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"已停用列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=1";s:15:"permission_name";s:20:"module_manage_stoped";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:27:"module_manage_not_installed";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"未安装列表";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=not_installed&";s:15:"permission_name";s:27:"module_manage_not_installed";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"module_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:54:"./index.php?c=module&a=manage-system&do=recycle&type=2";s:15:"permission_name";s:21:"module_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:23:"module_manage_subscribe";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"订阅管理";s:3:"url";s:50:"./index.php?c=module&a=manage-system&do=subscribe&";s:15:"permission_name";s:23:"module_manage_subscribe";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:6;}s:11:"user_manage";a:8:{s:5:"title";s:12:"用户管理";s:4:"icon";s:16:"wi wi-user-group";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=display&";s:7:"section";a:1:{s:11:"user_manage";a:2:{s:5:"title";s:12:"用户管理";s:4:"menu";a:7:{s:19:"user_manage_display";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"普通用户";s:3:"url";s:29:"./index.php?c=user&a=display&";s:15:"permission_name";s:19:"user_manage_display";s:4:"icon";N;s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_founder";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"副站长";s:3:"url";s:32:"./index.php?c=founder&a=display&";s:15:"permission_name";s:19:"user_manage_founder";s:4:"icon";N;s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_clerk";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"店员管理";s:3:"url";s:39:"./index.php?c=user&a=display&type=clerk";s:15:"permission_name";s:17:"user_manage_clerk";s:4:"icon";N;s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:17:"user_manage_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"审核用户";s:3:"url";s:39:"./index.php?c=user&a=display&type=check";s:15:"permission_name";s:17:"user_manage_check";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:19:"user_manage_recycle";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"回收站";s:3:"url";s:41:"./index.php?c=user&a=display&type=recycle";s:15:"permission_name";s:19:"user_manage_recycle";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_fields";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户属性设置";s:3:"url";s:39:"./index.php?c=user&a=fields&do=display&";s:15:"permission_name";s:18:"user_manage_fields";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:18:"user_manage_expire";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户过期设置";s:3:"url";s:28:"./index.php?c=user&a=expire&";s:15:"permission_name";s:18:"user_manage_expire";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:7;}s:10:"permission";a:8:{s:5:"title";s:9:"权限组";s:4:"icon";s:22:"wi wi-userjurisdiction";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=module&a=group&";s:7:"section";a:1:{s:10:"permission";a:2:{s:5:"title";s:9:"权限组";s:4:"menu";a:4:{s:23:"permission_module_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:29:"./index.php?c=module&a=group&";s:15:"permission_name";s:23:"permission_module_group";s:4:"icon";N;s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:31:"permission_create_account_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"账号权限组";s:3:"url";s:34:"./index.php?c=user&a=create-group&";s:15:"permission_name";s:31:"permission_create_account_group";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:21:"permission_user_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"用户权限组合";s:3:"url";s:27:"./index.php?c=user&a=group&";s:15:"permission_name";s:21:"permission_user_group";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:0:{}}s:24:"permission_founder_group";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:21:"副站长权限组合";s:3:"url";s:30:"./index.php?c=founder&a=group&";s:15:"permission_name";s:24:"permission_founder_group";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:0:{}}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:8;}s:6:"system";a:8:{s:5:"title";s:12:"系统功能";s:4:"icon";s:13:"wi wi-setting";s:9:"dimension";i:3;s:3:"url";s:31:"./index.php?c=article&a=notice&";s:7:"section";a:5:{s:7:"article";a:3:{s:5:"title";s:12:"站内公告";s:4:"menu";a:1:{s:14:"system_article";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站内公告";s:3:"url";s:31:"./index.php?c=article&a=notice&";s:15:"permission_name";s:14:"system_article";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:12:"公告列表";s:15:"permission_name";s:26:"system_article_notice_list";}i:1;a:2:{s:5:"title";s:12:"公告分类";s:15:"permission_name";s:30:"system_article_notice_category";}}}}s:7:"founder";b:1;}s:15:"system_template";a:3:{s:5:"title";s:6:"模板";s:4:"menu";a:1:{s:15:"system_template";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"微官网模板";s:3:"url";s:32:"./index.php?c=system&a=template&";s:15:"permission_name";s:15:"system_template";s:4:"icon";s:17:"wi wi-wx-template";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:14:"system_welcome";a:3:{s:5:"title";s:12:"系统首页";s:4:"menu";a:2:{s:14:"system_welcome";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统首页应用";s:3:"url";s:60:"./index.php?c=module&a=manage-system&support=welcome_support";s:15:"permission_name";s:14:"system_welcome";s:4:"icon";s:20:"wi wi-system-welcome";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:11:"system_news";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统新闻";s:3:"url";s:29:"./index.php?c=article&a=news&";s:15:"permission_name";s:11:"system_news";s:4:"icon";s:13:"wi wi-article";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:2:{i:0;a:2:{s:5:"title";s:13:"新闻列表 ";s:15:"permission_name";s:24:"system_article_news_list";}i:1;a:2:{s:5:"title";s:13:"新闻分类 ";s:15:"permission_name";s:28:"system_article_news_category";}}}}s:7:"founder";b:1;}s:17:"system_statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:23:"system_account_analysis";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"访问统计";s:3:"url";s:35:"./index.php?c=statistics&a=account&";s:15:"permission_name";s:23:"system_account_analysis";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:7:"founder";b:1;}s:5:"cache";a:2:{s:5:"title";s:6:"缓存";s:4:"menu";a:1:{s:26:"system_setting_updatecache";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"更新缓存";s:3:"url";s:35:"./index.php?c=system&a=updatecache&";s:15:"permission_name";s:26:"system_setting_updatecache";s:4:"icon";s:12:"wi wi-update";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:9;}s:4:"site";a:9:{s:5:"title";s:12:"站点设置";s:4:"icon";s:17:"wi wi-system-site";s:9:"dimension";i:3;s:3:"url";s:28:"./index.php?c=system&a=site&";s:7:"section";a:4:{s:5:"cloud";a:2:{s:5:"title";s:9:"云服务";s:4:"menu";a:3:{s:14:"system_profile";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统升级";s:3:"url";s:30:"./index.php?c=cloud&a=upgrade&";s:15:"permission_name";s:20:"system_cloud_upgrade";s:4:"icon";s:11:"wi wi-cache";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_register";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"注册站点";s:3:"url";s:30:"./index.php?c=cloud&a=profile&";s:15:"permission_name";s:21:"system_cloud_register";s:4:"icon";s:18:"wi wi-registersite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:21:"system_cloud_diagnose";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"云服务诊断";s:3:"url";s:31:"./index.php?c=cloud&a=diagnose&";s:15:"permission_name";s:21:"system_cloud_diagnose";s:4:"icon";s:14:"wi wi-diagnose";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"setting";a:2:{s:5:"title";s:6:"设置";s:4:"menu";a:9:{s:19:"system_setting_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"站点设置";s:3:"url";s:28:"./index.php?c=system&a=site&";s:15:"permission_name";s:19:"system_setting_site";s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:9;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"菜单设置";s:3:"url";s:28:"./index.php?c=system&a=menu&";s:15:"permission_name";s:19:"system_setting_menu";s:4:"icon";s:18:"wi wi-menu-setting";s:12:"displayorder";i:8;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_attachment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"附件设置";s:3:"url";s:34:"./index.php?c=system&a=attachment&";s:15:"permission_name";s:25:"system_setting_attachment";s:4:"icon";s:16:"wi wi-attachment";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_systeminfo";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"系统信息";s:3:"url";s:34:"./index.php?c=system&a=systeminfo&";s:15:"permission_name";s:25:"system_setting_systeminfo";s:4:"icon";s:17:"wi wi-system-info";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_setting_logs";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"查看日志";s:3:"url";s:28:"./index.php?c=system&a=logs&";s:15:"permission_name";s:19:"system_setting_logs";s:4:"icon";s:9:"wi wi-log";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:26:"system_setting_ipwhitelist";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:11:"IP白名单";s:3:"url";s:35:"./index.php?c=system&a=ipwhitelist&";s:15:"permission_name";s:26:"system_setting_ipwhitelist";s:4:"icon";s:8:"wi wi-ip";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:28:"system_setting_sensitiveword";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"过滤敏感词";s:3:"url";s:37:"./index.php?c=system&a=sensitiveword&";s:15:"permission_name";s:28:"system_setting_sensitiveword";s:4:"icon";s:15:"wi wi-sensitive";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"system_setting_thirdlogin";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:25:"用户登录/注册设置";s:3:"url";s:33:"./index.php?c=user&a=registerset&";s:15:"permission_name";s:25:"system_setting_thirdlogin";s:4:"icon";s:10:"wi wi-user";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_setting_oauth";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"全局借用权限";s:3:"url";s:29:"./index.php?c=system&a=oauth&";s:15:"permission_name";s:20:"system_setting_oauth";s:4:"icon";s:11:"wi wi-oauth";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"utility";a:2:{s:5:"title";s:12:"常用工具";s:4:"menu";a:6:{s:24:"system_utility_filecheck";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统文件校验";s:3:"url";s:33:"./index.php?c=system&a=filecheck&";s:15:"permission_name";s:24:"system_utility_filecheck";s:4:"icon";s:10:"wi wi-file";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_optimize";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"性能优化";s:3:"url";s:32:"./index.php?c=system&a=optimize&";s:15:"permission_name";s:23:"system_utility_optimize";s:4:"icon";s:14:"wi wi-optimize";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:23:"system_utility_database";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:9:"数据库";s:3:"url";s:32:"./index.php?c=system&a=database&";s:15:"permission_name";s:23:"system_utility_database";s:4:"icon";s:9:"wi wi-sql";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"system_utility_scan";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"木马查杀";s:3:"url";s:28:"./index.php?c=system&a=scan&";s:15:"permission_name";s:19:"system_utility_scan";s:4:"icon";s:12:"wi wi-safety";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:18:"system_utility_bom";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"检测文件BOM";s:3:"url";s:27:"./index.php?c=system&a=bom&";s:15:"permission_name";s:18:"system_utility_bom";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:20:"system_utility_check";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"系统常规检测";s:3:"url";s:29:"./index.php?c=system&a=check&";s:15:"permission_name";s:20:"system_utility_check";s:4:"icon";s:9:"wi wi-bom";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"backjob";a:2:{s:5:"title";s:12:"后台任务";s:4:"menu";a:1:{s:10:"system_job";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"后台任务";s:3:"url";s:38:"./index.php?c=system&a=job&do=display&";s:15:"permission_name";s:10:"system_job";s:4:"icon";s:9:"wi wi-job";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:7:"founder";b:1;s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:10;}s:6:"myself";a:8:{s:5:"title";s:12:"我的账户";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:29:"./index.php?c=user&a=profile&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:11;}s:7:"message";a:8:{s:5:"title";s:12:"消息管理";s:4:"icon";s:10:"wi wi-bell";s:9:"dimension";i:2;s:3:"url";s:31:"./index.php?c=message&a=notice&";s:7:"section";a:1:{s:7:"message";a:2:{s:5:"title";s:12:"消息管理";s:4:"menu";a:3:{s:14:"message_notice";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息提醒";s:3:"url";s:31:"./index.php?c=message&a=notice&";s:15:"permission_name";s:14:"message_notice";s:4:"icon";N;s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:15:"message_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"消息设置";s:3:"url";s:42:"./index.php?c=message&a=notice&do=setting&";s:15:"permission_name";s:15:"message_setting";s:4:"icon";N;s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:22:"message_wechat_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"微信提醒设置";s:3:"url";s:49:"./index.php?c=message&a=notice&do=wechat_setting&";s:15:"permission_name";s:22:"message_wechat_setting";s:4:"icon";N;s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:12;}s:7:"account";a:8:{s:5:"title";s:9:"公众号";s:4:"icon";s:18:"wi wi-white-collar";s:9:"dimension";i:3;s:3:"url";s:41:"./index.php?c=home&a=welcome&do=platform&";s:7:"section";a:5:{s:8:"platform";a:2:{s:5:"title";s:12:"增强功能";s:4:"menu";a:6:{s:14:"platform_reply";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"自动回复";s:3:"url";s:31:"./index.php?c=platform&a=reply&";s:15:"permission_name";s:14:"platform_reply";s:4:"icon";s:11:"wi wi-reply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:7:{s:22:"platform_reply_keyword";a:4:{s:5:"title";s:21:"关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=keyword";s:15:"permission_name";s:22:"platform_reply_keyword";s:6:"active";s:7:"keyword";}s:22:"platform_reply_special";a:4:{s:5:"title";s:24:"非关键字自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=special";s:15:"permission_name";s:22:"platform_reply_special";s:6:"active";s:7:"special";}s:22:"platform_reply_welcome";a:4:{s:5:"title";s:24:"首次访问自动回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=welcome";s:15:"permission_name";s:22:"platform_reply_welcome";s:6:"active";s:7:"welcome";}s:22:"platform_reply_default";a:4:{s:5:"title";s:12:"默认回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=default";s:15:"permission_name";s:22:"platform_reply_default";s:6:"active";s:7:"default";}s:22:"platform_reply_service";a:4:{s:5:"title";s:12:"常用服务";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=service";s:15:"permission_name";s:22:"platform_reply_service";s:6:"active";s:7:"service";}s:22:"platform_reply_userapi";a:5:{s:5:"title";s:21:"自定义接口回复";s:3:"url";s:40:"./index.php?c=platform&a=reply&m=userapi";s:15:"permission_name";s:22:"platform_reply_userapi";s:6:"active";s:7:"userapi";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"platform_reply_setting";a:4:{s:5:"title";s:12:"回复设置";s:3:"url";s:38:"./index.php?c=profile&a=reply-setting&";s:15:"permission_name";s:22:"platform_reply_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:13:"platform_menu";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:15:"自定义菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:13:"platform_menu";s:4:"icon";s:16:"wi wi-custommenu";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:21:"platform_menu_default";a:4:{s:5:"title";s:12:"默认菜单";s:3:"url";s:38:"./index.php?c=platform&a=menu&do=post&";s:15:"permission_name";s:21:"platform_menu_default";s:6:"active";s:4:"post";}s:25:"platform_menu_conditional";a:5:{s:5:"title";s:15:"个性化菜单";s:3:"url";s:47:"./index.php?c=platform&a=menu&do=display&type=3";s:15:"permission_name";s:25:"platform_menu_conditional";s:6:"active";s:7:"display";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:11:"platform_qr";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:1;s:5:"title";s:22:"二维码/转化链接";s:3:"url";s:28:"./index.php?c=platform&a=qr&";s:15:"permission_name";s:11:"platform_qr";s:4:"icon";s:12:"wi wi-qrcode";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";a:2:{s:14:"platform_qr_qr";a:4:{s:5:"title";s:9:"二维码";s:3:"url";s:36:"./index.php?c=platform&a=qr&do=list&";s:15:"permission_name";s:14:"platform_qr_qr";s:6:"active";s:4:"list";}s:22:"platform_qr_statistics";a:4:{s:5:"title";s:21:"二维码扫描统计";s:3:"url";s:39:"./index.php?c=platform&a=qr&do=display&";s:15:"permission_name";s:22:"platform_qr_statistics";s:6:"active";s:7:"display";}}}s:17:"platform_masstask";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"定时群发";s:3:"url";s:30:"./index.php?c=platform&a=mass&";s:15:"permission_name";s:17:"platform_masstask";s:4:"icon";s:13:"wi wi-crontab";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:22:"platform_masstask_post";a:4:{s:5:"title";s:12:"定时群发";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=post&";s:15:"permission_name";s:22:"platform_masstask_post";s:6:"active";s:4:"post";}s:22:"platform_masstask_send";a:4:{s:5:"title";s:12:"群发记录";s:3:"url";s:38:"./index.php?c=platform&a=mass&do=send&";s:15:"permission_name";s:22:"platform_masstask_send";s:6:"active";s:4:"send";}}}s:17:"platform_material";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:16:"素材/编辑器";s:3:"url";s:34:"./index.php?c=platform&a=material&";s:15:"permission_name";s:17:"platform_material";s:4:"icon";s:12:"wi wi-redact";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:5:{s:22:"platform_material_news";a:4:{s:5:"title";s:6:"图文";s:3:"url";s:43:"./index.php?c=platform&a=material&type=news";s:15:"permission_name";s:22:"platform_material_news";s:6:"active";s:4:"news";}s:23:"platform_material_image";a:4:{s:5:"title";s:6:"图片";s:3:"url";s:44:"./index.php?c=platform&a=material&type=image";s:15:"permission_name";s:23:"platform_material_image";s:6:"active";s:5:"image";}s:23:"platform_material_voice";a:4:{s:5:"title";s:6:"语音";s:3:"url";s:44:"./index.php?c=platform&a=material&type=voice";s:15:"permission_name";s:23:"platform_material_voice";s:6:"active";s:5:"voice";}s:23:"platform_material_video";a:5:{s:5:"title";s:6:"视频";s:3:"url";s:44:"./index.php?c=platform&a=material&type=video";s:15:"permission_name";s:23:"platform_material_video";s:6:"active";s:5:"video";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"platform_material_delete";a:3:{s:5:"title";s:6:"删除";s:15:"permission_name";s:24:"platform_material_delete";s:10:"is_display";b:0;}}}s:13:"platform_site";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:1;s:5:"title";s:16:"微官网-文章";s:3:"url";s:27:"./index.php?c=site&a=multi&";s:15:"permission_name";s:13:"platform_site";s:4:"icon";s:10:"wi wi-home";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:19:"platform_site_multi";a:4:{s:5:"title";s:9:"微官网";s:3:"url";s:38:"./index.php?c=site&a=multi&do=display&";s:15:"permission_name";s:19:"platform_site_multi";s:6:"active";s:5:"multi";}s:19:"platform_site_style";a:4:{s:5:"title";s:15:"微官网模板";s:3:"url";s:39:"./index.php?c=site&a=style&do=template&";s:15:"permission_name";s:19:"platform_site_style";s:6:"active";s:5:"style";}s:21:"platform_site_article";a:4:{s:5:"title";s:12:"文章管理";s:3:"url";s:40:"./index.php?c=site&a=article&do=display&";s:15:"permission_name";s:21:"platform_site_article";s:6:"active";s:7:"article";}s:22:"platform_site_category";a:4:{s:5:"title";s:18:"文章分类管理";s:3:"url";s:41:"./index.php?c=site&a=category&do=display&";s:15:"permission_name";s:22:"platform_site_category";s:6:"active";s:8:"category";}}}}}s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:2:{s:5:"title";s:6:"粉丝";s:4:"menu";a:3:{s:7:"mc_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"粉丝管理";s:3:"url";s:24:"./index.php?c=mc&a=fans&";s:15:"permission_name";s:7:"mc_fans";s:4:"icon";s:16:"wi wi-fansmanage";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";a:2:{s:15:"mc_fans_display";a:4:{s:5:"title";s:12:"全部粉丝";s:3:"url";s:35:"./index.php?c=mc&a=fans&do=display&";s:15:"permission_name";s:15:"mc_fans_display";s:6:"active";s:7:"display";}s:21:"mc_fans_fans_sync_set";a:4:{s:5:"title";s:18:"粉丝同步设置";s:3:"url";s:41:"./index.php?c=mc&a=fans&do=fans_sync_set&";s:15:"permission_name";s:21:"mc_fans_fans_sync_set";s:6:"active";s:13:"fans_sync_set";}}}s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:1;s:5:"title";s:12:"会员管理";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:9:"mc_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:7:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:12:"mc_member_uc";a:5:{s:5:"title";s:12:"会员中心";s:3:"url";s:34:"./index.php?c=site&a=editor&do=uc&";s:15:"permission_name";s:12:"mc_member_uc";s:6:"active";s:2:"uc";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:19:"mc_member_quickmenu";a:5:{s:5:"title";s:12:"快捷菜单";s:3:"url";s:41:"./index.php?c=site&a=editor&do=quickmenu&";s:15:"permission_name";s:19:"mc_member_quickmenu";s:6:"active";s:9:"quickmenu";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"mc_member_register_seting";a:5:{s:5:"title";s:12:"注册设置";s:3:"url";s:46:"./index.php?c=mc&a=member&do=register_setting&";s:15:"permission_name";s:25:"mc_member_register_seting";s:6:"active";s:16:"register_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}s:10:"mc_message";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"留言管理";s:3:"url";s:27:"./index.php?c=mc&a=message&";s:15:"permission_name";s:10:"mc_message";s:4:"icon";s:13:"wi wi-message";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:7:"profile";a:2:{s:5:"title";s:6:"配置";s:4:"menu";a:7:{s:15:"profile_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:15:"profile_setting";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:7;s:2:"id";N;s:14:"sub_permission";a:6:{s:22:"profile_setting_remote";a:4:{s:5:"title";s:12:"远程附件";s:3:"url";s:42:"./index.php?c=profile&a=remote&do=display&";s:15:"permission_name";s:22:"profile_setting_remote";s:6:"active";s:7:"display";}s:24:"profile_setting_passport";a:5:{s:5:"title";s:12:"借用权限";s:3:"url";s:42:"./index.php?c=profile&a=passport&do=oauth&";s:15:"permission_name";s:24:"profile_setting_passport";s:6:"active";s:5:"oauth";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:25:"profile_setting_tplnotice";a:5:{s:5:"title";s:18:"微信通知设置";s:3:"url";s:42:"./index.php?c=profile&a=tplnotice&do=list&";s:15:"permission_name";s:25:"profile_setting_tplnotice";s:6:"active";s:4:"list";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:22:"profile_setting_notify";a:5:{s:5:"title";s:18:"邮件通知参数";s:3:"url";s:39:"./index.php?c=profile&a=notify&do=mail&";s:15:"permission_name";s:22:"profile_setting_notify";s:6:"active";s:4:"mail";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:26:"profile_setting_uc_setting";a:5:{s:5:"title";s:14:"UC站点整合";s:3:"url";s:45:"./index.php?c=profile&a=common&do=uc_setting&";s:15:"permission_name";s:26:"profile_setting_uc_setting";s:6:"active";s:10:"uc_setting";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}s:27:"profile_setting_upload_file";a:5:{s:5:"title";s:20:"上传JS接口文件";s:3:"url";s:46:"./index.php?c=profile&a=common&do=upload_file&";s:15:"permission_name";s:27:"profile_setting_upload_file";s:6:"active";s:11:"upload_file";s:10:"is_display";a:2:{i:0;i:1;i:1;i:3;}}}}s:15:"profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:2:{i:0;i:1;i:1;i:3;}s:10:"is_display";i:1;s:5:"title";s:12:"支付参数";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:15:"profile_payment";s:4:"icon";s:17:"wi wi-pay-setting";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";a:2:{s:19:"profile_payment_pay";a:4:{s:5:"title";s:12:"支付配置";s:3:"url";s:32:"./index.php?c=profile&a=payment&";s:15:"permission_name";s:19:"profile_payment_pay";s:6:"active";s:7:"payment";}s:22:"profile_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:42:"./index.php?c=profile&a=refund&do=display&";s:15:"permission_name";s:22:"profile_payment_refund";s:6:"active";s:6:"refund";}}}s:23:"profile_app_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:31:"profile_app_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:19:"profile_bind_domain";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"域名绑定";s:3:"url";s:36:"./index.php?c=profile&a=bind-domain&";s:15:"permission_name";s:19:"profile_bind_domain";s:4:"icon";s:17:"wi wi-bind-domain";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:44:"./index.php?c=profile&a=module-link-uniacid&";s:15:"permission_name";s:18:"webapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:14:"webapp_rewrite";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:9:"伪静态";s:3:"url";s:31:"./index.php?c=webapp&a=rewrite&";s:15:"permission_name";s:14:"webapp_rewrite";s:4:"icon";s:13:"wi wi-rewrite";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:18:"webapp_bind_domain";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:5;}s:10:"is_display";i:0;s:5:"title";s:18:"域名访问设置";s:3:"url";s:35:"./index.php?c=webapp&a=bind-domain&";s:15:"permission_name";s:18:"webapp_bind_domain";s:4:"icon";s:17:"wi wi-bind-domain";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:10:"statistics";a:2:{s:5:"title";s:6:"统计";s:4:"menu";a:2:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:5:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;i:4;i:5;}s:10:"is_display";i:1;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:16:"statistics_visit";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}s:15:"statistics_fans";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:4:{i:0;i:1;i:1;i:3;i:2;i:9;i:3;i:10;}s:10:"is_display";i:1;s:5:"title";s:12:"用户统计";s:3:"url";s:32:"./index.php?c=statistics&a=fans&";s:15:"permission_name";s:15:"statistics_fans";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:13;}s:5:"wxapp";a:8:{s:5:"title";s:15:"微信小程序";s:4:"icon";s:19:"wi wi-small-routine";s:9:"dimension";i:3;s:3:"url";s:38:"./index.php?c=wxapp&a=display&do=home&";s:7:"section";a:5:{s:14:"wxapp_entrance";a:3:{s:5:"title";s:15:"小程序入口";s:4:"menu";a:1:{s:20:"module_entrance_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"入口页面";s:3:"url";s:36:"./index.php?c=wxapp&a=entrance-link&";s:15:"permission_name";s:19:"wxapp_entrance_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";i:0;}s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:2:"mc";a:3:{s:5:"title";s:6:"粉丝";s:4:"menu";a:1:{s:9:"mc_member";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:6:"会员";s:3:"url";s:26:"./index.php?c=mc&a=member&";s:15:"permission_name";s:15:"mc_wxapp_member";s:4:"icon";s:10:"wi wi-fans";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:4:{s:17:"mc_member_diaplsy";a:4:{s:5:"title";s:12:"会员管理";s:3:"url";s:37:"./index.php?c=mc&a=member&do=display&";s:15:"permission_name";s:17:"mc_member_diaplsy";s:6:"active";s:7:"display";}s:15:"mc_member_group";a:4:{s:5:"title";s:9:"会员组";s:3:"url";s:36:"./index.php?c=mc&a=group&do=display&";s:15:"permission_name";s:15:"mc_member_group";s:6:"active";s:7:"display";}s:24:"mc_member_credit_setting";a:4:{s:5:"title";s:12:"积分设置";s:3:"url";s:44:"./index.php?c=mc&a=member&do=credit_setting&";s:15:"permission_name";s:24:"mc_member_credit_setting";s:6:"active";s:14:"credit_setting";}s:16:"mc_member_fields";a:4:{s:5:"title";s:18:"会员字段管理";s:3:"url";s:34:"./index.php?c=mc&a=fields&do=list&";s:15:"permission_name";s:16:"mc_member_fields";s:6:"active";s:4:"list";}}}}s:10:"is_display";i:0;}s:13:"wxapp_profile";a:2:{s:5:"title";s:6:"配置";s:4:"menu";a:5:{s:33:"wxapp_profile_module_link_uniacid";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:33:"wxapp_profile_module_link_uniacid";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:21:"wxapp_profile_payment";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"支付参数";s:3:"url";s:30:"./index.php?c=wxapp&a=payment&";s:15:"permission_name";s:21:"wxapp_profile_payment";s:4:"icon";s:16:"wi wi-appsetting";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";a:2:{s:17:"wxapp_payment_pay";a:4:{s:5:"title";s:12:"支付参数";s:3:"url";s:41:"./index.php?c=wxapp&a=payment&do=display&";s:15:"permission_name";s:17:"wxapp_payment_pay";s:6:"active";s:7:"payment";}s:20:"wxapp_payment_refund";a:4:{s:5:"title";s:12:"退款配置";s:3:"url";s:40:"./index.php?c=wxapp&a=refund&do=display&";s:15:"permission_name";s:20:"wxapp_payment_refund";s:6:"active";s:6:"refund";}}}s:28:"wxapp_profile_front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";i:1;s:10:"is_display";i:1;s:5:"title";s:15:"下载程序包";s:3:"url";s:37:"./index.php?c=wxapp&a=front-download&";s:15:"permission_name";s:28:"wxapp_profile_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:23:"wxapp_profile_domainset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"域名设置";s:3:"url";s:32:"./index.php?c=wxapp&a=domainset&";s:15:"permission_name";s:23:"wxapp_profile_domainset";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:22:"profile_setting_remote";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:3:{i:0;i:4;i:1;i:7;i:2;i:8;}s:10:"is_display";i:0;s:5:"title";s:12:"参数配置";s:3:"url";s:31:"./index.php?c=profile&a=remote&";s:15:"permission_name";s:22:"profile_setting_remote";s:4:"icon";s:23:"wi wi-parameter-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}}}s:10:"statistics";a:3:{s:5:"title";s:6:"统计";s:4:"menu";a:1:{s:16:"statistics_visit";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:7:{i:0;i:4;i:1;i:7;i:2;i:8;i:3;i:6;i:4;i:11;i:5;i:12;i:6;i:13;}s:10:"is_display";i:0;s:5:"title";s:12:"访问统计";s:3:"url";s:31:"./index.php?c=statistics&a=app&";s:15:"permission_name";s:22:"statistics_visit_wxapp";s:4:"icon";s:17:"wi wi-statistical";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";a:3:{s:20:"statistics_visit_app";a:4:{s:5:"title";s:24:"app端访问统计信息";s:3:"url";s:42:"./index.php?c=statistics&a=app&do=display&";s:15:"permission_name";s:20:"statistics_visit_app";s:6:"active";s:3:"app";}s:21:"statistics_visit_site";a:4:{s:5:"title";s:24:"所有用户访问统计";s:3:"url";s:51:"./index.php?c=statistics&a=site&do=current_account&";s:15:"permission_name";s:21:"statistics_visit_site";s:6:"active";s:4:"site";}s:24:"statistics_visit_setting";a:4:{s:5:"title";s:18:"访问统计设置";s:3:"url";s:46:"./index.php?c=statistics&a=setting&do=display&";s:15:"permission_name";s:24:"statistics_visit_setting";s:6:"active";s:7:"setting";}}}}s:10:"is_display";i:0;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:14;}s:6:"webapp";a:7:{s:5:"title";s:2:"PC";s:4:"icon";s:8:"wi wi-pc";s:3:"url";s:39:"./index.php?c=webapp&a=home&do=display&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:15;}s:8:"phoneapp";a:7:{s:5:"title";s:3:"APP";s:4:"icon";s:18:"wi wi-white-collar";s:3:"url";s:41:"./index.php?c=phoneapp&a=display&do=home&";s:7:"section";a:2:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}s:16:"phoneapp_profile";a:3:{s:5:"title";s:6:"配置";s:4:"menu";a:2:{s:28:"profile_phoneapp_module_link";a:10:{s:9:"is_system";i:1;s:18:"permission_display";a:1:{i:0;i:6;}s:10:"is_display";i:0;s:5:"title";s:12:"数据同步";s:3:"url";s:42:"./index.php?c=wxapp&a=module-link-uniacid&";s:15:"permission_name";s:28:"profile_phoneapp_module_link";s:4:"icon";s:18:"wi wi-data-synchro";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:14:"front_download";a:10:{s:9:"is_system";i:1;s:18:"permission_display";b:1;s:10:"is_display";i:1;s:5:"title";s:9:"下载APP";s:3:"url";s:40:"./index.php?c=phoneapp&a=front-download&";s:15:"permission_name";s:23:"phoneapp_front_download";s:4:"icon";s:13:"wi wi-examine";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:16;}s:5:"xzapp";a:7:{s:5:"title";s:9:"熊掌号";s:4:"icon";s:11:"wi wi-xzapp";s:3:"url";s:38:"./index.php?c=xzapp&a=home&do=display&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:12:"应用模块";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:17;}s:6:"aliapp";a:7:{s:5:"title";s:18:"支付宝小程序";s:4:"icon";s:12:"wi wi-aliapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:18;}s:8:"baiduapp";a:7:{s:5:"title";s:15:"百度小程序";s:4:"icon";s:14:"wi wi-baiduapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:19;}s:10:"toutiaoapp";a:7:{s:5:"title";s:15:"头条小程序";s:4:"icon";s:16:"wi wi-toutiaoapp";s:3:"url";s:40:"./index.php?c=miniapp&a=display&do=home&";s:7:"section";a:1:{s:15:"platform_module";a:3:{s:5:"title";s:6:"应用";s:4:"menu";a:0:{}s:10:"is_display";b:1;}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:20;}s:5:"store";a:7:{s:5:"title";s:6:"商城";s:4:"icon";s:11:"wi wi-store";s:3:"url";s:43:"./index.php?c=home&a=welcome&do=ext&m=store";s:7:"section";a:6:{s:11:"store_goods";a:2:{s:5:"title";s:12:"商品分类";s:4:"menu";a:6:{s:18:"store_goods_module";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"应用模块";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-apply";s:12:"displayorder";i:6;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_goods_account";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台个数";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=2";s:15:"permission_name";N;s:4:"icon";s:13:"wi wi-account";s:12:"displayorder";i:5;s:2:"id";N;s:14:"sub_permission";N;}s:25:"store_goods_account_renew";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"平台续费";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=7";s:15:"permission_name";N;s:4:"icon";s:21:"wi wi-appjurisdiction";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_goods_package";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"应用权限组";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=5";s:15:"permission_name";N;s:4:"icon";s:21:"wi wi-appjurisdiction";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:25:"store_goods_users_package";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:15:"用户权限组";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=9";s:15:"permission_name";N;s:4:"icon";s:22:"wi wi-userjurisdiction";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:15:"store_goods_api";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:23:"应用访问流量(API)";s:3:"url";s:64:"./index.php?c=site&a=entry&do=goodsbuyer&m=store&direct=1&type=6";s:15:"permission_name";N;s:4:"icon";s:9:"wi wi-api";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:12:"store_manage";a:3:{s:5:"title";s:12:"商城管理";s:7:"founder";b:1;s:4:"menu";a:4:{s:18:"store_manage_goods";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"添加商品";s:3:"url";s:58:"./index.php?c=site&a=entry&do=goodsSeller&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:15:"wi wi-goods-add";s:12:"displayorder";i:4;s:2:"id";N;s:14:"sub_permission";N;}s:20:"store_manage_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"商城设置";s:3:"url";s:54:"./index.php?c=site&a=entry&do=setting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-store";s:12:"displayorder";i:3;s:2:"id";N;s:14:"sub_permission";N;}s:19:"store_manage_payset";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"支付设置";s:3:"url";s:57:"./index.php?c=site&a=entry&do=paySetting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-money";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:23:"store_manage_permission";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:18:"商城访问权限";s:3:"url";s:57:"./index.php?c=site&a=entry&do=permission&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:15:"wi wi-blacklist";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:12:"store_orders";a:2:{s:5:"title";s:12:"订单管理";s:4:"menu";a:2:{s:15:"store_orders_my";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"我的订单";s:3:"url";s:53:"./index.php?c=site&a=entry&do=orders&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:17:"wi wi-sale-record";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:17:"store_cash_orders";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"分销订单";s:3:"url";s:71:"./index.php?c=site&a=entry&do=cash&m=store&operate=cash_orders&direct=1";s:15:"permission_name";N;s:4:"icon";s:11:"wi wi-order";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:14:"store_payments";a:2:{s:5:"title";s:12:"收入明细";s:4:"menu";a:1:{s:8:"payments";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"收入明细";s:3:"url";s:55:"./index.php?c=site&a=entry&do=payments&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:17:"wi wi-sale-record";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:17:"store_cash_manage";a:2:{s:5:"title";s:12:"分销管理";s:4:"menu";a:2:{s:25:"store_manage_cash_setting";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"分销设置";s:3:"url";s:58:"./index.php?c=site&a=entry&do=cashsetting&m=store&direct=1";s:15:"permission_name";N;s:4:"icon";s:18:"wi wi-site-setting";s:12:"displayorder";i:2;s:2:"id";N;s:14:"sub_permission";N;}s:16:"store_check_cash";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"提现审核";s:3:"url";s:73:"./index.php?c=site&a=entry&do=cash&m=store&operate=consume_order&direct=1";s:15:"permission_name";N;s:4:"icon";s:18:"wi wi-check-select";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}s:10:"store_cash";a:2:{s:5:"title";s:12:"佣金管理";s:4:"menu";a:1:{s:8:"payments";a:10:{s:9:"is_system";i:1;s:18:"permission_display";N;s:10:"is_display";i:1;s:5:"title";s:12:"我的佣金";s:3:"url";s:66:"./index.php?c=site&a=entry&do=cash&m=store&operate=mycash&direct=1";s:15:"permission_name";N;s:4:"icon";s:10:"wi wi-list";s:12:"displayorder";i:1;s:2:"id";N;s:14:"sub_permission";N;}}}}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:21;}s:11:"custom_help";a:7:{s:5:"title";s:12:"本站帮助";s:4:"icon";s:12:"wi wi-market";s:3:"url";s:39:"./index.php?c=help&a=display&do=custom&";s:7:"section";a:0:{}s:9:"is_system";b:1;s:10:"is_display";b:1;s:12:"displayorder";i:22;}}'),
('cloud:transtoken', 's:39:"408eFE8wDa3kB5nIphg+fJeXNBTjTP1LipMkB3k";'),
('we7:unimodules:1', 'a:0:{}'),
('we7:module_info:basic', 'a:35:{s:3:"mid";s:1:"1";s:4:"name";s:5:"basic";s:4:"type";s:6:"system";s:5:"title";s:18:"基本文字回复";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"和您进行简单对话";s:11:"description";s:201:"一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/basic/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:basic:1', 'a:1:{s:6:"module";s:5:"basic";}');
INSERT INTO `ims_core_cache` (`key`, `value`) VALUES
('we7:module_info:news', 'a:35:{s:3:"mid";s:1:"2";s:4:"name";s:4:"news";s:4:"type";s:6:"system";s:5:"title";s:24:"基本混合图文回复";s:7:"version";s:3:"1.0";s:7:"ability";s:33:"为你提供生动的图文资讯";s:11:"description";s:272:"一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:58:"http://47.104.103.199/addons/news/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:news:1', 'a:1:{s:6:"module";s:4:"news";}'),
('we7:module_info:music', 'a:35:{s:3:"mid";s:1:"3";s:4:"name";s:5:"music";s:4:"type";s:6:"system";s:5:"title";s:18:"基本音乐回复";s:7:"version";s:3:"1.0";s:7:"ability";s:39:"提供语音、音乐等音频类回复";s:11:"description";s:183:"在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/music/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:music:1', 'a:1:{s:6:"module";s:5:"music";}'),
('we7:module_info:userapi', 'a:35:{s:3:"mid";s:1:"4";s:4:"name";s:7:"userapi";s:4:"type";s:6:"system";s:5:"title";s:21:"自定义接口回复";s:7:"version";s:3:"1.1";s:7:"ability";s:33:"更方便的第三方接口设置";s:11:"description";s:141:"自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:61:"http://47.104.103.199/addons/userapi/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:userapi:1', 'a:1:{s:6:"module";s:7:"userapi";}'),
('we7:module_info:recharge', 'a:35:{s:3:"mid";s:1:"5";s:4:"name";s:8:"recharge";s:4:"type";s:6:"system";s:5:"title";s:24:"会员中心充值模块";s:7:"version";s:3:"1.0";s:7:"ability";s:24:"提供会员充值功能";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:62:"http://47.104.103.199/addons/recharge/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:recharge:1', 'a:1:{s:6:"module";s:8:"recharge";}'),
('we7:module_info:images', 'a:35:{s:3:"mid";s:1:"7";s:4:"name";s:6:"images";s:4:"type";s:6:"system";s:5:"title";s:18:"基本图片回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://47.104.103.199/addons/images/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:images:1', 'a:1:{s:6:"module";s:6:"images";}'),
('we7:module_info:video', 'a:35:{s:3:"mid";s:1:"8";s:4:"name";s:5:"video";s:4:"type";s:6:"system";s:5:"title";s:18:"基本视频回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供图片回复";s:11:"description";s:132:"在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/video/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:video:1', 'a:1:{s:6:"module";s:5:"video";}'),
('we7:module_info:voice', 'a:35:{s:3:"mid";s:1:"9";s:4:"name";s:5:"voice";s:4:"type";s:6:"system";s:5:"title";s:18:"基本语音回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"提供语音回复";s:11:"description";s:132:"在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/voice/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:voice:1', 'a:1:{s:6:"module";s:5:"voice";}'),
('we7:module_info:wxcard', 'a:35:{s:3:"mid";s:2:"11";s:4:"name";s:6:"wxcard";s:4:"type";s:6:"system";s:5:"title";s:18:"微信卡券回复";s:7:"version";s:3:"1.0";s:7:"ability";s:18:"微信卡券回复";s:11:"description";s:18:"微信卡券回复";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://47.104.103.199/addons/wxcard/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:wxcard:1', 'a:1:{s:6:"module";s:6:"wxcard";}'),
('we7:module_info:custom', 'a:35:{s:3:"mid";s:1:"6";s:4:"name";s:6:"custom";s:4:"type";s:6:"system";s:5:"title";s:15:"多客服转接";s:7:"version";s:5:"1.0.0";s:7:"ability";s:36:"用来接入腾讯的多客服系统";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:17:"http://bbs.we7.cc";s:8:"settings";s:1:"0";s:10:"subscribes";a:0:{}s:7:"handles";a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}s:12:"isrulefields";s:1:"1";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:60:"http://47.104.103.199/addons/custom/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:custom:1', 'a:1:{s:6:"module";s:6:"custom";}'),
('we7:module_info:chats', 'a:35:{s:3:"mid";s:2:"10";s:4:"name";s:5:"chats";s:4:"type";s:6:"system";s:5:"title";s:18:"发送客服消息";s:7:"version";s:3:"1.0";s:7:"ability";s:77:"公众号可以在粉丝最后发送消息的48小时内无限制发送消息";s:11:"description";s:0:"";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/chats/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:chats:1', 'a:1:{s:6:"module";s:5:"chats";}'),
('we7:module_info:store', 'a:35:{s:3:"mid";s:2:"12";s:4:"name";s:5:"store";s:4:"type";s:8:"business";s:5:"title";s:12:"站内商城";s:7:"version";s:3:"1.0";s:7:"ability";s:12:"站内商城";s:11:"description";s:12:"站内商城";s:6:"author";s:13:"WeEngine Team";s:3:"url";s:18:"http://www.we7.cc/";s:8:"settings";s:1:"0";s:10:"subscribes";s:0:"";s:7:"handles";s:0:"";s:12:"isrulefields";s:1:"0";s:8:"issystem";s:1:"1";s:6:"target";s:1:"0";s:6:"iscard";s:1:"0";s:11:"permissions";s:0:"";s:13:"title_initial";s:0:"";s:13:"wxapp_support";s:1:"1";s:15:"welcome_support";s:1:"1";s:10:"oauth_type";s:1:"1";s:14:"webapp_support";s:1:"1";s:16:"phoneapp_support";s:1:"0";s:15:"account_support";s:1:"2";s:13:"xzapp_support";s:1:"0";s:11:"app_support";s:1:"0";s:14:"aliapp_support";s:1:"0";s:4:"logo";s:0:"";s:16:"baiduapp_support";s:1:"0";s:18:"toutiaoapp_support";s:1:"0";s:9:"isdisplay";i:1;s:7:"preview";s:59:"http://47.104.103.199/addons/store/preview.jpg?v=1553059181";s:11:"main_module";b:0;s:11:"plugin_list";a:0:{}s:12:"recycle_info";a:0:{}}'),
('we7:module_setting:store:1', 'a:1:{s:6:"module";s:5:"store";}'),
('we7:stat_todaylock:1', 'a:1:{s:6:"expire";i:1553066381;}'),
('we7:uniaccount:', 'a:1:{s:11:"encrypt_key";N;}'),
('we7:site_store_buy:6:1', 'i:0;');

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_cron`
--

CREATE TABLE IF NOT EXISTS `ims_core_cron` (
  `id` int(10) unsigned NOT NULL,
  `cloudid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `lastruntime` int(10) unsigned NOT NULL,
  `nextruntime` int(10) unsigned NOT NULL,
  `weekday` tinyint(3) NOT NULL,
  `day` tinyint(3) NOT NULL,
  `hour` tinyint(3) NOT NULL,
  `minute` varchar(255) NOT NULL,
  `extra` varchar(5000) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_cron_record`
--

CREATE TABLE IF NOT EXISTS `ims_core_cron_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `tid` int(10) unsigned NOT NULL,
  `note` varchar(500) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_job`
--

CREATE TABLE IF NOT EXISTS `ims_core_job` (
  `id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `payload` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `title` varchar(22) NOT NULL,
  `handled` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_menu`
--

CREATE TABLE IF NOT EXISTS `ims_core_menu` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `title` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `append_title` varchar(30) NOT NULL,
  `append_url` varchar(255) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_system` tinyint(3) unsigned NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `icon` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_menu_shortcut`
--

CREATE TABLE IF NOT EXISTS `ims_core_menu_shortcut` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `updatetime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_paylog`
--

CREATE TABLE IF NOT EXISTS `ims_core_paylog` (
  `plid` bigint(11) unsigned NOT NULL,
  `type` varchar(20) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `acid` int(10) NOT NULL,
  `openid` varchar(40) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `tid` varchar(128) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `tag` varchar(2000) NOT NULL,
  `is_usecard` tinyint(3) unsigned NOT NULL,
  `card_type` tinyint(3) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `card_fee` decimal(10,2) unsigned NOT NULL,
  `encrypt_code` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_performance`
--

CREATE TABLE IF NOT EXISTS `ims_core_performance` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `runtime` varchar(10) NOT NULL,
  `runurl` varchar(512) NOT NULL,
  `runsql` varchar(512) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_queue`
--

CREATE TABLE IF NOT EXISTS `ims_core_queue` (
  `qid` bigint(20) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `message` varchar(2000) NOT NULL,
  `params` varchar(1000) NOT NULL,
  `keyword` varchar(1000) NOT NULL,
  `response` varchar(2000) NOT NULL,
  `module` varchar(50) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_refundlog`
--

CREATE TABLE IF NOT EXISTS `ims_core_refundlog` (
  `id` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `refund_uniontid` varchar(64) NOT NULL,
  `reason` varchar(80) NOT NULL,
  `uniontid` varchar(64) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_resource`
--

CREATE TABLE IF NOT EXISTS `ims_core_resource` (
  `mid` int(11) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `trunk` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `dateline` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_sendsms_log`
--

CREATE TABLE IF NOT EXISTS `ims_core_sendsms_log` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `result` varchar(255) NOT NULL,
  `createtime` int(11) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_sessions`
--

CREATE TABLE IF NOT EXISTS `ims_core_sessions` (
  `sid` char(32) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `data` varchar(5000) NOT NULL,
  `expiretime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_core_settings`
--

CREATE TABLE IF NOT EXISTS `ims_core_settings` (
  `key` varchar(200) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_core_settings`
--

INSERT INTO `ims_core_settings` (`key`, `value`) VALUES
('copyright', 'a:1:{s:6:"slides";a:3:{i:0;s:58:"https://img.alicdn.com/tps/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg";i:1;s:58:"https://img.alicdn.com/tps/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg";i:2;s:58:"https://img.alicdn.com/tps/TB1h9xxIFXXXXbKXXXXXXXXXXXX.jpg";}}'),
('authmode', 'i:1;'),
('close', 'a:2:{s:6:"status";s:1:"0";s:6:"reason";s:0:"";}'),
('register', 'a:4:{s:4:"open";i:1;s:6:"verify";i:0;s:4:"code";i:1;s:7:"groupid";i:1;}'),
('site', 'a:5:{s:3:"key";s:9:"229155853";s:5:"token";s:32:"g5zhijnotw18fry60bq7sv239cxdpk4e";s:3:"url";s:14:"47.104.103.199";s:7:"version";s:5:"2.0.0";s:15:"profile_perfect";s:1:"1";}'),
('cloudip', 'a:2:{s:2:"ip";s:13:"123.206.45.56";s:6:"expire";i:1553062173;}');

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon`
--

CREATE TABLE IF NOT EXISTS `ims_coupon` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `acid` int(10) unsigned NOT NULL DEFAULT '0',
  `card_id` varchar(50) NOT NULL,
  `type` varchar(15) NOT NULL,
  `logo_url` varchar(150) NOT NULL,
  `code_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `brand_name` varchar(15) NOT NULL,
  `title` varchar(15) NOT NULL,
  `sub_title` varchar(20) NOT NULL,
  `color` varchar(15) NOT NULL,
  `notice` varchar(15) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date_info` varchar(200) NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `use_custom_code` tinyint(3) NOT NULL DEFAULT '0',
  `bind_openid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `can_share` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `can_give_friend` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `get_limit` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `service_phone` varchar(20) NOT NULL,
  `extra` varchar(1000) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_display` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_selfconsume` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `promotion_url_name` varchar(10) NOT NULL,
  `promotion_url` varchar(100) NOT NULL,
  `promotion_url_sub_title` varchar(10) NOT NULL,
  `source` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `dosage` int(10) unsigned DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_activity`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_activity` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `msg_id` int(10) NOT NULL DEFAULT '0',
  `status` int(10) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `type` int(3) NOT NULL DEFAULT '0',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `coupons` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '‘’',
  `members` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_groups`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_groups` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `couponid` varchar(255) NOT NULL DEFAULT '',
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_location`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_location` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `sid` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `province` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `district` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `photo_list` varchar(10000) NOT NULL,
  `avg_price` int(10) unsigned NOT NULL,
  `open_time` varchar(50) NOT NULL,
  `recommend` varchar(255) NOT NULL,
  `special` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `offset_type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_modules`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_modules` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `couponid` int(10) unsigned NOT NULL DEFAULT '0',
  `module` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_record`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `friend_openid` varchar(50) NOT NULL,
  `givebyfriend` tinyint(3) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `usetime` int(10) unsigned NOT NULL,
  `status` tinyint(3) NOT NULL,
  `clerk_name` varchar(15) NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `clerk_type` tinyint(3) unsigned NOT NULL,
  `couponid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `grantmodule` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_coupon_store`
--

CREATE TABLE IF NOT EXISTS `ims_coupon_store` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `couponid` varchar(255) NOT NULL DEFAULT '',
  `storeid` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_cover_reply`
--

CREATE TABLE IF NOT EXISTS `ims_cover_reply` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `module` varchar(30) NOT NULL,
  `do` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_cover_reply`
--

INSERT INTO `ims_cover_reply` (`id`, `uniacid`, `multiid`, `rid`, `module`, `do`, `title`, `description`, `thumb`, `url`) VALUES
(1, 1, 0, 7, 'mc', '', '进入个人中心', '', '', './index.php?c=mc&a=home&i=1'),
(2, 1, 1, 8, 'site', '', '进入首页', '', '', './index.php?c=home&i=1&t=1');

-- --------------------------------------------------------

--
-- 表的结构 `ims_custom_reply`
--

CREATE TABLE IF NOT EXISTS `ims_custom_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `start1` int(10) NOT NULL,
  `end1` int(10) NOT NULL,
  `start2` int(10) NOT NULL,
  `end2` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_images_reply`
--

CREATE TABLE IF NOT EXISTS `ims_images_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_job`
--

CREATE TABLE IF NOT EXISTS `ims_job` (
  `id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `payload` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `title` varchar(22) NOT NULL,
  `handled` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `color` varchar(255) NOT NULL DEFAULT '',
  `background` varchar(1000) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `format_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `format` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(512) NOT NULL DEFAULT '',
  `fields` varchar(1000) NOT NULL DEFAULT '',
  `snpos` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `business` text NOT NULL,
  `discount_type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `discount` varchar(3000) NOT NULL DEFAULT '',
  `grant` varchar(3000) NOT NULL,
  `grant_rate` varchar(20) NOT NULL DEFAULT '0',
  `offset_rate` int(10) unsigned NOT NULL DEFAULT '0',
  `offset_max` int(10) NOT NULL DEFAULT '0',
  `nums_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `nums_text` varchar(15) NOT NULL,
  `nums` varchar(1000) NOT NULL DEFAULT '',
  `times_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `times_text` varchar(15) NOT NULL,
  `times` varchar(1000) NOT NULL DEFAULT '',
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `recommend_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `sign_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `brand_name` varchar(128) NOT NULL DEFAULT '',
  `notice` varchar(48) NOT NULL DEFAULT '',
  `quantity` int(10) NOT NULL DEFAULT '0',
  `max_increase_bonus` int(10) NOT NULL DEFAULT '0',
  `least_money_to_use_bonus` int(10) NOT NULL DEFAULT '0',
  `source` int(1) NOT NULL DEFAULT '1',
  `card_id` varchar(250) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_credit_set`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_credit_set` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sign` varchar(1000) NOT NULL,
  `share` varchar(500) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_members`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_members` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `openid` varchar(50) NOT NULL,
  `cid` int(10) NOT NULL DEFAULT '0',
  `cardsn` varchar(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `nums` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_notices`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_notices` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `title` varchar(30) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_notices_unread`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_notices_unread` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `notice_id` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(15) NOT NULL,
  `model` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tag` varchar(10) NOT NULL,
  `note` varchar(255) NOT NULL,
  `remark` varchar(200) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_card_sign_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_card_sign_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `is_grant` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_cash_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_cash_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `clerk_type` tinyint(3) unsigned NOT NULL,
  `fee` decimal(10,2) unsigned NOT NULL,
  `final_fee` decimal(10,2) unsigned NOT NULL,
  `credit1` int(10) unsigned NOT NULL,
  `credit1_fee` decimal(10,2) unsigned NOT NULL,
  `credit2` decimal(10,2) unsigned NOT NULL,
  `cash` decimal(10,2) unsigned NOT NULL,
  `return_cash` decimal(10,2) unsigned NOT NULL,
  `final_cash` decimal(10,2) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `trade_type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_chats_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_chats_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL,
  `openid` varchar(32) NOT NULL,
  `msgtype` varchar(15) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_credits_recharge`
--

CREATE TABLE IF NOT EXISTS `ims_mc_credits_recharge` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `tid` varchar(64) NOT NULL,
  `transid` varchar(30) NOT NULL,
  `fee` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `backtype` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_credits_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_credits_record` (
  `id` int(11) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(11) NOT NULL,
  `credittype` varchar(10) NOT NULL,
  `num` decimal(10,2) NOT NULL,
  `operator` int(10) unsigned NOT NULL,
  `module` varchar(30) NOT NULL,
  `clerk_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `clerk_type` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `remark` varchar(200) NOT NULL,
  `real_uniacid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_fans_groups`
--

CREATE TABLE IF NOT EXISTS `ims_mc_fans_groups` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groups` varchar(10000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_fans_tag_mapping`
--

CREATE TABLE IF NOT EXISTS `ims_mc_fans_tag_mapping` (
  `id` int(11) unsigned NOT NULL,
  `fanid` int(11) unsigned NOT NULL,
  `tagid` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_groups`
--

CREATE TABLE IF NOT EXISTS `ims_mc_groups` (
  `groupid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `credit` int(10) unsigned NOT NULL,
  `isdefault` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_mc_groups`
--

INSERT INTO `ims_mc_groups` (`groupid`, `uniacid`, `title`, `credit`, `isdefault`) VALUES
(1, 1, '默认会员组', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_handsel`
--

CREATE TABLE IF NOT EXISTS `ims_mc_handsel` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `touid` int(10) unsigned NOT NULL,
  `fromuid` varchar(32) NOT NULL,
  `module` varchar(30) NOT NULL,
  `sign` varchar(100) NOT NULL,
  `action` varchar(20) NOT NULL,
  `credit_value` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_mapping_fans`
--

CREATE TABLE IF NOT EXISTS `ims_mc_mapping_fans` (
  `fanid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `groupid` varchar(60) NOT NULL,
  `salt` char(8) NOT NULL,
  `follow` tinyint(1) unsigned NOT NULL,
  `followtime` int(10) unsigned NOT NULL,
  `unfollowtime` int(10) unsigned NOT NULL,
  `tag` varchar(1000) NOT NULL,
  `updatetime` int(10) unsigned DEFAULT NULL,
  `unionid` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_mapping_ucenter`
--

CREATE TABLE IF NOT EXISTS `ims_mc_mapping_ucenter` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `centeruid` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_mass_record`
--

CREATE TABLE IF NOT EXISTS `ims_mc_mass_record` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `fansnum` int(10) unsigned NOT NULL,
  `msgtype` varchar(10) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `group` int(10) NOT NULL,
  `attach_id` int(10) unsigned NOT NULL,
  `media_id` varchar(100) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `cron_id` int(10) unsigned NOT NULL,
  `sendtime` int(10) unsigned NOT NULL,
  `finalsendtime` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `msg_id` varchar(50) NOT NULL,
  `msg_data_id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_members`
--

CREATE TABLE IF NOT EXISTS `ims_mc_members` (
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `mobile` varchar(18) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `groupid` int(11) NOT NULL,
  `credit1` decimal(10,2) unsigned NOT NULL,
  `credit2` decimal(10,2) unsigned NOT NULL,
  `credit3` decimal(10,2) unsigned NOT NULL,
  `credit4` decimal(10,2) unsigned NOT NULL,
  `credit5` decimal(10,2) unsigned NOT NULL,
  `credit6` decimal(10,2) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `vip` tinyint(3) unsigned NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) unsigned NOT NULL,
  `birthmonth` tinyint(3) unsigned NOT NULL,
  `birthday` tinyint(3) unsigned NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL,
  `pay_password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_member_address`
--

CREATE TABLE IF NOT EXISTS `ims_mc_member_address` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(50) unsigned NOT NULL,
  `username` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `district` varchar(32) NOT NULL,
  `address` varchar(512) NOT NULL,
  `isdefault` tinyint(1) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_member_fields`
--

CREATE TABLE IF NOT EXISTS `ims_mc_member_fields` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `fieldid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_member_property`
--

CREATE TABLE IF NOT EXISTS `ims_mc_member_property` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(11) NOT NULL,
  `property` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mc_oauth_fans`
--

CREATE TABLE IF NOT EXISTS `ims_mc_oauth_fans` (
  `id` int(10) unsigned NOT NULL,
  `oauth_openid` varchar(50) NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_menu_event`
--

CREATE TABLE IF NOT EXISTS `ims_menu_event` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `picmd5` varchar(32) NOT NULL,
  `openid` varchar(128) NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_message_notice_log`
--

CREATE TABLE IF NOT EXISTS `ims_message_notice_log` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(3) NOT NULL,
  `uid` int(11) NOT NULL,
  `sign` varchar(22) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_mobilenumber`
--

CREATE TABLE IF NOT EXISTS `ims_mobilenumber` (
  `id` int(11) NOT NULL,
  `rid` int(10) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `dateline` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules`
--

CREATE TABLE IF NOT EXISTS `ims_modules` (
  `mid` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `version` varchar(15) NOT NULL,
  `ability` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `settings` tinyint(1) NOT NULL,
  `subscribes` varchar(500) NOT NULL,
  `handles` varchar(500) NOT NULL,
  `isrulefields` tinyint(1) NOT NULL,
  `issystem` tinyint(1) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `iscard` tinyint(3) unsigned NOT NULL,
  `permissions` varchar(5000) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `wxapp_support` tinyint(1) NOT NULL,
  `welcome_support` int(2) NOT NULL,
  `oauth_type` tinyint(1) NOT NULL,
  `webapp_support` tinyint(1) NOT NULL,
  `phoneapp_support` tinyint(1) NOT NULL,
  `account_support` tinyint(1) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `app_support` tinyint(1) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `logo` varchar(250) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_modules`
--

INSERT INTO `ims_modules` (`mid`, `name`, `type`, `title`, `version`, `ability`, `description`, `author`, `url`, `settings`, `subscribes`, `handles`, `isrulefields`, `issystem`, `target`, `iscard`, `permissions`, `title_initial`, `wxapp_support`, `welcome_support`, `oauth_type`, `webapp_support`, `phoneapp_support`, `account_support`, `xzapp_support`, `app_support`, `aliapp_support`, `logo`, `baiduapp_support`, `toutiaoapp_support`) VALUES
(1, 'basic', 'system', '基本文字回复', '1.0', '和您进行简单对话', '一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的回复内容.', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(2, 'news', 'system', '基本混合图文回复', '1.0', '为你提供生动的图文资讯', '一问一答得简单对话, 但是回复内容包括图片文字等更生动的媒体内容. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 或符合某些特定的格式时. 系统自动应答设定好的图文回复内容.', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(3, 'music', 'system', '基本音乐回复', '1.0', '提供语音、音乐等音频类回复', '在回复规则中可选择具有语音、音乐等音频类的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝，实现一问一答得简单对话。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(4, 'userapi', 'system', '自定义接口回复', '1.1', '更方便的第三方接口设置', '自定义接口又称第三方接口，可以让开发者更方便的接入微擎系统，高效的与微信公众平台进行对接整合。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(5, 'recharge', 'system', '会员中心充值模块', '1.0', '提供会员充值功能', '', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 0, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(6, 'custom', 'system', '多客服转接', '1.0.0', '用来接入腾讯的多客服系统', '', 'WeEngine Team', 'http://bbs.we7.cc', 0, 'a:0:{}', 'a:6:{i:0;s:5:"image";i:1;s:5:"voice";i:2;s:5:"video";i:3;s:8:"location";i:4;s:4:"link";i:5;s:4:"text";}', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(7, 'images', 'system', '基本图片回复', '1.0', '提供图片回复', '在回复规则中可选择具有图片的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝图片。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(8, 'video', 'system', '基本视频回复', '1.0', '提供图片回复', '在回复规则中可选择具有视频的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝视频。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(9, 'voice', 'system', '基本语音回复', '1.0', '提供语音回复', '在回复规则中可选择具有语音的回复内容，并根据用户所设置的特定关键字精准的返回给粉丝语音。', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(10, 'chats', 'system', '发送客服消息', '1.0', '公众号可以在粉丝最后发送消息的48小时内无限制发送消息', '', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 0, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(11, 'wxcard', 'system', '微信卡券回复', '1.0', '微信卡券回复', '微信卡券回复', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 1, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0),
(12, 'store', 'business', '站内商城', '1.0', '站内商城', '站内商城', 'WeEngine Team', 'http://www.we7.cc/', 0, '', '', 0, 1, 0, 0, '', '', 1, 1, 1, 1, 0, 2, 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_bindings`
--

CREATE TABLE IF NOT EXISTS `ims_modules_bindings` (
  `eid` int(11) NOT NULL,
  `module` varchar(100) NOT NULL,
  `entry` varchar(30) NOT NULL,
  `call` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `do` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `direct` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `displayorder` tinyint(255) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_cloud`
--

CREATE TABLE IF NOT EXISTS `ims_modules_cloud` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `version` varchar(10) NOT NULL,
  `install_status` tinyint(4) NOT NULL,
  `account_support` tinyint(4) NOT NULL,
  `wxapp_support` tinyint(4) NOT NULL,
  `webapp_support` tinyint(4) NOT NULL,
  `phoneapp_support` tinyint(4) NOT NULL,
  `welcome_support` tinyint(4) NOT NULL,
  `main_module_name` varchar(50) NOT NULL,
  `main_module_logo` varchar(100) NOT NULL,
  `has_new_version` tinyint(1) NOT NULL,
  `has_new_branch` tinyint(1) NOT NULL,
  `is_ban` tinyint(4) NOT NULL,
  `lastupdatetime` int(11) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `cloud_id` int(11) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL,
  `buytime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_ignore`
--

CREATE TABLE IF NOT EXISTS `ims_modules_ignore` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `version` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_plugin`
--

CREATE TABLE IF NOT EXISTS `ims_modules_plugin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `main_module` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_plugin_rank`
--

CREATE TABLE IF NOT EXISTS `ims_modules_plugin_rank` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `plugin_name` varchar(200) NOT NULL,
  `main_module_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_rank`
--

CREATE TABLE IF NOT EXISTS `ims_modules_rank` (
  `id` int(10) unsigned NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `uid` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_modules_recycle`
--

CREATE TABLE IF NOT EXISTS `ims_modules_recycle` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `modulename` varchar(255) NOT NULL,
  `account_support` tinyint(1) NOT NULL,
  `wxapp_support` tinyint(1) NOT NULL,
  `welcome_support` tinyint(1) NOT NULL,
  `webapp_support` tinyint(1) NOT NULL,
  `phoneapp_support` tinyint(1) NOT NULL,
  `xzapp_support` tinyint(1) NOT NULL,
  `aliapp_support` tinyint(1) NOT NULL,
  `baiduapp_support` tinyint(1) NOT NULL,
  `toutiaoapp_support` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_music_reply`
--

CREATE TABLE IF NOT EXISTS `ims_music_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(300) NOT NULL,
  `hqurl` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_news_reply`
--

CREATE TABLE IF NOT EXISTS `ims_news_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `parent_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `thumb` varchar(500) NOT NULL,
  `content` mediumtext NOT NULL,
  `url` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `media_id` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_paycenter_order`
--

CREATE TABLE IF NOT EXISTS `ims_paycenter_order` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `clerk_id` int(10) unsigned NOT NULL DEFAULT '0',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  `clerk_type` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `uniontid` varchar(40) NOT NULL,
  `transaction_id` varchar(40) NOT NULL,
  `type` varchar(10) NOT NULL,
  `trade_type` varchar(10) NOT NULL,
  `body` varchar(255) NOT NULL,
  `fee` varchar(15) NOT NULL,
  `final_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit1` int(10) unsigned NOT NULL DEFAULT '0',
  `credit1_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cash` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) NOT NULL,
  `auth_code` varchar(30) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `follow` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `credit_status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `paytime` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_phoneapp_versions`
--

CREATE TABLE IF NOT EXISTS `ims_phoneapp_versions` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `modules` text,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_profile_fields`
--

CREATE TABLE IF NOT EXISTS `ims_profile_fields` (
  `id` int(10) unsigned NOT NULL,
  `field` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `unchangeable` tinyint(1) NOT NULL,
  `showinregister` tinyint(1) NOT NULL,
  `field_length` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_profile_fields`
--

INSERT INTO `ims_profile_fields` (`id`, `field`, `available`, `title`, `description`, `displayorder`, `required`, `unchangeable`, `showinregister`, `field_length`) VALUES
(1, 'realname', 1, '真实姓名', '', 0, 1, 1, 1, 0),
(2, 'nickname', 1, '昵称', '', 1, 1, 0, 1, 0),
(3, 'avatar', 1, '头像', '', 1, 0, 0, 0, 0),
(4, 'qq', 1, 'QQ号', '', 0, 0, 0, 1, 0),
(5, 'mobile', 1, '手机号码', '', 0, 0, 0, 0, 0),
(6, 'vip', 1, 'VIP级别', '', 0, 0, 0, 0, 0),
(7, 'gender', 1, '性别', '', 0, 0, 0, 0, 0),
(8, 'birthyear', 1, '出生生日', '', 0, 0, 0, 0, 0),
(9, 'constellation', 1, '星座', '', 0, 0, 0, 0, 0),
(10, 'zodiac', 1, '生肖', '', 0, 0, 0, 0, 0),
(11, 'telephone', 1, '固定电话', '', 0, 0, 0, 0, 0),
(12, 'idcard', 1, '证件号码', '', 0, 0, 0, 0, 0),
(13, 'studentid', 1, '学号', '', 0, 0, 0, 0, 0),
(14, 'grade', 1, '班级', '', 0, 0, 0, 0, 0),
(15, 'address', 1, '邮寄地址', '', 0, 0, 0, 0, 0),
(16, 'zipcode', 1, '邮编', '', 0, 0, 0, 0, 0),
(17, 'nationality', 1, '国籍', '', 0, 0, 0, 0, 0),
(18, 'resideprovince', 1, '居住地址', '', 0, 0, 0, 0, 0),
(19, 'graduateschool', 1, '毕业学校', '', 0, 0, 0, 0, 0),
(20, 'company', 1, '公司', '', 0, 0, 0, 0, 0),
(21, 'education', 1, '学历', '', 0, 0, 0, 0, 0),
(22, 'occupation', 1, '职业', '', 0, 0, 0, 0, 0),
(23, 'position', 1, '职位', '', 0, 0, 0, 0, 0),
(24, 'revenue', 1, '年收入', '', 0, 0, 0, 0, 0),
(25, 'affectivestatus', 1, '情感状态', '', 0, 0, 0, 0, 0),
(26, 'lookingfor', 1, ' 交友目的', '', 0, 0, 0, 0, 0),
(27, 'bloodtype', 1, '血型', '', 0, 0, 0, 0, 0),
(28, 'height', 1, '身高', '', 0, 0, 0, 0, 0),
(29, 'weight', 1, '体重', '', 0, 0, 0, 0, 0),
(30, 'alipay', 1, '支付宝帐号', '', 0, 0, 0, 0, 0),
(31, 'msn', 1, 'MSN', '', 0, 0, 0, 0, 0),
(32, 'email', 1, '电子邮箱', '', 0, 0, 0, 0, 0),
(33, 'taobao', 1, '阿里旺旺', '', 0, 0, 0, 0, 0),
(34, 'site', 1, '主页', '', 0, 0, 0, 0, 0),
(35, 'bio', 1, '自我介绍', '', 0, 0, 0, 0, 0),
(36, 'interest', 1, '兴趣爱好', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_qrcode`
--

CREATE TABLE IF NOT EXISTS `ims_qrcode` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `extra` int(10) unsigned NOT NULL,
  `qrcid` bigint(20) NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `model` tinyint(1) unsigned NOT NULL,
  `ticket` varchar(250) NOT NULL,
  `url` varchar(256) NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  `subnum` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_qrcode_stat`
--

CREATE TABLE IF NOT EXISTS `ims_qrcode_stat` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `qid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `qrcid` bigint(20) unsigned NOT NULL,
  `scene_str` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule`
--

CREATE TABLE IF NOT EXISTS `ims_rule` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `containtype` varchar(100) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_rule`
--

INSERT INTO `ims_rule` (`id`, `uniacid`, `name`, `module`, `displayorder`, `status`, `containtype`) VALUES
(1, 0, '城市天气', 'userapi', 255, 1, ''),
(2, 0, '百度百科', 'userapi', 255, 1, ''),
(3, 0, '即时翻译', 'userapi', 255, 1, ''),
(4, 0, '今日老黄历', 'userapi', 255, 1, ''),
(5, 0, '看新闻', 'userapi', 255, 1, ''),
(6, 0, '快递查询', 'userapi', 255, 1, ''),
(7, 1, '个人中心入口设置', 'cover', 0, 1, ''),
(8, 1, '微擎团队入口设置', 'cover', 0, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_rule_keyword`
--

CREATE TABLE IF NOT EXISTS `ims_rule_keyword` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_rule_keyword`
--

INSERT INTO `ims_rule_keyword` (`id`, `rid`, `uniacid`, `module`, `content`, `type`, `displayorder`, `status`) VALUES
(1, 1, 0, 'userapi', '^.+天气$', 3, 255, 1),
(2, 2, 0, 'userapi', '^百科.+$', 3, 255, 1),
(3, 2, 0, 'userapi', '^定义.+$', 3, 255, 1),
(4, 3, 0, 'userapi', '^@.+$', 3, 255, 1),
(5, 4, 0, 'userapi', '日历', 1, 255, 1),
(6, 4, 0, 'userapi', '万年历', 1, 255, 1),
(7, 4, 0, 'userapi', '黄历', 1, 255, 1),
(8, 4, 0, 'userapi', '几号', 1, 255, 1),
(9, 5, 0, 'userapi', '新闻', 1, 255, 1),
(10, 6, 0, 'userapi', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$', 3, 255, 1),
(11, 7, 1, 'cover', '个人中心', 1, 0, 1),
(12, 8, 1, 'cover', '首页', 1, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_article`
--

CREATE TABLE IF NOT EXISTS `ims_site_article` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `iscommend` tinyint(1) NOT NULL,
  `ishot` tinyint(1) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL,
  `ccate` int(10) unsigned NOT NULL,
  `template` varchar(300) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `edittime` int(10) NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `credit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_article_comment`
--

CREATE TABLE IF NOT EXISTS `ims_site_article_comment` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `articleid` int(10) NOT NULL,
  `parentid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `content` text,
  `is_read` tinyint(1) NOT NULL,
  `iscomment` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_category`
--

CREATE TABLE IF NOT EXISTS `ims_site_category` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `nid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `parentid` int(10) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `ishomepage` tinyint(1) NOT NULL,
  `icontype` tinyint(1) unsigned NOT NULL,
  `css` varchar(500) NOT NULL,
  `multiid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_multi`
--

CREATE TABLE IF NOT EXISTS `ims_site_multi` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `site_info` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `bindhost` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_site_multi`
--

INSERT INTO `ims_site_multi` (`id`, `uniacid`, `title`, `styleid`, `site_info`, `status`, `bindhost`) VALUES
(1, 1, '微擎团队', 1, '', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_nav`
--

CREATE TABLE IF NOT EXISTS `ims_site_nav` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `section` tinyint(4) NOT NULL,
  `module` varchar(50) NOT NULL,
  `displayorder` smallint(5) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(500) NOT NULL,
  `css` varchar(1000) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `categoryid` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_page`
--

CREATE TABLE IF NOT EXISTS `ims_site_page` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `params` longtext NOT NULL,
  `html` longtext NOT NULL,
  `multipage` longtext NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `goodnum` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_slide`
--

CREATE TABLE IF NOT EXISTS `ims_site_slide` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `displayorder` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_store_cash_log`
--

CREATE TABLE IF NOT EXISTS `ims_site_store_cash_log` (
  `id` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `number` char(30) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_store_cash_order`
--

CREATE TABLE IF NOT EXISTS `ims_site_store_cash_order` (
  `id` int(10) NOT NULL,
  `number` char(30) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `cash_log_id` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_store_create_account`
--

CREATE TABLE IF NOT EXISTS `ims_site_store_create_account` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `endtime` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_store_goods`
--

CREATE TABLE IF NOT EXISTS `ims_site_store_goods` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `title` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `account_num` int(10) NOT NULL,
  `wxapp_num` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `slide` varchar(1000) NOT NULL,
  `category_id` int(10) NOT NULL,
  `title_initial` varchar(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `synopsis` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `module_group` int(10) NOT NULL,
  `api_num` int(10) NOT NULL,
  `user_group` int(10) NOT NULL,
  `user_group_price` varchar(1000) DEFAULT NULL,
  `account_group` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_store_order`
--

CREATE TABLE IF NOT EXISTS `ims_site_store_order` (
  `id` int(10) unsigned NOT NULL,
  `orderid` varchar(28) NOT NULL,
  `goodsid` int(10) NOT NULL,
  `duration` int(10) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `buyerid` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `changeprice` tinyint(1) NOT NULL,
  `createtime` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `endtime` int(15) NOT NULL,
  `wxapp` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_styles`
--

CREATE TABLE IF NOT EXISTS `ims_site_styles` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_site_styles`
--

INSERT INTO `ims_site_styles` (`id`, `uniacid`, `templateid`, `name`) VALUES
(1, 1, 1, '微站默认模板_gC5C');

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_styles_vars`
--

CREATE TABLE IF NOT EXISTS `ims_site_styles_vars` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `variable` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_site_templates`
--

CREATE TABLE IF NOT EXISTS `ims_site_templates` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `version` varchar(64) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `sections` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_site_templates`
--

INSERT INTO `ims_site_templates` (`id`, `name`, `title`, `version`, `description`, `author`, `url`, `type`, `sections`) VALUES
(1, 'default', '微站默认模板', '', '由微擎提供默认微站模板套系', '微擎团队', 'http://we7.cc', '1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_fans`
--

CREATE TABLE IF NOT EXISTS `ims_stat_fans` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `new` int(10) unsigned NOT NULL,
  `cancel` int(10) unsigned NOT NULL,
  `cumulate` int(10) NOT NULL,
  `date` varchar(8) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_stat_fans`
--

INSERT INTO `ims_stat_fans` (`id`, `uniacid`, `new`, `cancel`, `cumulate`, `date`) VALUES
(1, 1, 0, 0, 0, '20190319'),
(2, 1, 0, 0, 0, '20190318'),
(3, 1, 0, 0, 0, '20190317'),
(4, 1, 0, 0, 0, '20190316'),
(5, 1, 0, 0, 0, '20190315'),
(6, 1, 0, 0, 0, '20190314'),
(7, 1, 0, 0, 0, '20190313');

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_keyword`
--

CREATE TABLE IF NOT EXISTS `ims_stat_keyword` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` varchar(10) NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `hit` int(10) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_msg_history`
--

CREATE TABLE IF NOT EXISTS `ims_stat_msg_history` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_rule`
--

CREATE TABLE IF NOT EXISTS `ims_stat_rule` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `hit` int(10) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_visit`
--

CREATE TABLE IF NOT EXISTS `ims_stat_visit` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `ip_count` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_stat_visit`
--

INSERT INTO `ims_stat_visit` (`id`, `uniacid`, `module`, `count`, `date`, `type`, `ip_count`) VALUES
(1, 0, '', 7, 20190320, 'web', 1),
(2, 1, 'we7_account', 1, 20190320, 'web', 0),
(3, 1, '', 2, 20190320, 'web', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_stat_visit_ip`
--

CREATE TABLE IF NOT EXISTS `ims_stat_visit_ip` (
  `id` int(10) NOT NULL,
  `ip` varchar(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_stat_visit_ip`
--

INSERT INTO `ims_stat_visit_ip` (`id`, `ip`, `uniacid`, `type`, `module`, `date`) VALUES
(1, '3738938660', 0, 'web', '', 20190320);

-- --------------------------------------------------------

--
-- 表的结构 `ims_superman_home_kv`
--

CREATE TABLE IF NOT EXISTS `ims_superman_home_kv` (
  `id` int(11) NOT NULL,
  `skey` varchar(255) NOT NULL DEFAULT '',
  `svalue` mediumtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_system_stat_visit`
--

CREATE TABLE IF NOT EXISTS `ims_system_stat_visit` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `modulename` varchar(100) NOT NULL,
  `uid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account` (
  `uniacid` int(10) unsigned NOT NULL,
  `groupid` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `default_acid` int(10) unsigned NOT NULL,
  `rank` int(10) DEFAULT NULL,
  `title_initial` varchar(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_uni_account`
--

INSERT INTO `ims_uni_account` (`uniacid`, `groupid`, `name`, `description`, `default_acid`, `rank`, `title_initial`) VALUES
(1, -1, '微擎团队', '一个朝气蓬勃的团队', 1, NULL, 'W');

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account_group`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account_group` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `groupid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account_menus`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account_menus` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `menuid` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `sex` tinyint(3) unsigned NOT NULL,
  `group_id` int(10) NOT NULL,
  `client_platform_type` tinyint(3) unsigned NOT NULL,
  `area` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `isdeleted` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account_modules`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account_modules` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `settings` text NOT NULL,
  `shortcut` tinyint(1) unsigned NOT NULL,
  `displayorder` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account_modules_shortcut`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account_modules_shortcut` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `url` varchar(250) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `version_id` int(10) NOT NULL,
  `module_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_account_users`
--

CREATE TABLE IF NOT EXISTS `ims_uni_account_users` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `role` varchar(255) NOT NULL,
  `rank` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_group`
--

CREATE TABLE IF NOT EXISTS `ims_uni_group` (
  `id` int(10) unsigned NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `modules` text NOT NULL,
  `templates` varchar(5000) NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_uni_group`
--

INSERT INTO `ims_uni_group` (`id`, `owner_uid`, `name`, `modules`, `templates`, `uniacid`, `uid`) VALUES
(1, 0, '体验套餐服务', 'N;', 'N;', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_link_uniacid`
--

CREATE TABLE IF NOT EXISTS `ims_uni_link_uniacid` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `link_uniacid` int(10) NOT NULL,
  `version_id` int(10) NOT NULL,
  `module_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_modules`
--

CREATE TABLE IF NOT EXISTS `ims_uni_modules` (
  `id` int(10) NOT NULL,
  `uniacid` int(10) NOT NULL,
  `module_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_settings`
--

CREATE TABLE IF NOT EXISTS `ims_uni_settings` (
  `uniacid` int(10) unsigned NOT NULL,
  `passport` varchar(200) NOT NULL,
  `oauth` varchar(100) NOT NULL,
  `jsauth_acid` int(10) unsigned NOT NULL,
  `uc` varchar(500) NOT NULL,
  `notify` varchar(2000) NOT NULL,
  `creditnames` varchar(500) NOT NULL,
  `creditbehaviors` varchar(500) NOT NULL,
  `welcome` varchar(60) NOT NULL,
  `default` varchar(60) NOT NULL,
  `default_message` varchar(2000) NOT NULL,
  `payment` text NOT NULL,
  `stat` varchar(300) NOT NULL,
  `default_site` int(10) unsigned DEFAULT NULL,
  `sync` tinyint(3) unsigned NOT NULL,
  `recharge` varchar(500) NOT NULL,
  `tplnotice` varchar(2000) NOT NULL,
  `grouplevel` tinyint(3) unsigned NOT NULL,
  `mcplugin` varchar(500) NOT NULL,
  `exchange_enable` tinyint(3) unsigned NOT NULL,
  `coupon_type` tinyint(3) unsigned NOT NULL,
  `menuset` text NOT NULL,
  `statistics` varchar(100) NOT NULL,
  `bind_domain` varchar(200) NOT NULL,
  `comment_status` tinyint(1) NOT NULL,
  `reply_setting` tinyint(4) NOT NULL,
  `default_module` varchar(100) NOT NULL,
  `attachment_limit` int(11) DEFAULT NULL,
  `attachment_size` varchar(20) DEFAULT NULL,
  `sync_member` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_uni_settings`
--

INSERT INTO `ims_uni_settings` (`uniacid`, `passport`, `oauth`, `jsauth_acid`, `uc`, `notify`, `creditnames`, `creditbehaviors`, `welcome`, `default`, `default_message`, `payment`, `stat`, `default_site`, `sync`, `recharge`, `tplnotice`, `grouplevel`, `mcplugin`, `exchange_enable`, `coupon_type`, `menuset`, `statistics`, `bind_domain`, `comment_status`, `reply_setting`, `default_module`, `attachment_limit`, `attachment_size`, `sync_member`) VALUES
(1, 'a:3:{s:8:"focusreg";i:0;s:4:"item";s:5:"email";s:4:"type";s:8:"password";}', 'a:2:{s:6:"status";s:1:"0";s:7:"account";s:1:"0";}', 0, 'a:1:{s:6:"status";i:0;}', 'a:1:{s:3:"sms";a:2:{s:7:"balance";i:0;s:9:"signature";s:0:"";}}', 'a:5:{s:7:"credit1";a:2:{s:5:"title";s:6:"积分";s:7:"enabled";i:1;}s:7:"credit2";a:2:{s:5:"title";s:6:"余额";s:7:"enabled";i:1;}s:7:"credit3";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit4";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}s:7:"credit5";a:2:{s:5:"title";s:0:"";s:7:"enabled";i:0;}}', 'a:2:{s:8:"activity";s:7:"credit1";s:8:"currency";s:7:"credit2";}', '', '', '', 'a:4:{s:6:"credit";a:1:{s:6:"switch";b:0;}s:6:"alipay";a:4:{s:6:"switch";b:0;s:7:"account";s:0:"";s:7:"partner";s:0:"";s:6:"secret";s:0:"";}s:6:"wechat";a:5:{s:6:"switch";b:0;s:7:"account";b:0;s:7:"signkey";s:0:"";s:7:"partner";s:0:"";s:3:"key";s:0:"";}s:8:"delivery";a:1:{s:6:"switch";b:0;}}', '', 1, 0, '', '', 0, '', 0, 0, '', '', '', 0, 0, '', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_uni_verifycode`
--

CREATE TABLE IF NOT EXISTS `ims_uni_verifycode` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `verifycode` varchar(6) NOT NULL,
  `total` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `failed_count` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_userapi_cache`
--

CREATE TABLE IF NOT EXISTS `ims_userapi_cache` (
  `id` int(10) unsigned NOT NULL,
  `key` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_userapi_reply`
--

CREATE TABLE IF NOT EXISTS `ims_userapi_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `description` varchar(300) NOT NULL,
  `apiurl` varchar(300) NOT NULL,
  `token` varchar(32) NOT NULL,
  `default_text` varchar(100) NOT NULL,
  `cachetime` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_userapi_reply`
--

INSERT INTO `ims_userapi_reply` (`id`, `rid`, `description`, `apiurl`, `token`, `default_text`, `cachetime`) VALUES
(1, 1, '"城市名+天气", 如: "北京天气"', 'weather.php', '', '', 0),
(2, 2, '"百科+查询内容" 或 "定义+查询内容", 如: "百科姚明", "定义自行车"', 'baike.php', '', '', 0),
(3, 3, '"@查询内容(中文或英文)"', 'translate.php', '', '', 0),
(4, 4, '"日历", "万年历", "黄历"或"几号"', 'calendar.php', '', '', 0),
(5, 5, '"新闻"', 'news.php', '', '', 0),
(6, 6, '"快递+单号", 如: "申通1200041125"', 'express.php', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ims_users`
--

CREATE TABLE IF NOT EXISTS `ims_users` (
  `uid` int(10) unsigned NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `founder_groupid` tinyint(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  `joindate` int(10) unsigned NOT NULL,
  `joinip` varchar(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `register_type` tinyint(3) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `welcome_link` tinyint(4) NOT NULL,
  `is_bind` tinyint(1) NOT NULL,
  `notice_setting` varchar(5000) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_users`
--

INSERT INTO `ims_users` (`uid`, `owner_uid`, `groupid`, `founder_groupid`, `username`, `password`, `salt`, `type`, `status`, `joindate`, `joinip`, `lastvisit`, `lastip`, `remark`, `starttime`, `endtime`, `register_type`, `openid`, `welcome_link`, `is_bind`, `notice_setting`) VALUES
(1, 0, 1, 0, 'admin', '7ac32da025a8512620b5315011ba82e42f75b3d1', '1f718bb2', 0, 0, 1553058536, '', 1553058547, '222.219.173.36', '', 0, 0, 0, '', 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_bind`
--

CREATE TABLE IF NOT EXISTS `ims_users_bind` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bind_sign` varchar(50) NOT NULL,
  `third_type` tinyint(4) NOT NULL,
  `third_nickname` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_create_group`
--

CREATE TABLE IF NOT EXISTS `ims_users_create_group` (
  `id` int(10) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `maxaccount` int(10) NOT NULL,
  `maxwxapp` int(10) NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_extra_group`
--

CREATE TABLE IF NOT EXISTS `ims_users_extra_group` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uni_group_id` int(10) NOT NULL,
  `create_group_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_extra_limit`
--

CREATE TABLE IF NOT EXISTS `ims_users_extra_limit` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `maxaccount` int(10) NOT NULL,
  `maxwxapp` int(10) NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `timelimit` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_extra_modules`
--

CREATE TABLE IF NOT EXISTS `ims_users_extra_modules` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `support` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_extra_templates`
--

CREATE TABLE IF NOT EXISTS `ims_users_extra_templates` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `template_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_failed_login`
--

CREATE TABLE IF NOT EXISTS `ims_users_failed_login` (
  `id` int(10) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL,
  `username` varchar(32) NOT NULL,
  `count` tinyint(1) unsigned NOT NULL,
  `lastupdate` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_founder_group`
--

CREATE TABLE IF NOT EXISTS `ims_users_founder_group` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) unsigned NOT NULL,
  `maxsubaccount` int(10) unsigned NOT NULL,
  `timelimit` int(10) unsigned NOT NULL,
  `maxwxapp` int(10) unsigned NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_founder_own_create_groups`
--

CREATE TABLE IF NOT EXISTS `ims_users_founder_own_create_groups` (
  `id` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `create_group_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_founder_own_uni_groups`
--

CREATE TABLE IF NOT EXISTS `ims_users_founder_own_uni_groups` (
  `id` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `uni_group_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_founder_own_users`
--

CREATE TABLE IF NOT EXISTS `ims_users_founder_own_users` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_founder_own_users_groups`
--

CREATE TABLE IF NOT EXISTS `ims_users_founder_own_users_groups` (
  `id` int(10) NOT NULL,
  `founder_uid` int(10) NOT NULL,
  `users_group_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_group`
--

CREATE TABLE IF NOT EXISTS `ims_users_group` (
  `id` int(10) unsigned NOT NULL,
  `owner_uid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `package` varchar(5000) NOT NULL,
  `maxaccount` int(10) unsigned NOT NULL,
  `maxsubaccount` int(10) unsigned NOT NULL,
  `timelimit` int(10) unsigned NOT NULL,
  `maxwxapp` int(10) unsigned NOT NULL,
  `maxwebapp` int(10) NOT NULL,
  `maxphoneapp` int(10) NOT NULL,
  `maxxzapp` int(10) NOT NULL,
  `maxaliapp` int(10) NOT NULL,
  `maxbaiduapp` int(10) NOT NULL,
  `maxtoutiaoapp` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_invitation`
--

CREATE TABLE IF NOT EXISTS `ims_users_invitation` (
  `id` int(10) unsigned NOT NULL,
  `code` varchar(64) NOT NULL,
  `fromuid` int(10) unsigned NOT NULL,
  `inviteuid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_lastuse`
--

CREATE TABLE IF NOT EXISTS `ims_users_lastuse` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `modulename` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ims_users_lastuse`
--

INSERT INTO `ims_users_lastuse` (`id`, `uid`, `uniacid`, `modulename`, `type`) VALUES
(1, 1, 1, '', 'account_display');

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_permission`
--

CREATE TABLE IF NOT EXISTS `ims_users_permission` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `permission` varchar(10000) NOT NULL,
  `url` varchar(255) NOT NULL,
  `modules` text NOT NULL,
  `templates` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_users_profile`
--

CREATE TABLE IF NOT EXISTS `ims_users_profile` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `edittime` int(10) NOT NULL,
  `realname` varchar(10) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `fakeid` varchar(30) NOT NULL,
  `vip` tinyint(3) unsigned NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthyear` smallint(6) unsigned NOT NULL,
  `birthmonth` tinyint(3) unsigned NOT NULL,
  `birthday` tinyint(3) unsigned NOT NULL,
  `constellation` varchar(10) NOT NULL,
  `zodiac` varchar(5) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `idcard` varchar(30) NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `resideprovince` varchar(30) NOT NULL,
  `residecity` varchar(30) NOT NULL,
  `residedist` varchar(30) NOT NULL,
  `graduateschool` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `education` varchar(10) NOT NULL,
  `occupation` varchar(30) NOT NULL,
  `position` varchar(30) NOT NULL,
  `revenue` varchar(10) NOT NULL,
  `affectivestatus` varchar(30) NOT NULL,
  `lookingfor` varchar(255) NOT NULL,
  `bloodtype` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `weight` varchar(5) NOT NULL,
  `alipay` varchar(30) NOT NULL,
  `msn` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `taobao` varchar(30) NOT NULL,
  `site` varchar(30) NOT NULL,
  `bio` text NOT NULL,
  `interest` text NOT NULL,
  `workerid` varchar(64) NOT NULL,
  `is_send_mobile_status` tinyint(3) NOT NULL,
  `send_expire_status` tinyint(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_video_reply`
--

CREATE TABLE IF NOT EXISTS `ims_video_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_voice_reply`
--

CREATE TABLE IF NOT EXISTS `ims_voice_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `mediaid` varchar(255) NOT NULL,
  `createtime` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_wechat_attachment`
--

CREATE TABLE IF NOT EXISTS `ims_wechat_attachment` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `acid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `media_id` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  `type` varchar(15) NOT NULL,
  `model` varchar(25) NOT NULL,
  `tag` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `module_upload_dir` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_wechat_news`
--

CREATE TABLE IF NOT EXISTS `ims_wechat_news` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned DEFAULT NULL,
  `attach_id` int(10) unsigned NOT NULL,
  `thumb_media_id` varchar(60) NOT NULL,
  `thumb_url` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(30) NOT NULL,
  `digest` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_source_url` varchar(200) NOT NULL,
  `show_cover_pic` tinyint(3) unsigned NOT NULL,
  `url` varchar(200) NOT NULL,
  `displayorder` int(2) NOT NULL,
  `need_open_comment` tinyint(1) NOT NULL,
  `only_fans_can_comment` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxapp_general_analysis`
--

CREATE TABLE IF NOT EXISTS `ims_wxapp_general_analysis` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) NOT NULL,
  `session_cnt` int(10) NOT NULL,
  `visit_pv` int(10) NOT NULL,
  `visit_uv` int(10) NOT NULL,
  `visit_uv_new` int(10) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `stay_time_uv` varchar(10) NOT NULL,
  `stay_time_session` varchar(10) NOT NULL,
  `visit_depth` varchar(10) NOT NULL,
  `ref_date` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxapp_versions`
--

CREATE TABLE IF NOT EXISTS `ims_wxapp_versions` (
  `id` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `multiid` int(10) unsigned NOT NULL,
  `version` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `modules` varchar(1000) NOT NULL,
  `design_method` tinyint(1) NOT NULL,
  `template` int(10) NOT NULL,
  `quickmenu` varchar(2500) NOT NULL,
  `createtime` int(10) NOT NULL,
  `type` int(2) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `appjson` text NOT NULL,
  `default_appjson` text NOT NULL,
  `use_default` tinyint(1) NOT NULL,
  `last_modules` varchar(1000) DEFAULT NULL,
  `tominiprogram` varchar(1000) NOT NULL,
  `upload_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ims_wxcard_reply`
--

CREATE TABLE IF NOT EXISTS `ims_wxcard_reply` (
  `id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `card_id` varchar(50) NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `success` varchar(255) NOT NULL,
  `error` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ims_account`
--
ALTER TABLE `ims_account`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `idx_uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_aliapp`
--
ALTER TABLE `ims_account_aliapp`
  ADD PRIMARY KEY (`acid`);

--
-- Indexes for table `ims_account_baiduapp`
--
ALTER TABLE `ims_account_baiduapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_phoneapp`
--
ALTER TABLE `ims_account_phoneapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_toutiaoapp`
--
ALTER TABLE `ims_account_toutiaoapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_webapp`
--
ALTER TABLE `ims_account_webapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_wechats`
--
ALTER TABLE `ims_account_wechats`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `idx_key` (`key`);

--
-- Indexes for table `ims_account_wxapp`
--
ALTER TABLE `ims_account_wxapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_account_xzapp`
--
ALTER TABLE `ims_account_xzapp`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_activity_clerks`
--
ALTER TABLE `ims_activity_clerks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `password` (`password`),
  ADD KEY `openid` (`openid`);

--
-- Indexes for table `ims_activity_clerk_menu`
--
ALTER TABLE `ims_activity_clerk_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_activity_exchange`
--
ALTER TABLE `ims_activity_exchange`
  ADD PRIMARY KEY (`id`),
  ADD KEY `extra` (`extra`(333));

--
-- Indexes for table `ims_activity_exchange_trades`
--
ALTER TABLE `ims_activity_exchange_trades`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `uniacid` (`uniacid`,`uid`,`exid`);

--
-- Indexes for table `ims_activity_exchange_trades_shipping`
--
ALTER TABLE `ims_activity_exchange_trades_shipping`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_activity_stores`
--
ALTER TABLE `ims_activity_stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `ims_article_category`
--
ALTER TABLE `ims_article_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ims_article_comment`
--
ALTER TABLE `ims_article_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articleid` (`articleid`);

--
-- Indexes for table `ims_article_news`
--
ALTER TABLE `ims_article_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `cateid` (`cateid`);

--
-- Indexes for table `ims_article_notice`
--
ALTER TABLE `ims_article_notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `cateid` (`cateid`);

--
-- Indexes for table `ims_article_unread_notice`
--
ALTER TABLE `ims_article_unread_notice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `notice_id` (`notice_id`);

--
-- Indexes for table `ims_attachment_group`
--
ALTER TABLE `ims_attachment_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_basic_reply`
--
ALTER TABLE `ims_basic_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_business`
--
ALTER TABLE `ims_business`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lat_lng` (`lng`,`lat`);

--
-- Indexes for table `ims_core_attachment`
--
ALTER TABLE `ims_core_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_cache`
--
ALTER TABLE `ims_core_cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ims_core_cron`
--
ALTER TABLE `ims_core_cron`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createtime` (`createtime`),
  ADD KEY `nextruntime` (`nextruntime`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `cloudid` (`cloudid`);

--
-- Indexes for table `ims_core_cron_record`
--
ALTER TABLE `ims_core_cron_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `tid` (`tid`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `ims_core_job`
--
ALTER TABLE `ims_core_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_menu`
--
ALTER TABLE `ims_core_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_menu_shortcut`
--
ALTER TABLE `ims_core_menu_shortcut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_core_paylog`
--
ALTER TABLE `ims_core_paylog`
  ADD PRIMARY KEY (`plid`),
  ADD KEY `idx_openid` (`openid`),
  ADD KEY `idx_tid` (`tid`),
  ADD KEY `idx_uniacid` (`uniacid`),
  ADD KEY `uniontid` (`uniontid`);

--
-- Indexes for table `ims_core_performance`
--
ALTER TABLE `ims_core_performance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_queue`
--
ALTER TABLE `ims_core_queue`
  ADD PRIMARY KEY (`qid`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `module` (`module`),
  ADD KEY `dateline` (`dateline`);

--
-- Indexes for table `ims_core_refundlog`
--
ALTER TABLE `ims_core_refundlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_uniontid` (`refund_uniontid`),
  ADD KEY `uniontid` (`uniontid`);

--
-- Indexes for table `ims_core_resource`
--
ALTER TABLE `ims_core_resource`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `acid` (`uniacid`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ims_core_sendsms_log`
--
ALTER TABLE `ims_core_sendsms_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_core_sessions`
--
ALTER TABLE `ims_core_sessions`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `ims_core_settings`
--
ALTER TABLE `ims_core_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ims_coupon`
--
ALTER TABLE `ims_coupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `ims_coupon_activity`
--
ALTER TABLE `ims_coupon_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_coupon_groups`
--
ALTER TABLE `ims_coupon_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_coupon_location`
--
ALTER TABLE `ims_coupon_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`);

--
-- Indexes for table `ims_coupon_modules`
--
ALTER TABLE `ims_coupon_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`couponid`),
  ADD KEY `uniacid` (`uniacid`,`acid`);

--
-- Indexes for table `ims_coupon_record`
--
ALTER TABLE `ims_coupon_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `card_id` (`card_id`),
  ADD KEY `hash` (`hash`);

--
-- Indexes for table `ims_coupon_store`
--
ALTER TABLE `ims_coupon_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couponid` (`couponid`);

--
-- Indexes for table `ims_cover_reply`
--
ALTER TABLE `ims_cover_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_custom_reply`
--
ALTER TABLE `ims_custom_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_images_reply`
--
ALTER TABLE `ims_images_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_job`
--
ALTER TABLE `ims_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_card`
--
ALTER TABLE `ims_mc_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_card_credit_set`
--
ALTER TABLE `ims_mc_card_credit_set`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_card_members`
--
ALTER TABLE `ims_mc_card_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_card_notices`
--
ALTER TABLE `ims_mc_card_notices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_card_notices_unread`
--
ALTER TABLE `ims_mc_card_notices_unread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `notice_id` (`notice_id`);

--
-- Indexes for table `ims_mc_card_record`
--
ALTER TABLE `ims_mc_card_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `addtime` (`addtime`);

--
-- Indexes for table `ims_mc_card_sign_record`
--
ALTER TABLE `ims_mc_card_sign_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_cash_record`
--
ALTER TABLE `ims_mc_cash_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_chats_record`
--
ALTER TABLE `ims_mc_chats_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`),
  ADD KEY `openid` (`openid`),
  ADD KEY `createtime` (`createtime`);

--
-- Indexes for table `ims_mc_credits_recharge`
--
ALTER TABLE `ims_mc_credits_recharge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uniacid_uid` (`uniacid`,`uid`),
  ADD KEY `idx_tid` (`tid`);

--
-- Indexes for table `ims_mc_credits_record`
--
ALTER TABLE `ims_mc_credits_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_mc_fans_groups`
--
ALTER TABLE `ims_mc_fans_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_fans_tag_mapping`
--
ALTER TABLE `ims_mc_fans_tag_mapping`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mapping` (`fanid`,`tagid`),
  ADD KEY `fanid_index` (`fanid`),
  ADD KEY `tagid_index` (`tagid`);

--
-- Indexes for table `ims_mc_groups`
--
ALTER TABLE `ims_mc_groups`
  ADD PRIMARY KEY (`groupid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_handsel`
--
ALTER TABLE `ims_mc_handsel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`touid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_mc_mapping_fans`
--
ALTER TABLE `ims_mc_mapping_fans`
  ADD PRIMARY KEY (`fanid`),
  ADD UNIQUE KEY `openid_2` (`openid`),
  ADD KEY `acid` (`acid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `nickname` (`nickname`),
  ADD KEY `updatetime` (`updatetime`),
  ADD KEY `uid` (`uid`),
  ADD KEY `openid` (`openid`);

--
-- Indexes for table `ims_mc_mapping_ucenter`
--
ALTER TABLE `ims_mc_mapping_ucenter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_mass_record`
--
ALTER TABLE `ims_mc_mass_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`acid`);

--
-- Indexes for table `ims_mc_members`
--
ALTER TABLE `ims_mc_members`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `groupid` (`groupid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `email` (`email`),
  ADD KEY `mobile` (`mobile`),
  ADD KEY `createtime` (`createtime`);

--
-- Indexes for table `ims_mc_member_address`
--
ALTER TABLE `ims_mc_member_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uinacid` (`uniacid`),
  ADD KEY `idx_uid` (`uid`);

--
-- Indexes for table `ims_mc_member_fields`
--
ALTER TABLE `ims_mc_member_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_uniacid` (`uniacid`),
  ADD KEY `idx_fieldid` (`fieldid`);

--
-- Indexes for table `ims_mc_member_property`
--
ALTER TABLE `ims_mc_member_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mc_oauth_fans`
--
ALTER TABLE `ims_mc_oauth_fans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oauthopenid_acid` (`oauth_openid`,`acid`);

--
-- Indexes for table `ims_menu_event`
--
ALTER TABLE `ims_menu_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `picmd5` (`picmd5`);

--
-- Indexes for table `ims_message_notice_log`
--
ALTER TABLE `ims_message_notice_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_mobilenumber`
--
ALTER TABLE `ims_mobilenumber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_modules`
--
ALTER TABLE `ims_modules`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `idx_name` (`name`);

--
-- Indexes for table `ims_modules_bindings`
--
ALTER TABLE `ims_modules_bindings`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `idx_module` (`module`);

--
-- Indexes for table `ims_modules_cloud`
--
ALTER TABLE `ims_modules_cloud`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `lastupdatetime` (`lastupdatetime`);

--
-- Indexes for table `ims_modules_ignore`
--
ALTER TABLE `ims_modules_ignore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ims_modules_plugin`
--
ALTER TABLE `ims_modules_plugin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `main_module` (`main_module`);

--
-- Indexes for table `ims_modules_plugin_rank`
--
ALTER TABLE `ims_modules_plugin_rank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_modules_rank`
--
ALTER TABLE `ims_modules_rank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_name` (`module_name`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_modules_recycle`
--
ALTER TABLE `ims_modules_recycle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `modulename` (`name`);

--
-- Indexes for table `ims_music_reply`
--
ALTER TABLE `ims_music_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_news_reply`
--
ALTER TABLE `ims_news_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_paycenter_order`
--
ALTER TABLE `ims_paycenter_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_phoneapp_versions`
--
ALTER TABLE `ims_phoneapp_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `version` (`version`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_profile_fields`
--
ALTER TABLE `ims_profile_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_qrcode`
--
ALTER TABLE `ims_qrcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_qrcid` (`qrcid`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `ticket` (`ticket`);

--
-- Indexes for table `ims_qrcode_stat`
--
ALTER TABLE `ims_qrcode_stat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_rule`
--
ALTER TABLE `ims_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_rule_keyword`
--
ALTER TABLE `ims_rule_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_content` (`content`),
  ADD KEY `rid` (`rid`),
  ADD KEY `idx_rid` (`rid`),
  ADD KEY `idx_uniacid_type_content` (`uniacid`,`type`,`content`);

--
-- Indexes for table `ims_site_article`
--
ALTER TABLE `ims_site_article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_iscommend` (`iscommend`),
  ADD KEY `idx_ishot` (`ishot`);

--
-- Indexes for table `ims_site_article_comment`
--
ALTER TABLE `ims_site_article_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `articleid` (`articleid`);

--
-- Indexes for table `ims_site_category`
--
ALTER TABLE `ims_site_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_multi`
--
ALTER TABLE `ims_site_multi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `bindhost` (`bindhost`);

--
-- Indexes for table `ims_site_nav`
--
ALTER TABLE `ims_site_nav`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_page`
--
ALTER TABLE `ims_site_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_slide`
--
ALTER TABLE `ims_site_slide`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `multiid` (`multiid`);

--
-- Indexes for table `ims_site_store_cash_log`
--
ALTER TABLE `ims_site_store_cash_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `founder_uid` (`founder_uid`);

--
-- Indexes for table `ims_site_store_cash_order`
--
ALTER TABLE `ims_site_store_cash_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `founder_uid` (`founder_uid`);

--
-- Indexes for table `ims_site_store_create_account`
--
ALTER TABLE `ims_site_store_create_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_store_goods`
--
ALTER TABLE `ims_site_store_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module` (`module`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `ims_site_store_order`
--
ALTER TABLE `ims_site_store_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goodid` (`goodsid`),
  ADD KEY `buyerid` (`buyerid`);

--
-- Indexes for table `ims_site_styles`
--
ALTER TABLE `ims_site_styles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_styles_vars`
--
ALTER TABLE `ims_site_styles_vars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_site_templates`
--
ALTER TABLE `ims_site_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_stat_fans`
--
ALTER TABLE `ims_stat_fans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`,`date`);

--
-- Indexes for table `ims_stat_keyword`
--
ALTER TABLE `ims_stat_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`);

--
-- Indexes for table `ims_stat_msg_history`
--
ALTER TABLE `ims_stat_msg_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`);

--
-- Indexes for table `ims_stat_rule`
--
ALTER TABLE `ims_stat_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_createtime` (`createtime`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_stat_visit`
--
ALTER TABLE `ims_stat_visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `module` (`module`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_stat_visit_ip`
--
ALTER TABLE `ims_stat_visit_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_date_module_uniacid` (`ip`,`date`,`module`,`uniacid`);

--
-- Indexes for table `ims_superman_home_kv`
--
ALTER TABLE `ims_superman_home_kv`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_skey` (`skey`);

--
-- Indexes for table `ims_system_stat_visit`
--
ALTER TABLE `ims_system_stat_visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ims_uni_account`
--
ALTER TABLE `ims_uni_account`
  ADD PRIMARY KEY (`uniacid`);

--
-- Indexes for table `ims_uni_account_group`
--
ALTER TABLE `ims_uni_account_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_uni_account_menus`
--
ALTER TABLE `ims_uni_account_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `menuid` (`menuid`);

--
-- Indexes for table `ims_uni_account_modules`
--
ALTER TABLE `ims_uni_account_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_module` (`module`),
  ADD KEY `idx_uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_account_modules_shortcut`
--
ALTER TABLE `ims_uni_account_modules_shortcut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_uni_account_users`
--
ALTER TABLE `ims_uni_account_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_memberid` (`uid`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_group`
--
ALTER TABLE `ims_uni_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_link_uniacid`
--
ALTER TABLE `ims_uni_link_uniacid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_uni_modules`
--
ALTER TABLE `ims_uni_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_uni_settings`
--
ALTER TABLE `ims_uni_settings`
  ADD PRIMARY KEY (`uniacid`);

--
-- Indexes for table `ims_uni_verifycode`
--
ALTER TABLE `ims_uni_verifycode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_userapi_cache`
--
ALTER TABLE `ims_userapi_cache`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_userapi_reply`
--
ALTER TABLE `ims_userapi_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_users`
--
ALTER TABLE `ims_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ims_users_bind`
--
ALTER TABLE `ims_users_bind`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `bind_sign` (`bind_sign`);

--
-- Indexes for table `ims_users_create_group`
--
ALTER TABLE `ims_users_create_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_extra_group`
--
ALTER TABLE `ims_users_extra_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_extra_limit`
--
ALTER TABLE `ims_users_extra_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_extra_modules`
--
ALTER TABLE `ims_users_extra_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_extra_templates`
--
ALTER TABLE `ims_users_extra_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_failed_login`
--
ALTER TABLE `ims_users_failed_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_username` (`ip`,`username`);

--
-- Indexes for table `ims_users_founder_group`
--
ALTER TABLE `ims_users_founder_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_founder_own_create_groups`
--
ALTER TABLE `ims_users_founder_own_create_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_founder_own_uni_groups`
--
ALTER TABLE `ims_users_founder_own_uni_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_founder_own_users`
--
ALTER TABLE `ims_users_founder_own_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_founder_own_users_groups`
--
ALTER TABLE `ims_users_founder_own_users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_group`
--
ALTER TABLE `ims_users_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_invitation`
--
ALTER TABLE `ims_users_invitation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_code` (`code`);

--
-- Indexes for table `ims_users_lastuse`
--
ALTER TABLE `ims_users_lastuse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_permission`
--
ALTER TABLE `ims_users_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_users_profile`
--
ALTER TABLE `ims_users_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ims_video_reply`
--
ALTER TABLE `ims_video_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_voice_reply`
--
ALTER TABLE `ims_voice_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `ims_wechat_attachment`
--
ALTER TABLE `ims_wechat_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `media_id` (`media_id`),
  ADD KEY `acid` (`acid`);

--
-- Indexes for table `ims_wechat_news`
--
ALTER TABLE `ims_wechat_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `attach_id` (`attach_id`);

--
-- Indexes for table `ims_wxapp_general_analysis`
--
ALTER TABLE `ims_wxapp_general_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uniacid` (`uniacid`),
  ADD KEY `ref_date` (`ref_date`);

--
-- Indexes for table `ims_wxapp_versions`
--
ALTER TABLE `ims_wxapp_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `version` (`version`),
  ADD KEY `uniacid` (`uniacid`);

--
-- Indexes for table `ims_wxcard_reply`
--
ALTER TABLE `ims_wxcard_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ims_account`
--
ALTER TABLE `ims_account`
  MODIFY `acid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_account_wxapp`
--
ALTER TABLE `ims_account_wxapp`
  MODIFY `acid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_clerks`
--
ALTER TABLE `ims_activity_clerks`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_clerk_menu`
--
ALTER TABLE `ims_activity_clerk_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_exchange`
--
ALTER TABLE `ims_activity_exchange`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_exchange_trades`
--
ALTER TABLE `ims_activity_exchange_trades`
  MODIFY `tid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_exchange_trades_shipping`
--
ALTER TABLE `ims_activity_exchange_trades_shipping`
  MODIFY `tid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_activity_stores`
--
ALTER TABLE `ims_activity_stores`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_category`
--
ALTER TABLE `ims_article_category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_comment`
--
ALTER TABLE `ims_article_comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_news`
--
ALTER TABLE `ims_article_news`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_notice`
--
ALTER TABLE `ims_article_notice`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_article_unread_notice`
--
ALTER TABLE `ims_article_unread_notice`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_attachment_group`
--
ALTER TABLE `ims_attachment_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_basic_reply`
--
ALTER TABLE `ims_basic_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_business`
--
ALTER TABLE `ims_business`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_attachment`
--
ALTER TABLE `ims_core_attachment`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_core_cron`
--
ALTER TABLE `ims_core_cron`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_cron_record`
--
ALTER TABLE `ims_core_cron_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_job`
--
ALTER TABLE `ims_core_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_menu`
--
ALTER TABLE `ims_core_menu`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_menu_shortcut`
--
ALTER TABLE `ims_core_menu_shortcut`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_paylog`
--
ALTER TABLE `ims_core_paylog`
  MODIFY `plid` bigint(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_performance`
--
ALTER TABLE `ims_core_performance`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_queue`
--
ALTER TABLE `ims_core_queue`
  MODIFY `qid` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_refundlog`
--
ALTER TABLE `ims_core_refundlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_resource`
--
ALTER TABLE `ims_core_resource`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_core_sendsms_log`
--
ALTER TABLE `ims_core_sendsms_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon`
--
ALTER TABLE `ims_coupon`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_activity`
--
ALTER TABLE `ims_coupon_activity`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_groups`
--
ALTER TABLE `ims_coupon_groups`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_location`
--
ALTER TABLE `ims_coupon_location`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_modules`
--
ALTER TABLE `ims_coupon_modules`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_record`
--
ALTER TABLE `ims_coupon_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_coupon_store`
--
ALTER TABLE `ims_coupon_store`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_cover_reply`
--
ALTER TABLE `ims_cover_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ims_custom_reply`
--
ALTER TABLE `ims_custom_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_images_reply`
--
ALTER TABLE `ims_images_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_job`
--
ALTER TABLE `ims_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card`
--
ALTER TABLE `ims_mc_card`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_credit_set`
--
ALTER TABLE `ims_mc_card_credit_set`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_members`
--
ALTER TABLE `ims_mc_card_members`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_notices`
--
ALTER TABLE `ims_mc_card_notices`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_notices_unread`
--
ALTER TABLE `ims_mc_card_notices_unread`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_record`
--
ALTER TABLE `ims_mc_card_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_card_sign_record`
--
ALTER TABLE `ims_mc_card_sign_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_cash_record`
--
ALTER TABLE `ims_mc_cash_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_chats_record`
--
ALTER TABLE `ims_mc_chats_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_credits_recharge`
--
ALTER TABLE `ims_mc_credits_recharge`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_credits_record`
--
ALTER TABLE `ims_mc_credits_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_fans_groups`
--
ALTER TABLE `ims_mc_fans_groups`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_fans_tag_mapping`
--
ALTER TABLE `ims_mc_fans_tag_mapping`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_groups`
--
ALTER TABLE `ims_mc_groups`
  MODIFY `groupid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_mc_handsel`
--
ALTER TABLE `ims_mc_handsel`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_mapping_fans`
--
ALTER TABLE `ims_mc_mapping_fans`
  MODIFY `fanid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_mapping_ucenter`
--
ALTER TABLE `ims_mc_mapping_ucenter`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_mass_record`
--
ALTER TABLE `ims_mc_mass_record`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_members`
--
ALTER TABLE `ims_mc_members`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_member_address`
--
ALTER TABLE `ims_mc_member_address`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_member_fields`
--
ALTER TABLE `ims_mc_member_fields`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_member_property`
--
ALTER TABLE `ims_mc_member_property`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mc_oauth_fans`
--
ALTER TABLE `ims_mc_oauth_fans`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_menu_event`
--
ALTER TABLE `ims_menu_event`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_message_notice_log`
--
ALTER TABLE `ims_message_notice_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_mobilenumber`
--
ALTER TABLE `ims_mobilenumber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules`
--
ALTER TABLE `ims_modules`
  MODIFY `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ims_modules_bindings`
--
ALTER TABLE `ims_modules_bindings`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_cloud`
--
ALTER TABLE `ims_modules_cloud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_ignore`
--
ALTER TABLE `ims_modules_ignore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_plugin`
--
ALTER TABLE `ims_modules_plugin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_plugin_rank`
--
ALTER TABLE `ims_modules_plugin_rank`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_rank`
--
ALTER TABLE `ims_modules_rank`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_modules_recycle`
--
ALTER TABLE `ims_modules_recycle`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_music_reply`
--
ALTER TABLE `ims_music_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_news_reply`
--
ALTER TABLE `ims_news_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_paycenter_order`
--
ALTER TABLE `ims_paycenter_order`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_phoneapp_versions`
--
ALTER TABLE `ims_phoneapp_versions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_profile_fields`
--
ALTER TABLE `ims_profile_fields`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `ims_qrcode`
--
ALTER TABLE `ims_qrcode`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_qrcode_stat`
--
ALTER TABLE `ims_qrcode_stat`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_rule`
--
ALTER TABLE `ims_rule`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ims_rule_keyword`
--
ALTER TABLE `ims_rule_keyword`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ims_site_article`
--
ALTER TABLE `ims_site_article`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_article_comment`
--
ALTER TABLE `ims_site_article_comment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_category`
--
ALTER TABLE `ims_site_category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_multi`
--
ALTER TABLE `ims_site_multi`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_site_nav`
--
ALTER TABLE `ims_site_nav`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_page`
--
ALTER TABLE `ims_site_page`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_slide`
--
ALTER TABLE `ims_site_slide`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_cash_log`
--
ALTER TABLE `ims_site_store_cash_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_cash_order`
--
ALTER TABLE `ims_site_store_cash_order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_create_account`
--
ALTER TABLE `ims_site_store_create_account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_goods`
--
ALTER TABLE `ims_site_store_goods`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_store_order`
--
ALTER TABLE `ims_site_store_order`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_styles`
--
ALTER TABLE `ims_site_styles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_site_styles_vars`
--
ALTER TABLE `ims_site_styles_vars`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_site_templates`
--
ALTER TABLE `ims_site_templates`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_stat_fans`
--
ALTER TABLE `ims_stat_fans`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ims_stat_keyword`
--
ALTER TABLE `ims_stat_keyword`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_msg_history`
--
ALTER TABLE `ims_stat_msg_history`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_rule`
--
ALTER TABLE `ims_stat_rule`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_stat_visit`
--
ALTER TABLE `ims_stat_visit`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ims_stat_visit_ip`
--
ALTER TABLE `ims_stat_visit_ip`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_superman_home_kv`
--
ALTER TABLE `ims_superman_home_kv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_system_stat_visit`
--
ALTER TABLE `ims_system_stat_visit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account`
--
ALTER TABLE `ims_uni_account`
  MODIFY `uniacid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_uni_account_group`
--
ALTER TABLE `ims_uni_account_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_menus`
--
ALTER TABLE `ims_uni_account_menus`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_modules`
--
ALTER TABLE `ims_uni_account_modules`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_modules_shortcut`
--
ALTER TABLE `ims_uni_account_modules_shortcut`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_account_users`
--
ALTER TABLE `ims_uni_account_users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_group`
--
ALTER TABLE `ims_uni_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_uni_link_uniacid`
--
ALTER TABLE `ims_uni_link_uniacid`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_modules`
--
ALTER TABLE `ims_uni_modules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_uni_verifycode`
--
ALTER TABLE `ims_uni_verifycode`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_userapi_cache`
--
ALTER TABLE `ims_userapi_cache`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_userapi_reply`
--
ALTER TABLE `ims_userapi_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ims_users`
--
ALTER TABLE `ims_users`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_users_bind`
--
ALTER TABLE `ims_users_bind`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_create_group`
--
ALTER TABLE `ims_users_create_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_extra_group`
--
ALTER TABLE `ims_users_extra_group`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_extra_limit`
--
ALTER TABLE `ims_users_extra_limit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_extra_modules`
--
ALTER TABLE `ims_users_extra_modules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_extra_templates`
--
ALTER TABLE `ims_users_extra_templates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_failed_login`
--
ALTER TABLE `ims_users_failed_login`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_founder_group`
--
ALTER TABLE `ims_users_founder_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_founder_own_create_groups`
--
ALTER TABLE `ims_users_founder_own_create_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_founder_own_uni_groups`
--
ALTER TABLE `ims_users_founder_own_uni_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_founder_own_users`
--
ALTER TABLE `ims_users_founder_own_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_founder_own_users_groups`
--
ALTER TABLE `ims_users_founder_own_users_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_group`
--
ALTER TABLE `ims_users_group`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_invitation`
--
ALTER TABLE `ims_users_invitation`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_lastuse`
--
ALTER TABLE `ims_users_lastuse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ims_users_permission`
--
ALTER TABLE `ims_users_permission`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_users_profile`
--
ALTER TABLE `ims_users_profile`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_video_reply`
--
ALTER TABLE `ims_video_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_voice_reply`
--
ALTER TABLE `ims_voice_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wechat_attachment`
--
ALTER TABLE `ims_wechat_attachment`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wechat_news`
--
ALTER TABLE `ims_wechat_news`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wxapp_general_analysis`
--
ALTER TABLE `ims_wxapp_general_analysis`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wxapp_versions`
--
ALTER TABLE `ims_wxapp_versions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ims_wxcard_reply`
--
ALTER TABLE `ims_wxcard_reply`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
