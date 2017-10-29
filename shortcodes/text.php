<?php
add_filter( 'su/data/shortcodes', 'rasb_register_text_shortcode', 10, 2 );
function rasb_register_text_shortcode( $shortcodes ) {
	$shortcodes['text'] = array(
		'name' => __( 'Text', 'ra-shortcodes-bundle' ),
		'type' => 'wrap',
		'group' => 'ra-shortcodes-bundle',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text class', 'ra-shortcodes-bundle' )
			),
			'tag' => array(
				'type' => 'text',
				'default' => 'span',
				'name' => __( 'Tag', 'ra-shortcodes-bundle' ),
				'desc' => __( 'HTML tag', 'ra-shortcodes-bundle' )
			),
			'icon' => array(
				'type' => 'icon',
				'default' => '',
				'name' => __( 'Icon', 'ra-shortcodes-bundle' ),
				'desc' => __( 'You can upload custom icon for this box', 'ra-shortcodes-bundle' )
			),
			'icon_color' => array(
				'type' => 'color',
				'default' => '#333333',
				'name' => __( 'Icon color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'This color will be applied to the selected icon. Does not work with uploaded icons', 'shortcodes-bundle' )
			),
			'icon_size' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Icon Size', 'ra-shortcodes-bundle' )
			),
			'size' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Font Size', 'ra-shortcodes-bundle' )
			),
			'spacing' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 1,
				'step' => 0.05,
				'default' => '',
				'name' => __( 'Letter Spacing', 'ra-shortcodes-bundle' ),
			),
			'height' => array(
				'type' => 'number',
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => '',
				'name' => __( 'Line Height', 'ra-shortcodes-bundle' ),
			),
			'alignment' => array(
				'type' => 'select',
				'values' => array(
					'none' => __( 'None' ),
					'center' => __( 'Center' ),
					'left' => __( 'Left' ),
					'right' => __( 'Right' )
				),
				'default' => 'none',
				'name' => __( 'Alignment', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text alignment', 'ra-shortcodes-bundle' )
			),
			'color' => array(
				'type' => 'color',
				'values' => array( ),
				'default' => '',
				'name' => __( 'Color', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text color', 'ra-shortcodes-bundle' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Bottom margin', 'ra-shortcodes-bundle' )
			)
		),
		'content' => __( 'Text', 'ra-shortcodes-bundle' ),
		'desc' => __( 'Text content', 'ra-shortcodes-bundle' ),
		'icon' => 'code',
		'function' => 'rasb_custom_text_shortcode'
	);

	return $shortcodes;
}

//* Text
function rasb_custom_text_shortcode( $atts, $content = null ) {
	static $instance = 0;
	$instance++;

	$atts = shortcode_atts( array(
		'class' => '',
		'size' => 'inherit',
		'tag' => 'span',
		'alignment' => '',
		'color' => 'inherit',
		'margin' => '',
		'height' => '',
		'spacing' => '',
		'icon' => '',
		'icon_color' => '#333',
		'icon_size' => ''
	), $atts, 'text' );

	if ( $atts['height'] != 0 && $atts['size'] != 0 ) {
		$height = ($atts['height']/$atts['size']);
	}

	$selector = 'rasb_text-' . $instance;

	$classes = array();
	$classes[] = 'rasb_text';
	$classes[] = 'text';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];

	$styles = array();
	if ( !empty( $atts['size'] ) ) $styles['fontSize'] = $atts['size'] . 'px';
	if ( !empty( $atts['height'] ) ) $styles['lineHeight'] = $height;
	if ( !empty( $atts['spacing'] ) ) $styles['letterSpacing'] = $atts['spacing'] . 'em';
	if ( !empty( $atts['color'] ) ) $styles['color'] = $atts['color'];
	if ( $atts['alignment'] !== 'none' ) $styles['textAlign'] = $atts['alignment'];
	
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
	wp_localize_script( 'rasb-shortcodes-js', 'text' . $instance, $styles );

	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'id' => $selector,
		'data-instance' => $instance
	);

	ob_start(); ?>

	<?php
	// Built-in icon
	if ( $atts['icon'] ) {
		if ( strpos( $atts['icon'], 'icon:' ) !== false ) {
			$atts['icon'] = '<span class="icon-font fa fa-' . trim( str_replace( 'icon:', '', $atts['icon'] ) ) . '" style="width:' . $atts['icon_size'] . 'px;height:' . $atts['icon_size'] . 'px;font-size:' . $atts['icon_size'] . 'px;color:' . $atts['icon_color'] . ';"></span>';
			su_query_asset( 'css', 'font-awesome' );
		}
		// Uploaded icon
		else {
			$atts['icon'] = '<img class="icon-img" src="' . $atts['icon'] . '" width="' . $atts['icon_size'] . '" height="auto" />';
		}
	} 
	?>

	<<?php echo $atts['tag']; ?> <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>>
		<?php echo $atts['icon']; ?>
		<?php echo su_do_shortcode( $content, 's' ); ?>
	</<?php echo $atts['tag']; ?>>

	<?php $output = ob_get_clean();
	return $output;
}