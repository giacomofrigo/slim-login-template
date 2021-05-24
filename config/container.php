<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use App\Exception\SettingsErrorException;
use App\Service\UserService;
use Psr\Log\LoggerInterface;


return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    'em' => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['doctrine']['meta']['entity_path'],
            $settings['doctrine']['meta']['auto_generate_proxies'],
            $settings['doctrine']['meta']['proxy_dir'],
            $settings['doctrine']['meta']['cache'],
            false
        );
        return EntityManager::create($settings['doctrine']['connection'], $config);
    },

    LoggerInterface::class => function(ContainerInterface $container){

        $possible_levels = array(
            "debug" => Logger::DEBUG,
            "info" => Logger::INFO,
            "warning" => Logger::WARNING,
            "error" => Logger::ERROR
        );
        $settings = $container->get('settings');

        if (!(array_key_exists($settings['logger']['level'], $possible_levels))){
            throw new SettingsErrorException("Error in logger settings, level not allowed.", 500);
        }

        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output);

        $stream = $settings['logger']['path'] . DIRECTORY_SEPARATOR . $settings['logger']['filename'];
        
        $logger = new Logger($settings['logger']['name']);


        $fileHandler = new StreamHandler($stream, $possible_levels[$settings['logger']['level']]);
        $fileHandler->setFormatter($formatter);
        $logger->pushHandler($fileHandler);
        
        if (array_key_exists('stdoutHandler', $settings['logger'])){
            if ((bool) $settings['logger']['stdoutHandler']){
                $stdoutHandler = new StreamHandler('php://stdout', Logger::DEBUG);
                $stdoutHandler->setFormatter($formatter);
                $logger->pushHandler($stdoutHandler);
            }
        }


        

        return $logger;
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    // default error handler config
    // not used.
    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },
    

    'errorHandler' => function (ContainerInterface $container) {
        return function ($request, $response, $exception) use ($container) {
            $container->get(LoggerInterface::class)->info("Exception logging");
            return $response->withStatus($exception->getReturnCode())
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($exception->toArray()));
        };
    },

    'userService' => function(ContainerInterface $container){
        return new UserService($container);
    }

    


];