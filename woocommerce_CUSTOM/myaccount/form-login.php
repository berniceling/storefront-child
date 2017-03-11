<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="col2-set" id="customer_login">

	<div class="col-1">

<?php endif; ?>

<?php $url = site_url()."/login?action=register"; ?>
		
		<div class="custom_login_top_div" >
			<h2 style='padding-top: 0px;'>Login</h2><p>or <a href="<?php echo $url; ?>">Register</a></p>
			<div class="cl_facebook_log"><div class="fball_ui">
        <div class="fball_form" title="Facebook All"><a href="javascript:void(0);" title="Login with Facebook" onclick="FbAll.facebookLogin();" class="fball_login_facebook"><img src="http://neyrinck.com/images/login_with_fb.png" style="cursor:pointer;"></a></div>
        <div id="fball_facebook_auth">
          <input type="hidden" name="client_id" id="client_id" value="150075864040">
          <input type="hidden" name="redirect_uri" id="redirect_uri" value="https://neyrinck.com">
        </div>
	    <input type="hidden" id="fball_login_form_uri" value="">
        </div></div><p></p></div>
		
		

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<table width="80%" border="0" cellspacing="0" cellpadding="0">
		
				<tr style="height: 3.5em;">
					<td width="100px" style="vertical-align:middle;">E-mail:<span class="required">*</span></td>
					<td><input style='width:100%' class="input-text" type="email" name="username" id="username" />
					</td>
				</tr>
				<tr style="height: 3.5em;">
					<td width="100px" style="vertical-align:middle">Password:<span class="required">*</span></td>
					<td><input style='width:100%' class="input-text" type="password" name="password" id="password" />
					</td>
				</tr>
				<tr style="height: 2.5em;">
					<td width="100px" style="vertical-align:bottom"></td>
					<td><br/>
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found' ); ?>"><?php _e( 'Forgot your password?' ); ?></a>
					
					</td>
				</tr>

		</table>



			<?php do_action( 'woocommerce_login_form' ); ?>

			<div class='form'>
				<p class="form-row" style="text-align:center; width: 320px; margin: 0 auto;">
					<?php wp_nonce_field( 'woocommerce-login' ); ?>
					<input type="submit" style="width:320px; padding-left: 30px; padding-right: 30px; font-size:24px; " class="button" name="login" value="<?php _e( 'Login with Email', 'woocommerce' ); ?>" />
					
						
						<p class="forgetmenot" style="width: 320px; ;margin: 0 auto; padding:0px"><label for="rememberme">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> Remember Me</label></p>
				</p>
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="col-2">

		<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
					<input type="password" class="input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
