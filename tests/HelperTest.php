<?php

namespace tw2113\Whichsky;

class HelperTest extends \PHPUnit_Framework_TestCase
{

    public function testInstanceOf()
    {
        $helper = new Form_Helpers( new \AdamWathan\Form\FormBuilder() );

        $this->assertInstanceOf( 'tw2113\Whichsky\Form_Helpers', $helper );
    }

    public function testDefaultFields()
    {
        $helper   = new Form_Helpers( new \AdamWathan\Form\FormBuilder() );
        $defaults = $helper->get_default_fields();
        $this->assertNotEmpty( $defaults );

        $example = [ 'whisky_name'           => '',
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

        $this->assertSame( $example, $defaults );
    }

    public function testPopulateData()
    {

    }

    public function testRenderManageForm()
    {

    }
}
