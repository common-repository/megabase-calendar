<?php

if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );
if( !is_array( $relationships ) ) return;
?>

<div id="megacal-manage-<?php esc_attr_e( $type_plural ); ?>-page" class="megacal-manage-relationships-page megacal-settings-page wrap">	

	<h1 class="wp-heading-inline">Edit <?php esc_html_e( ucwords( str_replace( '-', ' ', $type_plural ) ) ); ?></h1>

	<?php include( trailingslashit( MEGACAL_PLUGIN_DIR ) . 'includes/partials/part-notice-container.php' ); ?>

	<!-- <hr class="wp-header-end" /> -->

	<?php if( $this->megacal_is_pro_account() ): ?>
		<ul class="megacal-admin-tabs">

			<li class="current">
				<a href="admin.php?page=megacal-manage-<?php esc_attr_e( $type_plural ); ?>&published=true" class="<?php echo true === $published ? 'current' : ''; ?>">Published</a>
			</li>
			<li class="<?php echo empty( $settings['megacal_access_token'] ) ? '' : 'current'; ?>">
				<a href="admin.php?page=megacal-manage-<?php esc_attr_e( $type_plural ); ?>&published=false" class="<?php echo false === $published ? 'current' : ''; ?>">Hidden</a>
			</li>
		</ul>
	<?php endif; ?>	

	<div class="postbox megacal-relationship-forms-wrap">
		<?php if( !$this->megacal_is_pro_account() ): ?>
			<p>Pro Accounts can edit Venue and Category details. <a href="<?php esc_attr_e( MEGACAL_UPGRADE_URL ); ?>">Upgrade today</a> to enable this feature.</p>
		<?php else: ?>
			<?php wp_nonce_field( 'megacal_update_relationships_nonce', 'megacal_update_relationships_nonce' ); ?>
			<?php if( empty( $relationships ) ): ?>
				<p>No <?php echo true === $published ? 'published' : 'hidden'; ?> <?php esc_html_e( ucwords( str_replace( '-', ' ', $type_plural ) ) ); ?> were found.</p>	
			<?php endif; ?>

			<?php foreach( $relationships as $obj ): ?>
				<form class="megacal-manage-relationship-form megacal-horizontal-form" method="POST">
					<input type="hidden" name="type" value="<?php esc_attr_e( $type ); ?>" />
					<input type="hidden" name="id" value="<?php esc_attr_e( $obj->get_id() ); ?>" />

					<div class="megacal-form-field-group">
						<label for="name-<?php esc_attr_e( $obj->get_id() ); ?>"><?php esc_html_e( ucfirst( $type ) ); ?> Name</label>
						<input type="text" name="name" id="name-<?php esc_attr_e( $obj->get_id() ); ?>" value="<?php esc_attr_e( $obj->get_name() ); ?>" readonly />
					</div>

					<?php if( MegabaseCalendar::TYPE_VENUE === $type ): ?>
						<?php $location = !empty( $obj->get_location() ) ? $obj->get_location() : ''; ?>
						<div class="megacal-form-field-group">
							<label for="location-<?php esc_attr_e( $obj->get_id() ); ?>">Address or Description</label>
							<textarea id="location-<?php esc_attr_e( $obj->get_id() ); ?>" name="location" readonly><?php echo esc_textarea( $location ); ?></textarea>
						</div>
					<?php endif; ?>

					<div class="megacal-form-field-group">
						<label for="published-<?php esc_attr_e( $obj->get_id() ); ?>">
							<input type="checkbox" name="published" id="published-<?php esc_attr_e( $obj->get_id() ); ?>" <?php echo $obj->get_published() ? 'checked' : ''; ?> disabled />
							Published
						</label>
						<!-- <p class="small">(Event <?php esc_html_e( $type ); ?> will remain on existing events).</p> -->
					</div>

					<div class="megacal-form-field-group">
						<button class="megacal-relationship-edit-btn button button-secondary"><i class="icon-pencil" title="Edit"></i><span class="screen-reader-text">Edit this <?php esc_html_e( $type ); ?></span></button>
						<button class="megacal-relationship-save-btn button button-primary" type="submit" disabled><i class="icon-save-floppy" title="Save"></i><span class="screen-reader-text">Save <?php esc_html_e( $type ); ?> details</button>
					</div>
				</form>
			<?php endforeach; ?>
			<div class="megaNotebox">
				<h4>Notes</h4>
				<p>
					You can create a new event category when adding a new event from the Add/Manage Events screen.
				</p><p>
					When making an Event Category unpublished, it will appear in the "Hidden" tab at the top of this page
				</p><p>
					Unpublished Event Categories will not be removed from any existing events that are using them. An unpublished (hidden) category is removed from the category dropdown when creating new events. It can be republished at any time. 
				</p>
				<p>
					Event categories must have unique names. 
				</p>
			</div>
		<?php endif; ?>
	</div>
	<?php $this->megacal_display_admin_links(); ?>
</div>