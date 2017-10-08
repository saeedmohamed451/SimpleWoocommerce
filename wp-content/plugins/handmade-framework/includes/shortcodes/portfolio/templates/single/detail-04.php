<?php

do_action('g5plus_before_page');

$data_section_id = uniqid();

$terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
$cat = $cat_filter = '';
foreach ($terms as $term) {
    $cat_filter .= preg_replace('/\s+/', '', $term->name) . ' ';
    $cat .=  '<span><a href="'.get_category_link($term->term_id).'">'.$term->name . '</a></span>';
}

?>
<div class="portfolio-full detail-04" id="content">
    <div class="fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="post-slideshow" id="post_slideshow_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],1170,900);
                                    if($resize!=null && is_array($resize) )
                                        $img = $resize['url'];
                                }

                                ?>
                                <div class="item">
                                    <a class="nav-post-slideshow" href="javascript:;" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>">
                                        <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                    </a>
                                </div>
                            <?php }
                        }else { if(count($imgThumbs)>0) {?>
                            <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" /></div>
                        <?php }
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div class="row portfolio-content-wrap">
                <div class="col-md-9">
                    <div class="portfolio-info">
                        <h2 class="portfolio-title bold-color line-height-1 p-font"><?php the_title() ?></h2>
                        <div class="category line-height-1">
                            <?php echo wp_kses_post($cat) ?>
                        </div>
                        <?php the_content() ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="portfolio-info spec">
                        <?php
                        $meta = get_post_meta(get_the_ID(), 'portfolio_custom_fields', TRUE);
                        if(isset($meta) && is_array($meta) && count($meta['portfolio_custom_fields'])>0){
                            for($i=0; $i<count($meta['portfolio_custom_fields']);$i++){
                                ?>
                                <div class="portfolio-info-box">
                                    <h6 class="p-color p-font"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-title']) ?>: </h6>
                                    <div class="portfolio-term line-height-1"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-description']) ?></div>
                                </div>
                            <?php }
                        }
                        ?>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__('Date','g5plus-handmade') ?>: </h6>
                            <div class="portfolio-term line-height-1"><?php echo date(get_option('date_format'),strtotime($post->post_date)) ?></div>
                        </div>
                        <div class="portfolio-info-box">
                            <h6 class="p-color p-font"><?php echo esc_html__('Client','g5plus-handmade') ?>: </h6>
                            <div class="portfolio-term line-height-1"><?php echo esc_html($client) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(window).load(function(){
            $(".post-slideshow",'#content').owlCarousel({
                items: 1,
                singleItem: true,
                navigation : true,
                slideSpeed: 600,
                navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                pagination: false
            });
        })
    })(jQuery);
</script>

