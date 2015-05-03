<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;
use \AdamWathan\Form\FormBuilder;

$app->get('/manage/', function() use ($app) {

    $templates = new Plates('./templates');

    // Render a template
    echo $templates->render('manage');
});
