<?php

if ( ! function_exists( 'elaine_edge_content_bottom_options_map' ) ) {
	function elaine_edge_content_bottom_options_map() {
		
		$panel_content_bottom = elaine_edge_add_admin_panel(
			array(
				'page'  => '_page_page',
				'name'  => 'panel_content_bottom',
				'title' => esc_html__( 'Content Bottom Area Style', 'elaine' )
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'name'          => 'enable_content_bottom_area',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Content Bottom Area', 'elaine' ),
				'description'   => esc_html__( 'This option will enable Content Bottom area on pages', 'elaine' ),
				'parent'        => $panel_content_bottom
			)
		);
		
		$enable_content_bottom_area_container = elaine_edge_add_admin_container(
			array(
				'parent'          => $panel_content_bottom,
				'name'            => 'enable_content_bottom_area_container',
				'dependency' => array(
					'show' => array(
						'enable_content_bottom_area'  => 'yes'
					)
				)
			)
		);
		
		$elaine_custom_sidebars = elaine_edge_get_custom_sidebars();
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'selectblank',
				'name'          => 'content_bottom_sidebar_custom_display',
				'default_value' => '',
				'label'         => esc_html__( 'Widget Area to Display', 'elaine' ),
				'description'   => esc_html__( 'Choose a Content Bottom widget area to display', 'elaine' ),
				'options'       => $elaine_custom_sidebars,
				'parent'        => $enable_content_bottom_area_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'          => 'yesno',
				'name'          => 'content_bottom_in_grid',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Display in Grid', 'elaine' ),
				'description'   => esc_html__( 'Enabling this option will place Content Bottom in grid', 'elaine' ),
				'parent'        => $enable_content_bottom_area_container
			)
		);
		
		elaine_edge_add_admin_field(
			array(
				'type'        => 'color',
				'name'        => 'content_bottom_background_color',
				'label'       => esc_html__( 'Background Color', 'elaine' ),
				'description' => esc_html__( 'Choose a background color for Content Bottom area', 'elaine' ),
				'parent'      => $enable_content_bottom_area_container
			)
		);
	}
	
	add_action( 'elaine_edge_action_additional_page_options_map', 'elaine_edge_content_bottom_options_map' );
}