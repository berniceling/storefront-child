<?php
/**
 * Email Header
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
        <style>
            .smtxt {font-size: 12px;}
            hr { border-top : 1px solid #eee !important;}
            a, a:hover  { text-decoration: none !important; }

        </style>
	</head>
    <body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<div id="wrapper">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="center" valign="top">
						<div id="template_header_image">
	                		<?php
	                			if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
	                				echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" /></p>';
	                			}
	                		?>

						</div>
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Header -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style='background:#ccc'>
                                        <tr>
                                            <td>
                                                <a href='https://neyrinck.com/store/' style='text-decoration: none !important;'>
                                                <span style='font-family: Helvetica; padding-bottom: 10px;'>
                                                    <h1 style='font-size: 34px; letter-spacing: -1px; font-weight:800; margin:0; line-height: 1em; padding:36px 48px 5px 36px'>NEYRINCK</h1>
                                                    <p style='padding: 0; margin: 0; padding-left:36px; font-size: 15px; font-weight: 200; color: #202020'>Making Great Sound Easy</p>
                                                    
                                                </span>
                                                </a>
                                                <br/>
                                                <hr />
                                                <br/>

                                            	<h1 style='font-size: 30px !important; font-weight: 300 !important; text-align: center !important;'><?php echo $email_heading; ?></h1>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                    	<tr>
                                            <td valign="top" id="body_content">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div id="body_content_inner">
