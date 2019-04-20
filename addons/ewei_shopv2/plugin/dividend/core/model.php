<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('TM_DIVIDEND_AGENT_NEW', 'TM_DIVIDEND_AGENT_NEW'); //新下线
define('TM_DIVIDEND_ORDER_PAY', 'TM_DIVIDEND_ORDER_PAY'); //新下线付款
define('TM_DIVIDEND_ORDER_FINISH', 'TM_DIVIDEND_ORDER_FINISH'); //完成订单
define('TM_DIVIDEND_APPLY', 'TM_DIVIDEND_APPLY'); //提现申请
define('TM_DIVIDEND_APPLYMONEY', 'TM_DIVIDEND_APPLYMONEY'); //提现申请（店家）
define('TM_DIVIDEND_CHECK', 'TM_DIVIDEND_CHECK'); //审核通过
define('TM_DIVIDEND_PAY', 'TM_DIVIDEND_PAY'); //打款
define('TM_DIVIDEND_BECOME', 'TM_DIVIDEND_BECOME'); //成为队长通知
if (!class_exists('DividendModel')) {

    class DividendModel extends PluginModel
    {

        public function getSet($uniacid = 0)
        {
            $set = m('common')->getPluginset('dividend');
            $set['texts'] = array(
                'agent' => empty($set['texts']['agent']) ? '队长' : $set['texts']['agent'],
                'center' => empty($set['texts']['center']) ? '分红中心' : $set['texts']['center'],
                'become' => empty($set['texts']['become']) ? '成为队长' : $set['texts']['become'],
                'withdraw' => empty($set['texts']['withdraw']) ? '提现' : $set['texts']['withdraw'],
                'dividend' => empty($set['texts']['dividend']) ? '分红' : $set['texts']['dividend'],
                'dividend1' => empty($set['texts']['dividend1']) ? '团队分红' : $set['texts']['dividend1'],
                'dividend_total' => empty($set['texts']['dividend_total']) ? '累计分红' : $set['texts']['dividend_total'],
                'dividend_ok' => empty($set['texts']['dividend_ok']) ? '可提现分红' : $set['texts']['dividend_ok'],
                'dividend_apply' => empty($set['texts']['dividend_apply']) ? '已申请分红' : $set['texts']['dividend_apply'],
                'dividend_check' => empty($set['texts']['dividend_check']) ? '待打款分红' : $set['texts']['dividend_check'],
                'dividend_lock' => empty($set['texts']['dividend_lock']) ? '未结算分红' : $set['texts']['dividend_lock'],
                'dividend_detail' => empty($set['texts']['dividend_detail']) ? '提现明细' : ($set['texts']['dividend_detail'] == '分红明细' ? '提现明细' : $set['texts']['dividend_detail']),
                'dividend_pay' => empty($set['texts']['dividend_pay']) ? '成功提现分红' : $set['texts']['dividend_pay'],
                'dividend_wait' => empty($set['texts']['dividend_wait']) ? '待收货分红' : $set['texts']['dividend_wait'],
                'dividend_fail' => empty($set['texts']['dividend_fail']) ? '无效分红' : $set['texts']['dividend_fail'],
                'dividend_charge' => empty($set['texts']['dividend_charge']) ? '扣除提现手续费' : $set['texts']['dividend_charge'],
                'order' => empty($set['texts']['order']) ? '团队订单' : $set['texts']['order'],
//                'mydown' => empty($set['texts']['mydown']) ? '我的下线' : $set['texts']['mydown'],
//                'down' => empty($set['texts']['down']) ? '下线' : $set['texts']['down'],
                'yuan' => empty($set['texts']['yuan']) ? '元' : $set['texts']['yuan'],
            );
            return $set;
        }

        /**
         * 获取队长所有信息
         * @param type $openid
         * @param type $options 获取参数 total 累计   ordercount 订单统计 ok 可提现拥挤 lock 未结算佣金 apply 待审核佣金 check 待打款用尽 id 是否返回代理ids
         */
        public function getInfo($openid, $options = null)
        {
            global $_W;
            if (empty($options) || !is_array($options)) {
                $options = array();
            }
            $where_time = '';
            if (isset($options['starttime']) && isset($options['endtime'])){
                $options['starttime'] = strexists($options['starttime'],'-') ? strtotime($options['starttime']) : $options['starttime'];
                $options['endtime'] = strexists($options['endtime'],'-') ? strtotime($options['endtime']) : $options['endtime'];
                $where_time = " and o.createtime between {$options['starttime']} and {$options['endtime']}";
            }


            $set = $this->getSet();
            $member = m('member') -> getInfo($openid);

            $time = time();
            $day_times = intval($set['settledays']) * 3600 * 24;

            $groupscount = 0; //团员人数

            $groupscounts = pdo_fetch('select count(id) as counts from '.tablename('ewei_shop_member').' where headsid = :headsid and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
            $groupscount = $groupscounts['counts'];



            $ordercount0 = 0;   //全部订单数(下单的)
            $ordermoney0 = 0;   //全部订单金额(下单的)

            $ordercount = 0;   //已付款订单数 (付款的)
            $ordermoney = 0; //已付款订单金额(付款的)

            $ordercount3 = 0;   //已完成订单数 (完成的)
            $ordermoney3 = 0; //已完成订金额(完成的)

            $dividend_total = 0;  //累计分红
            $dividend_apply=0;//待审核分红
            $dividend_check = 0; //待打款分红
            $dividend_pay = 0; //已打款分红
            $dividend_ok = 0; //可提现分红
            $dividend_lock = 0; //未结算分红
            $dividend_wait = 0; //待收货分红
            $dividend_fail = 0; //失败的
//            $dividend_withdraw = 0; //提现笔数


            //累计分红
            if (in_array('total', $options)) {
                $order_all = pdo_fetchall('select id,headsid,price,deductcredit2,dispatchprice,dividend from '.tablename('ewei_shop_order')
                    .' where 1 and headsid = :headsid and status >= 0 and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($order_all)){
                    foreach($order_all as $k => $v){
                        $divedend = iunserializer($v['dividend']);
                        $dividend_total += $divedend['dividend_price'];
                    }
                }
            }

            //可提现分红
            if(in_array('ok', $options)){
                $divedend_order_ok = pdo_fetchall('select id,headsid,price,deductcredit2,dispatchprice,dividend,finishtime from '.tablename('ewei_shop_order')
                    .' where 1 and headsid = :headsid and status >= 3 and dividend_status=0 and ('.$time.'-finishtime > '.$day_times.') and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($divedend_order_ok)){
                    foreach($divedend_order_ok as $k => $v){
                        $dividend = iunserializer($v['dividend']);
                        $dividend_ok += $dividend['dividend_price'];
                    }
                }
            }

            //待打款分红
            if(in_array('check',$options)){
                $check_apply  = pdo_fetchall('select id,orderids,dividend from '.tablename('ewei_shop_dividend_apply')
                    .' where mid = :mid and status = 2 and uniacid = :uniacid',array(':mid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($check_apply)){
                    foreach($check_apply as $k => $v){
                        $dividend_check += $v['dividend'];
                    }
                }
            }

            //待审核分红
            if(in_array('check',$options)){
                $check_apply  = pdo_fetchall('select id,orderids,dividend from '.tablename('ewei_shop_dividend_apply')
                    .' where mid = :mid and status = 1 and uniacid = :uniacid',array(':mid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($check_apply)){
                    foreach($check_apply as $k => $v){
                        $dividend_apply += $v['dividend'];
                    }
                }
            }



            //已打款分红
            if(in_array('pay',$options)){
                $check_apply_pay  = pdo_fetchall('select id,orderids,dividend from '.tablename('ewei_shop_dividend_apply')
                    .' where mid = :mid and status = 3 and uniacid = :uniacid',array(':mid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($check_apply_pay)){
                    foreach($check_apply_pay as $k => $v){
                        $dividend_pay += $v['dividend'];
                    }
                }
            }

            //未结算分红
            if(in_array('lock',$options)){
                $check_apply_lock = pdo_fetchall('select id,headsid,price,deductcredit2,dispatchprice,dividend,finishtime from '.tablename('ewei_shop_order')
                     .' where 1 and headsid = :headsid and status >= 3 and dividend_status=0 and ('.$time.'-finishtime <= '.$day_times.') and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($check_apply_lock)){
                    foreach($check_apply_lock as $k => $v){
                        $dividend = iunserializer($v['dividend']);
                        $dividend_lock += $dividend['dividend_price'];
                    }
                }
            }

            //待收货分红
            if(in_array('wait',$options)){
                $divedend_order_wait = pdo_fetchall('select id,headsid,price,deductcredit2,dispatchprice,dividend,finishtime from '.tablename('ewei_shop_order')
                    .' where 1 and headsid = :headsid and status = 2 and ('.$time.'-finishtime > '.$day_times.') and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($divedend_order_wait)){
                    foreach($divedend_order_wait as $k => $v){
                        $dividend = iunserializer($v['dividend']);
                        $dividend_wait += $dividend['dividend_price'];
                    }
                }
            }

            //失败的分红
            if(in_array('fail',$options)){
                $check_apply_fail  = pdo_fetchall('select id,orderids,dividend from '.tablename('ewei_shop_dividend_apply')
                    .' where mid = :mid and status = -1 and uniacid = :uniacid',array(':mid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($check_apply_fail)){
                    foreach($check_apply_fail as $k => $v){
                        $dividend_fail += $v['dividend'];
                    }
                }
            }

            //提现笔数
//            if(in_array('withdraw',$options)){
//                $withdraw_num = pdo_fetch('select count(distinct id) as count from '.tablename('ewei_shop_dividend_apply').' where mid = :mid and status = 3 and uniacid = :uniacid',array(':mid'=>$member['id'],':uniacid'=>$_W['uniacid']));
//                $dividend_withdraw = $withdraw_num['count'];
//            }

            //全部订单
            if(in_array('ordercount0', $options)){
                $order0 = pdo_fetch('select sum(price) as ordermoney,count(distinct id) as ordercount from '.tablename('ewei_shop_order').' where headsid = :headsid and status >=0 and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($order0)){
                    $ordercount0 += $order0['ordercount'];
                    $ordermoney0 += $order0['ordermoney'];
                }
            }

            //已付款订单
            if(in_array('ordercount', $options)){
                $order = pdo_fetch('select sum(price) as ordermoney,count(distinct id) as ordercount from '.tablename('ewei_shop_order').' where headsid = :headsid and status >=1 and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($order)){
                    $ordercount += $order['ordercount'];
                    $ordermoney += $order['ordermoney'];
                }
            }

            //已完成订单
            if (in_array('ordercount3', $options)) {
                $order3 = pdo_fetch('select sum(price) as ordermoney,count(distinct id) as ordercount from '.tablename('ewei_shop_order').' where headsid = :headsid and status >=3 and uniacid = :uniacid',array(':headsid'=>$member['id'],':uniacid'=>$_W['uniacid']));
                if(!empty($order3)){
                    $ordercount3 += $order3['ordercount'];
                    $ordermoney3 += $order3['ordermoney'];
                }
            }


            //团员数
            $member['groupscount'] = $groupscount;

            //订单数据
            $member['ordercount0'] = $ordercount0;
            $member['ordermoney0'] = $ordermoney0;

            $member['ordercount'] = $ordercount;
            $member['ordermoney'] = $ordermoney;

            $member['ordercount3'] = $ordercount3;
            $member['ordermoney3'] = $ordermoney3;

            //分红数据
            $member['dividend_total'] = $dividend_total;
            $member['dividend_apply'] = $dividend_apply;
            $member['dividend_check'] = $dividend_check;
            $member['dividend_pay'] = $dividend_pay;
            $member['dividend_ok'] = $dividend_ok;
            $member['dividend_lock'] = $dividend_lock;
            $member['dividend_wait'] = $dividend_wait;
            $member['dividend_fail'] = $dividend_fail;
//            $member['dividend_withdraw'] = $dividend_withdraw;

            $this->getInfo = $member;
            return $this->getInfo;
        }


        public function getHeadsDownNum($openid=NULL)
        {
            global $_W;
            $openid = isset($openid) ? $openid : $_W['openid'];

            $set = $this->getSet();
            $member = $this->getInfo($openid);
            $itemscount = 0;
            $count = (int)pdo_fetchcolumn('select count(id) from '.tablename('ewei_shop_member').' where headsid=:agentid and headsstatus = 0 and  and uniacid=:uniacid limit 1'
                ,array(":headsid"=>$member['id'],':uniacid'=>$_W['uniacid']));

            return array(
                'itemscount' => $itemscount,
            );
        }

        /**
         * 是否是队长
         * @param type $openid
         * @return type
         */
        public function isheads($openid)
        {
            if (empty($openid)) {
                return false;
            }
            if (is_array($openid)) {
                return $openid['isheads'] == 1 && $openid['headsstatus'] == 1;
            }

            $member = m('member')->getMember($openid);
            return $member['isheads'] == 1 && $member['headsstatus'] == 1;
        }

        /**
         *  下单处理团队分红
         * @param $order String 订单ID
         */
        public function checkOrderConfirm($orderid = '0')
        {
            global $_W, $_GPC;

            if (empty($orderid)) {
                return;
            }

            $set = $this->getSet();
            if(empty($set['open'])){
                return;
            }

            $order = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime,officcode,dispatchprice,deductcredit2,price,deductcredit2 from ' . tablename('ewei_shop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
            if (empty($order)) {
                return;
            }
            $openid = $order['openid'];

            $member = m('member')->getMember($openid);

            if (empty($member)) {
                return;
            }

            //不是团员
            if(empty($member['headsid'])){
                return;
            }

            //队长订单不参与分红
            if(!empty($member['isheads']) && !empty($member['headsstatus'])){
                return;
            }
            $divedend['dividend_price'] = floatval(($order['price']+$order['deductcredit2'] - $order['dispatchprice']) * $set['ratio'] / 100);
            $divedend['dividend_price'] = round($divedend['dividend_price'],2);
            $divedend['dividend_ratio'] = $set['ratio'];

            pdo_update('ewei_shop_order', array(
                'headsid' => $member['headsid'],
                'dividend' => iserializer($divedend),
            ), array('id' => $orderid));

            return true;
        }

        //代理订单付款
        public function checkOrderPay($orderid = '0')
        {
            global $_W, $_GPC;

            if (empty($orderid)) {
                return;
            }

            $set = $this->getSet();
            if (empty($set['level'])) {
                return;
            }
            $order = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('ewei_shop_order') . ' where id=:id and status>=1 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
            if (empty($order)) {
                return;
            }
            $openid = $order['openid'];

            $member = m('member')->getMember($openid);
            if (empty($member)) {
                return;
            }

            $become_check = intval($set['become_check']); //是否需要审核
            $become_child = intval($set['become_child']);
            $parent = false;
            if (empty($become_child)) {
                //如果是分享连接成为下线
                $parent = m('member')->getMember($member['agentid']);
            } else {
                //如果是下单或付款成为下线，则上线为最后一个邀请人
                $parent = m('member')->getMember($member['inviter']);
            }
            $parent_is_agent = !empty($parent) && $parent['isagent'] == 1 && $parent['status'] == 1;

            $time = time();
            //成为下线条件
            $become_child = intval($set['become_child']);
            if ($parent_is_agent) {
                if ($become_child == 2) {
                    //首次付款
                    if (empty($member['agentid']) && $member['id'] != $parent['id']) {
                        if (empty($member['fixagentid'])) { //不固定上级
                            $member['agentid'] = $parent['id'];
                            $authorid = empty($parent['isauthor']) ? $parent['authorid'] : $parent['id'];
                            $author = p('author');
                            if ($author) {
                                $author->upgradeLevelByAgent($parent['id']);
                                pdo_update('ewei_shop_member', array('agentid' => $parent['id'], 'childtime' => $time,'authorid'=>$authorid), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                            }else{
                                pdo_update('ewei_shop_member', array('agentid' => $parent['id'], 'childtime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                            }

                            if ($author){
                                $author_set = $author->getSet();
                                if(!empty($author_set['become']) && ($author_set['become']=='2' || $author_set['become']=='5')){
                                    $can_author = false;
                                    $getAgentsDownNum = $this->getAgentsDownNum($parent['openid']);
                                    if ($author_set['become']=='2'){
                                        if ($getAgentsDownNum['level1'] >= $author_set['become_down1']){
                                            $can_author = true;
                                        }elseif ($getAgentsDownNum['level2'] >= $author_set['become_down2']){
                                            $can_author = true;
                                        }elseif ($getAgentsDownNum['level3'] >= $author_set['become_down3']){
                                            $can_author = true;
                                        }
                                    }elseif($author_set['become']=='5'){
                                        if ($getAgentsDownNum['total'] >= $author_set['become_downcount']){
                                            $can_author = true;
                                        }
                                    }elseif($author_set['become']=='5'){
                                        $temp_parent = $parent['id'];
                                        do{
                                            $res = $author->becomeType6($temp_parent);
                                            $temp_parent = $res['agentid'];
                                        }while($res['agentid'] != 0);
                                    }

                                    if($can_author){
                                        $become_check = intval($author_set['become_check']);
                                        if (empty($member['authorblack'])) { //不是黑名单
                                            pdo_update('ewei_shop_member', array('authorstatus' => $become_check, 'isauthor' => 1, 'authortime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $parent['id']));

                                            //发送成为创始人
                                            if ($become_check == 1) {
                                                $this->sendMessage($parent['openid'], array('nickname' => $parent['nickname'], 'authortime' => $time), TM_AUTHOR_BECOME);
                                            }
                                        }
                                    }
                                }
                            }

                            //消息通知
                            $this->sendMessage($parent['openid'], array('nickname' => $member['nickname'], 'childtime' => $time), TM_COMMISSION_AGENT_NEW);

                            //升级
                            $this->upgradeLevelByAgent($parent['id']);

                            //股东升级
                            if (p('globonus')) {
                                p('globonus')->upgradeLevelByAgent($parent['id']);
                            }
                            //区域代理升级
                            if (p('abonus')) {
                                p('abonus')->upgradeLevelByAgent($parent['id']);
                            }
                            //创始人升级
                            if (p('author')) {
                                p('author')->upgradeLevelByAgent($parent['id']);
                            }

                            if (empty($order['agentid'])) {
                                $order['agentid'] = $parent['id'];
                                pdo_update('ewei_shop_order', array('agentid' => $parent['id']), array('id' => $orderid));

                                //成为下线，重新计佣金
                                $order_agent_id = !empty($parent['id']) ?  $parent['id'] : null;
                                $this->calculate($orderid,true,$order_agent_id);
                            }
                        }
                    }
                }
            }

            $isagent = $member['isagent'] == 1 && $member['status'] == 1;
            if (!$isagent) {
                if (intval($set['become']) == 4 && !empty($set['become_goodsid'])) {
                    if (empty($set['become_order'])) {
                        //付款购买商品成为分销商
                        $order_goods = pdo_fetchall('select goodsid from ' . tablename('ewei_shop_order_goods') . ' where orderid=:orderid and uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']), "goodsid");
                        if (in_array($set['become_goodsid'], array_keys($order_goods))) {
                            //包含此商品
                            if (empty($member['agentblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('status' => $become_check, 'isagent' => 1, 'agenttime' => $become_check == 1 ? $time : 0), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                                if ($become_check == 1) {
                                    //发送成为分销商
                                    $this->sendMessage($openid, array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
                                    if (!empty($parent)) {

                                        //升级
                                        $this->upgradeLevelByAgent($parent['id']);

                                        //股东升级
                                        if (p('globonus')) {
                                            p('globonus')->upgradeLevelByAgent($parent['id']);
                                        }
                                        //区域代理升级
                                        if (p('abonus')) {
                                            p('abonus')->upgradeLevelByAgent($parent['id']);
                                        }
                                        //创始人升级
                                        if (p('author')) {
                                            p('author')->upgradeLevelByAgent($parent['id']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else if ($set['become'] == 2 || $set['become'] == 3) {
                    if (empty($set['become_order'])) {
                        //付款后
                        //如果不是, 则根据分销条件检测检测 统计付款订单
                        $time = time();
                        $parentisagent = true;
                        if (!empty($member['agentid'])) {
                            $parent = m('member')->getMember($member['agentid']);
                            if (empty($parent) || $parent['isagent'] != 1 || $parent['status'] != 1) {
                                $parentisagent = false;
                            }
                        }
                        $can = false;
                        if ($set['become'] == '2') {
                            $ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $ordercount >= intval($set['become_ordercount']);
                        } else if ($set['become'] == '3') {
                            //消费金额
                            $moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('ewei_shop_order_goods')
                                . ' og left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $moneycount >= floatval($set['become_moneycount']);
                        }
                        if ($can) {
                            if (empty($member['agentblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('status' => $become_check, 'isagent' => 1, 'agenttime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));

                                //发送成为分销商
                                if ($become_check == 1) {
                                    $this->sendMessage($openid, array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);

                                    if ($parentisagent) {
                                        //升级
                                        $this->upgradeLevelByAgent($parent['id']);

                                        //股东升级
                                        if (p('globonus')) {
                                            p('globonus')->upgradeLevelByAgent($parent['id']);
                                        }
                                        //区域代理升级
                                        if (p('abonus')) {
                                            p('abonus')->upgradeLevelByAgent($parent['id']);
                                        }
                                        //创始人升级
                                        if (p('author')) {
                                            p('author')->upgradeLevelByAgent($parent['id']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //发送下级付款消息
            if (!empty($member['agentid'])) {

                $parent = m('member')->getMember($member['agentid']);
                if (!empty($parent) && $parent['isagent'] == 1 && $parent['status'] == 1) {

                    $order_goods = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1,og.commissions  from ' . tablename('ewei_shop_order_goods') . ' og '
                        . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid '
                        . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));
                    $goods = '';
                    $commission_total1 = 0;
                    $commission_total2 = 0;
                    $commission_total3 = 0;
                    $pricetotal = 0;
                    foreach ($order_goods as $og) {
                        $goods .= "" . $og['title'] . '( ';
                        if (!empty($og['optiontitle'])) {
                            $goods .= " 规格: " . $og['optiontitle'];
                        }
                        $goods .= ' 单价: ' . ($og['realprice'] / $og['total']) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . "); ";

                        $commissions = iunserializer($og['commissions']);
                        $commission_total1 += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
                        $commission_total2 += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
                        $commission_total3 += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
                        $pricetotal += $og['realprice'];
                    }

                    if ($order['agentid'] == $member['id']) {
                        $this->sendMessage($member['openid'], array(
                            'nickname' => $member['nickname'],
                            'ordersn' => $order['ordersn'],
                            'orderopenid' => $order['openid'],
                            'price' => $pricetotal,
                            'goods' => $goods,
                            'commission1' => $commission_total1,
                            'commission2' => $commission_total2,
                            'commission3' => $commission_total3,
                            'paytime' => $order['paytime'],
                        ), TM_COMMISSION_ORDER_PAY
                        );
                    } elseif ($order['agentid'] == $parent['id']) {
                        $this->sendMessage($parent['openid'], array(
                            'nickname' => $member['nickname'],
                            'ordersn' => $order['ordersn'],
                            'orderopenid' => $order['openid'],
                            'price' => $pricetotal,
                            'goods' => $goods,
                            'commission1' => $commission_total1,
                            'commission2' => $commission_total2,
                            'commission3' => $commission_total3,
                            'paytime' => $order['paytime'],
                        ), TM_COMMISSION_ORDER_PAY
                        );
                    }

                    //创始人发下线付款
                    if (p('author') && !empty($member['authorid'])) {
                        $author = m('member')->getMember($member['authorid']);
                        if (!empty($author['isauthor']) && $author['authorstatus']){
                            p('author')->sendMessage($author['openid'],array(
                                'nickname' => $member['nickname'],
                                'ordersn' => $order['ordersn'],
                                'price' => $pricetotal,
                                'goods' => $goods,
                                'paytime' => $order['paytime']
                            ),TM_AUTHOR_DOWN_PAY);
                        }
                    }
                }
            }



            if ($isagent) {


                //购物成功股东
                $plugin_globonus = p('globonus');
                if(!$plugin_globonus){
                    return;
                }

                $set = $plugin_globonus->getSet();
                if (empty($set['open'])) {
                    return;
                }

                if ($member['ispartner']) {
                    return;
                }
                if(strpos($member['openid'],'sns_wa_')===true){
                    return;
                }
                //股东是否需要审核
                $become_check = intval($set['become_check']);
                if (intval($set['become']) == 4 && !empty($set['become_goodsid'])) {
                    if (empty($set['become_order'])) {
                        //付款购买商品成为股东
                        $order_goods = pdo_fetchall('select goodsid from ' . tablename('ewei_shop_order_goods') . ' where orderid=:orderid and uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']), "goodsid");
                        if (in_array($set['become_goodsid'], array_keys($order_goods))) {
                            //包含此商品
                            if (empty($member['partnerblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('partnerstatus' => $become_check, 'ispartner' => 1, 'partnertime' => $become_check == 1 ? $time : 0), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                                if ($become_check == 1) {
                                    //发送成为股东
                                    $plugin_globonus->sendMessage($openid, array('nickname' => $member['nickname'], 'partnertime' => $time), TM_GLOBONUS_BECOME);
                                }
                            }
                        }
                    }
                } else if ($set['become'] == 2 || $set['become'] == 3) {
                    if (empty($set['become_order'])) {
                        //付款后
                        //如果不是, 则根据分销条件检测检测 统计付款订单
                        $time = time();
                        $can = false;
                        if ($set['become'] == '2') {
                            $ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $ordercount >= intval($set['become_ordercount']);
                        } else if ($set['become'] == '3') {
                            //消费金额
                            $moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('ewei_shop_order_goods')
                                . ' og left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $moneycount >= floatval($set['become_moneycount']);
                        }
                        if ($can) {
                            if (empty($member['partnerblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('partnerstatus' => $become_check, 'ispartner' => 1, 'partnertime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));

                                //发送成为股东
                                if ($become_check == 1) {
                                    $plugin_globonus->sendMessage($openid, array('nickname' => $member['nickname'], 'partnertime' => $time), TM_GLOBONUS_BECOME);
                                }
                            }
                        }
                    }
                }
            }
        }

        //代理收货
        public function checkOrderFinish($orderid = '')
        {


            global $_W, $_GPC;

            if (empty($orderid)) {
                return;
            }

            $order = pdo_fetch('select id,openid, ordersn,goodsprice,agentid,finishtime from ' . tablename('ewei_shop_order') . ' where id=:id and status>=3 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
            if (empty($order)) {
                return;
            }

            $set = $this->getSet();
            if (empty($set['level'])) {
                return;
            }

            $openid = $order['openid'];
            $member = m('member')->getMember($openid);
            if (empty($member)) {
                return;
            }
            $this->orderFinishTask($order,$set['selfbuy'] ? true : false, $member);//任务中心
            $time = time();
            $become_check = intval($set['become_check']); //是否需要审核
            $isagent = $member['isagent'] == 1 && $member['status'] == 1;

            $parentisagent = true;
            if (!empty($member['agentid'])) {
                $parent = m('member')->getMember($member['agentid']);
                if (empty($parent) || $parent['isagent'] != 1 || $parent['status'] != 1) {
                    $parentisagent = false;
                }
            }

            if (!$isagent && $set['become_order'] == '1') {

                //如果不是, 则根据分销条件检测检测 统计完成订单
                if ($set['become'] == '4' && !empty($set['become_goodsid'])) {
                    //付款购买商品成为分销商
                    $order_goods = pdo_fetchall('select goodsid from ' . tablename('ewei_shop_order_goods') . ' where orderid=:orderid and uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']), "goodsid");
                    if (in_array($set['become_goodsid'], array_keys($order_goods))) {
                        //包含此商品
                        if (empty($member['agentblack'])) { //不是黑名单
                            pdo_update('ewei_shop_member', array('status' => $become_check, 'isagent' => 1, 'agenttime' => $become_check == 1 ? $time : 0), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                            if ($become_check == 1) {
                                //发送成为分销商
                                $this->sendMessage($openid, array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
                                if ($parentisagent) {

                                    //升级
                                    $this->upgradeLevelByAgent($parent['id']);

                                    //股东升级
                                    if (p('globonus')) {
                                        p('globonus')->upgradeLevelByAgent($parent['id']);
                                    }
                                    //区域代理升级
                                    if (p('abonus')) {
                                        p('abonus')->upgradeLevelByAgent($parent['id']);
                                    }
                                    //创始人升级
                                    if (p('author')) {
                                        p('author')->upgradeLevelByAgent($parent['id']);
                                    }
                                }
                            }
                        }
                    }
                } else if ($set['become'] == 2 || $set['become'] == 3) {
                    $can = false;
                    if ($set['become'] == '2') {
                        $ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                        $can = $ordercount >= intval($set['become_ordercount']);
                    } else if ($set['become'] == '3') {
                        //消费金额
                        $moneycount = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                        $can = $moneycount >= floatval($set['become_moneycount']);
                    }
                    if ($can) {
                        if (empty($member['agentblack'])) { //不是黑名单
                            pdo_update('ewei_shop_member', array('status' => $become_check, 'isagent' => 1, 'agenttime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));

                            //发送成为分销商
                            if ($become_check == 1) {
                                $this->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
                            }
                        }
                    }
                }
            }


            //发送下级收货消息
            if (!empty($member['agentid'])) {

                $parent = m('member')->getMember($member['agentid']);
                if (!empty($parent) && $parent['isagent'] == 1 && $parent['status'] == 1) {

                    $order_goods = pdo_fetchall('select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1,og.commissions from ' . tablename('ewei_shop_order_goods') . ' og '
                        . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid '
                        . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']));
                    $goods = '';
                    $commission_total1 = 0;
                    $commission_total2 = 0;
                    $commission_total3 = 0;
                    $pricetotal = 0;
                    foreach ($order_goods as $og) {
                        $goods .= "" . $og['title'] . '( ';
                        if (!empty($og['optiontitle'])) {
                            $goods .= " 规格: " . $og['optiontitle'];
                        }
                        $goods .= ' 单价: ' . ($og['realprice'] / $og['total']) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['realprice'] . "); ";
                        $commissions = iunserializer($og['commissions']);
                        $commission_total1 += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
                        $commission_total2 += isset($commissions['level2']) ? floatval($commissions['level2']) : 0;
                        $commission_total3 += isset($commissions['level3']) ? floatval($commissions['level3']) : 0;
                        $pricetotal += $og['realprice'];
                    }

                    if ($order['agentid'] == $member['id']) {
                        $this->sendMessage($member['openid'], array(
                            'nickname' => $member['nickname'],
                            'ordersn' => $order['ordersn'],
                            'orderopenid' => $order['openid'],
                            'price' => $pricetotal,
                            'goods' => $goods,
                            'commission1' => $commission_total1,
                            'commission2' => $commission_total2,
                            'commission3' => $commission_total3,
                            'finishtime' => $order['finishtime'],
                        ), TM_COMMISSION_ORDER_FINISH
                        );
                    } elseif ($order['agentid'] == $parent['id']) {
                        $this->sendMessage($parent['openid'], array(
                            'nickname' => $member['nickname'],
                            'ordersn' => $order['ordersn'],
                            'orderopenid' => $order['openid'],
                            'price' => $pricetotal,
                            'goods' => $goods,
                            'commission1' => $commission_total1,
                            'commission2' => $commission_total2,
                            'commission3' => $commission_total3,
                            'finishtime' => $order['finishtime'],
                        ), TM_COMMISSION_ORDER_FINISH
                        );
                    }
                }
            }


            $this->upgradeLevelByOrder($openid);


            if ($isagent) {

                //购物成功创始人
                $plugin_author = p('author');
                if($plugin_author){
                    $set = $plugin_author->getSet();
                    if (!empty($set['open'])) {
                        $isauthor = $member['isauthor'] && $member['authorstatus'];
                        if ($isauthor) {
                            //创始人升级检测
                            $plugin_author->upgradeLevelByOrder($openid);
                        }else{
                            //创始人是否需要审核
                            $become_check = intval($set['become_check']);
                            if ($set['become_order'] == '1') {

                                $info = $this->getInfo($member['id'], array('ordercount3', 'ordermoney3', 'order13money', 'order13'));
                                $can = false;
                                if ($set['become'] == '3') {
                                    $can = floatval($info['ordermoney3']) >= floatval($set['become_moneycount']);
                                } else if ($set['become'] == '4') {
                                    //消费金额
                                    $moneycount = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                                    $can = floatval($moneycount) >= floatval($set['become_selfmoneycount']);
                                }
                                if ($can) {
                                    if (empty($member['authorblack'])) { //不是黑名单
                                        pdo_update('ewei_shop_member', array('authorstatus' => $become_check, 'isauthor' => 1, 'authortime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));

                                        //发送成为创始人
                                        if ($become_check == 1) {
                                            $plugin_author->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'authortime' => $time), TM_AUTHOR_BECOME);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


                //购物成功股东
                $plugin_globonus = p('globonus');
                if(!$plugin_globonus){
                    return;
                }

                $set = $plugin_globonus->getSet();
                if (empty($set['open'])) {
                    return;
                }

                $ispartner = $member['ispartner'] && $member['partnerstatus'];
                if ($ispartner) {
                    //股东升级检测
                    $plugin_globonus->upgradeLevelByOrder($openid);
                    return;
                }
                //股东是否需要审核
                $become_check = intval($set['become_check']);
                if ($set['become_order'] == '1') {

                    //如果不是, 则根据分销条件检测检测 统计完成订单
                    if ($set['become'] == '4' && !empty($set['become_goodsid'])) {
                        //付款购买商品成为分销商
                        $order_goods = pdo_fetchall('select goodsid from ' . tablename('ewei_shop_order_goods') . ' where orderid=:orderid and uniacid=:uniacid  ', array(':uniacid' => $_W['uniacid'], ':orderid' => $order['id']), "goodsid");
                        if (in_array($set['become_goodsid'], array_keys($order_goods))) {
                            //包含此商品
                            if (empty($member['partnerblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('partnerstatus' => $become_check, 'ispartner' => 1, 'partnertime' => $become_check == 1 ? $time : 0), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
                                if ($become_check == 1) {
                                    //发送成为分销商
                                    $plugin_globonus->sendMessage($openid, array('nickname' => $member['nickname'], 'partnertime' => $time), TM_GLOBONUS_BECOME);
                                }
                            }
                        }
                    } else if ($set['become'] == 2 || $set['become'] == 3) {
                        $can = false;
                        if ($set['become'] == '2') {
                            $ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $ordercount >= intval($set['become_ordercount']);
                        } else if ($set['become'] == '3') {
                            //消费金额
                            $moneycount = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('ewei_shop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                            $can = $moneycount >= floatval($set['become_moneycount']);
                        }
                        if ($can) {
                            if (empty($member['partnerblack'])) { //不是黑名单
                                pdo_update('ewei_shop_member', array('partnerstatus' => $become_check, 'ispartner' => 1, 'partnertime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));

                                //发送成为股东
                                if ($become_check == 1) {
                                    $plugin_globonus->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'partnertime' => $time), TM_GLOBONUS_BECOME);
                                }
                            }
                        }
                    }
                }
            }
        }

        // 订单完成后的分销任务
        function orderFinishTask($order, $self_buy = false, $member){
            global $_W;
            /*** 1. 获取一些订单和会员信息 ***/
            if (!p('task'))return;
            if (empty($order['agentid']))return;
            $order_id = $order['id'];
            $level_price_1 = $level_price_2 = $level_price_3 = 0;
            // 查询参与了分销的订单商品
            $order_goods_list = pdo_fetchall('SELECT commissions FROM '
                . tablename('ewei_shop_order_goods') . ' WHERE orderid = :order_id AND uniacid = :uniacid AND nocommission = 0'
                ,array(':order_id'=>$order_id,':uniacid'=>$_W['uniacid']));

            if (empty($order_goods_list))return;
            foreach ((array)$order_goods_list as $one_order_goods) {
                $commissions = unserialize( (string)$one_order_goods['commissions'] );
                if (!empty($commissions)){//有分销信息
                    $level_price_1 += round((float)$commissions['level1'], 2);
                    $level_price_2 += round((float)$commissions['level2'], 2);
                    $level_price_3 += round((float)$commissions['level3'], 2);
                }
            }
            $openid1 = $openid2 = $openid3 = '';
            // 一级佣金
            if ($level_price_1 > 0){
                if ($self_buy){
                    $openid1 = $member['openid'];
                } else {
                    $member = m('member')->getMember($member['agentid']);
                    $openid1 = $member['openid'];
                }
                p('task')->checkTaskReward('commission_money', $level_price_1, $openid1);
                p('task')->checkTaskProgress((int)$level_price_1, 'pyramid_money', 0, $openid1);

                // 二级佣金
                if ($level_price_2 > 0){
                    $member = m('member')->getMember($member['agentid']);
                    if (empty($member))return;
                    $openid2 = $member['openid'];
                    p('task')->checkTaskReward('commission_money', $level_price_2, $openid2);
                    p('task')->checkTaskProgress((int)$level_price_2, 'pyramid_money', 0, $openid2);

                    // 三级佣金
                    if ($level_price_3 > 0){
                        $member = m('member')->getMember($member['agentid']);
                        if (empty($member))return;
                        $openid3 = $member['openid'];
                        p('task')->checkTaskReward('commission_money', $level_price_3, $openid3);
                        p('task')->checkTaskProgress((int)$level_price_3, 'pyramid_money', 0, $openid3);
                    }
                }
            }
        }

        /**
         * 消息通知
         * @param type $message_type
         * @param type $openid
         * @return type
         */
        function sendMessage($openid = '', $data = array(), $message_type = '')
        {
            global $_W, $_GPC;
            $set = $this->getSet();
            $tm = $set['tm'];
            $templateid = $tm['templateid'];
            $time = date('Y-m-d H:i:s',time());
            $member = m('member')->getMember($openid);
            $usernotice = unserialize($member['noticeset']);
            if (!is_array($usernotice)) {
                $usernotice = array();
            }
            if ($message_type == TM_DIVIDEND_ORDER_FINISH && empty($usernotice['dividend_order_finish'])) {
                if($tm['is_advanced']){
                    if($tm['dividend_order_finish_close_advanced']){
                        return false;
                    }

                    //下线收货
                    $data['isagent'] = 0;
                    if ($data['orderopenid'] == $openid){
                        $agent = $this->getAgentsByMember($openid,1);
                        $openid = $agent[0]['openid'];
                        $data['isagent'] = 1;
                    }

                    $tag = 'dividend_order_finish';
                    $text = "您的下级".$data['nickname']."已确认收货！\n".date('Y-m-d H:i')."\n";
                    $message = array(
                        'first' => array('value' => "亲爱的".$member['nickname']."，您的下级".$data['nickname'].'已确认收货', "color" => "#ff0000"),
                        'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                        'keyword2' => array('title' => '处理进度', 'value' => '下级收货通知', "color" => "#000000"),
                        'keyword3' => array('title' => '处理内容', 'value' => '您的下级'.$data['nickname'].'已经确认收货', "color" => "#000000"),
                        'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                    );
                    $toopenid = $openid;
                    $datas[] = array('name'=>'昵称','value'=>$member['nickname']);
                    $datas[] = array('name'=>'下级昵称','value'=>$data['nickname']);
                    $datas[] = array('name'=>'时间','value'=>date('Y-m-d H:i:s', $data['finishtime']));
                    $datas[] = array('name'=>'订单编号','value'=>$data['ordersn']);
                    $datas[] = array('name'=>'订单金额','value'=>$data['price']);
                    $datas[] = array('name'=>'商品详情','value'=>$data['goods']);
                }else{
                    $data['isagent'] = 0;
                    if ($data['orderopenid'] == $openid){
                        $agent = $this->getAgentsByMember($openid,1);
                        $openid = $agent[0]['openid'];
                        $data['isagent'] = 1;
                    }
                    $message = $tm['dividend_order_finish'];
                    $message = str_replace('[昵称]', $member['nickname'], $message);
                    $message = str_replace('[下级昵称]', $data['nickname'], $message);
                    $message = str_replace('[时间]', date('Y-m-d H:i:s', $data['finishtime']), $message);
                    $message = str_replace('[订单编号]', $data['ordersn'], $message);
                    $message = str_replace('[订单金额]', $data['price'], $message);
                    $message = str_replace('[商品详情]', $data['goods'], $message);
                    $msg = array(
                        'keyword1' => array('value' => '会员通知', "color" => "#73a68d"),
                        'keyword2' => array('value' => !empty($tm['dividend_order_finishtitle']) ? $tm['dividend_order_finishtitle'] : '下线确认收货通知', "color" => "#73a68d"),
                        'keyword3' => array('value' => $message, "color" => "#73a68d")
                    );
                    return $this->sendNotice($openid, $tm, 'dividend_order_finish_advanced', $data, $member, $msg);
                }



            } else if ($message_type == TM_DIVIDEND_APPLY && empty($usernotice['dividend_apply'])) {
                if($tm['dividend_apply_close_advanced']){
                    return false;
                }
                //提现申请提交
                $tag = 'dividend_apply';

                $text = "您的".$set['texts']['dividend']."提现申请已提交！\n".date('Y-m-d H:i')."\n";
                $message = array(
                    'first' => array('value' => "亲爱的".$member['nickname']."，您的".$set['texts']['dividend'].'提现申请已提交', "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => '您的佣金提现申请已提交', "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '提现申请提交通知', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                );
                $toopenid = $openid;
                $datas[] = array('name'=>'昵称','value'=>$member['nickname']);
                $datas[] = array('name'=>'时间','value'=>$time);
                $datas[] = array('name'=>'金额','value'=>$data['dividend']);
                $datas[] = array('name'=>'提现方式','value'=>$data['type']);
            } else if ($message_type == TM_DIVIDEND_CHECK && empty($usernotice['dividend_check'])) {
                if($tm['dividend_check_close_advanced']){
                    return false;
                }
                //提现申请审核
                $tag = 'dividend_check';
                $text = "您的".$set['texts']['dividend']."提现申请已审核通过！\n".date('Y-m-d H:i')."\n";
                $message = array(
                    'first' => array('value' => "亲爱的".$member['nickname']."，您的".$set['texts']['dividend'].'提现申请已审核通过', "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => '您的佣金提现申请审核完成', "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '提现申请审核通知', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                );
                $toopenid = $openid;
                $datas[] = array('name'=>'昵称','value'=>$member['nickname']);
                $datas[] = array('name'=>'时间','value'=>$time);
                $datas[] = array('name'=>'金额','value'=>$data['dividend']);
                $datas[] = array('name'=>'提现方式','value'=>$data['type']);
            } else if ($message_type == TM_DIVIDEND_PAY && empty($usernotice['dividend_pay'])) {
                if($tm['is_advanced']){
                    if($tm['dividend_pay_close_advanced']){
                        return false;
                    }
                    //打款
                    $tag = 'dividend_pay';
                    $text = "您的".$set['texts']['dividend1']."打款成功！\n".date('Y-m-d H:i')."\n";
                    $message = array(
                        'first' => array('value' => "亲爱的".$member['nickname']."，您的".$set['texts']['dividend1'].'打款成功', "color" => "#ff0000"),
                        'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                        'keyword2' => array('title' => '处理进度', 'value' => $set['texts']['dividend1'].'打款通知', "color" => "#000000"),
                        'keyword3' => array('title' => '处理内容', 'value' => '您的佣金提现已打款成功', "color" => "#000000"),
                        'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                    );
                    $toopenid = $openid;
                    $datas[] = array('name'=>'昵称','value'=>$member['nickname']);
                    $datas[] = array('name'=>'时间','value'=>$time);
                    $datas[] = array('name'=>'金额','value'=>$data['dividend']);
                    $datas[] = array('name'=>'提现方式','value'=>$data['type']);
                }else{
                    //打款
                    $message = $tm['dividend_pay'];
                    $message = str_replace('[昵称]', $member['nickname'], $message);
                    $message = str_replace('[时间]', date('Y-m-d H:i:s', time()), $message);
                    $message = str_replace('[金额]', $data['dividend'], $message);
                    $message = str_replace('[提现方式]', $data['type'], $message);
                    $msg = array(
                        'keyword1' => array('value' => '会员通知', "color" => "#73a68d"),
                        'keyword2' => array('value' => !empty($tm['dividend_paytitle']) ? $tm['dividend_paytitle'] : '佣金打款通知', "color" => "#73a68d"),
                        'keyword3' => array('value' => $message, "color" => "#73a68d")
                    );
                    return $this->sendNotice($openid, $tm, 'dividend_pay_advanced', $data, $member, $msg);
                }

            } else if ($message_type == TM_DIVIDEND_BECOME && empty($usernotice['dividend_become'])) {
                if($tm['dividend_become_close_advanced']){
                    return false;
                }
                $tag = 'dividend_become';
                $text = "恭喜您".$set['texts']['become']."！\n".date('Y-m-d H:i')."\n";
                $message = array(
                    'first' => array('value' => "亲爱的".$member['nickname']."，恭喜您".$set['texts']['become'], "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => '成为分销商通知', "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '成为'.$set['texts']['agent'].'通知', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                );
                $toopenid = $openid;
                $datas[] = array('name' => '昵称','value'=>$data['nickname']);
                $datas[] = array('name' => '时间','value'=>date('Y-m-d H:i:s', $data['headstime']));
            }else if ($message_type == TM_DIVIDEND_BECOME_SALER && empty($usernotice['dividend_become_saler'])) {

                if($tm['dividend_become_saler_close_advanced']){
                    return false;
                }
                $tag = 'dividend_become_saler';
                $text = "您的商城会员".$member['nickname'].$set['texts']['become']."！\n".date('Y-m-d H:i')."\n";
                $message = array(
                    'first' => array('value' => "您的商城会员".$member['nickname'].$set['texts']['become'], "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => '成为队长通知', "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '成为'.$set['texts']['agent'].'通知', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                );
                $datas[] = array('name' => '昵称','value'=>$data['nickname']);
                $datas[] = array('name' => '时间','value'=>date('Y-m-d H:i:s', $data['headstime']));
            } else if($message_type == TM_DIVIDEND_APPLYMONEY && empty($usernotice['dividend_applymoney'])) {
                if($tm['dividend_applymoney_close']) {
                    return false;
                }
                //提现申请提交
                $tag = 'dividend_applymoney';
                $text = "您有" . $set['texts']['dividend'] . "提现申请已提交！\n" . date('Y-m-d H:i:s') . "\n";
                $message = array(
                    'first' => array('value' => "亲爱的管理员您有一条新的" . $set['texts']['dividend'] . '提现申请', "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => "您的商城会员提交了一笔提现，\n金额:".$data['dividend']." \n 时间:".$time."\n 提现方式:".$data['type'], "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '已提交', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n请您注意审核团队分红的分红提现申请，及时处理哦", "color" => "#000000")
                );
                $toopenid = $tm['openid'];
                $datas[] = array('name' => '昵称', 'value' => $member['nickname']);
                $datas[] = array('name' => '时间', 'value' => $time);
                $datas[] = array('name' => '金额', 'value' => $data['dividend']);
                $datas[] = array('name' => '提现方式', 'value' => $data['type']);
            }else if($message_type == TM_DIVIDEND_DOWNLINE_BECOME && empty($usernotice['dividend_downline_become'])){
                if($tm['dividend_downline_become_close_advanced']) {
                    return false;
                }
                //下线成为队长

                if(empty($member['headsid'])){
                    return false;
                }

                $heads = pdo_fetch('select id,openid from '.tablename('ewei_shop_member').' where id=:id',array(':id'=>$member['headsid']));

                $tag = 'dividend_downline_become';
                $text = "您的团员" .$member['nickname']. "已成为队长！\n" . date('Y-m-d H:i:s') . "\n";
                $message = array(
                    'first' => array('value' => "您的团员" . $member['nickname'] . '已成为队长', "color" => "#ff0000"),
                    'keyword1' => array('title' => '业务类型', 'value' => '会员通知', "color" => "#000000"),
                    'keyword2' => array('title' => '业务内容', 'value' => "您的团员在".$time."成为队长，他的下线不在为您提供分红", "color" => "#000000"),
                    'keyword3' => array('title' => '处理结果', 'value' => '团员成为队长通知', "color" => "#000000"),
                    'keyword4' => array('title' => '操作时间', 'value' => date('Y-m-d H:i:s', time()), "color" => "#000000"),
                    'remark' => array('value' => "\n感谢您的支持", "color" => "#000000")
                );
                $toopenid = $heads['openid'];
                $datas[] = array('name' => '昵称', 'value' => $member['nickname']);
                $datas[] = array('name' => '时间', 'value' => $time);
            }

            if (!empty($tm['openid']) && ($message_type == TM_DIVIDEND_APPLYMONEY  || $message_type == TM_DIVIDEND_BECOME_SALER)) {
                $openids = explode(',', $tm['openid']);
                foreach ($openids as $tmopenid) {
                    if (empty($tmopenid)) {
                        continue;
                    }

                    m('notice')->sendNotice(array(
                        "openid" => $tmopenid,
                        'tag' => $tag,
                        'default' => $message,
                        'cusdefault' => $text,
                        'datas' => $datas,
                        'plugin' => 'dividend'
                    ));
                }
            }else{
                m('notice')->sendNotice(array(
                    "openid" => $toopenid,
                    'tag' => $tag,
                    'default' => $message,
                    'cusdefault' => $text,
                    'datas' => $datas,
                    'plugin' => 'dividend'
                ));
            }



        }

        public function getTotals()
        {
            global $_W;
            return array(
                "total1" => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_commission_apply') . ' where status=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'])),
                "total2" => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_commission_apply') . ' where status=2 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'])),
                "total3" => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_commission_apply') . ' where status=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'])),
                "total_1" => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_commission_apply') . ' where status=-1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']))
            );
        }

        protected function sendNotice($touser, $tm, $tag, $datas, $member, $msg)
        {
            global $_W;
            if (!empty($tm['is_advanced']) && !empty($tm[$tag])) {
                //高级模式
                $advanced_template = pdo_fetch('select * from ' . tablename('ewei_shop_member_message_template') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $tm[$tag], ':uniacid' => $_W['uniacid']));

                if (!empty($advanced_template)) {
                    $url = !empty($advanced_template['url']) ? $this->replaceTemplate($advanced_template['url'], $tag, $datas, $member) : '';
                    $advanced_message = array(
                        'first' => array('value' => $this->replaceTemplate($advanced_template['first'], $tag, $datas, $member), 'color' => $advanced_template['firstcolor']),
                        'remark' => array('value' => $this->replaceTemplate($advanced_template['remark'], $tag, $datas, $member), 'color' => $advanced_template['remarkcolor'])
                    );

                    $data = iunserializer($advanced_template['data']);
                    foreach ($data as $d) {
                        $advanced_message[$d['keywords']] = array('value' => $this->replaceTemplate($d['value'], $tag, $datas, $member), 'color' => $d['color']);
                    }
                    //高级模板消息
                    $tm['templateid'] = $advanced_template['template_id'];
                    $this->sendMoreAdvanced($touser, $tm, $tag, $advanced_message, $url, $datas);
                }
            } else {

                if (empty($msg['keyword2']['value'])) {
                    return true;
                }
////                $msg['keyword3']['value']=date('Y-m-d H:i:s',time());
//                $msg['keyword3']['color']="#000000";

                $tag = str_replace('_advanced', '', $tag);

                $this->sendMore($touser, $tm, $tag, $msg, $datas);
            }
            return true;
        }

        protected function sendMore($touser, $tm, $tag, $msg, $datas)
        {
            $res = $this->getAgentsByMember($touser, intval($tm[$tag . '_notice']));
            $set = $this->getSet();
            //如果没开启内购,走下面
//            if (!empty($set['selfbuy']) && ($tag == 'commission_order_finish' || $tag == 'commission_order_pay')) {
//                goto commission_order;
//
//            }
            $msgbk = $msg;
            $msgbk['keyword3']['value'] = str_replace('[下线层级]', $set['texts']['c1'], $msgbk['keyword3']['value']);
            $msgbk['keyword3']['value'] = str_replace('[下线]', $set['texts']['down'], $msgbk['keyword3']['value']);
            if ($tag == 'commission_order_finish' || $tag == 'commission_order_pay') {
                if ($datas['isagent']){
                    $msgbk['keyword3']['value'] = str_replace('[佣金金额]', $datas['commission2'], $msgbk['keyword3']['value']);
                }else{
                    $msgbk['keyword3']['value'] = str_replace('[佣金金额]', $datas['commission1'], $msgbk['keyword3']['value']);
                }
            }
            if (!empty($tm[$tag]) && !empty($tm['templateid'])) {
//
                m('message')->sendTplNotice($touser,$tm['templateid'], $msgbk);
            } else {
                m('message')->sendCustomNotice($touser, $msgbk);
            }
//            commission_order:
            foreach ($res as $key=>$value){
                $msgbk = $msg;
                if ($key == 0) {
                    $msgbk['keyword3']['value'] = str_replace('[下线层级]', $set['texts']['c2'], $msgbk['keyword3']['value']);
                    $msgbk['keyword3']['value'] = str_replace('[下线]', $set['texts']['c2'].$set['texts']['down'], $msgbk['keyword3']['value']);
                    if ($tag == 'commission_order_finish' || $tag == 'commission_order_pay') {
                        if ($datas['isagent']){
                            $msgbk['keyword3']['value'] = str_replace('[佣金金额]', $datas['commission3'], $msgbk['keyword3']['value']);
                        }else{
                            $msgbk['keyword3']['value'] = str_replace('[佣金金额]', $datas['commission2'], $msgbk['keyword3']['value']);
                        }
                    }
                }
                if ($key == 1) {
                    $msgbk['keyword3']['value'] = str_replace('[下线层级]', $set['texts']['c3'], $msgbk['keyword3']['value']);
                    $msgbk['keyword3']['value'] = str_replace('[下线]', $set['texts']['c3'].$set['texts']['down'], $msgbk['keyword3']['value']);
                    if ($tag == 'commission_order_finish' || $tag == 'commission_order_pay') {
                        if ($datas['isagent']){
                            $msgbk['keyword3']['value'] = str_replace('[佣金金额]', 0.00, $msgbk['keyword3']['value']);
                        }else{
                            $msgbk['keyword3']['value'] = str_replace('[佣金金额]', $datas['commission3'], $msgbk['keyword3']['value']);
                        }
                    }
                }
                if (!empty($tm[$tag]) && !empty($tm['templateid'])) {
                    m('message')->sendTplNotice($value['openid'], $tm['templateid'], $msgbk);
                } else {
                    m('message')->sendCustomNotice($value['openid'], $msgbk);
                }
            }
        }

        protected function sendMoreAdvanced($touser, $tm, $tag, $msg, $url, $datas)
        {
            $res = $this->getAgentsByMember($touser, intval($tm[$tag . '_notice']));
            $set = $this->getSet();
            //如果没开启内购,走下面
//            if (!empty($set['selfbuy']) && ($tag == 'commission_order_finish_advanced' || $tag == 'commission_order_pay_advanced')) {
//                goto commission;
//            }
            $msgbk = $msg;
            $msgbk = $this->replaceArray($msgbk, '['.$set['texts']['down'].']', $set['texts']['c1'].$set['texts']['down']);
            $msgbk = $this->replaceArray($msgbk, '[下线层级]', $set['texts']['c1']);
            if ($tag == 'commission_order_finish_advanced' || $tag == 'commission_order_pay_advanced') {
                $msgbk = $this->replaceArray($msgbk, '[佣金金额]', $datas['commission1']);
            }
            if (!empty($tm[$tag]) && !empty($tm['templateid'])) {
                m('message')->sendTplNotice($touser, $tm['templateid'], $msgbk, $url);
            } else {
                m('message')->sendCustomNotice($touser, $msgbk, $url);
            }
//            commission:
            foreach ($res as $key => $value) {
                if ($key == 0) {
                    $msgbk = $msg;
                    $msgbk = $this->replaceArray($msgbk, '['.$set['texts']['down'].']', $set['texts']['c2'].$set['texts']['down']);
                    $msgbk = $this->replaceArray($msgbk, '[下线层级]', $set['texts']['c2']);
                    if ($tag == 'commission_order_finish_advanced' || $tag == 'commission_order_pay_advanced') {
                        $msgbk = $this->replaceArray($msgbk, '[佣金金额]', $datas['commission2']);
                    }
                }
                if ($key == 1) {
                    $msgbk = $msg;
                    $msgbk = $this->replaceArray($msgbk, '['.$set['texts']['down'].']', $set['texts']['c3'].$set['texts']['down']);
                    $msgbk = $this->replaceArray($msgbk, '[下线层级]', $set['texts']['c3']);
                    if ($tag == 'commission_order_finish_advanced' || $tag == 'commission_order_pay_advanced') {
                        $msgbk = $this->replaceArray($msgbk, '[佣金金额]', $datas['commission3']);
                    }
                }
                if (!empty($tm[$tag]) && !empty($tm['templateid'])) {
                    m('message')->sendTplNotice($value['openid'], $tm['templateid'], $msgbk, $url);
                } else {
                    m('message')->sendCustomNotice($value['openid'], $msgbk, $url);
                }
            }
        }

        protected function replaceArray(array $array, $str, $replace_str)
        {
            foreach ($array as $key => &$value) {
                foreach ($value as $k => &$v) {
                    $v = str_replace($str, $replace_str, $v);
                }
                unset($v);
            }
            unset($value);
            return $array;
        }

        protected function replaceTemplate($str, $tag, $data, $member)
        {
            $arr = $this->templateValue($member, $data);
            switch ($tag) {
                case 'dividend_become_advanced':
                    $arr['[时间]'] = date('Y-m-d H:i:s', $data['agenttime']);
                    $arr['[下级昵称]'] = $data['nickname'];
                    $arr['[昵称]'] = $data['nickname'];
                    break;
                case 'dividend_agent_new_advanced':
                    $arr['[时间]'] = date('Y-m-d H:i:s', $data['childtime']);
                    $arr['[下级昵称]'] = $data['nickname'];
                    $arr['[昵称]'] = $data['nickname'];
                    break;
                case 'dividend_order_pay_advanced':
                    $arr['[时间]'] = date('Y-m-d H:i:s', $data['paytime']);
                    $arr['[下级昵称]'] = $data['nickname'];
                    $arr['[昵称]'] = $data['nickname'];
                    break;
                case 'dividend_order_finish_advanced':
                    $arr['[时间]'] = date('Y-m-d H:i:s', $data['finishtime']);
                    $arr['[下级昵称]'] = $data['nickname'];
                    $arr['[昵称]'] = $data['nickname'];
                    break;
            }
            foreach ($arr as $key => $value) {
                $str = str_replace($key, $value, $str);
            }
            return $str;
        }

        protected function templateValue($member, $data)
        {
            $set = $this->getSet();
            return array(
                '[昵称]' => $member['nickname'],
                '[时间]' => date('Y-m-d H:i:s', time()),
                '[金额]' => !empty($data['commission']) ? $data['commission'] : '',
                '[提现方式]' => !empty($data['type']) ? $data['type'] : '',
                '[订单编号]' => !empty($data['ordersn']) ? $data['ordersn'] : '',
                '[订单金额]' => !empty($data['price']) ? $data['price'] : '',
                '[商品详情]' => !empty($data['goods']) ? $data['goods'] : '',
            );
        }

        function getLastApply($mid, $type = -1)
        {
            global $_W;

            $params = array(':uniacid' => $_W['uniacid'],':mid'=>$mid);
            $sql = "select type,alipay,bankname,bankcard,realname from " . tablename('ewei_shop_commission_apply') . " where mid=:mid and uniacid=:uniacid";

            if ($type > -1) {
                $sql .= " and type=:type";
                $params[':type'] = $type;
            }
            $sql .= " order by id desc Limit 1";
            $data = pdo_fetch($sql, $params);

            return $data;
        }

        function getRepurchase($openid,array $time)
        {
            global $_W;
            if(empty($openid)||empty($time)){
                return null;
            }
            $set = $this->getSet();
            $agentLevel = $this->getLevel($openid);
            if ($agentLevel){
                $repurchase_price = (float)$agentLevel['repurchase'];
            }else{
                $repurchase_price = (float)$set['repurchase_default'];
            }
            $residue = 0;
            $month_array = array();
            foreach ($time as $value){
                $time1 = strtotime(date($value.'-1'));
                $time2 = strtotime('+1 months',$time1);
                if (!empty($repurchase_price)){
                    $order_price = (float)pdo_fetchcolumn("SELECT SUM(price) as price FROM ".tablename('ewei_shop_order')." WHERE `uniacid`=:uniacid AND `openid`=:openid AND `status`>2 AND `createtime` BETWEEN :time1 AND :time2",array(':uniacid' => $_W['uniacid'],':openid'=>$openid,':time1'=>$time1,':time2'=>$time2));

                    $year_month = explode('-',$value);
                    $year_month[0] = (int)$year_month[0];
                    $year_month[1] = (int)$year_month[1];
                    $residue_price = (float)pdo_fetchcolumn("SELECT SUM(repurchase) FROM ".tablename('ewei_shop_commission_repurchase')." WHERE `uniacid`=:uniacid AND `openid`=:openid AND `year`=:year AND `month`=:month",array(':uniacid' => $_W['uniacid'],':openid'=>$openid,':year'=>$year_month[0],':month'=>$year_month[1]));

                    $month_array[$value] = max($repurchase_price-($order_price+$residue_price),0);
                }
            }
            return $month_array;
        }

        /**
         * @param array $level 数组中有两个参数 一个是等级,一个是新等级
         * @param array $levels 分销商等级数组
         * @return bool 如果新等级大于 原等级 则返回true 否则 false
         */
        public function compareLevel(array $level,array $levels = array())
        {
            global $_W;
            $old_key = -1;
            $new_key = -1;
            $levels = !empty($levels) ? $levels : $this->getLevels();
            foreach ($levels as $kk=>$vv ){
                if ($vv['id'] == $level[0]){
                    $old_key = $kk;
                }
                if ($vv['id'] == $level[1]){
                    $new_key = $kk;
                }
            }

            return $new_key>$old_key;
        }


        public function getAgentLevel($member, $mid)
        {
            global $_W;

            $level1_agentids = $member['level1_agentids'];
            $level2_agentids = $member['level2_agentids'];
            $level3_agentids = $member['level3_agentids'];

            if (!empty($level1_agentids)) {
                if(array_key_exists($mid, $level1_agentids)){
                    return 1;
                }
            }

            if (!empty($level2_agentids)) {
                if(array_key_exists($mid, $level2_agentids)){
                    return 2;
                }
            }

            if (!empty($level3_agentids)) {
                if(array_key_exists($mid, $level3_agentids)){
                    return 3;
                }
            }
            return 0;
        }

        public function getAllDown($openid)
        {
            global $_W;
            if (empty($openid)){
                return false;
            }
            $uid= (int)$openid;
            if ($uid==0) {
                $info = pdo_fetch('select id,openid,uniacid,agentid,isagent,status from ' . tablename('ewei_shop_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
                if (empty($info)){
                    return false;
                }
                $uid = $info['id'];
            }
            $agents = pdo_fetchall('select id,openid,uniacid,agentid,isagent,nickname,agenttime,createtime,avatar,status,realname,mobile,weixin from ' . tablename('ewei_shop_member') . ' where uniacid=:uniacid and agentid=:agentid', array(':uniacid' => $_W['uniacid'], ':agentid' => $uid));
            $ids = array();
            $openids = array();
            $users = array();
            foreach ($agents as $val){
                $ids[] = $val['id'];
                $openids[] = $val['openid'];
                $users[$val['id']] = $val;
                if ($val['isagent'] && $val['status']){
                    $arr = $this->getAllDown($val['id']);
                    if ($arr){
                        $ids = array_merge($ids,$arr['ids']);
                        $openids = array_merge($openids,$arr['openids']);
                        $users = array_merge($users,$arr['users']);
                    }
                }
            }
            return array(
                'ids'=>$ids,
                'openids'=>$openids,
                'users'=>$users
            );
        }

        public function getAllDownOrder($openid,$start=0,$end=0)
        {
            global $_W;
            $down = $this->getAllDown($openid);
            if (!is_numeric($start)){
                $start = strtotime($start);
            }
            if (!is_numeric($end)){
                $end = strtotime($end);
            }
            if (!empty($down['openids']))
            {
                $order = pdo_fetchall("SELECT * FROM ".tablename('ewei_shop_order')." WHERE uniacid=:uniacid AND openid IN ('".implode("','",$down['openids'])."') AND createtime BETWEEN :time1 AND :time2 AND ccard>0",array(':uniacid'=>$_W['uniacid'],':time1'=>$start,':time2'=>$end));
                if ($order){
                    return array(
                        'openids' => $down['openids'],
                        'order' => $order
                    );
                }
            }
            return false;
        }


        //更新团队分红关系
        function update_headsid($memberid,$agentid){
            global $_W, $_GPC;
            //查询上级
            $agent = pdo_fetch('select id,isheads,headsid,headsstatus from ' . tablename('ewei_shop_member') . ' where id = :id', array(':id' => $agentid));
            //如果是队长 并且 已经审核通过
            if (!empty($agent['isheads']) && !empty($agent['headsstatus'])) {
                pdo_update('ewei_shop_member', array('headsid' => $agentid), array('id' => $memberid, 'uniacid' => $_W['uniacid']));
                //如果不是队长 并且 有归属队长
            } else if (empty($agent['isheads']) && !empty($agent['headsid'])) {
                pdo_update('ewei_shop_member', array('headsid' => $agent['headsid']), array('id' => $memberid, 'uniacid' => $_W['uniacid']));
            }
        }
    }

}