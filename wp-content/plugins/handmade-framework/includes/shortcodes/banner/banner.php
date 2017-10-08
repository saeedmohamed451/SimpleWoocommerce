<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Banner')) {
    class g5plusFramework_Shortcode_Banner
    {
        function __construct()
        {
            add_shortcode('handmade_banner', array($this, 'banner_shortcode'));
        }
        function banner_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $icon_type
             * @var $icon_fontawesome
             * @var $icon_handmade
             * @var $icon_openiconic
             * @var $icon_typicons
             * @var $icon_entypoicons
             * @var $icon_linecons
             * @var $icon_image
             * @var $border_color
             * @var $bg_color
             * @var $text_color
             * @var $location_content
             * @var $content_align
             * @var $location_style2
             * @var $location_border
             * @var $add_button
             * @var $content_style
             * @var $overlay_banner
             * @var $image
             * @var $link
             * @var $title
             * @var $sub_title
             * @var $description
             * @var $height
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $style_index=$style_bg=$sub_color=$style_border=$location_border=$location_style2=$location_content=$border_color=$style=$iconClass='';
            $atts = vc_map_get_attributes( 'handmade_banner', $atts );
            extract( $atts );
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            }
            global $g5plus_options;
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade_banner_css', plugins_url('handmade-framework/includes/shortcodes/banner/assets/css/banner' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );

            $a_href='#';
            $a_title = $title;
            $a_target = '_self';

            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            if (!empty($bg_color) && $layout_style == 'style4'){
                $style_bg = 'style= "background-color: '.$bg_color.';"';
                $style_index = 'style= "border-color: '.$bg_color.';"';
            }
            if (!empty($border_color) && $layout_style == 'style1'){
                $style_border = 'style= "border-color: '.$border_color.';"';
            }
            if (!empty($text_color)){
                $sub_color = 'style="color: '.$text_color.';"';
            }
            if (!empty($image)) {
                $bg_images_attr = wp_get_attachment_image_src($image, "full");
                if (isset($bg_images_attr)) {
                    if (!empty($height)) {
                        if(!empty($border_color) && $layout_style == 'style3'){
                            $style = ' style="height:' . $height . 'px; background-image: url(' . $bg_images_attr[0] . '); border-color:'.$border_color.'";';
                        }else {
                            $style = ' style="height:' . $height . 'px; background-image: url(' . $bg_images_attr[0] . ');"';
                        }
                    }else {
                        if(!empty($border_color) && $layout_style == 'style3'){
                            $style = ' style="background-image: url(' . $bg_images_attr[0] . '); border-color:'.$border_color.'";';
                        }else {
                            $style = ' style="background-image: url(' . $bg_images_attr[0] . ');"';
                        }
                    }
                }
            }

	        $banner_class = array('handmade-banner', $layout_style, $g5plus_animation);
	        if($layout_style =='custom'){
		        $banner_class[] = esc_attr($location_content);
	        }
	        if($layout_style == 'style1'){
		        $banner_class[] = esc_attr($content_align);
	        }
	        if($layout_style == 'style2') {
		        $banner_class[] = esc_attr($location_style2);
	        }
	        if($layout_style == 'style3') {
		        $banner_class[] = esc_attr($location_border);
	        }
	        if($layout_style == 'style2' && (empty($title)) && (empty($sub_title)) && (empty($description)) && $add_button == 'yes-add' ){
		        $banner_class[] = 'only-button';
	        }
	        if(($layout_style == 'style2' && $add_button == 'yes-add') && ((!empty($title)) || (!empty($sub_title)) || (!empty($description)))){
		        $banner_class[] = 'yes-add';
	        }
            ob_start();?>
            <div <?php echo wp_kses_post($style_border)?> <?php echo wp_kses_post($style_bg)?> class="<?php echo join(' ', $banner_class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php if($layout_style == 'style2') :?>
                <div class="overflow-hidden">
                    <?php endif;?>
                    <div class="bg-img" <?php echo wp_kses_post($style)?>></div>
                    <?php if($layout_style == 'style2'):?>
                </div>
                <?php endif;?>
                <div class="overlay-banner">
                    <a class= 'link-banner' title="<?php echo esc_attr($a_title ); ?>" target="<?php echo esc_attr($a_target); ?>" href="<?php echo  esc_url($a_href) ?>">
                        <div class="content-middle">
                            <div class="content-middle-inner">
                                <?php if($layout_style == 'style4' && (!empty($a_title))):?>
                                    <span <?php echo wp_kses_post($style_index)?> class="title-style4">
                                        <?php echo esc_html($a_title)?>
                                    </span>
                                <?php endif;
                                if ($layout_style == 'custom-icon'):?>
                                    <?php if ( $icon_type != '' ) :
                                        if ( $icon_type == 'image' ) :
                                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                                            <img src="<?php echo esc_url($img[0])?>"/>
                                        <?php else :?>
                                            <i class="<?php echo esc_attr($iconClass) ?>"></i>
                                        <?php endif;
                                    endif;?>
                                <?php endif;
                                if(!empty ($title)):?>
                                    <h2><?php echo esc_attr($title)?></h2>
                                <?php endif;
                                if(!empty($sub_title)):?>
                                    <span <?php echo wp_kses_post($sub_color)?> class="sub-title"><?php echo esc_html($sub_title)?></span>
                                <?php endif;
                                if(!empty($description)):?>
                                    <p><?php echo esc_html($description)?></p>
                                <?php endif;
                                if($layout_style == 'custom-button' || ($layout_style == 'style2' && $add_button == 'yes-add')):?>
                                    <span class="handmade-button style1 button-1x">
                                    <?php if(!empty($a_title)):?><?php echo esc_html($a_title)?><?php endif;?>
                                        <i class="pe-7s-right-arrow"></i>
                                </span>
                                <?php endif;?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Banner();
}