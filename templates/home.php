<?php

namespace tw2113\WhiskyPalatte;
use \Slim\Slim as Slim;

$app = Slim::getInstance();

$app->render('header.php');

printf( '<h1>%s</h1>',
	'Welcome to Whicksky! Your own personal Whisky tasting and wishlist application.'
);

$app->render('footer.php');
