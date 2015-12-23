<?php
/* Select and Radios Arrays */ 
$sn_skin_login_options_themes = array(
	'theme-1' => array(
		'value' => 'theme-1',
		'label' => __( 'Theme 1', 'snplugin' )
	),
	'theme-2' => array(
		'value' => 'theme-2',
		'label' => __( 'Theme 2', 'snplugin' )
	),
	'theme-3' => array(
		'value' => 'theme-3',
		'label' => __( 'Theme 3', 'snplugin' )
	),
	'theme-4' => array(
		'value' => 'theme-4',
		'label' => __( 'Theme 4', 'snplugin' )
	)
); 

/* Options Fields Array */
$sn_skin_login_options_fields = array(

array(	"label" => 				__( "General", 'snplugin' ), 
		"description" => 		"",
		"field" => 				"heading" ),
array(	"field" => 				"space" ),

array(	"label" => 				__( "Your Logo", 'snplugin' ), 
		"name" => 				"sn_skin_login_logo", 
		"default" =>			get_bloginfo('url')."/wp-admin/images/wordpress-logo.png",
		"description" => 		"",
		"field" => 				"file" ),	

array(	"label" => 				__( "Logo Width", 'snplugin' ), 
		"name" => 				"sn_skin_login_logo_width", 
		"default" => 			"274px",
		"description" => 		"",
		"field" => 				"text" ),

array(	"label" => 				__( "Logo Height", 'snplugin' ), 
		"name" => 				"sn_skin_login_logo_height", 
		"default" => 			"63px",
		"description" => 		"",
		"field" => 				"text" ),

array(	"label" => 				__( "Logo Link", 'snplugin' ), 
		"name" => 				"sn_skin_login_logo_link", 
		"default" => 			"",
		"description" => 		"",
		"field" => 				"text" ),

array(	"field" => 				"space" ),	

array(	"label" => 				__( "Background Colour", 'snplugin' ), 
		"name" => 				"sn_skin_login_background_colour", 
		"default" => 			"#FBFBFB",
		"description" => 		"",
		"field" => 				"colorpicker" ),

array(	"label" => 				__( "Background Image", 'snplugin' ), 
		"name" => 				"sn_skin_login_background_image", 
		"default" => 			"",
		"description" => 		"",
		"field" => 				"file" ),	

array(	"field" => 				"space" ),

array(	"label" => 				__( "Text Colour", 'snplugin' ), 
		"name" => 				"sn_skin_login_text_colour", 
		"default" => 			"#777777",
		"description" => 		"",
		"field" => 				"colorpicker" ),	

array(	"label" => 				__( "Link Colour", 'snplugin' ), 
		"name" => 				"sn_skin_login_link_colour", 
		"default" => 			"#21759B",
		"description" => 		"",
		"field" => 				"colorpicker" ),	

array(	"label" => 				__( "Button Colour", 'snplugin' ), 
		"name" => 				"sn_skin_login_button_colour", 
		"default" => 			"#21759B",
		"description" => 		"",
		"field" => 				"colorpicker" ),	

array(	"label" => 				__( "Button Border Colour", 'snplugin' ), 
		"name" => 				"sn_skin_login_button_border_colour", 
		"default" => 			"#298CBA",
		"description" => 		"",
		"field" => 				"colorpicker" ),

array(	"field" => 				"space" ),	

array(	"label" => 				__( "Theme CSS", 'snplugin' ), 
		"name" => 				"sn_skin_login_theme_css", 
		"default" => 			"",
		"description" => 		"",
		"field" => 				"textarea" ),

array(	"label" => 				__( "Custom CSS", 'snplugin' ), 
		"name" => 				"sn_skin_login_custom_css", 
		"default" => 			"",
		"description" => 		"<a href='#' class='view-diagram-link'>View diagram of element names</a>",
		"field" => 				"textarea" ),
		
array(	"label" => 				__( "Themes", 'snplugin' ), 
		"description" => 		"",
		"field" => 				"heading" ),	

array(	"label" => 				__( "&nbsp;", 'snplugin' ), 
		"name" => 				"sn_skin_login_theme", 
		"choices" => 			$sn_skin_login_options_themes,
		"description" => 		"",
		"field" => 				"select_theme" ),	
	
);