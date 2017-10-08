<?php

do_action('g5plus_before_page');

$data_section_id = uniqid();
$cat = $cat_filter = '';
$terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
foreach ($terms as $term) {
    $cat_filter .= preg_replace('/\s+/', '', $term->name) . ' ';
    $cat .=  '<span><a href="'.get_category_link($term->term_id).'">'.$term->name . '</a></span> , ';
}
?>
<div class="portfolio-full detail-01" id="content">
    <div class="fullwidth">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="portfolio-title-wrap">
                        <h2 class="portfolio-title p-font"><?php the_title() ?></h2>
                    </div>
                    <div class="post-slideshow" id="post_slideshow_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],970,747);
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
        </div>
        <div class="paging-wrap">
            <div class="container">
                <div class="row">
                    <div class="slideshow-paging" data-current-index="0" data-total-items="<?php echo esc_attr(count($meta_values)) ?>" id="slideshow_paging_<?php echo esc_attr($data_section_id) ?>">
                        <?php if(count($meta_values) > 0){
                            $index = 0;
                            foreach($meta_values as $image){
                                $urls = wp_get_attachment_image_src($image,'full');
                                $img = '';
                                if(count($urls)>0){
                                    $resize = matthewruddy_image_resize($urls[0],170,129);
                                    if($resize!=null && is_array($resize) )
                                        $img = $resize['url'];
                                }
                                ?>
                                <div class="item">
                                    <a href="javascript:;" class="nav-slideshow" data-section-id="<?php echo esc_attr($data_section_id) ?>" data-index="<?php echo esc_attr($index++) ?>" >
                                        <img alt="portfolio" src="<?php echo esc_url($img) ?>" />
                                    </a>
                                </div>
                            <?php }
                        }else { if(count($imgThumbs)>0) {?>
                            <div class="item">
                                <img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" />
                            </div>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="container">
            <div class="row portfolio-content-wrap">
                <div class="col-md-12">
                    <div class="portfolio-info">
                        <h5 class="clear-top title s-font line-height-1"><?php echo esc_html__('About Project','g5plus-handmade') ?></h5>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="portfolio-info">
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
                            <h6 class="p-color p-font"><?php echo esc_html__('Category','g5plus-handmade') ?>: </h6>
                            <div class="portfolio-term line-height-1"><?php echo rtrim($cat,','); ?></div>
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
                pagination: false,
                afterInit:function(){
                    $(".post-slideshow",'#content').css('opacity','1');
                },
                afterMove:function(){
                    var index = this.owl.currentItem;
                    moveNavSlide(index);
                }
            });

            $(".slideshow-paging",'#content').owlCarousel({
                items: 6,
                itemsDesktop : [1024,5],
                itemsDesktopSmall : [767,3],
                itemsTablet: [600,3],
                itemsMobile: false,
                singleItem: false,
                navigation : false,
                pagination: false,
                afterInit:function(){
                    $(".slideshow-paging",'#content').css('opacity','1');

                    $('a.nav-slideshow', '#content .slideshow-paging').click(function(){
                        var index = $(this).attr('data-index');
                        var currentIndex = $(".slideshow-paging",'#content').attr('data-current-index');
                        var totalItems = $(".slideshow-paging",'#content').attr('data-total-items');

                        index = parseInt(index);
                        movePostSlide(index);

                        var owl_nav = $(".slideshow-paging",'#content').data('owlCarousel');
                        if(index <= currentIndex){
                            owl_nav.goTo(index-1);
                        }

                    })
                }
            });
            function moveNavSlide(index){
                var owl_nav = $(".slideshow-paging",'#content').data('owlCarousel');
                owl_nav.goTo(index);
                $(".slideshow-paging",'#content').attr('data-current-index', index);

            }
            function movePostSlide(index){
                if(index!='undefined'){
                    var owl_post = $(".post-slideshow",'#content').data('owlCarousel');
                    owl_post.goTo(index);
                    $(".slideshow-paging",'#content').attr('data-current-index', index);
                }
            }
        })


    })(jQuery);
</script>

