<?php
add_filter( 'su/data/shortcodes', 'rasb_register_button_shortcode', 10, 2 );
function rasb_register_button_shortcode( $shortcodes ) {
	unset( $shortcodes['button'] );

	$shortcodes['button'] = array(
		'name' => __( 'Button', 'ra-shortcodes-bundle' ),
		'type' => 'wrap',
		'group' => 'ra-shortcodes-bundle',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button class', 'ra-shortcodes-bundle' )
			),
			'type' => array(
				'type' => 'select',
				'default' => 'rounded',
				'values' => array(
					'flat' => 'Flat',
					'rounded' => 'Rounded',
					'ghost' => 'Border'
				),
				'name' => 'Button type',
				'desc' => ''
			),
			'background' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Button color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button background color', 'ra-shortcodes-bundle' )
			),
			'background_hover' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Button hover color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button background color on hover', 'ra-shortcodes-bundle' )
			),
			'color' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Text color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text font color', 'ra-shortcodes-bundle' )
			),
			'color_hover' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Text hover color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text font color on hover', 'ra-shortcodes-bundle' )
			),
			'padding' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => '',
				'name' => __( 'Padding', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button padding', 'ra-shortcodes-bundle' )
			),
			'radius' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Border Radius', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Border radius', 'ra-shortcodes-bundle' )
			),
			'border' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Border Width', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button border width', 'ra-shortcodes-bundle' )
			),
			'size' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Font Size', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button font size', 'ra-shortcodes-bundle' )
			),
			'width' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Width', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button width on tablet and largescreen devices.', 'ra-shortcodes-bundle' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Bottom margin', 'ra-shortcodes-bundle' )
			),
			'target' => array(
				'type' => 'select',
				'values' => array(
					'_self' => 'Self',
					'_blank' => 'Blank'
				),
				'default' => '_self',
				'name' => __( 'Target', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button target', 'ra-shortcodes-bundle' )
			),
			'url' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'URL', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Button URL', 'ra-shortcodes-bundle' )
			)
		),
		'content' => __( 'Button text', 'ra-shortcodes-bundle' ),
		'desc' => __( 'Button text', 'ra-shortcodes-bundle' ),
		'icon' => 'code',
		'function' => 'rasb_custom_button_shortcode'
	);

	return $shortcodes;
}

// Button
function rasb_custom_button_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
		'target' => '_self',
		'url' => '',
		'padding' => '',
		'margin' => '',
		'size' => '',
		'width' => '',
		'radius' => '',
		'border' => '',
		'background' => '#333',
		'background_hover' => '',
		'color' => '#fff',
		'color_hover' => '#fff',
		'instance' => $instance,
		'type' => ''
	), $atts, 'button' );
	
	if ( !empty( $atts['background_hover'] ) ) {
		$hover = $atts['background_hover'];
	} elseif ( empty( $atts['background_hover'] ) && !empty( $atts['background'] ) ) {
		$hover = rasb_color_luminance( $atts['background'], -0.1 );
	} else {
		$hover = 'transparent';
	}

	if ( !empty( $atts['background_hover'] ) ) {
		$hover = $atts['background_hover'];
	} else {
		$hover = rasb_color_luminance( $atts['background'], -0.1 );
	}

	if ( $atts['type'] == 'border' ) {
		if ( !empty( $atts['background_hover'] ) ) {
			$hover = $atts['background_hover'];
		} else {
			$hover = $atts['background'];
		}		
	}

	$colorhover = $atts['color_hover'] ? $atts['color_hover'] : $atts['color'];

	$classes = array();
	$classes[] = 'rasb_button';
	$classes[] = 'btn';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$classes[] = $atts['type'] ? 'btn-' . $atts['type'] : 'btn-flat';

	$styles = array();
	if ( !empty( $atts['size'] ) ) $styles['fontSize'] = $atts['size'] . 'px';
	if ( !empty( $atts['padding'] ) ) $styles['padding'] = $atts['padding'] . 'px 0';
	if ( !empty( $atts['radius'] ) ) $styles['borderRadius'] = $atts['radius'] . 'px';
	if ( !empty( $atts['border'] ) ) $styles['borderWidth'] = $atts['border'] . 'px';
	if ( !empty( $atts['width'] ) ) $styles['width'] = $atts['width'] . 'px';
	if ( !empty( $atts['background'] ) ) $styles['backgroundColor'] = $atts['background'];
	if ( !empty( $atts['background'] ) ) $styles['borderColor'] = $atts['background'];
	if ( !empty( $atts['color'] ) ) $styles['color'] = $atts['color'];
	$styles['colorHover'] = $colorhover;
	$styles['hover'] = $hover;

	if ( $atts['margin'] == 0 ) {
		$styles['marginBottom'] = '0px';
	} else {
		$styles['marginBottom'] = $atts['margin'] . 'px';
	}

	if ( $atts['size'] >= 24 ) {
		$styles['tabletSize'] = ($atts['size'] - $atts['size']/4) . 'px';
	}
	
	wp_enqueue_script( 'rasb-vein-js' );
	wp_enqueue_script( 'rasb-shortcodes-js' );
	wp_localize_script( 'rasb-shortcodes-js', 'btn' . $instance, $styles );

	$wraps = array();
	if ( !empty( $atts['width'] ) ) $wraps['width'] = $atts['width'] . 'px';

	$selector = 'btn-' . $instance;

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	$spans = array(
		'class' => 'btn-wrap'
	);

	if ( !empty( $atts['target'] ) ) $attributes['target'] = $atts['target'];
	if ( !empty( $atts['url'] ) ) $attributes['href'] = $atts['url'];

	ob_start(); ?>

	<a <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
		<span <?php foreach( $spans as $name => $value ) echo $name . '="' . $value . '" ' ?>>
			<?php echo do_shortcode( $content ); ?>
		</span>
	</a>

	<?php $output = ob_get_clean();
	return $output;
}