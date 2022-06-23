<?php

/* 
 *	Custom Options via ACF Pro v5 
 *	https://www.advancedcustomfields.com/resources/options-page/
 */

if( function_exists('acf_add_options_page') ) {

	//https://www.advancedcustomfields.com/resources/acf_add_options_page/

	acf_add_options_page(array(
		'page_title' => __('Ustawienia zaawansowane'),
		'menu_slug' => 'theme-settings',
		'icon_url' => 'dashicons-admin-generic'
		//'redirect' => false,
	));


}
