<?php

//decode by http://www.yunlu99.com/
namespace app\api\controller;

use app\api\service\RedPaper;
use app\api\service\WxCompany;
use app\urge\controller\Upload;
use think\Db;
use think\Debug;
use think\Request;
class User extends Base
{
    public function book()
    {
        return 1;
    }
    public function get_user_info()
    {
        $rs = ["status" => "success"];
        if ($this->user_info) {
            $rs["msg"] = "获取成功！";
            $info = $this->user_info;
            $info["is_vip"] = $this->get_user_vip($info["id"]);
            if ($info["vip_end_time"] > time()) {
                $info["vip_end_time"] = date("Y-m-d", $info["vip_end_time"]) . "到期";
            } else {
                $info["vip_end_time"] = 0;
            }
            $trailing = Db::name("user_trailing")->where("user_id", $info["id"])->count();
            $info["trailing"] = formatNumber($trailing);
            $paper = Db::name("paper")->where("user_id", $info["id"])->count();
            $info["paper"] = formatNumber($paper);
            $user_track = Db::name("user_track")->where("at_user_id", $info["id"])->count();
            $info["user_track"] = formatNumber($user_track);
            $user_fs = Db::name("user_track")->where("qu_user_id", $info["id"])->count();
            $info["user_fs"] = formatNumber($user_fs);
            $info["autograph"] = emoji_decode($info["autograph"]);
            $info["is_nick_name"] = false;
            $info["is_nick_name_end"] = 0;
            if ($info["is_vip"] == 0) {
                if ($info["nick_name_time"] + 90 * 86400 > time()) {
                    $info["is_nick_name_end"] = date("Y-m-d H:i:s", $info["nick_name_time"] + 90 * 86400);
                    $info["is_nick_name"] = true;
                }
            }
            if ($info["is_vip"] == 1) {
                if ($info["nick_name_time"] + 30 * 86400 > time()) {
                    $info["is_nick_name_end"] = date("Y-m-d H:i:s", $info["nick_name_time"] + 30 * 86400);
                    $info["is_nick_name"] = true;
                }
            }
            $check = Db::name("user_punch")->whereTime("punch_time", "today")->where("user_id", $info["id"])->order("punch_time desc")->count();
            $info["is_sign"] = $check;
            $user_male = Db::name("user_smail")->where("user_id", $info["id"])->where("status", 0)->count();
            $info["user_male"] = $user_male;
            $user_yzm = Db::name("user_invitation_code")->where("user_id", $info["id"])->find();
            if (empty($user_yzm)) {
                $yzm = $this->get_yzm_random(6);
                Db::name("user_invitation_code")->insert(["user_id" => $info["id"], "code" => $yzm, "much_id" => $this->much_id]);
            }
            $rs["info"] = $info;
        } else {
            $rs["status"] = "error";
            $rs["msg"] = "系统忙，请稍候重试！";
        }
        return json_encode($rs);
    }
    public function add_user_punch()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $check = Db::name("user_punch")->whereTime("punch_time", "today")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->order("punch_time desc")->find();
        if ($check) {
            $rs = ["status" => "error", "msg" => "今天已经签过，请明天再来！"];
            return json_encode($rs);
        }
        Db::startTrans();
        $is_vip = $this->get_user_vip($data["uid"]);
        $punch_range = Db::name("user_punch_range")->where("much_id", $data["much_id"])->find();
        if ($is_vip == 1) {
            $fraction = rand($punch_range["noble_min"] * 100, $punch_range["noble_max"] * 100) / 100;
        } else {
            $fraction = rand($punch_range["aver_min"] * 100, $punch_range["aver_max"] * 100) / 100;
        }
        try {
            $ins = Db::name("user_punch")->insert(["user_id" => $data["uid"], "fraction" => $fraction, "punch_time" => time(), "much_id" => $data["much_id"]]);
            if (!$ins) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "签到失败，请稍候重试"];
                return json_encode($rs);
            }
            $am["user_id"] = $data["uid"];
            $am["category"] = 3;
            $am["poem_fraction"] = $user_info["fraction"];
            $am["surplus_fraction"] = $user_info["fraction"] + $fraction;
            $am["finance"] = $fraction;
            $am["ruins_time"] = time();
            $am["solution"] = "每日签到赠送" . $this->design["confer"];
            $am["evaluate"] = 1;
            $am["much_id"] = $data["much_id"];
            $user_amount = Db::name("user_amount")->insert($am);
            if (!$user_amount) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "签到失败，请稍候重试"];
                return json_encode($rs);
            }
            $user_up = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["fraction" => $am["surplus_fraction"]]);
            if (!$user_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "签到失败，请稍候重试"];
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "签到成功！" . $this->design["confer"] . "增加" . $fraction . $this->design["confer"]];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "签到失败，请稍候重试" . $e->getMessage()];
            return json_encode($rs);
        }
    }
    public function edit_user_info()
    {
        $rs = ["status" => "success", "msg" => "保存成功"];
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $user_list = Db::name("user")->where("id", "<>", $data["uid"])->where("much_id", $data["much_id"])->where("user_nick_name", emoji_encode($data["nick_name"]))->find();
        if ($user_list) {
            $rs = ["status" => "error", "msg" => "昵称已存在，换个吧"];
            return json_encode($rs);
        }
        if (emoji_encode($data["nick_name"]) != $user_info["user_nick_name"]) {
            $up["user_nick_name"] = emoji_encode($data["nick_name"]);
            $up["nick_name_time"] = emoji_encode($data["nick_name"]) == $user_info["user_nick_name"] ? 0 : time();
        }
        $up["user_head_sculpture"] = $data["img"];
        $up["gender"] = $data["gender"];
        $up["autograph"] = emoji_encode($data["autograph"]);
        $up["user_head_sculpture"] = $data["img"];
        $update = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update($up);
        if ($update !== false) {
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "保存失败"];
            return json_encode($rs);
        }
    }
    public function get_index_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $where = [];
        if (isset($data["tory_id"])) {
            $where["p.tory_id"] = ["eq", $data["tory_id"]];
            $where["p.topping_time"] = ["eq", 0];
        }
        if ($this->version == 1) {
            $where["p.study_type"] = ["in", ["0", "1"]];
        }
        $user_trailing = Db::name("user_trailing")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->select();
        $user_trailing_id = '';
        foreach ($user_trailing as $k => $v) {
            $user_trailing_id .= $v["tory_id"] . ",";
        }
        $user_trailing_id = substr($user_trailing_id, 0, -1);
        $q_tory = Db::name("territory")->whereNotIn("id", $user_trailing_id)->where("status", 1)->where("attention", 1)->where("much_id", $data["much_id"])->select();
        $q_tory_id = '';
        foreach ($q_tory as $k => $v) {
            $q_tory_id .= $v["id"] . ",";
        }
        $q_tory_id = substr($q_tory_id, 0, -1);
        $page = $data["index_page"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where("t.status", 1)->where($where)->whereNotIn("t.id", $q_tory_id)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name,u.user_wechat_open_id")->order("p.adapter_time desc")->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                if (isset($data["tory_id"])) {
                    $list[$k]["check_qq"] = $this->check_qq($v["user_wechat_open_id"], $v["tory_id"]);
                }
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "48";
                    } else {
                        $list[$k]["image_length"] = "31.5";
                    }
                }
                $list[$k]["adapter_time"] = formatTime($v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
                $red = Db::name("paper_red_packet")->where("paper_id", $v["id"])->where("much_id", $data["much_id"])->count();
                $list[$k]["red"] = $red;
            }
            $rs["info"] = $list;
        } else {
            $rs["info"] = [];
        }
        $rs["version"] = $this->version;
        return json_encode($rs);
    }
    public function get_my_index_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $user_track = Db::name("user_track")->where("at_user_id", $data["uid"])->select();
        $user_arr = [];
        foreach ($user_track as $k => $v) {
            $user_arr[$k] = $v["qu_user_id"];
        }
        $user["user_track"] = formatNumber($user_track);
        $where = [];
        if ($this->version == 1) {
            $where["p.study_type"] = ["in", ["0", "1"]];
        }
        $where["p.user_id"] = ["in", $user_arr];
        $page = $data["index_page"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where($where)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name")->order("p.adapter_time desc")->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "48";
                    } else {
                        $list[$k]["image_length"] = "31.5";
                    }
                }
                $list[$k]["adapter_time"] = formatTime($v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
            }
            $rs["info"] = $list;
        } else {
            $rs["info"] = [];
        }
        return json_encode($rs);
    }
    public function add_circle()
    {
        $data = input("param.");
        if (!empty($data["content"])) {
            $ms = $this->check_msg($data["content"], $data["mch_id"]);
            if ($ms != 0) {
                $rs = ["status" => "error", "msg" => "内容含有违法违规内容"];
                return json_encode($rs);
            }
        }
        if (!empty($data["title"])) {
            $ms1 = $this->check_msg($data["title"], $data["mch_id"]);
            if ($ms1 != 0) {
                $rs = ["status" => "error", "msg" => "标题含有违法违规内容"];
                return json_encode($rs);
            }
        }
        $msg = '';
        if ($this->paper_smingle["auto_review"] == 0) {
            $msg = "等待审核";
        }
        $check_banned = Db::name("user_banned")->where("tory_id", $data["fa_class"])->where("user_id", $data["uid"])->where("much_id", $data["mch_id"])->find();
        if ($check_banned["refer_time"] > time()) {
            return json_encode(["status" => "error", "id" => 0, "msg" => "您已被禁言，解除时间:" . date("Y-m-d H:i:s", $check_banned["refer_time"])]);
        }
        if ($this->paper_smingle["number_limit"] != 0) {
            $check_today = Db::name("paper")->where("user_id", $this->user_info["id"])->whereTime("adapter_time", "today")->count();
            if ($check_today >= $this->paper_smingle["number_limit"]) {
                return json_encode(["status" => "error", "id" => 0, "msg" => "今日发帖已达上限！"]);
            }
        }
        $paper["study_type"] = $data["type"];
        $paper["user_id"] = $this->user_info["id"];
        $paper["tory_id"] = $data["fa_class"];
        $paper["study_title"] = emoji_encode($data["title"]);
        $paper["study_title_color"] = $data["color"];
        $paper["adapter_time"] = time();
        $paper["is_open"] = $data["is_open"];
        $paper["much_id"] = $data["mch_id"];
        if (!empty($data["img_arr"])) {
            $paper["image_part"] = json_encode($data["img_arr"]);
        }
        $paper["study_content"] = emoji_encode($data["content"]);
        $paper["study_status"] = $this->paper_smingle["auto_review"];
        if ($this->paper_smingle["auto_review"] == 1) {
            $paper["prove_time"] = time();
        }
        if ($data["type"] == 1) {
            $paper["study_voice"] = $data["user_file"];
            $paper["study_voice_time"] = $data["file_ss"];
        } else {
            if ($data["type"] == 2) {
                $paper["study_video"] = $data["user_file"];
            } else {
                if ($data["type"] == 0) {
                    $paper["study_voice"] = '';
                    $paper["study_video"] = '';
                }
            }
        }
        Db::startTrans();
        try {
            $res = Db::name("paper")->insertGetId($paper);
            if (!$res) {
                Db::rollback();
                return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！"]);
            }
            if ($data["red_paper"] == 1) {
                $red["paper_id"] = $res;
                $red["initial_fraction"] = $data["zong_red_money"];
                $red["surplus_fraction"] = $data["zong_red_money"];
                $red["initial_quantity"] = $data["zong_red_count"];
                $red["surplus_quantity"] = $data["zong_red_count"];
                $red["red_type"] = $data["red_type"];
                $red["much_id"] = $data["mch_id"];
                $red_res = Db::name("paper_red_packet")->insert($red);
                if (!$red_res) {
                    Db::rollback();
                    return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！1"]);
                }
                if ($this->user_info["fraction"] < $data["zong_red_money"]) {
                    Db::rollback();
                    return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，积分不足！"]);
                }
                $amount["user_id"] = $data["uid"];
                $amount["category"] = 2;
                $amount["finance"] = -$data["zong_red_money"];
                $amount["poem_fraction"] = $this->user_info["fraction"];
                $amount["poem_conch"] = $this->user_info["conch"];
                $amount["surplus_fraction"] = $this->user_info["fraction"] - $data["zong_red_money"];
                $amount["surplus_conch"] = $this->user_info["conch"];
                $amount["ruins_time"] = time();
                $amount["solution"] = "发布红包贴";
                $amount["evaluate"] = 1;
                $amount["much_id"] = $data["mch_id"];
                $amount_res = Db::name("user_amount")->insert($amount);
                if (!$amount_res) {
                    Db::rollback();
                    return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！2"]);
                }
                $money = $this->user_info["fraction"] - $data["zong_red_money"];
                $user_res = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["mch_id"])->update(["fraction" => $money]);
                if (!$user_res) {
                    Db::rollback();
                    return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！3"]);
                }
            }
            if ($this->paper_smingle["auto_review"] == 1) {
                $shaky_fission = Db::name("shaky_fission")->where("much_id", $data["mch_id"])->find();
                if (!empty($shaky_fission)) {
                    $check_paper = Db::name("paper")->where("user_id", $data["uid"])->whereTime("adapter_time", "today")->where("much_id", $data["mch_id"])->count();
                    if ($shaky_fission["release_single"] != 0) {
                        if ($check_paper <= $shaky_fission["release_single"]) {
                            $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["mch_id"])->find();
                            $amount_j["user_id"] = $data["uid"];
                            $amount_j["category"] = 3;
                            $amount_j["finance"] = $shaky_fission["release_fraction"];
                            $amount_j["poem_fraction"] = $user_info["fraction"];
                            $amount_j["poem_conch"] = $user_info["conch"];
                            $amount_j["surplus_fraction"] = $user_info["fraction"] + $shaky_fission["release_fraction"];
                            $amount_j["surplus_conch"] = $user_info["conch"];
                            $amount_j["ruins_time"] = time();
                            $amount_j["solution"] = "发贴获得积分";
                            $amount_j["evaluate"] = 1;
                            $amount_j["much_id"] = $data["mch_id"];
                            $amount_j_res = Db::name("user_amount")->insert($amount_j);
                            if (!$amount_j_res) {
                                Db::rollback();
                                return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！2"]);
                            }
                            $user_j_res = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["mch_id"])->update(["fraction" => $amount_j["surplus_fraction"]]);
                            if (!$user_j_res) {
                                Db::rollback();
                                return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！3"]);
                            } else {
                                $msg = $this->design["confer"] . "增加:" . $shaky_fission["release_fraction"];
                            }
                        }
                    }
                }
            }
            Db::commit();
            return json_encode(["status" => "success", "id" => $res, "msg" => "发布成功！" . $msg]);
        } catch (\Exception $e) {
            Db::rollback();
            return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！" . $e->getMessage()]);
        }
    }
    public function get_article_info()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $id = $data["id"];
        Db::name("paper")->where("id", $id)->setInc("study_heat");
        $info = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.id", $id)->field("p.*,t.concern,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name,t.realm_icon,t.id as realm_id")->find();
        if ($info) {
            $info["user_vip"] = $this->get_user_vip($info["user_id"]);
            $info["adapter_time"] = formatTime($info["adapter_time"]);
            $info["is_voice"] = false;
            $info["user_nick_name"] = emoji_decode($info["user_nick_name"]);
            $info["study_title"] = emoji_decode($info["study_title"]);
            $info["study_content"] = emoji_decode($info["study_content"]);
            $info["image_part"] = json_decode($info["image_part"], true);
            $info["is_voice"] = false;
            $info["study_heat"] = formatNumber($info["study_heat"]);
            $info["study_laud"] = formatNumber($info["study_laud"]);
            $info["study_repount"] = formatNumber($info["study_repount"]);
            $info["concern"] = formatNumber($info["concern"]);
            $info["paper_number"] = formatNumber(Db::name("paper")->where("tory_id", $info["tory_id"])->where("study_status", 1)->where("whether_delete", 0)->where("much_id", $data["much_id"])->count());
            $sc = Db::name("user_collect")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $id)->count();
            $info["is_info_sc"] = $sc == 0 ? false : true;
            $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $id)->count();
            $info["is_info_zan"] = $sc == 0 ? false : true;
            $count = Db::name("user_collect")->where("paper_id", $id)->count();
            $info["info_sc_count"] = formatNumber($count);
            $count_zan = Db::name("user_applaud")->where("paper_id", $id)->count();
            $info["info_zan_count"] = formatNumber($count_zan);
            $info["is_qq"] = $this->check_qq($data["openid"], $info["tory_id"]);
            $red = Db::name("paper_red_packet")->where("paper_id", $id)->where("much_id", $data["much_id"])->find();
            if (!empty($red)) {
                $info["red"] = $red;
            }
            $rs["info"] = $info;
        } else {
            $rs["status"] = "error";
            $rs["msg"] = "该信息已被删除";
        }
        return json_encode($rs);
    }
    public function get_article_huifu()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $id = $data["id"];
        $page = $data["page"];
        $show_type = $data["show_type"];
        $where = [];
        $t_uid = Db::name("paper")->where("id", $id)->find();
        if ($show_type == "main") {
            $where["r.user_id"] = ["eq", $t_uid["user_id"]];
        }
        if ($show_type == "my") {
            $where["r.user_id"] = ["eq", $data["uid"]];
        }
        $pl = Db::name("paper_reply")->alias("r")->join("user u", "u.id=r.user_id")->where("r.paper_id", $id)->where("r.whether_delete", "0")->where($where)->field("r.*,u.gender,u.user_nick_name,u.user_head_sculpture,u.user_wechat_open_id")->order("r.praise desc,r.phase")->page($page, "20")->select();
        foreach ($pl as $k => $v) {
            $pl[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
            $pl[$k]["is_qq"] = $this->check_qq($v["user_wechat_open_id"], $this->get_user_applaud($v["id"])["tory_id"]);
            $pl[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
            $pl[$k]["reply_content"] = emoji_decode($v["reply_content"]);
            $pl[$k]["apter_time"] = formatTime($v["apter_time"]);
            $pl[$k]["image_part"] = json_decode($v["image_part"]);
            $pl[$k]["is_voice"] = false;
            $pl[$k]["is_paper_user"] = $this->get_page_user($id)["user_id"];
            $check_hf_zan = Db::name("user_applaud")->where("applaud_type", 1)->where("user_id", $data["uid"])->where("paper_id", $v["id"])->find();
            $pl[$k]["is_huifu_zan_count"] = Db::name("user_applaud")->where("applaud_type", 1)->where("paper_id", $v["id"])->count();
            if ($check_hf_zan > 0) {
                $pl[$k]["is_huifu_zan"] = true;
            } else {
                $pl[$k]["is_huifu_zan"] = false;
            }
            $pl[$k]["is_huifu_zan_count"] = formatNumber($pl[$k]["is_huifu_zan_count"]);
            $hui_and_key = Db::name("paper_reply_duplex")->where("reply_id", $v["id"])->count();
            $pl[$k]["huifu_count"] = $hui_and_key == 0 ? '' : formatNumber($hui_and_key);
        }
        $hui_count = Db::name("paper_reply")->where("whether_delete", 0)->where("paper_id", $id)->count();
        $rs["huifu_count"] = formatNumber($hui_count);
        $rs["huifu"] = $pl;
        return json_encode($rs);
    }
    public function add_paper_reply()
    {
        $rs = ["status" => "success", "msg" => "回复成功！"];
        $data = input("param.");
        if (!empty($data["text"])) {
            $ms = $this->check_msg($data["text"], $data["much_id"]);
            if ($ms != 0) {
                $rs = ["status" => "error", "msg" => "内容含有违法违规内容"];
                return json_encode($rs);
            }
        }
        $chech_tory_id = Db::name("paper")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        $check_banned = Db::name("user_banned")->where("tory_id", $chech_tory_id["tory_id"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($check_banned["refer_time"] > time()) {
            return json_encode(["status" => "error", "msg" => "您已被禁言，解除时间:" . date("Y-m-d H:i:s", $check_banned["refer_time"])]);
        }
        $ins["paper_id"] = $data["id"];
        $ins["user_id"] = $data["uid"];
        $ins["reply_type"] = $data["reply_type"];
        if ($data["reply_type"] == 1) {
            $ins["reply_voice"] = $data["file"];
            $ins["reply_voice_time"] = $data["file_ss"];
        } else {
            $ins["image_part"] = json_encode($data["img_arr"]);
        }
        $phase = Db::name("paper_reply")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->max("phase");
        if ($phase == 0) {
            $ins["phase"] = 2;
        } else {
            $ins["phase"] = $phase + 1;
        }
        $ins["reply_content"] = emoji_encode($data["text"]);
        $ins["apter_time"] = time();
        $ins["much_id"] = $data["much_id"];
        $add = Db::name("paper_reply")->insertGetId($ins);
        if ($add) {
            Db::name("paper")->where("much_id", $data["much_id"])->where("id", $data["id"])->setInc("study_repount");
            $rs["id"] = $add;
            if ($data["uid"] != $chech_tory_id["user_id"]) {
                $con = $chech_tory_id["study_title"] == '' ? $chech_tory_id["study_content"] : $chech_tory_id["study_title"];
                $msg = "用户【" . emoji_encode($this->user_info["user_nick_name"]) . "】，评论了您的帖子[" . $con . "]";
                Db::name("user_smail")->insert(["maring" => $msg, "user_id" => $chech_tory_id["user_id"], "clue_time" => time(), "much_id" => $data["much_id"]]);
            }
        } else {
            $rs["status"] = "error";
            $rs["msg"] = "回复失败";
            return json_encode($rs);
        }
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $fa_info = $this->get_page_user($data["id"]);
        $hui_info = $this->paper_reply($add);
        Db::startTrans();
        try {
            $zong_money = 0;
            $shaky_fission = Db::name("shaky_fission")->where("much_id", $data["much_id"])->find();
            if (!empty($shaky_fission)) {
                $paper = Db::name("paper_red_packet")->where("paper_id", $data["id"])->where("much_id", $data["much_id"])->find();
                if (!empty($paper) && $shaky_fission["packet_single"] != 0) {
                    if ($paper["surplus_quantity"] != 0) {
                        if ($paper["red_type"] == 1) {
                            $red = new RedPaper();
                            $red->amount = $paper["surplus_fraction"];
                            $red->num = $paper["surplus_quantity"];
                            $red->paper_min = 0.01;
                            $get_money = $red->handle()["items"][0];
                        }
                        if ($paper["red_type"] == 0) {
                            $get_money = $this->rob_red_avg($paper["surplus_fraction"], $paper["surplus_quantity"]);
                        }
                        $user_red_packet = Db::name("user_red_packet")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->whereTime("obtain_time", "today")->count();
                        if ($user_red_packet <= $shaky_fission["packet_single"]) {
                            $check_paer_hui = Db::name("user_red_packet")->where("red_packet_id", $paper["id"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->count();
                            if (empty($check_paer_hui)) {
                                $packet["user_id"] = $data["uid"];
                                $packet["red_packet_id"] = $paper["id"];
                                $packet["obtain_fraction"] = $get_money;
                                $packet["obtain_time"] = time();
                                $packet["much_id"] = $data["much_id"];
                                $packet_res = Db::name("user_red_packet")->insert($packet);
                                if (!$packet_res) {
                                    Db::rollback();
                                    $rs = ["status" => "error", "msg" => "回复失败！4"];
                                    return json_encode($rs);
                                }
                                $amount["user_id"] = $data["uid"];
                                $amount["category"] = 3;
                                $amount["finance"] = $get_money;
                                $amount["poem_fraction"] = $user_info["fraction"];
                                $amount["poem_conch"] = $user_info["conch"];
                                $amount["surplus_fraction"] = $user_info["fraction"] + $get_money;
                                $amount["surplus_conch"] = $user_info["conch"];
                                $amount["ruins_time"] = time();
                                $amount["solution"] = "回帖红包奖励";
                                $amount["evaluate"] = 1;
                                $amount["much_id"] = $data["much_id"];
                                $amount_res = Db::name("user_amount")->insert($amount);
                                if (!$amount_res) {
                                    Db::rollback();
                                    $rs = ["status" => "error", "msg" => "回复失败！3"];
                                    return json_encode($rs);
                                } else {
                                    $rs = ["status" => "success", "msg" => "回复成功，" . $this->design["confer"] . "增加" . $get_money];
                                }
                                $zong_money += $get_money;
                                $packet_c["surplus_fraction"] = $paper["surplus_fraction"] - $get_money;
                                $packet_c["surplus_quantity"] = $paper["surplus_quantity"] - 1;
                                $packet_c_res = Db::name("paper_red_packet")->where("id", $paper["id"])->where("much_id", $data["much_id"])->update($packet_c);
                                if (!$packet_c_res) {
                                    Db::rollback();
                                    $rs = ["status" => "error", "msg" => "回复失败！1"];
                                    return json_encode($rs);
                                }
                            }
                        }
                    }
                }
                $paper_hui_count = Db::name("paper_reply")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->whereTime("apter_time", "today")->count();
                if ($shaky_fission["reply_single"] >= $paper_hui_count) {
                    $amount_j["user_id"] = $data["uid"];
                    $amount_j["category"] = 3;
                    $amount_j["finance"] = $shaky_fission["reply_fraction"];
                    $amount_j["poem_fraction"] = $user_info["fraction"];
                    $amount_j["poem_conch"] = $user_info["conch"];
                    $amount_j["surplus_fraction"] = $user_info["fraction"] + $shaky_fission["reply_fraction"];
                    $amount_j["surplus_conch"] = $user_info["conch"];
                    $amount_j["ruins_time"] = time();
                    $amount_j["solution"] = "回帖积分奖励";
                    $amount_j["evaluate"] = 1;
                    $amount_j["much_id"] = $data["much_id"];
                    $amount_j_res = Db::name("user_amount")->insert($amount_j);
                    $zong_money += $shaky_fission["reply_fraction"];
                    $update_moeny = $user_info["fraction"] + $zong_money;
                    if (!$amount_j_res) {
                        Db::rollback();
                        $rs = ["status" => "error", "msg" => "回复失败！5"];
                        return json_encode($rs);
                    } else {
                        $rs = ["status" => "success", "msg" => "回复成功，增加" . substr(sprintf("%.3f", $zong_money), 0, -1) . $this->design["confer"]];
                    }
                    $user_j_res = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["fraction" => $update_moeny]);
                    if (!$user_j_res) {
                        Db::rollback();
                        $rs = ["status" => "error", "msg" => "回复失败！6"];
                        return json_encode($rs);
                    }
                }
            }
            $check_fa = Db::name("user_templet_history")->where("send_user_id", $data["uid"])->where("accept_user_id", $fa_info["user_id"])->where("archetype_id", "AT1803")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->find();
            if (empty($check_fa)) {
                $page_title = $hui_info["study_title"] == '' ? subtext($hui_info["study_content"], 10) : subtext($hui_info["study_title"], 10);
                $hui_title = subtext($hui_info["reply_content"], 10);
                if (empty($hui_title)) {
                    if ($hui_info["reply_type"] == 0) {
                        $hui_title = "[一张图片]";
                    }
                    if ($hui_info["reply_type"] == 1) {
                        $hui_title = "[一段语音]";
                    }
                }
                if (empty($page_title)) {
                    if ($fa_info["study_type"] == 0) {
                        $page_title = "[图片帖子]";
                    }
                    if ($fa_info["study_type"] == 1) {
                        $page_title = "[语音帖子]";
                    }
                    if ($fa_info["study_type"] == 2) {
                        $page_title = "[视频帖子]";
                    }
                }
                $result = $this->add_template(["much_id" => $data["much_id"], "at_id" => "AT1803", "user_id" => $fa_info["user_id"], "page" => "yl_welore/pages/packageA/article/index?id=" . $fa_info["id"] . "&type=" . $fa_info["study_type"], "keyword1" => emoji_encode($page_title), "keyword2" => emoji_encode($user_info["user_nick_name"]), "keyword3" => $hui_title, "keyword4" => date("Y年m月d日 H:i:s", time())]);
                if ($result == 0) {
                    Db::name("user_templet_history")->insert(["paper_id" => $data["id"], "send_user_id" => $data["uid"], "accept_user_id" => $fa_info["user_id"], "archetype_id" => "AT1803", "send_time" => time(), "much_id" => $data["much_id"]]);
                }
            }
            Db::commit();
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "回复失败！" . $e->getMessage()];
            return json_encode($rs);
        }
    }
    public function rob_red_avg($sum, $num)
    {
        $res = $sum / $num;
        $i = 0;
        while ($i < $num) {
            $arr[$i] = $res;
            $i++;
        }
        return $arr[0];
    }
    public function del_article()
    {
        $data = input("param.");
        $info = Db::name("paper")->where("id", $data["paper_id"])->find();
        if ($info["whether_delete"] == 1) {
            $rs = ["status" => "success", "msg" => "删除成功！"];
            return json_encode($rs);
        }
        $up = [];
        if ($data["uid"] == $info["user_id"]) {
            $up["whetd_time"] = time();
            $up["whether_delete"] = 1;
            $up["whether_type"] = 3;
            $up["whether_reason"] = "用户自己删除";
            $up["token"] = md5(time());
        }
        if (!empty($data["is_qq_text"])) {
            $up["whetd_time"] = time();
            $up["whether_delete"] = 1;
            $up["whether_type"] = 2;
            $up["whether_reason"] = emoji_encode($data["is_qq_text"]);
            $up["token"] = md5(time());
        }
        $del = Db::name("paper")->where("much_id", $data["much_id"])->where("id", $data["paper_id"])->update($up);
        if ($del) {
            $rs = ["status" => "success", "msg" => "删除成功！"];
            if (!empty($data["is_qq_text"])) {
                $tatle = $info["study_title"] == '' ? $info["study_content"] : $info["study_title"];
                $msg = "您的帖子【" . subtext($tatle, 20) . "】由于：" . emoji_encode($data["is_qq_text"]) . "被管理员删除，如有疑问请到服务中心申诉";
                $this->add_user_smail($info["user_id"], $msg, $data["much_id"]);
            }
        } else {
            $rs = ["status" => "error", "msg" => "删除失败！"];
        }
        return json_encode($rs);
    }
    public function del_article_huifu()
    {
        $rs = ["status" => "success", "msg" => "删除成功！"];
        $data = input("param.");
        $check = $this->get_user_applaud($data["id"]);
        $huifu_info = Db::name("paper_reply")->where("id", $data["id"])->find();
        if ($data["uid"] == $check["user_id"]) {
            $up["whetd_time"] = time();
            $up["whether_delete"] = 1;
            $up["whether_type"] = 4;
            $up["whether_reason"] = "楼主删除";
            $up["token"] = md5(time());
        }
        if ($data["uid"] == $huifu_info["user_id"]) {
            $up["whetd_time"] = time();
            $up["whether_delete"] = 1;
            $up["whether_type"] = 3;
            $up["whether_reason"] = "用户自己删除";
            $up["token"] = md5(time());
        }
        if (!empty($data["is_qq_text"])) {
            $up["whetd_time"] = time();
            $up["whether_delete"] = 1;
            $up["whether_type"] = 2;
            $up["whether_reason"] = emoji_encode($data["is_qq_text"]);
            $up["token"] = md5(time());
        }
        $del = Db::name("paper_reply")->where("id", $data["id"])->update($up);
        if (!$del) {
            $rs["status"] = "error";
            $rs["msg"] = "删除失败！";
        }
        Db::name("paper")->where("id", $data["paper_id"])->setDec("study_repount");
        if (!empty($data["is_qq_text"])) {
            $msg = "您的回复由于：" . emoji_encode($data["is_qq_text"]) . "被管理员删除，如有疑问请到服务中心申诉";
            $this->add_user_smail($huifu_info["user_id"], $msg, $data["much_id"]);
        }
        return json_encode($rs);
    }
    public function add_user_zan()
    {
        $rs = ["status" => "success", "msg" => "赞成功！"];
        $data = input("param.");
        if ($data["zan_type"] == 1) {
            Db::name("user_applaud")->where("applaud_type", $data["applaud_type"])->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $data["id"])->delete();
            $count = Db::name("user_applaud")->where("applaud_type", $data["applaud_type"])->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->count();
            $rs["info_zan_count"] = formatNumber($count);
            $rs["info_zan"] = false;
            $rs["status"] = "success";
            $rs["msg"] = "取消成功！";
            Db::name("paper")->where("id", $data["id"])->setDec("study_laud");
            return json_encode($rs);
        }
        $check_count = Db::name("user_applaud")->where("applaud_type", $data["applaud_type"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->count();
        if ($check_count > 0) {
            $rs["info_zan"] = true;
            return json_encode($rs);
        }
        $ins_data["user_id"] = $data["uid"];
        $ins_data["paper_id"] = $data["id"];
        $ins_data["much_id"] = $data["much_id"];
        $ins_data["laud_time"] = time();
        $ins_data["applaud_type"] = $data["applaud_type"];
        Db::name("user_applaud")->insert($ins_data);
        $count = Db::name("user_applaud")->where("applaud_type", $data["applaud_type"])->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->count();
        $rs["info_zan_count"] = formatNumber($count);
        $rs["info_zan"] = true;
        Db::name("paper")->where("id", $data["id"])->setInc("study_laud");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $fa_info = $this->get_page_user($data["id"]);
        $check_fa = Db::name("user_templet_history")->where("send_user_id", $data["uid"])->where("accept_user_id", $fa_info["user_id"])->where("archetype_id", "AT2295")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->find();
        if (empty($check_fa)) {
            $page_title = $fa_info["study_title"] == '' ? subtext($fa_info["study_content"], 10) : subtext($fa_info["study_title"], 10);
            if (empty($page_title)) {
                if ($fa_info["study_type"] == 0) {
                    $page_title = "[图片帖子]";
                }
                if ($fa_info["study_type"] == 1) {
                    $page_title = "[语音帖子]";
                }
                if ($fa_info["study_type"] == 2) {
                    $page_title = "[视频帖子]";
                }
            }
            $result = $this->add_template(["much_id" => $data["much_id"], "at_id" => "AT2295", "user_id" => $fa_info["user_id"], "page" => "yl_welore/pages/packageA/article/index?id=" . $fa_info["id"] . "&type=" . $fa_info["study_type"], "keyword1" => emoji_encode($page_title), "keyword2" => emoji_encode($user_info["user_nick_name"]), "keyword3" => date("Y年m月d日 H:i:s", time())]);
            if ($result == 0) {
                Db::name("user_templet_history")->insert(["paper_id" => $data["id"], "send_user_id" => $data["uid"], "accept_user_id" => $fa_info["user_id"], "archetype_id" => "AT2295", "send_time" => time(), "much_id" => $data["much_id"]]);
            }
        }
        return json_encode($rs);
    }
    public function placement()
    {
        $data = input("param.");
        $check = Db::name("paper")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($check["whether_type"] != 0 || $check["whether_delete"] == 1) {
            $rs = ["status" => "error", "msg" => "帖子已被删除！"];
            return json_encode($rs);
        }
        if ($check["topping_time"] == 0) {
            $up = Db::name("paper")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["topping_time" => time()]);
            if ($up) {
                $rs = ["status" => "success", "msg" => "置顶成功！"];
            } else {
                $rs = ["status" => "error", "msg" => "置顶失败！"];
            }
        } else {
            $up = Db::name("paper")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["topping_time" => 0]);
            if ($up) {
                $rs = ["status" => "success", "msg" => "取消置顶成功！"];
            } else {
                $rs = ["status" => "error", "msg" => "取消置顶失败！"];
            }
        }
        return json_encode($rs);
    }
    public function get_placement_top()
    {
        $data = input("param.");
        $check = Db::name("paper")->where("tory_id", $data["tory_id"])->where("much_id", $data["much_id"])->where("study_status", 1)->where("whether_delete", 0)->where("topping_time<>0")->order("topping_time desc")->limit(5)->select();
        foreach ($check as $k => $v) {
            $check[$k]["study_title_color"] = emoji_decode($v["study_title_color"]);
            $check[$k]["study_content"] = emoji_decode($v["study_content"]);
        }
        $rs = ["status" => "success", "msg" => "成功！"];
        $rs["info"] = $check;
        return json_encode($rs);
    }
    public function add_user_collect()
    {
        $rs = ["status" => "success", "msg" => "收藏成功！"];
        $data = input("param.");
        if ($data["sc_type"] == 1) {
            $ins = Db::name("user_collect")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $data["id"])->delete();
            if ($ins) {
                $rs["msg"] = "取消收藏成功！";
            } else {
                $rs["status"] = "error";
                $rs["msg"] = "取消收藏失败！";
            }
            $count = Db::name("user_collect")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->count();
            $rs["info_sc_count"] = $count;
            $rs["info_sc"] = false;
            return json_encode($rs);
        }
        $ins_data["user_id"] = $data["uid"];
        $ins_data["paper_id"] = $data["id"];
        $ins_data["much_id"] = $data["much_id"];
        $ins_data["create_time"] = time();
        $ins = Db::name("user_collect")->insert($ins_data);
        $count = Db::name("user_collect")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->count();
        if (!$ins) {
            $rs["status"] = "error";
            $rs["msg"] = "收藏失败！";
        }
        $rs["info_sc_count"] = $count;
        $rs["info_sc"] = true;
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $fa_info = $this->get_page_user($data["id"]);
        $check_fa = Db::name("user_templet_history")->where("send_user_id", $data["uid"])->where("accept_user_id", $fa_info["user_id"])->where("archetype_id", "AT2310")->where("much_id", $data["much_id"])->where("paper_id", $data["id"])->find();
        if (empty($check_fa)) {
            $page_title = $fa_info["study_title"] == '' ? subtext($fa_info["study_content"], 10) : subtext($fa_info["study_title"], 10);
            if (empty($page_title)) {
                if ($fa_info["study_type"] == 0) {
                    $page_title = "[图片帖子]";
                }
                if ($fa_info["study_type"] == 1) {
                    $page_title = "[语音帖子]";
                }
                if ($fa_info["study_type"] == 2) {
                    $page_title = "[视频帖子]";
                }
            }
            $result = $this->add_template(["much_id" => $data["much_id"], "at_id" => "AT2310", "user_id" => $fa_info["user_id"], "page" => "yl_welore/pages/packageA/article/index?id=" . $fa_info["id"] . "&type=" . $fa_info["study_type"], "keyword1" => emoji_encode($page_title), "keyword2" => emoji_encode($user_info["user_nick_name"]), "keyword3" => $count]);
            if ($result == 0) {
                Db::name("user_templet_history")->insert(["paper_id" => $data["id"], "send_user_id" => $data["uid"], "accept_user_id" => $fa_info["user_id"], "archetype_id" => "AT2310", "send_time" => time(), "much_id" => $data["much_id"]]);
            }
        }
        return json_encode($rs);
    }
    public function get_user_collection()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_collect")->alias("c")->join("paper p", "p.id=c.paper_id")->join("user u", "u.id=p.user_id")->where("c.user_id", $data["uid"])->where("c.much_id", $data["much_id"])->page($data["page"], "20")->order("c.create_time desc")->field("p.*,u.user_head_sculpture,u.user_nick_name")->select();
        foreach ($list as $k => $v) {
            $list[$k]["study_title"] = emoji_decode($v["study_title"]);
            $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
            $list[$k]["study_content"] = emoji_decode($v["study_content"]);
            $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
            $list[$k]["study_title"] = emoji_decode($v["study_title"]);
            $list[$k]["image_part"] = json_decode($v["image_part"], true);
            $list[$k]["is_user"] = Db::name("user_track")->where("much_id", $data["much_id"])->where("at_user_id", $data["uid"])->where("qu_user_id", $v["user_id"])->count();
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function add_paper_complaint()
    {
        $rs = ["status" => "success", "msg" => "举报成功！"];
        $data = input("param.");
        $cheek = Db::name("paper_complaint")->where("acceptance_status", 0)->where("user_id", $data["uid"])->where("paper_id", $data["id"])->find();
        $cheek_1 = Db::name("paper_complaint")->where("acceptance_status", 0)->where("user_id", $data["uid"])->where("prely_id", $data["id"])->find();
        if ($cheek || $cheek_1) {
            $rs = ["status" => "error", "msg" => "您已举报，请等待处理！"];
            return json_encode($rs);
        }
        $ins["user_id"] = $data["uid"];
        $ins["tale_type"] = $data["tale_type"];
        if ($data["tale_type"] == 0) {
            $ins["paper_id"] = $data["id"];
            $ins["tory_id"] = $this->get_page_user($data["id"])["tory_id"];
        }
        if ($data["tale_type"] == 1) {
            $ins["prely_id"] = $data["id"];
            $ins["tory_id"] = $this->get_user_applaud($data["id"])["tory_id"];
        }
        $ins["tale_content"] = emoji_encode($data["content"]);
        $ins["petition_time"] = time();
        $ins["much_id"] = $data["much_id"];
        $ins["is_strike"] = 0;
        $red = Db::name("paper_complaint")->insert($ins);
        if (!$red) {
            $rs["status"] = "error";
            $rs["msg"] = "举报失败，请稍候重试！";
        }
        $rett = "用户" . $this->user_info["user_nick_name"] . "举报了一个帖子，请及时处理！";
        Db::name("prompt_msg")->insert(["msg_time" => time(), "type" => 1, "retter" => $rett, "status" => 0, "much_id" => $data["much_id"]]);
        $notices = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $data["much_id"])->count("*");
        cache("vacants_" . $data["much_id"], $notices);
        return json_encode($rs);
    }
    public function add_paper_prely()
    {
        $rs = ["status" => "success", "msg" => "点赞成功！"];
        $data = input("param.");
        $check = Db::name("user_applaud")->where("paper_id", $data["hui_id"])->where("user_id", $data["uid"])->where("applaud_type", 1)->find();
        if ($check) {
            Db::name("user_applaud")->where("paper_id", $data["hui_id"])->where("user_id", $data["uid"])->where("applaud_type", 1)->delete();
            $rs = ["status" => "success", "msg" => "成功！"];
            Db::name("paper_reply")->where("id", $data["hui_id"])->setDec("praise");
            return json_encode($rs);
        }
        $ins["paper_id"] = $data["hui_id"];
        $ins["user_id"] = $data["uid"];
        $ins["applaud_type"] = 1;
        $ins["laud_time"] = time();
        $ins["much_id"] = $data["much_id"];
        $red = Db::name("user_applaud")->insert($ins);
        if (!$red) {
            $rs = ["status" => "error", "msg" => "点赞失败！"];
            return json_encode($rs);
        }
        Db::name("paper_reply")->where("id", $data["hui_id"])->setInc("praise");
        return json_encode($rs);
    }
    public function get_all_needle()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");

        $needle = Db::name("needle")->where("status", 1)->where("much_id", $data["much_id"])->order("scores")->limit(6)->select();
        foreach ($needle as $k => $v) {
            $nex = Db::name("territory")->where("status", 1)->where("needle_id", $v["id"])->order("concern desc")->limit(3)->select();
            foreach ($nex as $a => $b) {
                $nex[$a]["concern"] = formatNumber($b["concern"]);
            }
            $needle[$k]["children"] = $nex;
            $needle[$k]["needle_count"] = Db::name("territory")->where("much_id", 3)->where("needle_id", $v["id"])->sum("concern");
        }
        $rs["info"] = $needle;
        return json_encode($rs);
    }
    public function get_left_needle()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $needle = Db::name("needle")->where("status", 1)->where("much_id", $data["much_id"])->select();
        $rs["info"] = $needle;
        return json_encode($rs);
    }
    public function get_right_needle()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $page = $data["page"];
        if ($data["get_id"] > 0) {
            $needle = Db::name("territory")->where("status", 1)->where("much_id", $data["much_id"])->where("needle_id", $data["get_id"])->page($page, "15")->select();
        }
        if ($data["get_id"] == -1) {
            $needle = Db::name("user_trailing")->alias("t")->join("territory e", "e.id=t.tory_id")->where("t.user_id", $data["uid"])->where("e.status", 1)->order("t.ling_time desc")->where("e.much_id", $data["much_id"])->field("e.*")->page($page, "15")->select();
        }
        if ($data["get_id"] == -2) {
            $needle = Db::name("territory")->where("status", 1)->order("concern desc")->where("much_id", $data["much_id"])->limit(50)->select();
        }
        if ($data["get_id"] == -3) {
            $needle = Db::name("territory")->where("status", 1)->order("rising_time desc")->where("much_id", $data["much_id"])->limit(50)->select();
        }
        foreach ($needle as $k => $v) {
            $needle[$k]["concern"] = formatNumber($v["concern"]);
            $needle[$k]["is_trailing"] = $this->get_user_trailing($data["uid"], $v["id"]);
            $needle[$k]["is_paper_count"] = formatNumber($this->get_territory_papo_count($v["id"]));
            $needle[$k]["realm_name"] = emoji_decode($v["realm_name"]);
        }
        $rs["info"] = $needle;
        return json_encode($rs);
    }
    public function set_user_trailing()
    {
        $rs = ["status" => "success", "msg" => "加入成功！"];
        $data = input("param.");
        $tory_info = Db::name("territory")->where("id", $data["tory_id"])->where("much_id", $data["much_id"])->find();
        $ckeck = Db::name("user_trailing")->where("user_id", $data["uid"])->where("tory_id", $data["tory_id"])->find();
        $tory_check = Db::name("territory_interest")->where("tory_id", $data["tory_id"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($data["is_trailing"] == 1) {
            $territory_learned = $this->check_qq($data["openid"], $data["tory_id"]);
            if ($territory_learned != "no") {
                $rs = ["status" => "error", "msg" => "管理员无法取消关注！"];
                return json_encode($rs);
            }
            Db::name("territory")->where("id", $data["tory_id"])->where("much_id", $data["much_id"])->setDec("concern");
            Db::name("user_trailing")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("tory_id", $data["tory_id"])->delete();
            if ($tory_check) {
                Db::name("territory_interest")->where("id", $tory_check["id"])->where("much_id", $data["much_id"])->delete();
            }
            $rs = ["status" => "success", "msg" => "取消成功！"];
            return json_encode($rs);
        }
        if ($ckeck) {
            $rs = ["status" => "error", "msg" => "已经加入该" . $this->design["landgrave"]];
            return json_encode($rs);
        }
        if ($tory_info["attention"] == 1) {
            if ($data["trailing_type"] == 0) {
                if ($tory_check) {
                    if ($tory_check["status"] == 0) {
                        $rs = ["status" => "error", "msg" => "已经申请加入" . $this->design["landgrave"]];
                        return json_encode($rs);
                    }
                    if ($tory_check["status"] == 1) {
                        $rs = ["status" => "error", "msg" => "您已经加入该" . $this->design["landgrave"]];
                        return json_encode($rs);
                    }
                    if ($tory_check["status"] == 2) {
                        $jia = Db::name("territory_interest")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->update(["reason" => emoji_encode(preg_replace("# #", '', $data["trailing_text"])), "status" => 0]);
                        if ($jia) {
                            $rs = ["status" => "error", "msg" => "申请加入" . $this->design["landgrave"] . "成功！"];
                            return json_encode($rs);
                        } else {
                            $rs = ["status" => "error", "msg" => "加入失败！"];
                            return json_encode($rs);
                        }
                    }
                }
                $interest = Db::name("territory_interest")->insert(["reason" => emoji_encode(preg_replace("# #", '', $data["trailing_text"])), "user_id" => $data["uid"], "tory_id" => $data["tory_id"], "sult_time" => time(), "rest_time" => 0, "much_id" => $data["much_id"]]);
                if ($interest) {
                    $rs = ["status" => "error", "msg" => "申请加入" . $this->design["landgrave"] . "成功！"];
                    $rett = "用户：" . $this->user_info["user_nick_name"] . "申请关注了" . $this->design["landgrave"] . "[" . $tory_info["realm_name"] . "]";
                    Db::name("prompt_msg")->insert(["msg_time" => time(), "type" => 0, "retter" => $rett, "status" => 0, "much_id" => $data["much_id"]]);
                    $notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $data["much_id"])->count("*");
                    cache("notices_" . $data["much_id"], $notices);
                    return json_encode($rs);
                } else {
                    $rs = ["status" => "error", "msg" => "申请失败"];
                    return json_encode($rs);
                }
            } else {
                if ($tory_info["atcipher"] == emoji_encode(preg_replace("# #", '', $data["trailing_text"]))) {
                    $real = Db::name("user_trailing")->insert(["user_id" => $data["uid"], "tory_id" => $data["tory_id"], "ling_time" => time(), "much_id" => $data["much_id"]]);
                    if ($real) {
                        Db::name("territory")->where("id", $data["tory_id"])->where("much_id", $data["much_id"])->setInc("concern");
                        $rs = ["status" => "success", "msg" => "加入成功！"];
                        if ($tory_check) {
                            Db::name("territory_interest")->where("id", $tory_check["id"])->where("much_id", $data["much_id"])->update(["status" => 1, "rest_time" => time()]);
                        }
                        return json_encode($rs);
                    } else {
                        $rs = ["status" => "error", "msg" => "加入失败！"];
                        return json_encode($rs);
                    }
                } else {
                    $rs = ["status" => "error", "msg" => "暗号不正确，加入失败！"];
                    return json_encode($rs);
                }
            }
        }
        $real = Db::name("user_trailing")->insert(["user_id" => $data["uid"], "tory_id" => $data["tory_id"], "ling_time" => time(), "much_id" => $data["much_id"]]);
        if ($real) {
            Db::name("territory")->where("id", $data["tory_id"])->where("much_id", $data["much_id"])->setInc("concern");
        } else {
            $rs = ["status" => "error", "msg" => "加入失败！"];
            return json_encode($rs);
        }
        return json_encode($rs);
    }
    public function get_tory_info()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $info = Db::name("territory")->where("status", 1)->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if (!$info) {
            $rs = ["status" => "error", "msg" => $this->design["landgrave"] . "不见了！"];
            return json_encode($rs);
        }
        $info["is_trailing"] = $this->get_user_trailing($data["uid"], $data["id"]);
        $info["is_paper_count"] = formatNumber($this->get_territory_papo_count($data["id"]));
        $info["concern"] = formatNumber($info["concern"]);
        $info["realm_name"] = emoji_decode($info["realm_name"]);
        $rs["info"] = $info;
        return json_encode($rs);
    }
    public function get_liwu()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("tribute")->where("status", 1)->where("much_id", $data["much_id"])->order("scores")->select();
        if (!$list) {
            $rs = ["status" => "error", "msg" => "获取礼物失败！"];
        } else {
            $rs["user_info"] = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
            $rs["info"] = $list;
        }
        return json_encode($rs);
    }
    public function get_user_honorary()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_honorary")->where("much_id", $data["much_id"])->find();
        $user_info = Db::name("user")->where("id", $data["uid"])->find();
        if (!$list) {
            $rs = ["status" => "error", "msg" => "获取会员价格失败！"];
        } else {
            if ($user_info["vip_end_time"] == 0) {
                $dd[0] = array("hono_price" => sprintf("%.1f", $list["hono_price"]), "hono_name" => "1个月", "time" => 1, "first_discount" => $list["first_discount"], "discount_scale" => $list["discount_scale"] * 10, "avg" => sprintf("%.1f", $list["discount_scale"] * $list["hono_price"]));
            } else {
                $dd[0] = array("hono_price" => sprintf("%.1f", $list["hono_price"]), "hono_name" => "1个月", "time" => 1, "first_discount" => 0);
            }
            $dd[1] = array("hono_price" => sprintf("%.1f", $list["hono_price"] * 3), "hono_name" => "3个月", "time" => 3, "first_discount" => 0);
            $dd[2] = array("hono_price" => sprintf("%.1f", $list["hono_price"] * 6), "hono_name" => "6个月", "time" => 6, "first_discount" => 0);
            $dd[3] = array("hono_price" => sprintf("%.1f", $list["hono_price"] * 12), "hono_name" => "12个月", "time" => 12, "first_discount" => 0);
            $rs["info"] = $dd;
        }
        return json_encode($rs);
    }
    public function add_territory_petition()
    {
        $rs = ["status" => "success", "msg" => "申请成功,请等待审核！"];
        $data = input("param.");
        if ($data["realm_icon"] == '') {
            $rs = ["status" => "error", "msg" => "请上传一张头像！"];
            return json_encode($rs);
        }
        if ($data["realm_name"] == '') {
            $rs = ["status" => "error", "msg" => "请填写名称！"];
            return json_encode($rs);
        }
        if ($data["realm_synopsis"] == '') {
            $rs = ["status" => "error", "msg" => "请填写简介！"];
            return json_encode($rs);
        }
        if ($data["solicit_origin"] == '') {
            $rs = ["status" => "error", "msg" => "请填写申请原因！"];
            return json_encode($rs);
        }
        $ins["realm_icon"] = $data["realm_icon"];
        $ins["realm_name"] = emoji_encode($data["realm_name"]);
        $ins["needle_id"] = $data["needle_id"];
        $ins["realm_synopsis"] = emoji_encode($data["realm_synopsis"]);
        $ins["solicit_origin"] = emoji_encode($data["solicit_origin"]);
        $ins["user_id"] = $data["uid"];
        $ins["is_gnaw_qulord"] = $data["is_gnaw_qulord"];
        $ins["attention"] = $data["attention"];
        $ins["found_lasting"] = time();
        $ins["much_id"] = $data["much_id"];
        $red = Db::name("territory_petition")->insert($ins);
        if ($red) {
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "申请失败！"];
            return json_encode($rs);
        }
    }
    public function get_search_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $where = [];
        $where["p.study_type"] = ["in", ["0", "1"]];
        $where["p.study_title|p.study_content"] = ["like", "%" . emoji_encode($data["search"]) . "%"];
        $page = $data["page"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where($where)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name")->order("p.adapter_time desc")->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "48";
                    } else {
                        $list[$k]["image_length"] = "31.5";
                    }
                }
                $list[$k]["adapter_time"] = formatTime($v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
            }
            $rs["info"] = $list;
        } else {
            $rs["info"] = [];
        }
        $map["realm_name"] = ["like", "%" . emoji_encode($data["search"]) . "%"];
        $territory = Db::name("territory")->where($map)->where("status", 1)->order("concern desc")->select();
        $rs["is_search_yes"] = 0;
        foreach ($territory as $k => $v) {
            $territory[$k]["concern"] = formatNumber($v["concern"]);
            $territory[$k]["paper_count"] = formatNumber($this->get_territory_papo_count($v["id"]));
            if (emoji_encode($data["search"]) == $v["realm_name"]) {
                $rs["is_search_yes"] = 1;
            }
        }
        $rs["territory"] = $territory;
        return json_encode($rs);
    }
    public function get_tj_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $page = $data["page"];
        $user_trailing = Db::name("user_trailing")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->field("tory_id")->select();
        $id_arr = [];
        foreach ($user_trailing as $a => $b) {
            $id_arr[$a] = $b["tory_id"];
        }
        $list = Db::name("territory")->where("much_id", $data["much_id"])->where("id", "not in", $id_arr)->page($page, "20")->select();
        foreach ($list as $k => $v) {
            $paper = Db::name("paper")->where("tory_id", $v["id"])->where("whether_type", "0")->where("study_status", "1")->field("image_part")->where("image_part", "not NULL")->order("adapter_time desc")->limit(5)->select();
            $img = [];
            foreach ($paper as $a => $b) {
                $img[$a] = json_decode($b["image_part"], true)[0];
            }
            $list[$k]["img"] = $img;
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_my_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $where = [];
        $page = $data["index_page"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where("p.user_id", $data["id"])->where($where)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name")->order("p.adapter_time desc")->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "47";
                    } else {
                        $list[$k]["image_length"] = "30.5";
                    }
                }
                $list[$k]["adapter_time"] = date("Y-m-d", $v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
            }
            $res = array();
            foreach ($list as $key => $val) {
                $res[$val["adapter_time"]][] = $val;
            }
            $re = [];
            foreach ($res as $ke => $va) {
                $re[]["time"] = $ke;
                foreach ($re as $a => $v) {
                    foreach ($va as $key => $value) {
                        if ($v["time"] == $value["adapter_time"]) {
                            $re[$a]["list"] = $va;
                        }
                    }
                }
            }
            foreach ($re as $k => $v) {
                $time = explode("-", $v["time"]);
                $re[$k]["month"] = numToWord($time[1]) . "月";
                $re[$k]["day"] = $time[2];
            }
            $rs["info"] = $re;
        } else {
            $rs["info"] = [];
        }
        return json_encode($rs);
    }
    public function get_user_territory_interest()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $list = Db::name("territory_interest")->alias("t")->join("user u", "t.user_id=u.id")->where("t.much_id", $data["much_id"])->where("t.status", 0)->where("t.tory_id", $data["id"])->page($data["page"], "30")->field("t.*,u.user_head_sculpture,u.user_nick_name,u.gender")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["sult_time"] = date("Y-m-d H:i:s", $v["sult_time"]);
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["reason"] = emoji_decode($v["reason"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function add_territory_interest()
    {
        $data = input("param.");
        $territory_interest = Db::name("territory_interest")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        $tory_info = Db::name("territory")->where("id", $territory_interest["tory_id"])->where("much_id", $data["much_id"])->find();
        if ($territory_interest["status"] > 0) {
            $rs = ["status" => "error", "msg" => "该用户已经审核！"];
            return json_encode($rs);
        }
        Db::startTrans();
        try {
            $territory_up = Db::name("territory_interest")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["rest_time" => time(), "status" => $data["status"]]);
            if (!$territory_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "操作失败！"];
                return json_encode($rs);
            }
            if ($data["status"] == 1) {
                $territory_user = Db::name("user_trailing")->insert(["user_id" => $territory_interest["user_id"], "tory_id" => $territory_interest["tory_id"], "much_id" => $data["much_id"], "ling_time" => time()]);
                if (!$territory_user) {
                    Db::rollback();
                    $rs = ["status" => "error", "msg" => "操作失败！"];
                    return json_encode($rs);
                }
            }
            Db::name("territory")->where("id", $territory_interest["tory_id"])->where("much_id", $data["much_id"])->setInc("concern");
            Db::commit();
            $this->add_template(["much_id" => $data["much_id"], "at_id" => "AT0330", "user_id" => $territory_interest["user_id"], "page" => "yl_welore/pages/packageA/circle_info/index?id=" . $territory_interest["tory_id"], "keyword1" => "申请加入:" . emoji_decode($tory_info["realm_name"]), "keyword2" => $data["status"] == 1 ? "申请通过" : "申请拒绝", "keyword3" => date("Y年m月d日 H:i:s")]);
            $rs = ["status" => "success", "msg" => "操作成功！"];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "操作失败！"];
            return json_encode($rs);
        }
    }
    public function get_follow_fansi()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        if ($data["type"] == 1) {
            $list = Db::name("user_track")->alias("t")->join("user u", "u.id=t.qu_user_id")->where("t.at_user_id", $data["uid"])->where("t.much_id", $data["much_id"])->order("t.fo_time desc")->field("u.id,u.user_head_sculpture,u.user_nick_name,u.autograph,u.gender")->page($data["page"], "20")->select();
        }
        if ($data["type"] == 2) {
            $list = Db::name("user_track")->alias("t")->join("user u", "u.id=t.at_user_id")->where("t.qu_user_id", $data["uid"])->where("t.much_id", $data["much_id"])->order("t.fo_time desc")->field("u.id,u.user_head_sculpture,u.user_nick_name,u.autograph,u.gender")->page($data["page"], "20")->select();
        }
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["autograph"] = emoji_decode($v["autograph"]);
            }
        }
        $rs["info"] = $list;
        $rs["num"] = count($list);
        return json_encode($rs);
    }
    public function get_territory_papo_count($id)
    {
        $count = Db::name("paper")->where("whether_delete", 0)->where("tory_id", $id)->where("study_status", 1)->count();
        return $count;
    }
    public function get_user_trailing($uid, $tory_id)
    {
        $info = Db::name("user_trailing")->where("tory_id", $tory_id)->where("user_id", $uid)->find();
        if ($info) {
            return true;
        } else {
            return false;
        }
    }
    public function get_page_user($p_id)
    {
        $info = Db::name("paper")->where("id", $p_id)->find();
        return $info;
    }
    public function get_user_applaud($id)
    {
        $info = Db::name("paper_reply")->where("id", $id)->find();
        return $this->get_page_user($info["paper_id"]);
    }
    public function img_upload()
    {
        $uniacid = input("param.much_id");
        $up = new Upload($uniacid);
        $code = $up->operate();
        if ($code["status"] == "success") {
            $code["msg"] = "上传成功！";
        } else {
            $code["msg"] = "上传错误！";
        }
        return json_encode($code);
    }
    public function get_user_vip($uid)
    {
        $user_info = Db::name("user")->where("id", $uid)->find();
        if ($user_info["vip_end_time"] > time()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function check_user_vip()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($user_info["vip_end_time"] > time()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function set_arr_dx()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $rs["info"] = array_reverse($data["arr"]);
        return json_encode($rs);
    }
    public function get_ad()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $info = Db::name("advertise")->where("much_id", $data["much_id"])->find();
        $info_sw = Db::name("polling")->where("status", 1)->where("much_id", $data["much_id"])->order("scores asc")->select();
        $info_zf = Db::name("reissue")->where("much_id", $data["much_id"])->find();
        $rs["info"] = $info;
        $rs["info_sw"] = $info_sw;
        $rs["info_zf"] = $info_zf;
        return json_encode($rs);
    }
    public function get_user_info_my()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $user = Db::name("user")->where("much_id", $data["much_id"])->where("id", $data["uid"])->find();
        $user["is_vip"] = $this->get_user_vip($user["id"]);
        $trailing = Db::name("user_trailing")->where("user_id", $data["uid"])->count();
        $user["trailing"] = formatNumber($trailing);
        $user_track = Db::name("user_track")->where("at_user_id", $data["uid"])->count();
        $user["user_track"] = formatNumber($user_track);
        $user_fs = Db::name("user_track")->where("qu_user_id", $data["uid"])->count();
        $user["user_fs"] = formatNumber($user_fs);
        $is_user = Db::name("user_track")->where("at_user_id", $data["this_uid"])->where("qu_user_id", $data["uid"])->count();
        $user["is_user"] = $is_user > 0 ? 1 : $is_user;
        $user["user_nick_name"] = emoji_decode($user["user_nick_name"]);
        $user["autograph"] = emoji_decode($user["autograph"]);
        $rs["info"] = $user;
        return json_encode($rs);
    }
    public function get_user_cancel()
    {
        $data = input("param.");
        if ($data["is_user"] == 1) {
            $del = Db::name("user_track")->where("at_user_id", $data["this_uid"])->where("qu_user_id", $data["uid"])->where("much_id", $data["much_id"])->delete();
            if ($del) {
                $rs = ["status" => "success", "msg" => "取消关注成功！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "取消关注失败！"];
                return json_encode($rs);
            }
        }
        $ins = Db::name("user_track")->insert(["at_user_id" => $data["this_uid"], "qu_user_id" => $data["uid"], "much_id" => $data["much_id"], "fo_time" => time()]);
        if ($ins) {
            $rs = ["status" => "success", "msg" => "关注成功！"];
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "关注失败！"];
            return json_encode($rs);
        }
    }
    public function get_qq_info()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $info = Db::name("territory")->where("much_id", $data["much_id"])->where("id", $data["id"])->find();
        $learned = Db::name("territory_learned")->where("much_id", $data["much_id"])->where("tory_id", $data["id"])->find();
        $da_qq = [];
        $this_da_qq = 0;
        if (!empty($learned["bulord"])) {
            $arr = json_decode($learned["bulord"]);
            foreach ($arr as $k => $v) {
                if ($v == $data["openid"]) {
                    $this_da_qq = 1;
                }
                $da_qq[$k] = $this->get_openId_user($v, $data["much_id"]);
            }
        }
        $xiao_qq = [];
        $this_xiao_qq = 0;
        if (!empty($learned["sulord"])) {
            $arr = json_decode($learned["sulord"]);
            foreach ($arr as $k => $v) {
                if ($v == $data["openid"]) {
                    $this_xiao_qq = 1;
                }
                $xiao_qq[$k] = $this->get_openId_user($v, $data["much_id"]);
            }
        }
        $info["da_qq"] = $da_qq;
        $info["xiao_qq"] = $xiao_qq;
        $info["this_da_qq"] = $this_da_qq;
        $info["this_xiao_qq"] = $this_xiao_qq;
        $info["realm_name"] = emoji_decode($info["realm_name"]);
        $info["realm_synopsis"] = emoji_decode($info["realm_synopsis"]);
        $info["atcipher"] = emoji_decode($info["atcipher"]);
        $rs["info"] = $info;
        return json_encode($rs);
    }
    public function get_openId_user($open_id, $much_id)
    {
        if (empty($open_id)) {
            return '';
        }
        $user_info = Db::name("user")->where("much_id", $much_id)->where("user_wechat_open_id", $open_id)->find();
        $user_info["user_nick_name"] = emoji_decode($user_info["user_nick_name"]);
        $user_info["autograph"] = emoji_decode($user_info["autograph"]);
        return $user_info;
    }
    public function check_qq($open_id, $tory_id)
    {
        $this_qq = "no";
        $learned = Db::name("territory_learned")->where("tory_id", $tory_id)->find();
        $json_da = json_decode($learned["bulord"], true);
        foreach ($json_da as $k => $v) {
            if ($v == $open_id) {
                $this_qq = "da";
            }
        }
        $json_xiao = json_decode($learned["sulord"], true);
        foreach ($json_xiao as $k => $v) {
            if ($v == $open_id) {
                $this_qq = "xiao";
            }
        }
        return $this_qq;
    }
    public function add_territory_learned()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $learned = Db::name("territory_learned")->where("much_id", $data["much_id"])->where("tory_id", $data["id"])->find();
        if ($learned) {
            if (count(json_decode($learned["bulord"])) == 3) {
                $rs = ["status" => "error", "msg" => "圈主人数已达上限！"];
                return json_encode($rs);
            }
            if (count(json_decode($learned["sulord"])) == 10) {
                $rs = ["status" => "error", "msg" => "管理员人数已达上限！"];
                return json_encode($rs);
            }
            if ($data["shenqing_type"] == "da") {
                $json_to_arr = json_decode($learned["snvite_bulord"], true);
                if (!empty($json_to_arr)) {
                    foreach ($json_to_arr as $k => $v) {
                        if ($v["openid"] == $data["openid"]) {
                            $rs = ["status" => "error", "msg" => "您已经申请圈主，请耐心等待！"];
                            return json_encode($rs);
                        }
                    }
                    array_push($json_to_arr, ["openid" => $data["openid"], "upshot" => emoji_encode($data["upshot"])]);
                } else {
                    $json_to_arr[] = ["openid" => $data["openid"], "upshot" => emoji_encode($data["upshot"])];
                }
                $update = Db::name("territory_learned")->where("much_id", $data["much_id"])->where("tory_id", $data["id"])->update(["snvite_bulord" => json_encode($json_to_arr)]);
            } else {
                if (empty($learned["envite_sulord"])) {
                    $json_to_arr[] = ["openid" => $data["openid"], "upshot" => emoji_encode($data["upshot"])];
                } else {
                    $json_to_arr = json_decode($learned["envite_sulord"], true);
                    foreach ($json_to_arr as $k => $v) {
                        if ($v["openid"] == $data["openid"]) {
                            $rs = ["status" => "error", "msg" => "您已经申请管理员，请耐心等待！"];
                            return json_encode($rs);
                        }
                    }
                    array_push($json_to_arr, ["openid" => $data["openid"], "upshot" => emoji_encode($data["upshot"])]);
                }
                $update = Db::name("territory_learned")->where("much_id", $data["much_id"])->where("tory_id", $data["id"])->update(["envite_sulord" => json_encode($json_to_arr)]);
            }
            if ($update) {
                $rs = ["status" => "success", "msg" => "申请成功！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "申请失败！"];
                return json_encode($rs);
            }
        } else {
            $arrr[] = ["openid" => $data["openid"], "upshot" => emoji_encode($data["upshot"])];
            $ins["tory_id"] = $data["id"];
            $ins["snvite_bulord"] = json_encode($arrr);
            $ins["envite_sulord"] = '';
            $ins["bulord"] = '';
            $ins["sulord"] = '';
            $ins["much_id"] = $data["much_id"];
            $add = Db::name("territory_learned")->insert($ins);
            if ($add) {
                $rs = ["status" => "success", "msg" => "申请成功！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "申请失败！"];
                return json_encode($rs);
            }
        }
    }
    public function do_banned_user()
    {
        $data = input("param.");
        $chech = Db::name("user_banned")->where("tory_id", $data["tory_id"])->where("user_id", $data["user_id"])->where("much_id", $data["much_id"])->find();
        if (!empty($chech) && $chech["refer_time"] > time()) {
            $rs = ["status" => "error", "msg" => "该用户已被禁言，解除时间：" . date("Y-m-d H:i:s", $chech["refer_time"])];
            return json_encode($rs);
        }
        $d = [];
        if (empty($chech)) {
            $d["tory_id"] = $data["tory_id"];
            $d["refer_id"] = $data["uid"];
            $d["refer_type"] = $data["refer_type"] == "da" ? 1 : 2;
            $d["user_id"] = $data["user_id"];
            $d["beget"] = emoji_encode($data["beget"]);
            $d["refer_time"] = time() + $data["day"] * 86400;
            $d["much_id"] = $data["much_id"];
            $ins = Db::name("user_banned")->insert($d);
            if ($ins) {
                $rs = ["status" => "success", "msg" => "禁言成功"];
            } else {
                $rs = ["status" => "error", "msg" => "禁言失败，请稍候重试"];
            }
            return json_encode($rs);
        }
        if (!empty($chech) && $chech["refer_time"] < time()) {
            $d["refer_id"] = $data["uid"];
            $d["refer_type"] = $data["refer_type"] == "da" ? 1 : 2;
            $d["beget"] = emoji_encode($data["beget"]);
            $d["refer_time"] = time() + $data["day"] * 86400;
            $d["much_id"] = $data["much_id"];
            $ins = Db::name("user_banned")->where("id", $chech["id"])->update($d);
            if ($ins) {
                $rs = ["status" => "success", "msg" => "禁言成功"];
            } else {
                $rs = ["status" => "error", "msg" => "禁言失败，请稍候重试"];
            }
            return json_encode($rs);
        }
        $msg = "由于：" . emoji_encode($data["beget"]) . "被管理员禁言，禁言解除时间" . date("Y-m-d H:i:s", $d["refer_time"]) . "，如有疑问请到服务中心申诉";
        $this->add_user_smail($data["uid"], $msg, $data["much_id"]);
    }
    public function get_user_amount()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $where = [];
        if ($data["evaluate"] == "tab1") {
            $where["evaluate"] = ["eq", 0];
        } else {
            $where["evaluate"] = ["eq", 1];
        }
        $list = Db::name("user_amount")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->page($data["page"], "20")->order("ruins_time desc")->where($where)->select();
        foreach ($list as $k => $v) {
            $list[$k]["ruins_time"] = date("Y-m-d H:i:s", $v["ruins_time"]);
        }
        $raws_setting = Db::name("raws_setting")->where("much_id", $data["much_id"])->find();
        $rs["info"] = $list;
        $rs["setting"] = $raws_setting;
        return json_encode($rs);
    }
    public function get_help_info()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("help")->where("much_id", $data["much_id"])->order("scores")->select();
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_help_info_desc()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("help")->where("much_id", $data["much_id"])->where("id", $data["id"])->find();
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_authority()
    {
        $data = input("param.");
        $info = Db::name("authority")->where("much_id", $data["much_id"])->find();
        return json_encode($info);
    }
    public function get_forward()
    {
        $data = input("param.");
        $info = Db::name("reissue")->where("much_id", $data["much_id"])->find();
        return json_encode($info);
    }
    public function get_user_banned()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_banned")->alias("b")->join("territory t", "t.id=b.tory_id")->where("b.user_id", $data["uid"])->where("b.much_id", $data["much_id"])->field("b.*,t.realm_name")->select();
        foreach ($list as $a => $b) {
            $user_is_mutter = Db::name("user_mutter")->where("much_id", $data["much_id"])->where("tory_id", $b["tory_id"])->where("user_id", $data["uid"])->where("ban_id", $b["id"])->where("status", 0)->count();
            $user_mutter_list = Db::name("user_mutter")->where("much_id", $data["much_id"])->where("tory_id", $b["tory_id"])->where("user_id", $data["uid"])->where("ban_id", $b["id"])->select();
            $list[$a]["user_is_mutter"] = $user_is_mutter;
            $list[$a]["user_mutter_list"] = $user_mutter_list;
            $list[$a]["beget"] = emoji_decode($b["beget"]);
            $list[$a]["reason_refusal"] = emoji_decode($b["reason_refusal"]);
            $list[$a]["realm_name"] = emoji_decode($b["realm_name"]);
            if ($b["refer_time"] != 0) {
                $list[$a]["refer_time"] = date("Y年m月d日 H:i:s", $b["refer_time"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function do_user_mutter()
    {
        $data = input("param.");
        $user_is_mutter = Db::name("user_mutter")->where("much_id", $data["much_id"])->where("tory_id", $data["tory_id"])->where("user_id", $data["uid"])->where("ban_id", $data["id"])->where("status", 0)->count();
        if ($user_is_mutter > 0) {
            $rs = ["status" => "error", "msg" => "您已经申诉，请耐心等待！"];
            return json_encode($rs);
        }
        $dd["user_id"] = $data["uid"];
        $dd["tory_id"] = $data["tory_id"];
        $dd["ban_id"] = $data["id"];
        $dd["beget"] = emoji_encode($data["beget"]);
        $dd["mute_time"] = time();
        $dd["status"] = 0;
        $dd["much_id"] = $data["much_id"];
        $dd["mute_type"] = 0;
        $dd["reason_refusal"] = '';
        $ins = Db::name("user_mutter")->insert($dd);
        if ($ins) {
            $rs = ["status" => "success", "msg" => "申诉成功！"];
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "申诉失败，请稍候重试！"];
            return json_encode($rs);
        }
    }
    public function get_user_paper_del()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $where = [];
        if ($data["del_type"] == "tab1") {
            $where["p.whether_type"] = ["eq", 1];
        }
        if ($data["del_type"] == "tab2") {
            $where["p.whether_type"] = ["eq", 2];
        }
        if ($data["del_type"] == "tab3") {
            $where["p.whether_type"] = ["eq", 4];
        }
        if ($data["del_type"] == "tab4") {
            $where["p.whether_type"] = ["eq", 3];
        }
        if ($data["del_type"] == "tab5") {
            $reject_reason = Db::name("paper")->alias("p")->join("territory t", "p.tory_id=t.id")->where("p.user_id", $data["uid"])->where("p.much_id", $data["much_id"])->where("p.study_status", 2)->field("p.*,t.realm_name")->select();
            foreach ($reject_reason as $k => $v) {
                $reject_reason[$k]["is_reply"] = 3;
                $reject_reason[$k]["study_title"] = emoji_decode($v["study_title"]);
                $reject_reason[$k]["study_content"] = emoji_decode($v["study_content"]);
                $reject_reason[$k]["reject_reason"] = emoji_decode($v["reject_reason"]);
                $reject_reason[$k]["prove_time"] = date("Y-m-d H:i:s", $v["prove_time"]);
            }
            $rs["info"] = $reject_reason;
            return json_encode($rs);
        }
        $paper = Db::name("paper")->alias("p")->join("territory t", "p.tory_id=t.id")->where("p.user_id", $data["uid"])->where("p.much_id", $data["much_id"])->where($where)->field("p.*,t.realm_name")->select();
        foreach ($paper as $k => $v) {
            $paper[$k]["is_reply"] = 0;
            $paper[$k]["study_title"] = emoji_decode($v["study_title"]);
            $paper[$k]["study_content"] = emoji_decode($v["study_content"]);
            $paper[$k]["whether_reason"] = emoji_decode($v["whether_reason"]);
            $paper[$k]["whetd_time"] = date("Y-m-d H:i:s", $v["whetd_time"]);
            $paper[$k]["is_complaint"] = Db::name("paper_complaint")->where("user_id", $data["uid"])->where("tale_type", 2)->where("paper_id", $v["id"])->where("tory_id", $v["tory_id"])->where("acceptance_status", 0)->count();
            $paper[$k]["is_complaint_list"] = Db::name("paper_complaint")->where("user_id", $data["uid"])->where("tale_type", 2)->where("paper_id", $v["id"])->where("tory_id", $v["tory_id"])->order("petition_time desc")->select();
        }
        $paper_reply = Db::name("paper_reply")->alias("p")->where("p.user_id", $data["uid"])->where("p.much_id", $data["much_id"])->where($where)->field("p.*")->select();
        if (!empty($paper_reply)) {
            foreach ($paper_reply as $k => $v) {
                $paper_reply[$k]["is_reply"] = 1;
                $paper_reply[$k]["study_title"] = emoji_decode($this->get_user_applaud($v["id"])["study_title"]);
                $paper_reply[$k]["study_content"] = emoji_decode($this->get_user_applaud($v["id"])["study_content"]);
                $paper_reply[$k]["tory_id"] = $this->get_user_applaud($v["id"])["tory_id"];
                $paper_reply[$k]["apter_time"] = date("Y-m-d H:i:s", $v["apter_time"]);
                $paper_reply[$k]["is_complaint"] = Db::name("paper_complaint")->where("user_id", $data["uid"])->where("tale_type", 3)->where("prely_id", $v["id"])->where("acceptance_status", 0)->count();
                $paper_reply[$k]["is_complaint_list"] = Db::name("paper_complaint")->where("user_id", $data["uid"])->where("tale_type", 3)->where("prely_id", $v["id"])->order("petition_time desc")->select();
                $paper[] = $paper_reply[$k];
            }
        }
        $rs["info"] = $paper;
        return json_encode($rs);
    }
    public function do_paper_mutter()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        if ($data["is_reply"] == 0) {
            $check = Db::name("paper_complaint")->where("tale_type", 2)->where("paper_id", $data["id"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->where("acceptance_status", 0)->find();
            if ($check) {
                $rs = ["status" => "error", "msg" => "您已经申诉过，请耐心等待！"];
                return json_encode($rs);
            }
            $ins["user_id"] = $data["uid"];
            $ins["tale_type"] = 2;
            $ins["paper_id"] = $data["id"];
            $ins["tory_id"] = $data["tory_id"];
            $ins["tale_content"] = emoji_encode($data["tale_content"]);
            $ins["acceptance_status"] = 0;
            $ins["is_strike"] = 1;
            $ins["petition_time"] = time();
            $ins["tale_instruct"] = '';
            $ins["much_id"] = $data["much_id"];
            $ins_data = Db::name("paper_complaint")->insert($ins);
            if ($ins_data) {
                $rs = ["status" => "success", "msg" => "申诉成功，请耐心等待！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "申诉失败请稍候重试！"];
                return json_encode($rs);
            }
        }
        if ($data["is_reply"] == 1) {
            $check = Db::name("paper_complaint")->where("tale_type", 3)->where("paper_id", $data["id"])->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->where("acceptance_status", 0)->find();
            if ($check) {
                $rs = ["status" => "error", "msg" => "您已经申诉过，请耐心等待！"];
                return json_encode($rs);
            }
            $ins["user_id"] = $data["uid"];
            $ins["tale_type"] = 3;
            $ins["paper_id"] = '';
            $ins["prely_id"] = $data["id"];
            $ins["tory_id"] = $this->get_user_applaud($data["id"])["tory_id"];
            $ins["tale_content"] = emoji_encode($data["tale_content"]);
            $ins["acceptance_status"] = 0;
            $ins["is_strike"] = 0;
            $ins["petition_time"] = time();
            $ins["tale_instruct"] = '';
            $ins["much_id"] = $data["much_id"];
            $ins_data = Db::name("paper_complaint")->insert($ins);
            if ($ins_data) {
                $rs = ["status" => "success", "msg" => "申诉成功，请耐心等待！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "申诉失败请稍候重试！"];
                return json_encode($rs);
            }
        }
    }
    public function get_user_report()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $where = [];
        if ($data["is_type"] == "tab1") {
            $where["c.tale_type"] = ["eq", 0];
        } else {
            $where["c.tale_type"] = ["eq", 1];
        }
        $list = Db::name("paper_complaint")->alias("c")->join("territory t", "c.tory_id=t.id")->where("c.user_id", $data["uid"])->where("c.much_id", $data["much_id"])->where($where)->field("c.*,t.realm_name")->select();
        foreach ($list as $k => $v) {
            $list[$k]["tale_content"] = emoji_decode($v["tale_content"]);
            $list[$k]["petition_time"] = date("Y-m-d H:i:s", $v["petition_time"]);
            $list[$k]["realm_name"] = emoji_decode($v["realm_name"]);
            if ($data["is_type"] == "tab1") {
                $list[$k]["paper"] = $this->get_paper($v["paper_id"]);
            } else {
                $list[$k]["paper"] = $this->get_paper($this->get_user_applaud($v["prely_id"])["id"]);
                $list[$k]["paper_reply"] = $this->paper_reply($v["prely_id"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_my_rec()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_subsidy")->alias("s")->join("user u", "s.con_user_id=u.id")->where("s.much_id", $data["much_id"])->where("s.sel_user_id", $data["uid"])->page($data["page"], 30)->field("s.*,u.user_head_sculpture,u.user_nick_name")->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["bute_time"] = date("Y-m-d H:i", $v["bute_time"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function user_reward()
    {
        $data = input("param.");
        $tribute_taxation = Db::name("tribute_taxation")->where("much_id", $data["much_id"])->find();
        $li_wu = Db::name("tribute")->where("id", $data["li_id"])->where("much_id", $data["much_id"])->find();
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $conch = $data["num"] * $li_wu["tr_conch"];
        if ($user_info["conch"] < $conch) {
            $rs = ["status" => "error", "msg" => $this->design["currency"] . "不足，请充值！"];
            return json_encode($rs);
        }
        $is["much_id"] = $data["much_id"];
        $is["con_user_id"] = $data["uid"];
        $is["sel_user_id"] = $data["user_id"];
        $is["bute_name"] = $data["num"] . "个" . $li_wu["tr_name"];
        $is["bute_price"] = $li_wu["tr_conch"];
        $is["allow_scale"] = 1 - $tribute_taxation["taxing"];
        $is["bute_time"] = time();
        $fraction = $conch * $is["allow_scale"] * 10;
        Db::startTrans();
        try {
            $uid_amount = $this->add_user_amount($data["uid"], 2, $conch, "购买赠送礼物", $data["much_id"], $is["allow_scale"]);
            if (!$uid_amount) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return json_encode($rs);
            }
            $user_amount = $this->add_user_amount($data["user_id"], 3, $conch, "获赠礼物收益并扣除手续费", $data["much_id"], $is["allow_scale"]);
            if (!$user_amount) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return json_encode($rs);
            }
            $ins = Db::name("user_subsidy")->insert($is);
            if (!$ins) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return json_encode($rs);
            }
            $up = Db::name("user")->where("id", $data["uid"])->setDec("conch", $conch);
            if (!$up) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return json_encode($rs);
            }
            $up_user = Db::name("user")->where("id", $data["user_id"])->setInc("fraction", $fraction);
            if (!$up_user) {
                $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
                Db::rollback();
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "赠送成功！"];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "赠送失败，请稍候重试！"];
            return json_encode($rs);
        }
    }
    public function get_ji_bei()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($user_info["fraction"] < 1) {
            $rs = ["status" => "error", "msg" => "至少大于1" . $this->design["confer"]];
            return json_encode($rs);
        }
        $finance1 = $user_info["fraction"] / 10;
        $evaluate1["category"] = 1;
        $evaluate1["evaluate"] = 1;
        $evaluate1["finance"] = -$user_info["fraction"];
        $evaluate1["poem_conch"] = $user_info["fraction"];
        $evaluate1["surplus_conch"] = 0;
        $evaluate1["solution"] = $this->design["confer"] . "兑换" . $this->design["currency"] . "，" . $this->design["confer"] . "减少";
        $evaluate1["user_id"] = $data["uid"];
        $evaluate1["ruins_time"] = time();
        $evaluate1["much_id"] = $data["much_id"];
        $evaluate0["category"] = 1;
        $evaluate0["evaluate"] = 0;
        $evaluate0["finance"] = $finance1;
        $evaluate0["poem_conch"] = $user_info["conch"];
        $evaluate0["surplus_conch"] = $user_info["conch"] + $finance1;
        $evaluate0["solution"] = $this->design["confer"] . "兑换" . $this->design["currency"] . "，" . $this->design["currency"] . "增加";
        $evaluate0["user_id"] = $data["uid"];
        $evaluate0["ruins_time"] = time();
        $evaluate0["much_id"] = $data["much_id"];
        Db::startTrans();
        try {
            $evaluate1_ins = Db::name("user_amount")->insert($evaluate1);
            if (!$evaluate1_ins) {
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！1"];
                Db::rollback();
                return json_encode($rs);
            }
            $evaluate0_ins = Db::name("user_amount")->insert($evaluate0);
            if (!$evaluate0_ins) {
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！2"];
                Db::rollback();
                return json_encode($rs);
            }
            $user_up = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["conch" => $evaluate0["surplus_conch"], "fraction" => 0]);
            if (!$user_up) {
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！3"];
                Db::rollback();
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "兑换成功！"];
            return json_encode($rs);
        } catch (\Exception $e) {
            $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！" . $e->getMessage()];
            Db::rollback();
            return json_encode($rs);
        }
    }
    public function add_user_amount($user_id, $category, $finance, $solution, $much_id, $tribute_taxation)
    {
        $user_info = Db::name("user")->where("id", $user_id)->where("much_id", $much_id)->find();
        $data["user_id"] = $user_id;
        $data["category"] = $category;
        $data["ruins_time"] = time();
        $data["solution"] = $solution;
        $data["much_id"] = $much_id;
        if ($category == 3) {
            $data["evaluate"] = 1;
            $data["finance"] = $finance * $tribute_taxation * 10;
            $data["poem_fraction"] = $user_info["fraction"];
            $data["surplus_fraction"] = $user_info["fraction"] + $finance * $tribute_taxation * 10;
        }
        if ($category == 2) {
            $data["evaluate"] = 0;
            $data["finance"] = -$finance;
            $data["poem_conch"] = $user_info["conch"];
            $data["surplus_conch"] = $user_info["conch"] - $finance;
        }
        $ins = Db::name("user_amount")->insert($data);
        if ($ins) {
            return true;
        } else {
            return false;
        }
    }
    public function get_paper($id)
    {
        $info = Db::name("paper")->where("id", $id)->find();
        $info["study_title"] = emoji_encode($info["study_title"]);
        $info["study_content"] = emoji_encode($info["study_content"]);
        $info["reject_reason"] = emoji_encode($info["reject_reason"]);
        $info["whether_reason"] = emoji_encode($info["whether_reason"]);
        $info["image_part"] = json_decode($info["image_part"], true);
        return $info;
    }
    public function paper_reply($id)
    {
        $info = Db::name("paper_reply")->where("id", $id)->find();
        $info["reply_content"] = emoji_encode($info["reply_content"]);
        $info["whether_reason"] = emoji_encode($info["whether_reason"]);
        $info["image_part"] = json_decode($info["image_part"], true);
        return $info;
    }
    public function get_user_guard()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_subsidy")->alias("s")->join("user u", "s.con_user_id=u.id")->where("s.sel_user_id", $data["uid"])->group("s.con_user_id")->field("u.user_head_sculpture,u.user_nick_name,count(s.bute_price) as sub_count")->limit(10)->order("sub_count desc,s.id desc")->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
            }
        }
        $rs["count"] = Db::name("user_subsidy")->where("sel_user_id", $data["uid"])->where("much_id", $data["much_id"])->count();
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function user_mastert()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $da = Db::name("territory_learned")->alias("l")->join("territory t", "l.tory_id=t.id")->where("l.bulord", "like", "%" . $data["openid"] . "%")->field("t.*")->where("l.much_id", $data["much_id"])->select();
        foreach ($da as $k => $v) {
            $da[$k]["is_type"] = "da";
        }
        $xiao = Db::name("territory_learned")->alias("l")->join("territory t", "l.tory_id=t.id")->where("l.sulord", "like", "%" . $data["openid"] . "%")->field("t.*")->where("l.much_id", $data["much_id"])->select();
        foreach ($xiao as $k => $v) {
            $xiao[$k]["is_type"] = "xiao";
        }
        $rs["info"] = array_merge($da, $xiao);
        $rs["user_info"] = $this->get_openId_user($data["openid"], $data["much_id"]);
        return json_encode($rs);
    }
    public function get_envite_sulord()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("territory_learned")->where("tory_id", $data["id"])->where("much_id", $data["much_id"])->find();
        $json = json_decode($list["envite_sulord"], true);
        $user = [];
        foreach ($json as $k => $v) {
            $user[$k]["upshot"] = emoji_decode($v["upshot"]);
            $user[$k]["user_info"] = $this->get_openId_user($v["openid"], $data["much_id"]);
        }
        $rs["info"] = $user;
        return json_encode($rs);
    }
    public function add_envite_sulord()
    {
        $rs = ["status" => "success", "msg" => "任命成功！"];
        $data = input("param.");
        $check = Db::name("territory_learned")->where("tory_id", $data["id"])->where("much_id", $data["much_id"])->find();
        $json = json_decode($check["sulord"], true);
        if (count($json) >= 10) {
            $rs = ["status" => "error", "msg" => "管理员最多10位！"];
            return json_encode($rs);
        }
        $json_s = json_decode($check["envite_sulord"], true);
        foreach ($json_s as $k => $v) {
            if ($v["openid"] == $data["user_openid"]) {
                unset($json_s[$k]);
            }
        }
        if (empty($json)) {
            $json = [$data["user_openid"]];
        } else {
            array_push($json, $data["user_openid"]);
        }
        Db::startTrans();
        try {
            $up_s = Db::name("territory_learned")->where("id", $check["id"])->update(["envite_sulord" => json_encode(array_values($json_s))]);
            $up_d = Db::name("territory_learned")->where("id", $check["id"])->update(["sulord" => json_encode($json)]);
            if (!$up_s || !$up_d) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "任命失败！"];
                return json_encode($rs);
            }
            Db::commit();
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "任命失败！"];
            return json_encode($rs);
        }
    }
    public function add_tc_submit()
    {
        $rs = ["status" => "success", "msg" => "投诉成功！"];
        $data = input("param.");
        $msg = '';
        if ($data["user_type"] == 0) {
            $msg = "(" . $this->design["landgrave"] . ")";
            $check2 = Db::name("lament")->where("ment_type", 0)->where("proof_id", $data["uid"])->where("tory_id", $data["id"])->where("much_id", $data["much_id"])->find();
            if ($check2) {
                $rs = ["status" => "error", "msg" => "已经投诉过该" . $this->design["landgrave"] . "了！"];
                return json_encode($rs);
            }
        }
        if ($data["user_type"] == 1 || $data["user_type"] == 2) {
            $msg = "(用户)";
            $check1 = Db::name("lament")->where("proof_id", $data["uid"])->where("user_id", $data["user_id"])->where("much_id", $data["much_id"])->find();
            if ($check1) {
                $rs = ["status" => "error", "msg" => "已经投诉过该用户了！"];
                return json_encode($rs);
            }
        }
        Db::startTrans();
        try {
            $up_msg = Db::name("prompt_msg")->insertGetId(["msg_time" => time(), "type" => 1, "retter" => "新的投诉" . $msg, "status" => 0, "much_id" => $data["much_id"]]);
            $dd["proof_id"] = $data["uid"];
            $dd["mopt_id"] = $up_msg;
            $dd["ment_type"] = $data["user_type"];
            $dd["tory_id"] = $data["id"];
            $dd["labor"] = $data["labor"];
            $dd["user_id"] = $data["user_id"];
            $dd["ment_caption"] = emoji_encode($data["get_tc_text"]);
            $dd["status"] = 0;
            $dd["ment_time"] = time();
            $dd["much_id"] = $data["much_id"];
            $ins = Db::name("lament")->insert($dd);
            if (!$ins) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "投诉失败，请稍候重试！"];
                return json_encode($rs);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "投诉失败，请稍候重试！"];
            return json_encode($rs);
        }
        $vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $data["much_id"])->count("*");
        cache("vacants_" . $data["much_id"], $vacants);
        return json_encode($rs);
    }
    public function get_user_smail()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_smail")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->order("clue_time desc")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["maring"] = emoji_decode($v["maring"]);
                $list[$k]["clue_time"] = date("Y-m-d H:i:s", $v["clue_time"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function up_user_smail()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $rr = Db::name("user_smail")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["status" => 1]);
        if (!$rr) {
            $rs = ["status" => "error", "msg" => "失败，请稍候重试！"];
            return json_encode($rs);
        }
        return json_encode($rs);
    }
    public function del_user_smail()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $rr = Db::name("user_smail")->where("id", $data["id"])->where("much_id", $data["much_id"])->delete();
        if (!$rr) {
            $rs = ["status" => "error", "msg" => "失败，请稍候重试！"];
            return json_encode($rs);
        }
        return json_encode($rs);
    }
    public function up_user_smail_all()
    {
        $rs = ["status" => "success", "msg" => "标记成功！"];
        $data = input("param.");
        $rr = Db::name("user_smail")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->update(["status" => 1]);
        if ($rr !== false) {
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "标记失败，请稍候重试！"];
            return json_encode($rs);
        }
    }
    public function add_user_smail($uid, $maring, $much_id)
    {
        $d["user_id"] = $uid;
        $d["maring"] = $maring;
        $d["much_id"] = $much_id;
        $d["clue_time"] = time();
        $is = Db::name("user_smail")->insert($d);
        return $is;
    }
    public function get_user_banned_qq()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("user_banned")->alias("b")->join("user u", "u.id=b.user_id")->where("b.tory_id", $data["id"])->where("b.much_id", $data["much_id"])->field("b.id,b.refer_time,b.beget,u.user_head_sculpture,u.user_nick_name")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]["beget"] = emoji_decode($v["beget"]);
                $list[$k]["refer_time"] = date("Y-m-d H:i:s", $v["refer_time"]);
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function jie_user_banned()
    {
        $rs = ["status" => "success", "msg" => "解除成功！"];
        $data = input("param.");
        $update = Db::name("user_banned")->where("id", $data["id"])->where("much_id", $data["much_id"])->delete();
        if (!$update) {
            $rs = ["status" => "error", "msg" => "解除失败，请稍候重试！"];
            return json_encode($rs);
        }
        return json_encode($rs);
    }
    public function get_user_status()
    {
        $data = input("param.");
        $update = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        return $update["status"];
    }
    public function get_shop_type()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $update = Db::name("shop_type")->where("status", 1)->where("much_id", $data["much_id"])->order("scores")->select();
        $rs["info"] = $update;
        $rs["user"] = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->field("conch")->find();
        return json_encode($rs);
    }
    public function get_shop_list()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("shop")->where("status", 1)->where("much_id", $data["much_id"])->where("product_type", $data["type_id"])->order("scores")->page($data["page"], "15")->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]["product_img"] = json_decode($v["product_img"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_goods()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $list = Db::name("shop")->where("status", 1)->where("much_id", $data["much_id"])->where("id", $data["id"])->find();
        if (!empty($list)) {
            $list["product_img"] = json_decode($list["product_img"]);
            $list["is_vip"] = $this->get_user_vip($data["uid"]);
            $rs["info"] = $list;
        } else {
            $rs = ["status" => "error", "msg" => "商品已下架！"];
        }
        return json_encode($rs);
    }
    public function exchange_goods()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $info = Db::name("shop")->where("status", 1)->where("much_id", $data["much_id"])->where("id", $data["id"])->find();
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($info["product_price"] > $user_info["conch"]) {
            $rs = ["status" => "error", "msg" => $this->design["currency"] . "不足！"];
            return json_encode($rs);
        }
        if ($info["noble_exclusive"] == 1) {
            $is_vip = $this->get_user_vip($data["uid"]);
            if ($is_vip == 0) {
                $rs = ["status" => "error", "msg" => "您还不是会员！"];
                return json_encode($rs);
            }
        }
        if ($info["product_restrict"] > 0) {
            $check_user_order = Db::name("shop_order")->where("user_id", $data["uid"])->where("product_id", $data["id"])->where("much_id", $data["much_id"])->count();
            if ($info["product_restrict"] <= $check_user_order) {
                $rs = ["status" => "error", "msg" => "您已经兑换超限！"];
                return json_encode($rs);
            }
        }
        if ($info["open_discount"] == 1) {
            $money = $info["noble_discount"] * $info["product_price"];
            $c_money = floor($money * 100) / 100;
            if ($c_money > $user_info["conch"]) {
                $rs = ["status" => "error", "msg" => $this->design["currency"] . "不足！"];
                return json_encode($rs);
            }
        }
        return json_encode($rs);
    }
    public function exchange_goods_do()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if (empty($data["real_name"])) {
            $rs = ["status" => "error", "msg" => "收货人不能为空！"];
            return json_encode($rs);
        }
        if (empty($data["phone"])) {
            $rs = ["status" => "error", "msg" => "联系电话不能为空！"];
            return json_encode($rs);
        }
        if (empty($data["address"])) {
            $rs = ["status" => "error", "msg" => "收货地址不能为空！"];
            return json_encode($rs);
        }
        $is_vip = $this->get_user_vip($data["uid"]);
        $good_info = Db::name("shop")->where("much_id", $data["much_id"])->where("id", $data["id"])->find();
        if ($good_info["open_discount"] == 1 && $is_vip == 1) {
            $money = $good_info["noble_discount"] * $good_info["product_price"];
            $c_money = floor($money * 100) / 100;
        } else {
            $c_money = $good_info["product_price"];
        }
        $order["order_number"] = time() . rand(99999, 1000000);
        $order["user_id"] = $data["uid"];
        $order["product_id"] = $data["id"];
        $order["product_img"] = athumbnail($good_info["product_img"]);
        $order["product_name"] = $good_info["product_name"];
        $order["product_price"] = $good_info["product_price"];
        $order["remark"] = emoji_encode($data["remark"]);
        $order["buy_time"] = time();
        $order["buyer_name"] = $data["real_name"];
        $order["buyer_address"] = $data["address"];
        $order["buyer_phone"] = $data["phone"];
        $order["actual_price"] = $c_money;
        $order["is_noble"] = $is_vip;
        if ($good_info["open_discount"] == 1) {
            $order["product_discount"] = $good_info["noble_discount"];
        }
        if ($good_info["noble_rebate"] > 0 && $is_vip == 1) {
            $order["product_rebate"] = $good_info["noble_rebate"];
        }
        $order["much_id"] = $data["much_id"];
        Db::startTrans();
        try {
            $result = true;
            $ins_order = Db::name("shop_order")->insert($order);
            if (!$ins_order) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！"];
                return json_encode($rs);
            }
            $bk["user_id"] = $data["uid"];
            $bk["category"] = 2;
            $bk["finance"] = -$c_money;
            $bk["poem_conch"] = $user_info["conch"];
            $bk["surplus_conch"] = $user_info["conch"] - $c_money;
            $bk["ruins_time"] = time();
            $bk["solution"] = "兑换商品";
            $bk["evaluate"] = 0;
            $bk["much_id"] = $data["much_id"];
            $ins_bk = Db::name("user_amount")->insert($bk);
            if (!$ins_bk) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！2"];
                return json_encode($rs);
            }
            $u_up["conch"] = $bk["surplus_conch"];
            $user_update = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update($u_up);
            if ($user_update === false) {
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！4"];
                return json_encode($rs);
            }
            $user_update_add = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["buyer_name" => $data["real_name"], "buyer_phone" => $data["phone"], "buyer_address" => $data["address"]]);
            if ($user_update_add === false) {
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！5"];
                return json_encode($rs);
            }
            $goods_up = Db::name("shop")->where("much_id", $data["much_id"])->where("id", $data["id"])->setDec("product_inventory");
            if (!$goods_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！2"];
                return json_encode($rs);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！" . $e->getMessage()];
            return json_encode($rs);
        }
        Db::name("prompt_msg")->insert(["msg_time" => time(), "type" => 0, "retter" => "用户购买了" . $good_info["product_name"], "status" => 0, "much_id" => $data["much_id"]]);
        $notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $data["much_id"])->count("*");
        cache("notices_" . $data["much_id"], $notices);
        if ($result == true) {
            $rs = ["status" => "success", "msg" => "兑换成功！"];
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "兑换失败，请稍候重试！"];
            return json_encode($rs);
        }
    }
    public function get_order_list()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $where = [];
        if ($data["order_type"] == "tab1") {
            $where["status"] = ["eq", "0"];
        }
        if ($data["order_type"] == "tab2") {
            $where["status"] = ["eq", "1"];
        }
        if ($data["order_type"] == "tab3") {
            $where["status"] = ["eq", "2"];
        }
        if ($data["order_type"] == "tab4") {
            $where["status"] = ["eq", "3"];
        }
        if ($data["order_type"] == "tab5") {
            $where["status"] = ["eq", "4"];
        }
        $list = Db::name("shop_order")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->page($data["page"], "10")->order("buy_time desc")->where($where)->select();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $list[$k]["buy_time"] = date("Y-m-d H:i:s", $v["buy_time"]);
            }
        }
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function get_my_order()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $order_info = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($order_info) {
            $order_info["remark"] = emoji_decode($order_info["remark"]);
            $order_info["buy_time"] = date("Y-m-d H:i:s", $order_info["buy_time"]);
            if (!empty($order_info["ship_time"])) {
                $order_info["ship_time"] = date("Y-m-d H:i:s", $order_info["ship_time"]);
            }
        }
        $rs["info"] = $order_info;
        return json_encode($rs);
    }
    public function order_refund()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $order_info = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($order_info["status"] == 3 || $order_info["status"] == 4) {
            $rs = ["status" => "error", "msg" => "当前订单已不能申请退款！"];
            return json_encode($rs);
        }
        Db::startTrans();
        try {
            $result = true;
            $o["status"] = 2;
            $o["reason_refund"] = emoji_encode($data["refund_text"]);
            $o["refund_count"] = 1;
            $o_up = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->update($o);
            if (!$o_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "申请退货失败，请稍候重试"];
                return json_encode($rs);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "申请退货失败，请稍候重试"];
            return json_encode($rs);
        }
        Db::name("prompt_msg")->insert(["msg_time" => time(), "type" => 0, "retter" => $user_info["user_nick_name"] . "发起了退款，订单号" . $order_info["order_number"], "status" => 0, "much_id" => $data["much_id"]]);
        $notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $data["much_id"])->count("*");
        cache("notices_" . $data["much_id"], $notices);
        if ($result == true) {
            $rs = ["status" => "success", "msg" => "申请成功！"];
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "申请退货失败，请稍候重试"];
            return json_encode($rs);
        }
    }
    public function refund_del_do()
    {
        $data = input("param.");
        $order_info = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        Db::startTrans();
        try {
            if (empty($order_info["ship_time"])) {
                $o["status"] = 0;
            } else {
                $o["status"] = 1;
            }
            $o_up = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->update($o);
            if (!$o_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "取消退货失败，请稍候重试"];
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "取消成功！"];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "取消退货失败，请稍候重试" . $e->getMessage()];
            return json_encode($rs);
        }
    }
    public function ok_mod_do()
    {
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $order_info = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($order_info["status"] == 4) {
            $rs = ["status" => "error", "msg" => "当前订单已完成"];
            return json_encode($rs);
        }
        Db::startTrans();
        try {
            if ($order_info["product_rebate"] != 0 && $order_info["is_noble"] == 1) {
                $jf["user_id"] = $data["uid"];
                $jf["category"] = 3;
                $jf["finance"] = $order_info["product_rebate"];
                $jf["poem_fraction"] = $user_info["fraction"];
                $jf["surplus_fraction"] = $user_info["fraction"] + $order_info["product_rebate"];
                $jf["ruins_time"] = time();
                $jf["solution"] = "确认收货赠送" . $this->design["confer"];
                $jf["evaluate"] = 1;
                $jf["much_id"] = $data["much_id"];
                $ins_jf = Db::name("user_amount")->insert($jf);
                if (!$ins_jf) {
                    Db::rollback();
                    $rs = ["status" => "error", "msg" => "确认收货失败，请稍候重试1"];
                    return json_encode($rs);
                }
                $user_up = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["fraction" => $jf["surplus_fraction"]]);
                if (!$user_up) {
                    Db::rollback();
                    $rs = ["status" => "error", "msg" => "确认收货失败，请稍候重试2"];
                    return json_encode($rs);
                }
            }
            $o_up = Db::name("shop_order")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["status" => 4]);
            if (!$o_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "确认收货失败，请稍候重试2"];
                return json_encode($rs);
            }
            $smail = Db::name("user_smail")->insert(["user_id" => $data["uid"], "maring" => "已完成收货，感谢您的惠顾，再见！", "clue_time" => time(), "status" => 0, "much_id" => $data["much_id"]]);
            if (!$smail) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "确认收货失败，请稍候重试2"];
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "确认收货成功！"];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "确认收货失败，请稍候重试2"];
            return json_encode($rs);
        }
    }
    public function get_diy()
    {
        $json = ["style" => ["backcolor" => "#ffffff", "font_color" => "#A7A8A5", "font_color_active" => "#2FA0DF"], "home" => ["title" => "首页", "images" => ["img" => "../../style/icon/1.png", "img_active" => "../../style/icon/1.png"]], "plaza" => ["title" => "广场", "images" => ["img" => "../../style/icon/2.png", "img_active" => "../../style/icon/2.png"]], "release" => ["title" => "发布", "images" => ["img" => "../../style/icon/home_add.png", "img_active" => "../../style/icon/home_add.png"]], "goods" => ["title" => "小商品", "images" => ["img" => "../../style/icon/3.png", "img_active" => "../../style/icon/3.png"]], "user" => ["title" => "我的", "images" => ["img" => "../../style/icon/4.png", "img_active" => "../../style/icon/4.png"]]];
        $data = input("param.");
        $diy = Db::name("design")->where("much_id", $data["much_id"])->find();
        if (empty($diy)) {
            $diy["confer"] = "积分";
            $diy["currency"] = "贝壳";
            $diy["landgrave"] = "圈子";
            $diy["home_title"] = "首页";
            $frist = mb_substr($diy["landgrave"], 0, 1, "utf-8");
            $diy["qq_name"] = $frist;
        } else {
            $frist = mb_substr($diy["landgrave"], 0, 1, "utf-8");
            $diy["qq_name"] = $frist;
            if (!empty($diy["pattern_data"])) {
                $json = json_decode($diy["pattern_data"], true);
                foreach ($json as $k => $v) {
                    if ($k[$v] == "home") {
                        $json[$k]["home"]["title"] = emoji_decode($v["home"]["title"]);
                    }
                    if ($k[$v] == "plaza") {
                        $json[$k]["plaza"]["title"] = emoji_decode($v["plaza"]["title"]);
                    }
                    if ($k[$v] == "release") {
                        $json[$k]["release"]["title"] = emoji_decode($v["release"]["title"]);
                    }
                    if ($k[$v] == "goods") {
                        $json[$k]["goods"]["title"] = emoji_decode($v["goods"]["title"]);
                    }
                    if ($k[$v] == "user") {
                        $json[$k]["user"]["title"] = emoji_decode($v["user"]["title"]);
                    }
                }
                if (!strpos($diy["pattern_data"], "release")) {
                    $json["release"] = ["title" => "发布", "images" => ["img" => "../../style/icon/home_add.png", "img_active" => "../../style/icon/home_add.png"]];
                }
            }
        }
        $diy["pattern_data"] = $json;
        $diy["version"] = $this->version;
        return json_encode($diy);
    }
    public function withdraw()
    {
        $data = input("param.");
        $wxcom = new WxCompany();
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $setting = Db::name("raws_setting")->where("much_id", $data["much_id"])->find();
        if ($setting["open_offline_payment"] == 1) {
            if (empty($setting["payment_tariff"])) {
                $rs = ["status" => "error", "msg" => "请输入正确的银行卡号！"];
                return json_encode($rs);
            }
        }
        if (!is_numeric($data["withdraw_money"])) {
            $rs = ["status" => "error", "msg" => "请输入正确的金额！"];
            return json_encode($rs);
        }
        $moeny = sprintf("%.2f", $data["withdraw_money"] - $data["withdraw_money"] * $setting["payment_tariff"]);
        if ($setting["lowest_money"] > $moeny) {
            $rs = ["status" => "error", "msg" => "金额不满足最低提现金额！"];
            return json_encode($rs);
        }
        if ($data["withdraw_money"] > $user_info["conch"]) {
            $rs = ["status" => "error", "msg" => "用户余额不足！"];
            return json_encode($rs);
        }
        Db::startTrans();
        try {
            $data_withdraw["user_id"] = $data["uid"];
            $data_withdraw["user_account"] = $data["withdraw_number"];
            $data_withdraw["display_money"] = $data["withdraw_money"];
            $data_withdraw["tariff"] = $setting["payment_tariff"];
            $data_withdraw["actual_amount"] = $moeny;
            $data_withdraw["withdraw_type"] = $setting["open_offline_payment"];
            $data_withdraw["much_id"] = $data["much_id"];
            if ($setting["auto_review_payment"] == 1) {
                $data_withdraw["verify_time"] = time();
                $data_withdraw["status"] = 1;
            } else {
                $data_withdraw["seek_time"] = time();
                $data_withdraw["status"] = 0;
            }
            $withdraw_ins = Db::name("user_withdraw_money")->insertGetId($data_withdraw);
            if (!$withdraw_ins) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "提现失败，请稍候重试！"];
                return json_encode($rs);
            }
            $amount["user_id"] = $data["uid"];
            $amount["category"] = 1;
            $amount["finance"] = -$data["withdraw_money"];
            $amount["poem_conch"] = $user_info["conch"] - $data["withdraw_money"];
            $amount["surplus_conch"] = 0;
            $amount["ruins_time"] = time();
            $amount["solution"] = "提现";
            $amount["evaluate"] = 0;
            $amount["much_id"] = $data["much_id"];
            $amount_ins = Db::name("user_amount")->insert($amount);
            if (!$amount_ins) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "提现失败，请稍候重试！"];
                return json_encode($rs);
            }
            $user_update = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["conch" => $amount["poem_conch"]]);
            if (!$user_update) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "提现失败，请稍候重试！"];
                return json_encode($rs);
            }
            if ($setting["open_offline_payment"] == 0 && $setting["auto_review_payment"] == 1) {
                $wxcom->payurl = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
                $result = $wxcom->companyToPocket($user_info["user_wechat_open_id"], $moeny, '', "提现", '', $data["much_id"]);
                if ($result["status"] == 0) {
                    $rs = ["status" => "success", "msg" => "提现成功！"];
                } else {
                    Db::rollback();
                    $rs = ["status" => "error", "msg" => $result["msg"]];
                    return json_encode($rs);
                }
            } else {
                $rs = ["status" => "success", "msg" => "审核通过后，即可提现成功！"];
            }
            $apiclientCert = EXTEND_PATH . "Wxpay" . DS . "Cert" . DS . "apiclient_cert_" . $data["much_id"] . ".pem";
            $apiclientKey = EXTEND_PATH . "Wxpay" . DS . "Cert" . DS . "apiclient_key_" . $data["much_id"] . ".pem";
            @unlink($apiclientCert);
            @unlink($apiclientKey);
            Db::commit();
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "提现失败，请稍候重试！" . $e->getMessage()];
            return json_encode($rs);
        }
    }
    public function get_raws_setting()
    {
        $data = input("param.");
        $setting = Db::name("raws_setting")->where("much_id", $data["much_id"])->find();
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $setting["user_info"] = $user_info;
        return json_encode($setting);
    }
    public function get_withdraw_list()
    {
        $data = input("param.");
        $list = Db::name("user_withdraw_money")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->page($data["page"], "20")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                if (!empty($v["seek_time"])) {
                    $list[$k]["seek_time"] = date("Y-m-d H:i:s", $v["seek_time"]);
                }
                if (!empty($v["verify_time"])) {
                    $list[$k]["verify_time"] = date("Y-m-d H:i:s", $v["verify_time"]);
                }
            }
        }
        return json_encode($list);
    }
    public function base64EncodeImage()
    {
        $data = input("param.");
        $img = $data["img"];
        $imageInfo = getimagesize($img);
        $base64 = '' . chunk_split(base64_encode(file_get_contents($img)));
        return "data:" . $imageInfo["mime"] . ";base64," . chunk_split(base64_encode(file_get_contents($img)));
    }
    public function qrcode()
    {
        $data = input("param.");
        $paper_info = Db::name("paper")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if (cache("fatal_" . $data["much_id"])) {
            $getConfig = cache("fatal_" . $data["much_id"]);
        } else {
            $getConfig = Db::name("config")->where("much_id", $data["much_id"])->find();
            if ($getConfig) {
                foreach ($getConfig as $key => $value) {
                    if ($key != "id" && $key != "pay_react" && $key != "much_id") {
                        $getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
                    }
                }
                cache("fatal_" . $data["much_id"], $getConfig);
            }
        }
        if (cache("access_token_" . $data["much_id"])) {
            $exp = json_decode(cache("access_token_" . $data["much_id"]));
            if ($exp["expires_in"] < time()) {
                $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
                $json_access_token = file_get_contents($url_access_token);
                $arr_access_token = json_decode($json_access_token, true);
                $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
                cache("access_token_" . $data["much_id"], $arr_access_token);
                $access_token = $arr_access_token["access_token"];
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
                $data = array("page" => "yl_welore/pages/packageA/article/index", "scene" => $data["id"] . "-" . $paper_info["study_type"], "is_hyaline" => true);
                $result = $this->_requestPost($url, json_encode($data));
            } else {
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $exp["access_token"];
                $data = array("page" => "yl_welore/pages/packageA/article/index", "scene" => $data["id"] . "-" . $paper_info["study_type"], "is_hyaline" => true);
                $result = $this->_requestPost($url, json_encode($data));
            }
        } else {
            $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
            $json_access_token = file_get_contents($url_access_token);
            $arr_access_token = json_decode($json_access_token, true);
            $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
            cache("access_token_" . $data["much_id"], $arr_access_token);
            $access_token = $arr_access_token["access_token"];
            $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
            $data = array("page" => "yl_welore/pages/packageA/article/index", "scene" => $data["id"] . "-" . $paper_info["study_type"], "is_hyaline" => true);
            $result = $this->_requestPost($url, json_encode($data));
        }
        return $result;
    }
    public function qrcode_code()
    {
        $data = input("param.");
        if (cache("fatal_" . $data["much_id"])) {
            $getConfig = cache("fatal_" . $data["much_id"]);
        } else {
            $getConfig = Db::name("config")->where("much_id", $data["much_id"])->find();
            if ($getConfig) {
                foreach ($getConfig as $key => $value) {
                    if ($key != "id" && $key != "pay_react" && $key != "much_id") {
                        $getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
                    }
                }
                cache("fatal_" . $data["much_id"], $getConfig);
            }
        }
        if (cache("access_token_" . $data["much_id"])) {
            $exp = json_decode(cache("access_token_" . $data["much_id"]));
            if ($exp["expires_in"] < time()) {
                $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
                $json_access_token = file_get_contents($url_access_token);
                $arr_access_token = json_decode($json_access_token, true);
                $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
                cache("access_token_" . $data["much_id"], $arr_access_token);
                $access_token = $arr_access_token["access_token"];
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
                $data = array("page" => "yl_welore/pages/packageC/user_invitation/index", "scene" => $data["uid"], "is_hyaline" => true);
                $result = $this->_requestPost($url, json_encode($data));
            } else {
                $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $exp["access_token"];
                $data = array("page" => "yl_welore/pages/packageC/user_invitation/index", "scene" => $data["uid"], "is_hyaline" => true);
                $result = $this->_requestPost($url, json_encode($data));
            }
        } else {
            $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
            $json_access_token = file_get_contents($url_access_token);
            $arr_access_token = json_decode($json_access_token, true);
            $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
            cache("access_token_" . $data["much_id"], $arr_access_token);
            $access_token = $arr_access_token["access_token"];
            $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $access_token;
            $data = array("page" => "yl_welore/pages/packageC/user_invitation/index", "scene" => $data["uid"], "is_hyaline" => true);
            $result = $this->_requestPost($url, json_encode($data));
        }
        return $result;
    }
    public function add_template($data)
    {
        if (cache("fatal_" . $data["much_id"])) {
            $getConfig = cache("fatal_" . $data["much_id"]);
        } else {
            $getConfig = Db::name("config")->where("much_id", $data["much_id"])->find();
            if ($getConfig) {
                foreach ($getConfig as $key => $value) {
                    if ($key != "id" && $key != "pay_react" && $key != "much_id") {
                        $getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
                    }
                }
                cache("fatal_" . $data["much_id"], $getConfig);
            }
        }
        if (cache("access_token_" . $data["much_id"])) {
            $exp = json_decode(cache("access_token_" . $data["much_id"]));
            if ($exp["expires_in"] < time()) {
                $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
                $json_access_token = file_get_contents($url_access_token);
                $arr_access_token = json_decode($json_access_token, true);
                $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
                cache("access_token_" . $data["much_id"], $arr_access_token);
                $access_token = $arr_access_token["access_token"];
            } else {
                $access_token = $exp["access_token"];
            }
        } else {
            $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
            $json_access_token = file_get_contents($url_access_token);
            $arr_access_token = json_decode($json_access_token, true);
            $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
            cache("access_token_" . $data["much_id"], $arr_access_token);
            $access_token = $arr_access_token["access_token"];
        }
        $tmpl_url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
        $user_form_id = Db::name("user_form_info")->where("user_id", $data["user_id"])->where("much_id", $data["much_id"])->order("create_time desc")->find();
        $tmpl_sql = Db::name("mouldboard")->where("much_id", $data["much_id"])->find();
        $json = json_decode($tmpl_sql["prototype_data"], true);
        if ($data["at_id"] == "AT2310") {
            $tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT2310"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
        }
        if ($data["at_id"] == "AT2295") {
            $tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT2295"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
        }
        if ($data["at_id"] == "AT1803") {
            $tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT1803"], "page" => $data["page"], "form_id" => $user_form_id["formid"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]], "keyword4" => ["value" => $data["keyword4"]]));
        }
        if ($data["at_id"] == "AT0330") {
            $tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT0330"], "form_id" => $user_form_id["formid"], "page" => $data["page"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]]));
        }
        if ($data["at_id"] == "AT1235") {
            $tmpl_data = array("touser" => $user_form_id["open_id"], "template_id" => $json["AT1235"], "form_id" => $user_form_id["formid"], "page" => $data["page"], "data" => array("keyword1" => ["value" => $data["keyword1"]], "keyword2" => ["value" => $data["keyword2"]], "keyword3" => ["value" => $data["keyword3"]], "keyword4" => ["value" => $data["keyword4"]]));
        }
        $result = $this->_requestPost($tmpl_url, json_encode($tmpl_data));
        $error_json = json_decode($result, true);
        if ($error_json["errcode"] == 0) {
            Db::name("user_form_info")->where("id", $user_form_id["id"])->delete();
        }
        return $error_json["errcode"];
    }
    public function add_form_id()
    {
        $data = input("param.");
        $dd["user_id"] = $data["uid"];
        $dd["open_id"] = $data["openid"];
        $dd["formid"] = preg_replace("# #", '', $data["form_id"]);
        $dd["much_id"] = $data["much_id"];
        $dd["create_time"] = time();
        Db::name("user_form_info")->insert($dd);
        Db::name("user_form_info")->where("formid", "theformIdisamockone")->delete();
    }
    public function open_atence()
    {
        $data = input("param.");
        $info = Db::name("territory")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($data["atcipher_type"] == 0) {
            $up_data["atence"] = 1;
            if (empty($info["atcipher"])) {
                $up_data["atcipher"] = $this->get_ah_random();
            }
            $up = Db::name("territory")->where("id", $data["id"])->where("much_id", $data["much_id"])->update($up_data);
            if ($up) {
                $rs = ["status" => "success", "msg" => "开启成功！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "开启失败！"];
                return json_encode($rs);
            }
        } else {
            $up = Db::name("territory")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["atence" => 0]);
            if ($up) {
                $rs = ["status" => "success", "msg" => "关闭成功！"];
                return json_encode($rs);
            } else {
                $rs = ["status" => "error", "msg" => "关闭失败！"];
                return json_encode($rs);
            }
        }
    }
    public function update_atcipher()
    {
        $data = input("param.");
        $info = Db::name("territory")->where("id", $data["id"])->where("much_id", $data["much_id"])->find();
        if ($info["atcipher"] == emoji_encode($data["this_atcipher"])) {
            $rs = ["status" => "error", "msg" => "没有做任何更改！"];
            return json_encode($rs);
        }
        $up = Db::name("territory")->where("id", $data["id"])->where("much_id", $data["much_id"])->update(["atcipher" => emoji_encode(preg_replace("# #", '', $data["this_atcipher"]))]);
        if ($up) {
            $rs = ["status" => "success", "msg" => "更改成功！"];
            return json_encode($rs);
        } else {
            $rs = ["status" => "error", "msg" => "更改失败！"];
            return json_encode($rs);
        }
    }
    public function get_ah_random()
    {
        $len = 8;
        $chars = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $str = '';
        $i = 0;
        while ($i < $len) {
            $str .= $chars[mt_rand(0, $charsLen)];
            $i++;
        }
        return $str;
    }
    public function get_yzm_random($len = 6)
    {
        $chars = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $str = '';
        $i = 0;
        while ($i < $len) {
            $str .= $chars[mt_rand(0, $charsLen)];
            $i++;
        }
        $check_yzm = Db::name("user_invitation_code")->where("code", $str)->find();
        if (!empty($check_yzm)) {
            $this->get_yzm_random(6);
        }
        return $str;
    }
    public function ger_user_code()
    {
        $data = input("param.");
        $info = Db::name("user_invitation_code")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if (empty($info)) {
            $yzm = $this->get_yzm_random(6);
            Db::name("user_invitation_code")->insert(["user_id" => $data["uid"], "code" => $yzm, "much_id" => $this->much_id]);
            $info = Db::name("user_invitation_code")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        }
        return $info["code"];
    }
    public function add_user_invitation()
    {
        $data = input("param.");
        if (empty($data["yzm_text"])) {
            $rs = ["status" => "error", "msg" => "内容不能为空！"];
            return json_encode($rs);
        }
        $yam_check = Db::name("user_invitation_code")->where("code", preg_replace("# #", '', $data["yzm_text"]))->where("much_id", $data["much_id"])->find();
        if (empty($yam_check)) {
            $rs = ["status" => "error", "msg" => "邀请码错误！"];
            return json_encode($rs);
        }
        $user_check_yzm = Db::name("user_respond_invitation")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if ($user_check_yzm) {
            $rs = ["status" => "error", "msg" => "您已经响应过朋友啦！"];
            return json_encode($rs);
        }
        $this_user_code = Db::name("user_invitation_code")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $lian_check = Db::name("user_respond_invitation")->where("user_id", $yam_check["user_id"])->where("re_code", $this_user_code["code"])->find();
        if ($lian_check) {
            $rs = ["status" => "error", "msg" => "不能互相邀请哦！"];
            return json_encode($rs);
        }
        $user_info = $this->get_user_invitation(preg_replace("# #", '', $data["yzm_text"]), $data["much_id"]);
        $this_user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $punch_range = Db::name("user_punch_range")->where("much_id", $data["much_id"])->find();
        $fraction = rand($punch_range["invite_min"] * 100, $punch_range["invite_max"] * 100) / 100;
        Db::startTrans();
        try {
            $respond_invitation = Db::name("user_respond_invitation")->insert(["user_id" => $data["uid"], "re_code" => preg_replace("# #", '', $data["yzm_text"]), "in_us_reward" => $fraction, "re_us_reward" => $fraction, "re_time" => time(), "much_id" => $data["much_id"]]);
            if (!$respond_invitation) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "验证失败"];
                return json_encode($rs);
            }
            $amount["user_id"] = $user_info["id"];
            $amount["category"] = 3;
            $amount["finance"] = $fraction;
            $amount["poem_fraction"] = $user_info["fraction"];
            $amount["surplus_fraction"] = $user_info["fraction"] + $fraction;
            $amount["ruins_time"] = time();
            $amount["solution"] = "邀请好友获得" . $this->design["confer"];
            $amount["evaluate"] = 1;
            $amount["much_id"] = $data["much_id"];
            $user_amount = Db::name("user_amount")->insert($amount);
            $user_up = Db::name("user")->where("id", $user_info["id"])->where("much_id", $data["much_id"])->update(["fraction" => $amount["surplus_fraction"]]);
            if (!$user_amount || !$user_up) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "验证失败"];
                return json_encode($rs);
            }
            $amount_d["user_id"] = $data["uid"];
            $amount_d["category"] = 3;
            $amount_d["finance"] = $fraction;
            $amount_d["poem_fraction"] = $this_user_info["fraction"];
            $amount_d["surplus_fraction"] = $this_user_info["fraction"] + $fraction;
            $amount_d["ruins_time"] = time();
            $amount_d["solution"] = "响应好友获得" . $this->design["confer"];
            $amount_d["evaluate"] = 1;
            $amount_d["much_id"] = $data["much_id"];
            $user_amount_d = Db::name("user_amount")->insert($amount_d);
            $user_up_d = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update(["fraction" => $amount_d["surplus_fraction"]]);
            if (!$user_amount_d || !$user_up_d) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "验证失败"];
                return json_encode($rs);
            }
            Db::commit();
            $rs = ["status" => "success", "msg" => "验证成功,恭喜获得" . $fraction . $this->design["confer"]];
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "验证失败"];
            return json_encode($rs);
        }
    }
    public function get_user_invitation($yzm, $much_id)
    {
        $user_invitation_code = Db::name("user_invitation_code")->where("code", $yzm)->where("much_id", $much_id)->find();
        $user_info = Db::name("user")->where("id", $user_invitation_code["user_id"])->where("much_id", $much_id)->find();
        return $user_info;
    }
    public function _requestPost($url, $data, $ssl = true)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "\r\n    Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4";
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if (false === $response) {
            echo "<br>", curl_error($curl), "<br>";
            return false;
        }
        curl_close($curl);
        return $response;
    }
    public function check_msg($msg, $much_id)
    {
        if (cache("fatal_" . $much_id)) {
            $getConfig = cache("fatal_" . $much_id);
        } else {
            $getConfig = Db::name("config")->where("much_id", $much_id)->find();
            if ($getConfig) {
                foreach ($getConfig as $key => $value) {
                    if ($key != "id" && $key != "pay_react" && $key != "much_id") {
                        $getConfig[$key] = authcode($getConfig[$key], "DECODE", "YuluoNetwork", 0);
                    }
                }
                cache("fatal_" . $much_id, $getConfig);
            }
        }
        if (cache("access_token_" . $much_id)) {
            $exp = json_decode(cache("access_token_" . $much_id));
            if ($exp["expires_in"] < time()) {
                $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
                $json_access_token = file_get_contents($url_access_token);
                $arr_access_token = json_decode($json_access_token, true);
                $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
                cache("access_token_" . $much_id, $arr_access_token);
                $access_token = $arr_access_token["access_token"];
            } else {
                $access_token = $exp["access_token"];
            }
        } else {
            $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $getConfig["app_id"] . "&secret=" . $getConfig["app_secret"];
            $json_access_token = file_get_contents($url_access_token);
            $arr_access_token = json_decode($json_access_token, true);
            $arr_access_token["expires_in"] = $arr_access_token["expires_in"] + time();
            cache("access_token_" . $much_id, $arr_access_token);
            $access_token = $arr_access_token["access_token"];
        }
        $url = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token=" . $access_token;
        $result = $this->_requestPost($url, json_encode(array("content" => $msg), JSON_UNESCAPED_UNICODE));
        $error_json = json_decode($result, true);
        return $error_json["errcode"];
    }
    public function get_post_notice()
    {
        $data = input("param.");
        $setting = Db::name("paper_smingle")->where("much_id", $data["much_id"])->find();
        return json_encode($setting);
    }
    public function get_paper_reply_info()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $info = Db::name("paper_reply")->alias("r")->join("user u", "u.id=r.user_id")->where("r.id", $data["id"])->where("r.much_id", $data["much_id"])->field("r.*,u.user_nick_name,u.user_head_sculpture")->find();
        if (!empty($info["image_part"])) {
            $info["image_part"] = json_decode($info["image_part"], true);
        }
        $info["reply_content"] = emoji_decode($info["reply_content"]);
        $info["user_nick_name"] = emoji_decode($info["user_nick_name"]);
        $info["apter_time"] = formatTime($info["apter_time"]);
        $info["hui_count"] = Db::name("paper_reply_duplex")->where("reply_id", $data["id"])->count();
        $info_list = Db::name("paper_reply_duplex")->alias("r")->join("user u", "u.id=r.user_id")->where("r.reply_id", $data["id"])->page($data["page"], "5")->select();
        if (!empty($info_list)) {
            foreach ($info_list as $k => $v) {
                $info_list[$k]["duplex_content"] = emoji_decode($v["duplex_content"]);
                $info_list[$k]["duplex_time"] = formatTime($v["duplex_time"]);
                $info_list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                if ($info_list[$k]["reply_user_id"] != 0) {
                    $user = Db::name("user")->where("id", $v["reply_user_id"])->where("much_id", $data["much_id"])->find();
                    $info_list[$k]["hui_nick_name"] = emoji_decode($user["user_nick_name"]);
                }
            }
        }
        $rs["info"] = $info;
        $rs["list"] = $info_list;
        return json_encode($rs);
    }
    public function add_paper_reply_duplex()
    {
        $rs = ["status" => "success", "msg" => "回复成功"];
        $data = input("param.");
        if (!empty($data["duplex_content"])) {
            $ms = $this->check_msg($data["duplex_content"], $data["much_id"]);
            if ($ms != 0) {
                $rs = ["status" => "error", "msg" => "内容含有违法违规内容"];
                return json_encode($rs);
            }
        }
        $info = Db::name("paper_reply")->alias("r")->join("user u", "u.id=r.user_id")->where("r.id", $data["id"])->where("r.much_id", $data["much_id"])->field("r.*,u.user_nick_name,u.user_head_sculpture")->find();
        $dd["user_id"] = $data["uid"];
        $dd["reply_id"] = $data["id"];
        $dd["duplex_content"] = emoji_encode($data["duplex_content"]);
        $dd["duplex_time"] = time();
        $dd["much_id"] = $data["much_id"];
        $dd["reply_user_id"] = $data["user_id"];
        $ins = Db::name("paper_reply_duplex")->insert($dd);
        if (!$ins) {
            $rs = ["status" => "error", "msg" => "回复失败"];
        }
        $check = Db::name("user_templet_history")->where("paper_id", $data["id"])->where("send_user_id", $data["uid"])->where("accept_user_id", $info["user_id"])->where("archetype_id", "AT1235")->where("much_id", $data["much_id"])->find();
        if ($info["user_id"] != $data["uid"]) {
            if (empty($check)) {
                if ($info["reply_type"] == 1) {
                    $keyword1 = "[语音]";
                }
                if ($info["reply_type"] == 0) {
                    if (empty($info["reply_content"])) {
                        $keyword1 = "[图片]";
                    } else {
                        if (empty($info["image_part"])) {
                            $keyword1 = emoji_decode($info["reply_content"]);
                        } else {
                            $keyword1 = emoji_decode($info["reply_content"]);
                        }
                    }
                }
                $this->add_template(["much_id" => $data["much_id"], "at_id" => "AT1235", "user_id" => $info["user_id"], "page" => "yl_welore/pages/packageA/article/index?id=" . $info["paper_id"], "keyword1" => $keyword1, "keyword2" => $data["duplex_content"], "keyword3" => emoji_decode($this->user_info["user_nick_name"]), "keyword4" => date("Y年m月d日 H:i:s")]);
            }
        }
        return json_encode($rs);
    }
    public function get_school_list()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $where = [];
        $order = "p.adapter_time desc";
        if (isset($data["tory_id"])) {
            $where["p.tory_id"] = ["eq", $data["tory_id"]];
            $where["p.topping_time"] = ["eq", 0];
        }
        if ($this->version == 1) {
            $where["p.study_type"] = ["in", ["0", "1"]];
        }
        $user_trailing = Db::name("user_trailing")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->select();
        $user_trailing_id = '';
        foreach ($user_trailing as $k => $v) {
            $user_trailing_id .= $v["tory_id"] . ",";
        }
        $user_trailing_id = substr($user_trailing_id, 0, -1);
        $q_tory = Db::name("territory")->whereNotIn("id", $user_trailing_id)->where("status", 1)->where("attention", 1)->where("much_id", $data["much_id"])->select();
        $q_tory_id = '';
        foreach ($q_tory as $k => $v) {
            $q_tory_id .= $v["id"] . ",";
        }
        $q_tory_id = substr($q_tory_id, 0, -1);
        $page = $data["index_page"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where("t.status", 1)->where($where)->whereNotIn("t.id", $q_tory_id)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name,u.user_wechat_open_id")->order($order)->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                if (isset($data["tory_id"])) {
                    $list[$k]["check_qq"] = $this->check_qq($v["user_wechat_open_id"], $v["tory_id"]);
                }
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "48";
                    } else {
                        $list[$k]["image_length"] = "31.5";
                    }
                }
                $list[$k]["adapter_time"] = formatTime($v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
                $list[$k]["school"] = $this->get_this_school($v["id"], $data["much_id"]);
            }
            $rs["info"] = $list;
        } else {
            $rs["info"] = [];
        }
        $rs["version"] = $this->version;
        return json_encode($rs);
    }
    public function get_school_list_tab3()
    {
        $rs = ["status" => "success", "msg" => "获取成功"];
        $data = input("param.");
        $where = [];
        if (isset($data["tory_id"])) {
            $where["p.tory_id"] = ["eq", $data["tory_id"]];
            $where["p.topping_time"] = ["eq", 0];
        }
        if ($this->version == 1) {
            $where["p.study_type"] = ["in", ["0", "1"]];
        }
        $user_trailing = Db::name("user_trailing")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->select();
        $user_trailing_id = '';
        foreach ($user_trailing as $k => $v) {
            $user_trailing_id .= $v["tory_id"] . ",";
        }
        $user_trailing_id = substr($user_trailing_id, 0, -1);
        $q_tory = Db::name("territory")->whereNotIn("id", $user_trailing_id)->where("status", 1)->where("attention", 1)->where("much_id", $data["much_id"])->select();
        $q_tory_id = '';
        foreach ($q_tory as $k => $v) {
            $q_tory_id .= $v["id"] . ",";
        }
        $q_tory_id = substr($q_tory_id, 0, -1);
        $page = $data["index_page"];
        $user_school = Db::name("user_school")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if (empty($user_school)) {
            $rs["info"] = [];
            return json_encode($rs);
        }
        $where["s.school_id"] = $data["school_id"];
        $list = Db::name("paper")->alias("p")->join("user u", "p.user_id=u.id")->join("territory t", "p.tory_id=t.id")->join("school_paper s", "s.paper_id=p.id")->where("p.whether_delete", "0")->where("p.study_status", "1")->where("p.much_id", $data["much_id"])->where("t.status", 1)->where($where)->whereNotIn("t.id", $q_tory_id)->field("p.*,u.gender,u.user_nick_name,u.user_head_sculpture,t.realm_name,u.user_wechat_open_id")->order("p.adapter_time desc")->page($page, "15")->select();
        if ($list) {
            foreach ($list as $k => $v) {
                if (isset($data["tory_id"])) {
                    $list[$k]["check_qq"] = $this->check_qq($v["user_wechat_open_id"], $v["tory_id"]);
                }
                $list[$k]["is_voice"] = false;
                $list[$k]["user_nick_name"] = emoji_decode($v["user_nick_name"]);
                $list[$k]["study_title"] = emoji_decode($v["study_title"]);
                $list[$k]["study_content"] = emoji_decode($v["study_content"]);
                $list[$k]["image_part"] = json_decode($v["image_part"], true);
                $ling = count(json_decode($v["image_part"], true));
                $list[$k]["study_heat"] = formatNumber($v["study_heat"]);
                $list[$k]["study_laud"] = formatNumber($v["study_laud"]);
                $list[$k]["study_repount"] = formatNumber($v["study_repount"]);
                $list[$k]["user_vip"] = $this->get_user_vip($v["user_id"]);
                if ($ling == 1) {
                    $list[$k]["image_length"] = "97.5";
                } else {
                    if ($ling == 2) {
                        $list[$k]["image_length"] = "48";
                    } else {
                        $list[$k]["image_length"] = "31.5";
                    }
                }
                $list[$k]["adapter_time"] = formatTime($v["adapter_time"]);
                $sc = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("user_id", $data["uid"])->where("paper_id", $v["id"])->count();
                $list[$k]["is_info_zan"] = $sc == 0 ? false : true;
                $count = Db::name("user_applaud")->where("much_id", $data["much_id"])->where("paper_id", $v["id"])->count();
                $list[$k]["info_zan_count"] = formatNumber($count);
                $list[$k]["school"] = $this->get_this_school($v["id"], $data["much_id"]);
            }
            if (!isset($data["tory_id"])) {
                $arr1 = array_map(create_function("\$n", "return \$n[\"info_zan_count\"];"), $list);
                array_multisort($arr1, SORT_DESC, $list);
            }
            $rs["info"] = $list;
        } else {
            $rs["info"] = [];
        }
        $rs["version"] = $this->version;
        return json_encode($rs);
    }
    public function get_school()
    {
        $rs = ["status" => "success", "msg" => "保存成功"];
        $data = input("param.");
        $check = Db::name("user_school")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
        if (empty($check)) {
            $rs["user_school"] = 0;
        } else {
            $rs["user_school"] = $check["school_id"];
            $school_info = Db::name("school")->where("id", $check["school_id"])->where("much_id", $data["much_id"])->find();
            $rs["user_school_name"] = $school_info["school_name"];
        }
        $list = Db::name("school")->where("much_id", $data["much_id"])->where("status", "1")->order("scores")->select();
        $rs["info"] = $list;
        return json_encode($rs);
    }
    public function edit_user_school_info()
    {
        $rs = ["status" => "success", "msg" => "保存成功"];
        $data = input("param.");
        $user_info = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->find();
        $user_list = Db::name("user")->where("id", "<>", $data["uid"])->where("much_id", $data["much_id"])->where("user_nick_name", emoji_encode($data["nick_name"]))->find();
        if ($user_list) {
            $rs = ["status" => "error", "msg" => "昵称已存在，换个吧"];
            return json_encode($rs);
        }
        if (emoji_encode($data["nick_name"]) != $user_info["user_nick_name"]) {
            $up["user_nick_name"] = emoji_encode($data["nick_name"]);
            $up["nick_name_time"] = emoji_encode($data["nick_name"]) == $user_info["user_nick_name"] ? 0 : time();
        }
        $up["user_head_sculpture"] = $data["img"];
        $up["gender"] = $data["gender"];
        $up["autograph"] = emoji_encode($data["autograph"]);
        $up["user_head_sculpture"] = $data["img"];
        Db::startTrans();
        try {
            $update = Db::name("user")->where("id", $data["uid"])->where("much_id", $data["much_id"])->update($up);
            if ($update === false) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "保存失败2"];
                return json_encode($rs);
            }
            $check = Db::name("user_school")->where("user_id", $data["uid"])->where("much_id", $data["much_id"])->find();
            if (empty($check)) {
                $ins = Db::name("user_school")->insert(["user_id" => $data["uid"], "school_id" => $data["school_id"], "much_id" => $data["much_id"]]);
            } else {
                $ins = Db::name("user_school")->where("id", $check["id"])->update(["user_id" => $data["uid"], "school_id" => $data["school_id"], "much_id" => $data["much_id"]]);
            }
            if ($ins === false) {
                Db::rollback();
                $rs = ["status" => "error", "msg" => "保存失败3"];
                return json_encode($rs);
            }
            Db::commit();
            return json_encode($rs);
        } catch (\Exception $e) {
            Db::rollback();
            $rs = ["status" => "error", "msg" => "保存失败" . $e->getMessage()];
            return json_encode($rs);
        }
    }
    public function get_user_school_info_my()
    {
        $rs = ["status" => "success", "msg" => "成功！"];
        $data = input("param.");
        $user = Db::name("user")->where("much_id", $data["much_id"])->where("id", $data["uid"])->find();
        $user["is_vip"] = $this->get_user_vip($user["id"]);
        $trailing = Db::name("user_trailing")->where("user_id", $data["uid"])->count();
        $user["trailing"] = formatNumber($trailing);
        $user_track = Db::name("user_track")->where("at_user_id", $data["uid"])->count();
        $user["user_track"] = formatNumber($user_track);
        $user_fs = Db::name("user_track")->where("qu_user_id", $data["uid"])->count();
        $user["user_fs"] = formatNumber($user_fs);
        $is_user = Db::name("user_track")->where("at_user_id", $data["this_uid"])->where("qu_user_id", $data["uid"])->count();
        $user["is_user"] = $is_user;
        $school = Db::name("user_school")->alias("u")->join("school s", "u.school_id=s.id")->where("u.user_id", $data["uid"])->where("u.much_id", $data["much_id"])->find();
        $user["user_nick_name"] = emoji_decode($user["user_nick_name"]);
        $user["autograph"] = emoji_decode($user["autograph"]);
        $user["school"] = $school;
        $rs["info"] = $user;
        return json_encode($rs);
    }
    public function add_school_circle()
    {
        $data = input("param.");
        $msg = '';
        if ($this->paper_smingle["auto_review"] == 0) {
            $msg = "等待审核";
        }
        $check_banned = Db::name("user_banned")->where("tory_id", $data["fa_class"])->where("user_id", $data["uid"])->where("much_id", $data["mch_id"])->find();
        if ($check_banned["refer_time"] > time()) {
            return json_encode(["status" => "error", "id" => 0, "msg" => "您已被禁言，解除时间:" . date("Y-m-d H:i:s", $check_banned["refer_time"])]);
        }
        if ($this->paper_smingle["number_limit"] != 0) {
            $check_today = Db::name("paper")->where("user_id", $this->user_info["id"])->whereTime("adapter_time", "today")->count();
            if ($check_today >= $this->paper_smingle["number_limit"]) {
                return json_encode(["status" => "error", "id" => 0, "msg" => "今日发帖已达上限！"]);
            }
        }
        $paper["study_type"] = $data["type"];
        $paper["user_id"] = $this->user_info["id"];
        $paper["tory_id"] = $data["fa_class"];
        $paper["study_title"] = emoji_encode($data["title"]);
        $paper["study_title_color"] = $data["color"];
        $paper["adapter_time"] = time();
        $paper["is_open"] = $data["is_open"];
        $paper["much_id"] = $data["mch_id"];
        if (!empty($data["img_arr"])) {
            $paper["image_part"] = json_encode($data["img_arr"]);
        }
        $paper["study_content"] = emoji_encode($data["content"]);
        $paper["study_status"] = $this->paper_smingle["auto_review"];
        if ($this->paper_smingle["auto_review"] == 1) {
            $paper["prove_time"] = time();
        }
        if ($data["type"] == 1) {
            $paper["study_voice"] = $data["user_file"];
            $paper["study_voice_time"] = $data["file_ss"];
        } else {
            if ($data["type"] == 2) {
                $paper["study_video"] = $data["user_file"];
            } else {
                if ($data["type"] == 0) {
                    $paper["study_voice"] = '';
                    $paper["study_video"] = '';
                }
            }
        }
        Db::startTrans();
        try {
            $res = Db::name("paper")->insertGetId($paper);
            if (!$res) {
                Db::rollback();
                return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！"]);
            }
            $user_sc_info = Db::name("user_school")->where("user_id", $data["uid"])->where("much_id", $data["mch_id"])->find();
            if (!empty($user_sc_info)) {
                $paper_sc = Db::name("school_paper")->insert(["paper_id" => $res, "school_id" => $user_sc_info["school_id"], "much_id" => $data["mch_id"]]);
                if (!$paper_sc) {
                    Db::rollback();
                    return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！"]);
                }
            }
            Db::commit();
            return json_encode(["status" => "success", "id" => $res, "msg" => "发布成功！" . $msg]);
        } catch (\Exception $e) {
            Db::rollback();
            return json_encode(["status" => "error", "id" => 0, "msg" => "发布失败，请稍候重试！" . $e->getMessage()]);
        }
    }
    public function get_this_school($paper_id, $much_id)
    {
        $paper = Db::name("school_paper")->where("paper_id", $paper_id)->where("much_id", $much_id)->find();
        if (empty($paper)) {
            return '';
        }
        $school = Db::name("school")->where("id", $paper["school_id"])->where("much_id", $much_id)->find();
        return $school;
    }
}