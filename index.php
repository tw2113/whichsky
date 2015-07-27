<?php

namespace tw2113\Whichsky;

use \Slim as Slim;
use Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;

require 'vendor/autoload.php';

$app = new Slim\App(
	array(
		'debug' => true,
		'log.enabled' => true
	)
);

# Add so we do not need to instantiate everywhere.
$app->plates = new Plates( './templates' );

require 'routes/home.php';
require 'routes/whiskies.php';
require 'routes/whisky.php';
require 'routes/wishlist.php';
require 'routes/options.php';
require 'routes/manage.php';

$app->run();
