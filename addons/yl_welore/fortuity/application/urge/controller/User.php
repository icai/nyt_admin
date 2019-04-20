<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use app\api\service\TmplService;
use app\api\service\UserService;
use think\Db;
class User extends Base
{
    private function defaultQuery()
    {
        $urlFirst = request()->query();
        $urlSecond = explode("=/", $urlFirst);
        $urlThird = explode("&", $urlSecond[1]);
        $url = "/" . $urlThird[0];
        return $url;
    }
    public function index()
    {
        $url = self::defaultQuery();
        $hazy_name = request()->get("hazy_name", '');
        if ($hazy_name) {
            $list = Db::name("user")->where("user_nick_name|user_wechat_open_id", "like", "%{$hazy_name}%")->where("uvirtual", 0)->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
        } else {
            $list = Db::name("user")->where("uvirtual", 0)->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url]]);
        }

        $defaultNavigate = self::defaultNavigate();
        $this->assign("defaultNavigate", $defaultNavigate);
        $this->assign("list", $list);
        $this->assign("hazy_name", $hazy_name);
        $page = request()->get("page", 1);
        $this->assign("page", $page);
        return $this->fetch();
    }
    public function material()
    {
        $usid = request()->get("usid", '');
        if ($usid) {
            $userInfo = Db::name("user")->where("uvirtual", 0)->where("id", $usid)->where("much_id", $this->much_id)->find();
            if ($userInfo) {
                $this->assign("userInfo", $userInfo);
                $existSchool = Db::query("show tables like \"yl_welore_school\"");
                $existUserSchool = Db::query("show tables like \"yl_welore_user_school\"");
                if ($existSchool && $existUserSchool) {
                    $userSchool = Db::name("user_school")->alias("usl")->join("school sc", "usl.school_id=sc.id", "left")->where("usl.user_id", $userInfo["id"])->where("usl.much_id", $this->much_id)->field("sc.school_name")->find();
                    $this->assign("userSchool", $userSchool);
                }
                return $this->fetch();
            } else {
                return $this->redirect("user/index");
            }
        } else {
            return $this->redirect("user/index");
        }
    }
    public function wallet()
    {
        $usid = request()->get("usid", '');
        $conchPage = request()->get("conchPage", 1);
        $fractionPage = request()->get("fractionPage", 1);
        if ($usid) {
            $user = Db::name("user")->where("uvirtual", 0)->where("id", $usid)->where("much_id", $this->much_id)->find();
            $userConch = self::userConch($usid, $conchPage);
            $userFraction = self::userFraction($usid, $fractionPage);
            if ($user) {
                $defaultNavigate = self::defaultNavigate();
                $this->assign("defaultNavigate", $defaultNavigate);
                $this->assign("user", $user);
                $this->assign("userConch", $userConch);
                $this->assign("userFraction", $userFraction);
                $this->assign("usid", $usid);
                $this->assign("conchPage", $conchPage);
                $this->assign("fractionPage", $fractionPage);
                return $this->fetch();
            } else {
                return $this->redirect("user/index");
            }
        } else {
            return $this->redirect("user/index");
        }
    }
    public function getConch()
    {
        $usid = request()->post("usid", '');
        $conchPage = request()->post("conchPage", 1);
        return self::userConch($usid, $conchPage);
    }
    private function userConch($usid, $page)
    {
        $userAmount = Db::name("user_amount")->where("user_id", $usid)->where("evaluate", 0)->where("much_id", $this->much_id)->limit(($page - 1) * 10, 10 * $page)->order("ruins_time", "desc")->field("solution,ruins_time,finance")->select();
        return $userAmount;
    }
    public function getFraction()
    {
        $usid = request()->post("usid", '');
        $fractionPage = request()->post("fractionPage", 1);
        return self::userFraction($usid, $fractionPage);
    }
    private function userFraction($usid, $page)
    {
        $userAmount = Db::name("user_amount")->where("user_id", $usid)->where("evaluate", 1)->where("much_id", $this->much_id)->limit(($page - 1) * 10, 10 * $page)->order("ruins_time", "desc")->field("solution,ruins_time,finance")->select();
        return $userAmount;
    }
    public function alterunt()
    {
        if (request()->isPost() && request()->isAjax()) {
            $usid = request()->post("usid");
            $genus = request()->post("genus");
            $cipher = request()->post("cipher");
            switch ($genus) {
                case 0:
                    Db::startTrans();
                    try {
                        $userA = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->setInc("conch", $cipher);
                        $userB = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        $defaultNavigate = self::defaultNavigate();
                        $amountData = ["user_id" => $usid, "category" => 3, "finance" => $cipher, "poem_fraction" => $userA["fraction"], "poem_conch" => $userA["conch"], "surplus_fraction" => $userB["fraction"], "surplus_conch" => $userB["conch"], "ruins_time" => time(), "solution" => "系统赠送{$defaultNavigate["currency"]}", "evaluate" => 0, "much_id" => $this->much_id];
                        Db::name("user_amount")->insert($amountData);
                        $result = true;
                        Db::commit();
                    } catch (\Exception $e) {
                        $result = false;
                        Db::rollback();
                    }
                    break;
                case 1:
                    Db::startTrans();
                    try {
                        $userA = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->setDec("conch", $cipher);
                        $userB = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        $defaultNavigate = self::defaultNavigate();
                        $amountData = ["user_id" => $usid, "category" => 2, "finance" => -$cipher, "poem_fraction" => $userA["fraction"], "poem_conch" => $userA["conch"], "surplus_fraction" => $userB["fraction"], "surplus_conch" => $userB["conch"], "ruins_time" => time(), "solution" => "系统扣除{$defaultNavigate["currency"]}", "evaluate" => 0, "much_id" => $this->much_id];
                        Db::name("user_amount")->insert($amountData);
                        $result = true;
                        Db::commit();
                    } catch (\Exception $e) {
                        $result = false;
                        Db::rollback();
                    }
                    break;
                case 2:
                    Db::startTrans();
                    try {
                        $userA = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->setInc("fraction", $cipher);
                        $userB = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        $amountData = ["user_id" => $usid, "category" => 3, "finance" => $cipher, "poem_fraction" => $userA["fraction"], "poem_conch" => $userA["conch"], "surplus_fraction" => $userB["fraction"], "surplus_conch" => $userB["conch"], "ruins_time" => time(), "solution" => "系统赠送积分", "evaluate" => 1, "much_id" => $this->much_id];
                        Db::name("user_amount")->insert($amountData);
                        $result = true;
                        Db::commit();
                    } catch (\Exception $e) {
                        $result = false;
                        Db::rollback();
                    }
                    break;
                case 3:
                    Db::startTrans();
                    try {
                        $userA = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->setDec("fraction", $cipher);
                        $userB = Db::name("user")->where("id", $usid)->where("uvirtual", 0)->where("much_id", $this->much_id)->find();
                        $amountData = ["user_id" => $usid, "category" => 2, "finance" => -$cipher, "poem_fraction" => $userA["fraction"], "poem_conch" => $userA["conch"], "surplus_fraction" => $userB["fraction"], "surplus_conch" => $userB["conch"], "ruins_time" => time(), "solution" => "系统扣除积分", "evaluate" => 1, "much_id" => $this->much_id];
                        Db::name("user_amount")->insert($amountData);
                        $result = true;
                        Db::commit();
                    } catch (\Exception $e) {
                        $result = false;
                        Db::rollback();
                    }
                    break;
            }
            if ($result !== false) {
                return json(["code" => 1, "msg" => $genus == 0 || $genus == 2 ? "充值成功" : "扣除成功"]);
            } else {
                return json(["code" => 0, "msg" => $genus == 0 || $genus == 2 ? "充值失败" : "扣除失败"]);
            }
        }
    }
    public function pulate()
    {
        if (request()->isAjax() && request()->isPost()) {
            $data = request()->post();
            $result = Db::name("user")->where("id", $data["nuid"])->where("uvirtual", 0)->where("much_id", $this->much_id)->update(["status" => $data["ntheir"] == 1 ? 1 : 0]);
            if ($result !== false) {
                return json(["code" => 1, "msg" => $data["ntheir"] == 1 ? "解封成功" : "封禁成功"]);
            } else {
                return json(["code" => 0, "msg" => $data["ntheir"] == 1 ? "解封失败" : "封禁失败"]);
            }
        }
    }
    public function inspect()
    {
        $url = self::defaultQuery();
        $list = Db::name("user_maker")->alias("usme")->join("user us", "usme.user_open_id=us.user_wechat_open_id", "left")->where("usme.much_id", $this->much_id)->order("usme.scores", "asc")->order("usme.id", "asc")->field("usme.*,us.user_head_sculpture,us.user_nick_name")->paginate(10, false, ["query" => ["s" => $url]]);
        $this->assign("list", $list);
        $page = request()->get("page", 1);
        $this->assign("page", $page);
        return $this->fetch();
    }
    public function slpect()
    {
        if (request()->isPost() && request()->isAjax()) {
            $syid = request()->post("asyId");
            $scores = request()->post("dalue");
            $result = Db::name("user_maker")->where("id", $syid)->where("much_id", $this->much_id)->update(["scores" => $scores]);
            if ($result !== false) {
                return json(["code" => 1, "msg" => "保存成功"]);
            } else {
                return json(["code" => 0, "msg" => "保存失败"]);
            }
        }
    }
    public function ruinspect()
    {
        if (request()->isPost() && request()->isAjax()) {
            $data = request()->post();
            $usmaker = Db::name("user_maker")->where("user_open_id", $data["user_open_id"])->where("much_id", $this->much_id)->find();
            if (!$usmaker) {
                $data["found_time"] = time();
                $data["much_id"] = $this->much_id;
                $result = Db::name("user_maker")->insert($data);
                if ($result != false) {
                    return json(["code" => 1, "msg" => "保存成功"]);
                } else {
                    return json(["code" => 0, "msg" => "保存失败"]);
                }
            } else {
                return json(["code" => 0, "msg" => "保存失败，该用户已是超级管理员"]);
            }
        }
        return $this->fetch();
    }
    public function slpust()
    {
        $usid = request()->post("usid");
        $status = request()->post("status");
        $result = Db::name("user_maker")->where("id", $usid)->where("much_id", $this->much_id)->update(["status" => $status]);
        if ($result !== false) {
            return json(["code" => 1, "msg" => $status == 0 ? "状态已更改为禁用" : "状态已更改为正常"]);
        } else {
            return json(["code" => 0, "msg" => "状态更改失败"]);
        }
    }
    public function spectlint()
    {
        if (request()->isPost() && request()->isAjax()) {
            $usid = request()->post("ecid");
            $result = Db::name("user_maker")->where("id", $usid)->where("much_id", $this->much_id)->delete();
            if ($result !== false) {
                return json(["code" => 1, "msg" => "删除成功"]);
            } else {
                return json(["code" => 0, "msg" => "删除失败"]);
            }
        }
    }
    public function theoretic()
    {
        $url = self::defaultQuery();
        $hazy_name = request()->get("hazy_name", '');
        if ($hazy_name) {
            $list = Db::name("user")->where("user_nick_name", "like", "%{$hazy_name}%")->where("uvirtual", 1)->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
        } else {
            $list = Db::name("user")->where("uvirtual", 1)->where("much_id", $this->much_id)->order("id", "desc")->paginate(10, false, ["query" => ["s" => $url]]);
        }
        $this->assign("list", $list);
        $tribute = Db::name("tribute")->where("much_id", $this->much_id)->order("scores")->select();
        $this->assign("tribute", $tribute);
        $defaultNavigate = self::defaultNavigate();
        $this->assign("defaultNavigate", $defaultNavigate);
        $this->assign("hazy_name", $hazy_name);
        $page = request()->get("page", 1);
        $this->assign("page", $page);
        return $this->fetch();
    }
    public function rutheoretic()
    {
        if (request()->isPost() && request()->isAjax()) {
            $data["user_nick_name"] = request()->post("name");
            $data["user_head_sculpture"] = emoji_encode(request()->post("headimg"));
            $data["uvirtual"] = 1;
            $data["gender"] = request()->post("gender");
            $data["autograph"] = request()->post("autograph");
            $data["user_reg_time"] = time();
            $data["much_id"] = $this->much_id;
            $userInfo = Db::name("user")->where("user_nick_name", $data["user_head_sculpture"])->where("much_id", $this->much_id)->find();
            if ($userInfo) {
                return json(["code" => 0, "msg" => "保存失败，该用户名已存在"]);
            }
            Db::startTrans();
            try {
                Db::name("user")->insert($data);
                $result = true;
                Db::commit();
            } catch (\Exception $e) {
                $result = false;
                Db::rollback();
            }
            if ($result !== false) {
                return json(["code" => 1, "msg" => "保存成功"]);
            } else {
                return json(["code" => 0, "msg" => "保存失败"]);
            }
        }
        return $this->fetch();
    }
    public function uptheoretic()
    {
        if (request()->isPost() && request()->isAjax()) {
            $usid = request()->post("usid");
            $data["user_nick_name"] = request()->post("name");
            $data["user_head_sculpture"] = emoji_encode(request()->post("headimg"));
            $data["uvirtual"] = 1;
            $data["gender"] = request()->post("gender");
            $data["autograph"] = request()->post("autograph");
            $data["user_reg_time"] = time();
            $data["much_id"] = $this->much_id;
            $userInfo = Db::name("user")->where("user_nick_name", $data["user_head_sculpture"])->where("user_nick_name", "<>", $data["user_head_sculpture"])->where("much_id", $this->much_id)->find();
            if ($userInfo) {
                return json(["code" => 0, "msg" => "保存失败，该用户名已存在"]);
            }
            Db::startTrans();
            try {
                Db::name("user")->where("id", $usid)->where("much_id", $this->much_id)->update($data);
                $result = true;
                Db::commit();
            } catch (\Exception $e) {
                $result = false;
                Db::rollback();
            }
            if ($result !== false) {
                return json(["code" => 1, "msg" => "保存成功"]);
            } else {
                return json(["code" => 0, "msg" => "保存失败"]);
            }
        }
        $usid = request()->get("usid", '');
        if ($usid) {
            $getUser = Db::name("user")->where("id", $usid)->where("uvirtual", 1)->where("much_id", $this->much_id)->find();
            if ($getUser) {
                $this->assign("list", $getUser);
                return $this->fetch();
            } else {
                return $this->error("参数错误", "user/theoretic");
            }
        } else {
            return $this->error("参数错误", "user/theoretic");
        }
    }
    public function reticraphic()
    {
        if (request()->isPost() && request()->isAjax()) {
            $rectify = request()->post();
            $data["user_id"] = $rectify["userid"];
            $data["tory_id"] = $rectify["toryid"];
            $data["study_title"] = $rectify["title"];
            $data["study_title_color"] = "#000000";
            $data["study_content"] = $rectify["content"];
            $data["study_type"] = 0;
            $data["topping_time"] = 0;
            $data["image_part"] = json_encode($rectify["multipleImg"], 320);
            $data["adapter_time"] = time();
            $data["prove_time"] = time();
            $data["study_status"] = 1;
            $data["is_open"] = 1;
            $data["much_id"] = $this->much_id;
            Db::startTrans();
            try {
                Db::name("paper")->insert($data);
                $result = true;
                Db::commit();
            } catch (\Exception $e) {
                $result = false;
                Db::rollback();
            }
            if ($result !== false) {
                return json(["code" => 1, "msg" => "保存成功"]);
            } else {
                return json(["code" => 0, "msg" => "保存失败"]);
            }
        }
        $usid = request()->get("usid", '');
        if ($usid) {
            $getUser = Db::name("user")->where("id", $usid)->where("uvirtual", 1)->where("much_id", $this->much_id)->find();
            if ($getUser) {
                $this->assign("userInfo", $getUser);
                $toryInfo = Db::name("territory")->where("much_id", $this->much_id)->order("scores")->select();
                $this->assign("toryInfo", $toryInfo);
                return $this->fetch();
            } else {
                return $this->error("参数错误", "user/theoretic");
            }
        } else {
            return $this->error("参数错误", "user/theoretic");
        }
    }
    public function reticrpaper()
    {
        if (request()->isPost() && request()->isAjax()) {
            $data["paper_id"] = request()->post("paperId");
            $paperInfo = Db::name("paper")->where("id", $data["paper_id"])->where("study_status", 1)->where("whether_delete", 0)->where("much_id", $this->much_id)->find();
            if ($paperInfo) {
                $data["user_id"] = request()->post("userId");
                $data["reply_type"] = 0;
                $phase = Db::name("paper_reply")->where("much_id", $this->much_id)->where("paper_id", $data["paper_id"])->max("phase");
                if ($phase == 0) {
                    $data["phase"] = 2;
                } else {
                    $data["phase"] = $phase + 1;
                }
                $data["reply_content"] = request()->post("content", null);
                $image_part[] = request()->post("multipleImg", '');
                $data["image_part"] = json_encode($image_part, true);
                $data["apter_time"] = time();
                $data["much_id"] = $this->much_id;
                Db::startTrans();
                try {
                    $replyId = Db::name("paper_reply")->insertGetId($data);
                    Db::name("paper")->where("id", $data["paper_id"])->where("much_id", $this->much_id)->setInc("study_repount", 1);
                    $page_title = $paperInfo["study_title"] == '' ? subtext($paperInfo["study_content"], 10) : subtext($paperInfo["study_title"], 10);
                    $fa_info = Db::name("paper_reply")->where("id", $replyId)->where("much_id", $this->much_id)->find();
                    $hui_title = subtext($fa_info["reply_content"], 10);
                    if (empty($hui_title)) {
                        if ($fa_info["reply_type"] == 0) {
                            $hui_title = "[一张图片]";
                        }
                        if ($fa_info["reply_type"] == 1) {
                            $hui_title = "[一段语音]";
                        }
                    }
                    if (empty($page_title)) {
                        if ($paperInfo["study_type"] == 0) {
                            $page_title = "[图片帖子]";
                        }
                        if ($paperInfo["study_type"] == 1) {
                            $page_title = "[语音帖子]";
                        }
                        if ($paperInfo["study_type"] == 2) {
                            $page_title = "[视频帖子]";
                        }
                    }
                    $getUser = Db::name("user")->where("id", $data["user_id"])->where("uvirtual", 1)->where("much_id", $this->much_id)->find();
                    $tmplData = ["much_id" => $this->much_id, "at_id" => "AT1803", "user_id" => $paperInfo["user_id"], "page" => "yl_welore/pages/packageA/article/index?id=" . $paperInfo["id"] . "&type=" . $paperInfo["study_type"], "keyword1" => emoji_encode($page_title), "keyword2" => emoji_encode($getUser["user_nick_name"]), "keyword3" => $hui_title, "keyword4" => date("Y年m月d日 H:i:s", time())];
                    $tmplService = new TmplService();
                    $tmplService->add_template($tmplData);
                    $result = true;
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                    return json(["code" => 0, "msg" => "error , " . $e->getMessage()]);
                }
                if ($result === true) {
                    return json(["code" => 1, "msg" => "回贴成功，请在小程序里查看回复内容！"]);
                }
            } else {
                return json(["code" => 0, "msg" => "帖子ID填写有误"]);
            }
        } else {
            $usid = request()->get("usid", '');
            if ($usid) {
                $getUser = Db::name("user")->where("id", $usid)->where("uvirtual", 1)->where("much_id", $this->much_id)->find();
                if ($getUser) {
                    $this->assign("userInfo", $getUser);
                    $toryInfo = Db::name("territory")->where("much_id", $this->much_id)->order("scores")->select();
                    $this->assign("toryInfo", $toryInfo);
                    return $this->fetch();
                } else {
                    return $this->error("参数错误", "user/theoretic");
                }
            } else {
                return $this->error("参数错误", "user/theoretic");
            }
        }
    }
    public function water()
    {
        $url = self::defaultQuery();
        $hazy_name = request()->get("hazy_name", '');
        $hazy_egon = request()->get("egon", 0);
        switch ($hazy_egon) {
            case 0:
                $list = Db::name("user_serial")->alias("ul")->join("user us", "ul.user_id=us.id", "left")->where("ul.single_mark|us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("us.uvirtual", 0)->where("ul.much_id", $this->much_id)->order("ul.id", "desc")->field("ul.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
                break;
            case 1:
                $list = Db::name("user_serial")->alias("ul")->join("user us", "ul.user_id=us.id", "left")->where("ul.single_mark|us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("us.uvirtual", 0)->where("ul.status", 0)->where("ul.much_id", $this->much_id)->order("ul.id", "desc")->field("ul.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
                break;
            case 2:
                $list = Db::name("user_serial")->alias("ul")->join("user us", "ul.user_id=us.id", "left")->where("ul.single_mark|us.user_nick_name|us.user_wechat_open_id", "like", "%{$hazy_name}%")->where("us.uvirtual", 0)->where("ul.status", 1)->where("ul.much_id", $this->much_id)->order("ul.id", "desc")->field("ul.*,us.user_nick_name,us.user_wechat_open_id")->paginate(10, false, ["query" => ["s" => $url, "egon" => $hazy_egon, "hazy_name" => $hazy_name]]);
                break;
        }
        $this->assign("list", $list);
        $this->assign("hazy_name", $hazy_name);
        $this->assign("egon", $hazy_egon);
        $page = request()->get("page", 1);
        $this->assign("page", $page);
        return $this->fetch();
    }
    public function engage()
    {
        $url = self::defaultQuery();
        $hazy_name = request()->get("hazy_name", '');
        $list = Db::name("user_invitation_code")->alias("uic")->join("user us", "uic.user_id=us.id", "left")->join("user_respond_invitation uri", "uic.code=uri.re_code", "left")->where("us.user_nick_name|us.user_wechat_open_id|uic.code", "like", "%{$hazy_name}%")->where("us.uvirtual", 0)->where("uic.much_id", $this->much_id)->group("uri.re_code")->group("uic.user_id")->field("us.user_nick_name,us.user_wechat_open_id,uic.code,count(uri.re_code) as uri_people , sum(uri.in_us_reward) as uri_reward")->order("uri_people", "desc")->order("uic.user_id", "asc")->paginate(10, false, ["query" => ["s" => $url, "hazy_name" => $hazy_name]]);
        $defaultNavigate = self::defaultNavigate();
        $this->assign("defaultNavigate", $defaultNavigate);
        $this->assign("list", $list);
        $this->assign("hazy_name", $hazy_name);
        $page = request()->get("page", 1);
        $this->assign("page", $page);
        return $this->fetch();
    }
    public function virtualSendGifts()
    {
        if (request()->isPost() && request()->isAjax()) {
            $data["li_id"] = request()->post("tributeNumber");
            $data["uid"] = request()->post("virtualUser");
            $userOpenId = request()->post("userOpenid");
            $getUserInfo = Db::name("user")->where("user_wechat_open_id", $userOpenId)->where("much_id", $this->much_id)->find();
            if ($getUserInfo) {
                $data["user_id"] = $getUserInfo["id"];
                $data["num"] = request()->post("tributeQuantity");
                $data["much_id"] = $this->much_id;
                $userServer = new UserService();
                $result = $userServer->user_reward($data);
                if ($result["status"] == "success") {
                    return json(["code" => 1, "msg" => $result["msg"]]);
                } else {
                    return json(["code" => 0, "msg" => $result["msg"]]);
                }
            } else {
                return json(["code" => 0, "msg" => "openid输入错误"]);
            }
        } else {
            return $this->redirect("user/theoretic");
        }
    }
}