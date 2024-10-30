<?php 

if( !defined( 'ABSPATH' ) ) 
	die( 'Not Allowed' );

	$processing_errors = $this->megacal_get_settings( 'megacal_processing_errors' );
?>

<div id="megacal-notices" class="notice-wrap">
	
	<div id="alert-notice" class="notice-container hidden">
		<span class="alert-notice-inner"></span>
		<button class="alert-notice-close"><i class="fui-cross"></i></button>
	</div>

	<?php if( !empty( $processing_errors ) ): ?>
		<?php foreach( $processing_errors as $error ): ?>
			<div class="notice-container error-notice">
				<p><?php esc_html_e( $error ); ?></p>
			</div>
		<?php endforeach; ?>
		<?php update_option( 'megacal_processing_errors', array() ); // flush error messages ?>
	<?php endif; ?>

	<?php if( MEGACAL_MANAGE_SLUG == $_GET['page'] ): ?>
		<?php wp_nonce_field( 'megacal_get_approval_list_nonce', 'megacal_get_approval_list_nonce' ); ?>
		<div id="megacal-approval-list"></div> 
	<?php endif; ?>
</div>