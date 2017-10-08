<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Counter')) {
    class g5plusFramework_ShortCode_Counter
    {
        function __construct()
        {
            add_shortcode('handmade_counter', array($this, 'counter_shortcode'));
        }

        function counter_shortcode($atts)
        {
	        /**
	         * Shortcode attributes
	         * @var $value
	         * @var $value_color
	         * @var $title
	         * @var $title_color
	         * @var $el_class
	         */
            $value=$value_color=$title=$title_color=$el_class='';
	        $atts = vc_map_get_attributes( 'handmade_counter', $atts );
	        extract( $atts );
            global $g5plus_options;
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('handmade_counter_js', plugins_url('handmade-framework/includes/shortcodes/counter/assets/js/jquery.countTo' . $min_suffix_js . '.js'), array(), false, true);
            wp_enqueue_style('handmade_counter_css', plugins_url('handmade-framework/includes/shortcodes/counter/assets/css/counter' . $min_suffix_css . '.css'), array(), false);
            ob_start();?>
            <div class="handmade-counter <?php echo esc_attr($el_class) ?>">
            <?php if($value!=''): ?>
                <span class="display-percentage" style="color: <?php echo esc_attr($value_color) ?>" data-percentage="<?php echo esc_attr($value) ?>"><?php echo esc_html($value) ?></span>
                <?php if($title!=''): ?>
                    <p class="counter-title" style="color: <?php echo esc_attr($title_color) ?>"><?php echo wp_kses_post($title) ?></p>
                <?php endif;
            endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Counter();
}