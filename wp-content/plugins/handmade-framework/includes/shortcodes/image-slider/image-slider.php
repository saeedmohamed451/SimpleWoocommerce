<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Image_Slider')) {
    class g5plusFramework_Shortcode_Image_Slider
    {
        function __construct()
        {
            add_shortcode('handmade_image_slider', array($this, 'image_slider_shortcode'));
        }

        function image_slider_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $title
             * @var $images
             * @var $custom_links
             * @var $custom_links_target
             * @var $img_size
             * @var $navigation
             * @var $pagination
             * @var $autoplay
             * @var $items
             * @var $itemsdesktop
             * @var $itemsdesktopsmall
             * @var $itemstablet
             * @var $itemstabletsmall
             * @var $itemsmobile
             * @var $stoponhover
             * @var $slidespeed
             * @var $paginationspeed
             * @var $rewindspeed
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $title = $images = $opacity = $custom_links = $custom_links_target = $img_size = $column = $autoplay = $pagination = $navigation = $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('handmade_image_slider', $atts);
            extract($atts);
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_image_slider_css', plugins_url('handmade-framework/includes/shortcodes/image-slider/assets/css/image-slider' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if ($images == '') $images = '-1,-2,-3';

            $custom_links = explode(',', $custom_links);

            $images = explode(',', $images);
            $i = -1;
            $data_carousel = '"singleItem": false,"autoHeight":false';

            $pagination = ($pagination == 'yes') ? 'true' : 'false';
            $navigation = ($navigation == 'yes') ? 'true' : 'false';
            $stoponhover = ($stoponhover == 'yes') ? 'true' : 'false';

            $data_carousel .= ',"navigation":' . $navigation;
            $data_carousel .= ',"pagination":' . $pagination;
            $data_carousel .= ',"stopOnHover":' . $stoponhover;
            if ($autoplay != '') {
                $data_carousel .= ',"autoPlay":' . $autoplay;
            }
            if ($items != '') {
                $data_carousel .= ',"items":' . $items;
            }
            if ($itemsdesktop != '') {
                if ($itemsdesktop != 'false') {
                    $data_carousel .= ',"itemsDesktop":[' . $itemsdesktop . ']';
                } else {
                    $data_carousel .= ',"itemsDesktop":' . $itemsdesktop;
                }
            }
            if ($itemsdesktopsmall != '') {
                if ($itemsdesktopsmall != 'false') {
                    $data_carousel .= ',"itemsDesktopSmall":[' . $itemsdesktopsmall . ']';
                } else {
                    $data_carousel .= ',"itemsDesktopSmall":' . $itemsdesktopsmall;
                }

            }
            if ($itemstablet != '') {
                if ($itemstablet != 'false') {
                    $data_carousel .= ',"itemsTablet":[' . $itemstablet . ']';
                } else {
                    $data_carousel .= ',"itemsTablet":' . $itemstablet;
                }
            }
            if ($itemstabletsmall != '') {
                if ($itemstabletsmall != 'false') {
                    $data_carousel .= ',"itemsTabletSmall":[' . $itemstabletsmall . ']';
                } else {
                    $data_carousel .= ',"itemsTabletSmall":' . $itemstabletsmall;
                }
            }
            if ($itemsmobile != '') {
                if ($itemsmobile != 'false') {
                    $data_carousel .= ',"itemsMobile":[' . $itemsmobile . ']';
                } else {
                    $data_carousel .= ',"itemsMobile":' . $itemsmobile;
                }
            }
            if ($slidespeed != '') {
                $data_carousel .= ',"slideSpeed":' . $slidespeed;
            }
            if ($paginationspeed != '') {
                $data_carousel .= ',"paginationSpeed":' . $paginationspeed;
            }
            if ($rewindspeed != '') {
                $data_carousel .= ',"rewindSpeed":' . $rewindspeed;
            }
            ob_start(); ?>
            <div
                class="handmade-image-slider <?php if ($title == '' && $navigation == 'true') echo ' margin-top-60';
                echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php if ($title != ''): ?>
                    <h2><?php echo esc_attr($title) ?></h2>
                <?php endif; ?>
                <?php if ($title != '' || $navigation == 'true'): ?>
                    <div class="handmade-line"></div>
                <?php endif; ?>
                <div class="row">
                    <div class="owl-carousel"
                         data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'>
                        <?php foreach ($images as $attach_id):
                            $i++;
                            if ($attach_id > 0) {
                                $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
                            } else {
                                $post_thumbnail = array();
                                $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url('vc/no_image.png') . '" />';
                                $post_thumbnail['p_img_large'][0] = vc_asset_url('vc/no_image.png');
                            }
                            $thumbnail = $post_thumbnail['thumbnail'];
                            if (isset($custom_links[$i]) && $custom_links[$i] != ''):?>
                                <a href="<?php echo esc_url($custom_links[$i]) ?>"
                                   target="<?php echo esc_attr($custom_links_target) ?>">
                                    <?php echo wp_kses_post($thumbnail) ?>
                                </a>
                            <?php else:
                                echo wp_kses_post($thumbnail);
                            endif;
                        endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Image_Slider();
}