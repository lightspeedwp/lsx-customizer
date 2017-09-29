<?php

/**
 * Filter: lsx_customizer_colour_names
 *
 * Add two new colors (test) in main array of colors
 */
function test_lsx_customizer_colour_names( $array ) {
	$array['test_text_color']       = esc_html__( 'TEST: Text', 'lsx-customizer' );
	$array['test_text_color_hover'] = esc_html__( 'TEST: Text (hover)', 'lsx-customizer' );
	return $array;
}
add_filter( 'lsx_customizer_colour_names', 'test_lsx_customizer_colour_names' );

/**
 * Filter: lsx_customizer_colour_choices_default
 *
 * Add the new colors (test) in default scheme
 */
function test_lsx_customizer_colour_choices_default( $array ) {
	$array['test_text_color']       = '#ddddd1';
	$array['test_text_color_hover'] = '#eeeee1';
	return $array;
}
add_filter( 'lsx_customizer_colour_choices_default', 'test_lsx_customizer_colour_choices_default' );

/**
 * Filter: lsx_customizer_colour_choices_red
 *
 * Add the new colors (test) in red scheme
 */
function test_lsx_customizer_colour_choices_red( $array ) {
	$array['test_text_color']       = '#ddddd2';
	$array['test_text_color_hover'] = '#eeeee2';
	return $array;
}
add_filter( 'lsx_customizer_colour_choices_red', 'test_lsx_customizer_colour_choices_red' );

/**
 * Filter: lsx_customizer_colour_choices_orange
 *
 * Add the new colors (test) in orange scheme
 */
function test_lsx_customizer_colour_choices_orange( $array ) {
	$array['test_text_color']       = '#ddddd3';
	$array['test_text_color_hover'] = '#eeeee3';
	return $array;
}
add_filter( 'lsx_customizer_colour_choices_orange', 'test_lsx_customizer_colour_choices_orange' );

/**
 * Filter: lsx_customizer_colour_choices_green
 *
 * Add the new colors (test) in green scheme
 */
function test_lsx_customizer_colour_choices_green( $array ) {
	$array['test_text_color']       = '#ddddd4';
	$array['test_text_color_hover'] = '#eeeee4';
	return $array;
}
add_filter( 'lsx_customizer_colour_choices_green', 'test_lsx_customizer_colour_choices_green' );

/**
 * Filter: lsx_customizer_colour_choices_brown
 *
 * Add the new colors (test) in brown scheme
 */
function test_lsx_customizer_colour_choices_brown( $array ) {
	$array['test_text_color']       = '#ddddd5';
	$array['test_text_color_hover'] = '#eeeee5';
	return $array;
}
add_filter( 'lsx_customizer_colour_choices_brown', 'test_lsx_customizer_colour_choices_brown' );

/**
 * Filter: lsx_customizer_colour_choices
 *
 * Add a new scheme
 * Also add the new colors (test) in new scheme
 */
function test_lsx_customizer_colour_choices( $array ) {
	$array['test'] = array(
		'label'  => esc_html__( 'Test', 'lsx-customizer' ),
		'colors' => array(
			'button_background_color'       => '#428bca',
			'button_background_hover_color' => '#2a6496',
			'button_text_color'             => '#ffffff',
			'button_text_color_hover'       => '#ffffff',
			'button_shadow'                 => '#2a6496',

			'button_cta_background_color'       => '#f7941d',
			'button_cta_background_hover_color' => '#f7741d',
			'button_cta_text_color'             => '#ffffff',
			'button_cta_text_color_hover'       => '#ffffff',
			'button_cta_shadow'                 => '#f7741d',

			'top_menu_background_color'          => '#333333',
			'top_menu_link_color'                => '#ffffff',
			'top_menu_link_hover_color'          => '#428bca',
			'top_menu_icon_color'                => '#428bca',
			'top_menu_icon_hover_color'          => '#ffffff',
			'top_menu_dropdown_color'            => '#333333',
			'top_menu_dropdown_hover_color'      => '#444444',
			'top_menu_dropdown_link_color'       => '#ffffff',
			'top_menu_dropdown_link_hover_color' => '#428bca',

			'header_background_color'  => '#ffffff',
			'header_link_color'        => '#428bca',
			'header_link_hover_color'  => '#1072c9',
			'header_description_color' => '#555555',

			'main_menu_background_color'                => '#ffffff',
			'main_menu_link_color'                      => '#555555',
			'main_menu_link_hover_color'                => '#ffffff',
			'main_menu_dropdown_background_color'       => '#428bca',
			'main_menu_dropdown_background_hover_color' => '#1072c9',
			'main_menu_dropdown_link_color'             => '#ffffff',
			'main_menu_dropdown_link_hover_color'       => '#dddddd',

			'banner_background_color'               => '#2a6496',
			'banner_text_color'                     => '#ffffff',
			'banner_text_image_color'               => '#ffffff',
			'banner_breadcrumb_background_color'    => '#374750',
			'banner_breadcrumb_text_color'          => '#919191',
			'banner_breadcrumb_text_selected_color' => '#ffffff',

			'background_color'                       => '#ffffff',
			'body_line_color'                        => '#dddddd',
			'body_text_heading_color'                => '#333333',
			'body_text_small_color'                  => '#919191',
			'body_text_color'                        => '#333333',
			'body_link_color'                        => '#596b46',
			'body_link_hover_color'                  => '#3d4a30',
			'body_section_full_background_color'     => '#596b46',
			'body_section_full_text_color'           => '#ffffff',
			'body_section_full_link_color'           => '#eeeeee',
			'body_section_full_link_hover_color'     => '#dddddd',
			'body_section_full_cta_background_color' => '#333333',
			'body_section_full_cta_text_color'       => '#ffffff',
			'body_section_full_cta_link_color'       => '#eeeeee',
			'body_section_full_cta_link_hover_color' => '#dddddd',

			'footer_cta_background_color' => '#428bca',
			'footer_cta_text_color'       => '#ffffff',
			'footer_cta_link_color'       => '#dddddd',
			'footer_cta_link_hover_color' => '#ffffff',

			'footer_widgets_background_color' => '#333333',
			'footer_widgets_text_color'       => '#eeeeee',
			'footer_widgets_link_color'       => '#428bca',
			'footer_widgets_link_hover_color' => '#1072c9',

			'footer_background_color' => '#232222',
			'footer_text_color'       => '#ffffff',
			'footer_link_color'       => '#428bca',
			'footer_link_hover_color' => '#1072c9',

			'test_text_color'       => '#ddddd6',
			'test_text_color_hover' => '#eeeee6',
		),
	);

	return $array;
}
add_filter( 'lsx_customizer_colour_choices', 'test_lsx_customizer_colour_choices' );

/**
 * Filter: lsx_customizer_colour_selectors_button
 *
 * Add new selectors in "button" group of colours
 */
function test_lsx_customizer_colour_selectors_button( $css, $colors ) {
	$css .= <<<CSS

	/* Button TEST */

	.selector-test-button {
		attr1: {$colors['button_background_color']};
		attr2: {$colors['button_background_hover_color']};
		attr3: {$colors['button_text_color']};
		attr4: {$colors['button_text_color_hover']};
		attr5: {$colors['button_shadow']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_button', 'test_lsx_customizer_colour_selectors_button', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_button_cta
 *
 * Add new selectors in "button cta" group of colours
 */
function test_lsx_customizer_colour_selectors_button_cta( $css, $colors ) {
	$css .= <<<CSS

	/* Button CTA TEST */

	.selector-test-button-cta {
		attr1: {$colors['button_cta_background_color']};
		attr2: {$colors['button_cta_background_hover_color']};
		attr3: {$colors['button_cta_text_color']};
		attr4: {$colors['button_cta_text_color_hover']};
		attr5: {$colors['button_cta_shadow']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_button_cta', 'test_lsx_customizer_colour_selectors_button_cta', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_top_menu
 *
 * Add new selectors in "top menu" group of colours
 */
function test_lsx_customizer_colour_selectors_top_menu( $css, $colors ) {
	$css .= <<<CSS

	/* Top Menu TEST */

	.selector-test-top-menu {
		attr1: {$colors['top_menu_background_color']};
		attr2: {$colors['top_menu_link_color']};
		attr3: {$colors['top_menu_link_hover_color']};
		attr3: {$colors['top_menu_icon_color']};
		attr3: {$colors['top_menu_icon_hover_color']};
		attr3: {$colors['top_menu_dropdown_color']};
		attr3: {$colors['top_menu_dropdown_hover_color']};
		attr3: {$colors['top_menu_dropdown_link_color']};
		attr3: {$colors['top_menu_dropdown_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_top_menu', 'test_lsx_customizer_colour_selectors_top_menu', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_header
 *
 * Add new selectors in "header" group of colours
 */
function test_lsx_customizer_colour_selectors_header( $css, $colors ) {
	$css .= <<<CSS

	/* Header TEST */

	.selector-test-header {
		attr1: {$colors['header_background_color']};
		attr2: {$colors['header_link_color']};
		attr3: {$colors['header_link_hover_color']};
		attr4: {$colors['header_description_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_header', 'test_lsx_customizer_colour_selectors_header', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_main_menu
 *
 * Add new selectors in "main meun" group of colours
 */
function test_lsx_customizer_colour_selectors_main_menu( $css, $colors ) {
	$css .= <<<CSS

	/* Main Menu TEST */

	.selector-test-main-menu {
		attr1: {$colors['main_menu_background_color']};
		attr2: {$colors['main_menu_link_color']};
		attr3: {$colors['main_menu_link_hover_color']};
		attr4: {$colors['main_menu_dropdown_background_color']};
		attr5: {$colors['main_menu_dropdown_background_hover_color']};
		attr6: {$colors['main_menu_dropdown_link_color']};
		attr7: {$colors['main_menu_dropdown_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_main_menu', 'test_lsx_customizer_colour_selectors_main_menu', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_banner
 *
 * Add new selectors in "banner" group of colours
 */
function test_lsx_customizer_colour_selectors_banner( $css, $colors ) {
	$css .= <<<CSS

	/* Banner TEST */

	.selector-test-banner {
		attr1: {$colors['banner_background_color']};
		attr2: {$colors['banner_text_color']};
		attr3: {$colors['banner_text_image_color']};
		attr4: {$colors['banner_breadcrumb_background_color']};
		attr5: {$colors['banner_breadcrumb_text_color']};
		attr6: {$colors['banner_breadcrumb_text_selected_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_banner', 'test_lsx_customizer_colour_selectors_banner', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_body
 *
 * Add new selectors in "body" group of colours
 */
function test_lsx_customizer_colour_selectors_body( $css, $colors ) {
	$css .= <<<CSS

	/* Body TEST */

	.selector-test-body {
		attr1: {$colors['background_color']};
		attr2: {$colors['body_line_color']};
		attr3: {$colors['body_text_heading_color']};
		attr4: {$colors['body_text_small_color']};
		attr5: {$colors['body_text_color']};
		attr6: {$colors['body_link_color']};
		attr7: {$colors['body_link_hover_color']};
		attr8: {$colors['body_section_full_background_color']};
		attr9: {$colors['body_section_full_text_color']};
		attr10: {$colors['body_section_full_link_color']};
		attr11: {$colors['body_section_full_link_hover_color']};
		attr12: {$colors['body_section_full_cta_background_color']};
		attr13: {$colors['body_section_full_cta_text_color']};
		attr14: {$colors['body_section_full_cta_link_color']};
		attr15: {$colors['body_section_full_cta_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_body', 'test_lsx_customizer_colour_selectors_body', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_footer_cta
 *
 * Add new selectors in "footer cta" group of colours
 */
function test_lsx_customizer_colour_selectors_footer_cta( $css, $colors ) {
	$css .= <<<CSS

	/* Footer CTA TEST */

	.selector-test-footer-cta {
		attr1: {$colors['footer_cta_background_color']};
		attr2: {$colors['footer_cta_text_color']};
		attr3: {$colors['footer_cta_link_color']};
		attr4: {$colors['footer_cta_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_footer_cta', 'test_lsx_customizer_colour_selectors_footer_cta', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_footer_widgets
 *
 * Add new selectors in "footer widgets" group of colours
 */
function test_lsx_customizer_colour_selectors_footer_widgets( $css, $colors ) {
	$css .= <<<CSS

	/* Footer Widgets TEST */

	.selector-test-footer-widgets {
		attr1: {$colors['footer_widgets_background_color']};
		attr2: {$colors['footer_widgets_text_color']};
		attr3: {$colors['footer_widgets_link_color']};
		attr4: {$colors['footer_widgets_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_footer_widgets', 'test_lsx_customizer_colour_selectors_footer_widgets', 10, 2 );

/**
 * Filter: lsx_customizer_colour_selectors_footer
 *
 * Add new selectors in "footer" group of colours
 */
function test_lsx_customizer_colour_selectors_footer( $css, $colors ) {
	$css .= <<<CSS

	/* Footer TEST */

	.selector-test-footer {
		attr1: {$colors['footer_background_color']};
		attr2: {$colors['footer_text_color']};
		attr3: {$colors['footer_link_color']};
		attr4: {$colors['footer_link_hover_color']};
	}
CSS;

	return $css;
}
add_filter( 'lsx_customizer_colour_selectors_footer', 'test_lsx_customizer_colour_selectors_footer', 10, 2 );
