<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get( '/install', function ( $request, $response, $args ) use ( $app ) {

    $config = $app->config;

    $db = new Database(
        [
            'pdo_connection' => $config,
        ],
        new Logger( 'install_errors' ),
        new StreamHandler( 'logs/error.log', Logger::WARNING )
    );

    $db->start();

    $templates = $app->plates;

    // Render a template
    echo $templates->render( 'tmpl-install' );
} );
