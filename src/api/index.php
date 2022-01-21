<?php
// stole all this code from: https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000

require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if((isset($uri[4]) && $uri[4] != 'command') || !isset($uri[4])) 
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/CommandController.php";

$objFeedController = new CommandController();
$strMethodName = $uri[5] . 'Action';
$objFeedController->{$strMethodName}();
?>