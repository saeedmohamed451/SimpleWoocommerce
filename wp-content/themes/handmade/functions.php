<?php
define( 'HOME_URL', trailingslashit( home_url() ) );
define( 'THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'THEME_URL', trailingslashit( get_template_directory_uri() ) );

if (!function_exists('g5plus_include_theme_options')) {
	function g5plus_include_theme_options() {
		if (!class_exists( 'ReduxFramework' )) {
			require_once( THEME_DIR . 'g5plus-framework/options/framework.php' );
		}
		require_once( THEME_DIR . 'g5plus-framework/option-extensions/loader.php' );
		require_once( THEME_DIR . 'includes/options-config.php' );

		global $g5plus_handmade_options, $g5plus_options;
		$g5plus_options = $g5plus_handmade_options;
	}
	g5plus_include_theme_options();
}
function g5plus_check_vc_status() {
    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if(is_plugin_active('js_composer/js_composer.php')) {
        return true;
    }
    else{
        return false;
    }
}

if (!function_exists('g5plus_include_library')) {
	function g5plus_include_library() {
        require_once(THEME_DIR . 'g5plus-framework/g5plus-framework.php');
		require_once(THEME_DIR . 'includes/register-require-plugin.php');
		require_once(THEME_DIR . 'includes/theme-setup.php');
		require_once(THEME_DIR . 'includes/sidebar.php');
		require_once(THEME_DIR . 'includes/meta-boxes.php');
		require_once(THEME_DIR . 'includes/admin-enqueue.php');
		require_once(THEME_DIR . 'includes/theme-functions.php');
		require_once(THEME_DIR . 'includes/theme-action.php');
		require_once(THEME_DIR . 'includes/theme-filter.php');
		require_once(THEME_DIR . 'includes/frontend-enqueue.php');
		require_once(THEME_DIR . 'includes/tax-meta.php');

        if( g5plus_check_vc_status() == true) {
            require_once(THEME_DIR . 'includes/vc-functions.php');
        }
    }
	g5plus_include_library();
}
wp_enqueue_style( 'custom-css', get_template_directory_uri().'/assets/css/custom.css', array(), '1.0.0', true  );

function custom_my_account_menu_items( $items ) {
    /*unset($items['downloads']);
    //$items['dashboard'] = 'My Account';
    //set($items['dashboard']);
    $items['dashboard'] = 'My Account';
    $items['edit-account'] = 'About you';
    $items['edit-address'] = 'Address book';*/

    $items = array(
        'dashboard'       => __( 'My Account', 'woocommerce' ),
        'edit-account'    => __( 'About you', 'woocommerce' ),
        'edit-address'    => __( 'Address book', 'woocommerce' ),
        'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        'orders'          => __( 'Orders', 'woocommerce' ),
        //'downloads'       => __( 'Downloads', 'woocommerce' ),
        '#' => __( 'Password Change', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );

add_action('wp_logout','logout_redirect');

function logout_redirect(){
    wp_redirect( home_url() );
    exit;
}
