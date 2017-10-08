<?php
$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
$arrImages = wp_get_attachment_image_src($post_thumbnail_id, 'full');
$width = 370;
$height = 494;
$overlay_height = 'height-50';

$matrix = array(
  array(2,1,2),
  array(2,2,2),
  array(2,1,1)
);

$index_row = floor(($index-1) / $column)%3;
$index_col = ($index-1) % $column;
if($matrix[$index_row][$index_col]==1){
    $width = 370;
    $height = 260;
    $overlay_height = '';
}

?>

<div class="portfolio-item hover-dir <?php echo sprintf('%s %s %s',$cat_filter,$overlay_align, $overlay_height) ?>">

    <?php
    $thumbnail_url = '';
    if (count($arrImages) > 0) {
        $resize = matthewruddy_image_resize($arrImages[0], $width, $height);
        if ($resize != null && is_array($resize))
            $thumbnail_url = $resize['url'];
    }

    $url_origin = $arrImages[0];
    if ($overlay_style == 'left-title-excerpt-link')
        $overlay_style = 'title-excerpt-link';
    include(plugin_dir_path(__FILE__) . '/overlay/' . $overlay_style . '.php');
    ?>

    <?php
    include(plugin_dir_path(__FILE__) . '/gallery.php');
    ?>

</div>
