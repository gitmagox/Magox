<?php



//定义系统常量

define('P_D_I_R','/../');
define('MAGOX_PATH',__DIR__.'/');
define('MAGOX_LIB_PATH',MAGOX_PATH.'libs/magox/');
defined('APP_PATH')  or define('APP_PATH',dirname($_SERVER['SCRIPT_FILENAME']) .'/App/');
defined('ROOT_PATH') or define('ROOT_PATH',APP_PATH.'../');

defined('APP_INCLUDE_PATH')  or define('APP_INCLUDE_PATH',APP_PATH.'Common/');
defined('APP_CONFIG_PATH')   or define('APP_CONFIG_PATH',APP_INCLUDE_PATH.'config/');
defined('APP_CONFIG_D_FILE') or define('APP_CONFIG_D_FILE',APP_CONFIG_PATH.'/config.php');
defined('APP_FUNCITON_PATH') or define('APP_FUNCITON_PATH',APP_PATH.'function/');
defined('APP_FUNCITON_FILE') or define('APP_FUNCITON_FILE',APP_FUNCITON_PATH.'function.php');

define('MAGOX_LIB_FUNCTION_FILE',MAGOX_LIB_PATH.'function/function.php');


//自动加载类
include MAGOX_LIB_PATH.'load.php';
spl_autoload_register('\\Magox\\Load::autoload');

//加载系统函数
require_once MAGOX_LIB_FUNCTION_FILE;


use Magox\start;
start::run();

