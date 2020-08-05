<?php
/**
 * Plugin generic functions file
 *
 * @package Video gallery and Player
 * @since 2.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Function to get unique number
 * 
 * @package Video gallery and Player
 * @since 2.0.0
 */ 
 function wp_html5vp_get_unique() {
    static $unique = 0;
    $unique++;

    return $unique;
}

/**
 * Function to add array after specific key
 * 
 * @package Video gallery and Player
 * @since 2.0.0
 */
function wp_html5vp_add_array(&$array, $value, $index, $from_last = false) {
    
    if( is_array($array) && is_array($value) ) {

        if( $from_last ) {
            $total_count    = count($array);
            $index          = (!empty($total_count) && ($total_count > $index)) ? ($total_count-$index): $index;
        }
        
        $split_arr  = array_splice($array, max(0, $index));
        $array      = array_merge( $array, $value, $split_arr);
    }
    return $array;
}