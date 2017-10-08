<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/20/15
 * Time: 11:01 AM
 */
$cat = '';
foreach ( $terms as $term ){
    $cat .= $term->name.', ';
}
$cat = rtrim($cat,', ');

global $g5plus_options;
$disable_link = false;
if(isset($g5plus_options['portfolio_disable_link_detail']) && $g5plus_options['portfolio_disable_link_detail']=='1' )
{
    $disable_link = true;
}
?>
<div class="entry-thumbnail title-category">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover p-bg-rgba-color">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <span class="icon-logo">
                    <a href="<?php echo esc_url($url_origin) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                        <i class="fa fa-search  fc-white"></i>
                    </a>
                </span>
                <?php if ($disable_link){?>
                    <div class="title fc-white"><?php the_title() ?></div>
                <?php } else{?>
                    <a href="<?php echo get_permalink(get_the_ID()) ?>" class="line-height-1"><div class="title fc-white"><?php the_title() ?></div> </a>
                <?php }?>

                <span class="category line-height-1"><?php echo wp_kses_post($cat) ?></span>
            </div>
        </div>
    </div>

</div>