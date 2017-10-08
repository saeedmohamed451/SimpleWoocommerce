<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/19/15
 * Time: 5:31 PM
 */

$args = array(
    'offset' => $offset,
    'orderby' => 'post__in',
    'post__in' => explode(",", $portfolio_ids),
    'posts_per_page' => $post_per_page,
    'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
    'post_status' => 'publish');

$query_category = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : '';
if($query_category!=''){
    $category = $query_category;
}
if ($data_source == '') {
    $args = array(
        'offset' => $offset,
        'posts_per_page' => $post_per_page,
        'orderby' => 'post_date',
        'order' => $order,
        'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
        G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY => strtolower($category),
        'post_status' => 'publish');
}

$posts_array = new WP_Query($args);
$total_post = $posts_array->found_posts;
$col_class = '';
$col_class = 'handmade-col-md-' . $column;
if ($data_section_id == '')
    $data_section_id = uniqid();
$paging_style = $show_pagging == 2 ? 'slider' : 'paging';

?>
<div class="portfolio-container">
    <div
        class="portfolio overflow-hidden <?php echo esc_attr($g5plus_animation . ' ' . $styles_animation . ' ' . $paging_style) ?>"
        id="portfolio-<?php echo esc_attr($data_section_id) ?>">
        <?php if ($show_category != '' || (isset($show_title) && $show_title == 'yes')) { ?>
            <div class="portfolio-tabs <?php if($show_category!=''){ echo 'category ';} if(isset($show_title) && $show_title == 'yes'){ echo ' title';} ?>">
                <?php if (isset($show_title) && $show_title == 'yes') { ?>
                    <div class="title-portfolio left s-font">
                        <span><?php echo wp_kses_post($title); ?>&nbsp;</span>
                        <span class="bottom-line p-color-bt"></span>
                    </div>
                <?php } ?>

                <?php
                if ($show_category != '') {
                    $termIds = array();
                    $portfolio_terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
                    if ($category != '') {
                        $slugSelected = explode(',', $category);
                        foreach ($portfolio_terms as $term) {
                            if (in_array($term->slug, $slugSelected))
                                $termIds[$term->term_id] = $term->term_id;
                        }
                    }
                    $array_terms = array();
                    if($query_category==''){
                        $array_terms = array(
                            'include' => $termIds
                        );
                    }

                    $terms = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, $array_terms);

                    if (count($terms) > 0) {
                        $index = 1;
                        ?>
                        <div
                            class="tab-wrapper line-height-1 <?php echo esc_attr($show_category) ?>">
                            <ul>
                                <li class="<?php if($query_category==''){ echo 'active';} ;?>">
                                    <a class="isotope-portfolio ladda-button handmade-button style2 button-dark button-2x  <?php if($query_category==''){ echo 'active';} ;?>"
                                       data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                       data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                       data-category=""
                                       data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                       data-source="<?php echo esc_attr($data_source) ?>"
                                       data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                       data-group="all" data-filter="*"
                                       data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                       data-current-page="1"
                                       data-offset="<?php echo esc_attr($offset) ?>"
                                       data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                       data-order="<?php echo esc_attr($order) ?>"
                                       data-column="<?php echo esc_attr($column) ?>"
                                       data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                       data-style="zoom-out" data-spinner-color="#fff"
                                       href="javascript:;">
                                        <?php echo esc_html__('All', 'g5plus-handmade') ?>
                                    </a>
                                </li>
                                <?php
                                foreach ($terms as $term) {
                                    ?>
                                    <li class="<?php if ($index == count($terms)) {
                                        echo "last";
                                    } ?> <?php if($query_category==$term->slug){ echo ' active';} ;?>">
                                        <a class="isotope-portfolio ladda-button handmade-button style2 button-dark button-2x <?php if($query_category==$term->slug){ echo ' active';} ;?>"
                                           href="javascript:;" data-section-id="<?php echo esc_attr($data_section_id) ?>"
                                           data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                                           data-category="<?php echo esc_attr($term->slug) ?>"
                                           data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                                           data-source="<?php echo esc_attr($data_source) ?>"
                                           data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                                           data-layout-type="<?php echo esc_attr($layout_type) ?>"
                                           data-current-page="1"
                                           data-offset="<?php echo esc_attr($offset) ?>"
                                           data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                                           data-column="<?php echo esc_attr($column) ?>"
                                           data-order="<?php echo esc_attr($order) ?>"
                                           data-group="<?php echo preg_replace('/\s+/', '', str_replace('%','',$term->slug)) ?>"
                                           data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                                           data-filter=".<?php echo str_replace('%','',$term->slug) ?>"
                                           data-style="zoom-out"
                                           data-spinner-color="#fff">
                                            <?php echo wp_kses_post($term->name) ?>
                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>

                    <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
        <?php
        $data_plugin_options = $owl_carousel_class = '';
        if ($show_pagging == '2' && $total_post / $item > 1) {
            $data_plugin_options = 'data-plugin-options=\'{ "items" : ' . $column . ',"pagination": false, "navigation": true, "autoPlay": false}\'';
            $owl_carousel_class = 'owl-carousel';
        }
        ?>
        <div
            class="portfolio-wrapper <?php echo sprintf('%s %s %s %s', $col_class, $padding, $layout_type, $owl_carousel_class) ?>" <?php echo wp_kses_post($data_plugin_options) ?>
            data-section-id="<?php echo esc_attr($data_section_id) ?>"
            id="portfolio-container-<?php echo esc_attr($data_section_id) ?>"
            data-columns="<?php echo esc_attr($column) ?>">
            <?php
            $index = 0;

            while ($posts_array->have_posts()) : $posts_array->the_post();
                $index++;
                $permalink = get_permalink();
                $title_post = get_the_title();
                $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
                $cat = $cat_filter = '';
                foreach ($terms as $term) {
                    $cat_filter .= str_replace("%","",$term->slug) . ' ';
                    $cat .= $term->name . ', ';
                }
                $cat = rtrim($cat, ', ');

                ?>

                <?php
                include(plugin_dir_path(__FILE__) . '/loop/' . $layout_type . '-item.php');
                ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>

        </div>
        <?php if ($show_pagging == '1' && $post_per_page > 0 && $total_post / $post_per_page > 1 && $total_post > ($post_per_page * $current_page)) { ?>
            <div style="clear: both"></div>
            <div class="paging" id="load-more-<?php echo esc_attr($data_section_id) ?>">
                <a href="javascript:;" class="handmade-button style1 button-3x load-more ladda-button "
                   data-source="<?php echo esc_attr($data_source) ?>"
                   data-tab-category-action="<?php echo esc_attr($tab_category_action) ?>"
                   data-load-type="<?php echo esc_attr($tab_category_action) ?>"
                   data-overlay-style="<?php echo esc_attr($overlay_style) ?>"
                   data-category="<?php echo esc_attr($category) ?>"
                   data-portfolio-ids="<?php echo esc_attr($portfolio_ids) ?>"
                   data-section-id="<?php echo esc_attr($data_section_id) ?>"
                   data-current-page="<?php echo esc_attr($current_page + 1) ?>"
                   data-column="<?php echo esc_attr($column); ?>"
                   data-offset="<?php echo esc_attr($offset) ?>"
                   data-current-page="<?php echo esc_attr($current_page) ?>"
                   data-post-per-page="<?php echo esc_attr($post_per_page) ?>"
                   data-show-paging="<?php echo esc_attr($show_pagging) ?>"
                   data-padding="<?php echo esc_attr($padding) ?>"
                   data-layout-type="<?php echo esc_attr($layout_type) ?>"
                   data-order="<?php echo esc_attr($order) ?>"
                   data-style="zoom-out" data-spinner-color="#fff"
                    ><?php esc_html_e('Load more', 'g5plus-handmade') ?></a>
            </div>
        <?php } ?>

    </div>
</div>


<?php if (isset($ajax_load) && $ajax_load == '0') { ?>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            <?php if($show_pagging!='2') {?>
            $(document).ready(function () {
                <?php if(isset($tab_category_action) && $tab_category_action=='filter') { ?>
                var $tab_container = jQuery('#portfolio-<?php echo esc_attr($data_section_id); ?>');
                $('.portfolio-tabs .isotope-portfolio', $tab_container).off();
                $('.portfolio-tabs .isotope-portfolio', $tab_container).click(function () {
                    $('.portfolio-tabs .isotope-portfolio', $tab_container).removeClass('active');
                    $('.portfolio-tabs li', $tab_container).removeClass('active');
                    $(this).addClass('active');
                    $(this).parent().addClass('active');
                    var dataSectionId = $(this).attr('data-section-id');
                    var filter = $(this).attr('data-filter');
                    var $container = jQuery('div[data-section-id="' + dataSectionId + '"]').isotope({ filter: filter});
                    $container.imagesLoaded(function () {
                        $container.isotope('layout');
                    });
                });
                var $container = jQuery('div[data-section-id="<?php echo esc_attr($data_section_id); ?>"]');
                $container.imagesLoaded(function () {
                    $container.isotope({
                        itemSelector: '.portfolio-item'
                    }).isotope('layout');
                });
                <?php } ?>
            });

            <?php } ?>

            $(document).ready(function () {
                <?php if (g5framework_is_enable_hover_dir($overlay_style)) {?>
                $('.portfolio-item.hover-dir > div.entry-thumbnail').hoverdir();
                <?php } ?>
                PortfolioAjaxAction.init('<?php echo esc_url(get_site_url() . '/wp-admin/admin-ajax.php') ?>', '<?php echo esc_attr($tab_category_action) ?>', '<?php echo esc_attr($data_section_id)?>');
            })

        })(jQuery);
    </script>
<?php } ?>


