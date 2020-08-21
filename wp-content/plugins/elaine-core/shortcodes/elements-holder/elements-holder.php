<?php
namespace ElaineCore\CPT\Shortcodes\ElementsHolder;

use ElaineCore\Lib;

class ElementsHolder implements Lib\ShortcodeInterface {
	private $base;
	
	function __construct() {
		$this->base = 'edgtf_elements_holder';
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map(
				array(
					'name'      => esc_html__( 'Elements Holder', 'elaine-core' ),
					'base'      => $this->base,
					'icon'      => 'icon-wpb-elements-holder extended-custom-icon',
					'category'  => esc_html__( 'by ELAINE', 'elaine-core' ),
					'as_parent' => array( 'only' => 'edgtf_elements_holder_item' ),
					'js_view'   => 'VcColumnView',
					'params'    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'custom_class',
							'heading'     => esc_html__( 'Custom CSS Class', 'elaine-core' ),
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'holder_full_height',
							'heading'     => esc_html__( 'Enable Holder Full Height', 'elaine-core' ),
							'value'       => array_flip( elaine_edge_get_yes_no_select_array( false ) ),
							'save_always' => true
						),
						array(
							'type'       => 'colorpicker',
							'param_name' => 'background_color',
							'heading'    => esc_html__( 'Background Color', 'elaine-core' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'number_of_columns',
							'heading'     => esc_html__( 'Columns', 'elaine-core' ),
							'value'       => array(
								esc_html__( '1 Column', 'elaine-core' )  => 'one-column',
								esc_html__( '2 Columns', 'elaine-core' ) => 'two-columns',
								esc_html__( '3 Columns', 'elaine-core' ) => 'three-columns',
								esc_html__( '4 Columns', 'elaine-core' ) => 'four-columns',
								esc_html__( '5 Columns', 'elaine-core' ) => 'five-columns',
								esc_html__( '6 Columns', 'elaine-core' ) => 'six-columns'
							),
							'save_always' => true
						),
						array(
							'type'       => 'checkbox',
							'param_name' => 'items_float_left',
							'heading'    => esc_html__( 'Items Float Left', 'elaine-core' ),
							'value'      => array( 'Make Items Float Left?' => 'yes' )
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'switch_to_one_column',
							'heading'     => esc_html__( 'Switch to One Column', 'elaine-core' ),
							'value'       => array(
								esc_html__( 'Default', 'elaine-core' )      => '',
								esc_html__( 'Below 1366px', 'elaine-core' ) => '1366',
								esc_html__( 'Below 1024px', 'elaine-core' ) => '1024',
								esc_html__( 'Below 768px', 'elaine-core' )  => '768',
								esc_html__( 'Below 680px', 'elaine-core' )  => '680',
								esc_html__( 'Below 480px', 'elaine-core' )  => '480',
								esc_html__( 'Never', 'elaine-core' )        => 'never'
							),
							'description' => esc_html__( 'Choose on which stage item will be in one column', 'elaine-core' ),
							'save_always' => true
						),
						array(
							'type'        => 'dropdown',
							'param_name'  => 'alignment_one_column',
							'heading'     => esc_html__( 'Choose Alignment In Responsive Mode', 'elaine-core' ),
							'value'       => array(
								esc_html__( 'Default', 'elaine-core' ) => '',
								esc_html__( 'Left', 'elaine-core' )    => 'left',
								esc_html__( 'Center', 'elaine-core' )  => 'center',
								esc_html__( 'Right', 'elaine-core' )   => 'right'
							),
							'description' => esc_html__( 'Alignment When Items are in One Column', 'elaine-core' ),
							'save_always' => true
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'custom_class'         => '',
			'holder_full_height'   => 'no',
			'background_color'     => '',
			'number_of_columns'    => 'one-column',
			'items_float_left'     => '',
			'switch_to_one_column' => '',
			'alignment_one_column' => ''
		);
		$params = shortcode_atts( $args, $atts );
		
		$holder_classes = $this->getHolderClasses( $params );
		$holder_styles  = $this->getHolderStyles( $params );
		
		$html = '<div ' . elaine_edge_get_class_attribute( $holder_classes ) . ' ' . elaine_edge_get_inline_attr( $holder_styles, 'style' ) . '>';
			$html .= do_shortcode( $content );
		$html .= '</div>';
		
		return $html;
	}
	
	private function getHolderClasses( $params ) {
		$holderClasses = array( 'edgtf-elements-holder' );
		
		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = $params['holder_full_height'] === 'yes' ? 'edgtf-eh-full-height' : '';
		$holderClasses[] = ! empty( $params['number_of_columns'] ) ? 'edgtf-' . $params['number_of_columns'] : '';
		$holderClasses[] = $params['items_float_left'] !== '' ? 'edgtf-ehi-float' : '';
		$holderClasses[] = ! empty( $params['switch_to_one_column'] ) ? 'edgtf-responsive-mode-' . $params['switch_to_one_column'] : 'edgtf-responsive-mode-768';
		$holderClasses[] = ! empty( $params['alignment_one_column'] ) ? 'edgtf-one-column-alignment-' . $params['alignment_one_column'] : '';
		
		return implode( ' ', $holderClasses );
	}
	
	private function getHolderStyles( $params ) {
		$styles = array();
		
		if ( ! empty( $params['background_color'] ) ) {
			$styles[] = 'background-color: ' . $params['background_color'];
		}
		
		return implode( ';', $styles );
	}
}
