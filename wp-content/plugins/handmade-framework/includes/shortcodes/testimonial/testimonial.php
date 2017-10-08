<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Testimonial')) {
    class g5plusFramework_Shortcode_Testimonial
    {
        function __construct()
        {
            add_shortcode('handmade_testimonial_ctn', array($this, 'testimonial_ctn_shortcode'));
            add_shortcode('handmade_testimonial_sc', array($this, 'testimonial_sc_shortcode'));
        }
        function testimonial_ctn_shortcode($atts, $content)
        {
	        /**
	         * Shortcode attributes
             * @var $layout_style
	         * @var $color_scheme
             * @var $border
	         * @var $stoponhover
	         * @var $autoplay
	         * @var $autoheight
	         * @var $slidespeed
	         * @var $paginationspeed
	         * @var $rewindspeed
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
	        $atts = vc_map_get_attributes( 'handmade_testimonial_ctn', $atts );
	        extract( $atts );
	        $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if ($layout_style == 'style3') {
                $data_carousel = '"singleItem":false,"items":2,"itemsDesktop":[1199, 2],"itemsDesktopSmall":[980, 1],"itemsTablet":[768, 1]';
            } else {
                $data_carousel = '"singleItem":true,"transitionStyle":"fade"';
            }
            $stoponhover = ($stoponhover == 'yes') ? 'true' : 'false';
            $autoheight = ($autoheight == 'yes') ? 'true' : 'false';
            if ($layout_style == 'style1') {
                $data_carousel .= ',"pagination":true';
            } else {
                $data_carousel .= ',"pagination":false';
            }
            $data_carousel .= ',"navigation":false';
            $data_carousel.=',"stopOnHover":'.$stoponhover;
            $data_carousel.=',"autoHeight":'.$autoheight;
            if($autoplay!='')
            {
                $data_carousel.=',"autoPlay":'.$autoplay;
            }
            if($slidespeed!='')
            {
                $data_carousel.=',"slideSpeed":'.$slidespeed;
            }
            if($paginationspeed!='')
            {
                $data_carousel.=',"paginationSpeed":'.$paginationspeed;
            }
            if($rewindspeed!='')
            {
                $data_carousel.=',"rewindSpeed":'.$rewindspeed;
            }
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_testimonial_css', plugins_url('handmade-framework/includes/shortcodes/testimonial/assets/css/testimonial' . $min_suffix_css . '.css'), array(), false);
            ob_start();?>
            <div
                class="handmade-testimonial<?php if ($border == 'yes') echo ' border-p-color';
                echo esc_attr(' ' . $layout_style . ' ' . $color_scheme . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'
                     class="owl-carousel">
                    <?php echo do_shortcode($content); ?>
                </div>
            </div>
            <?php
            $output = ob_get_clean();
            return $output;
        }
        function testimonial_sc_shortcode($atts,$content = nul)
        {
            $author = $author_info = $image = '';
            extract(shortcode_atts(array(
                'image'            => '',
                'author' => '',
                'author_info' => ''
            ), $atts));
            ob_start();?>
            <div class="testimonial-item">
                <div class="testimonial-avatar">
                    <?php $img_id = preg_replace('/[^\d]/', '', $image);
                    $img = wpb_getImageBySize(array('attach_id' => $img_id, 'thumb_size' => '123'));
                    echo wp_kses_post($img['thumbnail']);
                    ?>
                </div>
                <div class="testimonial-info">
                    <p><?php echo wp_strip_all_tags($content) ?></p>
                    <?php if ($author != ''): ?>
                        <h3 class="p-color"><?php echo esc_html($author) ?></h3>
                    <?php endif; ?>
                    <?php if ($author_info != ''): ?>
                        <span class="s-color"><?php echo esc_html($author_info) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            $output = ob_get_clean();
            return $output;
        }
    }
    new g5plusFramework_Shortcode_Testimonial();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_handmade_testimonial_ctn extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_handmade_testimonial_sc extends WPBakeryShortCode {
    }
}