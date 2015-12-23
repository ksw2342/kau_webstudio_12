<?php 

function sn_skin_login_get_field($args, $i) {
	global $sn_skin_login_options, $post, $heading_i;

	if(isset($args['meta'])) { $option_meta = $args['meta']; } else { $option_meta = 0; }
	if(isset($args['type'])) { $field_type = $args['type']; } else { $field_type = "text"; }
	if(isset($args['name'])) { $field_name = $args['name']; } else { $field_name = ""; }
	if(isset($args['label'])) { $field_label = $args['label']; } else { $field_label = ""; }
	if(isset($args['default'])) { $field_default = $args['default']; } else { $field_default = ""; }
	if(isset($args['description'])) { $field_description = $args['description']; } else { $field_description = ""; }
	if(isset($args['choices'])) { $field_choices = $args['choices']; } else { $field_choices = ""; }
	if(isset($args['posttype'])) { $field_posttype = $args['posttype']; } else { $field_posttype = "post"; }
	if(isset($args['taxonomy'])) { $field_taxonomy = $args['taxonomy']; } else { $field_taxonomy = "category"; }
	if(isset($args['button_label'])) { $field_button_label = $args['button_label']; } else { $field_button_label = "Upload Image"; }
	
	if($option_meta) {
		$option_type = "meta";
		if(get_post_meta($post->ID, $field_name, true)) { $field_value = get_post_meta($post->ID, $field_name, true); } else { $field_value = ""; }
		$field_id = $field_name;
	} else {
		$option_type = "option";
		if(isset($sn_skin_login_options[$field_name])) { $field_value = $sn_skin_login_options[$field_name]; } else { $field_value = $field_default; }
		$field_id = 'sn_skin_login_options['.$field_name.']';
	}
	
	/* HEADING */  if($field_type == "heading") { $heading_i++; ?>
					
					<?php if($i != 1) { ?></table></div><!-- end tabpane --><?php } ?>
					<div class="tabpane">
					<table class="form-table">
						
						<!-- <div class="tabpane_heading">
							<h2 id="options_tab_<?php echo $heading_i; ?>"><?php echo $field_label; ?></h2>
							<p class="tabpane_description"><?php echo $field_description; ?></p>
						</div> -->
						<tr>
							<th></th>
							<td></td>
						</tr>
		
	<?php /* SUB HEADING */  } else if($field_type == "subheading") { ?>
					
					</table>
					
						<div class="options-sub-heading">
							<h4><?php echo $field_label; ?></h4>
							<?php if($field_description) {  ?><p><?php echo $field_description; ?></p><?php } ?>
						</div>
					
					<table class="form-table">
					
	<?php /* SPACE */   } else if($field_type == "space") { ?>
				
					<tr valign="top"><th scope="row" style="padding:0;font-size:1px;line-height:24px;">&nbsp;</th>
						<td style="padding:0;font-size:1px;line-height:24px">&nbsp;</td>
					</tr>
					
	<?php /* ACTUAL FIELDS */  } else { ?>
	
					<tr valign="top" class="<?php echo 'field_'.$field_name; ?>">
					<?php if($field_label == "&nbsp;" || $field_type == "export" || $field_type == "import") { ?>
						<td colspan="2">
					<?php } else { ?>
						<th scope="row"><?php echo $field_label; ?></th>
						<td>
					<?php } ?>
			
			<?php /* TEXT */ if($field_type == "text") { ?>
					
						<input id="<?php echo $field_id; ?>" class="regular-text" type="<?php echo $field_type; ?>" 
						name="<?php echo $field_id; ?>" value="<?php echo esc_attr_e($field_value); ?>" />
			
			<?php /* LOGIN STYLE */ } else if($field_type == "text_login_style") { ?>
					
						<input style="display:none" id="<?php echo $field_id; ?>" class="regular-text" type="<?php echo $field_type; ?>" name="<?php echo $field_id; ?>" value="<?php echo esc_attr_e($field_value); ?>" />
						
						<a href="#" class="login-style-1<?php if($field_value == 1) { echo ' active'; } ?>"><img src="<?php global $plugin_file; echo plugin_dir_url($plugin_file); ?>/images/login.jpg" alt="" width="200" /></a>&nbsp;&nbsp;&nbsp;
						<a href="#" class="login-style-2<?php if($field_value == 2) { echo ' active'; } ?>"><img src="<?php global $plugin_file; echo plugin_dir_url($plugin_file); ?>/images/login-2.png" alt="" width="200" /></a>
						
			
			<?php /* TEXTAREA */ } else if($field_type == "textarea") { ?>
			
						<textarea id="<?php echo $field_id; ?>" class="large-text" cols="50" rows="10" 
						name="<?php echo $field_id; ?>"><?php echo esc_textarea($field_value); ?></textarea><br/>
			
			<?php /* TEXTAREA */ } else if($field_type == "wpeditor") { ?>
						
						<?php $settings = array(
							'wpautop' => true, 
							'media_buttons' => false, 
							'quicktags' => false, 
							'textarea_rows' => '20'
						);
						wp_editor(esc_textarea($field_value), $field_id, $settings); ?>
									
			<?php /* CHECKBOX */ } else if($field_type == "checkbox") { ?>
				
						<input id="<?php echo $field_id; ?>" type="checkbox" value="1" 
						name="<?php echo $field_id; ?>" <?php if(isset($field_value)) { checked( '1', $field_value ); } ?> />
			
			<?php /* FILE UPLOAD */ } else if($field_type == "file") { ?>
			
						<input id="<?php echo $field_id; ?>" class="regular-text upload_url" type="text" 
						name="<?php echo $field_id; ?>" value="<?php esc_attr_e($field_value); ?>" />
						<div class="upload_buttons">
							<input type="button" 
							value="<?php if($field_button_label) { echo $field_button_label; } else { echo 'Upload Image'; } ?>" 
							class="button upload_button" rel="<?php if($post) { echo $post->ID; } else { echo '0'; } ?>" />
							<a href="#" class="remove_image">Remove</a>
						</div>
						<?php if($field_value) { ?>
						<div class="show-image"><img src="<?php echo $field_value; ?>" alt="" /></div>
						<?php } ?>
			
			<?php /* COLOUR PICKER */ } else if($field_type == "colorpicker") { ?>
					
						<div class="color-picker-container" style="position: relative;">
							<input id="<?php echo $field_id; ?>" class="regular-text color-picker-text" type="text" name="<?php echo $field_id; ?>" value="<?php echo esc_attr_e($field_value); ?>" />
							<div style="position: absolute;" class="color-picker-selector"></div>
					    </div>
						
			<?php /* RADIO BUTTONS */ } else if($field_type == "radio") { ?>
				
						<fieldset>
							<legend class="screen-reader-text"><span><?php echo $field_label; ?></span></legend>
							<?php
								if ( ! isset( $checked ) ) { $checked = ''; }
								foreach($field_choices as $option) {
									if ( '' != $field_value ) {
										if ( $field_value == $option['value'] ) {
											$checked = "checked=\"checked\"";
										} else {
											$checked = '';
										}
									}
									?>
									<label class="radio_description description">
										<input type="radio" value="<?php esc_attr_e( $option['value'] ); ?>" 
										name="<?php echo $field_id; ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?>
									</label><br />
									<?php
								}
							?>
						</fieldset>
			
			<?php /* SELECT */ } else if($field_type == "select") { ?>
				
						<select name="<?php echo $field_id; ?>">
							<?php foreach ( $field_choices as $option ) {
								$label = $option['label']; ?>
									<option <?php if($field_value == $option['value']) { ?>selected='selected'<?php } ?> 
									value='<?php echo  esc_attr( $option['value'] ); ?>'><?php echo $label; ?></option>
							<?php } ?>
						</select>
						
			<?php /* SELECT THEME */ } else if($field_type == "select_theme") { ?>
						
						<div class="sn_skin_login_themes_wrapper">
						
							<div class="themes-nav">
								<a href="#" class="button prev">&lt;</a>
								<a href="#" class="button next">&gt;</a>
							</div>
							<h2><?php _e('Choose a theme', 'snplugin'); ?></h2>
							
							<select name="<?php echo $field_id; ?>">
								<?php foreach ( $field_choices as $option ) {
									$label = $option['label']; ?>
										<option <?php if($field_value == $option['value']) { ?>selected='selected'<?php } ?> 
										value='<?php echo  esc_attr( $option['value'] ); ?>'><?php echo $label; ?></option>
								<?php } ?>
							</select>
							
							<ul class="sn_skin_login_themes">
							<?php
							global $sn_skin_login_directory;
							if($field_value) { } else { $do_first = 1; }
							$counter = 0;
							foreach ( $field_choices as $option ) {
									$counter++;
									$label = $option['label']; 
									if(isset($do_first)) {
										if($counter == 1) {
											$active = ' class="active"';
										} else { $active = ""; }
									} else {
										if($field_value == $option['value']) {
											$active = ' class="active"';
										} else { $active = ""; }
									}
									?>
								<li<?php echo $active; ?>><a href="<?php echo $sn_skin_login_directory; ?>/includes/themes/<?php echo $option['value']; ?>.css" id="<?php echo $option['value']; ?>"><img src="<?php echo $sn_skin_login_directory; ?>/includes/themes/<?php echo $option['value']; ?>.jpg" alt="" /></a></li>
							<?php } ?>
							</ul>
						
						</div>
						
			
			<?php /* IMPORT */ } else if($field_type == "import") { ?>
						
						<h3 style="margin-bottom:0px;">Export</h3>
						<p>Add the code you exported from another install and then click the Import button.</p>
						
						<input type="hidden" id="import_script_location" value="<?php global $sn_skin_login_directory; echo $sn_skin_login_directory; ?>/includes/premium/import.php" />
						<textarea id="import_text" class="large-text" style="height:200px" name="import_text"></textarea><br/>
						<input type="button" name="import_submit" id="import_submit" class="button" value="Import" />
					
			
			<?php /* EXPORT */ } else if($field_type == "export") { ?>
						
						<h3 style="margin-bottom:0px;">Export</h3>
						
						<p style="color:red">Please note, you must Save Changes before you copy this code.</p>
						
						<textarea id="<?php echo $field_id; ?>" class="large-text" style="height:200px" 
						name="<?php echo $field_id; ?>"><?php include('premium/export.php'); ?></textarea><br/>
						
					
			<?php /* SELECT TAXONOMY */ } else if($field_type == "select_taxonomy") { ?>
				
						<select name="<?php echo $field_id; ?>">
							<option value=""></option>
							<?php $list_terms = get_terms($field_taxonomy); 
								foreach ($list_terms as $list_term) { ?>
									<option <?php if($field_value == $list_term->term_id) { ?>selected='selected'<?php } ?> 
									value='<?php echo  esc_attr( $list_term->term_id ); ?>'><?php echo $list_term->name; ?></option>
							<?php } ?>
						</select>
			
			<?php /* SELECT POST */ } else if($field_type == "select_post") { ?>
				
						<select name="<?php echo $field_id; ?>">
							<option value=""></option>
							<?php $list_posts = get_posts('post_type='.$field_posttype.'&numberposts=-1&orderby=title&order=ASC'); 
								foreach ($list_posts as $list_post) { ?>
									<option <?php if($field_value == $list_post->ID) { ?>selected='selected'<?php } ?> 
									value='<?php echo  esc_attr( $list_post->ID ); ?>'><?php echo $list_post->post_title; ?></option>
							<?php } ?>
						</select>
			
			<?php } ?>
				
						<label class="<?php echo $field_type.'_description '; ?>description" for="<?php echo $field_id; ?>"><?php echo $field_description; ?></label>
						
					</td>
				</tr>
				
	<?php } /* End field checks */
	
}