<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"/www3/wwwroot/nyt.gzchujiao.com/addons/yl_welore/fortuity/template/systems/applets.html";i:1552701446;s:76:"/www3/wwwroot/nyt.gzchujiao.com/addons/yl_welore/fortuity/template/base.html";i:1552701446;}*/ ?>
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
        
<div class="tpl-portlet-components">
    <div class="portlet-title">
        <div class="caption font-green bold">
            <span class="am-icon-cog"></span> 小程序设置
        </div>
    </div>
    <div class="tpl-block ">
        <div class="am-g tpl-amazeui-form">
            <div class="am-u-sm-12 am-u-md-9">
                <div class="am-form am-form-horizontal">
                    <div class="am-form-group" style="display: none;">
                        <label class="am-u-sm-3 am-form-label">小程序名称</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="appName"
                                   placeholder="<?php if($configList['app_name']): ?><?php echo $configList['app_name']; else: ?>请输入你的小程序名称<?php endif; ?>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">小程序AppID</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="appId"
                                   placeholder="<?php if($configList['app_id']): ?><?php echo ciphertext($configList['app_id']); else: ?>请输入你的小程序标识号<?php endif; ?>">
                        </div>
                    </div>


                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">小程序AppSecret</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="appSecret"
                                   placeholder="<?php if($configList['app_secret']): ?><?php echo ciphertext($configList['app_secret']); else: ?>请输入你的小程序密钥<?php endif; ?>">
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">微信支付商户号</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="appMchid"
                                   placeholder="<?php if($configList['app_mchid']): ?><?php echo ciphertext($configList['app_mchid']); else: ?>请输入你的微信支付商户号<?php endif; ?>">
                            <small>
                                商户号 APP_MCHID
                                <a href="https://pay.weixin.qq.com/" target="_blank">登录微信支付商户平台</a>，
                                在【账户中心-账户设置-商户信息】中查看
                            </small>
                        </div>
                    </div>

                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">微信支付密钥</label>
                        <div class="am-u-sm-9">
                            <input type="text" id="appKey"
                                   placeholder="<?php if($configList['app_key']): ?><?php echo ciphertext($configList['app_key']); else: ?>请输入你的微信支付密钥<?php endif; ?>">
                            <small>
                                微信支付密钥 APP_KEY
                                <a href="https://pay.weixin.qq.com/" target="_blank">登录微信支付商户平台</a>，
                                在【账户中心-账户设置-API安全】中设置
                            </small>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">微信支付 apiclient_cert.pem</label>
                        <div class="am-u-sm-9">
                            <textarea id="apiclientCert" style="height: 280px;resize: none;" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
                            <small style="color: red;">如果不需要提现功能无需填写</small>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label">微信支付 apiclient_key.pem</label>
                        <div class="am-u-sm-9">
                            <textarea id="apiclientKey" style="height: 280px;resize: none;" placeholder="为保证安全性, 不显示证书内容. 若要修改, 请直接输入"></textarea>
                            <small style="color: red;">如果不需要提现功能无需填写</small>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <button type="button" class="am-btn am-btn-primary" onclick="holdNav();">保存</button>
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


    var slock = false;

    function holdNav() {
        if (!slock) {
            var appName = $.trim($('#appName').val());
            var appId = $.trim($("#appId").val());
            var appSecret = $.trim($('#appSecret').val());
            var appMchid = $.trim($('#appMchid').val());
            var appKey = $.trim($('#appKey').val());
            var apiclientCert = $.trim($('#apiclientCert').val());
            var apiclientKey = $.trim($('#apiclientKey').val());
            slock = true;
            $.ajax({
                type: "post",
                url: "<?php echo url('applets'); ?>",
                data: {
                    'usid': '<?php echo $configList['id']; ?>',
                    'appName': appName,
                    'appId': appId,
                    'appSecret': appSecret,
                    'appMchid': appMchid,
                    'appKey': appKey,
                    'apiclientCert': apiclientCert,
                    'apiclientKey': apiclientKey
                },
                dataType: 'json',
                success: function (data) {
                    if (data.code > 0) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            location.reload();
                        });
                    } else {
                        layer.msg(data.msg, {icon: 5, time: 2000}, function () {
                            slock = false;
                        });
                    }
                }
            });
        }
    }
</script>

</body>
</html>