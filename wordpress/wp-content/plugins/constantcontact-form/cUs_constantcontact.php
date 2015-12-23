<?php
/*
  Plugin Name: Constant Contact Signup Form by ContactUs
  Plugin URI:  http://help.contactus.com/entries/24886721-Adding-the-Constant-Contact-Form-Plugin-for-WordPress
  Description: The Constant Contact Signup Form Plugin by ContactUs.com
  Author: contactus.com
  Version: 3.0
  Author URI: http://www.contactus.com/
  License: GPLv2 or later
*/

/*
  Copyright 2014  ContactUs.com  ( help.contacus.com )
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//INCLUDE WP HOOKS ACTIONS & FUNCTIONS
require_once( dirname(__FILE__) . '/cUs_constantcontact_conf.php' );

//INCLUDE WP HOOKS ACTIONS & FUNCTIONS
require_once( dirname(__FILE__) . '/helpers/cUs_constantcontact_functions.php' );

/*
 * Method in charge to render plugin layout
 * @since 1.0
 * @return string Render HTML layout into WP admin
 */
if (!function_exists('cUs_CtCt_menu_render')) {

    function cUs_CtCt_menu_render() {

        //cUs_CtCt_plugin_db_uninstall();
        $aryUserCredentials = get_option('cUs_CtCt_settings_userCredentials'); //get the values, wont work the first time

        ?>
        <div id="cu_plugin-container">
            <?php
                /*
                * PLUGIN HEADER
                * @since 5.0
                */
                require_once( cUs_CtCt_DIR . 'views/header.php');
            ?>

            <?php
                if(!empty($aryUserCredentials) && is_array($aryUserCredentials)) {
                    require_once( cUs_CtCt_DIR . 'views/priv-uix.php');
                }else{
                    require_once( cUs_CtCt_DIR . 'views/pub-uix.php');
                }
            ?>

        </div>

    <?php
    } //cUs_CtCt_menu_render ends

} // END IF FUNCTION RENDER