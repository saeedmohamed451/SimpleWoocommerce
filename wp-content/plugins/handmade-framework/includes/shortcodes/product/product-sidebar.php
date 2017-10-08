<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/7/2015
 * Time: 9:24 AM
 */
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if (!class_exists('g5plusFramework_Shortcode_Product_Sidebar')) {
	class g5plusFramework_Shortcode_Product_Sidebar{
		function __construct() {
			add_shortcode('handmade_product_sidebar', array($this, 'product_sidebar_shortcode' ));
		}

		function  product_sidebar_shortcode($atts) {
			global $g5plus_options;
			$min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' :  '';
			wp_enqueue_style('handmade_product_css', plugins_url('handmade-framework/includes/shortcodes/product/assets/css/style' . $min_suffix . '.css'), array(), false);
			$atts = vc_map_get_attributes( 'handmade_product_sidebar', $atts );
			$style =  $title =  $feature = $category = $total_item =  $per_page =  $slider = $auto_play = $auto_play_speed = $transition_style  = $orderby = $order = $el_class = $css_animation = $duration = $delay =  '';
			extract(shortcode_atts(array(
				'style' => 'style-01',
				'title' => '',
				'feature' => 'all',
				'category' => '',
				'total_item' => 8,
				'slider'  => '',
				'per_page' => 4,
				'auto_play' => 0,
				'auto_play_speed' => 5000,
				'transition_style' => 'false',
				'orderby' => 'date',
				'order' => 'DESC',
				'el_class'      => '',
				'css_animation' => '',
				'duration'      => '',
				'delay'         => ''
			), $atts));

			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			$query_args = array(
				'posts_per_page' => $total_item,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'no_found_rows'  => 1,
				'meta_query'     => array(),
				'tax_query'      => array(
					'relation' => 'AND',
				),
			);

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['outofstock'],
						'operator' => 'NOT IN',
					),
				);
			}



			if (!empty($category)) {
				$query_args['tax_query'][] = array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=>  explode(',',$category),
						'field' 		=> 'slug',
						'operator' 		=> 'IN'
				);
			}

			switch($feature) {
				case 'sale':
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;
				case 'new-in':
					$query_args['orderby'] = 'DESC';
					$query_args['order'] = 'date';
					break;
				case 'featured':
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['featured'],
					);
					break;
				case 'top-rated':
					$query_args['meta_key'] = '_wc_average_rating';
					$query_args['orderby'] = 'meta_value_num';
					$query_args['order'] = 'DESC';
					$query_args['meta_query'] = WC()->query->get_meta_query();
					$query_args['tax_query'] = WC()->query->get_tax_query();
					break;
				case 'recent-review':
					add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
					break;
				case 'best-selling' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby'] = 'meta_value_num';
					break;
			}


			if (in_array($feature,array('all','sale','featured'))) {
				$query_args['order'] = $order;

				switch ( $orderby ) {
					case 'price' :
						$query_args['meta_key'] = '_price';
						$query_args['orderby']  = 'meta_value_num';
						break;
					case 'rand' :
						$query_args['orderby']  = 'rand';
						break;
					case 'sales' :
						$query_args['meta_key'] = 'total_sales';
						$query_args['orderby']  = 'meta_value_num';
						break;
					default :
						$query_args['orderby']  = 'date';
				}
			}




			$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );

			if($feature =='recent-review' ){
				remove_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' )  );
			}

			$class = array('sc-product-sidebar-wrap');
			$class[] = $style;
			$class[] = $el_class;
			$class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			if (empty($title)) {
				$class[] = 'no-title';
			}

			$class_name = join(' ',$class);

			if (($slider == 'slider') && ($products->post_count <= $per_page)) {
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
			<?php if ($products->have_posts()) : ?>
				<div class="<?php echo esc_attr($class_name) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
					<?php if (!empty($title)) : ?>
						<h4 class="sc-title"><span><?php echo esc_html($title); ?></span></h4>
					<?php endif; ?>
					<?php woocommerce_product_loop_start(); ?>
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php if (($slider == 'slider') && (($index % $per_page) === 0)) : ?>
							<?php $index_sub = 0; ?>
							<div>
						<?php endif; ?>

						<?php if ($style == 'style-01') : ?>
							<?php wc_get_template_part( 'content', 'product-sidebar' ); ?>
						<?php else: ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endif; ?>

						<?php if (($slider == 'slider') && ($index_sub == ($per_page - 1))) : ?>
							</div>
						<?php endif; ?>
						<?php
						$index_sub++;
						$index++;
						?>
					<?php endwhile; // end of the loop. ?>
					<?php if (($slider == 'slider') && ($index_sub != $per_page) && ($index > 0)) : ?>
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

		function order_by_comment_date_post_clauses($args){
			global $wpdb;

			$args['join'] .= "
                LEFT JOIN (
                    SELECT comment_post_ID, MAX(comment_date)  as  comment_date
                    FROM $wpdb->comments
                    WHERE comment_approved = 1
                    GROUP BY comment_post_ID
                ) as wp_comments ON($wpdb->posts.ID = wp_comments.comment_post_ID)
            ";
			$args['orderby'] = "wp_comments.comment_date DESC";
			return $args;
		}
	}
	new g5plusFramework_Shortcode_Product_Sidebar();
}