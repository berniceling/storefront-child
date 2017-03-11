<?php

add_filter( 'woocommerce_sale_flash', 'wc_custom_replace_sale_text' );
function wc_custom_replace_sale_text( $html ) {
    return str_replace( __( 'Sale!', 'woocommerce' ), __( 'December Sale!', 'woocommerce' ), $html );
}





/**
 // Allow customers to login with their email address or username
**/
add_filter('authenticate', 'internet_allow_email_login', 20, 3);
/**
 * internet_allow_email_login filter to the authenticate filter hook, to fetch a username based on entered email
 * @param  obj $user
 * @param  string $username [description]
 * @param  string $password [description]
 * @return boolean
 */
function internet_allow_email_login( $user, $username, $password ) {
    if ( is_email( $username ) ) {
        $user = get_user_by_email( $username );
        if ( $user ) $username = $user->user_login;
    }
    return wp_authenticate_username_password( null, $username, $password );
}




/**
 * Redirect customer to my-account page after login
 */

add_action('login_form', 'redirect_after_login'); 
function redirect_after_login() { 
	global $redirect_to; 
	if (!isset($_GET['redirect_to'])) { 
		$redirect_to = get_option('siteurl')."/store"; 
	}

} 



/**
/* Change text of order button
*/
add_filter( 'woocommerce_order_button_text', create_function( '', 'return "Checkout";' ) );



/**
 * Redirect the Continue Shopping URL from the default (most recent product) to
 * a custom URL.
 */
function custom_continue_shopping_redirect_url ( $url ) {
	$url = "https://neyrinck.com/store/"; // Add your link here
	return $url;
}
add_filter('woocommerce_continue_shopping_redirect', 'custom_continue_shopping_redirect_url');



/**
* Password confirmation in woocommerce
*/
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
	$fields['account']['account_password-2'] = array(
        'label'     	=> __('Confirm Password', 'woocommerce'),
		'placeholder'   => _x('Confirm Password', 'placeholder', 'woocommerce'),
		'required'  	=> true,
		'class'     	=> array('form-row, form-row-wide'),
		'clear'     	=> true,
		'type'     	=> 'password',
     );

     return $fields;
}

// Check the password and confirm password fields match before allow checkout to proceed.
add_action( 'woocommerce_after_checkout_validation', 'wc_check_confirm_password_matches_checkout', 10, 2 );
function wc_check_confirm_password_matches_checkout( $posted ) {
	$checkout = WC()->checkout;
	if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
		if ( strcmp( $posted['account_password'], $posted['account_password-2'] ) !== 0 ) {
			wc_add_notice( __( 'Passwords not match.', 'woocommerce' ), 'error' );
		}
	}
}



// ******* CUSTOMIZATION OF REGISTRATION ************//

remove_action('init', 'save_account_details');
add_action( 'init', 'my_save_account_details' );

function my_save_account_details() {

		if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
			return;
		}

		if ( empty( $_POST[ 'action' ] ) || 'save_account_details' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_account_details' ) ) {
			return;
		}

		$update       = true;
		$errors       = new WP_Error();
		$user         = new stdClass();

		$user->ID     = (int) get_current_user_id();
		$current_user = get_user_by( 'id', $user->ID );

		if ( $user->ID <= 0 ) {
			return;
		}

		$account_first_name = ! empty( $_POST[ 'account_first_name' ] ) ? wc_clean( $_POST[ 'account_first_name' ] ) : '';
		$account_last_name  = ! empty( $_POST[ 'account_last_name' ] ) ? wc_clean( $_POST[ 'account_last_name' ] ) : '';
		$account_email      = ! empty( $_POST[ 'account_email' ] ) ? sanitize_email( $_POST[ 'account_email' ] ) : '';
		$account_country      = ! empty( $_POST[ 'account_country' ] ) ? wc_clean( $_POST[ 'account_country' ] ) : '';
		$account_organization      = ! empty( $_POST[ 'account_organization' ] ) ? wc_clean( $_POST[ 'account_organization' ] ) : '';
		$pass_cur           = ! empty( $_POST[ 'password_current' ] ) ? $_POST[ 'password_current' ] : '';
		$pass1              = ! empty( $_POST[ 'password_1' ] ) ? $_POST[ 'password_1' ] : '';
		$pass2              = ! empty( $_POST[ 'password_2' ] ) ? $_POST[ 'password_2' ] : '';
		$save_pass          = true;

		$user->first_name   = $account_first_name;
		$user->last_name    = $account_last_name;
		$user->user_email   = $account_email;
		$user->display_name = $user->first_name;
		$user->billling_company = $account_organization; 
		$user->billing_country     = $account_country;

		
		if ( empty( $account_first_name ) || empty( $account_last_name ) ) {
			wc_add_notice( __( 'Please enter your name.', 'woocommerce' ), 'error' );
		}

		if ( empty( $account_email ) || ! is_email( $account_email ) ) {
			wc_add_notice( __( 'Please provide a valid email address.', 'woocommerce' ), 'error' );
		} elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
			wc_add_notice( __( 'This email address is already registered.', 'woocommerce' ), 'error' );
		}

		if ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
			wc_add_notice( __( 'Your current password is incorrect.', 'woocommerce' ), 'error' );
			$save_pass = false;
		}

		if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
			wc_add_notice( __( 'Please fill out all password fields.', 'woocommerce' ), 'error' );

			$save_pass = false;
		} elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
			wc_add_notice( __( 'Please enter your current password.', 'woocommerce' ), 'error' );

			$save_pass = false;
		} elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
			wc_add_notice( __( 'Please re-enter your password.', 'woocommerce' ), 'error' );

			$save_pass = false;
		} elseif ( ! empty( $pass1 ) && $pass1 !== $pass2 ) {
			wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' );

			$save_pass = false;
		}

		if ( $pass1 && $save_pass ) {
			$user->user_pass = $pass1;
		}

		// Allow plugins to return their own errors.
		do_action_ref_array( 'user_profile_update_errors', array( &$errors, $update, &$user ) );

		if ( $errors->get_error_messages() ) {
			foreach ( $errors->get_error_messages() as $error ) {
				wc_add_notice( $error, 'error' );
			}
		}

		if ( wc_notice_count( 'error' ) === 0 ) {

			wp_update_user( $user ) ;

			wc_add_notice( __( 'Account details changed successfully.', 'woocommerce' ) );

			bl_save_country($account_country, $user->ID);
			bl_save_organization($account_organization, $user->ID);
			do_action( 'woocommerce_save_account_details', $user->ID );
			
			wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
			exit;
		}
}

function bl_save_country($account_country, $user_id){
	global $wpdb;
        $wpdb->update( 'wp_usermeta', 
            array(  
                'meta_value' => $account_country,
            ),
            array( 'user_id' => $user_id, 'meta_key' => 'billing_country' )
        );
}

function bl_save_organization($account_organization, $user_id){
	global $wpdb;
        $wpdb->update( 'wp_usermeta', 
            array( 
                'meta_value' => $account_organization,
            ),
            array( 'user_id' => $user_id, 'meta_key' => 'billing_company')
        );
}


function bl_get_country($user_id){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT meta_value FROM wp_usermeta WHERE meta_key="billing_country" AND user_id ='.get_current_user_id(), OBJECT );
    if (is_array($results) ) {
        $result = $results[0]->meta_value;
        return $result;
    } else return false;
    
}

function bl_get_organization($user_id){
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT meta_value FROM wp_usermeta WHERE meta_key="billing_company" AND user_id ='.get_current_user_id(), OBJECT );
    if (is_array($results) ) {
        $result = $results[0]->meta_value;
        return $result;
    } else return false;
    
}

function eg_remove_my_subscriptions_button( $actions, $subscriptions ) {

	foreach ( $actions as $subscription_key => $action_buttons ) {
		foreach ( $action_buttons as $action => $button ) {
			switch ( $action ) {
//				case 'change_payment_method':	// Hide "Change Payment Method" button?
				case 'change_address':		// Hide "Change Address" button?
				case 'switch':			// Hide "Switch Subscription" button?
				case 'renew':			// Hide "Renew" button on a cancelled subscription?
//				case 'pay':			// Hide "Pay" button on subscriptions that are "on-hold" as they require payment?
				case 'reactivate':		// Hide "Reactive" button on subscriptions that are "on-hold"?
//				case 'cancel':			// Hide "Cancel" button on subscriptions that are "active" or "on-hold"?
					unset( $actions[ $subscription_key ][ $action ] );
					break;
				default: 
					error_log( '-- $action = ' . print_r( $action, true ) );
					break;
			}
		}
	}

	return $actions;
}
add_filter( 'woocommerce_my_account_my_subscriptions_actions', 'eg_remove_my_subscriptions_button', 100, 2 );



/**
/*   CUSTOM TEMPLATE FOR SUBSCRIPTION DETAILS PAGE
/*
*/

add_shortcode('bl_my_subscription', 'bl_my_subscription_function');
function bl_my_subscription_function(){	
		woocommerce_get_template( 'myaccount/my-subscription-details.php' );
}



/*  core changes made to this plugin, DO NOT UPDATE  */
function filter_plugin_updates( $value ) {
    // unset( $value->response['duofaq-responsive-flat-simple-faq/duo-faq.php'] );
    unset( $value->response['gallery-video/video-gallery.php'] );
    unset( $value->response['bbpress/bbpress.php'] );
    unset( $value->response['profile-builder/profile-builder.php'] );
    unset( $value->response['woocommerce-sequential-order-numbers/woocommerce-sequential-order-numbers.php'] );
    return $value;
}
//add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );




add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// Disabling the Reviews Tab in WooCommerce
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
 unset($tabs['reviews']);
 return $tabs;
}

//register the custom menus
function register_my_menus() {
	register_nav_menus(
		array(
			'vcontrolplus-menu' => __( 'V-Control Plus Menu' ),
			'vcontrolpro-menu' => __( 'V-Control Pro Menu' ),
			'soundcodesupremebundle-menu' => __( 'SoundCode Supreme Bundle Menu' ),
			'soundcodefordolbye-menu' => __( 'SoundCode For Dolby E Menu' ),
			'soundcodeltrt-menu' => __( 'SoundCode LtRt Tools Menu' ),
			'soundcodefordolbydigital2-menu' => __( 'SoundCode For Dolby Digital 2 Menu' ),
			'vmon-menu' => __( 'V-Mon Menu' ),
			'company-menu' => __( 'Company Menu' ),
			'developer-menu' => __( 'Developer Menu' ),
			'vcontropro-compatibleapps-menu' => __( 'V-Control Pro Compatible Apps Menu' ),
			'vcp2-compatibleapps-menu' => __( 'V-Control Pro 2 Compatible Apps Menu' ),
			'spill-menu' => __( 'Spill Menu' )
		)
	);
}
add_action( 'init', 'register_my_menus' );

//[add_vcontrol_compatible_apps_menu]
function addVcontrolCompatibleAppsMenu( $atts ){
	$menu = wp_nav_menu( array('theme_location' => 'vcontropro-compatibleapps-menu', 'container_id' => ''));
	echo $menu;
}
add_shortcode( 'add_vcontrol_compatible_apps_menu', 'addVcontrolCompatibleAppsMenu' );

// remove storefront_credit from the footer
// Since child theme functions.php is loaded before the parent theme's functions, 
// we'll need to load the remove_action on the "init" hook, which is loaded _after_ the parent function is loaded.
add_action( 'init', 'custom_remove_storefront_elements', 10 );

function custom_remove_storefront_elements () {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    remove_action( 'storefront_header', 'storefront_product_search', 	40 );
	// remove_action( 'storefront_header', 'storefront_header_cart', 		60 );
	remove_action( 'storefront_loop_post','storefront_post_meta',20 );
	remove_action( 'storefront_single_post','storefront_post_meta',			20 );
	remove_action( 'storefront_loop_post', 'storefront_post_header',		10 );
	remove_action( 'storefront_single_post', 'storefront_post_header',		10 );
	remove_action( 'storefront_single_post','storefront_post_content',		30 );
	remove_action( 'storefront_loop_post','storefront_post_content',		30 );

}

// **  NEWS BLOG  **
function storefront_post_header_NEWS(){
	echo "<div class='header_news'><a href='https://neyrinck.com/news/'>News</a></div>";
}
add_action( 'storefront_single_post','storefront_post_header_NEWS',5 );

add_action( 'storefront_loop_post',	'storefront_post_header_NEWS',5);

function storefront_post_meta_revised() {
		?>
		<div class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'storefront' ) );

			if ( $categories_list && storefront_categorized_blog() ) : ?>
				<span class="cat-links"><?php echo wp_kses_post( $categories_list ); ?></span>
			<?php endif; // End if categories ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );

			if ( $tags_list ) : ?>
				<span class="tags-links"><?php echo wp_kses_post( $tags_list ); ?></span>
			<?php endif; // End if $tags_list ?>

			<?php endif; // End if 'post' == get_post_type() ?>
		</div>
		<?php
}
add_action( 'storefront_single_post',		'storefront_post_meta_revised', 50 );

function storefront_post_header_revised() { ?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
			storefront_posted_on();
			
		} else {
			the_title( sprintf( '<h1 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			if ( 'post' == get_post_type() ) {
				storefront_posted_on();
			}
		}
		?>
		</header><!-- .entry-header -->
		<?php
}

add_action( 'storefront_loop_post',			'storefront_post_header_revised',		10 );
add_action( 'storefront_single_post',		'storefront_post_header_revised',		10 );

function add_quickshare(){
	do_quickshare_output(); 
}
add_action( 'storefront_single_post',		'add_quickshare',		40 );

add_action( 'storefront_single_post',		'storefront_post_content_remove_featured_image',		30 );
function storefront_post_content_remove_featured_image() {
	?>
	<div class="entry-content" itemprop="articleBody">
	
	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'storefront' ) ); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
	?>
	</div><!-- .entry-content -->
	<?php
}

add_action( 'storefront_loop_post',			'storefront_post_content_revised',		30 );
function storefront_post_content_revised() {
		?>
		<?php if (has_post_thumbnail()) {?> 
			<div class="entry-content" itemprop="articleBody" style='float:left; width: 65%; margin-right: 1em'>
		<?php } else {?>  <div class="entry-content" itemprop="articleBody"> <?php } ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'storefront' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
				'after'  => '</div>',
			) );
		?>
		</div><!-- .entry-content -->
		<div class='featured_image'> 
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
		}
		?>
		</div><!-- .featured_image -->
		<?php
	}

function mycustom_breadcrumb_options() {
	    // Home - default = true
	    $args['include_home']    = false;
	    // Forum root - default = true
	    $args['include_root']    = true;
	    // Current - default = true
	    $args['include_current'] = true;
	 
	    return $args;
	}
	 
add_filter('bbp_before_get_breadcrumb_parse_args', 'mycustom_breadcrumb_options');

/* Remove the topic/reply count from the forum list */
// function remove_counts() {
// $args['show_topic_count'] = false;
// $args['show_reply_count'] = false;
// $args['count_sep'] = '';
//  return $args;
// }
// add_filter('bbp_before_list_forums_parse_args', 'remove_counts' );

/*
 * Search only a specific forum
 */
function my_bbp_filter_search_results( $r ){
 
    //Get the submitted forum ID (from the hidden field added in step 2)
    $forum_id = sanitize_title_for_query( $_GET['bbp_search_forum_id'] );
 
    //If the forum ID exits, filter the query
    if( $forum_id && is_numeric( $forum_id ) ){
 
        $r['meta_query'] = array(
            array(
                'key' => '_bbp_forum_id',
                'value' => $forum_id,
                'compare' => '=',
            )
        );
         
    }
 
    return $r;
}
add_filter( 'bbp_after_has_search_results_parse_args' , 'my_bbp_filter_search_results' );


if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
	add_filter('login_redirect', 'my_login_redirect', 10, 3);
	function my_login_redirect() {
		$location = $_SERVER['HTTP_REFERER'];
		wp_safe_redirect($location);
		exit();
	}
}


//Remove cart from the storefront_header hook when empty
// add_action( 'storefront_header', 'remove_storefront_header_cart', 50 );
// function remove_storefront_header_cart () {
// 	global $woocommerce;
// 	if ($woocommerce->cart->cart_contents_count == 0) {
// 		remove_action( 'storefront_header', 'storefront_header_cart', 		60 );}
// }

// add login form shortcode
add_action( 'init', 'bl_add_shortcodes' );

function bl_add_shortcodes() {
	add_shortcode( 'bl-checkout-login-form', 'bl_login_form_shortcode' );
}
function bl_login_form_shortcode() {
	if ( is_user_logged_in() ) return '';
	custom_login_div();
	return wp_login_form( array( 'echo' => false,'label_username' => __( 'Email' ), 'redirect' => wc_get_page_permalink( 'checkout' ) ) );
}

// custom header for login form
add_filter( 'login_headertitle', 'custom_login_div' );
function custom_login_div(){
	if ($_GET['action'] == 'register')  $isRegistration = true;
	else if ($_GET['action'] == 'resetpass') $isResetPW = true;
	else if ($_GET['action'] == 'lostpassword') $isLostPW = true;
	else $isLogIn = true;

	// global $redirect_to;
	$redirect_to = $_SESSION['bl_orignial_refererer'];
	// $redirect_to = $_GET['redirect_to'];


	$register_url = site_url()."/login?action=register&redirect_to=".$redirect_to; 
	$login_url = site_url()."/login?redirect_to=".$redirect_to; 


	if ($isRegistration) { $headerNav="<h2>Register</h2><p>or <a href='". $login_url."'>Login</a></p>"; } 
	if ($isResetPW) { $headerNav="<h2>Reset Password</h2>"; }
	if ($isLostPW) { $headerNav="<h2>Forgot Your Password</h2>"; } 
	if ($isLogIn) { $headerNav="<h2>Login</h2><p>or <a href='". $register_url."'>Register</a></p>"; } 
    echo "
	<div class='custom_login_top_div'>".$headerNav."
	<div class='cl_facebook_log'>";

	do_shortcode( '[facebookall_login]' );

	echo "</div>";
	if ($isRegistration) { echo '<p style="font-size: 12px; font-weight: 300;margin-bottom: 0; margin-top: 15px;">NOTE: We will never sell or rent your personal information to third parties for their use without your consent.</p>'; }
	  else { echo '<p></p>';}
	echo "</div>";

	

}

if ( ! function_exists( 'cor_remove_personal_options' ) ) {
  /**
   * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
   */
  function cor_remove_personal_options( $subject ) {
    $subject = preg_replace( '#<h3>Personal Options</h3>.+?/table>#s', '', $subject, 1 );
    return $subject;
  }

  function cor_profile_subject_start() {
    ob_start( 'cor_remove_personal_options' );
  }

  function cor_profile_subject_end() {
    ob_end_flush();
  }
}
add_action( 'admin_head-user-edit.php', 'cor_profile_subject_start' );
add_action( 'admin_footer-user-edit.php', 'cor_profile_subject_end' );
remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
        return __( ' BUY ', 'woocommerce' ); 
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


// Display 100products per page. 
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 100;' ), 20 );


// remove TaxLabel
function sv_change_email_tax_label( $label ) {
    $label = '';
    return $label;
}
add_filter( 'woocommerce_countries_ex_tax_or_vat', 'sv_change_email_tax_label' );

// WooCommerce only sends invoice when triggere invoice automatically
// The code below send invoice automatically.
function sendinvoice($orderid)
{
    $email = new WC_Email_Customer_Invoice();
    $email->trigger($orderid);
}   

add_action('woocommerce_order_status_completed_notification','sendinvoice');



/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
 
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}
	return $actions;
}
 
add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );

?>