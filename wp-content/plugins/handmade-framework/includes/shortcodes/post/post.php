<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/4/15
 * Time: 2:41 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Post')):
    class g5plusFramework_Shortcode_Post
    {
        function __construct()
        {
            add_shortcode('handmade_post', array($this, 'post_shortcode'));
        }

        function post_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $title
             * @var $category
             * @var $display
             * @var $item_amount
             * @var $column
             * @var $is_slider
             * @var $pagination
             * @var $navigation
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $title = $category = $display = $item_amount = $column = $is_slider = $pagination = $navigation = $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('handmade_post', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $query['posts_per_page'] = $item_amount;
            $query['no_found_rows'] = true;
            $query['post_status'] = 'publish';
            $query['ignore_sticky_posts'] = true;
            $query['post_type'] = 'post';
            if (!empty($category)) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio'),
                        'operator' => 'NOT IN'
                    ),
                    array(
                        'taxonomy' => 'category',
                        'terms' => explode(',', $category),
                        'field' => 'slug',
                        'operator' => 'IN'
                    )
                );
            } else {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio'),
                        'operator' => 'NOT IN'
                    )
                );
            }
            if ($display == 'random') {
                $query['orderby'] = 'rand';
            } elseif ($display == 'popular') {
                $query['orderby'] = 'comment_count';
            } elseif ($display == 'recent') {
                $query['orderby'] = 'post_date';
                $query['order'] = 'DESC';
            } else {
                $query['orderby'] = 'post_date';
                $query['order'] = 'ASC';
            }
            $r = new WP_Query($query);
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_post_css', plugins_url('handmade-framework/includes/shortcodes/post/assets/css/post' . $min_suffix_css . '.css'), array(), false);
            $pagination = ($pagination == 'yes') ? 'true' : 'false';
            $navigation = ($navigation == 'yes') ? 'true' : 'false';
            ob_start();
            if ($r->have_posts()) :
                ?>
                <div
                    class="handmade-post<?php if ($title == '' && $navigation == 'true') echo ' margin-top-60';
                    echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                    <?php if ($title != ''): ?>
                        <h2><?php echo esc_attr($title) ?></h2>
                    <?php endif; ?>
                    <?php if ($title != '' || $navigation == 'true'): ?>
                        <div class="handmade-line"></div>
                    <?php endif; ?>
                    <div class="row<?php if (!$is_slider) echo ' column-equal-height' ?>">
                        <?php if ($is_slider) :
                            $data_carousel = '"autoPlay": true, "items":' . $column . ',"itemsDesktop":[1199, ' . $column . '],"itemsDesktopSmall":[980, ' . $column . '],"itemsTablet":[768, 1]';
                            $data_carousel .= ', "pagination":' . $pagination . ', "navigation":' . $navigation;
                            ?>
                            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'
                                 class="owl-carousel">
                                <?php while ($r->have_posts()) : $r->the_post(); ?>
                                    <div class="handmade-post-item">
                                        <?php
                                        $thumbnail = g5plus_post_thumbnail('blog-related');
                                        if (!empty($thumbnail)) : ?>
                                            <div class="handmade-post-image">
                                                <?php echo wp_kses_post($thumbnail); ?>
                                                <div class="handmade-post-image-overlay">
                                                    <a class="handmade-post-readmore" href="<?php the_permalink(); ?>"
                                                       title="<?php the_title(); ?>"><?php esc_html_e('READ MORE', 'g5plus-handmade'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="handmade-post-content">
                                            <h3><a href="<?php the_permalink(); ?>"
                                                   rel="bookmark"
                                                   title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                                            <div class="post-entry-meta p-color">
                                                <span
                                                    class="handmade-post-date"><?php echo get_the_date(get_option('date_format')); ?></span>
                                                | <span
                                                    class="handmade-post-author"><?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?></span>
                                            </div>
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            $excerpt = g5plusFramework_Shortcodes::substr($excerpt, 143, ' ...');
                                            ?>
                                            <p><?php echo($excerpt); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else:
                            while ($r->have_posts()) : $r->the_post(); ?>
                                <div class="col-md-<?php echo(12 / esc_attr($column)) ?> col-sm-6">
                                    <div class="handmade-post-item margin-bottom-30">
                                        <?php
                                        $thumbnail = g5plus_post_thumbnail('blog-related');
                                        if (!empty($thumbnail)) : ?>
                                            <div class="handmade-post-image">
                                                <?php echo wp_kses_post($thumbnail); ?>
                                                <div class="handmade-post-image-overlay">
                                                    <a class="handmade-post-readmore" href="<?php the_permalink(); ?>"
                                                       title="<?php the_title(); ?>"><?php esc_html_e('READ MORE', 'g5plus-handmade'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="handmade-post-content">
                                            <h3><a href="<?php the_permalink(); ?>"
                                                   rel="bookmark"
                                                   title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                                            <div class="post-entry-meta p-color">
                                                <span
                                                    class="handmade-post-date"><?php echo get_the_date(get_option('date_format')); ?></span>
                                                | <span
                                                    class="handmade-post-author"><?php printf('<a href="%1$s">%2$s</a>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), esc_html(get_the_author())); ?></span>
                                            </div>
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            $excerpt = g5plusFramework_Shortcodes::substr($excerpt, 143, ' ...');
                                            ?>
                                            <p><?php echo($excerpt); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>
                <?php
            endif;
            wp_reset_postdata();
            g5plus_archive_loop_reset();
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Post();
endif;