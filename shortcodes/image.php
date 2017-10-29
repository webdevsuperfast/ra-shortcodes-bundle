<?php
add_filter( 'su/data/shortcodes', 'rasb_register_image_shortcode', 10, 2 );
function rasb_register_image_shortcode( $shortcodes ) {
	$shortcodes['image'] = array(
		'name' => __( 'Image', 'ra-shortcodes-bundle' ),
		'type' => 'single',
		'group' => 'ra-shortcodes-bundle',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Class', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Image class', 'ra-shortcodes-bundle' )
			),
			'image' => array(
				'type' => 'upload',
				'default' => '',
				'name' => __( 'Image Source', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Off-site images won\'t be resized.', 'ra-shortcodes-bundle' )
			),
			'alt' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Alt', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Alt text', 'ra-shortcodes-bundle' )
			),
			'width' => array(
				'type' => 'number',
				'default' => '',
				'name' => __( 'Width', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Image width', 'ra-shortcodes-bundle' )
			),
			'height' => array(
				'type' => 'number',
				'default' => '',
				'name' => __( 'Height', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Image height', 'ra-shortcodes-bundle' )
			),
			'url' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Link', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Image link', 'ra-shortcodes-bundle' )
			),
			'alignment' => array(
				'type' => 'select',
				'values' => array(
					'alignnone' => 'None',
					'aligncenter' => 'Center',
					'alignleft' => 'Left',
					'alignright' => 'Right'
				),
				'default' => 'alignnone',
				'name' => __( 'Alignment', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Text alignment', 'ra-shortcodes-bundle' )
			),
			'margin' => array(
				'type' => 'number',
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'name' => __( 'Margin', 'ra-shortcodes-bundle' ),
				'desc' => __( 'Image margin based on chosen alignment', 'ra-shortcodes-bundle' )
			),
			'div' => array(
				'type' => 'bool',
				'default' => 'no',
				'name' => __( 'Add enclosing div tags?', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
		),
		'content' => '',
		'desc' => __( 'Text content', 'ra-shortcodes-bundle' ),
		'icon' => 'code',
		'function' => 'rasb_custom_image_shortcode'
	);
	
	return $shortcodes;
}

//* Image
function rasb_custom_image_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class' => '',
		'image' => '',
		'url' => '',
		'width' => '',
		'height' => '',
		'margin' => '',
		'alignment' => '',
		'alt' => '',
		'div' => ''
	), $atts, 'image' );

	$image = $atts['image'];

	if ( $image ) {
		$image = rasb_thumb( $image, $atts['width'] ? $atts['width'] : 0, $atts['height'] ? $atts['height'] : 0 );
	} else {
		$image = $image;
	}

	$classes = array();
	$classes[] = 'rasb_image';
	if ( !empty( $atts['class'] ) ) $classes[] = $atts['class'];
	if ( !empty( $atts['alignment'] ) ) $classes[] = $atts['alignment'];

	$styles = array();

	if ( $atts['margin'] == 0 ) {
		$styles['margin-bottom'] = '0px';
	} else {
		$styles['margin-bottom'] = $atts['margin'] . 'px';
	}

	$attributes = array();
	$attributes = array(
		'class' => esc_attr( implode( ' ', $classes ) ),
		'style' => implode('; ', array_map( function ( $v, $k ) { return $k . ':' . $v; }, $styles, array_keys( $styles ) ) ),
		'src' => esc_url( $image )
	);

	if ( !empty( $atts['alt'] ) ) $attributes['alt'] = $atts['alt'];

	ob_start(); ?>
	<?php echo $atts['div'] ? '<div class="image-wrapper">' : ''; ?>
		<?php echo $atts['url'] ? '<a href="'.esc_url( $atts['url'] ).'">' : ''; ?>
			<img <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?> />
		<?php echo $atts['url'] ? '</a>' : ''; ?>
	<?php echo $atts['div'] ? '</div>' : ''; ?>
	
	<?php
	$output = ob_get_clean();
	return $output;
}