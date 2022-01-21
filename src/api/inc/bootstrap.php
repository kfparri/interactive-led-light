<?php
define("PROJECT_ROOT_PATH", __DIR__ . "\\..\\");

// include main config file
require_once PROJECT_ROOT_PATH . "/inc/config.php";

// include base controller file
require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

// include the Command model
require_once PROJECT_ROOT_PATH . "/Model/CommandModel.php";