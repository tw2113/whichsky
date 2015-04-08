<?php

namespace tw2113\Whichsky;

use \Slim as Slim;
use Aura\SqlQuery\QueryFactory;

require 'vendor/autoload.php';

$app = new \Slim\App(
	array(
		'debug' => true,
		'log.enabled' => true
	)
);

require 'routes/home.php';
require 'routes/whiskies.php';
require 'routes/whisky.php';
require 'routes/wishlist.php';

$app->run();
