<?php

namespace tw2113\WhiskyPalatte;
use \Slim\Slim as Slim;

$app = Slim::getInstance();

$app->render('header.php');

$app->render('footer.php');
