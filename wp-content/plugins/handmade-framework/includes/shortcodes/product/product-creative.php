<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/30/15
 * Time: 10:15 AM
 */

if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Product_Cretive')) {
    class g5plusFramework_Shortcode_Product_Cretive
    {
        function __construct()
        {
            add_shortcode('handmade_product_creative', array($this, 'product_creative_shortcode'));
        }

        function  product_creative_shortcode($atts)
        {
            global $g5plus_options;
            $min_suffix = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_product_css', plugins_url('handmade-framework/includes/shortcodes/product/assets/css/style' . $min_suffix . '.css'), array(), false);

            $atts = vc_map_get_attributes('handmade_product_creative', $atts);
            $title = $feature = $category = $per_page = $columns = $rating = $slider = $orderby = $order = $el_class = $css_animation = $duration = $delay = '';
            extract(shortcode_atts(array(
                'columns' => '3',
                'title' => '',
                'feature' => 'all',
                'category' => '',
                'per_page' => '6',
                'rating' => 0,
                'slider' => 'isotope-slider',
                'orderby' => 'date',
                'order' => 'DESC',
                'el_class' => '',
                'css_animation' => '',
                'duration' => '',
                'delay' => ''
            ), $atts));


            $meta_query = WC()->query->get_meta_query();
            $query_args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $per_page,
                'meta_query' => $meta_query
            );

            if (!empty($category)) {
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => explode(',', $category),
                        'field' => 'slug',
                        'operator' => 'IN'
                    )
                );
            }

            switch ($feature) {
                case 'sale':
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $query_args['post__in'] = array_merge(array(0), $product_ids_on_sale);
                    break;
                case 'new-in':
                    $query_args['orderby'] = 'DESC';
                    $query_args['order'] = 'date';
                    break;
                case 'featured':
                    $query_args['meta_query'][] = array(
                        'key'   => '_featured',
                        'value' => 'yes'
                    );
                    break;
                case 'top-rated':
                    if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) {
                        add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
                    } else {
                        $query_args['meta_key'] = '_wc_average_rating';
                        $query_args['orderby'] = 'meta_value_num';
                        $query_args['order'] = 'DESC';
                        $query_args['meta_query'] = WC()->query->get_meta_query();
                        $query_args['tax_query'] = WC()->query->get_tax_query();
                    }
                    break;
                case 'recent-review':
                    add_filter('posts_clauses', array($this, 'order_by_comment_date_post_clauses'));
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


            $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $query_args, $atts));

            if ($feature == 'top-rated') {
                if (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION,'3.0.0','<')) {
                    remove_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
                }
            }

            if ($feature == 'recent-review') {
                remove_filter('posts_clauses', array($this, 'order_by_comment_date_post_clauses'));
            }

            $class = array('woocommerce sc-product-wrap');
            $class[] = $el_class;
            $class[] = g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $class_name = join(' ', $class);
            global $g5plus_woocommerce_loop;
            $g5plus_woocommerce_loop['columns'] = $columns;
            $g5plus_woocommerce_loop['layout'] = $slider;
            $g5plus_woocommerce_loop['masonry'] = 1;
            $g5plus_woocommerce_loop['rating'] = $rating == 1 ? 1 : 0;
            $g5plus_woocommerce_loop['post_index'] = 1;
            $total_product = isset($products) ? $products->post_count : 0;
            $pages = floor($total_product / 6) + ($total_product % 6 > 0 ? 1 : 0);
            if ($columns == 2) {
                $pages = floor($total_product / 5) + ($total_product % 5 > 0 ? 1 : 0);
            }
            $data_section_id = uniqid();
            ob_start();
            ?>
            <?php if ($products->have_posts()) : ?>
            <div id="<?php echo esc_attr($data_section_id) ?>" data-columns="<?php echo esc_attr($columns) ?>"
                 class="<?php echo esc_attr($class_name) ?> product-creative" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php if (!empty($title)) : ?>
                    <h3 class="sc-title s-font"><span><?php echo esc_html($title); ?></span></h3>
                <?php endif; ?>
                <?php if ($pages >= 1) {
                    $nav_class= 'iso-filter ';
                    if ($pages==1){
                        $nav_class .= ' hidden-lg';

                    }
                    ?>
                    <a href="javascript:;" class="<?php echo $nav_class ?>" data-section-id="<?php echo esc_attr($data_section_id) ?>"
                       data-page="1" data-total-product="<?php echo esc_attr($total_product) ?>"
                       data-total-pages="<?php echo esc_attr($pages) ?>" data-navigation="prev"><span class="prev"><i
                                class='fa fa-angle-left'></i></span></a>
                    <a href="javascript:;" class="<?php echo $nav_class ?>" data-section-id="<?php echo esc_attr($data_section_id) ?>"
                       data-page="1" data-total-product="<?php echo esc_attr($total_product) ?>"
                       data-total-pages="<?php echo esc_attr($pages) ?>" data-navigation="next"><span class="next"><i
                                class='fa fa-angle-right'></i></span></a>
                <?php } ?>
                <?php woocommerce_product_loop_start(); ?>
                <?php while ($products->have_posts()) : $products->the_post();
                    ?>
                    <?php wc_get_template_part('content', 'product-creative');
                    $g5plus_woocommerce_loop['post_index']++;?>
                <?php endwhile; // end of the loop. ?>
                <?php woocommerce_product_loop_end();
                $g5plus_woocommerce_loop['post_index'] = null;
                $g5plus_woocommerce_loop['masonry'] = '';
                ?>
            </div>
        <?php else: ?>
            <div class="item-not-found"><?php echo esc_html__('No item found', 'g5plus-handmade') ?></div>
        <?php endif; ?>
            <?php
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;

        }

        function order_by_comment_date_post_clauses($args)
        {
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

    new g5plusFramework_Shortcode_Product_Cretive();

}