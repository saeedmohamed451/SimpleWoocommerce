<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $g5plus_options;

$single_product_show_image_thumb = isset($g5plus_options['single_product_show_image_thumb']) ? $g5plus_options['single_product_show_image_thumb'] : 0;

$index = 0;
$product_images = array();
$image_ids = array();

if (has_post_thumbnail()) {
	$product_images[$index] = array(
		'image_id' => get_post_thumbnail_id()
	);
	$image_ids[$index] = get_post_thumbnail_id();
	$index++;
}

$attachment_ids  = $product->get_gallery_image_ids();
if ($attachment_ids) {
	foreach ( $attachment_ids as $attachment_id ) {
		if (in_array($attachment_id,$image_ids)) continue;
		$product_images[$index] = array(
			'image_id' => $attachment_id
		);
		$image_ids[$index] = $attachment_id;
		$index++;
	}
}

if (g5plus_woocommerce_get_product_type($product) == 'variable') {
	$available_variations = $product->get_available_variations();
	if (isset($available_variations)){
		foreach ($available_variations as $available_variation){
			$variation_id = $available_variation['variation_id'];
			if (has_post_thumbnail($variation_id)) {
				$variation_image_id = get_post_thumbnail_id($variation_id);

				if (in_array($variation_image_id,$image_ids)) {
					$index_of = array_search($variation_image_id, $image_ids);
					if (isset($product_images[$index_of]['variation_id'])) {
						$product_images[$index_of]['variation_id'] .= $variation_id . '|';
					} else {
						$product_images[$index_of]['variation_id'] = '|' . $variation_id . '|';
					}
					continue;
				}

				$product_images[$index] = array(
					'image_id' => $variation_image_id,
					'variation_id' => '|' . $variation_id . '|'
				);
				$image_ids[$index] = $variation_image_id;
				$index++;
			}
		}
	}
}
if ( count($product_images) > 1 ) {
	$gallery = '[product-gallery]';
} else {
	$gallery = '';
}

$product_images_thumb = array('product-thumb-wrap');
$product_images_thumb[] = 'product-image-total-' . $index;
if ($single_product_show_image_thumb == 0) {
	$product_images_thumb[] = 'product-thumb-disable';
}
?>
<div class="single-product-image-inner">
    <div id="sync1" class="owl-carousel manual">

	    <?php
	    foreach($product_images as $key => $value) {
		    $index = $key;
		    $image_id = $value['image_id'];
		    $variation_id = isset($value['variation_id']) ? $value['variation_id'] : '' ;
		    $image_title 	= esc_attr( get_the_title( $image_id ) );
		    $image_caption = '';
		    $image_obj = get_post( $image_id );
		    if (isset($image_obj) && isset($image_obj->post_excerpt)) {
			    $image_caption 	= $image_obj->post_excerpt;
		    }
		    $image_link  	= wp_get_attachment_url( $image_id );
		    $image       	= wp_get_attachment_image( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			    'title'	=> $image_title,
			    'alt'	=> $image_title
		    ) );
		    echo '<div>';
		    if (!empty($variation_id)) {
			    echo  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" data-rel="prettyPhoto' . $gallery . '" data-variation_id="%s" data-index="%s">%s</a>', $image_link, $image_caption,$variation_id,$index, $image ), $post->ID );
		    } else {
			    echo  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s" data-rel="prettyPhoto' . $gallery . '" data-index="%s">%s</a>', $image_link, $image_caption,$index, $image ), $post->ID );
		    }
		    echo '</div>';
	    }

	    ?>

</div>
<div class="<?php echo join(' ',$product_images_thumb); ?>">
	<div id="sync2" class="owl-carousel manual">
		<?php
		foreach($product_images as $key => $value) {
			$index = $key;
			$image_id = $value['image_id'];
			$variation_id = isset($value['variation_id']) ? $value['variation_id'] : '' ;
			$image_title 	= esc_attr( get_the_title( $image_id ) );
			$image_caption = '';
			$image_obj = get_post( $image_id );
			if (isset($image_obj) && isset($image_obj->post_excerpt)) {
				$image_caption 	= $image_obj->post_excerpt;
			}


			$image_link  	= wp_get_attachment_url( $image_id );
			$image       	= wp_get_attachment_image( $image_id,  apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
			) );
			echo '<div class="thumbnail-image">';
			if (!empty($variation_id)) {
				echo  apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-thumbnail-image" title="%s" data-variation_id="%s" data-index="%s">%s</a>', $image_link, $image_caption,$variation_id,$index,  $image ), $post->ID );
			} else {
				echo  apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-thumbnail-image" title="%s" data-index="%s">%s</a>', $image_link, $image_caption,$index , $image), $post->ID );
			}
			echo '</div>';
		}

		?>
	</div>
</div>
</div>
<script type="text/javascript">
	(function($) {
		"use strict";
		$(document).ready(function() {

			var sync1 = $("#sync1",".single-product-image-inner");
			var sync2 = $("#sync2",".single-product-image-inner");
			sync1.owlCarousel({
				singleItem : true,
				slideSpeed : 100,
				navigation: true,
				pagination:false,
				navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				afterAction : syncPosition,
				responsiveRefreshRate : 200
			});

			sync2.owlCarousel({
				items : 4,
				itemsDesktop: [1199, 4],
				itemsDesktopSmall: [980, 3],
				itemsTablet: [768, 3],
				itemsTabletSmall: false,
				itemsMobile: [479, 2],
				pagination:false,
				responsiveRefreshRate : 100,
				navigation: false,
				navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				afterInit : function(el){
					el.find(".owl-item").eq(0).addClass("synced");
				}
			});

			function syncPosition(el){
				var current = this.currentItem;
				$("#sync2")
					.find(".owl-item")
					.removeClass("synced")
					.eq(current)
					.addClass("synced");
				if($("#sync2").data("owlCarousel") !== undefined){
					center(current);
				}
			}

			$("#sync2").on("click", ".owl-item", function(e){
				e.preventDefault();
				var number = $(this).data("owlItem");
				sync1.trigger("owl.goTo",number);
			});

			function center(number){
				var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
				var num = number;
				var found = false;
				for(var i in sync2visible){
					if(num === sync2visible[i]){
						var found = true;
					}
				}

				if(found===false){
					if(num>sync2visible[sync2visible.length-1]){
						sync2.trigger("owl.goTo", num - sync2visible.length+2)
					}else{
						if(num - 1 === -1){
							num = 0;
						}
						sync2.trigger("owl.goTo", num);
					}
				} else if(num === sync2visible[sync2visible.length-1]){
					sync2.trigger("owl.goTo", sync2visible[1])
				} else if(num === sync2visible[0]){
					sync2.trigger("owl.goTo", num-1)
				}
			}


			$(document).on('found_variation',function(event,variation){
				var $product = $(event.target).closest('.product');
				if ((typeof variation !== 'undefined') && (typeof variation.variation_id !== 'undefined')) {
					var $stock    = $product.find( '.product_meta' ).find( '.product_stock' );
					// Display SKU
					if ( variation.availability_html ) {
						$stock.wc_set_content( $(variation.availability_html).text() );
					} else {
						$stock.wc_reset_content();
					}


					var variation_id = variation.variation_id,
						$mainImage = $product.find('#sync1');
					var index = parseInt($('a[data-variation_id*="|'+variation_id+'|"]',$mainImage).data('index'),10) ;
					if (!isNaN(index) ) {
						sync1.trigger("owl.goTo",index);
					}
				}
			});

			$(document).on('reset_data',function(event){
				var $product = $(event.target).closest('.product');
				$product.find( '.product_meta' ).find( '.product_stock').wc_reset_content();
				sync1.trigger("owl.goTo",0);
			});

		});
	})(jQuery);
</script>

