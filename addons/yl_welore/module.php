<?php


defined('IN_IA') or exit('Access Denied');

/**
 * 模块入口文件 (初始化)
 */
class Yl_weloreModule extends WeModule {

    private $make_variable;

    /**
     * 构造方法
     */
    public function __construct() {
        global $_W;
        $this->make_variable = $_W;
    }


    /**
     * 执行模块初始化操作
     */
    public function execute() {

        // 验证模块核心文件
        $this->checkModuleFile();

        //定义公共变量
        $this->causeFickle();

        // 跳转到独立后台
        $this->module();
    }

    /**
     * 验证模块核心文件
     */
    private function checkModuleFile() {

        $module_file = __DIR__ . '/web/index.php';
        !file_exists($module_file) && itoast('模块文件不存在', referer(), 'error');
    }

    /**
     * 定义公共变量
     */
    private function causeFickle() {
        @session_start();
        $_SESSION['make_variable'] = $this->make_variable;
    }

    /**
     * 跳转到模块后台
     */
    private function module() {
        global $_W;
        $homePage = 'index.php';
        $url = "{$_W['siteroot']}addons/{$_W['current_module']['name']}/web/" . $homePage;
        header('Location:' . $url);
        exit;
    }

    /**
     * 执行模块初始化
     */
    public function welcomeDisplay() {
        $this->execute();
    }

}