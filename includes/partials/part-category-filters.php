<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

$megacal = MegabaseCalendar::get_instance();
$categories = $megacal->megacal_get_my_category_list( array( 'published' => true ) );
$settings = MegabaseCalendar::megacal_get_settings();
?>

<!-- Style Settings Overrides -->
<style>
	.megacal-events-integration #megacal-cal-filters button:hover {
		<?php if( !empty( $settings['megacal_btn_bg_hovercolor'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
			border:1px solid <?php esc_html_e( $settings['megacal_btn_bg_hovercolor'] ); ?> !important;
		<?php endif; ?>

		<?php if( !empty( $settings['megacal_btn_text_hovercolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_btn_text_hovercolor'] ); ?> !important;
		<?php endif; ?>
	}

	.megacal-events-integration #megacal-cal-filters button.current {
		<?php if( !empty( $settings['megacal_custom_simple_details_btn_color'] ) ): ?>
			background-color: <?php esc_html_e( $settings['megacal_custom_simple_details_btn_color'] ); ?> !important;
			border:1px solid <?php esc_html_e( $settings['megacal_custom_simple_details_btn_color'] ); ?> !important;
		<?php endif; ?>

		<?php if( !empty( $settings['megacal_btn_text_hovercolor'] ) ): ?>
			color: <?php esc_html_e( $settings['megacal_btn_text_hovercolor'] ); ?> !important;
		<?php endif; ?>
	}

	<?php if( isset( $settings['megacal_invert_colors_dark_mode'] ) && $settings['megacal_invert_colors_dark_mode'] === "true" ): ?>
		.megacal-events-integration.blackBack #megacal-cal-filters button.current,
		.megacal-events-integration.blackBack #megacal-cal-filters button:hover {
			filter: invert( 100% ) !important;
		}
	<?php endif; ?>
</style>

<aside id="megacal-cal-filters">
				
	<!-- <h3>Filter Events</h3> -->

	<div class="megacal-filter-section">

		<!-- <h4>Event Category</h4> -->

		<button data-cat-id="" role="button" class="megacal-filter-cat-btn <?php echo empty( $event_cat ) ? 'current' : ''; ?>" aria-pressed="<?php echo empty( $event_cat ) ? 'true' : 'false'; ?>">
			All
		</button>
		
		<?php foreach( $categories as $cat ): ?>

			<?php if( $cat->get_count() < 1 ) continue; ?>

			<button data-cat-id="<?php esc_attr_e( $cat->get_id() ); ?>" role="button" class="megacal-filter-cat-btn megacal-filter-cat-<?php esc_attr_e( $cat->get_id() ); ?> <?php echo ( !empty( $event_cat ) && $cat->get_id() === $event_cat ) ? 'current' : ''; ?>" aria-pressed="<?php echo ( !empty( $event_cat ) && $cat->get_id() === $event_cat ) ? 'true' : 'false'; ?>">
				<?php esc_html_e( $cat->get_name() ); ?>
			</button>
		<?php endforeach; ?>

	</div>
	
</aside>
