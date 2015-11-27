<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get( '/options/', function () use ( $app ) {

    $templates = $app->plates;

    // Render a template
    echo $templates->render( 'tmpl-options' );
} );
