<?php 
class Framework
{
	// Initiate framework then register autoload and finally dispatch
	public static function run()
	{
	   self::init();
	   self::autoload();
	   self::dispatch();
	}

	// Initialization
	private static function init() {

	    // Define path constants

	    define("DS", DIRECTORY_SEPARATOR);

	    define("ROOT", getcwd() . DS);

	    define("APP_PATH", ROOT . 'app' . DS);
	  
	    define("FRAMEWORK_PATH", ROOT . "framework" . DS);

	    define("PUBLIC_PATH", ROOT . "public" . DS);

	    define("CONFIG_PATH", APP_PATH . "config" . DS);

	    define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);

	    define("MODEL_PATH", APP_PATH . "models" . DS);

	    define("VIEW_PATH", APP_PATH . "views" . DS);

	    define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);

	    define('DB_PATH', FRAMEWORK_PATH . "database" . DS);

	    define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);

	    define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);

	    define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);

	    // Define platform, controller, action, for example:

	    // index.php?p=admin&c=Goods&a=add

	    define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');

	    define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');

	    define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');

	    // define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . DS);

	    define("CURR_VIEW_PATH", VIEW_PATH . DS);

	    // Load core classes

	    require CORE_PATH . "Controller.php";

	    require CORE_PATH . "Loader.php";

	    require DB_PATH . "Mysql.php";

	    require CORE_PATH . "Model.php";

	    // Load configuration file

	    $GLOBALS['config'] = include CONFIG_PATH . "config.php";

	    // include db
	    include CONFIG_PATH . "db.php";

	    // Start session

	    session_start();

	}

	// Autoload
	private static function autoload()
	{
		spl_autoload_register(array(__CLASS__, 'load'));
	}

	// Define a custom load method
	private static function load($classname)
	{
	    if (substr($classname, -10) == "Controller") {
	        // Controller
	        require_once CONTROLLER_PATH . "$classname.php";
	    } elseif (substr($classname, -5) == "Model") {
	        // Model
	        require_once  MODEL_PATH . "$classname.php";
	    }
	}

	// Dispatch specific action
	private static function dispatch()
	{
	    // Instantiate the controller class and call its action method
	    $controller_name = CONTROLLER . "Controller";
	    $action_name = ACTION . "Action";
	    $controller = new $controller_name;
	    $controller->$action_name();
	}
}