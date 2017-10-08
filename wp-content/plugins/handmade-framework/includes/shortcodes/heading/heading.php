<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Heading')){
    class g5plusFramework_Shortcode_Heading{
        function __construct(){
            add_shortcode('handmade_heading', array($this, 'heading_shortcode'));
        }
        function heading_shortcode($atts){
	        /**
	         * Shortcode attributes
	         * @var $color_scheme
	         * @var $title
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
            $color_scheme = $title = $el_class = $css_animation = $duration = $delay = '';
	        $atts = vc_map_get_attributes( 'handmade_heading', $atts );
	        extract( $atts );
	        $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();?>
            <h2 class="handmade-heading <?php echo esc_attr($color_scheme . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php echo wp_kses_post($title) ?>
            </h2>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Heading();
}