<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Config;
use Phalcon\Mvc\Collection\Manager;

$config = new Config([]);
// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require_once(BASE_PATH.'/vendor/autoload.php');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
        APP_PATH . "/components/",
    ]
);
$loader->registerNamespaces([
    'App\Components' => APP_PATH.'/components/',
]);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

// use App\Components\Search;
$container->set(
    'findUser',
    function() {
        return new App\Components\Search();
    }
);

$container->set(
    'mongo',
    function () {
        $mongo = new MongoDB\Client(
            'mongodb+srv://root:VajsFVXK36vxh4M6@cluster0.nwpyx9q.mongodb.net/?retryWrites=true&w=majority'
        );
        return $mongo->userData;
    },
    true
);

$container->set(
    'collectionManager',
    function () {
        return new Manager();
    }
);
$application = new Application($container);



try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}