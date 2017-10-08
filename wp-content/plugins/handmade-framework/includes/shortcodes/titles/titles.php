<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Titles')){
	class g5plusFramework_Shortcode_Titles{
		function __construct(){
			add_shortcode('handmade_titles', array($this, 'titles_shortcode'));
		}
		function titles_shortcode($atts){
			/**
			 * Shortcode attributes
			 * @var $title
			 * @var color_scheme
			 * @var $sub_title
			 * @var $description
 			 * @var $text_align
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
			$color_scheme = $title = $el_class = $css_animation = $duration = $delay = '';
			$atts = vc_map_get_attributes( 'handmade_titles', $atts );
			global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
            wp_enqueue_style( 'handmade_title_css', plugins_url( 'handmade-framework/includes/shortcodes/titles/assets/css/titles' . $min_suffix_css . '.css' ), array(), false );
			extract( $atts );
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			ob_start();?>
			<div
				class="handmade-titles <?php echo esc_attr($text_align . ' ' . $color_scheme . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
				<h2>
					<?php echo esc_html($title)?>
				</h2>
				<?php if(!empty($sub_title)):?>
					<span><?php echo esc_html($sub_title)?></span>
				<?php endif;?>
				<?php if(!empty($description)):?>
					<p>
						<?php echo esc_html($description)?>
					</p>
				<?php endif;?>
			</div>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}
	new g5plusFramework_Shortcode_Titles();
}