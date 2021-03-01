<?php
/*
Plugin Name: Test 3
Description: A shortcode generator plugin for Test 3
Author: Davide Guerra
Version: 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 

 function show_product_variations() {
	global $product;
	// Check if this product is a variable one
	if ( $product->is_type( 'variable' ) ) {
		$variations = $product->get_available_variations();
		$variations_id = wp_list_pluck( $variations, 'variation_id' );
		
		// Check if the 'colore' attribute exists
		$colors_exist = true;
		foreach($variations_id as $check) {
			if (empty(get_post_meta($check, 'attribute_pa_colore', true))) {
				$colors_exist = false;
				break;
			}	
		}
		if ($colors_exist) {
			// Create a string
			$string  = '<div id="variations-list">';
			$string .= 'Disponibile anche nei colori:';
			$string .= '<ul class="variation-list">';
			// For each variation find attribute name and price
			foreach ($variations_id as $single_variation) {
				$attribute_name = get_post_meta($single_variation, 'attribute_pa_colore', true);
				$attribute_price = get_post_meta($single_variation, '_price', true);
				$string .= '<li class="variation-item">' . $attribute_name . ' a ' .$attribute_price . '€</li>';
			}
			$string .= '</ul>';
			$string .='</div>';
			return $string;
		}	
	}
}
add_shortcode('variations_list', 'show_product_variations');