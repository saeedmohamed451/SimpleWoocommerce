<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 7/13/15
 * Time: 11:14 AM
 */

do_action('g5plus_before_page');
$terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY));
$cat = $cat_filter = '';
foreach ($terms as $term) {
    $cat_filter .= preg_replace('/\s+/', '', $term->name) . ' ';
    $cat .=  '<span><a href="'.get_category_link($term->term_id).'">'.$term->name . '</a></span>';
}
?>
<div class="portfolio-full detail-02" id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="post-slideshow">
                    <?php if(count($meta_values) > 0){
                        foreach($meta_values as $image){
                            $urls = wp_get_attachment_image_src($image,'full');
                            $img = '';
                            if(count($urls)>0){
                                $resize = matthewruddy_image_resize($urls[0],570,460);
                                if($resize!=null && is_array($resize) && array_key_exists('url',$resize) )
                                    $img = $resize['url'];
                            }
                            ?>
                            <div class="item"><img alt="portfolio" src="<?php echo esc_url($img) ?>" /></div>
                        <?php }
                    }else { if(count($imgThumbs)>0) {?>
                        <div class="item"><img alt="portfolio" src="<?php echo esc_url($imgThumbs[0])?>" /></div>
                    <?php }
                    }
                    ?>
                </div>

            </div>
            <div class="col-md-6">
                <div class="portfolio-info">
                    <h2 class="portfolio-title p-font"><?php the_title() ?></h2>
                    <div class="category line-height-1">
                        <?php echo wp_kses_post($cat) ?>
                    </div>
                    <?php the_content(); ?>
                </div>
                <div class="portfolio-info extra-field">
                    <?php
                    $meta = get_post_meta(get_the_ID(), 'portfolio_custom_fields', TRUE);
                    if(isset($meta) && is_array($meta) && count($meta['portfolio_custom_fields'])>0){
                        for($i=0; $i<count($meta['portfolio_custom_fields']);$i++){
                            ?>
                            <div class="portfolio-info-box">
                                <h6 class="p-color p-font"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-title']) ?>:</h6>
                                <div class="portfolio-term line-height-1"><?php echo wp_kses_post($meta['portfolio_custom_fields'][$i]['custom-field-description']) ?></div>
                            </div>
                        <?php }
                    }
                    ?>

                    <div class="portfolio-info-box">
                        <h6 class="p-color p-font"><?php echo esc_html__('Date','g5plus-handmade') ?>: </h6>
                        <div class="portfolio-term "><?php echo date(get_option('date_format'),strtotime($post->post_date)) ?></div>
                    </div>
                    <div class="portfolio-info-box">
                        <?php if($client!=''){ ?>
                            <h6 class="p-color p-font"><?php echo esc_html__('Client','g5plus-handmade') ?>: </h6>
                            <div class="portfolio-term"><?php echo esc_html($client); ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div class="share">
                    <h6 class="p-color p-font"><?php echo esc_html__('Share','g5plus-handmade') ?>:</h6>
                    <ul>
                        <li><a href="javascript:;" data-href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink($post_id);?>"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="javascript:;" data-href="https://twitter.com/home?status=<?php echo get_permalink($post_id);?>" ><i class="fa fa-twitter"></i></a></li>
                        <li><a href="javascript:;" data-href="https://plus.google.com/share?url=<?php echo get_permalink($post_id);?>"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>


            </div>
        </div>
    </div>

</div>