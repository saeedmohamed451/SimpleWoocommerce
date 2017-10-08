<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/5/2015
 * Time: 6:04 PM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('g5plusFramework_Shortcode_Product_Categories_Home')) {
	class g5plusFramework_Shortcode_Product_Categories_Home {
		function __construct() {
			add_shortcode('handmade_product_categories_home', array($this, 'product_categories_home_shortcode' ));
		}
		function product_categories_home_shortcode($atts)
		{
			global $g5plus_options;
			$min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
			wp_enqueue_style('handmade_product_categories_home_css', plugins_url('handmade-framework/includes/shortcodes/product-categories-home/assets/css/style' . $min_suffix . '.css'), array(), false);

			$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' :  '';
			wp_enqueue_script('handmade_product_categories_home_js', plugins_url('handmade-framework/includes/shortcodes/product-categories-home/assets/js/main' . $min_suffix . '.js'), array(), false, true);

			$atts = vc_map_get_attributes( 'handmade_product_categories_home', $atts );
			$style =  $height = $hide_empty =  $show_product_count = $orderby = $order = $el_class = $css_animation = $duration = $delay =  '';
			extract(shortcode_atts(array(
				'style' => 'style-01',
				'height' => '',
				'hide_empty' => 0,
				'show_product_count' => 1,
				'orderby' => 'date',
				'order' => 'DESC',
				'el_class'      => '',
				'css_animation' => '',
				'duration'      => '',
				'delay'         => ''
			), $atts));


			$args = array(
				'orderby'    => $orderby,
				'order'      => $order,
				'hide_empty' => $hide_empty == 1 ? true : false ,
				'pad_counts' => true
			);

			$categories = get_terms( 'product_cat', $args );
			$category_content = '';
			if (function_exists('g5plus_categories_binder')) {
				$category_content = g5plus_categories_binder($categories, '0','product-categories-home',true,$show_product_count == 1 ? true : false);
			}



			$class[]= 'sc-product-categories-home-wrap p-color-bg';
			$class[] = $style;
			$class[] = $el_class;
			$class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			$class_name = join(' ',$class);
			ob_start();
			?>
			<div data-height="<?php echo esc_attr($height); ?>"  class="<?php echo esc_attr($class_name) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
				<?php echo wp_kses_post($category_content); ?>
				<a class="show-more"><i class="fa fa-angle-down"></i></a>
			</div>
			<?php
			$content =  ob_get_clean();
			return $content;
		}
	}
	new g5plusFramework_Shortcode_Product_Categories_Home();
}