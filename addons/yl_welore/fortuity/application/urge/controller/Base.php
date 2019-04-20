<?php

//decode by http://www.yunlu99.com/
namespace app\urge\controller;

use think\Controller;
use think\Db;
use think\Request;
class Base extends Controller
{
    protected $M = null;
    protected $much = null;
    protected $much_id = null;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        self::_initialize();
    }
    public function _initialize()
    {
        @session_start();
        if (isset($_SESSION["make_variable"]) && !empty($_SESSION["make_variable"])) {
            $this->M = $_SESSION["make_variable"];
        }
        if (!isset($this->M) || empty($this->M)) {
            $this->redirect("/");
        }
        if (cache("user_" . $this->M["user"]["username"] . "_" . $this->M["uniacid"])) {
            $this->much = cache("user_" . $this->M["user"]["username"] . "_" . $this->M["uniacid"]);
        } else {
            $this->much = Db::name("much_admin")->where("much_name", $this->M["user"]["username"])->where("much_uniacid", $this->M["uniacid"])->cache("user_" . $this->M["user"]["username"] . "_" . $this->M["uniacid"], 60)->find();
            if (!isset($this->much) || empty($_SESSION["make_variable"])) {
                $much_data["much_name"] = $this->M["user"]["username"];
                $much_data["much_uniacid"] = $this->M["uniacid"];
                $much_data["id"] = self::newMerchant($much_data);
                $this->much = $much_data;
            }
        }
        $this->much_id = $this->much["much_uniacid"];
        switch ($this->M["role"]) {
            case "founder":
                $much_title = "站长";
                break;
            case "vice_founder":
                $much_title = "副站长";
                break;
            case "operator":
                $much_title = "操作员";
                break;
            case "manager":
                $much_title = "管理员";
                break;
            case "owner":
                $much_title = "所有者";
                break;
        }
        $this->assign("much_role", $this->M["role"]);
        $this->assign("much_name", $this->much["much_name"]);
        $this->assign("much_title", $much_title);
        if ($this->M["role"] == "founder") {
            $pheres = ["pid" => 0, "furvie" => 1];
        } else {
            if ($this->M["role"] == "vice_founder") {
                $pheres = ["pid" => 0, "vurvie" => 1];
            } else {
                $pheres = ["pid" => 0, "survie" => 1];
            }
        }
        $query = request()->query();
        $query = explode("=/", $query);
        $query = explode("&", $query[1]);
        $query = explode(".html", $query[0]);
        $query = str_replace("urge/", '', $query[0]);
        if ($query == '') {
            $query = "index/index";
        }
        $this->assign("query", $query);
        if ($query == "index/index") {
            $this->assign("acid", 1);
        } else {
            $this->assign("acid", 2);
        }
        $motion = Db::name("motion")->where($pheres)->order("sort")->select();
        foreach ($motion as $key => $value) {
            $cheres = ["pid" => $value["id"], "divulge" => 1];
            if ($this->M["role"] == "founder") {
                $cheres["furvie"] = 1;
            } else {
                if ($this->M["role"] == "vice_founder") {
                    $cheres["vurvie"] = 1;
                } else {
                    $cheres["survie"] = 1;
                }
            }
            $motion[$key]["count"] = Db::name("motion")->where($cheres)->count();
            $motion_child[] = Db::name("motion")->where($cheres)->order("sort")->select();
        }
        $this->assign("motion", $motion);
        $this->assign("motion_child", $motion_child);
        $this->assign("_W", $this->M);
        $this->assign("globalRecluse", self::defaultAnchoret());
        $notice = Db::name("prompt_msg")->where("type", 0)->where("status", 0)->where("much_id", $this->much_id)->count("*");
        $this->assign("notice", $notice);
        $vacant = Db::name("prompt_msg")->where("type", 1)->where("status", 0)->where("much_id", $this->much_id)->count("*");
        $this->assign("vacant", $vacant);
        $knight = self::getKnight();
        $this->assign("knight", $knight);
    }
    protected function defaultAnchoret()
    {
        if (cache("globalRecluse")) {
            $getCopyright = cache("globalRecluse");
        } else {
            $getCopyright = Db::name("copyright")->where("id", 1)->find();
            if (!$getCopyright) {
                Db::startTrans();
                try {
                    $getCopyright = ["id" => 1, "hermit" => 0];
                    Db::name("copyright")->insert($getCopyright);
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                }
            }
            cache("globalRecluse", $getCopyright);
        }
        return $getCopyright;
    }
    private function newMerchant($much_data)
    {
        $muserId = Db::name("much_admin")->cache("user_" . $this->M["user"]["username"] . "_" . $this->M["uniacid"], 60)->insertGetId($much_data);
        self::defaultAdvertise($this->M["uniacid"]);
        self::defaultPaperSmingle($this->M["uniacid"]);
        self::defaultShakyFission($this->M["uniacid"]);
        self::defaultPreCount($this->M["uniacid"]);
        self::defaultReissue($this->M["uniacid"]);
        self::defaultTaxing($this->M["uniacid"]);
        self::defaultHonorablePrice($this->M["uniacid"]);
        self::defaultPunch($this->M["uniacid"]);
        return $muserId;
    }
    protected function defaultAdvertise($much_id)
    {
        $getAdver = Db::name("advertise")->where("much_id", $much_id)->find();
        if (!$getAdver) {
            $getAdver["id"] = Db::name("advertise")->insertGetId(["adstory" => 0, "adsper" => 0, "isolate" => 20, "much_id" => $much_id]);
        }
        return $getAdver;
    }
    protected function defaultPaperSmingle($much_id)
    {
        $getPaperSmingle = Db::name("paper_smingle")->where("much_id", $much_id)->find();
        if (!$getPaperSmingle) {
            $getPaperSmingle = ["auto_review" => 1, "number_limit" => 0, "notice" => '', "much_id" => $much_id];
            Db::startTrans();
            try {
                $getPaperSmingle["id"] = Db::name("paper_smingle")->insertGetId($getPaperSmingle);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
        return $getPaperSmingle;
    }
    protected function defaultShakyFission($much_id)
    {
        $getShakyFission = Db::name("shaky_fission")->where("much_id", $much_id)->find();
        if (!$getShakyFission) {
            $getShakyFission = ["release_single" => 0, "release_fraction" => 0.0, "reply_single" => 0, "reply_fraction" => 0.0, "packet_single" => 0, "much_id" => $much_id];
            Db::startTrans();
            try {
                $getShakyFission["id"] = Db::name("shaky_fission")->insertGetId($getShakyFission);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
        return $getShakyFission;
    }
    protected function defaultHonorablePrice($much_id)
    {
        if (cache("honor_" . $much_id)) {
            $getHonr = cache("honor_" . $much_id);
        } else {
            $getHonr = Db::name("user_honorary")->where("much_id", $much_id)->find();
            if (!$getHonr) {
                $getHonr = ["hono_price" => 29.9, "first_discount" => 0, "discount_scale" => 1.0, "much_id" => $much_id];
                Db::startTrans();
                try {
                    $getHonr["id"] = Db::name("user_honorary")->insertGetId($getHonr);
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                }
            }
            cache("honor_" . $much_id, $getHonr);
        }
        return $getHonr;
    }
    protected function defaultPreCount($much_id)
    {
        $getPreCount = Db::name("prompt_count")->where("much_id", $much_id)->find();
        if (!$getPreCount) {
            $getPreCount = ["barg" => 0, "much_id" => $much_id];
            Db::startTrans();
            try {
                $getPreCount["id"] = Db::name("prompt_count")->insertGetId($getPreCount);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
            cache("preCount_" . $much_id, $getPreCount);
        }
        return $getPreCount;
    }
    protected function defaultReissue($much_id)
    {
        $getReissue = Db::name("reissue")->where("much_id", $much_id)->find();
        if (!$getReissue) {
            $getReissue = ["whether_open" => 0, "title" => "您的好友给您转发了一条信息", "much_id" => $much_id];
            Db::startTrans();
            try {
                $getReissue["id"] = Db::name("reissue")->insertGetId($getReissue);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
        return $getReissue;
    }
    protected function defaultTaxing($much_id)
    {
        $getTaxing = Db::name("tribute_taxation")->where("much_id", $much_id)->find();
        if (!$getTaxing) {
            $getTaxing = ["taxing" => "1.00", "much_id" => $much_id];
            Db::startTrans();
            try {
                $getTaxing["id"] = Db::name("tribute_taxation")->insertGetId($getTaxing);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
        return $getTaxing;
    }
    protected function defaultPunch($much_id)
    {
        $punch = Db::name("user_punch_range")->where("much_id", $much_id)->find();
        if (!$punch) {
            $punch = ["aver_min" => 0.0, "aver_max" => 0.0, "noble_min" => 0.0, "noble_max" => 0.0, "much_id" => $much_id];
            Db::startTrans();
            try {
                $punch["id"] = Db::name("user_punch_range")->insertGetId($punch);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
        return $punch;
    }
    protected function getKnight()
    {
        if (cache("knight_" . $this->much_id)) {
            $snight = cache("knight_" . $this->much_id);
        } else {
            $snight = Db::name("authority")->where("much_id", $this->much_id)->find();
            if (!$snight) {
                $absAddress = explode("index.php", $_SERVER["SCRIPT_NAME"]);
                $absRess = "https://" . $_SERVER["HTTP_HOST"] . $absAddress[0] . "static/disappear/icon.png";
                $snight = ["hermit" => 0, "title" => "您还没有配置站点名称", "sgraph" => $absRess, "cust_phone" => "13000000000", "copyright" => "Copyright © 2019 XXXX. All Rights Reserved.", "prevent_duplication" => 1, "noble_arbor" => 1, "wallet_arbor" => 1, "ensure_arbor" => 0, "video_setting" => 60, "much_id" => $this->much_id];
                Db::startTrans();
                try {
                    $snight["id"] = Db::name("authority")->insertGetId($snight);
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                }
            }
            cache("knight_" . $this->much_id, $snight);
        }
        return $snight;
    }
    protected function defaultNavigate()
    {
        if (cache("design_" . $this->much_id)) {
            $navigate = cache("design_" . $this->much_id);
        } else {
            $navigate = db("design")->where("much_id", $this->much_id)->find();
            if (!$navigate) {
                $absAddress = explode("index.php", $_SERVER["SCRIPT_NAME"]);
                $absRess = "https://" . $_SERVER["HTTP_HOST"] . $absAddress[0] . "static/wechat";
                $navigate = ["confer" => "积分", "currency" => "贝壳", "landgrave" => "圈子", "home_title" => "首页", "pattern_data" => json_encode(["style" => ["backcolor" => "#ffffff", "font_color" => "#000000", "font_color_active" => "#ff0000"], "home" => ["title" => "首页", "images" => ["img" => "{$absRess}/home.png", "img_active" => "{$absRess}/home_active.png"]], "plaza" => ["title" => "广场", "images" => ["img" => "{$absRess}/plaza.png", "img_active" => "{$absRess}/plaza_active.png"]], "release" => ["title" => "发布", "images" => ["img" => "{$absRess}/release.png"]], "goods" => ["title" => "小商品", "images" => ["img" => "{$absRess}/goods.png", "img_active" => "{$absRess}/goods_active.png"]], "user" => ["title" => "我的", "images" => ["img" => "{$absRess}/user.png", "img_active" => "{$absRess}/user_active.png"]]], 320), "much_id" => $this->much_id];
                Db::startTrans();
                try {
                    $navigate["id"] = db("design")->insertGetId($navigate);
                    Db::commit();
                } catch (\Exception $e) {
                    Db::rollback();
                }
            }
            cache("design_" . $this->much_id, $navigate);
        }
        return $navigate;
    }
    public function ordinary()
    {
        if (cache("notices_" . $this->much_id)) {
            $notices = cache("notices_" . $this->much_id);
        } else {
            $notices = Db::name("prompt_msg")->where("status", 0)->where("type", 0)->where("much_id", $this->much_id)->cache("notices_" . $this->much_id)->count("*");
        }
        if (cache("vacants_" . $this->much_id)) {
            $vacants = cache("vacants_" . $this->much_id);
        } else {
            $vacants = Db::name("prompt_msg")->where("status", 0)->where("type", 1)->where("much_id", $this->much_id)->cache("vacants_" . $this->much_id)->count("*");
        }
        if (cache("preCount_" . $this->much_id)) {
            $promptCount = cache("preCount_" . $this->much_id);
        } else {
            $promptCount = Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->find();
        }
        return json(["notice" => $notices, "vacant" => $vacants, "preCount" => $promptCount["barg"]]);
    }
    public function receipt()
    {
        if (request()->isPost() && request()->isAjax()) {
            $multiply = request()->post("multiply", '');
            if ($multiply) {
                $result = Db::name("prompt_count")->where("much_id", $this->much_id)->cache("preCount_" . $this->much_id)->update(["barg" => $multiply]);
                return $result;
            }
        }
    }
}