<?php

/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */
class G5Plus_Widget_Map_ScrollUp extends G5Plus_Widget
{
    public function __construct()
    {

        $this->widget_cssclass = 'widget-map-scroll-up';
        $this->widget_description = esc_html__("Display map and scroll up", 'g5plus-handmade');
        $this->widget_id = 'handmade-map-scroll-up';
        $this->widget_name = esc_html__('G5Plus: Map & Scroll Up', 'g5plus-handmade');
        $this->settings = array(
            'scroll_up_title' => array(
                'type' => 'text',
                'std' => 'Scroll up',
                'label' => esc_html__('Scroll up title', 'g5plus-handmade')
            ),
            'see_map_title' => array(
                'type' => 'text',
                'std' => 'See map',
                'label' => esc_html__('Link map title ', 'g5plus-handmade')
            ),
            'map_title' => array(
                'type' => 'text',
                'std' => 'Google map',
                'label' => esc_html__('Google map title ', 'g5plus-handmade')
            ),
            'map_layout'  => array(
                'type'    => 'select',
                'std'     => 'container',
                'label'   => esc_html__( 'Map layout', 'g5plus-handmade' ),
                'options' => array(
                    'container' => esc_html__('Container','g5plus-handmade'),
                    'full' => esc_html__('Full','g5plus-handmade')
                )
            ),
            'link_map' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Link to map', 'g5plus-handmade')
            ),
            'location_x' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Or embed google map location x ', 'g5plus-handmade')
            ),
            'location_y' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Google map location y ', 'g5plus-handmade')
            ),
            'zoom' => array(
                'type' => 'text',
                'std' => '12',
                'label' => esc_html__('Google map zoom ', 'g5plus-handmade')
            ),

            'height' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Google map height ', 'g5plus-handmade')
            )
            );

        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $widget_id = $args['widget_id'];

        $link  = empty( $instance['link_map'] ) ? '' : apply_filters( 'widget_link_map', $instance['link_map'] );
        $location_x   = empty( $instance['location_x'] ) ? '' : apply_filters( 'widget_location_x', $instance['location_x'] );
        $location_y   = empty( $instance['location_y'] ) ? '' : apply_filters( 'widget_location_y', $instance['location_y'] );
        $zoom   = empty( $instance['zoom'] ) ? '' : apply_filters( 'widget_zoom', $instance['zoom'] );
        $scroll_up_title   = empty( $instance['scroll_up_title'] ) ? '' : apply_filters( 'widget_scroll_up_title', $instance['scroll_up_title'] );
        $map_title   = empty( $instance['map_title'] ) ? '' : apply_filters( 'widget_map_title', $instance['map_title'] );
        $see_map_title   = empty( $instance['see_map_title'] ) ? '' : apply_filters( 'widget_see_map_title', $instance['see_map_title'] );
        $height = empty( $instance['height'] ) ? '' : $instance['height'];
        $map_layout =  empty( $instance['map_layout'] ) ? '' : $instance['map_layout'];

        echo wp_kses_post($before_widget);
        ?>
        <div class="map-scroll-up">
            <div class="link-wrap">
                <div class="map col-md-6 col-sm-6 col-xs-6">
                    <a href="<?php if(isset($link) && $link!=''){ echo esc_url($link);} else{  echo 'javascript:;';} ?>" class="<?php if(isset($link) && $link!=''){ echo'';} else{  echo 'a-map p-color-hover';} ?>">
                        <i class="pe-7s-map-marker pe-lg pe-va"></i>
                        <span><?php echo wp_kses_post($see_map_title) ?></span>
                    </a>
                </div>
                <div class="scroll-up col-md-6 col-sm-6 col-xs-6">
                    <a href="javascript:;" class="a-scroll-up p-color-hover">
                        <i class="pe-7s-up-arrow"></i>
                        <span><?php echo wp_kses_post($scroll_up_title) ?></span>
                    </a>
                </div>
            </div>

            <?php if(!isset($link) || $link==''){?>
                <div class="handmade-map <?php echo esc_attr($map_layout) ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $shortcode = sprintf('[handmade_google_map map_zoom="%s" location_x="%s" location_y="%s" marker_title="%s" map_height="%s" map_style="none"]', $zoom, $location_x, $location_y, $map_title, $height);
                            if(shortcode_exists('handmade_google_map')){
                                echo do_shortcode($shortcode);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }
}

if (!function_exists('g5plus_register_widget_map_scroll_up')) {
    function g5plus_register_widget_map_scroll_up()
    {
        register_widget('G5Plus_Widget_Map_ScrollUp');
    }

    add_action('widgets_init', 'g5plus_register_widget_map_scroll_up', 1);

}