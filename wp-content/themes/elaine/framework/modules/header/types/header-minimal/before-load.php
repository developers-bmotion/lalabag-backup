<?php

if ( ! function_exists( 'elaine_edge_set_header_minimal_type_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function elaine_edge_set_header_minimal_type_global_option( $header_types ) {
		$header_types['header-minimal'] = array(
			'image' => EDGE_FRAMEWORK_HEADER_TYPES_ROOT . '/header-minimal/assets/img/header-minimal.png',
			'label' => esc_html__( 'Minimal', 'elaine' )
		);
		
		return $header_types;
	}
	
	add_filter( 'elaine_edge_filter_header_type_global_option', 'elaine_edge_set_header_minimal_type_global_option' );
}

if ( ! function_exists( 'elaine_edge_set_header_minimal_type_meta_boxes_option' ) ) {
	/**
	 * This function set header type value for header meta boxes map
	 */
	function elaine_edge_set_header_minimal_type_meta_boxes_option( $header_type_options ) {
		$header_type_options['header-minimal'] = esc_html__( 'Minimal', 'elaine' );
		
		return $header_type_options;
	}
	
	add_filter( 'elaine_edge_filter_header_type_meta_boxes', 'elaine_edge_set_header_minimal_type_meta_boxes_option' );
}

if ( ! function_exists( 'elaine_edge_set_hide_dep_options_header_minimal' ) ) {
	/**
	 * This function is used to hide all containers/panels for admin options when this header type is selected
	 */
	function elaine_edge_set_hide_dep_options_header_minimal( $hide_dep_options ) {
		$hide_dep_options[] = 'header-minimal';
		
		return $hide_dep_options;
	}
	
	// header global panel options
	add_filter( 'elaine_edge_filter_header_logo_area_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_main_menu_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	
	// header global panel meta boxes
	add_filter( 'elaine_edge_filter_header_logo_area_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_header_minimal' );
	
	// header types panel options
	add_filter( 'elaine_edge_filter_header_centered_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_standard_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_vertical_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_vertical_menu_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_vertical_closed_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_vertical_sliding_hide_global_option', 'elaine_edge_set_hide_dep_options_header_minimal' );
	
	// header types panel meta boxes
	add_filter( 'elaine_edge_filter_header_centered_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_standard_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_header_minimal' );
	add_filter( 'elaine_edge_filter_header_vertical_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_header_minimal' );

	// header dropdown styles meta boxes
	add_filter( 'elaine_edge_filter_dropdown_hide_meta_boxes', 'elaine_edge_set_hide_dep_options_header_minimal' );
}