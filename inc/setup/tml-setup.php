<?php
/**
 * Customizations for Theme My Login plugin. 
 * https://github.com/theme-my-login/theme-my-login
 * 
 * This file is loaded via theme-my-login-custom.php, see:
 * https://docs.thememylogin.com/article/63-using-theme-my-login-custom-php
 * 
 **/


/**
 * Deregister js scripts which are used for AJAX validation and Password Strength, but are dependant on jQuery
 */
function deregister_tml_scripts() {
	wp_dequeue_script( 'theme-my-login' );
	wp_deregister_script( 'theme-my-login' );
}
add_action( 'wp_print_scripts', 'deregister_tml_scripts' );

/**
 * WordPress function for redirecting users on login based on user role
 * https://developer.wordpress.org/reference/hooks/login_redirect/
 */
function theme_my_login_redirect( $url, $request, $user ) {
    if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
        if ( $user->has_cap( 'administrator' ) ) {
            $url = admin_url();
        } else {
            $url = home_url();
        }
    }
    return $url;
}
add_filter( 'login_redirect', 'theme_my_login_redirect', 10, 3 );


/**
 * Edit Form Fields fields
 * examples:
 * https://docs.thememylogin.com/article/93-removing-profile-fields
 * https://docs.thememylogin.com/article/88-modifying-the-user-panel
 */
function theme_my_login_form_fields() {

	//we can use tml_is_action when we use "wp" hook instead of "init"
	if( !tml_is_action() ) return;

	//edit login form
	if( tml_is_action('login') ) {
		$login = tml_get_form_field( 'login', 'log' );
		$login->add_attribute( 'required', 'true' );

		$password = tml_get_form_field( 'login', 'pwd' );
		$password->add_attribute( 'required', 'true' );			
	}

	//register form
	if( tml_is_action('register') ) {

		$user_login = tml_get_form_field( 'register', 'user_login' );
		$user_login->add_attribute( 'required', 'true' );
		//$user_login->add_attribute( 'placeholder', __('Nazwa użytkownika') );

		$user_email = tml_get_form_field( 'register', 'user_email' );
		$user_email->add_attribute( 'required', 'true' );

		$user_pass1 = tml_get_form_field( 'register', 'user_pass1' );
		$user_pass1->add_attribute( 'required', 'true' );

		$user_pass2 = tml_get_form_field( 'register', 'user_pass2' );
		$user_pass2->add_attribute( 'required', 'true' );			
	}

	//profile form (via Extension)
	if( tml_is_action('profile') ) {

		tml_remove_form_field( 'profile', 'locale' );

		tml_remove_form_field( 'profile', 'name_section_header' );
		tml_remove_form_field( 'profile', 'first_name' );
		tml_remove_form_field( 'profile', 'last_name' );

		//tml_remove_form_field( 'profile', 'nickname' );
		tml_remove_form_field( 'profile', 'display_name' );

		tml_remove_form_field( 'profile', 'contact_info_section_header' );
		tml_remove_form_field( 'profile', 'url' );

		tml_remove_form_field( 'profile', 'about_yourself_section_header' );
		tml_remove_form_field( 'profile', 'description' );

	}		

}
add_action( 'wp', 'theme_my_login_form_fields' );

/**
 * Add fields to Registration Form
 * https://docs.thememylogin.com/article/62-adding-extra-registration-fields
 * 
 */
function add_tml_registration_form_fields() {

	if( !tml_is_action() or !tml_is_action('register') ) return;

	tml_add_form_field( 'register', 'disclaimer', array(
		'type'     => 'custom',
		'content'  => sprintf(
			__( '<p>Zakładając konto akceptujesz <a href="%s">regulamin serwisu ASRoma.pl</a> oraz naszą <a href="%s">politykę prywatności</a>.</p>' ),
			get_permalink(THEME_TERMS_PAGE_ID),
			get_privacy_policy_url(),
		),
		'priority' => 33,
	) );

}
add_action( 'wp', 'add_tml_registration_form_fields' );