<?php

namespace tw2113\WhiskyPalatte;
use \Slim\Slim as Slim;

require 'vendor/autoload.php';

$app = new Slim(
	array(
		'debug' => true,
		'log.enabled' => true
	)
);

$app->get('/', function () use ($app) {
    $app->render('home.php', array(
		'title' => 'Hello Slim.',
		'body'  => 'Horrible latin'
	));
});

$app->run();
