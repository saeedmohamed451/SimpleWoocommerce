<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Call_Action')) {
	class g5plusFramework_Shortcode_Call_Action
	{
		function __construct()
		{
			add_shortcode('handmade_call_action', array($this, 'call_action_shortcode'));
		}

		function call_action_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $layout_style
			 * @var $text
			 * @var $link
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
			$atts = vc_map_get_attributes( 'handmade_call_action', $atts );
			extract( $atts );
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_call_action_css', plugins_url('handmade-framework/includes/shortcodes/call-action/assets/css/call-action' . $min_suffix_css . '.css'), array(), false);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
			$a_title='';
			$a_target='_self';
			$a_href='#';
            if ( strlen( $link['title'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            ob_start();?>
            <div
                class="handmade-call-action <?php echo esc_attr($layout_style . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="container">
                    <p><?php echo esc_html($text) ?></p>
                    <a class="handmade-button style1 button-2x" href="<?php echo esc_url($a_href); ?>"
                       target="<?php echo esc_attr($a_target); ?>"><?php echo esc_html($a_title); ?></a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
    new g5plusFramework_Shortcode_Call_Action();
}