<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;

$app->get( '/whisky/{id}/', function ( $request, $response, $args ) use ( $app ) {

    $templates = $app->plates;

    $c['config'] = require dirname( dirname( __FILE__ ) ) . '/config/config.php';

    $config = $c['config'];

    $query_factory = new QueryFactory( 'sqlite' );
    $select        = $query_factory->newSelect();

    $select
        ->cols(
            [ '*' ]
        )
        ->from( 'whiskies as w' )
        ->where( 'id = :id' )
        ->bindValues( [
            'id' => $args['id']
        ] );

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

    // Render a template
    echo $templates->render( 'tmpl-whisky' );
} );
