<?php

namespace tw2113\Whichsky;

use AdamWathan\Form\FormBuilder;

class Form_Helpers
{

    private $builder = null;

    public function __construct( FormBuilder $builder )
    {
        $this->builder = $builder;
    }

    /**
     * Renders our whisky management form.
     *
     * @param array $whisky_data Array of data to populate the form with.
     *
     * @return $this|string
     */
    public function render_manage_form( $whisky_data = [ ] )
    {

        if (empty( $whisky_data )) {
            $whisky_data = $this->get_default_fields();
        }

        $data = $this->populate_data( $whisky_data );

        $fields = [
            [ 'type' => 'text', 'label' => 'Whisky Name', 'id' => 'whisky_name', 'value' => $data['whisky_name'] ],
            [
                'type'  => 'text',
                'label' => 'Distilllery Name',
                'id'    => 'distillery_name',
                'value' => $data['distillery_name']
            ],
            [
                'type'  => 'text',
                'label' => 'Years Matured',
                'id'    => 'years_matured',
                'value' => $data['years_matured']
            ],
            [ 'type' => 'text', 'label' => 'Style', 'id' => 'style', 'value' => $data['style'] ],
            [
                'type'  => 'text',
                'label' => 'Years Matured',
                'id'    => 'years_matured',
                'value' => $data['years_matured']
            ],
            [ 'type' => 'text', 'label' => 'Volume', 'id' => 'volume', 'value' => $data['volume'] ],
            [ 'type' => 'text', 'label' => 'Price', 'id' => 'price', 'value' => $data['price'] ],
            [
                'type'  => 'text',
                'label' => 'Date Purchased',
                'id'    => 'date_purchased',
                'value' => $data['date_purchased']
            ],
            [ 'type' => 'text', 'label' => 'Date Opened', 'id' => 'date_opened', 'value' => $data['date_opened'] ],
            [ 'type' => 'text', 'label' => 'ABV', 'id' => 'abv', 'value' => $data['abv'] ],
            [
                'type'  => 'textarea',
                'label' => 'Packaging Description',
                'id'    => 'packaging_description',
                'value' => $data['packaging_description']
            ],
            [ 'type' => 'textarea', 'label' => 'Aroma', 'id' => 'aroma', 'value' => $data['aroma'] ],
            [ 'type' => 'textarea', 'label' => 'Palate', 'id' => 'palate', 'value' => $data['palate'] ],
            [ 'type' => 'textarea', 'label' => 'Finish', 'id' => 'finish', 'value' => $data['finish'] ],
        ];

        $form = $this->builder->open()->addClass( 'pure-form' );

        foreach ($fields as $field) {
            $form .= '<div class="pure-u-1-1">';
            switch ($field['type']) {
                case 'text':
                    $form .= $this->builder->label( $field['label'] )->forId( $field['id'] ) . '<br/>';
                    $form .= $this->builder->text( $field['id'] )->id( $field['id'] )->value( $field['value'] ) . '<br/>';
                    break;

                case 'textarea':
                    $form .= $this->builder->label( $field['label'] )->forId( $field['id'] ) . '<br/>';
                    $form .= $this->builder->textarea( $field['id'] )->id( $field['id'] )->rows( 5 )->value( $field['value'] );
                    break;
            }
            $form .= '</div>';
        }

        $form .= $this->builder->submit( 'Add whisky' )->addClass( 'pure-button button-secondary button-xlarge' );
        $form .= $this->builder->close();

        /*
    picture
    on_wishlist
    comments
         */

        return $form;
    }

    /**
     * Return array of default field keys.
     * @return array Array of our default field keys
     */
    public function get_default_fields()
    {
        return [
            'whisky_name'           => '',
            'distillery_name'       => '',
            'years_matured'         => '',
            'style'                 => '',
            'years_matured'         => '',
            'volume'                => '',
            'price'                 => '',
            'date_purchased'        => '',
            'date_opened'           => '',
            'abv'                   => '',
            'packaging_description' => '',
            'aroma'                 => '',
            'palate'                => '',
            'finish'                => ''
        ];
    }

    /**
     * Fills in values for the form.
     *
     * @param array $whisky_data Array of our provided values.
     *
     * @return array
     */
    public function populate_data( $whisky_data = [ ] )
    {

        # $whisky_data will be populated either with our saved whisky data or empty strings.
        foreach ($whisky_data as $key => $value) {
            $whisky_data[$key] = ( ! empty( $value ) ) ? $value : '';
        }

        return $whisky_data;
    }
}
