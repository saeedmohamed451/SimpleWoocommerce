<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/8/2015
 * Time: 9:20 AM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('g5plusFramework_Shortcode_Product_Reviews')) {
	class g5plusFramework_Shortcode_Product_Reviews {
		function __construct() {
			add_shortcode('handmade_product_reviews', array($this, 'product_reviews_shortcode' ));
		}

		function  product_reviews_shortcode($atts) {
			global $g5plus_options;
			$min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
			wp_enqueue_style('handmade_product_css', plugins_url('handmade-framework/includes/shortcodes/product/assets/css/style' . $min_suffix . '.css'), array(), false);
			$atts = vc_map_get_attributes( 'handmade_product_reviews', $atts );
			$title = $total_item = $slider = $per_page = $auto_play = $auto_play_speed = $transition_style =  $el_class = $css_animation = $duration = $delay = '';
			extract(shortcode_atts(array(
				'title' => '',
				'total_item' => 8,
				'slider'  => '',
				'per_page' => 4,
				'auto_play' => 0,
				'auto_play_speed' => 5000,
				'transition_style' => 'false',
				'el_class'      => '',
				'css_animation' => '',
				'duration'      => '',
				'delay'         => ''
			), $atts));
			$comments = get_comments(
				array(
					'number' => $total_item,
					'status' => 'approve',
					'post_status' => 'publish',
					'post_type' => 'product' )
			);

			$class = array('sc-product-sidebar-wrap');
			$class[] = $el_class;
			$class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			if (empty($title)) {
				$class[] = 'no-title';
			}
			$class_name = join(' ',$class);

			if (($slider == 'slider') && (count($comments) <= $per_page)) {
				$slider = '';
			}

			global  $g5plus_woocommerce_loop;
			$g5plus_woocommerce_loop['columns'] = 1;
			$g5plus_woocommerce_loop['layout'] = $slider;
			if ($slider == 'slider') {
				$g5plus_woocommerce_loop['autoHeight'] = 'true';
				$g5plus_woocommerce_loop['autoPlay'] = $auto_play == 0 ? 'false' : $auto_play_speed > 0 ? $auto_play_speed : 'true';
				$g5plus_woocommerce_loop['transitionStyle'] = $transition_style;
			}
			$index = 0;
			$index_sub = 0;

			ob_start();
			?>
			<?php if ( $comments ) : ?>
				<div class="<?php echo esc_attr($class_name) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
					<?php if (!empty($title)) : ?>
						<h4 class="sc-title"><span><?php echo esc_html($title); ?></span></h4>
					<?php endif; ?>
					<?php woocommerce_product_loop_start(); ?>
						<?php foreach ( (array) $comments as $comment ) : ?>
							<?php if (($slider == 'slider') && (($index % $per_page) === 0)) : ?>
								<?php $index_sub = 0; ?>
								<div>
							<?php endif; ?>
								<?php
								    $_product = wc_get_product( $comment->comment_post_ID );
								    $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

								if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) {
									$rating_html = $_product->get_rating_html( $rating );
								} else {
									$rating_html = wc_get_rating_html( $rating );
								}




								 ?>
								 <div class="product-sidebar-item comment">
										<a class="title" href="<?php echo esc_url(get_comment_link( $comment->comment_ID )); ?>">
											<?php echo wp_kses_post($_product->get_title()); ?>
										</a>
										<?php echo wp_kses_post($rating_html); ?>
										<p class="comment-content">
											<?php echo wp_kses_post($comment->comment_content);  ?>
										</p>
								 </div>

							<?php if (($slider == 'slider') && ($index_sub == ($per_page - 1))) : ?>
								</div>
							<?php endif; ?>

							<?php
							$index_sub++;
							$index++;
							?>
						<?php endforeach; ?>
						<?php if (($index_sub != $per_page) && ($index > 0)) : ?>
							</div>
						<?php endif; ?>
					<?php woocommerce_product_loop_end(); ?>

				</div>
			<?php else: ?>
				<div class="item-not-found"><?php echo esc_html__('No item found','g5plus-handmade') ?></div>
			<?php endif; ?>
			<?php
			wp_reset_postdata();
			$content =  ob_get_clean();
			return $content;
		}
	}
	new g5plusFramework_Shortcode_Product_Reviews();
}