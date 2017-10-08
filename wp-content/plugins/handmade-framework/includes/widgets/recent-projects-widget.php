<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5Plus_Widget_Recent_Portfolio extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-recent-portfolio';
        $this->widget_description = esc_html__( "Recent Portfolio", 'g5plus-handmade' );
        $this->widget_id          = 'wolverine-recent-portfolio';
        $this->widget_name        = esc_html__( 'G5Plus: Recent Projects', 'g5plus-handmade' );
        $this->settings           = array(
            'title' => array(
                'type'  => 'text',
                'std'   => 'Recent Projects',
                'label' => esc_html__( 'Enter title ', 'g5plus-handmade' ),
            ),
            'column' => array(
                'type'  => 'text',
                'std'   => '4',
                'label' => esc_html__( 'Enter column ', 'g5plus-handmade' ),
            ),
            'row' => array(
                'type'  => 'text',
                'std'   => '2',
                'label' => esc_html__( 'Enter row ', 'g5plus-handmade' ),
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title  = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $column  = empty( $instance['column'] ) ? '' : apply_filters( 'widget_column', $instance['column'] );
        $row  = empty( $instance['row'] ) ? '' : apply_filters( 'row', $instance['row'] );
        $widget_id = $args['widget_id'];

	    $class_names = array();
	    $class_names[] = 'columns-' . $column;

        echo wp_kses_post($before_widget);

        if(class_exists('G5PlusFramework_Portfolio'))
        {
            $post_per_page = $column * $row;
	        $query_args = array(
                'posts_per_page'   => $post_per_page,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'portfolio',
                'post_status'      => 'publish');

            $posts_array  = new WP_Query( $query_args );
        ?>
	        <?php if ( $title ) {
	        echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']);
        } ?>
	        <ul class="<?php echo join(' ',$class_names); ?>">
            <?php
                while ( $posts_array->have_posts() ) : $posts_array->the_post();
                    $permalink = get_permalink();
                    $title_post = get_the_title();
                    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
                    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
                    $thumbnail_url = '';
                    if(count($arrImages)>0){
                        $resize = matthewruddy_image_resize($arrImages[0],270,270);
                        if($resize!=null && is_array($resize) )
                            $thumbnail_url = $resize['url'];
                    }

            ?>
                <li>
                    <a href="<?php echo esc_url($permalink) ?>">
                        <img src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo esc_attr($title_post) ?>">
                    </a>
                </li>
            <?php
                endwhile;
                wp_reset_postdata(); ?>
            </ul>
        <?php
        }
        echo wp_kses_post($after_widget);
    }
}
if (!function_exists('g5plus_register_widget_recent_portfolio')) {
    function g5plus_register_widget_recent_portfolio() {
        register_widget('G5Plus_Widget_Recent_Portfolio');
    }
    add_action('widgets_init', 'g5plus_register_widget_recent_portfolio', 1);
}