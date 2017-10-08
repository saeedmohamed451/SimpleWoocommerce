<?php
/*---------------------------------------------------
/* THEME ADD ACTION
/*---------------------------------------------------*/

/*---------------------------------------------------
/* CUSTOM HEADER CSS
/*---------------------------------------------------*/
if (!function_exists('g5plus_custom_header_css')) {
	function g5plus_custom_header_css() {
		$page_id = '0';
		if (isset($_REQUEST['current_page_id'])) {
			$page_id = $_REQUEST['current_page_id'];
		}

		$css_variable = g5plus_custom_css_variable($page_id);

		if (!class_exists('Less_Parser')) {
			require_once THEME_DIR . 'g5plus-framework/less/Autoloader.php';
			Less_Autoloader::register();
		}
		$parser = new Less_Parser(array( 'compress'=>true ));

		$parser->parse($css_variable, THEME_URL);
		$parser->parseFile( THEME_DIR . 'assets/css/less/variable.less', THEME_URL );
		$parser->parseFile( THEME_DIR . 'assets/css/less/header-customize.less', THEME_URL );
		$parser->parseFile( THEME_DIR . 'assets/css/less/footer-customize.less', THEME_URL );

		$prefix = 'g5plus_';
		$enable_page_color = rwmb_meta($prefix . 'enable_page_color', array(), $page_id);
		if ($enable_page_color == '1') {
			$parser->parseFile( THEME_DIR . 'assets/css/less/color.less' );
		}

		$css = $parser->getCss();
		header("Content-type: text/css; charset: UTF-8");
		echo sprintf('%s', $css);
	}
	add_action('custom-page/header-custom-css', 'g5plus_custom_header_css');
}





