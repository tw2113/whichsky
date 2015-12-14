<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Aura\SqlQuery\QueryFactory;
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

        $query_factory = new QueryFactory( 'sqlite' );
        $insert        = $query_factory->newInsert();

        $insert
            ->into( 'whiskies' )
            ->cols(
                [
                    'name',
                    'whisky_abv',
                    'distiller_name',
                    'distiller_id',
                    'packaging_description',
                    'years_matured',
                    'style',
                    'volume',
                    'price',
                    'aroma',
                    'palate',
                    'finish',
                    'date_purchased',
                    'date_opened'
                ]
            )
            ->bindValues(
                [
                    'name'                  => $form_data['whisky_name'],
                    'whisky_abv'            => $form_data['abv'],
                    'distillery_name'       => $form_data['distillery_name'],
                    'packaging_description' => $form_data['packaging_description'],
                    'years_matured'         => $form_data['years_matured'],
                    'style'                 => $form_data['style'],
                    'volume'                => $form_data['volume'],
                    'price'                 => $form_data['price'],
                    'aroma'                 => $form_data['aroma'],
                    'palate'                => $form_data['palate'],
                    'finish'                => $form_data['finish'],
                    'date_purchased'        => $form_data['date_purchased'],
                    'date_opened'           => $form_data['date_opened']
                ]
            );

        try {
            $pdo = new \PDO( $config['db.pdo.connect'] );
            $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

            $sth = $pdo->prepare( $insert->__toString() );
            $sth->execute( $insert->getBindValues() );

            // get the results back as an associative array
            $result = $sth->fetch( \PDO::FETCH_ASSOC );
        } catch ( \Exception $e ) {
            $logger = new Logger( 'manage_errors' );
            $logger->pushHandler( new StreamHandler( 'logs/error.log', Logger::WARNING ) );

            $logger->addError( "Caught manage POST exception: {$e->getMessage()}" );
            $data['error'] = true;
        }
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
