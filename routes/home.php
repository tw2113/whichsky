<?php

namespace tw2113\Whichsky;
use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use Aura\SqlQuery\QueryFactory;

# Single whisky view.
$app->get('/', function () use ($app) {
    $app->render('home.php', array(
		'title' => 'Whichsky Home'
	));
});
