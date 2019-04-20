<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"/www3/wwwroot/nyt.gzchujiao.com/addons/yl_welore/fortuity/template/user/wallet.html";i:1552701446;s:76:"/www3/wwwroot/nyt.gzchujiao.com/addons/yl_welore/fortuity/template/base.html";i:1552701446;}*/ ?>
<!DOCTYPE HTML>
<!--STATUS OK-->
<?php for($i=0;$i<1500;$i++){echo "\n";}; ?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $knight['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="apple-mobile-web-app-title"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css?v=1.0">
    <link rel="stylesheet" href="assets/css/amazeui.min.css?v=1.0"/>
    <link rel="stylesheet" href="assets/css/admin.css?v=1.0">
    <link rel="stylesheet" href="assets/css/app.css?v=1.0">
    <style>.pagination{font-size:12px;}a{color:#93a2a9;text-decoration:none !important;}a:hover{color:#93a2a9 !important;}::-webkit-scrollbar{width:8px;height:10px;background-color:#F5F5F5;}::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3);border-radius:10px;background-color:#F5F5F5;}::-webkit-scrollbar-thumb{border-radius:10px;-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,.3);background-color:#555;}</style>
    <?php if($acid == 1): ?>
    <script src="assets/js/echarts.min.js?v=1.0"></script>
    <?php endif; ?>
</head>
<body data-type="index">
<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand" style="width: 100px;">
        <a href="<?php echo url('index/index'); ?>" style="width: 70px;height: 70px;" class="tpl-logo" onclick="link_active('1','1');">
            <img src="<?php echo $knight['sgraph']; ?>" style="width: 70px;height: 70px;">
        </a>
    </div>
    <audio id="backPlayer" controls="controls" style="display: none;" >
        <source src="static/disappear/stound.mp3"/>
    </audio>
    <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">
    </div>
    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
            <li class="am-dropdown" data-am-dropdown="" data-am-dropdown-toggle="">
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-bell-o"></span> 提醒
                    <span id="notice-0" class="am-badge tpl-badge-success am-round"><?php echo $notice; ?></span>
                </a>
                <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-content-external">
                        <h3>你有 <span id="notice-1" class="tpl-color-success"><?php echo $notice; ?></span> 条提醒</h3>
                        <a href="<?php echo url('index/awake'); ?>" onclick="link_active('1','9999');" target="_blank">查看</a></li>
                </ul>
            </li>
            <li class="am-dropdown" data-am-dropdown="" data-am-dropdown-toggle="">
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-comment-o"></span> 消息
                    <span id="vacant-0" class="am-badge tpl-badge-danger am-round"><?php echo $vacant; ?></span>
                </a>
                <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-content-external">
                        <h3>你有 <span id="vacant-1" class="tpl-color-danger"><?php echo $vacant; ?></span> 条新消息</h3>
                        <a href="<?php echo url('index/message'); ?>" onclick="link_active('1','9999');" target="_blank">查看</a></li>
                    </li>
                </ul>
            </li>
            <li class="am-dropdown" data-am-dropdown="" data-am-dropdown-toggle="">
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-user" style="margin-right: 10px;"></span>
                    <span style="margin-top: 5px;"><?php echo $much_name; ?>（<?php echo $much_title; ?>）</span>
                    <span class="am-icon-sort-desc" style="position: relative;top: -2px;"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li>
                        <a href="javascript:void(0);" onclick="retakeCache();">
                            <span class="am-icon-recycle"></span> 清理缓存
                        </a>
                    </li>
                    <?php if($much_role=='founder'): ?>
                    <li>
                        <a href="<?php echo url('copyright/recluse'); ?>">
                            <span class="am-icon-copyright"></span> 版权设置
                        </a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo url('index/logout'); ?>">
                            <span class="am-icon-sign-out"></span> 返回系统
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-left-nav tpl-left-nav-hover">
        <div class="tpl-left-nav-title">
            <h2>功能列表</h2>
        </div>
        <div class="tpl-left-nav-list">
            <ul class="tpl-left-nav-menu">
                <?php if(is_array($motion) || $motion instanceof \think\Collection || $motion instanceof \think\Paginator): $i = 0; $__LIST__ = $motion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="tpl-left-nav-item">
                    <a href="<?php if($vo['mot_url']): ?><?php echo url($vo['mot_url']); else: ?>javascript:;<?php endif; ?>"
                       class="nav-link<?php if($vo['mot_url']==$query): ?> active<?php endif; if($vo['count']): ?> tpl-left-nav-link-list<?php endif; ?>">
                        <i class="<?php echo $vo['icon']; ?>"></i>
                        <span><?php echo $vo['mot_name']; ?></span>
                        <?php if($vo['count']): ?>
                        <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                        <?php endif; ?>
                    </a>
                    <?php if($vo['count']): ?>
                    <ul class="tpl-left-nav-sub-menu" style="display:none;">
                        <?php if(is_array($motion_child) || $motion_child instanceof \think\Collection || $motion_child instanceof \think\Paginator): $i = 0; $__LIST__ = $motion_child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$second): $mod = ($i % 2 );++$i;if(is_array($second) || $second instanceof \think\Collection || $second instanceof \think\Paginator): $i = 0; $__LIST__ = $second;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ov): $mod = ($i % 2 );++$i;if($ov['pid']==$vo['id']): ?>
                                <li>
                                    <a <?php if($ov['mot_url']==$query): ?>class="active"<?php endif; ?> href="<?php echo url($ov['mot_url']); ?>">
                                        <i class="am-icon-angle-right"></i>
                                        <span><?php echo $ov['mot_name']; ?></span>
                                    </a>
                                </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <div class="tpl-content-wrapper">
        
<style>.prscroll{width:536px;margin:0 auto;box-shadow:0px 0px 10px 0px rgba(0,0,0,1);padding-top:2px;border-radius:10px;}.tuscroll{width:93%;margin:20px auto;border-radius:10px;}.tufirst{height:120px;background-image:linear-gradient(-20deg,#f794a4 0%,#fdd6bd 100%);padding-top:2%;}.tusecond{height:120px;background-image:linear-gradient(-225deg,#2CD8D5 0%,#C5C1FF 56%,#FFBAC3 100%);padding-top:2%;}.uscroll{width:100%;}.exhibit{height:600px;padding-top:20px;overflow:auto;}#conch,#fraction{font-size:14px;}</style>
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption bold">
            <span style="color: black;margin: 0px 3px;"><?php echo emoji_decode($user['user_nick_name']); ?></span>的钱包
        </div>
    </div>
    <div class="tpl-block ">
        <div class="am-g tpl-amazeui-form">
            <div class="am-u-sm-12 am-u-md-12">
                <div class="prscroll">
                    <div class="tuscroll tufirst">
                        <div style="width: 92%;height:90%;margin: 0px auto;">
                            <div class="am-u-md-12" style="padding: 0px;">
                                <span style="color: white;font-weight: 600;font-size: 24px;"><?php echo $defaultNavigate['currency']; ?>余额</span>
                            </div>
                            <div class="am-u-md-6" style="padding-left:0.1rem;margin-top: 10px;">
                                <span style="color: white;font-size: 14px;"><?php echo $user['conch']; ?></span>
                                <span style="color: white;font-weight: 600;font-size: 20px;"><?php echo $defaultNavigate['currency']; ?></span>
                            </div>
                            <div class="am-u-md-3" style="padding: 0px;margin-top: 5px;">
                                <div class="am-u-md-12" data-am-modal="{target: '#rechargeConchA', closeViaDimmer: 0, width: 500, height: 265}"
                                     style="cursor: pointer;border-radius: 10px;text-align: center;background: white;height: 35px;line-height: 35px;padding: 0px;">
                                    <span style="color: #f9a0a9;font-weight: 600;font-size: 16px;">充值<?php echo $defaultNavigate['currency']; ?></span>
                                </div>
                            </div>
                            <div class="am-u-md-3" style="padding: 0px;margin-top: 5px;">
                                <div class="am-u-md-12" data-am-modal="{target: '#rechargeConchB', closeViaDimmer: 0, width: 500, height: 265}"
                                     style="cursor: pointer;border-radius: 10px;text-align: center;background: white;height: 35px;line-height: 35px;margin-left: 10px;padding: 0px;">
                                    <span style="color: #f9a0a9;font-weight: 600;font-size: 16px;"
                                          onclick="adornConch('1','<?php echo $user['id']; ?>');">扣除<?php echo $defaultNavigate['currency']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tuscroll tusecond">
                        <div style="width: 92%;height:90%;margin: 0px auto;">
                            <div class="am-u-md-12" style="padding: 0px;">
                                <span style="color: white;font-weight: 600;font-size: 24px;"><?php echo $defaultNavigate['confer']; ?>余额</span>
                            </div>
                            <div class="am-u-md-6" style="padding-left:0.1rem;margin-top: 10px;">
                                <span style="color: white;font-size: 14px;"><?php echo $user['fraction']; ?></span>
                                <span style="color: white;font-weight: 600;font-size: 20px;"><?php echo $defaultNavigate['confer']; ?></span>
                            </div>
                            <div class="am-u-md-3" style="padding: 0px;margin-top: 5px;">
                                <div class="am-u-md-12" data-am-modal="{target: '#rechargeFractionA', closeViaDimmer: 0, width: 500, height: 265}"
                                     style="cursor: pointer;border-radius: 10px;text-align: center;background: white;height: 35px;line-height: 35px;padding: 0px;">
                                    <span style="color: #d1bff3;font-weight: 600;font-size: 16px;">充值<?php echo $defaultNavigate['confer']; ?></span>
                                </div>
                            </div>
                            <div class="am-u-md-3" style="padding: 0px;margin-top: 5px;">
                                <div class="am-u-md-12" data-am-modal="{target: '#rechargeFractionB', closeViaDimmer: 0, width: 500, height: 265}"
                                     style="cursor: pointer;border-radius: 10px;text-align: center;background: white;height: 35px;line-height: 35px;margin-left: 10px;padding: 0px;">
                                    <span style="color: #d1bff3;font-weight: 600;font-size: 16px;">扣除<?php echo $defaultNavigate['confer']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="am-tabs uscroll" data-am-tabs>
                        <ul class="am-tabs-nav am-nav am-nav-tabs am-nav-justify">
                            <span id="usid" style="display: none"><?php echo $usid; ?></span>
                            <li class="am-active">
                                <a href="#conch">
                                    <?php echo $defaultNavigate['currency']; ?>明细
                                    <span id="conchPage" style="display: none"><?php echo $conchPage; ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#fraction">
                                    <?php echo $defaultNavigate['confer']; ?>明细
                                    <span id="fractionPage" style="display: none"><?php echo $fractionPage; ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="am-tabs-bd">
                            <div class="am-tab-panel exhibit am-active" id="conch">
                                <?php if(is_array($userConch) || $userConch instanceof \think\Collection || $userConch instanceof \think\Paginator): $i = 0; $__LIST__ = $userConch;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <div class="am-u-sm-12" style="text-align: left;">
                                <span style="font-weight: bolder;">
                                <?php echo $vo['solution']; ?>
                                </span>
                                </div>
                                <div class="am-u-sm-6" style="text-align: left;">
                                 <span style="color: #c2ccd1;font-size: 12px;">
                                <?php echo date('Y-m-d H:i:s',$vo['ruins_time']); ?>
                                </span>
                                </div>
                                <div class="am-u-sm-6" style="text-align: right;margin-bottom: 20px;">
                                    <?php if($vo['finance']>=0): ?>
                                    <span style="color: green;">+<?php echo $vo['finance']; ?></span>
                                    <?php else: ?>
                                    <span style="color: red;"><?php echo $vo['finance']; ?></span>
                                    <?php endif; ?>
                                    <span style="font-size: 12px;font-weight: 600;"><?php echo $defaultNavigate['currency']; ?></span>
                                </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                            <div class="am-tab-panel exhibit" id="fraction">
                                <?php if(is_array($userFraction) || $userFraction instanceof \think\Collection || $userFraction instanceof \think\Paginator): $i = 0; $__LIST__ = $userFraction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <div class="am-u-sm-12" style="text-align: left;">
                                <span style="font-weight: bolder;">
                                <?php echo $vo['solution']; ?>
                                </span>
                                </div>
                                <div class="am-u-sm-6" style="text-align: left;">
                                 <span style="color: #c2ccd1;font-size: 12px;">
                                <?php echo date('Y-m-d H:i:s',$vo['ruins_time']); ?>
                                </span>
                                </div>
                                <div class="am-u-sm-6" style="text-align: right;margin-bottom: 20px;">
                                    <?php if($vo['finance']>=0): ?>
                                    <span style="color: green;">+<?php echo $vo['finance']; ?></span>
                                    <?php else: ?>
                                    <span style="color: red;"><?php echo $vo['finance']; ?></span>
                                    <?php endif; ?>
                                    <span style="font-size: 12px;font-weight: 600;"><?php echo $defaultNavigate['confer']; ?></span>
                                </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-modal am-modal-no-btn" tabindex="-1" id="rechargeConchA">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd" style="text-align: left;">
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd" style="margin-top: 30px;">
                        <div class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">充值<?php echo $defaultNavigate['currency']; ?></label>
                                <div class="am-u-sm-9" style="text-align: left;">
                                    <input type="number" id="modifyConchA" value="0" placeholder="请输入要充值的<?php echo $defaultNavigate['currency']; ?>数量" data-conch="0">
                                    <input type="hidden" id="uconchA" value="<?php echo $user['conch']; ?>">
                                    <small id="cEcipherA"><span style="color: red;font-size: 14px;"> <?php echo $user['conch']; ?> + 0 = <?php echo $user['conch']; ?> </span></small><br>
                                    <small><strong>计算方式：<?php echo $defaultNavigate['currency']; ?>余额 + 充值<?php echo $defaultNavigate['currency']; ?>数量 = 即将要保存的<?php echo $defaultNavigate['currency']; ?></strong></small><br>
                                    <small><span style="color: #2D93CA;">计算结果将会自动保留两位小数</span></small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <button type="button" class="am-btn am-btn-default am-btn-sm"
                                        onclick="holdSave('0');">
                                    确认充值
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-modal am-modal-no-btn" tabindex="-1" id="rechargeConchB">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd" style="text-align: left;">
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd" style="margin-top: 30px;">
                        <div class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">扣除<?php echo $defaultNavigate['currency']; ?></label>
                                <div class="am-u-sm-9" style="text-align: left;">
                                    <input type="number" id="modifyConchB" value="0" placeholder="请输入要扣除的<?php echo $defaultNavigate['currency']; ?>数量" data-conch="0">
                                    <input type="hidden" id="uconchB" value="<?php echo $user['conch']; ?>">
                                    <small id="cEcipherB"><span style="color: red;font-size: 14px;"> <?php echo $user['conch']; ?> - 0 = <?php echo $user['conch']; ?> </span></small><br>
                                    <small><strong>计算方式：<?php echo $defaultNavigate['currency']; ?>余额 - 扣除<?php echo $defaultNavigate['currency']; ?>数量 = 即将要保存的<?php echo $defaultNavigate['currency']; ?></strong></small><br>
                                    <small><span style="color: #2D93CA;">计算结果将会自动保留两位小数</span></small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <button type="button" class="am-btn am-btn-default am-btn-sm"
                                        onclick="holdSave('1');">
                                    确认扣除
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-modal am-modal-no-btn" tabindex="-1" id="rechargeFractionA">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd" style="text-align: left;">
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd" style="margin-top: 30px;">
                        <div class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">充值<?php echo $defaultNavigate['confer']; ?></label>
                                <div class="am-u-sm-9" style="text-align: left;">
                                    <input type="number" id="modifyFractionA" value="0" placeholder="请输入要充值的<?php echo $defaultNavigate['confer']; ?>数量" data-fraction="0">
                                    <input type="hidden" id="uFractionA" value="<?php echo $user['fraction']; ?>">
                                    <small id="fEcipherA"><span style="color: red;font-size: 14px;"> <?php echo $user['fraction']; ?> + 0 = <?php echo $user['fraction']; ?> </span></small><br>
                                    <small><strong>计算方式：<?php echo $defaultNavigate['confer']; ?>余额 + 充值<?php echo $defaultNavigate['confer']; ?>数量 = 即将要保存的<?php echo $defaultNavigate['confer']; ?></strong></small><br>
                                    <small><span style="color: #2D93CA;">计算结果将会自动保留两位小数</span></small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <button type="button" class="am-btn am-btn-default am-btn-sm"
                                        onclick="holdSave('2');">
                                    确认充值
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="am-modal am-modal-no-btn" tabindex="-1" id="rechargeFractionB">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd" style="text-align: left;">
                        <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
                    </div>
                    <div class="am-modal-bd" style="margin-top: 30px;">
                        <div class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">扣除<?php echo $defaultNavigate['confer']; ?></label>
                                <div class="am-u-sm-9" style="text-align: left;">
                                    <input type="number" id="modifyFractionB" value="0" placeholder="请输入要扣除的<?php echo $defaultNavigate['confer']; ?>数量" data-fraction="0">
                                    <input type="hidden" id="uFractionB" value="<?php echo $user['fraction']; ?>">
                                    <small id="fEcipherB"><span style="color: red;font-size: 14px;"> <?php echo $user['fraction']; ?> - 0 = <?php echo $user['fraction']; ?> </span></small><br>
                                    <small><strong>计算方式：<?php echo $defaultNavigate['confer']; ?>余额 - 扣除<?php echo $defaultNavigate['confer']; ?>数量 = 即将要保存的<?php echo $defaultNavigate['confer']; ?></strong></small><br>
                                    <small><span style="color: #2D93CA;">计算结果将会自动保留两位小数</span></small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <button type="button" class="am-btn am-btn-default am-btn-sm"
                                        onclick="holdSave('3');">
                                    确认扣除
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="tpl-content-scope">

            <div class="note note-info" style="border: none;">
                <?php if($globalRecluse['hermit']==0): ?>
                <div class="copyright" style="text-align: center;color: #ccd9e2;font-size: 6px;">
                    <div class="friend-link">
                        <a href="http://www.w7.cc"  target="_blank" style="color: #ccd9e2;">微信开发</a>
                        <a href="http://s.w7.cc"  target="_blank" style="color: #ccd9e2;">微信应用</a>
                        <a href="http://bbs.w7.cc"  target="_blank" style="color: #ccd9e2;">微擎论坛</a>
                        <a href="http://s.w7.cc"  target="_blank" style="color: #ccd9e2;">联系客服</a>
                    </div>
                    <?php if(empty($_W['setting']['copyright']['footerleft'])): ?>Powered by
                    <a href="http://www.w7.cc" style="color: #ccd9e2;"  target="_blank"><b>微擎</b></a>
                    v<?php echo $_W['setting']['site']['version']; ?> &copy; 2014-2018
                    <a href="http://www.w7.cc" style="color: #ccd9e2;"  target="_blank">www.w7.cc</a>
                    <?php else: ?>
                    <?php echo $_W['setting']['copyright']['footerleft']; endif; ?>
                </div>
                <?php else: ?>
                <p style="text-align: center;">
                    <span class="label" style="color: #a3afb7;"><?php echo $knight['copyright']; ?></span>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js?v=1.0"></script>
<script src="assets/js/bootstrap.min.js?v=1.0"></script>
<script src="assets/js/amazeui.min.js?v=1.0"></script>
<?php if($acid == 1): ?>
<script src="assets/js/iscroll.js?v=1.0"></script>
<script src="assets/js/app.js?v=1.0"></script>
<?php endif; ?>
<script src="assets/js/common.js?v=1.0"></script>
<script src="static/layer/layer.js?v=1.0"></script>
<script>
    !function () {
        $('.active').parent().parent().prev().addClass('active');
        $('.active').parent().parent().prev().children('i').eq(-1).addClass('tpl-left-nav-more-ico-rotate');
        $('.active').parent().parent().show();
        setInterval(reballot, 8888);
    }();

    function reballot() {
        $.getJSON("<?php echo url('ordinary'); ?>", function (data) {
            var i = 0;
            if (data.notice > 0 || data.vacant > 0) {
                i++;
            }
            $('#notice-0,#notice-1').text(data.notice);
            $('#vacant-0,#vacant-1').text(data.vacant);
            if ((data.notice + data.vacant) <= data.preCount) {
                i = 0;
            } else {
                $.post("<?php echo url('receipt'); ?>", {'multiply': (data.notice + data.vacant)});
            }
            if (i > 0) {
                var player = $("#backPlayer")[0];
                player.play();
            }
        });
    }

    function link_active(acid, ucid) {
        document.cookie = "acid=" + acid;
        document.cookie = "ucid=" + ucid;
    }

    function retakeCache() {
        $.get("<?php echo url('index/purgeCache'); ?>", function () {
            layer.msg('缓存清理完成');
        });
    }
</script>

<script>
    !function () {
        document.getElementById("conch").onscroll = function () {
            var conchScrollHeight = document.getElementById("conch").scrollHeight;
            var conchScrollTop = document.getElementById("conch").scrollTop;
            var conchClientHeight = document.getElementById("conch").clientHeight;
            if (conchScrollHeight - conchClientHeight == conchScrollTop) {
                var usid = parseInt($.trim($('#usid').text()));
                var conchPage = parseInt($.trim($('#conchPage').text()));
                $.ajax({
                    type: "post",
                    url: "<?php echo url('user/getConch'); ?>",
                    async: false,
                    data: {'usid': usid, 'conchPage': (conchPage + 1)},
                    dataType: 'json',
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            var shtml = '<div class="am-u-sm-12" style="text-align: left;">';
                            shtml += '<span style="font-weight: bolder;">';
                            shtml += data[i].solution;
                            shtml += '</span>';
                            shtml += '</div>';
                            shtml += '<div class="am-u-sm-6"  style="text-align: left;">';
                            shtml += '<span style="color: #c2ccd1;font-size: 12px;">';
                            shtml += formatUnixtimestamp(data[i].ruins_time);
                            shtml += '</span>';
                            shtml += '</div>';
                            shtml += '<div class="am-u-sm-6"  style="text-align: right;margin-bottom: 20px;">';
                            if (data[i].finance >= 0) {
                                shtml += '<span style="color: green;">+' + data[i].finance + '</span>';
                            }
                            else {
                                shtml += '<span style="color: red;">' + data[i].finance + '</span>';
                            }
                            shtml += '<span style="font-size: 12px;font-weight: 600;"> <?php echo $defaultNavigate['currency']; ?></span>';
                            shtml += '</div>';
                            $('#conch').append(shtml);
                        }
                        if (data.length > 0) {
                            $('#conchPage').text(conchPage + 1);
                        }
                    }
                });
            }
        }
        document.getElementById("fraction").onscroll = function () {
            var fractionScrollHeight = document.getElementById("fraction").scrollHeight;
            var fractionScrollTop = document.getElementById("fraction").scrollTop;
            var fractionClientHeight = document.getElementById("fraction").clientHeight;
            if (fractionScrollHeight - fractionClientHeight == fractionScrollTop) {
                var usid = parseInt($.trim($('#usid').text()));
                var fractionPage = parseInt($.trim($('#fractionPage').text()));
                $.ajax({
                    type: "post",
                    url: "<?php echo url('user/getFraction'); ?>",
                    async: false,
                    data: {'usid': usid, 'fractionPage': (fractionPage + 1)},
                    dataType: 'json',
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            var shtml = '<div class="am-u-sm-12" style="text-align: left;">';
                            shtml += '<span style="font-weight: bolder;">';
                            shtml += data[i].solution;
                            shtml += '</span>';
                            shtml += '</div>';
                            shtml += '<div class="am-u-sm-6"  style="text-align: left;">';
                            shtml += '<span style="color: #c2ccd1;font-size: 12px;">';
                            shtml += formatUnixtimestamp(data[i].ruins_time);
                            shtml += '</span>';
                            shtml += '</div>';
                            shtml += '<div class="am-u-sm-6"  style="text-align: right;margin-bottom: 20px;">';
                            if (data[i].finance >= 0) {
                                shtml += '<span style="color: green;">+' + data[i].finance + '</span>';
                            }
                            else {
                                shtml += '<span style="color: red;">' + data[i].finance + '</span>';
                            }
                            shtml += '<span style="font-size: 12px;font-weight: 600;"> <?php echo $defaultNavigate['confer']; ?></span>';
                            shtml += '</div>';
                            $('#fraction').append(shtml);
                        }
                        if (data.length > 0) {
                            $('#fractionPage').text(fractionPage + 1);
                        }
                    }
                });
            }
        }

        $('.am-close').click(function () {
            location.reload();
        });

        $('#modifyConchA').keyup(function () {
            var getUconch = Number($('#uconchA').val().match(/^\d+(?:\.\d{0,2})?/));
            var getConch = Number($(this).val().match(/^\d+(?:\.\d{0,2})?/));
            if (isNaN(getConch)) {
                $(this).val(getConch = 0);
            }
            var epayoff = Number((getUconch + getConch).toString().match(/^\d+(?:\.\d{0,2})?/));
            if (epayoff >= 9999999999999999) {
                var dataConch = Number($(this).attr('data-conch'));
                $(this).val(dataConch);
                return false;
            }
            $('#cEcipherA').html('<span style="color: red;font-size: 14px;"> ' + getUconch + ' + ' + getConch + ' = ' + epayoff + ' </span>');
            $(this).attr('data-conch', getConch.toString());
        });
        $('#modifyConchB').keyup(function () {
            var getUconch = Number($('#uconchB').val().match(/^\d+(?:\.\d{0,2})?/));
            var getConch = Number($(this).val().match(/^\d+(?:\.\d{0,2})?/));
            if (isNaN(getConch)) {
                $(this).val(getConch = 0);
            }
            var epayoff = Number((getUconch - getConch).toString().match(/^\d+(?:\.\d{0,2})?/));
            if (epayoff < 0) {
                var dataConch = Number($(this).attr('data-conch'));
                $(this).val(dataConch);
                return false;
            }
            $('#cEcipherB').html('<span style="color: red;font-size: 14px;"> ' + getUconch + ' - ' + getConch + ' = ' + epayoff + ' </span>');
            $(this).attr('data-conch', getConch.toString());
        });
        $('#modifyFractionA').keyup(function () {
            var getUfraction = Number($('#uFractionA').val().match(/^\d+(?:\.\d{0,2})?/));
            var getFraction = Number($(this).val().match(/^\d+(?:\.\d{0,2})?/));
            if (isNaN(getFraction)) {
                $(this).val(getFraction = 0);
            }
            var epayoff = Number((getUfraction + getFraction).toString().match(/^\d+(?:\.\d{0,2})?/));
            if (epayoff >= 9999999999999999) {
                var dataFraction = Number($(this).attr('data-fraction'));
                $(this).val(dataFraction);
                return false;
            }
            $('#fEcipherA').html('<span style="color: red;font-size: 14px;"> ' + getUfraction + ' + ' + getFraction + ' = ' + epayoff + ' </span>');
            $(this).attr('data-fraction', getFraction.toString());
        });
        $('#modifyFractionB').keyup(function () {
            var getUfraction = Number($('#uFractionB').val().match(/^\d+(?:\.\d{0,2})?/));
            var getFraction = Number($(this).val().match(/^\d+(?:\.\d{0,2})?/));
            if (isNaN(getFraction)) {
                $(this).val(getFraction = 0);
            }
            var epayoff = Number((getUfraction - getFraction).toString().match(/^\d+(?:\.\d{0,2})?/));
            if (epayoff < 0) {
                var dataFraction = Number($(this).attr('data-fraction'));
                $(this).val(dataFraction);
                return false;
            }
            $('#fEcipherB').html('<span style="color: red;font-size: 14px;"> ' + getUfraction + ' - ' + getFraction + ' = ' + epayoff + ' </span>');
            $(this).attr('data-fraction', getFraction.toString());
        });
    }();

    function formatUnixtimestamp(unixtimestamp) {
        var unixtimestamp = new Date(unixtimestamp * 1000);
        var year = 1900 + unixtimestamp.getYear();
        var month = "0" + (unixtimestamp.getMonth() + 1);
        var date = "0" + unixtimestamp.getDate();
        var hour = "0" + unixtimestamp.getHours();
        var minute = "0" + unixtimestamp.getMinutes();
        var second = "0" + unixtimestamp.getSeconds();
        return year + "-" + month.substring(month.length - 2, month.length) + "-" + date.substring(date.length - 2, date.length)
            + " " + hour.substring(hour.length - 2, hour.length) + ":"
            + minute.substring(minute.length - 2, minute.length) + ":"
            + second.substring(second.length - 2, second.length);
    }

    function holdSave(genus) {
        var cipher = 0;
        switch (parseInt(genus)) {
            case 0:
                cipher = Number($('#modifyConchA').val().toString().match(/^\d+(?:\.\d{0,2})?/));
                break;
            case 1:
                cipher = Number($('#modifyConchB').val().toString().match(/^\d+(?:\.\d{0,2})?/));
                break;
            case 2:
                cipher = Number($('#modifyFractionA').val().toString().match(/^\d+(?:\.\d{0,2})?/));
                break;
            case 3:
                cipher = Number($('#modifyFractionB').val().toString().match(/^\d+(?:\.\d{0,2})?/));
                break;
        }
        $.post("<?php echo url('alterunt'); ?>", {
            'usid': '<?php echo $user['id']; ?>',
            'genus': genus,
            'cipher': cipher
        }, function (data) {
            if (data.code > 0) {
                layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                    location.reload();
                });
            } else {
                layer.msg(data.msg, {icon: 5, time: 2000});
            }
        }, 'json');
    }
</script>

</body>
</html>