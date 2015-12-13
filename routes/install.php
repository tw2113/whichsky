<?php

namespace tw2113\Whichsky;

use \Aura\SqlQuery\QueryFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get( '/install', function () use ( $app ) {

    $templates = $app->plates;

    // Render a template
    echo $templates->render( 'tmpl-home', [ 'name' => 'Michael' ] );
} );
