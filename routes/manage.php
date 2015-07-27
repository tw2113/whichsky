<?php

namespace tw2113\Whichsky;

use \Slim\Slim as Slim;
use \Slim\Logger as Logger;
use \Aura\SqlQuery\QueryFactory;
use \League\Plates\Engine as Plates;
use \AdamWathan\Form\FormBuilder;
use Respect\Validation\Validator as v;

/**
 * Handle new whisky form display/submission.
 */
$app->map( [ 'GET', 'POST' ], '/manage/new/', function ( $request, $response, $args ) use ( $app ) {

    $templates = $app->plates;

    $type = $request->getMethod();

    $whisky_data = array(); # Populate with sanitized $form_data and after saving.

    if ( 'POST' === $type ) {
        # https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md
        $form_data = $request->getParsedBody();
        # Validate and populate $whisky_data with values.
        # Redirect to new ID page after successful POST ?
        #   May not need to pass in $whisky_data to render_manage_form() if we redirect.
    }

    $data['form'] = render_manage_form( $whisky_data );

    echo $templates->render('tmpl-manage', $data );
});

/**
 * Displays information about a chosen whisky.
 */
$app->get('/manage/{id}/', function( $request, $response, $args ) use ($app) {
    $templates = $app->plates;

    $whisky_id = $args['id'];
    $whisky_data = array(); # Need to fetch data for specified ID
    $data['form'] = render_manage_form( $whisky_data );

    // Render a template
    echo $templates->render('tmpl-manage', $data );
});

/**
 * Updates information about an existing whisky.
 */
$app->post('/manage/{id}/', function( $request, $response, $args ) use ($app) {

    $templates = $app->plates;


    $form_data = $request->getParsedBody();
    $whisky_id = $args['id'];
    $whisky_data = array(); # Populate with sanitized $form_data and after saving.
    # https://github.com/Respect/Validation/blob/master/docs/VALIDATORS.md

    $data['form'] = render_manage_form( $whisky_data );

    echo $templates->render('tmpl-manage', $data );
});

/**
 * Renders our whisky management form.
 *
 * @param array $whisky_data Array of data to populate the form with.
 *
 * @return $this|string
 */
function render_manage_form( $whisky_data = array() ) {
    $builder = new FormBuilder;

    $fields = array(
        array( 'type' => 'text', 'label' => 'Whisky Name', 'id' => 'whisky_name' ),
        array( 'type' => 'text', 'label' => 'Distilllery Name', 'id' => 'distillery_name' ),
        array( 'type' => 'text', 'label' => 'Years Matured', 'id' => 'years_matured' ),
        array( 'type' => 'text', 'label' => 'Style', 'id' => 'style' ),
        array( 'type' => 'text', 'label' => 'Years Matured', 'id' => 'years_matured' ),
        array( 'type' => 'text', 'label' => 'Volume', 'id' => 'volume' ),
        array( 'type' => 'text', 'label' => 'Price', 'id' => 'price' ),
        array( 'type' => 'text', 'label' => 'Date Purchased', 'id' => 'date_purchased' ),
        array( 'type' => 'text', 'label' => 'Date Opened', 'id' => 'date_opened' ),
        array( 'type' => 'text', 'label' => 'ABV', 'id' => 'abv' ),
        array( 'type' => 'textarea', 'label' => 'Packaging Description', 'id' => 'packaging_description' ),
        array( 'type' => 'textarea', 'label' => 'Aroma', 'id' => 'aroma' ),
        array( 'type' => 'textarea', 'label' => 'Palet', 'id' => 'palet' ),
        array( 'type' => 'textarea', 'label' => 'Finish', 'id' => 'finish' ),
    );

    $form  = $builder->open()->addClass('pure-form');

    foreach ( $fields as $field ) {
        $form .= '<div class="pure-u-1-1">';
        switch ( $field['type'] ) {
            case 'text':
                $form .= $builder->label( $field['label'] )->forId( $field['id'] ) . '<br/>';
                $form .= $builder->text( $field['id'] )->id( $field['id'] ) . '<br/>';
                break;

            case 'textarea':
                $form .= $builder->label( $field['label'] )->forId( $field['id'] ) . '<br/>';
                $form .= $builder->textarea( $field['id'] )->id( $field['id'] )->rows(5);
                break;
        }
        $form .= '</div>';
    }

    $form .= $builder->submit('Add whisky')->addClass('pure-button button-secondary button-xlarge');
    $form .= $builder->close();

    /*
picture
on_wishlist
comments
     */

    return $form;
}
