<?php

namespace tw2113\WhiskyPalatte;
use \Slim\Slim as Slim;

$app = Slim::getInstance();

$app->render('header.php');

echo $body['id'] . $body['name'] . $body['distillery'];

echo '<hr/>';

printf(
	'<a href="%s">%s</a>',
	'/whisky/' . $body['id'],
	$body['name']
);

$app->render('footer.php');
