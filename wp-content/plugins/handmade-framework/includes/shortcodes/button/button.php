<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Button')) {
    class g5plusFramework_ShortCode_Button
    {
        function __construct()
        {
            add_shortcode('handmade_button', array($this, 'button_shortcode'));
        }

        function button_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $custom_background
             * @var $custom_text
             * @var $custom_border
             * @var $add_icon
             * @var $icon_type
             * @var $icon_image
             * @var $color_background
             * @var $size
             * @var $color_scheme
             * @var $link
             * @var $i_align
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $iconClass='';
            $atts = vc_map_get_attributes( 'handmade_button', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            }
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
            $a_title='';
            $a_target='_self';
            $a_href='#';
            if ( strlen( $link['title'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }

            $button_class = array('handmade-button');
            $button_class[] = $layout_style;
            if ($layout_style == 'style2') {
                $button_class[] = $color_scheme;
            }
            $button_class[] = $size;
            $button_class[] = $g5plus_animation;
            if($layout_style == 'style1') {
                $button_class[] = $color_background;
            }
            if($add_icon == 'yes'){
                $button_class[] = $i_align;
            }
            ob_start();?>

                <a  class="<?php echo join(' ',$button_class); ?>"<?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?> href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>">
                    <?php if($i_align == 'i_right'): echo esc_html($a_title); endif;?>
                    <?php if ( $icon_type != '' ) :
                        if ( $icon_type == 'image' ) :
                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                            <img src="<?php echo esc_attr($img[0])?>"/>
                        <?php else :?>
                            <i class="<?php echo esc_attr($iconClass)?>"></i>
                        <?php endif;
                    endif;?>
                    <?php if($i_align == 'i_left'): echo esc_html($a_title); endif;?>
                </a>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Button();
}