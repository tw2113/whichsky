<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$app->get( '/whiskies/', function () use ( $app ) {

    $templates = $app->plates;

    $c['config'] = require dirname( dirname( __FILE__ ) ) . '/config/config.php';

    $config = $c['config'];

    $query_factory = new QueryFactory( 'sqlite' );
    $select        = $query_factory->newSelect();

    $select
        ->cols(
            [ '*' ]
        )->from( 'whiskies as w' );

    // a PDO connection
    try {
        $pdo = new \PDO( $config['db.pdo.connect'] );
        $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

        $sth = $pdo->prepare( $select->__toString() );
        $sth->execute( $select->getBindValues() );

        // get the results back as an associative array
        $results = $sth->fetchAll( \PDO::FETCH_ASSOC );
    } catch ( \Exception $e ) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

    $data['whiskies'] = [ ];
    foreach ($results as $result) {
        foreach ($result as $key => $value) {
            $data['whiskies'][$key] = $value;
        }
    }
    // Render a template
    echo $templates->render( 'tmpl-whiskies', $data );
} );
