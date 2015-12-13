<?php

namespace tw2113\Whichsky;

use \Slim as Slim;
use \League\Plates\Engine as Plates;
use \AdamWathan\Form\FormBuilder as FormBuilder;

require 'vendor/autoload.php';

$app = new Slim\App(
	[
		'debug'       => true,
		'log.enabled' => true
	]
);

# Add so we do not need to instantiate everywhere.
$app->plates       = new Plates( './templates' );
$app->form_helpers = new Form_Helpers( new FormBuilder() );
$app->config = require 'config/config.php';

require 'routes/install.php';
require 'routes/home.php';
require 'routes/whiskies.php';
require 'routes/whisky.php';
require 'routes/wishlist.php';
require 'routes/options.php';
require 'routes/manage.php';

$app->run();
