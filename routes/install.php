<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use Aura\Sql\ExtendedPdo;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get( '/install', function ( $request, $response, $args ) use ( $app ) {

    $config = $app->config;

    $whiskies_table_create = "CREATE TABLE IF NOT EXISTS whiskies (
        whisky_id INTEGER PRIMARY KEY AUTOINCREMENT,
        whisky_name TEXT,
        distiller_name TEXT,
        alcohol_by_volume TEXT,
        package_description TEXT,
        years_matured TEXT,
        whisky_style TEXT,
        whisky_volume TEXT,
        purchase_price TEXT,
        aroma_description TEXT,
        palate_description TEXT,
        finish_description TEXT
    )";

    $distilleries_table_create = "CREATE TABLE IF NOT EXISTS distilleries (
        distillery_id INTEGER PRIMARY KEY AUTOINCREMENT,
        distillery_name TEXT,
        distillery_location TEXT,
        year_established TEXT,
        website_url TEXT
    )";

    $pdo = new ExtendedPdo(
        $config['db.pdo.connect']
    );

    try {
        $pdo->exec( $whiskies_table_create );
    } catch ( \Exception $e ) {
        $log = new Logger( 'install_errors' );
        $log->pushHandler( new StreamHandler( 'logs/error.log', Logger::WARNING ) );

        $log->addError( 'Whiskies table exception: ' . $e->getMessage() );
    }

    try {
        $pdo->exec( $distilleries_table_create );
    } catch ( \Exception $e ) {
        $log = new Logger( 'install_errors' );
        $log->pushHandler( new StreamHandler( 'logs/error.log', Logger::WARNING ) );

        $log->addError( 'Distilleries table exception: ' . $e->getMessage() );
    }

    $templates = $app->plates;

    // Render a template
    echo $templates->render( 'tmpl-install', [ 'name' => 'Michael' ] );
} );
