<div class="portfolio-item <?php echo esc_attr($cat_filter) ?> hover-dir">

    <?php
    $post_thumbnail_id = get_post_thumbnail_id(  get_the_ID() );
    $arrImages = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
    $width = 585;
    $height = 585;
    if($image_size=='590x393')
    {
        $width = 590;
        $height = 393;
    }
    if($image_size=='570x460')
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
    $cat = '';
    foreach ( $terms as $term ){
        $cat .= $term->name.', ';
    }
    $cat = rtrim($cat,', ');
    ?>

    <div class="entry-thumbnail title">
        <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
        <div class="entry-thumbnail-hover p-bg-rgba-color">
            <div class="entry-hover-wrapper">
                <div class="entry-hover-inner">
                    <a href="<?php echo esc_url($url_origin) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                        <i class="fa fa-search  fc-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="entry-title-wrapper line-height-1">
        <div class="entry-title-inner">
            <?php if (isset($disable_link_detail) && $disable_link_detail=='yes'){?>
                <div class="title"><?php the_title() ?></div>
            <?php } else{?>
                <a href="<?php echo get_permalink(get_the_ID()) ?>" class="bold-color"><div class="title"><?php the_title() ?></div> </a>
            <?php }?>
            <span class="category p-color display-inline-block"><?php echo wp_kses_post($cat) ?></span>
        </div>
    </div>

    <?php

    include(plugin_dir_path(__FILE__) . '/gallery.php');
    ?>

</div>
