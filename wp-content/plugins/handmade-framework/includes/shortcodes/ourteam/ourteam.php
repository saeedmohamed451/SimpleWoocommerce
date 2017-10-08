<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
// Include post types
global $ourteam_metabox;
$ourteam_metabox = new WPAlchemy_MetaBox(array
(
    'id' => 'handmade_ourteam_settings',
    'title' => esc_html__('Our Team Social Settings', 'g5plus-handmade'),
    'template' => plugin_dir_path(__FILE__) . 'custom-field.php',
    'types' => array('ourteam'),
    'autosave' => TRUE,
    'priority' => 'high',
    'context' => 'normal',
    'hide_editor' => TRUE
));
if (!class_exists('g5plusFramework_Shortcode_Ourteam')) {
    class g5plusFramework_Shortcode_Ourteam
    {
        function __construct()
        {
            add_action('init', array($this, 'register_taxonomies'), 5);
            add_action('init', array($this, 'register_post_types'), 5);
            add_shortcode('handmade_ourteam', array($this, 'ourteam_shortcode'));
            add_filter('rwmb_meta_boxes', array($this, 'register_meta_boxes'));
            if (is_admin()) {
                add_filter('manage_edit-ourteam_columns', array($this, 'add_columns'));
                add_action('manage_ourteam_posts_custom_column', array($this, 'set_columns_value'), 10, 2);
                add_action('admin_menu', array($this, 'addMenuChangeSlug'));
            }
        }

        function register_taxonomies()
        {
            if (taxonomy_exists('ourteam_category')) {
                return;
            }

            $post_type = 'ourteam';
            $taxonomy_slug = 'ourteam_category';
            $taxonomy_name = 'Our Team Categories';

            $post_type_slug = get_option('g5plus-handmade-' . $post_type . '-config');
            if (isset($post_type_slug) && is_array($post_type_slug) &&
                array_key_exists('taxonomy_slug', $post_type_slug) && $post_type_slug['taxonomy_slug'] != ''
            ) {
                $taxonomy_slug = $post_type_slug['taxonomy_slug'];
                $taxonomy_name = $post_type_slug['taxonomy_name'];
            }
            register_taxonomy('ourteam_category', 'ourteam',
                array('hierarchical' => true,
                    'label' => $taxonomy_name,
                    'query_var' => true,
                    'rewrite' => array('slug' => $taxonomy_slug))
            );
            flush_rewrite_rules();
        }

        function register_post_types()
        {
            $post_type = 'ourteam';

            if (post_type_exists($post_type)) {
                return;
            }

            $post_type_slug = get_option('g5plus-handmade-' . $post_type . '-config');
            if (!isset($post_type_slug) || !is_array($post_type_slug)) {
                $slug = 'ourteam';
                $name = $singular_name = 'Our Team';
            } else {
                $slug = $post_type_slug['slug'];
                $name = $post_type_slug['name'];
                $singular_name = $post_type_slug['singular_name'];
            }

            register_post_type($post_type,
                array(
                    'label' => esc_html__('Our Team', 'g5plus-handmade'),
                    'description' => esc_html__('Our Team Description', 'g5plus-handmade'),
                    'labels' => array(
                        'name' => $name,
                        'singular_name' => $singular_name,
                        'menu_name' => esc_attr($name),
                        'parent_item_colon' => esc_html__('Parent Item:', 'g5plus-handmade'),
                        'all_items' => sprintf(esc_html__('All %s', 'g5plus-handmade'), $name),
                        'view_item' => esc_html__('View Item', 'g5plus-handmade'),
                        'add_new_item' => sprintf(esc_html__('Add New  %s', 'g5plus-handmade'), $name),
                        'add_new' => esc_html__('Add New', 'g5plus-handmade'),
                        'edit_item' => esc_html__('Edit Item', 'g5plus-handmade'),
                        'update_item' => esc_html__('Update Item', 'g5plus-handmade'),
                        'search_items' => esc_html__('Search Item', 'g5plus-handmade'),
                        'not_found' => esc_html__('Not found', 'g5plus-handmade'),
                        'not_found_in_trash' => esc_html__('Not found in Trash', 'g5plus-handmade'),
                    ),
                    'supports' => array('title', 'revisions', 'excerpt', 'thumbnail'),
                    'public' => true,
                    'show_ui' => true,
                    '_builtin' => false,
                    'has_archive' => true,
                    'rewrite' => array('slug' => $slug, 'with_front' => true),
                )
            );
            flush_rewrite_rules();
        }

        function addMenuChangeSlug()
        {
            add_submenu_page('edit.php?post_type=ourteam', 'Setting', 'Settings', 'edit_posts', wp_basename(__FILE__), array($this, 'initPageSettings'));
        }

        function initPageSettings()
        {
            $template_path = ABSPATH . 'wp-content/plugins/handmade-framework/includes/shortcodes/posttype-settings/settings.php';
            if (file_exists($template_path))
                require_once $template_path;
        }

        function add_columns($columns)
        {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__('Name', 'g5plus-handmade')));
            $cols = array_merge($cols, array('job' => esc_html__('Job', 'g5plus-handmade')));
            $cols = array_merge($cols, array('thumbnail' => esc_html__('Picture', 'g5plus-handmade')));
            $cols = array_merge($cols, array('date' => esc_html__('Date', 'g5plus-handmade')));
            return $cols;
        }

        function set_columns_value($column, $post_id)
        {
            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'job': {
                    echo get_post_meta($post_id, 'job', true);
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
            }
        }

        function register_meta_boxes($meta_boxes)
        {
            $meta_boxes[] = array(
                'title' => esc_html__('Our Team Job', 'g5plus-handmade'),
                'pages' => array('ourteam'),
                'fields' => array(
                    array(
                        'name' => esc_html__('Job', 'g5plus-handmade'),
                        'id' => 'job',
                        'type' => 'text',
                    ),
                )
            );
            return $meta_boxes;
        }

        function ourteam_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $item_amount
             * @var $is_slider
             * @var $pagination
             * @var $navigation
             * @var $column
             * @var $category
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $layout_style = $item_amount = $is_slider = $pagination = $navigation = $column = $category = $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('handmade_ourteam', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            global $ourteam_metabox;
            global $meta;
            $args = array(
                'posts_per_page' => $item_amount,
                'post_type' => 'ourteam',
                'orderby' => 'date',
                'order' => 'ASC',
                'post_status' => 'publish'
            );
            if ($category != '') {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'ourteam_category',
                        'field' => 'slug',
                        'terms' => explode(',', $category),
                        'operator' => 'IN'
                    )
                );
            }
            $data = new WP_Query($args);
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_ourteam_css', plugins_url('handmade-framework/includes/shortcodes/ourteam/assets/css/ourteam' . $min_suffix_css . '.css'), array(), false);
            ob_start();
            $class_col = 'col-lg-' . (12 / esc_attr($column)) . ' col-md-' . (12 / esc_attr($column)) . ' col-sm-6  col-xs-12';
            $class_res = '';
            if ($layout_style == 'style1') {
                $class_res = 'col-sm-6 col-xs-12 ';
            }
            if ($data->have_posts()) :?>
                <div
                    class="handmade-ourteam <?php echo esc_attr($layout_style . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                    <div class="row<?php if (!$is_slider) echo ' column-equal-height' ?>">
                        <?php if ($is_slider) :
                            $pagination = ($pagination == 'yes') ? 'true' : 'false';
                            $navigation = ($navigation == 'yes') ? 'true' : 'false';
                            if ($layout_style == 'style1') {
                                $data_carousel = '"autoPlay": true, "items":' . $column . ',"itemsDesktop":[1199, ' . $column . '],"itemsDesktopSmall":[980, ' . $column . '],"itemsTablet":[768, 1]';
                                $data_carousel .= ', "pagination":' . $pagination . ', "navigation":' . $navigation;
                            } else {
                                $data_carousel = '"autoPlay": true, "items":' . $column . ',"itemsDesktop":[1199, ' . $column . '],"itemsDesktopSmall":[980, ' . $column . '],"itemsTablet":[768, 2]';
                                $data_carousel .= ', "pagination":' . $pagination . ', "navigation":' . $navigation;
                            }
                            ?>
                            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'
                                 class="owl-g5plus-shortcode owl-carousel">
                                <?php while ($data->have_posts()): $data->the_post();
                                    $job = get_post_meta(get_the_ID(), 'job', true);
                                    $img_id = get_post_thumbnail_id();
                                    $img = wpb_getImageBySize(array('attach_id' => $img_id, 'thumb_size' => '270x270'));
                                    $img_src=wp_get_attachment_image_src( $img_id, "attached-image" );
                                    ?>
                                    <div class="<?php if ($layout_style == 'style1') echo 'row ' ?>ourteam-item">
                                        <div class="<?php echo esc_attr($class_res) ?>ourteam-avatar">
                                            <div class="ourteam-avatar-inner">
                                                <?php echo wp_kses_post($img['thumbnail']); ?>
                                                <div class="ourteam-avatar-overlay">
                                                    <a data-rel="prettyPhoto" href="<?php echo esc_url($img_src[0]); ?>"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo esc_attr($class_res) ?>ourteam-info">
                                            <h6 class="p-color"><?php echo get_the_title() ?></h6>
                                            <span><?php echo esc_html($job) ?></span>
                                            <ul>
                                                <?php
                                                $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), true);
                                                if (is_array($meta)) {
                                                    foreach ($meta['ourteam'] as $col) {
                                                        $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                                                        $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                                                        $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                                                        ?>
                                                        <li><a href="<?php echo esc_url($socialLink) ?>"
                                                               title="<?php echo esc_url($socialName) ?>"><i
                                                                    class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <?php if ($layout_style == 'style1'): ?>
                                                <p><?php echo esc_html(get_the_excerpt()) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else:
                            while ($data->have_posts()): $data->the_post();
                                $job = get_post_meta(get_the_ID(), 'job', true);
                                $img_id = get_post_thumbnail_id();
                                $img = wpb_getImageBySize(array('attach_id' => $img_id, 'thumb_size' => '270x270'));
                                $img_src=wp_get_attachment_image_src( $img_id, "attached-image" );
                                ?>
                                <div class="<?php echo esc_attr($class_col); ?>">
                                    <div
                                        class="<?php if ($layout_style == 'style1') echo 'row ' ?>ourteam-item margin-bottom-90">
                                        <div class="<?php echo esc_attr($class_res) ?>ourteam-avatar">
                                            <div class="ourteam-avatar-inner">
                                                <?php echo wp_kses_post($img['thumbnail']); ?>
                                                <div class="ourteam-avatar-overlay">
                                                    <a data-rel="prettyPhoto" href="<?php echo esc_url($img_src[0]); ?>"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="<?php echo esc_attr($class_res) ?>ourteam-info">
                                            <h6 class="p-color"><?php echo get_the_title() ?></h6>
                                            <span><?php echo esc_html($job) ?></span>
                                            <ul>
                                                <?php
                                                $meta = get_post_meta(get_the_id(), $ourteam_metabox->get_the_id(), true);
                                                if (is_array($meta)) {
                                                    foreach ($meta['ourteam'] as $col) {
                                                        $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                                                        $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                                                        $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                                                        ?>
                                                        <li><a href="<?php echo esc_url($socialLink) ?>"
                                                               title="<?php echo esc_url($socialName) ?>"><i
                                                                    class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <?php if ($layout_style == 'style1'): ?>
                                                <p><?php echo esc_html(get_the_excerpt()) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile;
                        endif; ?>
                    </div>
                </div>
            <?php endif;
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Ourteam();
}