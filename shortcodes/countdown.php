<?php
add_filter( 'su/data/shortcodes', 'rasb_register_countdown_shortcode', 10, 2 );
function rasb_register_countdown_shortcode( $shortcodes ) {
    $shortcodes['countdown'] = array(
		'name' => __( 'Countdown', 'ra-shortcodes-bundle' ),
		'type' => 'single',
		'group' => 'ra-shortcodes-bundle',
		'atts' => array(
			'class' => array(
				'type' => 'text',
				'default' => '',
				'name' => __( 'Countdown Class', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
			'year' => array(
				'type' => 'slider',
				'min' => date( 'Y' ),
				'max' => 2100,
				'step' => 1,
				'default' => date( 'Y' ),
				'name' => __( 'Year', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
			'month' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 12,
				'step' => 1,
				'default' => 1,
				'name' => __( 'Month', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
			'day' => array(
				'type' => 'slider',
				'min' => 1,
				'max' => 31,
				'step' => 1,
				'default' => 1,
				'name' => __( 'Day', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
			'hour' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 23,
				'step' => 1,
				'default' => 1,
				'name' => __( 'Hour', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
			'minute' => array(
				'type' => 'slider',
				'min' => 0,
				'max' => 59,
				'step' => 1,
				'default' => 0,
				'name' => __( 'Minute', 'ra-shortcodes-bundle' ),
				'desc' => ''
			),
		),
		'content' => '',
		'desc' => __( 'Text content', 'ra-shortcodes-bundle' ),
		'icon' => 'code',
		'function' => 'rasb_custom_countdown_shortcode' 
	);

	return $shortcodes;
}

function rasb_custom_countdown_shortcode( $atts, $content = null ) {
    static $instance = 0;
    $instance++;

	$atts = shortcode_atts( array(
        'class' => '',
		'year' => date( 'Y' ),
		'month' => '',
		'day' => '',
		'hour' => '',
		'minute' => '',
        'instance' => $instance
	), $atts, 'countdown' );

    $classes = array();

    $classes[] = 'rasb-countdown';
    $classes[] = 'countdown';
    $classes[] = $atts['class'];

    $attributes = array();

    $attributes['class'] = esc_attr( implode( ' ', $classes ) );
    $attributes['id'] = 'countdown-' . $instance;
    $attributes['data-instance'] = $instance;

    $attr = array(
        'id' => 'countdown-' . $instance,
        'year' => $atts['year'],
        'month' => str_pad($atts['month'], 2, '0', STR_PAD_LEFT),
        'day' => str_pad($atts['day'], 2, '0', STR_PAD_LEFT),
        'hour' => str_pad($atts['hour'], 2, '0', STR_PAD_LEFT),
        'minute' => str_pad($atts['minute'], 2, '0', STR_PAD_LEFT)
    );

	wp_enqueue_script( 'rasb-countdown-js' );
    wp_enqueue_script( 'rasb-shortcodes-js' );
    wp_localize_script( 'rasb-shortcodes-js', 'countdown' . $instance, $attr );
	
	ob_start(); ?>
 
	<div <?php foreach( $attributes as $name => $value ) echo $name . '="' . $value . '" ' ?>></div>

	<?php $countdown = ob_get_clean();

	return $countdown;
}