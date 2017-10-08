<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5plus_Social_Profile extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description = esc_html__( "Social profile widget", 'g5plus-handmade' );
        $this->widget_id          = 'g5plus-social-profile';
        $this->widget_name        = esc_html__( 'G5Plus: Social Profile', 'g5plus-handmade' );
        $this->settings           = array(
            'label' => array(
		        'type' => 'text',
		        'std' => '',
		        'label' => esc_html__('Label','g5plus-handmade')
            ),
	        'type'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Type', 'g5plus-handmade' ),
                'options' => array(
                    'social-icon-no-border' => esc_html__( 'No Border', 'g5plus-handmade' ),
                    'social-icon-bordered'  => esc_html__( 'Bordered', 'g5plus-handmade' )
                )
            ),
            'icons' => array(
                'type'  => 'multi-select',
                'label'   => esc_html__( 'Select social profiles', 'g5plus-handmade' ),
                'std'   => '',
	            'options' => array(
		            'twitter'  => esc_html__( 'Twitter', 'g5plus-handmade' ),
		            'facebook'  => esc_html__( 'Facebook', 'g5plus-handmade' ),
		            'dribbble'  => esc_html__( 'Dribbble', 'g5plus-handmade' ),
		            'vimeo'  => esc_html__( 'Vimeo', 'g5plus-handmade' ),
		            'tumblr'  => esc_html__( 'Tumblr', 'g5plus-handmade' ),
		            'skype'  => esc_html__( 'Skype', 'g5plus-handmade' ),
		            'linkedin'  => esc_html__( 'LinkedIn', 'g5plus-handmade' ),
		            'googleplus'  => esc_html__( 'Google+', 'g5plus-handmade' ),
		            'flickr'  => esc_html__( 'Flickr', 'g5plus-handmade' ),
		            'youtube'  => esc_html__( 'YouTube', 'g5plus-handmade' ),
		            'pinterest' => esc_html__( 'Pinterest', 'g5plus-handmade' ),
		            'foursquare'  => esc_html__( 'Foursquare', 'g5plus-handmade' ),
		            'instagram' => esc_html__( 'Instagram', 'g5plus-handmade' ),
		            'github'  => esc_html__( 'GitHub', 'g5plus-handmade' ),
		            'xing' => esc_html__( 'Xing', 'g5plus-handmade' ),
		            'behance'  => esc_html__( 'Behance', 'g5plus-handmade' ),
		            'deviantart'  => esc_html__( 'Deviantart', 'g5plus-handmade' ),
		            'soundcloud'  => esc_html__( 'SoundCloud', 'g5plus-handmade' ),
		            'yelp'  => esc_html__( 'Yelp', 'g5plus-handmade' ),
		            'rss'  => esc_html__( 'RSS Feed', 'g5plus-handmade' ),
		            'email'  => esc_html__( 'Email address', 'g5plus-handmade' ),
	            )
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
	    $label = empty( $instance['label'] ) ? '' : apply_filters( 'widget_label', $instance['label'] );
        $type         = empty( $instance['type'] ) ? '' : apply_filters( 'widget_type', $instance['type'] );
        $icons        = empty( $instance['icons'] ) ? '' : apply_filters( 'widget_icons', $instance['icons'] );
        $widget_id    = $args['widget_id'];
	    $social_icons = g5plus_get_social_icon($icons,'social-profile ' . $type );
	    echo wp_kses_post( $before_widget );
	    ?>
	    <?php if (!empty($label)) : ?>
		    <span><?php echo wp_kses_post($label); ?></span>
		 <?php endif; ?>
		    <?php echo wp_kses_post( $social_icons ); ?>
	    <?php
	    echo wp_kses_post( $after_widget );
    }
}
if (!function_exists('g5plus_register_social_profile')) {
    function g5plus_register_social_profile() {
        register_widget('G5plus_Social_Profile');
    }
    add_action('widgets_init', 'g5plus_register_social_profile', 1);
}