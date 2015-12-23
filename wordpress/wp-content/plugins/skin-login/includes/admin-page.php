<?php

add_action( 'admin_init', 'sn_skin_login_options_init' );
add_action( 'admin_menu', 'sn_skin_login_options_add_page' );

/* Initialise the options */
function sn_skin_login_options_init(){
	register_setting( 'sn_skin_login_options_group', 'sn_skin_login_options', '' );
}

/* Add options page to Settings Menu */
function sn_skin_login_options_add_page() {
	add_options_page( __( 'Skin Login', 'snplugin' ), __( 'Skin Login', 'snplugin' ), 'manage_options', 'skin_options', 'sn_skin_login_options_do_page' );
}

/* Bring in the theme options fields */
require_once (dirname(__FILE__).'/admin-options.php');

/* Create the options page */
function sn_skin_login_options_do_page() {
	global $sn_skin_login_options_fields;
	
	/* Include the fields file */
	require_once (dirname(__FILE__).'/admin-fields.php');
	
	/* Enqueue some scripts */
	global $sn_skin_login_directory;
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
    wp_enqueue_style('farbtastic');
    wp_enqueue_script('farbtastic');
	wp_enqueue_style('admin_css', $sn_skin_login_directory.'/includes/scripts/admin.css');
    wp_register_script('admin_js', $sn_skin_login_directory.'/includes/scripts/admin.js');
	wp_enqueue_script('admin_js');
	
	
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	/* Now make the options form */
	?>
	<div class="wrap sn_plugin_options_wrap">
	
		<?php
		/* Theme Options Tabs and Heading */
		screen_icon(); ?><h2 class="nav-tab-wrapper">Skin Login&nbsp;
		<?php /* Loop through options array to get the heading tabs */
		$heading_i = 0; $i = 0; foreach($sn_skin_login_options_fields as $options_field) {
			if($options_field['field'] == "heading") { $i++;
				if($i == 1) { $nav_tab_classes = "nav-tab nav-tab-active"; } else { $nav_tab_classes = "nav-tab"; }
				echo '<a href="#options_tab_'.$i.'" class="' . $nav_tab_classes . '">' . $options_field['label'] . "</a>";
		} } ?>
		</h2>
		
		<input type="hidden" class="sn_skin_login_themes_dir" value="<?php echo $sn_skin_login_directory.'/includes/themes/'; ?>" />
		
		
		<?php include_once('admin-preview.php'); ?>		

		<form method="post" action="options.php" class="sn_plugin_options_form">
			<?php settings_fields( 'sn_skin_login_options_group' ); ?>
			<?php $options = get_option( 'sn_skin_login_options' ); ?>
			
			<?php 
			/* Loop through the options array */
			$i = 0; foreach($sn_skin_login_options_fields as $options_field) { $i++;
			
				/* Get field settings from array */
				$field_args = array();
				
				if(isset($options_field['field'])) { $field_args['type'] = $options_field['field']; }
				if(isset($options_field['label'])) { $field_args['label'] = $options_field['label']; }
				if(isset($options_field['name'])) { $field_args['name'] = $options_field['name']; }
				if(isset($options_field['default'])) { $field_args['default'] = $options_field['default']; }
				if(isset($options_field['description'])) { $field_args['description'] = $options_field['description']; }
				if(isset($options_field['choices'])) { $field_args['choices'] = $options_field['choices']; }
				if(isset($options_field['taxonomy'])) { $field_args['taxonomy'] = $options_field['taxonomy']; }
				if(isset($options_field['posttype'])) { $field_args['posttype'] = $options_field['posttype']; }
				if(isset($options_field['taxonomy'])) { $field_args['taxonomy'] = $options_field['taxonomy']; }
				if(isset($options_field['button_label'])) { $field_args['button_label'] = $options_field['button_label']; }
				
				/* Get the field (includes/admin/fields.php) */
				sn_skin_login_get_field($field_args, $i); 
			
			} ?>
			
			</table></div><!-- end tabpane -->
			
			<div class="upgrade-notice">
				<h4>The pro version...</h4>
				<p>Upgrade to the pro version for <a target="_blank" href="<?php echo $sn_skin_login_directory; ?>/includes/themes/upgrade-prev.jpg">6 pre-built designs</a> to make your login forms look great, and <a href="<?php echo $sn_skin_login_directory; ?>/includes/themes/upgrade-import.jpg" target="_blank">import/export options</a> to make it easy to set up your branding on multiple websites.<br/><a style="margin-top:5px;display:inline-block;" target="_blank" href="http://simnorlabs.com/project/skin-login-pro/">More Details</a></p>
			</div>
		
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'snplugin' ); ?>" />
			</p>
		</form>
		</div>
			
	
	<?php
}