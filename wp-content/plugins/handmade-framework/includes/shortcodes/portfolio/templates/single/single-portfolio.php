<?php
get_header();
global $g5plus_options;
$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
wp_enqueue_style('handmade-portfolio-css', plugins_url() . '/handmade-framework/includes/shortcodes/portfolio/assets/css/portfolio'.$min_suffix.'.css', array(),false);
wp_enqueue_style('handmade-portfolio-single-css', plugins_url() . '/handmade-framework/includes/shortcodes/portfolio/assets/css/portfolio-single.css', array(),false);
wp_enqueue_script('handmade-modernizr', plugins_url() . '/handmade-framework/includes/shortcodes/portfolio/assets/js/hoverdir/modernizr.js', false, true);
wp_enqueue_script('handmade-hoverdir', plugins_url() . '/handmade-framework/includes/shortcodes/portfolio/assets/js/hoverdir/jquery.hoverdir.js', false, true);

if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        $post_id = get_the_ID();
        $categories = get_the_terms($post_id, G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY);
        $client = get_post_meta($post_id, 'portfolio-client', true );
        $location = get_post_meta($post_id, 'portfolio-location', true );

        $meta_values = get_post_meta( get_the_ID(), 'portfolio-format-gallery', false );
        $imgThumbs = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $cat = '';
        $arrCatId = array();
        if($categories){
            foreach($categories as $category) {
                $cat .= '<span>'.$category->name.'</span>, ';
                $arrCatId[count($arrCatId)] = $category->term_id;
            }
            $cat = trim($cat, ', ');
        }

        $detail_style =  get_post_meta(get_the_ID(),'portfolio_detail_style',true);
        if (!isset($detail_style) || $detail_style == 'none' || $detail_style == '') {
            $detail_style = $g5plus_options['portfolio-single-style'];
        }

        include_once(plugin_dir_path( __FILE__ ).'/'.$detail_style.'.php');

    endwhile;
    }
?>

<?php

if(isset($g5plus_options['show_portfolio_related']) && $g5plus_options['show_portfolio_related']=='1' )
    include_once(plugin_dir_path( __FILE__ ).'/related.php');

?>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function(){

            $('a','.portfolio-full .share').each(function(){
                $(this).click(function(){
                    var href = $(this).attr('data-href');
                    var leftPosition, topPosition;
                    var width = 400;
                    var height = 300;
                    var leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
                    var topPosition = (window.screen.height / 2) - ((height / 2) + 50);
                    //Open the window.
                    window.open(href, "", "width=300, height=200,left=" + leftPosition + ",top=" + topPosition);
                })
            })

            $("a[rel^='prettyPhoto']").prettyPhoto(
                {
                    theme: 'light_rounded',
                    slideshow: 5000,
                    deeplinking: false,
                    social_tools: false
                });
            $('.portfolio-item.hover-dir > div.entry-thumbnail').hoverdir();
        })
    })(jQuery);
</script>

<?php get_footer(); ?>
