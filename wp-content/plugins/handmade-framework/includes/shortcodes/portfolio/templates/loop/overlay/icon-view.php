<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/20/15
 * Time: 11:01 AM
 */

global $g5plus_options;
$disable_link = false;
if(isset($g5plus_options['portfolio_disable_link_detail']) && $g5plus_options['portfolio_disable_link_detail']=='1' )
{
    $disable_link = true;
}

?>
<div class="entry-thumbnail title">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover p-bg-rgba-color">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <a href="<?php echo esc_url($url_origin) ?>" data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"  title="<?php echo get_the_title() ?>">
                    <i class="wicon icon-outline-vector-icons-pack-94 icon-fs-34 fc-white link-color-hover"></i>
                </a>
                <?php if ($disable_link){?>
                    <h5><?php the_title() ?></h5>
                <?php } else{?>
                    <a href="<?php echo get_permalink(get_the_ID()) ?>"><h5><?php the_title() ?></h5> </a>
                <?php }?>
            </div>
        </div>
    </div>
</div>