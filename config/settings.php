<?php



// Should be set to 0 in production

use App\Exception\SettingsErrorException;

error_reporting(E_ALL);

// Should be set to '0' in production
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Europe/Rome');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

if (isset($_ENV["APP_NAME"]))
    $settings['app-name'] = $_ENV["APP_NAME"];
else
    $settings['app-name'] = "";

if (isset($_ENV["APP_VERSION"]))
    $settings['app-version'] = $_ENV["APP_VERSION"];
else
    $settings['app-version'] = "";

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];


// doctrine settings
if (!(isset($_ENV['MYSQL_HOST'], $_ENV['MYSQL_PORT'], $_ENV['MYSQL_DBNAME'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'])))
    throw new SettingsErrorException("settings error", 500, ["unable to get db settings from .env file"]);


$settings['doctrine'] = [
    'meta' => [
        'entity_path' => [ $settings['root'] . '/src/Entity' ],
        'auto_generate_proxies' => true,
        'proxy_dir' => $settings['root'] . '/var/cache/proxies',
        'cache' => null,
    ],
    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => $_ENV['MYSQL_HOST'],
        'port' => $_ENV['MYSQL_PORT'],
        'dbname' => $_ENV['MYSQL_DBNAME'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD']
    ]
];




// Logger settings
$settings['logger'] = [
    'name' => 'slim-login-skeleton',
    'path' => __DIR__ . '/../logs',
    'filename' => 'logs.log',
    'level' => "info",
    'file_permission' => 0775,
    'stdoutHandler'=> true,
];


return $settings;