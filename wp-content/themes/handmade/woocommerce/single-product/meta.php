<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

$weight = $product->get_weight();


if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) {
    $dimensions = $product->get_dimensions();
} else {
    $dimensions = wc_format_dimensions( $product->get_dimensions( false ) );
}


$availability      = $product->get_availability();
if (empty($availability['availability'])) {
    $availability['availability'] = __( 'In stock', 'g5plus-handmade' );
    $availability['class'] = 'in-stock';
}
$availability_html = '<span class="product-stock-status ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>';

?>
<div class="product_meta">


    <?php do_action( 'woocommerce_product_meta_start' ); ?>
    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

        <span class="sku_wrapper"><label><?php esc_html_e( 'SKU:', 'g5plus-handmade' ); ?></label> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'g5plus-handmade' ); ?></span>.</span>

    <?php endif; ?>

    <span class="product-stock-status-wrapper"><label><?php esc_html_e('Availability:','g5plus-handmade') ?></label> <span class="product_stock"><?php echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product ); ?></span> </span>

    <?php if (!empty($dimensions)) : ?>
        <span><label><?php esc_html_e("Size:",'g5plus-handmade'); ?></label><span class="product_dimensions"> <?php echo esc_html($dimensions);?></span></span>
    <?php endif; ?>

    <?php if (!empty($weight)) : ?>
        <span><label><?php esc_html_e("Shipping Weight:",'g5plus-handmade'); ?></label><span class="product_weight"> <?php echo esc_html($weight) . ' ' .get_option( 'woocommerce_weight_unit' ) ?></span></span>
    <?php endif; ?>



    <?php if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) : ?>
        <?php echo  $product->get_categories( ', ', '<span class="posted_in">' . _n( '<label>Category:</label>', '<label>Categories:</label>', $cat_count, 'g5plus-handmade' ) . ' ', '.</span>' ); ?>
    <?php else: ?>
        <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<label>Category:</label>', '<label>Categories:</label>', $cat_count, 'g5plus-handmade' ) . ' ', '.</span>' ) ?>
    <?php endif; ?>


    <?php if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) : ?>
        <?php echo  $product->get_tags( ', ', '<span class="tagged_as">' . _n( '<label>Tag:</label>', '<label>Tags:</label>', $tag_count, 'g5plus-handmade' ) . ' ', '.</span>' ); ?>
    <?php else: ?>
        <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '<label>Tag:</label>', '<label>Tags:</label>', $tag_count, 'g5plus-handmade' ) . ' ', '.</span>' ); ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
