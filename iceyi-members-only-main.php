<?php
/**
*---------------------------------------------------------------------------------
*	@link			http://devuri.com
*	@package		iCeyi Members Only
*	@author 		devuri
*	@copyright  Copyright (c) 2016 , Uriel Wilson Jr. 
*---------------------------------------------------------------------------------
*
*	Plugin Name: iCeyi Members Only
*	Plugin URI: https://wordpress.org/plugins/iceyi-members-only/
*	Description: Provides shorcodes to protect content in posts and pages, simply place the protected content between these shortcodes [membersonly] protected content here [/membersonly] the user must be logged in to view. After they log in they will be redirected back to view the content.
*	Version: 4.0
*	Author: devuri
*	Author URI: http://devuri.com
*	Contributors:
*	License: GPLv2 or later
*	License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*	Text Domain: iceyi-members-only
*	Domain Path: /languages
*	Usage: Simple and easy to use, install and activate.
*	Tags:  member, members, profile, role, roles, shortcode, user, access, authentication, block, community, content, login, membership, password, permissions, register, registration, restriction, security, sirwil, iceyi, icelayer, jrpage, qweelo, members only,
*
*
*	
*	Copyright 2016 devuri	(email : devuriking@gmail.com)
*	License: GNU General Public License
*	GPLv2 Full license details in license.txt	
*	Contributors: icelayer, qweelo
*---------------------------------------------------------------------------------------------------------------------------------------------------------
*
*	iCeyi Members Only is built using the  http://wp.devuri.com/  QuickStart Plugin Builder{dc)} , (C) 2015- 2016 devuri.
*	QuickStart Plugin Builder is distributed under the terms of the GNU GPL v2 or later.
*
*	iCeyi Members Only , like WordPress, is licensed under the GPL.
*	Use it to make something cool, have fun, and share.	
*
*	iCeyi Members Only  is free software; you can redistribute it and/or
*	modify it under the terms of the GNU General Public License
*	as published by the Free Software Foundation; either version 2
*	of the License, or (at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with Devuri Plugin QuickStarter. If not, see http://www.gnu.org/licenses/
*---------------------------------------------------------------------------------------------------
*/


// * DIRECT ACCESS DENIED *
	if ( ! defined( "WPINC" ) ) { 
		die; 
	}
	
/*
*--------------------------------------------------------------------------------
*		 CONSTANTS
*/


	define("ICEYIMEMBERSONLY_DIR", dirname(__FILE__));
	define("ICEYIMEMBERSONLY_URL", plugins_url( "/",__FILE__ ));
	
	
	
/*
*--------------------------------------------------------------------------------
*		LANG STUFF
*/

	add_action( 'plugins_loaded', 'icde_textdomain' );
	
	function icde_textdomain() {
		load_plugin_textdomain( 'iceyi-members-only', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
	}
	
	
/*
*--------------------------------------------------------------------------------
*		 PLUGIN INFO 
*/
	
	// * VARS 
	function icde_info($plgn_info){
		
		$PluginName = "iCeyi Members Only";
		$Version = "3.0";
		$Description = "Provides shorcodes to protect content in posts and pages, simply place the protected content between these shortcodes [membersonly] protected content here [/membersonly] the user must be logged in to view.. ";
		$Author = "devuri";
		$AuthorURI = "http://devuri.com";
		$codepre = "icde";
		
		
		$pluginfo_atts = array (
			
				"name" 		=> $PluginName,
				"version" 	=> $Version,
				"description" 	=> $Description,
				"author"	=> $Author,
				"authoruri" => $AuthorURI,
				"codepre" => $codepre,
			);
		//	
		return $pluginfo_atts[$plgn_info];
	}
	
/*
*--------------------------------------------------------------------------------
*		 Settings Page
*/
	add_action('admin_menu', 'idce_settings_menu');
 
	function idce_settings_menu() {
		add_submenu_page(
			'options-general.php',
			'iCeyi Members Only Shortcode',
			'iMembers Only',
			'manage_options',
			'iceyi-members-only-settings',
			'idce_settings_page' );
	}		
//--------------- Admin MAIN Page ------------------------
	
		function idce_settings_page(){
				
				// header
				require_once(ICEYIMEMBERSONLY_DIR. "/_admin/head.php");	
				
				// page
				require_once(ICEYIMEMBERSONLY_DIR."/_admin/admin-page.php");
				
				// footer
				require_once(ICEYIMEMBERSONLY_DIR. "/_admin/footer.php");	

		}
/*
*--------------------------------------------------------------------------------
*		 EXTRA META LINKS
*/
	
	add_filter( 'plugin_row_meta', 'icde_row_meta', 10, 2 );
	
	function icde_row_meta( $links, $file ) {

		if ( strpos( $file, plugin_basename( __FILE__ )  ) !== false ) {
			$icde_addnew_links = array(
				'donate' => '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6D6W2KXB88NKE" target="_blank">Donate</a>',
               // 'docs' => '<a href="doc_url" target="_blank">Documentation</a>',
                'rate' => '<a href="https://wordpress.org/support/plugin/iceyi-members-only/reviews/?filter=5" target="_blank"><span class="dashicons dashicons-star-filled"></span> Rate</a>'
				);
		
		$links = array_merge( $links, $icde_addnew_links );
	}
	
		return $links;
	}
	
/*
*--------------------------------------------------------------------------------
*		SETTINGS LINK
*/
	
	
	
	add_filter( 'plugin_action_links', 'icde_settings_support_link', 10, 5 );
	function icde_settings_support_link( $actions, $plugin_file ) {
		static $icde_plugin;

		if (!isset($icde_plugin))
			$icde_plugin = plugin_basename(__FILE__);
		if ($icde_plugin == $plugin_file) {
			
			$support_link = array('support' => '<a style="color:green;" href="https://wordpress.org/support/plugin/iceyi-members-only" target="_blank" title="Get Support"> <span class="dashicons dashicons-businessman"></span> </a>');
			$settings = array('settings' => '<a href="options-general.php?page=iceyi-members-only-settings"  title="Update Settings"> ' . __('Settings', 'iceyi-members-only') . ' </a>');

		
				$actions = array_merge($settings, $actions);
				$actions = array_merge($support_link, $actions);
			
		}
		
		return $actions;
	}
   
   /*
    *--------------------------------------------------------------------------
    * Start Plugin Code Here
    *--------------------------------------------------------------------------
    */  
	
/*
*--------------------------------------------------------------------------------
*				[membersonly] protected [/membersonly] 
*/


	function membersonly_shortcode_iceyi( $atts, $content = null ) {

		ob_start();
		
		//...........................................................................................		
		if ( is_user_logged_in() ) {
			
			echo do_shortcode($content) ;
			
		} else { 
			
			echo ' You Must be logged in to view this content, <a href=" '. wp_login_url( get_permalink() ) . ' " title="Login Here ">Register or Login Here </a>' ;
		}/* // login check */;		
		
		//.............................................................................................
		$output_membersonly_obj = ob_get_contents(); 
		
		ob_end_clean();
		return $output_membersonly_obj;
	
	}
	
	add_shortcode( 'membersonly', 'membersonly_shortcode_iceyi' );


/*
*--------------------------------------------------------------------------------
*				[qw_members] protected [/qw_members] 
*/
	
	function members_qw( $atts, $content = null ) {

		ob_start();
		
		//...........................................................................................		
		if ( is_user_logged_in() ) {
			
			echo do_shortcode($content) ;
		
		} else { 
			
			echo ' You Must be logged in to view this content, <a href=" '. wp_login_url( get_permalink() ) . ' " title="Login Here ">Register or Login Here </a>' ;
		}/* // login check */;		
		
		//.............................................................................................
		$output_qw_members_obj = ob_get_contents(); 
		
		ob_end_clean();
		return $output_qw_members_obj;
	
	}
	
	
	add_shortcode( 'qw_members', 'members_qw' );
	