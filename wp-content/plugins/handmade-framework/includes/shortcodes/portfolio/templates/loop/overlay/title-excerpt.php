<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 7/6/15
 * Time: 6:13 PM
 */

global $g5plus_options;
$disable_link = false;
if(isset($g5plus_options['portfolio_disable_link_detail']) && $g5plus_options['portfolio_disable_link_detail']=='1' )
{
    $disable_link = true;
}
?>
<div class="entry-thumbnail title-excerpt">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>"
         src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner line-height-1 p-bg-rgba-color">
                <?php if ($disable_link){?>
                    <h5 class="fc-white p-font"><?php the_title() ?></h5>
                <?php } else{?>
                    <a href="<?php echo get_permalink(get_the_ID()) ?>" class="title"><h5 class="fc-white p-font"><?php the_title() ?></h5></a>
                <?php }?>
                <div class="excerpt-wrap">
                    <span class="excerpt">
                        <?php echo get_the_excerpt() ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>