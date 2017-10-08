<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/17/2015
 * Time: 5:29 PM
 */
class G5Plus_Widget_Posts_Advanced extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-posts-advanced';
        $this->widget_description = esc_html__( "Posts advanced widget", 'g5plus-handmade' );
        $this->widget_id          = 'g5plus-posts-advanced';
        $this->widget_name        = esc_html__( 'G5Plus: Posts Advanced', 'g5plus-handmade' );
        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title','g5plus-handmade')
            ),
            'source'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Source', 'g5plus-handmade' ),
                'options' => array(
                    'random' => esc_html__('Random','g5plus-handmade'),
                    'popular' => esc_html__('Popular','g5plus-handmade'),
                    'recent'  => esc_html__( 'Recent', 'g5plus-handmade' ),
                    'oldest' => esc_html__('Oldest','g5plus-handmade')
                )
            ),
            'number' => array(
                'type'  => 'number',
                'std'   => '5',
                'label' => esc_html__( 'Number of posts to show', 'g5plus-handmade' ),
            ),
            'col' => array(
	            'type'  => 'number',
	            'std'   => '5',
	            'label' => esc_html__( 'Number of items per row', 'g5plus-handmade' ),
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        if ( $this->get_cached_widget( $args ) )
            return;

        extract( $args, EXTR_SKIP );
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $source        = empty( $instance['source'] ) ? '' : $instance['source'];
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
	    $col = ( ! empty( $instance['col'] ) ) ? absint( $instance['col'] ) : 5;
        if ( ! $number )
            $number = 5;
        $query_args = array();

        switch ($source) {
            case 'random' :
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'rand',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'popular':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'comment_count',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;

            case 'recent':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'oldest':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'ASC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
        }

        $class = array('widget-posts-wrap');
        ob_start();
        $r = new WP_Query( $query_args);
        if ($r->have_posts()) : ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ( $title ) {
		        echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']);
	        } ?>
            <div class="<?php echo join(' ',$class); ?>">
	            <div class="row owl-carousel" data-plugin-options='{"items":<?php echo esc_attr($col); ?>}'>
		            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
			            <div class="widget_posts_item clearfix col-md-12">
				            <?php
				            $thumbnail = g5plus_post_thumbnail('medium');
				            if (!empty($thumbnail)) : ?>
					            <div class="widget-posts-thumbnail">
						            <?php echo wp_kses_post($thumbnail); ?>
					            </div>
				            <?php endif; ?>
				            <div class="widget-posts-content-wrap">
					            <a class="widget-posts-title" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					            <div class="widget-posts-date">
						            <?php echo get_the_date('M j Y'); ?> | <?php esc_html_e('By','g5plus-handmade') ?> <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
					            </div>
				            </div>

			            </div>
		            <?php endwhile; ?>
	            </div>
            </div>
            <?php echo wp_kses_post($args['after_widget']); ?>
        <?php endif;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }
}

if (!function_exists('g5plus_register_widget_posts_advanced')) {
    function g5plus_register_widget_posts_advanced() {
        register_widget('G5Plus_Widget_Posts_Advanced');
    }
    add_action('widgets_init', 'g5plus_register_widget_posts_advanced', 1);
}