<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;
use Respect\Validation\Validator as v;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Handle new whisky form display/submission.
 */
$app->map( [ 'GET', 'POST' ], '/manage/new/', function ( $request, $response, $args ) use ( $app ) {
    $helpers   = $app->form_helpers;
    $templates = $app->plates;
    $config    = $app->config;

    $whisky_data = [ ]; # Populate with sanitized $form_data and after saving.

    if ($request->isPost()) {
        # https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md
        $form_data = $request->getParsedBody();
        # Validate and populate $whisky_data with values.
        # Redirect to new ID page after successful POST ?
        #   May not need to pass in $whisky_data to render_manage_form() if we redirect.

        /*$c['config'] = require dirname( dirname( __FILE__ ) ) . '/config/config.php';

        $config = $c['config'];

        $query_factory = new QueryFactory( 'sqlite' );
        $insert        = $query_factory->newInsert();*/

        /*
         * $insert->into($table)->cols( array_keys( $form_data ) )->bindValues($form_data);
         * $this->db->perform($insert->__toString(),$insert->getBindValues());
         * $insert->getLastInsertIdName() //what does this one do?
         */
        /*$insert
            ->into( 'whiskies' )
            ->cols(
                array(
                    'name'           => 'Highland Single Malt',
                    'distiller_name' => 'Tomatin'
                )
            );*/

        // a PDO connection
        /*try {
            $pdo = new \PDO( $config['db.pdo.connect'] );
            $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            #$pdo->exec( 'CREATE TABLE whiskies (name TEXT, distiller_name TEXT)');
            $sth = $pdo->prepare( $insert->__toString() );
            $sth->execute( $insert->getBindValues() );

            // get the results back as an associative array
            $result = $sth->fetch( \PDO::FETCH_ASSOC );
        } catch ( \Exception $e ) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }*/
    }

    $data['form'] = $helpers->render_manage_form( $whisky_data );

    echo $templates->render( 'tmpl-manage', $data );
} );

/**
 * Displays information about a chosen whisky.
 */
$app->get( '/manage/{id:[0-9]+}/', function ( $request, $response, $args ) use ( $app ) {
    $helpers = $app->form_helpers;

    $templates = $app->plates;

    $whisky_id    = $args['id'];
    $whisky_data  = [ ]; # Need to fetch data for specified ID
    $data['form'] = $helpers->render_manage_form( $whisky_data );

    // Render a template
    echo $templates->render( 'tmpl-manage', $data );
} );

/**
 * Updates information about an existing whisky.
 */
$app->post( '/manage/{id}/', function ( $request, $response, $args ) use ( $app ) {
    $helpers   = $app->form_helpers;
    $templates = $app->plates;


    $form_data   = $request->getParsedBody();
    $whisky_id   = $args['id'];
    $whisky_data = [ ]; # Populate with sanitized $form_data and after saving.
    # https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md

    $data['form'] = $helpers->render_manage_form( $whisky_data );

    echo $templates->render( 'tmpl-manage', $data );
} );
