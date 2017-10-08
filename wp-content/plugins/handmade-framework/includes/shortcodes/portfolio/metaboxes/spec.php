<?php
/**
 * Add the question & answer meta box
 * @var [type]
 */
$class_metabox_qa = new WPAlchemy_MetaBox(array
(
    'id' => 'portfolio_custom_fields',
    'title' => esc_html__('Custom Field', 'g5plus-handmade'),
    'template' => plugin_dir_path( __FILE__ ) . 'custom-field.php',
    'types' => array(G5PLUS_PORTFOLIO_POST_TYPE),
    'autosave' => TRUE,
    'priority' => 'high',
    'context' => 'normal',
    'hide_editor' => FALSE
));


