<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $g5plus_woocommerce_loop,$g5plus_options;


$related_product_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if (!in_array($related_product_display_columns, array('3','4'))) {
	$related_product_display_columns = $g5plus_options['related_product_display_columns'];
}

$g5plus_woocommerce_loop['rating'] = 0;
$g5plus_woocommerce_loop['columns'] = $related_product_display_columns;
$g5plus_woocommerce_loop['layout'] = 'slider';

?>
<?php if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) :  ?>
<?php
	global $product, $woocommerce_loop;
	$crosssells = WC()->cart->get_cross_sells();
	if ( sizeof( $crosssells ) == 0 ) return;
	$meta_query = WC()->query->get_meta_query();
	$args = array(
		'post_type'           => 'product',
		'ignore_sticky_posts' => 1,
		'no_found_rows'       => 1,
		'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
		'orderby'             => $orderby,
		'post__in'            => $crosssells,
		'meta_query'          => $meta_query
	);
	$products = new WP_Query( $args );

//$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );
	if ( $products->have_posts() ) : ?>

		<div class="cross-sells">

			<h4 class="widget-title"><span><?php esc_html_e( 'You may be interested in&hellip;', 'g5plus-handmade' ) ?></span></h4>

			<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

		</div>

	<?php endif;

	wp_reset_query();
?>
<?php else: ?>
	<?php
	if ( $cross_sells ) : ?>

		<div class="cross-sells">

			<h4 class="widget-title"><span><?php esc_html_e( 'You may be interested in&hellip;', 'g5plus-handmade' ) ?></span></h4>

			<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				$post_object = get_post( $cross_sell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>

		</div>

	<?php endif;

	wp_reset_postdata();

	?>

<?php endif; ?>













