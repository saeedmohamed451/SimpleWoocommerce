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
<div class="entry-thumbnail title-only">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover p-bg-rgba-color">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <?php if ($disable_link){?>
                    <div class="title fc-white"><?php the_title() ?></div>
                <?php } else{?>
                    <a href="<?php echo get_permalink(get_the_ID()) ?>" class="line-height-1"><div class="title"><?php the_title() ?></div> </a>
                <?php }?>
            </div>
        </div>
    </div>

</div>