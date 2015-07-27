<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;

$app->get('/whiskies/', function() use ($app) {

    $templates = $app->plates;

    $data['whiskies'] = [
        'one'   => 'two',
        'three' => 'four',
        'five'  => 'six'
    ];
    // Render a template
    echo $templates->render('tmpl-whiskies',$data);
});
