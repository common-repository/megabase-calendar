<?php 

if( !defined( 'ABSPATH' ) ) die();
if( !current_user_can( MEGACAL_PLUGIN_VISIBILITY_CAP ) ) wp_die( 'Not Allowed' );

?>

<div id="megacal-events-shortcodes" class="wrap megacal-settings-page">

	<h1>Shortcodes</h1>	
	
	<?php $this->megacal_display_shortcode_options(); ?>
	<?php $this->megacal_display_admin_links(); ?>

</div>