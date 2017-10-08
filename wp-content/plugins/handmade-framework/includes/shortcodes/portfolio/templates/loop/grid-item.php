<div class="portfolio-item hover-dir <?php echo esc_attr($cat_filter . ' ' . $overlay_align) ?>">

    <?php
    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $width = 585;
    $height = 585;
    if(isset($image_size) && $image_size=='590x393')
    {
        $width = 590;
        $height = 393;
    }
    if(isset($image_size) &&  $image_size=='570x460')
    {
        $width = 570;
        $height = 460;
    }
    $thumbnail_url = '';
    if(count($arrImages)>0){
        $resize = matthewruddy_image_resize($arrImages[0],$width,$height);
        if($resize!=null && is_array($resize) )
            $thumbnail_url = $resize['url'];
    }

    $url_origin = $arrImages[0];
    if($overlay_style=='left-title-excerpt-link')
        $overlay_style = 'title-excerpt-link';
    include(plugin_dir_path( __FILE__ ).'/overlay/'.$overlay_style.'.php');
    ?>

    <?php
        include(plugin_dir_path(__FILE__) . '/gallery.php');
    ?>

</div>
