<?php
/*
Plugin Name: Skin Login
Plugin URI: http://simonmakes.com/plugins/skin-login/
Description: Allows you to skin the login form.
Version: 1.2
Author: Simon North
Author URI: http://simonmakes.com

/* Variables */
$sn_skin_login_options = get_option('sn_skin_login_options');
$sn_skin_login_path = dirname(__FILE__);
$sn_skin_login_main_file = dirname(__FILE__).'/skin-login.php';
$sn_skin_login_directory = plugin_dir_url($sn_skin_login_main_file);

/* Includes */
include('includes/admin-page.php');

/* Skin the login */
function sn_skin_login_css_styles() {
	global $sn_skin_login_options, $sn_skin_login_directory;
	remove_action('login_head', 'wp_shake_js', 12);

		if($sn_skin_login_options['sn_skin_login_background_image']) {
			$style_background_image = 'body.login { background: url('.$sn_skin_login_options['sn_skin_login_background_image'].') no-repeat center top; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; }';
		} else { $style_background_image = ""; }
			$style_background_colour = 'html, body.login { background-color: '.$sn_skin_login_options['sn_skin_login_background_colour'].'; color: '.$sn_skin_login_options['sn_skin_login_text_colour'].'; }';
			$style_logo = '.login h1 a { background-image: url('.$sn_skin_login_options['sn_skin_login_logo'].'); background-repeat: no-repeat; background-position: center top; background-size: '.$sn_skin_login_options['sn_skin_login_logo_width'].' '.$sn_skin_login_options['sn_skin_login_logo_height'].'; height: '.$sn_skin_login_options['sn_skin_login_logo_height'].'; }';
			$style_text_colour = '.login label { color: '.$sn_skin_login_options['sn_skin_login_text_colour'].'; }';
			$style_link_colour = '.login a, .login #nav a, .login #backtoblog a, .login a:hover, .login #nav a:hover, .login #backtoblog a:hover { color: '.$sn_skin_login_options['sn_skin_login_link_colour'].'!important; text-shadow: none; }';
			
			$style_button_colour = '.login #wp-submit { background: url('.$sn_skin_login_directory.'includes/themes/button-overlay.png) repeat-x scroll left top '.$sn_skin_login_options['sn_skin_login_button_colour'].'!important; }';
			$style_button_border_colour = '.login #wp-submit { border-color: '.$sn_skin_login_options['sn_skin_login_button_border_colour'].'!important; }';
		
			$style_theme_css = $sn_skin_login_options['sn_skin_login_theme_css'];
			$style_custom_css = $sn_skin_login_options['sn_skin_login_custom_css'];
			
		$sn_skin_login_css = $style_background_image.$style_background_colour.$style_logo.$style_text_colour.$style_link_colour.$style_button_colour.$style_button_border_colour.$style_theme_css.$style_custom_css;
		
?>
	<style type="text/css">
		<?php echo $sn_skin_login_css; ?>
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'sn_skin_login_css_styles' );