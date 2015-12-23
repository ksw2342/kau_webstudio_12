jQuery(document).ready(function() {

/* Options Panel Tabs */
var tabtoshow = 0;
if(jQuery('.sn_plugin_options_wrap').hasClass('sn_plugin_options_wrap')) {
	jQuery('.sn_plugin_options_wrap .tabpane').hide();
	jQuery('.sn_plugin_options_wrap .tabpane').eq(0).show();
	jQuery('.sn_plugin_options_wrap h2.nav-tab-wrapper a').click(function() {
		tabtoshow = jQuery(this).parent('h2.nav-tab-wrapper').find('a').index(jQuery(this));
		jQuery('.sn_plugin_options_wrap h2.nav-tab-wrapper a').removeClass('nav-tab-active');
		jQuery('.sn_plugin_options_wrap h2.nav-tab-wrapper a').eq(tabtoshow).addClass('nav-tab-active');
		jQuery('.sn_plugin_options_wrap .tabpane').hide();
		jQuery('.sn_plugin_options_wrap .tabpane').eq(tabtoshow).show();
		return false;
	});
}

/* Colour Picker */
	if(jQuery('.color-picker-selector').hasClass('color-picker-selector')) {
		jQuery('.color-picker-selector').hide();
		jQuery('.color-picker-selector').each(function() {
			jQuery(this).farbtastic(jQuery(this).parent('div').find('input.color-picker-text'));
		});
		jQuery('input.color-picker-text').focus(function() {
			jQuery(this).parent('div').find('.color-picker-selector').fadeIn();
		});
		jQuery(document).mousedown(function() { jQuery('.color-picker-selector').fadeOut(); });
	}


/* Upload Field */
	jQuery('.upload_url').blur(function() {
		jQuery(this).parent('td').find('.show-image').remove();
		jQuery(this).parent('td').append('<div class="show-image"><img src="'+jQuery(this).val()+'" alt="" /></div>');
	});
	jQuery('.upload_button').click(function() {
	
		var field_id    = jQuery(this).parent('div').parent('td').find('.upload_url').attr('name'),
		    post_id     = jQuery(this).attr('rel'),
		    backup      = window.send_to_editor,
		    showImageHTML  = '',
		    intval      = window.setInterval(function() {
		                    jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use this image'); 
		                    jQuery('#TB_iframeContent').contents().find('.savesend .button').addClass('button-primary'); 
		                    jQuery('#TB_iframeContent').contents().find('.savesend .button').css({"marginTop":"10px", "marginBottom":"20px"}); 
		                  }, 50);
		tb_show('', 'media-upload.php?post_id='+post_id+'&field_id='+field_id+'&type=image&TB_iframe=1');
		window.send_to_editor = function(html) {
		  var href = jQuery(html).attr('href');
		  var href_filename = href.substr( (href.lastIndexOf('.') +1) );
		  switch(href_filename) {
			case 'jpeg':
			case 'jpg':
			case 'png':
			case 'gif':
				showImageHTML += '<div class="show-image"><img src="'+href+'" alt="" /></div>';
			break;
		  }
		  jQuery('input[name="'+field_id+'"]').val(href);
		  jQuery('input[name="'+field_id+'"]').parent('td').find('.show-image').remove();
		  jQuery('input[name="'+field_id+'"]').parent('td').append(showImageHTML);
		  change_preview();
		  tb_remove();
		  window.clearInterval(intval);
		  window.send_to_editor = backup;
		    };
		return false;
	
	});
		      
	jQuery('.upload_buttons .remove_image').click(function() {
		jQuery(this).parent('div').parent('td').find('.upload_url').attr({'value':''})
		jQuery(this).parent('div').parent('td').find('.show-image').remove();
		change_preview();
		return false;
	});

/* Switch Previews */
	var preview_to_show = 0;
	jQuery('.switch-previews a').click(function() {
		if(jQuery(this).hasClass('active')) { } else {
			preview_to_show = jQuery('.switch-previews a').index(jQuery(this));
			jQuery('.switch-previews a').removeClass('active');
			jQuery('.switch-previews a').eq(preview_to_show).addClass('active');
			jQuery('.sn_skin_login_preview_page').not(preview_to_show).fadeOut();
			jQuery('.sn_skin_login_preview_page').eq(preview_to_show).fadeIn();
			
			
			if(jQuery('.classes-overlay').is(':visible')) {
				jQuery('.classes-overlay').css({"opacity": 0});
				setTimeout(function() {
					jQuery('.classes-overlay').css({"opacity": 1});
					show_overlay_classes();
				}, 1000);
			}

		}
		return false;
	});

/* Show Elements on preivew */
	function show_overlay_classes() {
		var note_position_left;
		var note_position_top;
		var note_position_width;
		var note_position_height;
		var preview_left_pos = jQuery('.sn_skin_login_preview').offset().left;
		var preview_top_pos = jQuery('.sn_skin_login_preview').offset().top + 58;
		jQuery('.sn_skin_login_preview .classes-overlay').html('');
		jQuery('.sn_skin_login_preview .classes-overlay').fadeIn();
		/* Login */
		note_position_left = "0px";
		note_position_top = "0px";
		note_position_width = "100%";
		note_position_height = "100%";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login</div></div></div>');
		
		/* Login ID */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('#login').css('marginLeft');
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('#login').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('#login').outerWidth() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('#login').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login</div></div></div>');
		
		/* Login h1 */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1').offset().left - preview_left_pos + "px";
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1').outerWidth() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login h1</div></div></div>');
		
		/* Login h1 a */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1 a').offset().left - preview_left_pos + "px";
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1 a').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1 a').width() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('h1 a').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login h1 a</div></div></div>');
		
		/* Login Form */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('form').offset().left - preview_left_pos + "px";
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('form').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('form').outerWidth() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('form').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login form</div></div></div>');
		
		/* p#nav */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#nav').offset().left - preview_left_pos + "px";
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#nav').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#nav').outerWidth() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#nav').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login p#nav</div></div></div>');
		
		/* p#backtoblog */
		note_position_left = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#backtoblog').offset().left - preview_left_pos + "px";
		note_position_top = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#backtoblog').offset().top - preview_top_pos + "px";
		note_position_width = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#backtoblog').outerWidth() + "px";
		note_position_height = jQuery('.sn_skin_login_preview .sn_skin_login_preview_page').eq(preview_to_show).find('p#backtoblog').outerHeight() + "px";
		jQuery('.sn_skin_login_preview .classes-overlay').append('<div class="note" style="top:'+note_position_top+';left:'+note_position_left+';width:'+note_position_width+';height:'+note_position_height+';"><span class="dot"></span><div class="grid"><div class="label">.login #login p#backtoblog</div></div></div>');
	
	}
	jQuery('.view-diagram-link').click(function() {
		if(jQuery('.classes-overlay').is(':visible')) {
			jQuery(this).text('View diagram of element names');
			jQuery('.sn_skin_login_preview .classes-overlay').fadeOut();
		} else {
			jQuery(this).text('Hide diagram of element names');
			show_overlay_classes();
		}
		return false;	
	});
	
	/* Hover on dots */
	jQuery('.note .dot').live('mouseover', function() {
		jQuery(this).parent('.note').find('.grid').fadeIn();
	});
	jQuery('.note .dot').live('mouseleave', function() {
		jQuery(this).parent('.note').find('.grid').fadeOut();
	});
	jQuery('.note .label').live('mouseover', function() {
		jQuery(this).parent('.grid').show();
	});

/* Change Preview */
	var style_background_image = "";
	var style_background_colour = "";
	var style_logo = "";
	var style_logo_width = "274px";
	var style_logo_height = "67px";
	var style_text_colour = "";
	var style_link_colour = "";
	var style_button_colour = "";
	var style_button_border_colour = "";
	var style_theme_css = "";
	var style_theme_to_use = jQuery('.field_sn_skin_login_theme select option:selected').val();
	var style_custom_css = "";
	
	var styles_to_output = "";
	var styles_to_output_for_js = "";
	function add_new_styles() {
		/* Background Image */
		if(jQuery('.field_sn_skin_login_background_image input[type="text"]').val() != '') {
			style_background_image = '.login { background: url('+jQuery('.field_sn_skin_login_background_image input[type="text"]').val()+') no-repeat center top; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; }';
		} else { style_background_image = ''; }
		/* Background Colour */
		style_background_colour = '.login { background-color: '+jQuery('.field_sn_skin_login_background_colour td input[type="text"]').val()+'; color: '+jQuery('.field_sn_skin_login_text_colour input[type="text"]').val()+'; }';
		/* Logo */
		style_logo = '.login h1 a { background-image: url('+jQuery('.field_sn_skin_login_logo td input[type="text"]').val()+'); background-repeat: no-repeat; background-position: center top; background-size: '+style_logo_width+' '+style_logo_height+'; height: '+style_logo_height+'; }';
		jQuery('tr.field_sn_skin_login_logo_width input[type="text"]').val(style_logo_width);
		jQuery('tr.field_sn_skin_login_logo_height input[type="text"]').val(style_logo_height);
		/* Text Colour */
		style_text_colour = '.login label { color: '+jQuery('.field_sn_skin_login_text_colour input[type="text"]').val()+'; }';
		/* Link Colour */
		style_link_colour = '.login a, .login #nav a, .login #backtoblog a, .login a:hover, .login #nav a:hover, .login #backtoblog a:hover { color: '+jQuery('.field_sn_skin_login_link_colour input[type="text"]').val()+'!important; text-shadow: none; }';
		/* Button Colour */
		style_button_colour = '.login #wp-submit { background: url('+jQuery('input.sn_skin_login_themes_dir').val()+'button-overlay.png) repeat-x scroll left top '+jQuery('.field_sn_skin_login_button_colour input[type="text"]').val()+'!important; }';
		style_button_border_colour = '.login #wp-submit { border-color: '+jQuery('.field_sn_skin_login_button_border_colour input[type="text"]').val()+'!important; }';
		/* Theme CSS */
		style_theme_css = jQuery('.field_sn_skin_login_theme_css textarea').val();
		/* Custom CSS */
		style_custom_css = jQuery('.field_sn_skin_login_custom_css textarea').val();
		
		/* Bring them altogether */
		styles_to_output = style_background_image+' '+style_background_colour+' '+style_logo+' '+style_text_colour+' '+style_link_colour+' '+style_button_colour+' '+style_button_border_colour+' '+style_theme_css+' '+style_custom_css;
		styles_to_output_for_js = '<style type="text/css">'+styles_to_output+'</style>';
		
		jQuery('.sn_skin_login_preview .added-styles .for-javascript').html(styles_to_output_for_js);
		jQuery('.sn_skin_login_preview .added-styles textarea').val(styles_to_output);

	}
	function change_preview() {
		setTimeout(function() {
			jQuery('.field_sn_skin_login_background_image .show-image img').each(function() {
				if(this.complete) {
					add_new_styles();
				} else {
					jQuery(this).load(function() {
						add_new_styles();
					});
				}
			});
			jQuery('.field_sn_skin_login_logo .show-image img').each(function() {
				if(jQuery(this).is(':visible')) {
					if(this.complete) {
						style_logo_height = jQuery(this).height() + "px";
						style_logo_width = jQuery(this).width() + "px";
						add_new_styles();
					} else {
						jQuery(this).load(function() {
							style_logo_height = jQuery(this).height() + "px";
							style_logo_width = jQuery(this).width() + "px";
							add_new_styles();
						});
					}
				}
			});
			if(jQuery('.field_sn_skin_login_logo .show-image img').size() < 1) {
				style_logo_height = "0px";
				style_logo_width = "0px";
			}
			add_new_styles();
		}, 300);
	}
	
	/* Action to be performed */
	jQuery('.field_sn_skin_login_logo input[type="text"], .field_sn_skin_login_background_image input[type="text"], .field_sn_skin_login_background_colour input[type="text"], .field_sn_skin_login_text_colour input[type="text"], .field_sn_skin_login_link_colour input[type="text"], .field_sn_skin_login_button_colour input[type="text"], .field_sn_skin_login_button_border_colour input[type="text"], .field_sn_skin_login_theme_css textarea, .field_sn_skin_login_custom_css textarea, .show-image img').bind("load change blur keyup onpaste focus", function() {
		change_preview();
	});
	jQuery(window).load(function() {
		change_preview();
		setTimeout(function() {
			jQuery('.sn_skin_login_preview_page').hide();
			jQuery('.sn_skin_login_preview_page:first').fadeIn();
		}, 400);
	});
	
	/* Applied Theme */
	function change_login_theme() {
		jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li').removeClass('active').hide();
		jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li a#'+style_theme_to_use).parent('li').addClass('active').fadeIn(200);
		jQuery.ajax({
			url: jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li a#'+style_theme_to_use).attr('href'),
		    cache: false,
		}).done(function(returned) { 
			returned = returned.replace('icons.png', jQuery('input.sn_skin_login_themes_dir').val()+'icons.png');
			returned = returned.replace('icons-w-back.png', jQuery('input.sn_skin_login_themes_dir').val()+'icons-w-back.png');
			jQuery('.field_sn_skin_login_theme_css textarea').val(returned);
		});
		change_preview();
		if(jQuery('.classes-overlay').is(':visible')) {
			jQuery('.classes-overlay').css({"opacity": 0});
			setTimeout(function() {
				show_overlay_classes();
				jQuery('.classes-overlay').animate({"opacity": 1});
			}, 1000);
		}
	}
	var style_theme_to_use_nav = jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li').index(jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li.active'));
	jQuery('.sn_skin_login_themes_wrapper .themes-nav a.next').click(function() {
		style_theme_to_use_nav++;
		if(style_theme_to_use_nav >= jQuery('.field_sn_skin_login_theme select option').size()) {
			style_theme_to_use_nav = 0;
		}
		style_theme_to_use = style_theme_to_use_nav + 1;
		style_theme_to_use = 'theme-'+style_theme_to_use;
		jQuery('.field_sn_skin_login_theme select').val(style_theme_to_use);
		change_login_theme();
		return false;
	});
	jQuery('.sn_skin_login_themes_wrapper .themes-nav a.prev').click(function() {
		style_theme_to_use_nav = style_theme_to_use_nav - 1;
		if(style_theme_to_use_nav <= -1) {
			style_theme_to_use_nav = jQuery('.field_sn_skin_login_theme select option').size() - 1;
		}
		style_theme_to_use = style_theme_to_use_nav + 1;
		style_theme_to_use = 'theme-'+style_theme_to_use;
		jQuery('.field_sn_skin_login_theme select').val(style_theme_to_use);
		change_login_theme();
		return false;
	});
	jQuery('.field_sn_skin_login_theme .sn_skin_login_themes li a').click(function() {
		jQuery('.field_sn_skin_login_theme select').val(jQuery(this).attr('id'));
		style_theme_to_use = jQuery(this).attr('id');
		change_login_theme();
		return false;
	});
	jQuery('.field_sn_skin_login_theme select').change(function() {
		style_theme_to_use = jQuery(this).val();
		style_theme_to_use_nav = style_theme_to_use.replace('theme-', '');
		style_theme_to_use_nav = style_theme_to_use_nav - 1;
		change_login_theme();
		return false;
	});
	
	
});