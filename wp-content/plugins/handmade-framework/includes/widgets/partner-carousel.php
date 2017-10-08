<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */

class G5Plus_Widget_Partner_Carousel extends  g5plus_acf_widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-partner-carousel';
        $this->widget_description = esc_html__( "Display partner that declare in Theme Option", 'g5plus-handmade' );
        $this->widget_id          = 'handmade-partner-carousel';
        $this->widget_name        = esc_html__( 'G5Plus: Partner Carousel', 'g5plus-handmade' );
        $this->settings           = array(
            'id'          => 'partner_carousel_acf',
            'type'        => 'rows',
            'title'       => esc_html__('Partner Carousel', 'g5plus-handmade'),
            'fields'      => array(
                array(
                    'name' => 'partner_name',
                    'title' => 'Partner name',
                    'type'  => 'text',
                    'is_title_block' => 1
                ),
                array(
                    'name' => 'partner_link',
                    'title' => 'Partner link',
                    'type'  => 'text'
                ),
                array(
                    'name' => 'partner_logo',
                    'title' => 'Logo',
                    'type'  => 'image',
                    'width' => '100',
                    'height' => '30'
                ),
            ),
            'extra' => array(
                array(
                    'name'   => 'display_top_line',
                    'title'   => esc_html__( 'Display top line', 'g5plus-handmade' ),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    //'multiple' => '1',
                    'options' => array(
                        ''  => esc_html__( 'No', 'g5plus-handmade' ),
                        'border-top-gray' => esc_html__( 'Yes', 'g5plus-handmade' )
                    )
                ),
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $widget_id = $args['widget_id'];
        $partners = array_key_exists('fields',$instance) ? $instance['fields'] : array() ;
        $display_top_line ='';
        $extra =  array_key_exists('extra',$instance) ? $instance['extra'] : '' ;
        if(isset($extra) && is_array($extra)){
            $display_top_line = $extra['display_top_line'];
        }
        $data_plugin_options = $owl_carousel_class = '';
        $data_plugin_options = 'data-plugin-options=\'{ "items" : 5,"pagination": false, "navigation": false, "autoPlay": true}\'';
        $owl_carousel_class = 'owl-carousel';
        echo wp_kses_post($before_widget);
        ?>
        <div class="container">
            <div class="partner-wrap col-md-12  <?php echo sprintf('%s %s',$owl_carousel_class, $display_top_line) ?>" <?php echo wp_kses_post($data_plugin_options) ?> >
                <?php if(isset($partners) && is_array($partners)){
                    foreach($partners as $partner ){ ?>
                        <div class="partner content-middle-inner">
                            <a href="<?php echo esc_attr($partner['partner_link']) ?>" title="<?php echo esc_attr($partner['partner_name']) ?>">
                                <img src="<?php echo esc_url($partner['partner_logo']['url'])?>" alt="<?php echo esc_attr($partner['partner_name']) ?>" />
                            </a>
                        </div>
                    <?php
                    }
                } ?>
            </div>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }
}
if (!function_exists('g5plus_register_widget_partner_carousel')) {
    function g5plus_register_widget_partner_carousel() {
        register_widget('G5Plus_Widget_Partner_Carousel');
    }
    add_action('widgets_init', 'g5plus_register_widget_partner_carousel', 1);
}