<?php // Public Calendar View 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
<style>
	.megacal-events-integration.blackBack .megaCalendarWrap .mega-content .mega-toolbar .mega-toolbar-button:hover {
		filter: invert( 100% ) !important;
	}
</style>
<?php endif; ?>

<div id="megacal-public-calendar-<?php esc_attr_e( $shortcode_instance_id ); ?>" class="megacal-public-calendar" data-category-filter="<?php esc_attr_e( $event_cat ); ?>"></div>