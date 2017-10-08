<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:44 PM
 */
if (!class_exists('g5plusFramework_Shortcodes')) {
    class g5plusFramework_Shortcodes
    {

        private static $instance;

        public static function init()
        {
            if (!isset(self::$instance)) {
                self::$instance = new g5plusFramework_Shortcodes;
                add_action('init', array(self::$instance, 'includes'), 0);
                add_action('init', array(self::$instance, 'register_vc_map'), 10);
            }
            return self::$instance;
        }

        public function includes()
        {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            if (!is_plugin_active('js_composer/js_composer.php')) {
                return;
            }
            global $g5plus_options;
            $cpt_disable = isset($g5plus_options['cpt-disable']) ? $g5plus_options['cpt-disable'] : null;
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/slider-container/slider-container.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/heading/heading.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/button/button.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/titles/titles.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/icon-box/icon-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/partner-carousel/partner-carousel.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/image-slider/image-slider.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/post/post.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/call-action/call-action.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/counter/counter.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/testimonial/testimonial.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/banner/banner.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/cover-box/cover-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/social-icon/social-icon.php');
	        include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/google-map/google-map.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/view-demo/view-demo.php');

            if (!isset($cpt_disable) || (array_key_exists('ourteam', $cpt_disable) && ($cpt_disable['ourteam'] == '0' || $cpt_disable['ourteam'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/ourteam/ourteam.php');
            }
            if (!isset($cpt_disable) || (array_key_exists('portfolio', $cpt_disable) && ($cpt_disable['portfolio'] == '0' || $cpt_disable['portfolio'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/portfolio/portfolio.php');
            }

            if (!isset($cpt_disable) || (array_key_exists('countdown', $cpt_disable) && ($cpt_disable['countdown'] == '0' || $cpt_disable['countdown'] == ''))) {
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/countdown/countdown.php');
            }

            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-creative.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-categories.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product-categories-home/product-categories-home.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-sidebar.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product-reviews.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/blog/blog.php');
        }

        public static function g5plus_get_css_animation($css_animation)
        {
            $output = '';
            if ($css_animation != '') {
                wp_enqueue_script('waypoints');
                $output = ' wpb_animate_when_almost_visible g5plus-css-animation ' . $css_animation;
            }
            return $output;
        }

        public static function g5plus_get_style_animation($duration, $delay)
        {
            $styles = array();
            if ($duration != '0' && !empty($duration)) {
                $duration = (float)trim($duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$duration}s";
                $styles[] = "-moz-animation-duration: {$duration}s";
                $styles[] = "-ms-animation-duration: {$duration}s";
                $styles[] = "-o-animation-duration: {$duration}s";
                $styles[] = "animation-duration: {$duration}s";
            }
            if ($delay != '0' && !empty($delay)) {
                $delay = (float)trim($delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$delay}s";
                $styles[] = "-moz-animation-delay: {$delay}s";
                $styles[] = "-ms-animation-delay: {$delay}s";
                $styles[] = "-o-animation-delay: {$delay}s";
                $styles[] = "animation-delay: {$delay}s";
            }
            if (count($styles) > 1) {
                return 'style="' . implode(';', $styles) . '"';
            }
            return implode(';', $styles);
        }

        public static function  substr($str, $txt_len, $end_txt = '...')
        {
            if (empty($str)) return '';
            if (strlen($str) <= $txt_len) return $str;

            $i = $txt_len;
            while ($str[$i] != ' ') {
                $i--;
                if ($i == -1) break;
            }
            while ($str[$i] == ' ') {
                $i--;
                if ($i == -1) break;
            }

            return substr($str, 0, $i + 1) . $end_txt;
        }


        public function register_vc_map()
        {

            global $g5plus_options;
            $cpt_disable = isset($g5plus_options['cpt-disable']) ? $g5plus_options['cpt-disable'] : null;

            if (function_exists('vc_map')) {
                $add_css_animation = array(
                    'type' => 'dropdown',
                    'heading' => __('CSS Animation', 'g5plus-handmade'),
                    'param_name' => 'css_animation',
                    'value' => array(__('No', 'g5plus-handmade') => '', __('Fade In', 'g5plus-handmade') => 'wpb_fadeIn', __('Fade Top to Bottom', 'g5plus-handmade') => 'wpb_fadeInDown', __('Fade Bottom to Top', 'g5plus-handmade') => 'wpb_fadeInUp', __('Fade Left to Right', 'g5plus-handmade') => 'wpb_fadeInLeft', __('Fade Right to Left', 'g5plus-handmade') => 'wpb_fadeInRight', __('Bounce In', 'g5plus-handmade') => 'wpb_bounceIn', __('Bounce Top to Bottom', 'g5plus-handmade') => 'wpb_bounceInDown', __('Bounce Bottom to Top', 'g5plus-handmade') => 'wpb_bounceInUp', __('Bounce Left to Right', 'g5plus-handmade') => 'wpb_bounceInLeft', __('Bounce Right to Left', 'g5plus-handmade') => 'wpb_bounceInRight', __('Zoom In', 'g5plus-handmade') => 'wpb_zoomIn', __('Flip Vertical', 'g5plus-handmade') => 'wpb_flipInX', __('Flip Horizontal', 'g5plus-handmade') => 'wpb_flipInY', __('Bounce', 'g5plus-handmade') => 'wpb_bounce', __('Flash', 'g5plus-handmade') => 'wpb_flash', __('Shake', 'g5plus-handmade') => 'wpb_shake', __('Pulse', 'g5plus-handmade') => 'wpb_pulse', __('Swing', 'g5plus-handmade') => 'wpb_swing', __('Rubber band', 'g5plus-handmade') => 'wpb_rubberBand', __('Wobble', 'g5plus-handmade') => 'wpb_wobble', __('Tada', 'g5plus-handmade') => 'wpb_tada'),
                    'description' => __('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'g5plus-handmade'),
                    'group' => __('Animation Settings', 'g5plus-handmade')
                );

                $add_duration_animation = array(
                    'type' => 'textfield',
                    'heading' => __('Animation Duration', 'g5plus-handmade'),
                    'param_name' => 'duration',
                    'value' => '',
                    'description' => __('Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'g5plus-handmade'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => __('Animation Settings', 'g5plus-handmade')
                );

                $add_delay_animation = array(
                    'type' => 'textfield',
                    'heading' => __('Animation Delay', 'g5plus-handmade'),
                    'param_name' => 'delay',
                    'value' => '',
                    'description' => __('Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'g5plus-handmade'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => __('Animation Settings', 'g5plus-handmade')
                );

                $add_el_class = array(
                    'type' => 'textfield',
                    'heading' => __('Extra class name', 'g5plus-handmade'),
                    'param_name' => 'el_class',
                    'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'g5plus-handmade'),
                );
                $custom_colors = array(
                    __('Informational', 'g5plus-handmade') => 'info',
                    __('Warning', 'g5plus-handmade') => 'warning',
                    __('Success', 'g5plus-handmade') => 'success',
                    __('Error', 'g5plus-handmade') => "danger",
                    __('Informational Classic', 'g5plus-handmade') => 'alert-info',
                    __('Warning Classic', 'g5plus-handmade') => 'alert-warning',
                    __('Success Classic', 'g5plus-handmade') => 'alert-success',
                    __('Error Classic', 'g5plus-handmade') => "alert-danger",
                );
                $target_arr = array(
                    __('Same window', 'g5plus-handmade') => '_self',
                    __('New window', 'g5plus-handmade') => '_blank'
                );
                $pe_7_stroke_icons = array(
                    array('pe-7s-album' => 'pe-7s-album'),
                    array('pe-7s-arc' => 'pe-7s-arc'),
                    array('pe-7s-back-2' => 'pe-7s-back-2'),
                    array('pe-7s-bandaid' => 'pe-7s-bandaid'),
                    array('pe-7s-car' => 'pe-7s-car'),
                    array('pe-7s-diamond' => 'pe-7s-diamond'),
                    array('pe-7s-door-lock' => 'pe-7s-door-lock'),
                    array('pe-7s-eyedropper' => 'pe-7s-eyedropper'),
                    array('pe-7s-female' => 'pe-7s-female'),
                    array('pe-7s-gym' => 'pe-7s-gym'),
                    array('pe-7s-hammer' => 'pe-7s-hammer'),
                    array('pe-7s-headphones' => 'pe-7s-headphones'),
                    array('pe-7s-helm' => 'pe-7s-helm'),
                    array('pe-7s-hourglass' => 'pe-7s-hourglass'),
                    array('pe-7s-leaf' => 'pe-7s-leaf'),
                    array('pe-7s-magic-wand' => 'pe-7s-magic-wand'),
                    array('pe-7s-male' => 'pe-7s-male'),
                    array('pe-7s-map-2' => 'pe-7s-map-2'),
                    array('pe-7s-next-2' => 'pe-7s-next-2'),
                    array('pe-7s-paint-bucket' => 'pe-7s-paint-bucket'),
                    array('pe-7s-pendrive' => 'pe-7s-pendrive'),
                    array('pe-7s-photo' => 'pe-7s-photo'),
                    array('pe-7s-piggy' => 'pe-7s-piggy'),
                    array('pe-7s-plugin' => 'pe-7s-plugin'),
                    array('pe-7s-refresh-2' => 'pe-7s-refresh-2'),
                    array('pe-7s-rocket' => 'pe-7s-rocket'),
                    array('pe-7s-settings' => 'pe-7s-settings'),
                    array('pe-7s-shield' => 'pe-7s-shield'),
                    array('pe-7s-smile' => 'pe-7s-smile'),
                    array('pe-7s-usb' => 'pe-7s-usb'),
                    array('pe-7s-vector' => 'pe-7s-vector'),
                    array('pe-7s-wine' => 'pe-7s-wine'),
                    array('pe-7s-cloud-upload' => 'pe-7s-cloud-upload'),
                    array('pe-7s-cash' => 'pe-7s-cash'),
                    array('pe-7s-close' => 'pe-7s-close'),
                    array('pe-7s-bluetooth' => 'pe-7s-bluetooth'),
                    array('pe-7s-cloud-download' => 'pe-7s-cloud-download'),
                    array('pe-7s-way' => 'pe-7s-way'),
                    array('pe-7s-close-circle' => 'pe-7s-close-circle'),
                    array('pe-7s-id' => 'pe-7s-id'),
                    array('pe-7s-angle-up' => 'pe-7s-angle-up'),
                    array('pe-7s-wristwatch' => 'pe-7s-wristwatch'),
                    array('pe-7s-angle-up-circle' => 'pe-7s-angle-up-circle'),
                    array('pe-7s-world' => 'pe-7s-world'),
                    array('pe-7s-angle-right' => 'pe-7s-angle-right'),
                    array('pe-7s-volume' => 'pe-7s-volume'),
                    array('pe-7s-angle-right-circle' => 'pe-7s-angle-right-circle'),
                    array('pe-7s-users' => 'pe-7s-users'),
                    array('pe-7s-angle-left' => 'pe-7s-angle-left'),
                    array('pe-7s-user-female' => 'pe-7s-user-female'),
                    array('pe-7s-angle-left-circle' => 'pe-7s-angle-left-circle'),
                    array('pe-7s-up-arrow' => 'pe-7s-up-arrow'),
                    array('pe-7s-angle-down' => 'pe-7s-angle-down'),
                    array('pe-7s-switch' => 'pe-7s-switch'),
                    array('pe-7s-angle-down-circle' => 'pe-7s-angle-down-circle'),
                    array('pe-7s-scissors' => 'pe-7s-scissors'),
                    array('pe-7s-wallet' => 'pe-7s-wallet'),
                    array('pe-7s-safe' => 'pe-7s-safe'),
                    array('pe-7s-volume2' => 'pe-7s-volume2'),
                    array('pe-7s-volume1' => 'pe-7s-volume1'),
                    array('pe-7s-voicemail' => 'pe-7s-voicemail'),
                    array('pe-7s-video' => 'pe-7s-video'),
                    array('pe-7s-user' => 'pe-7s-user'),
                    array('pe-7s-upload' => 'pe-7s-upload'),
                    array('pe-7s-unlock' => 'pe-7s-unlock'),
                    array('pe-7s-umbrella' => 'pe-7s-umbrella'),
                    array('pe-7s-trash' => 'pe-7s-trash'),
                    array('pe-7s-tools' => 'pe-7s-tools'),
                    array('pe-7s-timer' => 'pe-7s-timer'),
                    array('pe-7s-ticket' => 'pe-7s-ticket'),
                    array('pe-7s-target' => 'pe-7s-target'),
                    array('pe-7s-sun' => 'pe-7s-sun'),
                    array('pe-7s-study' => 'pe-7s-study'),
                    array('pe-7s-stopwatch' => 'pe-7s-stopwatch'),
                    array('pe-7s-star' => 'pe-7s-star'),
                    array('pe-7s-speaker' => 'pe-7s-speaker'),
                    array('pe-7s-signal' => 'pe-7s-signal'),
                    array('pe-7s-shuffle' => 'pe-7s-shuffle'),
                    array('pe-7s-shopbag' => 'pe-7s-shopbag'),
                    array('pe-7s-share' => 'pe-7s-share'),
                    array('pe-7s-server' => 'pe-7s-server'),
                    array('pe-7s-search' => 'pe-7s-search'),
                    array('pe-7s-film' => 'pe-7s-film'),
                    array('pe-7s-science' => 'pe-7s-science'),
                    array('pe-7s-disk' => 'pe-7s-disk'),
                    array('pe-7s-ribbon' => 'pe-7s-ribbon'),
                    array('pe-7s-repeat' => 'pe-7s-repeat'),
                    array('pe-7s-refresh' => 'pe-7s-refresh'),
                    array('pe-7s-add-user' => 'pe-7s-add-user'),
                    array('pe-7s-refresh-cloud' => 'pe-7s-refresh-cloud'),
                    array('pe-7s-paperclip' => 'pe-7s-paperclip'),
                    array('pe-7s-radio' => 'pe-7s-radio'),
                    array('pe-7s-note2' => 'pe-7s-note2'),
                    array('pe-7s-print' => 'pe-7s-print'),
                    array('pe-7s-network' => 'pe-7s-network'),
                    array('pe-7s-prev' => 'pe-7s-prev'),
                    array('pe-7s-mute' => 'pe-7s-mute'),
                    array('pe-7s-power' => 'pe-7s-power'),
                    array('pe-7s-medal' => 'pe-7s-medal'),
                    array('pe-7s-portfolio' => 'pe-7s-portfolio'),
                    array('pe-7s-like2' => 'pe-7s-like2'),
                    array('pe-7s-plus' => 'pe-7s-plus'),
                    array('pe-7s-left-arrow' => 'pe-7s-left-arrow'),
                    array('pe-7s-play' => 'pe-7s-play'),
                    array('pe-7s-key' => 'pe-7s-key'),
                    array('pe-7s-plane' => 'pe-7s-plane'),
                    array('pe-7s-joy' => 'pe-7s-joy'),
                    array('pe-7s-photo-gallery' => 'pe-7s-photo-gallery'),
                    array('pe-7s-pin' => 'pe-7s-pin'),
                    array('pe-7s-phone' => 'pe-7s-phone'),
                    array('pe-7s-plug' => 'pe-7s-plug'),
                    array('pe-7s-pen' => 'pe-7s-pen'),
                    array('pe-7s-right-arrow' => 'pe-7s-right-arrow'),
                    array('pe-7s-paper-plane' => 'pe-7s-paper-plane'),
                    array('pe-7s-delete-user' => 'pe-7s-delete-user'),
                    array('pe-7s-paint' => 'pe-7s-paint'),
                    array('pe-7s-bottom-arrow' => 'pe-7s-bottom-arrow'),
                    array('pe-7s-notebook' => 'pe-7s-notebook'),
                    array('pe-7s-note' => 'pe-7s-note'),
                    array('pe-7s-next' => 'pe-7s-next'),
                    array('pe-7s-news-paper' => 'pe-7s-news-paper'),
                    array('pe-7s-musiclist' => 'pe-7s-musiclist'),
                    array('pe-7s-music' => 'pe-7s-music'),
                    array('pe-7s-mouse' => 'pe-7s-mouse'),
                    array('pe-7s-more' => 'pe-7s-more'),
                    array('pe-7s-moon' => 'pe-7s-moon'),
                    array('pe-7s-monitor' => 'pe-7s-monitor'),
                    array('pe-7s-micro' => 'pe-7s-micro'),
                    array('pe-7s-menu' => 'pe-7s-menu'),
                    array('pe-7s-map' => 'pe-7s-map'),
                    array('pe-7s-map-marker' => 'pe-7s-map-marker'),
                    array('pe-7s-mail' => 'pe-7s-mail'),
                    array('pe-7s-mail-open' => 'pe-7s-mail-open'),
                    array('pe-7s-mail-open-file' => 'pe-7s-mail-open-file'),
                    array('pe-7s-magnet' => 'pe-7s-magnet'),
                    array('pe-7s-loop' => 'pe-7s-loop'),
                    array('pe-7s-look' => 'pe-7s-look'),
                    array('pe-7s-lock' => 'pe-7s-lock'),
                    array('pe-7s-lintern' => 'pe-7s-lintern'),
                    array('pe-7s-link' => 'pe-7s-link'),
                    array('pe-7s-like' => 'pe-7s-like'),
                    array('pe-7s-light' => 'pe-7s-light'),
                    array('pe-7s-less' => 'pe-7s-less'),
                    array('pe-7s-keypad' => 'pe-7s-keypad'),
                    array('pe-7s-junk' => 'pe-7s-junk'),
                    array('pe-7s-info' => 'pe-7s-info'),
                    array('pe-7s-home' => 'pe-7s-home'),
                    array('pe-7s-help2' => 'pe-7s-help2'),
                    array('pe-7s-help1' => 'pe-7s-help1'),
                    array('pe-7s-graph3' => 'pe-7s-graph3'),
                    array('pe-7s-graph2' => 'pe-7s-graph2'),
                    array('pe-7s-graph1' => 'pe-7s-graph1'),
                    array('pe-7s-graph' => 'pe-7s-graph'),
                    array('pe-7s-global' => 'pe-7s-global'),
                    array('pe-7s-gleam' => 'pe-7s-gleam'),
                    array('pe-7s-glasses' => 'pe-7s-glasses'),
                    array('pe-7s-gift' => 'pe-7s-gift'),
                    array('pe-7s-folder' => 'pe-7s-folder'),
                    array('pe-7s-flag' => 'pe-7s-flag'),
                    array('pe-7s-filter' => 'pe-7s-filter'),
                    array('pe-7s-file' => 'pe-7s-file'),
                    array('pe-7s-expand1' => 'pe-7s-expand1'),
                    array('pe-7s-exapnd2' => 'pe-7s-exapnd2'),
                    array('pe-7s-edit' => 'pe-7s-edit'),
                    array('pe-7s-drop' => 'pe-7s-drop'),
                    array('pe-7s-drawer' => 'pe-7s-drawer'),
                    array('pe-7s-download' => 'pe-7s-download'),
                    array('pe-7s-display2' => 'pe-7s-display2'),
                    array('pe-7s-display1' => 'pe-7s-display1'),
                    array('pe-7s-diskette' => 'pe-7s-diskette'),
                    array('pe-7s-date' => 'pe-7s-date'),
                    array('pe-7s-cup' => 'pe-7s-cup'),
                    array('pe-7s-culture' => 'pe-7s-culture'),
                    array('pe-7s-crop' => 'pe-7s-crop'),
                    array('pe-7s-credit' => 'pe-7s-credit'),
                    array('pe-7s-copy-file' => 'pe-7s-copy-file'),
                    array('pe-7s-config' => 'pe-7s-config'),
                    array('pe-7s-compass' => 'pe-7s-compass'),
                    array('pe-7s-comment' => 'pe-7s-comment'),
                    array('pe-7s-coffee' => 'pe-7s-coffee'),
                    array('pe-7s-cloud' => 'pe-7s-cloud'),
                    array('pe-7s-clock' => 'pe-7s-clock'),
                    array('pe-7s-check' => 'pe-7s-check'),
                    array('pe-7s-chat' => 'pe-7s-chat'),
                    array('pe-7s-cart' => 'pe-7s-cart'),
                    array('pe-7s-camera' => 'pe-7s-camera'),
                    array('pe-7s-call' => 'pe-7s-call'),
                    array('pe-7s-calculator' => 'pe-7s-calculator'),
                    array('pe-7s-browser' => 'pe-7s-browser'),
                    array('pe-7s-box2' => 'pe-7s-box2'),
                    array('pe-7s-box1' => 'pe-7s-box1'),
                    array('pe-7s-bookmarks' => 'pe-7s-bookmarks'),
                    array('pe-7s-bicycle' => 'pe-7s-bicycle'),
                    array('pe-7s-bell' => 'pe-7s-bell'),
                    array('pe-7s-battery' => 'pe-7s-battery'),
                    array('pe-7s-ball' => 'pe-7s-ball'),
                    array('pe-7s-back' => 'pe-7s-back'),
                    array('pe-7s-attention' => 'pe-7s-attention'),
                    array('pe-7s-anchor' => 'pe-7s-anchor'),
                    array('pe-7s-albums' => 'pe-7s-albums'),
                    array('pe-7s-alarm' => 'pe-7s-alarm'),
                    array('pe-7s-airplay' => 'pe-7s-airplay'),
                );
                $pixel_icons = array(
                    array('vc_pixel_icon vc_pixel_icon-alert' => __('Alert', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-info' => __('Info', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-tick' => __('Tick', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-explanation' => __('Explanation', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-address_book' => __('Address book', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-alarm_clock' => __('Alarm clock', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-anchor' => __('Anchor', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-application_image' => __('Application Image', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-arrow' => __('Arrow', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-asterisk' => __('Asterisk', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-hammer' => __('Hammer', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-balloon' => __('Balloon', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-balloon_buzz' => __('Balloon Buzz', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-balloon_facebook' => __('Balloon Facebook', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-balloon_twitter' => __('Balloon Twitter', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-battery' => __('Battery', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-binocular' => __('Binocular', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_excel' => __('Document Excel', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_image' => __('Document Image', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_music' => __('Document Music', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_office' => __('Document Office', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_pdf' => __('Document PDF', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_powerpoint' => __('Document Powerpoint', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-document_word' => __('Document Word', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-bookmark' => __('Bookmark', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-camcorder' => __('Camcorder', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-camera' => __('Camera', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-chart' => __('Chart', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-chart_pie' => __('Chart pie', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-clock' => __('Clock', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-fire' => __('Fire', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-heart' => __('Heart', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-mail' => __('Mail', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-play' => __('Play', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-shield' => __('Shield', 'g5plus-handmade')),
                    array('vc_pixel_icon vc_pixel_icon-video' => __('Video', 'g5plus-handmade')),
                );
                $icon_type = array(
                    'type' => 'dropdown',
                    'heading' => __('Icon library', 'g5plus-handmade'),
                    'value' => array(
                        __('[None]', 'g5plus-handmade') => '',
                        __('Pe Icon 7 Stroke', 'g5plus-handmade') => 'pe_7_stroke',
                        __('Font Awesome', 'g5plus-handmade') => 'fontawesome',
                        __('Open Iconic', 'g5plus-handmade') => 'openiconic',
                        __('Typicons', 'g5plus-handmade') => 'typicons',
                        __('Entypo', 'g5plus-handmade') => 'entypo',
                        __('Linecons', 'g5plus-handmade') => 'linecons',
                        __('Image', 'g5plus-handmade') => 'image',
                    ),
                    'param_name' => 'icon_type',
                    'description' => __('Select icon library.', 'g5plus-handmade'),
                );
                $icon_font = array(
                    'type' => 'dropdown',
                    'heading' => __('Icon library', 'g5plus-handmade'),
                    'value' => array(
                        __('[None]', 'g5plus-handmade') => '',
                        __('Pe Icon 7 Stroke', 'g5plus-handmade') => 'pe_7_stroke',
                        __('Font Awesome', 'g5plus-handmade') => 'fontawesome',
                        __('Open Iconic', 'g5plus-handmade') => 'openiconic',
                        __('Typicons', 'g5plus-handmade') => 'typicons',
                        __('Entypo', 'g5plus-handmade') => 'entypo',
                        __('Linecons', 'g5plus-handmade') => 'linecons',
                    ),
                    'param_name' => 'icon_type',
                    'description' => __('Select icon library.', 'g5plus-handmade'),
                );
                $icon_fontawesome = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_fontawesome',
                    'value' => 'fa fa-adjust', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false,
                        // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                        // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'fontawesome',
                    ),
                    'description' => __('Select icon from library.', 'g5plus-handmade'),
                );
                $icon_pe_7_stroke = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_pe_7_stroke',
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                        'type' => 'pe_7_stroke',
                        'source' => $pe_7_stroke_icons,
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'pe_7_stroke',
                    ),
                    'description' => __('Select icon from library.', 'g5plus-handmade'),
                );
                $icon_openiconic = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_openiconic',
                    'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'openiconic',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'openiconic',
                    ),
                    'description' => __('Select icon from library.', 'g5plus-handmade'),
                );
                $icon_typicons = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_typicons',
                    'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'typicons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'typicons',
                    ),
                    'description' => __('Select icon from library.', 'g5plus-handmade'),
                );
                $icon_entypo = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_entypo',
                    'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'entypo',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'entypo',
                    ),
                );
                $icon_linecons = array(
                    'type' => 'iconpicker',
                    'heading' => __('Icon', 'g5plus-handmade'),
                    'param_name' => 'icon_linecons',
                    'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'linecons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'linecons',
                    ),
                    'description' => __('Select icon from library.', 'g5plus-handmade'),
                );
                $icon_image = array(
                    'type' => 'attach_image',
                    'heading' => __('Upload Image Icon:', 'g5plus-handmade'),
                    'param_name' => 'icon_image',
                    'value' => '',
                    'description' => __('Upload the custom image icon.', 'g5plus-handmade'),
                    'dependency' => Array('element' => 'icon_type', 'value' => array('image')),
                );
                vc_map(array(
                    'name' => __('Slider Container', 'g5plus-handmade'),
                    'base' => 'handmade_slider_container',
                    'class' => '',
                    'icon' => 'fa fa-ellipsis-h',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'handmade_slider_container'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Navigation', 'g5plus-handmade'),
                            'param_name' => 'navigation',
                            'description' => __('Show navigation.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Pagination', 'g5plus-handmade'),
                            'param_name' => 'pagination',
                            'description' => __('Show pagination.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Single Item', 'g5plus-handmade'),
                            'param_name' => 'singleitem',
                            'description' => __('Display only one item.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Stop On Hover', 'g5plus-handmade'),
                            'param_name' => 'stoponhover',
                            'description' => __('Stop autoplay on mouse hover.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Auto Play', 'g5plus-handmade'),
                            'param_name' => 'autoplay',
                            'description' => __('Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '5000'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items', 'g5plus-handmade'),
                            'param_name' => 'items',
                            'description' => __('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-handmade'),
                            'value' => '',
                            'std' => 4
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktop',
                            'description' => __('This allows you to preset the number of slides visible with a particular browser width. The format is [x,y] whereby x=browser width and y=number of slides displayed. For example [1199,4] means that if(window<=1199){ show 4 slides per page} Alternatively use itemsDesktop: false to override these settings.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1199,4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop Small', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktopsmall',
                            'value' => '',
                            'std' => '979,3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet', 'g5plus-handmade'),
                            'param_name' => 'itemstablet',
                            'value' => '',
                            'std' => '768,2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet Small', 'g5plus-handmade'),
                            'param_name' => 'itemstabletsmall',
                            'value' => '',
                            'std' => 'false'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Mobile', 'g5plus-handmade'),
                            'param_name' => 'itemsmobile',
                            'value' => '',
                            'std' => '479,1'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Items Scale Up', 'g5plus-handmade'),
                            'param_name' => 'itemsscaleup',
                            'description' => __('Option to not stretch items when it is less than the supplied items.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Auto Height', 'g5plus-handmade'),
                            'param_name' => 'autoheight',
                            'description' => __('You can use different heights on slides.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Slide Speed', 'g5plus-handmade'),
                            'param_name' => 'slidespeed',
                            'description' => __('Slide speed in milliseconds. Ex 200', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '200',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Pagination Speed', 'g5plus-handmade'),
                            'param_name' => 'paginationspeed',
                            'description' => __('Pagination speed in milliseconds. Ex 800', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '800',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Rewind Speed', 'g5plus-handmade'),
                            'param_name' => 'rewindspeed',
                            'description' => __('Rewind speed in milliseconds. Ex 1000', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1000',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));

                vc_map(array(
                    'name' => __('Testimonials', 'g5plus-handmade'),
                    'base' => 'handmade_testimonial_ctn',
                    'class' => '',
                    'icon' => 'fa fa-quote-left',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('only' => 'handmade_testimonial_sc'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Layout Style', 'g5plus-handmade'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(__('Single Item, left ', 'g5plus-handmade') => 'style1', __('Single Item, center', 'g5plus-handmade') => 'style2', __('2 Item', 'g5plus-handmade') => 'style3'),
                            'description' => __('Select Layout Style.', 'g5plus-handmade')
                        ),
	                    array(
		                    'type' => 'dropdown',
                            'heading' => __('Color Scheme', 'g5plus-handmade'),
		                    'param_name' => 'color_scheme',
                            'value' => array(__('Dark', 'g5plus-handmade') => 'dark', __('Light', 'g5plus-handmade') => 'light'),
                            'std' => 'dark',
                            'description' => __('Select Color Scheme.', 'g5plus-handmade')
	                    ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Show border', 'g5plus-handmade'),
                            'param_name' => 'border',
                            'description' => __('Display border.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Auto Play', 'g5plus-handmade'),
                            'param_name' => 'autoplay',
                            'description' => __('Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '5000'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Stop On Hover', 'g5plus-handmade'),
                            'param_name' => 'stoponhover',
                            'description' => __('Stop autoplay on mouse hover.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Auto Height', 'g5plus-handmade'),
                            'param_name' => 'autoheight',
                            'description' => __('You can use different heights on slides.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Slide Speed', 'g5plus-handmade'),
                            'param_name' => 'slidespeed',
                            'description' => __('Slide speed in milliseconds. Ex 200', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '200',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Pagination Speed', 'g5plus-handmade'),
                            'param_name' => 'paginationspeed',
                            'description' => __('Pagination speed in milliseconds. Ex 800', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '800',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Rewind Speed', 'g5plus-handmade'),
                            'param_name' => 'rewindspeed',
                            'description' => __('Rewind speed in milliseconds. Ex 1000', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1000',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => __('Testimonial', 'g5plus-handmade'),
                    'base' => 'handmade_testimonial_sc',
                    'class' => '',
                    'icon' => 'fa fa-user',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_child' => array('only' => 'handmade_testimonial_ctn', 'handmade_slider_container'),
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => __('Image:', 'g5plus-handmade'),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => __('Choose the author picture.', 'g5plus-handmade'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Author name', 'g5plus-handmade'),
                            'param_name' => 'author',
                            'admin_label' => true,
                            'description' => __('Enter Author name.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Author Info', 'g5plus-handmade'),
                            'param_name' => 'author_info',
                            'admin_label' => true,
                            'description' => __('Enter Author information.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Quote from author', 'g5plus-handmade'),
                            'param_name' => 'content',
                            'value' => ''
                        )
                    )
                ));


                vc_map(array(
                    'name' => __('Cover Box', 'g5plus-handmade'),
                    'base' => 'handmade_cover_box_ctn',
                    'class' => '',
                    'icon' => 'fa fa-newspaper-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('only' => 'handmade_cover_box_sc'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Item Active Index', 'g5plus-handmade'),
                            'param_name' => 'active_index',
                            'std'   =>  '1',
                            'admin_label' => true,
                            'description' => __('Enter number index of item need active.', 'g5plus-handmade')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => __('Cover Box Item', 'g5plus-handmade'),
                    'base' => 'handmade_cover_box_sc',
                    'class' => '',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_child' => array('only' => 'handmade_cover_box_ctn', 'handmade_slider_container'),
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => __('Image:', 'g5plus-handmade'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'admin_label' => true,
                            'description' => __('Enter Title.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => __('Link (url)', 'g5plus-handmade'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Description', 'g5plus-handmade'),
                            'param_name' => 'content',
                            'value' => ''
                        )
                    )
                ));

                vc_map(array(
                    'name' => __('Counter', 'g5plus-handmade'),
                    'base' => 'handmade_counter',
                    'class' => '',
                    'icon' => 'fa fa-tachometer',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Value', 'g5plus-handmade'),
                            'param_name' => 'value',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => __('Color', 'g5plus-handmade'),
                            'param_name' => 'value_color',
                            'description' => __('Select custom color for your element.', 'g5plus-handmade'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => __('Color', 'g5plus-handmade'),
                            'param_name' => 'title_color',
                            'description' => __('Select custom color for your element.', 'g5plus-handmade'),
                        ),
                        $add_el_class
                    )
                ));

                if (!isset($cpt_disable) || (array_key_exists('portfolio', $cpt_disable) && ($cpt_disable['portfolio'] == '0' || $cpt_disable['portfolio'] == ''))) {
                    $portfolio_categories = get_terms(G5PLUS_PORTFOLIO_CATEGORY_TAXONOMY, array('hide_empty' => 0, 'orderby' => 'ASC'));
                    $portfolio_cat = array();
                    if (is_array($portfolio_categories)) {
                        foreach ($portfolio_categories as $cat) {
                            $portfolio_cat[$cat->name] = $cat->slug;
                        }
                    }

                    $args = array(
                        'posts_per_page' => -1,
                        'post_type' => G5PLUS_PORTFOLIO_POST_TYPE,
                        'post_status' => 'publish');
                    $list_portfolio = array();
                    $post_array = get_posts($args);
                    foreach ($post_array as $post) : setup_postdata($post);
                        $list_portfolio[$post->post_title] = $post->ID;
                    endforeach;
                    wp_reset_postdata();

                    vc_map(array(
                        'name' => __('Portfolio', 'g5plus-handmade'),
                        'base' => 'g5plusframework_portfolio',
                        'class' => '',
                        'icon' => 'fa fa-th-large',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Layout style', 'g5plus-handmade'),
                                'param_name' => 'layout_type',
                                'admin_label' => true,
                                'value' => array(__('Grid', 'g5plus-handmade') => 'grid',
                                    __('Title & category', 'g5plus-handmade') => 'title',
                                    __('One page', 'g5plus-handmade') => 'one-page',
                                    __('Masonry Style-01', 'g5plus-handmade') => 'masonry',
                                    __('Masonry Style-02', 'g5plus-handmade') => 'masonry-style-02',
                                    __('Masonry Classic', 'g5plus-handmade') => 'masonry-classic',
                                    __('Left menu', 'g5plus-handmade') => 'left-menu'
                                )
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Show title of shortcode', 'g5plus-handmade'),
                                'param_name' => 'show_title',
                                'admin_label' => true,
                                'value' => array(__('Yes', 'g5plus-handmade') => 'yes',
                                    __('No', 'g5plus-handmade') => 'no'
                                ),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid','title'))

                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Title of shortcode', 'g5plus-handmade'),
                                'param_name' => 'title',
                                'value' => '',
                                'dependency' => Array('element' => 'show_title', 'value' => array('yes'))

                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Source', 'g5plus-handmade'),
                                'param_name' => 'data_source',
                                'admin_label' => true,
                                'value' => array(
                                    __('From Category', 'g5plus-handmade') => '',
                                    __('From Portfolio IDs', 'g5plus-handmade') => 'list_id')
                            ),

                            array(
                                'type' => 'multi-select',
                                'heading' => __('Portfolio Category', 'g5plus-handmade'),
                                'param_name' => 'category',
                                'admin_label' => true,
                                'options' => $portfolio_cat,
                                'dependency' => Array('element' => 'data_source', 'value' => array(''))
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => __('Select Portfolio', 'g5plus-handmade'),
                                'param_name' => 'portfolio_ids',
                                'options' => $list_portfolio,
                                'dependency' => Array('element' => 'data_source', 'value' => array('list_id'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Show Category', 'g5plus-handmade'),
                                'param_name' => 'show_category',
                                'admin_label' => true,
                                'value' => array(
                                    __('None', 'g5plus-handmade') => '',
                                    __('Show in left', 'g5plus-handmade') => 'left',
                                    __('Show in center', 'g5plus-handmade') => 'center',
                                    __('Show in right', 'g5plus-handmade') => 'right'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title', 'masonry', 'masonry-classic','masonry-style-02'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Category action', 'g5plus-handmade'),
                                'param_name' => 'tab_category_action',
                                'admin_label' => true,
                                'value' => array(
                                    __('Isotope Filter', 'g5plus-handmade') => 'filter',
                                    __('Ajax filter', 'g5plus-handmade') => 'ajax',
                                  ),
                                'dependency' => Array('element' => 'show_category', 'value' => array('left', 'center', 'right'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Number of column', 'g5plus-handmade'),
                                'param_name' => 'column',
                                'value' => array('2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Number of column masonry', 'g5plus-handmade'),
                                'param_name' => 'column_masonry',
                                'value' => array('3' => '3', '4' => '4', '5' => '5'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('masonry'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Number of item (or number of item per page if choose show paging)', 'g5plus-handmade'),
                                'param_name' => 'item',
                                'value' => '',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order Post Date By', 'g5plus-handmade'),
                                'param_name' => 'order',
                                'value' => array(__('Descending', 'g5plus-handmade') => 'DESC', __('Ascending', 'g5plus-handmade') => 'ASC')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Show Paging', 'g5plus-handmade'),
                                'param_name' => 'show_pagging',
                                'value' => array('None' => '', __('Load more', 'g5plus-handmade') => '1', __('Slider', 'g5plus-handmade') => '2'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Show Paging Masonry', 'g5plus-handmade'),
                                'param_name' => 'show_pagging_masonry',
                                'value' => array('None' => '', __('Load more', 'g5plus-handmade') => '1'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('masonry','masonry-classic','masonry-style-02'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Padding', 'g5plus-handmade'),
                                'param_name' => 'padding',
                                'value' => array(__('No padding', 'g5plus-handmade') => '', '10 px' => 'col-padding-10', '15 px' => 'col-padding-15', '20 px' => 'col-padding-20', '40 px' => 'col-padding-40'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title', 'masonry', 'one-page', 'masonry-style-02', 'masonry-classic'))
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Image size', 'g5plus-handmade'),
                                'param_name' => 'image_size',
                                'value' => array('585x585' => '585x585', '590x393' => '590x393', '570x460'),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'title'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Overlay Style', 'g5plus-handmade'),
                                'param_name' => 'overlay_style',
                                'admin_label' => true,
                                'value' => array(__('Icon', 'g5plus-handmade') => 'icon',
                                    __('Title', 'g5plus-handmade') => 'title',
                                    __('Title & Category', 'g5plus-handmade') => 'title-category',
                                    __('Title & Category & Link button', 'g5plus-handmade') => 'title-category-link',
                                    __('Title & Excerpt & Link button & Align center', 'g5plus-handmade') => 'title-excerpt-link',
                                    __('Title & Excerpt & Link button & Align left', 'g5plus-handmade') => 'left-title-excerpt-link',
                                    __('Title & Excerpt', 'g5plus-handmade') => 'title-excerpt',
                                    __('Title & Excerpt Style 02', 'g5plus-handmade') => 'title-excerpt-style-02',
                                ),
                                'dependency' => Array('element' => 'layout_type', 'value' => array('grid', 'masonry', 'left-menu', 'title-more-link', 'more-link', 'one-page', 'masonry-style-02', 'masonry-classic'))
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation

                        )
                    ));
                }

                if (!isset($cpt_disable) || (array_key_exists('ourteam', $cpt_disable) && ($cpt_disable['ourteam'] == '0' || $cpt_disable['ourteam'] == ''))) {
                    $ourteam_cat = array();
                    $ourteam_categories = get_terms('ourteam_category', array('hide_empty' => 0, 'orderby' => 'ASC'));
                    if (is_array($ourteam_categories)) {
                        foreach ($ourteam_categories as $cat) {
                            $ourteam_cat[$cat->name] = $cat->slug;
                        }
                    }
                    vc_map(array(
                        'name' => __('Our Team', 'g5plus-handmade'),
                        'base' => 'handmade_ourteam',
                        'class' => '',
                        'icon' => 'fa fa-users',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Layout Style', 'g5plus-handmade'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(__('style 1', 'g5plus-handmade') => 'style1', __('style 2', 'g5plus-handmade') => 'style2'),
                                'description' => __('Select Layout Style.', 'g5plus-handmade')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Item Amount', 'g5plus-handmade'),
                                'param_name' => 'item_amount',
                                'value' => '8'
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Column', 'g5plus-handmade'),
                                'param_name' => 'column',
                                'value' => '4'
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Slider Style', 'g5plus-handmade'),
                                'param_name' => 'is_slider',
                                'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Show pagination control', 'g5plus-handmade'),
                                'param_name' => 'pagination',
                                'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Show navigation control', 'g5plus-handmade'),
                                'param_name' => 'navigation',
                                'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                                'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => __('Category', 'g5plus-handmade'),
                                'param_name' => 'category',
                                'options' => $ourteam_cat
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));
                }

                vc_map(array(
                    'name' => __('Button', 'g5plus-handmade'),
                    'base' => 'handmade_button',
                    'class' => '',
                    'icon' => 'fa fa-bold',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Layout Style', 'g5plus-handmade'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(__('Style Background', 'g5plus-handmade') => 'style1', __('Style Border', 'g5plus-handmade') => 'style2'),
                            'description' => __('Select Layout Style.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Color Background', 'g5plus-handmade'),
                            'param_name' => 'color_background',
                            'value' => array(__('Primary Color', 'g5plus-handmade') => 'pri-color', __('Gray Color', 'g5plus-handmade') => 'gray-color'),
                            'description' => __('Select Background Color', 'g5plus-handmade'),
                            'dependency' => array('element'=>'layout_style','value'=>'style1')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Size', 'g5plus-handmade'),
                            'param_name' => 'size',
                            'admin_label' => true,
                            'value' => array(__('Small', 'g5plus-handmade') => 'button-1x', __('Medium', 'g5plus-handmade') => 'button-2x', __('Large', 'g5plus-handmade') => 'button-3x'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Color Scheme', 'g5plus-handmade'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                __('Dark', 'g5plus-handmade') => 'button-dark',
                                __('Light', 'g5plus-handmade') => 'button-light'),
                            'description' => __('Select color scheme', 'g5plus-handmade'),
                            'dependency' => Array('element' => 'layout_style', 'value' => array('style2')),
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => __('Link (url)', 'g5plus-handmade'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Add icon?', 'g5plus-handmade'),
                            'param_name' => 'add_icon',
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Icon library', 'g5plus-handmade'),
                            'value' => array(
                                __('[None]', 'g5plus-handmade') => '',
                                __('Pe Icon 7 Stroke', 'g5plus-handmade') => 'pe_7_stroke',
                                __('Font Awesome', 'g5plus-handmade') => 'fontawesome',
                                __('Open Iconic', 'g5plus-handmade') => 'openiconic',
                                __('Typicons', 'g5plus-handmade') => 'typicons',
                                __('Entypo', 'g5plus-handmade') => 'entypo',
                                __('Linecons', 'g5plus-handmade') => 'linecons',
                                __('Image', 'g5plus-handmade') => 'image',
                            ),
                            'param_name' => 'icon_type',
                            'description' => __('Select icon library.', 'g5plus-handmade'),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $icon_pe_7_stroke,
                        $icon_fontawesome,
                        $icon_openiconic,
                        $icon_typicons,
                        $icon_entypo,
                        $icon_linecons,
                        $icon_image,
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Icon Alignment', 'g5plus-handmade'),
                            'description' => __('Select icon alignment.', 'g5plus-handmade'),
                            'param_name' => 'i_align',
                            'value' => array(
                                __('Left', 'g5plus-handmade') => 'i_left',
                                __('Right', 'g5plus-handmade') => 'i_right',
                            ),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));

                vc_map(array(
                    'name' => __('Call To Action', 'g5plus-handmade'),
                    'base' => 'handmade_call_action',
                    'class' => '',
                    'icon' => 'fa fa-play',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Layout Style', 'g5plus-handmade'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(__('Background Gray', 'g5plus-handmade') => 'style1', __('Background Primary Color', 'g5plus-handmade') => 'style2'),
                            'description' => __('Select Layout Style.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Text', 'g5plus-handmade'),
                            'param_name' => 'text',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => __('Link (url)', 'g5plus-handmade'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                $category = array();
                $categories = get_categories();
                if (is_array($categories)) {
                    foreach ($categories as $cat) {
                        $category[$cat->name] = $cat->slug;
                    }
                }

                vc_map(
                    array(
                        'name' => __('Blog', 'g5plus-handmade'),
                        'base' => 'handmade_blog',
                        'icon' => 'fa fa-file-text',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Blog Style', 'g5plus-handmade'),
                                'param_name' => 'type',
                                'value' => array(
                                    __('Larger Image', 'g5plus-handmade') => 'large-image',
                                    __('Medium Image', 'g5plus-handmade') => 'medium-image',
                                    __('Grid', 'g5plus-handmade') => 'grid',
                                    __('Masonry', 'g5plus-handmade') => 'masonry'
                                ),
                                'std' => 'large-image',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),

                            array(
                                "type" => "dropdown",
                                "heading" => __("Columns", 'g5plus-handmade'),
                                "param_name" => "columns",
                                "value" => array(
                                    __('2 columns', 'g5plus-handmade') => 2,
                                    __('3 columns', 'g5plus-handmade') => 3,
                                    __('4 columns', 'g5plus-handmade') => 4,
                                ),
                                "description" => __("How much columns grid", 'g5plus-handmade'),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value' => array('grid', 'masonry')
                                ),
                                'std' => 2,
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),


                            array(
                                'type' => 'multi-select',
                                'heading' => __('Narrow Category', 'g5plus-handmade'),
                                'param_name' => 'category',
                                'options' => $category
                            ),

                            array(
                                "type" => "textfield",
                                "heading" => __("Total items", 'g5plus-handmade'),
                                "param_name" => "max_items",
                                "value" => -1,
                                "description" => __('Set max limit for items or enter -1 to display all.', 'g5plus-handmade')
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Navigation Type', 'g5plus-handmade'),
                                'param_name' => 'paging_style',
                                'value' => array(
                                    __('Show all', 'g5plus-handmade') => 'all',
                                    __('Default', 'g5plus-handmade') => 'default',
                                    __('Load More', 'g5plus-handmade') => 'load-more',
                                    __('Infinity Scroll', 'g5plus-handmade') => 'infinity-scroll',
                                ),
                                'std' => 'all',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency' => array(
                                    'element' => 'max_items',
                                    'value' => array('-1')
                                ),
                            ),




                            array(
                                "type" => "textfield",
                                "heading" => __("Posts per page", 'g5plus-handmade'),
                                "param_name" => "posts_per_page",
                                "value" => get_option('posts_per_page'),
                                "description" => __('Number of items to show per page', 'g5plus-handmade'),
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value' => array('default', 'load-more', 'infinity-scroll'),
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Navigation Align', 'g5plus-handmade'),
                                'param_name' => 'paging_align',
                                'value' => array(
                                    __('Left', 'g5plus-handmade') => 'left',
                                    __('Center', 'g5plus-handmade') => 'center',
                                    __('Right', 'g5plus-handmade') => 'right',
                                ),
                                'std' => 'right',
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value' => array('default'),
                                ),
                            ),

                            // Data settings
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order by', 'g5plus-handmade'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    __('Date', 'g5plus-handmade') => 'date',
                                    __('Order by post ID', 'g5plus-handmade') => 'ID',
                                    __('Author', 'g5plus-handmade') => 'author',
                                    __('Title', 'g5plus-handmade') => 'title',
                                    __('Last modified date', 'g5plus-handmade') => 'modified',
                                    __('Post/page parent ID', 'g5plus-handmade') => 'parent',
                                    __('Number of comments', 'g5plus-handmade') => 'comment_count',
                                    __('Menu order/Page Order', 'g5plus-handmade') => 'menu_order',
                                    __('Meta value', 'g5plus-handmade') => 'meta_value',
                                    __('Meta value number', 'g5plus-handmade') => 'meta_value_num',
                                    __('Random order', 'g5plus-handmade') => 'rand',
                                ),
                                'description' => __('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'g5plus-handmade'),
                                'group' => __('Data Settings', 'g5plus-handmade'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Sorting', 'g5plus-handmade'),
                                'param_name' => 'order',
                                'group' => __('Data Settings', 'g5plus-handmade'),
                                'value' => array(
                                    __('Descending', 'g5plus-handmade') => 'DESC',
                                    __('Ascending', 'g5plus-handmade') => 'ASC',
                                ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'description' => __('Select sorting order.', 'g5plus-handmade'),
                            ),

                            array(
                                'type' => 'textfield',
                                'heading' => __('Meta key', 'g5plus-handmade'),
                                'param_name' => 'meta_key',
                                'description' => __('Input meta key for grid ordering.', 'g5plus-handmade'),
                                'group' => __('Data Settings', 'g5plus-handmade'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'dependency' => array(
                                    'element' => 'orderby',
                                    'value' => array('meta_value', 'meta_value_num'),
                                ),
                            ),

                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
                vc_map(array(
                    'name' => __('Posts', 'g5plus-handmade'),
                    'base' => 'handmade_post',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => __('Posts', 'g5plus-handmade'),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'value' => ''
                        ),
                        array(
                            'type' => 'multi-select',
                            'heading' => __('Category', 'g5plus-handmade'),
                            'param_name' => 'category',
                            'options' => $category
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Display', 'g5plus-handmade'),
                            'param_name' => 'display',
                            'admin_label' => true,
                            'value' => array(__('Random', '') => 'random', __('Popular', 'g5plus-handmade') => 'popular', __('Recent', 'g5plus-handmade') => 'recent', __('Oldest', 'g5plus-handmade') => 'oldest'),
                            'std' => 'recent',
                            'description' => __('Select Orderby.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Item Amount', 'g5plus-handmade'),
                            'param_name' => 'item_amount',
                            'value' => '6'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Column', 'g5plus-handmade'),
                            'param_name' => 'column',
                            'value' => '3',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Slider Style', 'g5plus-handmade'),
                            'param_name' => 'is_slider',
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Show pagination control', 'g5plus-handmade'),
                            'param_name' => 'pagination',
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Show navigation control', 'g5plus-handmade'),
                            'param_name' => 'navigation',
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => __('Partner Carousel', 'g5plus-handmade'),
                    'base' => 'handmade_partner_carousel',
                    'icon' => 'fa fa-user-plus',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => __('Animated carousel with images', 'g5plus-handmade'),
                    'params' => array(
                        array(
                            'type' => 'attach_images',
                            'heading' => __('Images', 'g5plus-handmade'),
                            'param_name' => 'images',
                            'value' => '',
                            'description' => __('Select images from media library.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Image size', 'g5plus-handmade'),
                            'param_name' => 'img_size',
                            'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'g5plus-handmade'),
                            'std' => 'full'
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Image Opacity', 'g5plus-handmade'),
                            'param_name' => 'opacity',
                            'value' => array(
                                __('[none]', 'g5plus-handmade') => '',
                                __('10%', 'g5plus-handmade') => '10',
                                __('20%', 'g5plus-handmade') => '20',
                                __('30%', 'g5plus-handmade') => '30',
                                __('40%', 'g5plus-handmade') => '40',
                                __('50%', 'g5plus-handmade') => '50',
                                __('60%', 'g5plus-handmade') => '60',
                                __('70%', 'g5plus-handmade') => '70',
                                __('80%', 'g5plus-handmade') => '80',
                                __('90%', 'g5plus-handmade') => '90',
                                __('100%', 'g5plus-handmade') => '100'
                            ),
                            'std' => '80'
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => __('Custom links', 'g5plus-handmade'),
                            'param_name' => 'custom_links',
                            'description' => __('Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'g5plus-handmade'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Custom link target', 'g5plus-handmade'),
                            'param_name' => 'custom_links_target',
                            'description' => __('Select where to open  custom links.', 'g5plus-handmade'),
                            'value' => $target_arr
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Navigation', 'g5plus-handmade'),
                            'param_name' => 'navigation',
                            'description' => __('Show navigation.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Pagination', 'g5plus-handmade'),
                            'param_name' => 'pagination',
                            'description' => __('Show pagination.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Auto Play', 'g5plus-handmade'),
                            'param_name' => 'autoplay',
                            'description' => __('Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '5000'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Stop On Hover', 'g5plus-handmade'),
                            'param_name' => 'stoponhover',
                            'description' => __('Stop autoplay on mouse hover.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items', 'g5plus-handmade'),
                            'param_name' => 'items',
                            'description' => __('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-handmade'),
                            'value' => '',
                            'std' => 5
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktop',
                            'description' => __('This allows you to preset the number of slides visible with a particular browser width. The format is [x,y] whereby x=browser width and y=number of slides displayed. For example [1199,4] means that if(window<=1199){ show 4 slides per page} Alternatively use itemsDesktop: false to override these settings.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1199,5'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop Small', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktopsmall',
                            'value' => '',
                            'std' => '979,4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet', 'g5plus-handmade'),
                            'param_name' => 'itemstablet',
                            'value' => '',
                            'std' => '768,3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet Small', 'g5plus-handmade'),
                            'param_name' => 'itemstabletsmall',
                            'value' => '',
                            'std' => 'false'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Mobile', 'g5plus-handmade'),
                            'param_name' => 'itemsmobile',
                            'value' => '',
                            'std' => '479,1'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Slide Speed', 'g5plus-handmade'),
                            'param_name' => 'slidespeed',
                            'description' => __('Slide speed in milliseconds. Ex 200', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '200',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Pagination Speed', 'g5plus-handmade'),
                            'param_name' => 'paginationspeed',
                            'description' => __('Pagination speed in milliseconds. Ex 800', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '800',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Rewind Speed', 'g5plus-handmade'),
                            'param_name' => 'rewindspeed',
                            'description' => __('Rewind speed in milliseconds. Ex 1000', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1000',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => __('Titles', 'g5plus-handmade'),
                    'base' => 'handmade_titles',
                    'class' => '',
                    'icon' => 'fa fa-text-width',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Color Scheme', 'g5plus-handmade'),
                            'param_name' => 'color_scheme',
                            'value' => array(__('Dark', 'g5plus-handmade') => 'dark', __('Light', 'g5plus-handmade') => 'light'),
                            'std'   => 'dark',
                            'description' => __('Select Color Scheme.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Titles', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'value' => ''
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Sub Title', 'g5plus-handmade'),
                            'param_name' => 'sub_title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => __('Description', 'g5plus-handmade'),
                            'param_name' => 'description',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Text align', 'g5plus-handmade'),
                            'param_name' => 'text_align',
                            'value' => array(
                                __('Left', 'g5plus-handmade') => 'text-left',
                                __('Right', 'g5plus-handmade') => 'text-right',
                                __('Center', 'g5plus-handmade') => 'text-center',
                            ),
                            'std' => 'text-center'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => __('Headings', 'g5plus-handmade'),
                    'base' => 'handmade_heading',
                    'class' => '',
                    'icon' => 'fa fa-header',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
	                    array(
		                    'type' => 'dropdown',
                            'heading' => __('Color Scheme', 'g5plus-handmade'),
		                    'param_name' => 'color_scheme',
                            'value' => array(__('Dark', 'g5plus-handmade') => 'dark', __('Light', 'g5plus-handmade') => 'light'),
		                    'std'   => 'dark',
                            'description' => __('Select Color Scheme.', 'g5plus-handmade')
	                    ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'value' => '',
	                        'admin_label' => true
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => __('Image Slider', 'g5plus-handmade'),
                    'base' => 'handmade_image_slider',
                    'icon' => 'icon-wpb-images-carousel',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => __('Animated carousel with images', 'g5plus-handmade'),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'g5plus-handmade'),
                            'param_name' => 'title',
                            'description' => __('Enter title', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'attach_images',
                            'heading' => __('Images', 'g5plus-handmade'),
                            'param_name' => 'images',
                            'value' => '',
                            'description' => __('Select images from media library.', 'g5plus-handmade')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Image size', 'g5plus-handmade'),
                            'param_name' => 'img_size',
                            'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'g5plus-handmade'),
                            'std' => 'full'
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => __('Custom links', 'g5plus-handmade'),
                            'param_name' => 'custom_links',
                            'description' => __('Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'g5plus-handmade'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Custom link target', 'g5plus-handmade'),
                            'param_name' => 'custom_links_target',
                            'description' => __('Select where to open  custom links.', 'g5plus-handmade'),
                            'value' => $target_arr
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Navigation', 'g5plus-handmade'),
                            'param_name' => 'navigation',
                            'description' => __('Show navigation.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Pagination', 'g5plus-handmade'),
                            'param_name' => 'pagination',
                            'description' => __('Show pagination.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Auto Play', 'g5plus-handmade'),
                            'param_name' => 'autoplay',
                            'description' => __('Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '5000'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Stop On Hover', 'g5plus-handmade'),
                            'param_name' => 'stoponhover',
                            'description' => __('Stop autoplay on mouse hover.', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items', 'g5plus-handmade'),
                            'param_name' => 'items',
                            'description' => __('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-handmade'),
                            'value' => '',
                            'std' => 3
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktop',
                            'description' => __('This allows you to preset the number of slides visible with a particular browser width. The format is [x,y] whereby x=browser width and y=number of slides displayed. For example [1199,4] means that if(window<=1199){ show 4 slides per page} Alternatively use itemsDesktop: false to override these settings.', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1199,5'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Desktop Small', 'g5plus-handmade'),
                            'param_name' => 'itemsdesktopsmall',
                            'value' => '',
                            'std' => '979,3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet', 'g5plus-handmade'),
                            'param_name' => 'itemstablet',
                            'value' => '',
                            'std' => '768,2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Tablet Small', 'g5plus-handmade'),
                            'param_name' => 'itemstabletsmall',
                            'value' => '',
                            'std' => 'false'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Items Mobile', 'g5plus-handmade'),
                            'param_name' => 'itemsmobile',
                            'value' => '',
                            'std' => '479,1'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Slide Speed', 'g5plus-handmade'),
                            'param_name' => 'slidespeed',
                            'description' => __('Slide speed in milliseconds. Ex 200', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '200',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Pagination Speed', 'g5plus-handmade'),
                            'param_name' => 'paginationspeed',
                            'description' => __('Pagination speed in milliseconds. Ex 800', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '800',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Rewind Speed', 'g5plus-handmade'),
                            'param_name' => 'rewindspeed',
                            'description' => __('Rewind speed in milliseconds. Ex 1000', 'g5plus-handmade'),
                            'value' => '',
                            'std' => '1000',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(
                    array(
                        'name' => __('Icon Box', 'g5plus-handmade'),
                        'base' => 'handmade_icon_box',
                        'icon' => 'fa fa-diamond',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => 'Adds icon box with font icons',
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Background shape', 'g5plus-handmade'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(__('None', 'g5plus-handmade') => 'style1', __('Circle', 'g5plus-handmade') => 'style2'),
                                'description' => __('Select Layout Style.', 'g5plus-handmade')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Icon Alignment', 'g5plus-handmade'),
                                'param_name' => 'i_align',
                                'value' => array(__('Top-Left', 'g5plus-handmade') => 'icon-top-left', __('Left', 'g5plus-handmade') => 'icon-left', __('Top-Center', 'g5plus-handmade') => 'icon-top-center'),
                                'description' => __('Select To Place Icon.', 'g5plus-handmade')
                            ),
	                        array(
		                        'type' => 'dropdown',
                                'heading' => __('Color Scheme', 'g5plus-handmade'),
		                        'param_name' => 'color_scheme',
                                'value' => array(__('Dark', 'g5plus-handmade') => 'dark', __('Light', 'g5plus-handmade') => 'light'),
		                        'std'=>'dark',
                                'description' => __('Select Color Scheme.', 'g5plus-handmade')
	                        ),
                            $icon_type,
                            $icon_pe_7_stroke,
                            $icon_fontawesome,
                            $icon_openiconic,
                            $icon_typicons,
                            $icon_entypo,
                            $icon_linecons,
                            $icon_image,
                            array(
                                'type' => 'vc_link',
                                'heading' => __('Link (url)', 'g5plus-handmade'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Title', 'g5plus-handmade'),
                                'param_name' => 'title',
                                'value' => '',
                                'description' => __('Provide the title for this icon box.', 'g5plus-handmade'),
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => __('Description', 'g5plus-handmade'),
                                'param_name' => 'description',
                                'value' => '',
                                'description' => __('Provide the description for this icon box.', 'g5plus-handmade'),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );

                vc_map(
                    array(
                        'name' => __('Banner', 'g5plus-handmade'),
                        'base' => 'handmade_banner',
                        'icon' => 'fa fa-file-image-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => __('Interactive banner', 'g5plus-handmade'),
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Layout Style', 'g5plus-handmade'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(__('Custom', 'g5plus-handmade') => 'custom', __('Custom Button', 'g5plus-handmade') => 'custom-button', __('Custom Icon', 'g5plus-handmade') => 'custom-icon', __('Border', 'g5plus-handmade') => 'style1', __('Border-Absolute', 'g5plus-handmade') => 'style2', __('Border Absolute Transparent', 'g5plus-handmade') => 'style3', __('Background', 'g5plus-handmade') => 'style4'),
                                'description' => __('Select Layout Style.', 'g5plus-handmade')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Content Alignment', 'g5plus-handmade'),
                                'param_name' => 'content_align',
                                'value' => array(__('Content Center', 'g5plus-handmade') => 'content-center', __('Content Left', 'g5plus-handmade') => 'content-left'),
                                'description' => __('Select place for content.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>'style1')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Content Location', 'g5plus-handmade'),
                                'param_name' => 'location_content',
                                'value' => array(__('Center', 'g5plus-handmade') => 'center', __('Top Left', 'g5plus-handmade') => 'top-left', __('Top-Right', 'g5plus-handmade') => 'top-right', __('Bottom-Right', 'g5plus-handmade') => 'bot-right', __('Bottom Left', 'g5plus-handmade') => 'bot-left'),
                                'description' => __('Select place for content.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>'custom')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Contents Location', 'g5plus-handmade'),
                                'param_name' => 'location_style2',
                                'value' => array(__('Left', 'g5plus-handmade') => 'left', __('Right', 'g5plus-handmade') => 'right'),
                                'description' => __('Select place for content.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>'style2')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Border Location', 'g5plus-handmade'),
                                'param_name' => 'location_border',
                                'value' => array(__('Top', 'g5plus-handmade') => 'top', __('Bottom', 'g5plus-handmade') => 'bot'),
                                'description' => __('Select place for border.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>'style3')
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => __('Color Border', 'g5plus-handmade'),
                                'param_name' => 'border_color',
                                'description' => __('Select custom color for your element.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style1','style3'))
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => __('Color Background', 'g5plus-handmade'),
                                'param_name' => 'bg_color',
                                'description' => __('Select custom color for your element.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style4'))
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => __('Color Sub Title', 'g5plus-handmade'),
                                'param_name' => 'text_color',
                                'description' => __('Select custom color for your element.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style1','style3'))
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => __('Image Banner:', 'g5plus-handmade'),
                                'param_name' => 'image',
                                'value' => '',
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => __('Link (url)', 'g5plus-handmade'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Add Button?', 'g5plus-handmade'),
                                'param_name' => 'add_button',
                                'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes-add'),
                                'dependency' => array('element'=>'layout_style','value'=>array('style2')),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Display Overlay?', 'g5plus-handmade'),
                                'param_name' => 'overlay_banner',
                                'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes-display'),
                                'dependency' => array('element'=>'layout_style','value'=>'custom'),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Title', 'g5plus-handmade'),
                                'param_name' => 'title',
                                'value' => '',
                                'dependency' => array('element'=>'layout_style','value'=>array('custom','custom-icon','style1','style2','style3'))
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Icon library', 'g5plus-handmade'),
                                'value' => array(
                                    __('[None]', 'g5plus-handmade') => '',
                                    __('Pe Icon 7 Stroke', 'g5plus-handmade') => 'pe_7_stroke',
                                    __('Font Awesome', 'g5plus-handmade') => 'fontawesome',
                                    __('Open Iconic', 'g5plus-handmade') => 'openiconic',
                                    __('Typicons', 'g5plus-handmade') => 'typicons',
                                    __('Entypo', 'g5plus-handmade') => 'entypo',
                                    __('Linecons', 'g5plus-handmade') => 'linecons',
                                    __('Image', 'g5plus-handmade') => 'image',
                                ),
                                'param_name' => 'icon_type',
                                'description' => __('Select icon library.', 'g5plus-handmade'),
                                'dependency' => array('element'=>'layout_style','value'=>'custom-icon')
                            ),
                            $icon_pe_7_stroke,
                            $icon_fontawesome,
                            $icon_openiconic,
                            $icon_typicons,
                            $icon_entypo,
                            $icon_linecons,
                            $icon_image,
                            array(
                                'type' => 'textfield',
                                'heading' => __('Sub Title', 'g5plus-handmade'),
                                'param_name' => 'sub_title',
                                'value' => '',
                                'dependency' => array('element'=>'layout_style','value'=>array('custom','style1','style2','style3'))
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => __('Description', 'g5plus-handmade'),
                                'param_name' => 'description',
                                'value' => '',
                                'dependency' => array('element'=>'layout_style','value'=>array('custom','style2','style3'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Banner Height', 'g5plus-handmade'),
                                'param_name' => 'height',
                                'value' => '',
                            ),

                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                $product_cat = array();
                if (class_exists('WooCommerce')) {
                    $args = array(
                        'number' => '',
                    );
                    $product_categories = get_terms('product_cat', $args);
                    if (is_array($product_categories)) {
                        foreach ($product_categories as $cat) {
                            $product_cat[$cat->name] = $cat->slug;
                        }
                    }


                    vc_map(
                        array(
                            'name' => __('Product', 'g5plus-handmade'),
                            'base' => 'handmade_product',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Title", 'g5plus-handmade'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Feature', 'g5plus-handmade'),
                                    'param_name' => 'feature',
                                    "admin_label" => true,
                                    'value' => array(
                                        __('All', 'g5plus-handmade') => 'all',
                                        __('Sale Off', 'g5plus-handmade') => 'sale',
                                        __('New In', 'g5plus-handmade') => 'new-in',
                                        __('Featured', 'g5plus-handmade') => 'featured',
                                        __('Top rated', 'g5plus-handmade') => 'top-rated',
                                        __('Recent review', 'g5plus-handmade') => 'recent-review',
                                        __('Best Selling', 'g5plus-handmade') => 'best-selling'
                                    )
                                ),
                                array(
                                    'type' => 'multi-select',
                                    'heading' => __('Narrow Category', 'g5plus-handmade'),
                                    'param_name' => 'category',
                                    'options' => $product_cat,
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Total Items", 'g5plus-handmade'),
                                    "param_name" => "per_page",
                                    "admin_label" => true,
                                    "value" => '8',
                                    "description" => __('How much total items to show', 'g5plus-handmade')
                                ),

                                array(
                                    'type' => 'dropdown',
                                    "heading" => __("Columns", 'g5plus-handmade'),
                                    "param_name" => "columns",
                                    "admin_label" => true,
                                    'value' => array(
                                        '2' => 2,
                                        '3' => 3,
                                        '4' => 4,
                                    ),
                                    'std' => 4,
                                    "description" => __("How much columns grid", 'g5plus-handmade'),
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Show Rating', 'g5plus-handmade'),
                                    'param_name' => 'rating',
	                                'std' => 0,
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 1
                                    )
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Display Slider', 'g5plus-handmade'),
                                    'param_name' => 'slider',
	                                'std' => '',
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 'slider'
                                    )
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order by', 'g5plus-handmade'),
                                    'param_name' => 'orderby',
                                    'value' => array(
                                        __('Date', 'g5plus-handmade') => 'date',
                                        __('Price', 'g5plus-handmade') => 'price',
                                        __('Random', 'g5plus-handmade') => 'rand',
                                        __('Sales', 'g5plus-handmade') => 'sales'
                                    ),
                                    'description' => __('Select how to sort retrieved products.', 'g5plus-handmade'),
	                                'dependency' => array(
		                                'element' => 'feature',
		                                'value' => array('all', 'sale', 'featured')
	                                ),
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order way', 'g5plus-handmade'),
                                    'param_name' => 'order',
                                    'value' => array(
                                        __('Descending', 'g5plus-handmade') => 'DESC',
                                        __('Ascending', 'g5plus-handmade') => 'ASC'
                                    ),
                                    'description' => __('Designates the ascending or descending order.', 'g5plus-handmade'),
	                                'dependency' => array(
		                                'element' => 'feature',
		                                'value' => array('all', 'sale', 'featured')
	                                ),
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );

                    vc_map(array(
                        'name' => __('Product Categories', 'g5plus-handmade'),
                        'base' => 'handmade_product_categories',
                        'class' => '',
                        'icon' => 'fa fa-cart-plus',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => __("Title", 'g5plus-handmade'),
                                "param_name" => "title",
                                "admin_label" => true,
                                "value" => ''
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => __('Narrow Category', 'g5plus-handmade'),
                                'param_name' => 'category',
                                'options' => $product_cat
                            ),
                            array(
                                'type' => 'dropdown',
                                "heading" => __("Columns", 'g5plus-handmade'),
                                "param_name" => "columns",
                                "admin_label" => true,
                                'value' => array(
                                    '2' => 2,
                                    '3' => 3,
                                    '4' => 4,
                                ),
                                'std' => 4,
                                "description" => __("How much columns grid", 'g5plus-handmade'),
                            ),

	                        array(
		                        'type' => 'checkbox',
                                'heading' => __('Display Slider', 'g5plus-handmade'),
		                        'param_name' => 'slider',
		                        'std' => '',
		                        'value' => array(
                                    __('Yes, please', 'g5plus-handmade') => 'slider'
		                        ),
                                "admin_label" => true,
	                        ),

	                        array(
		                        'type' => 'checkbox',
                                'heading' => __('Hide empty', 'g5plus-handmade'),
		                        'param_name' => 'hide_empty',
		                        'std' => 0,
		                        'value' => array(
                                    __('Yes, please', 'g5plus-handmade') => 1
		                        )
	                        ),


                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order by', 'g5plus-handmade'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    __('Name', 'g5plus-handmade') => 'name',
                                    __('Order', 'g5plus-handmade') => 'order'
                                ),
                                'description' => __('Select how to sort retrieved products.', 'g5plus-handmade')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order way', 'g5plus-handmade'),
                                'param_name' => 'order',
                                'value' => array(__('Descending', 'g5plus-handmade') => 'DESC', __('Ascending', 'g5plus-handmade') => 'ASC'),
                                'description' => __('Designates the ascending or descending orde.', 'g5plus-handmade')
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));

                    vc_map(
                        array(
                            'name' => __('Product Creative', 'g5plus-handmade'),
                            'base' => 'handmade_product_creative',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Layout', 'g5plus-handmade'),
                                    'param_name' => 'columns',
                                    'value' => array(
                                        __('3 column', 'g5plus-handmade') => '3',
                                        __('2 column', 'g5plus-handmade') => '2'
                                    )
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Title", 'g5plus-handmade'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Feature', 'g5plus-handmade'),
                                    'param_name' => 'feature',
                                    "admin_label" => true,
                                    'value' => array(
                                        __('All', 'g5plus-handmade') => 'all',
                                        __('Sale Off', 'g5plus-handmade') => 'sale',
                                        __('New In', 'g5plus-handmade') => 'new-in',
                                        __('Featured', 'g5plus-handmade') => 'featured',
                                        __('Top rated', 'g5plus-handmade') => 'top-rated',
                                        __('Recent review', 'g5plus-handmade') => 'recent-review',
                                        __('Best Selling', 'g5plus-handmade') => 'best-selling'
                                    )
                                ),
                                array(
                                    'type' => 'multi-select',
                                    'heading' => __('Narrow Category', 'g5plus-handmade'),
                                    'param_name' => 'category',
                                    'options' => $product_cat,
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Total item", 'g5plus-handmade'),
                                    "param_name" => "per_page",
                                    "admin_label" => true,
                                    "value" => '6',
                                    "description" => __('How much items to show', 'g5plus-handmade')
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Show Rating', 'g5plus-handmade'),
                                    'param_name' => 'rating',
                                    'std' => 0,
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 1
                                    )
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order by', 'g5plus-handmade'),
                                    'param_name' => 'orderby',
                                    'value' => array(
                                        __('Date', 'g5plus-handmade') => 'date',
                                        __('Price', 'g5plus-handmade') => 'price',
                                        __('Random', 'g5plus-handmade') => 'rand',
                                        __('Sales', 'g5plus-handmade') => 'sales'
                                    ),
                                    'description' => __('Select how to sort retrieved products.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order way', 'g5plus-handmade'),
                                    'param_name' => 'order',
                                    'value' => array(
                                        __('Descending', 'g5plus-handmade') => 'DESC',
                                        __('Ascending', 'g5plus-handmade') => 'ASC'
                                    ),
                                    'description' => __('Designates the ascending or descending order.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );

                    vc_map(array(
                        'name' => __('Product Categories Home', 'g5plus-handmade'),
                        'base' => 'handmade_product_categories_home',
                        'class' => '',
                        'icon' => 'fa fa-cart-plus',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Style', 'g5plus-handmade'),
                                "admin_label" => true,
                                'param_name' => 'style',
                                'value' => array(
                                    __('Style 01', 'g5plus-handmade') => 'style-01',
                                    __('Style 02', 'g5plus-handmade') => 'style-02'
                                )
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => __("Height", 'g5plus-handmade'),
                                "param_name" => "height",
                                "admin_label" => true,
                                "value" => ''
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' => __('Hide empty', 'g5plus-handmade'),
                                'param_name' => 'hide_empty',
                                'std' => 0,
                                'value' => array(
                                    __('Yes, please', 'g5plus-handmade') => 1
                                )
                            ),

                            array(
                                'type' => 'checkbox',
                                'heading' => __('Show Product Count', 'g5plus-handmade'),
                                'param_name' => 'show_product_count',
                                'std' => 1,
                                'value' => array(
                                    __('Yes, please', 'g5plus-handmade') => 1
                                )
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order by', 'g5plus-handmade'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    __('Name', 'g5plus-handmade') => 'name',
                                    __('Order', 'g5plus-handmade') => 'order'
                                ),
                                'description' => __('Select how to sort categories.', 'g5plus-handmade')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Order way', 'g5plus-handmade'),
                                'param_name' => 'order',
                                'value' => array(
                                    __('Descending', 'g5plus-handmade') => 'DESC',
                                    __('Ascending', 'g5plus-handmade') => 'ASC'
                                ),
                                'description' => __('Designates the ascending or descending order.', 'g5plus-handmade')
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    ));

                    vc_map(
                        array(
                            'name' => __('Product Sidebar', 'g5plus-handmade'),
                            'base' => 'handmade_product_sidebar',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Style', 'g5plus-handmade'),
                                    'param_name' => 'style',
                                    "admin_label" => true,
                                    'value' => array(
                                        __('Style 01', 'g5plus-handmade') => 'style-01',
                                        __('Style 02', 'g5plus-handmade') => 'style-02',
                                    ),
                                    'std' => 'style-01'
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Title", 'g5plus-handmade'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Feature', 'g5plus-handmade'),
                                    'param_name' => 'feature',
                                    "admin_label" => true,
                                    'value' => array(
                                        __('All', 'g5plus-handmade') => 'all',
                                        __('Sale Off', 'g5plus-handmade') => 'sale',
                                        __('New In', 'g5plus-handmade') => 'new-in',
                                        __('Featured', 'g5plus-handmade') => 'featured',
                                        __('Top rated', 'g5plus-handmade') => 'top-rated',
                                        __('Recent review', 'g5plus-handmade') => 'recent-review',
                                        __('Best Selling', 'g5plus-handmade') => 'best-selling'
                                    )
                                ),
                                array(
                                    'type' => 'multi-select',
                                    'heading' => __('Narrow Category', 'g5plus-handmade'),
                                    'param_name' => 'category',
                                    'options' => $product_cat,
                                    "admin_label" => true,
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Total Items", 'g5plus-handmade'),
                                    "param_name" => "total_item",
                                    "admin_label" => true,
                                    "value" => 8,
                                    "description" => __('How much total items to show', 'g5plus-handmade')
                                ),


                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Display Slider', 'g5plus-handmade'),
                                    'param_name' => 'slider',
                                    'std' => '',
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 'slider'
                                    )
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => __("Per Page", 'g5plus-handmade'),
                                    "param_name" => "per_page",
                                    "value" => 4,
                                    "description" => __('How much items per page to show', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('AutoPlay', 'g5plus-handmade'),
                                    'param_name' => 'auto_play',
                                    'std' => 0,
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 1
                                    ),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                   'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => __("AutoPlay Speed", 'g5plus-handmade'),
                                    "param_name" => "auto_play_speed",
                                    "value" => 5000,
                                    "description" => __('How much speed autoPlay (ms)', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'auto_play',
                                        'value' => array('1')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),



                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Transition Style', 'g5plus-handmade'),
                                    'param_name' => 'transition_style',
                                    'value' => array(
                                        __('default', 'g5plus-handmade') => 'false',
                                        __('fade', 'g5plus-handmade') => 'fade',
                                        __('backSlide', 'g5plus-handmade') => 'backSlide',
                                        __('goDown', 'g5plus-handmade') => 'goDown',
                                        __('fadeUp', 'g5plus-handmade') => 'fadeUp'

                                    ),
                                    'std' => 'false',
                                    'description' => __('Select transition style for slider.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                ),


                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order by', 'g5plus-handmade'),
                                    'param_name' => 'orderby',
                                    'value' => array(
                                        __('Date', 'g5plus-handmade') => 'date',
                                        __('Price', 'g5plus-handmade') => 'price',
                                        __('Random', 'g5plus-handmade') => 'rand',
                                        __('Sales', 'g5plus-handmade') => 'sales'

                                    ),
                                    'description' => __('Select how to sort retrieved products.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Order way', 'g5plus-handmade'),
                                    'param_name' => 'order',
                                    'value' => array(
                                        __('Descending', 'g5plus-handmade') => 'DESC',
                                        __('Ascending', 'g5plus-handmade') => 'ASC'
                                    ),
                                    'description' => __('Designates the ascending or descending order.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'feature',
                                        'value' => array('all', 'sale', 'featured')
                                    ),
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );


                    vc_map(
                        array(
                            'name' => __('Product Recent Reviews', 'g5plus-handmade'),
                            'base' => 'handmade_product_reviews',
                            'icon' => 'fa fa-shopping-cart',
                            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                            'params' => array(
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Title", 'g5plus-handmade'),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "value" => ''
                                ),
                                array(
                                    "type" => "textfield",
                                    "heading" => __("Total Items", 'g5plus-handmade'),
                                    "param_name" => "total_item",
                                    "admin_label" => true,
                                    "value" => 8,
                                    "description" => __('How much total items to show', 'g5plus-handmade')
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Display Slider', 'g5plus-handmade'),
                                    'param_name' => 'slider',
                                    'std' => '',
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 'slider'
                                    )
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => __("Per Page", 'g5plus-handmade'),
                                    "param_name" => "per_page",
                                    "value" => 4,
                                    "description" => __('How much items per page to show', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                ),

                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('AutoPlay', 'g5plus-handmade'),
                                    'param_name' => 'auto_play',
                                    'std' => 0,
                                    'value' => array(
                                        __('Yes, please', 'g5plus-handmade') => 1
                                    ),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),


                                array(
                                    "type" => "textfield",
                                    "heading" => __("AutoPlay Speed", 'g5plus-handmade'),
                                    "param_name" => "auto_play_speed",
                                    "value" => 5000,
                                    "description" => __('How much speed autoPlay (ms)', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'auto_play',
                                        'value' => array('1')
                                    ),
                                    'edit_field_class' => 'vc_col-sm-6 vc_column',
                                ),



                                array(
                                    'type' => 'dropdown',
                                    'heading' => __('Transition Style', 'g5plus-handmade'),
                                    'param_name' => 'transition_style',
                                    'value' => array(
                                        __('default', 'g5plus-handmade') => 'false',
                                        __('fade', 'g5plus-handmade') => 'fade',
                                        __('backSlide', 'g5plus-handmade') => 'backSlide',
                                        __('goDown', 'g5plus-handmade') => 'goDown',
                                        __('fadeUp', 'g5plus-handmade') => 'fadeUp'

                                    ),
                                    'std' => 'false',
                                    'description' => __('Select transition style for slider.', 'g5plus-handmade'),
                                    'dependency' => array(
                                        'element' => 'slider',
                                        'value' => array('slider')
                                    ),
                                ),
                                $add_el_class,
                                $add_css_animation,
                                $add_duration_animation,
                                $add_delay_animation
                            )
                        )
                    );


                }

	            vc_map(
		            array(
                        'name' => __('Handmade Google Map', 'g5plus-handmade'),
			            'base' => 'handmade_google_map',
			            'icon' => 'fa fa-map-marker',
			            'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
			            'params' => array(
				            array(
					            'type' => 'textfield',
                                'heading' => __('Marker title', 'g5plus-handmade'),
					            'param_name' => 'marker_title',
					            'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
				            ),
				            array(
					            'type' => 'textfield',
                                'heading' => __('Map height', 'g5plus-handmade'),
					            'param_name' => 'map_height',
					            'admin_label' => true,
					            'edit_field_class' => 'vc_col-sm-6',
                                'std' => '500px',
                                'description' => __('Set map height (px or %).', 'g5plus-handmade')
				            ),
				            array(
					            'type' => 'textfield',
                                'heading' => __('Location X', 'g5plus-handmade'),
					            'param_name' => 'location_x',
					            'admin_label' => true,
					            'edit_field_class' => 'vc_col-sm-6',
				            ),
				            array(
					            'type' => 'textfield',
                                'heading' => __('Location Y', 'g5plus-handmade'),
					            'param_name' => 'location_y',
					            'admin_label' => true,
					            'edit_field_class' => 'vc_col-sm-6',
				            ),
				            array(
					            'type' => 'number',
                                'heading' => __('Map zoom', 'g5plus-handmade'),
					            'param_name' => 'map_zoom',
					            'admin_label' => true,
					            'edit_field_class' => 'vc_col-sm-6',
					            'std' => '11',
					            'min' => '1',
					            'max' => '16',
				            ),
				            array(
					            'type' => 'dropdown',
                                'heading' => __('Map style', 'g5plus-handmade'),
					            'param_name' => 'map_style',
					            'admin_label' => true,
					            'edit_field_class' => 'vc_col-sm-6',
					            'std' => 'gray_scale',
					            'value' => array(
                                    __('None', 'g5plus-handmade') => 'none',
                                    __('Gray Scale', 'g5plus-handmade') => 'gray_scale',
                                    __('Icy Blue', 'g5plus-handmade') => 'icy_blue',
                                    __('Mono Green', 'g5plus-handmade') => 'mono_green',
					            )
				            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('API Url', 'g5plus-handmade'),
                                'param_name' => 'api_url',
                                'std' => 'http://maps.googleapis.com/maps/api/js?key=AIzaSyCSyxJHoDq9Ug4Y6CtYNbgLFAW-OacttnQ',
                            ),
				            $add_el_class,
				            $add_css_animation,
				            $add_duration_animation,
				            $add_delay_animation
			            )
		            )
	            );
                vc_map(array(
                    'name' => __('View Demo', 'g5plus-handmade'),
                    'base' => 'handmade_view_demo',
                    'class' => '',
                    'icon' => 'fa fa-eye',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => __('Image:', 'g5plus-handmade'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Text', 'g5plus-handmade'),
                            'param_name' => 'text',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => __('Link (url)', 'g5plus-handmade'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Is New', 'g5plus-handmade'),
                            'param_name' => 'is_new',
                            'description' => __('Is New Demo?', 'g5plus-handmade'),
                            'value' => array(__('Yes, please', 'g5plus-handmade') => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
            }
        }

    }

    if (!function_exists('init_g5plus_framework_shortcodes')) {
        function init_g5plus_framework_shortcodes()
        {
            return g5plusFramework_Shortcodes::init();
        }

        init_g5plus_framework_shortcodes();
    }
}