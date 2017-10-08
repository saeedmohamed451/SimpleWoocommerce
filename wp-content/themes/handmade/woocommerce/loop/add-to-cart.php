<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
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
global $product;
$product_Id = g5plus_woocommerce_get_product_id($product);
?>
<?php if (!$product->is_in_stock()) : ?>
	<a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product_Id ) ); ?>" class="product_type_soldout btn_add_to_cart" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Sold out','g5plus-handmade'); ?>"><i class="fa fa-shopping-cart"></i></a>
<?php else : ?>
<?php
	$icon_class = '';
	$product_type = g5plus_woocommerce_get_product_type($product);
	switch ($product_type) {
		case 'variable':
			$icon_class = 'fa fa-shopping-cart';
			break;
		case 'grouped':
			$icon_class = 'fa fa-shopping-cart';
			break;
		case 'external':
			$icon_class = 'fa fa-info';
			break;
		default:
			if ( $product->is_purchasable() && $product_type != "booking" ) {
				$icon_class = 'fa fa-shopping-cart';
			} else {
				$icon_class = 'fa fa-shopping-cart';
			}
			break;
	}

	echo '<div class="add-to-cart-wrap"  data-toggle="tooltip" data-placement="top" title="'. $product->add_to_cart_text() .'">';
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s btn_add_to_cart"><i class="%s"></i> %s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product_Id ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			esc_attr($icon_class),
			esc_html( $product->add_to_cart_text() )
		),
		$product );
	echo '</div>';



?>
<?php endif; ?>
