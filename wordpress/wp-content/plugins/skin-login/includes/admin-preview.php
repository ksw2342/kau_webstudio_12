<div class="sn_skin_login_preview">
	
	<h2>Preview</h2>
	<div class="switch-previews">
		<a href="#" class="switch-preview-login active">Login</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="#" class="switch-preview-register">Register</a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="#" class="switch-preview-forgot">Forgot Password</a>
	</div>

	<div class="added-styles">
		<div class="for-javascript">
		
		</div>
		<textarea></textarea>
	</div>
	
	<div class="classes-overlay">
	
	</div>

	<div class="sn_skin_login_preview_page sn_skin_login_preview_page_login login">
	
		<div id="login">
			<h1><a href="http://wordpress.org/" title="Powered by WordPress"><?php bloginfo('name'); ?></a></h1>
			<form name="loginform" id="loginform" action="<?php bloginfo('url'); ?>/wp-login.php" method="post">
				<p>
					<label for="user_login">Username<br />
					<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" autocomplete="off" /></label>
				</p>
				<p>
					<label for="user_pass">Password<br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" autocomplete="off" /></label>
				</p>
				<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Remember Me</label></p>
				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100" />
				</p>
			</form>
	
			<p id="nav">
				<a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a>
			</p>
	
			<p id="backtoblog"><a href="<?php bloginfo('url'); ?>" title="Are you lost?">&larr; Back to <?php bloginfo('name'); ?></a></p>
		
		</div>
	
	</div>
	<!-- end login page preview -->
	


	<div class="sn_skin_login_preview_page sn_skin_login_preview_page_register login">
		
		<div id="login">
			<h1><a href="http://wordpress.org/" title="Powered by WordPress"><?php bloginfo('name'); ?></a></h1>
			<p class="message register">Register For This Site</p>
	
			<form name="registerform" id="registerform" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post">
				<p>
					<label for="user_login">Username<br />
					<input type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
				</p>
				<p>
					<label for="user_email">E-mail<br />
					<input type="email" name="user_email" id="user_email" class="input" value="" size="25" tabindex="20" /></label>
				</p>
				<p id="reg_passmail">A password will be e-mailed to you.</p>
				<br class="clear" />
				<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Register" tabindex="100" /></p>
			</form>
	
			<p id="nav">
				<a href="<?php bloginfo('url'); ?>/wp-login.php">Log in</a> |
				<a href="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Lost your password?</a>
			</p>
	
			<p id="backtoblog"><a href="<?php bloginfo('url'); ?>" title="Are you lost?">&larr; Back to <?php bloginfo('name'); ?></a></p>
		
		</div>
	
	</div>
	<!-- end register page preview -->
	


	<div class="sn_skin_login_preview_page sn_skin_login_preview_page_forgot login">
			
		<div id="login">
			<h1><a href="http://wordpress.org/" title="Powered by WordPress"><?php bloginfo('name'); ?></a></h1>
			<p class="message">Please enter your username or email address. You will receive a link to create a new password via email.</p>
	
			<form name="lostpasswordform" id="lostpasswordform" action="<?php bloginfo('url'); ?>/wp-login.php?action=lostpassword" method="post">
				<p>
					<label for="user_login" >Username or E-mail:<br />
					<input type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
				</p>
				<input type="hidden" name="redirect_to" value="" />
				<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Get New Password" tabindex="100" /></p>
			</form>
		
			<p id="nav">
				<a href="<?php bloginfo('url'); ?>/wp-login.php">Log in</a>
				 | <a href="<?php bloginfo('url'); ?>/wp-login.php?action=register">Register</a>
			</p>
		
			<p id="backtoblog"><a href="<?php bloginfo('url'); ?>" title="Are you lost?">&larr; Back to <?php bloginfo('name'); ?></a></p>
		
		</div>
	
	</div>
	<!-- end forgot password preview -->
			
			
</div>