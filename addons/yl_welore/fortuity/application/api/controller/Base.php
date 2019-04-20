<?php

//decode by http://www.yunlu99.com/
namespace app\api\controller;

use app\common\Tension;
use think\Controller;
use think\Db;
use think\Request;
class Base extends Controller
{
    protected $user_info = null;
    protected $much_id = null;
    protected $paper_smingle = null;
    protected $design = null;
    protected $version = 0;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->_initialize();
    }
    public function _initialize()
    {
//        $ten = Tension::otherwise();
//        if ($ten == "error") {
//            echo "error";
//            exit;
//        }
        $much_id = input("param.much_id");
        $token = input("param.token");
        $openid = input("param.openid");
        $version = input("param.version");

        if (empty($version)) {
            $this->version = 0;
        } else {
            $check_version = Db::name("version")->where("sign_code", $version)->where("much_id", $much_id)->find();
            $chech_sh = Db::name("authority")->where("much_id", $much_id)->find();
            if ($chech_sh["ensure_arbor"] == 0) {
                $this->version = 0;
            } else {
                if (empty($check_version)) {
                    $this->version = 1;
                } else {
                    if ($check_version["status"] == 0) {
                        $this->version = 1;
                    } else {
                        $this->version = 0;
                    }
                }
            }
        }
        if (empty($openid)) {
            echo json_encode(["status" => "error", "msg" => "账户未授权!"]);
            exit;
        }
        $user = Db::name("user")->where("user_wechat_open_id", $openid)->where("token", $token)->find();
        if ($user) {
            $user["user_nick_name"] = emoji_decode($user["user_nick_name"]);
            $this->user_info = $user;
            $this->much_id = $user["much_id"];
            $paper_smingle = Db::name("paper_smingle")->where("much_id", $this->much_id)->find();
            $this->paper_smingle = $paper_smingle;
            $design = Db::name("design")->where("much_id", $this->much_id)->find();
            $this->design = $design;
        } else {
            echo json_encode(["status" => "error", "msg" => "账户未授权!"]);
            exit;
        }
    }
}