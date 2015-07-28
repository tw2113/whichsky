<?php

namespace tw2113\Whichsky;

use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;

$app->get('/', function() use ($app) {

    $templates = $app->plates;

    // Render a template
    echo $templates->render('tmpl-home', ['name' => 'Michael']);
});
