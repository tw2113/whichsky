<?php

namespace tw2113\Whichsky;

/**
 * Display listing of data with markup suitable for a grid.
 * @since   1.0.0
 * Class GridList
 * @package tw2113\Whichsky\Database
 */
class GridList implements Display
{

    /**
     * Classes to use in HTML class attributes.
     * @since 1.0.0
     * @var string
     */
    public $class_attr = '';

    /**
     * Set up our properties.
     * @since 1.0.0
     *
     * @param array $args
     */
    public function __construct( $args = [ ] )
    {
        $this->class_attr = $args['classes'];
    }

    /**
     * Display our final markup for our list of data.
     * @since 1.0.0
     *
     * @param array $list Array of listings to display.
     *
     * @return string Generated markup for list display.
     */
    public function listing( $list = [ ] )
    {
        $listing = '<div class="listing_wrap">';

        foreach ($list as $item) {
            $listing .= $this->item( $item );
        }
        $listng .= '</div>';

        return $listing;
    }

    /**
     * Generate markup for an individual item in our list of data.
     * @since 1.0.0
     *
     * @param array $item Data for a specific listing.
     *
     * @return string Generated markup for our item.
     */
    public function item( $item = [ ] )
    {
        $individual_item = '<div class="' . $this->class_attr . '">';

        $individual_item .= '</div>';

        return $individual_item;
    }
}
