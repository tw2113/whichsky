<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;

$app->get('/', function() use ($app) {

    $templates = $app->plates;

    // Render a template
    echo $templates->render('tmpl-home', ['name' => 'Michael']);
});
