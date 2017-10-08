<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 7/20/15
 * Time: 1:58 PM
 */
$index=0;
$column = 4;
$image_size = '570x460';
$show_pagging = '2';
$item = 4;

$args = array(
    'post__not_in' => array($post_id),
    'posts_per_page'   => -1,
    'orderby'			=> 'rand',
    'post_type'        => G5PLUS_PORTFOLIO_POST_TYPE,
    'portfolio_category__in'    => $arrCatId,
    'post_status'      => 'publish'
);
$posts_array = new WP_Query( $args );
$total_post = $posts_array->found_posts;
$data_plugin_options = $owl_carousel_class = '';
if ($total_post / $item > 1) {
    $data_plugin_options = 'data-plugin-options=\'{ "items" : ' . $column . ',"pagination": false, "navigation": true, "autoPlay": false}\'';
    $owl_carousel_class = 'owl-carousel';
}

global $g5plus_options;
$overlay_style = 'icon';
$column = 'handmade-col-md-4';
if(isset($g5plus_options['portfolio-related-overlay']))
    $overlay_style = $g5plus_options['portfolio-related-overlay'];
if(isset($g5plus_options['portfolio-related-column']))
    $column = 'handmade-col-md-'.$g5plus_options['portfolio-related-column'];

$layout = 'title';
if(isset($g5plus_options['portfolio_related_style']) && $g5plus_options['portfolio_related_style']!='' )
    $layout = $g5plus_options['portfolio_related_style'];

if ($overlay_style == 'left-title-excerpt-link')
    $overlay_align = 'hover-align-left';
else
    $overlay_align = 'hover-align-center';

?>

<div class="container">
    <div class="portfolio-related-wrap">
        <div class="heading-wrap border-primary-color">
            <div class="heading s-font">
                <?php echo esc_html__('Projects','g5plus-handmade'); ?>
            </div>
        </div>
        <div class="portfolio-related portfolio-wrapper <?php echo sprintf('%s %s',$column, $owl_carousel_class)?>" <?php echo wp_kses_post($data_plugin_options) ?>>
            <?php


            while ( $posts_array->have_posts() ) : $posts_array->the_post();
                $index++;
                $permalink = get_permalink();
                $title_post = get_the_title();
                $terms = wp_get_post_terms( get_the_ID(), array( G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
                $cat = $cat_filter = '';
                foreach ( $terms as $term ){
                    $cat_filter .= preg_replace('/\s+/', '', $term->name) .' ';
                    $cat .= $term->name.', ';
                }
                $cat = rtrim($cat,', ');

                ?>
                <?php include(G5PLUS_PORTFOLIO_DIR_PATH.'/templates/loop/'.$layout.'-item.php');
                ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

