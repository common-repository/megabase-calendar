<?php

use MegaCal\Client\CustomRecurrence;
use MegaCal\Client\EventRecurrenceDetail;

 if( !defined( 'ABSPATH' ) ) die();

$recurrence_types = empty( $recurrence_details ) ? EventRecurrenceDetail::RECURRENCE_TYPES : $recurrence_details->get_available_types();
$disabled = empty( $recurrence_details ) || false === $show_recurrence;
?>

<select id="eventRecurrenceSelect" name="eventRecurrence" <?php echo $disabled ? 'disabled' : ''; ?>>
	<option value="none">Does Not Repeat</option>
	<?php if( $disabled ): ?>
		<?php foreach( $recurrence_types as $type ): ?>
			<option value="none"><?php esc_html_e( $this->megacal_get_recurrence_type_mapping( $type ) ); ?></option>
		<?php endforeach; ?>
	<?php else: ?>
		<?php
			$weekly = $recurrence_details->get_weekly();
			$monthly = $recurrence_details->get_monthly();
			$annually = $recurrence_details->get_annually();
		?>

		<?php foreach( $recurrence_types as $type ): ?>
			<?php
				$type_name = $this->megacal_get_recurrence_type_mapping( $type );
				$type_extra = '';

				if( EventRecurrenceDetail::TYPE_WEEKDAY !== $type && EventRecurrenceDetail::TYPE_DAILY !== $type && EventRecurrenceDetail::TYPE_CUSTOM !== $type ) {

					$type_extra .= ' on ';
					
					switch( $type ) {

						case EventRecurrenceDetail::TYPE_WEEKLY:
							$type_extra .= ucfirst( strtolower( $weekly->get_day_of_week() ) );
							break;
						case EventRecurrenceDetail::TYPE_MONTHLY:
							$day_occurrence = $monthly->get_last_day_of_week() ? 'last' : $this->megacal_fmt_num_ordinal( $monthly->get_week_of_month() );
							$type_extra .= 'the ' . $day_occurrence . ' ' . ucfirst( strtolower( $monthly->get_day_of_week() ) );
							break;
						case EventRecurrenceDetail::TYPE_ANNUALLY:
							$type_extra .= ucfirst( strtolower( $annually->get_month() ) ) . ' ' . $annually->get_day_of_month();
							break;

					}

				}

				$rendered_type_str = $type_name . $type_extra;
			?>
			<option value="<?php esc_attr_e( $type ); ?>"><?php esc_html_e( $rendered_type_str ); ?></option>
		<?php endforeach; ?>
	<?php endif; ?>
</select>

<?php if( !$disabled ): ?>
	<input type="hidden" name="eventRecurrenceDayOfWeek" value="<?php esc_attr_e( $weekly->get_day_of_week() ); ?>" />
	<input type="hidden" name="eventRecurrenceWeekOfMonth" value="<?php esc_attr_e( $monthly->get_week_of_month() ); ?>" />
	<input type="hidden" name="eventRecurrenceLastDayOfWeek" value="<?php echo $monthly->get_last_day_of_week() === true ? 'true' : 'false'; ?>" />
	<input type="hidden" name="eventRecurrenceDayOfMonth" value="<?php esc_attr_e( $annually->get_day_of_month() ); ?>" />
	<input type="hidden" name="eventRecurrenceMonth" value="<?php esc_attr_e( $annually->get_month() ); ?>" />

	<?php $custom_details = $recurrence_details->get_custom(); ?>
	<div class="megacal-custom-recurrence-details hidden">
		<h4>Custom Recurrence</h4>

		<div class="megacal-custom-recurrence-section">
			<span>Repeat Every</span>
			<label for="eventRecurrenceRepetition" class="screen-reader-text">Recurrence Amount</label>
			<input id="eventRecurrenceRepetition" type="number" name="eventRecurrenceRepetition" value="" />

			<label for="eventRecurrenceCustomType" class="screen-reader-text">Recurrence Type</label>
			<select id="eventRecurrenceCustomType" name="eventRecurrenceCustomType">
				<?php foreach( $custom_details->get_available_types() as $type ): ?>
					<option value="<?php esc_attr_e( $type ); ?>" <?php echo EventRecurrenceDetail::TYPE_WEEKLY === $type ? 'selected' : ''; ?>>
						<?php esc_html_e( $this->megacal_get_recurrence_type_mapping( $type, MEGACAL_RECURRENCE_TYPE_PLURAL_FMT ) ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div class="megacal-custom-recurrence-section">

			<?php 
				$weekly_custom = $custom_details->get_weekly_custom();
				$monthly_custom = $custom_details->get_monthly_custom();
				$day_occurrence = $monthly_custom->get_last_day_of_week() ? 'last' : $this->megacal_fmt_num_ordinal( $monthly_custom->get_week_of_month() );
				$day_freq = 'the ' . $day_occurrence . ' ' . ucfirst( strtolower( $monthly_custom->get_day_of_week() ) );
			?>
			<label for="eventRecurrenceCustomMonthlyFreq" class="screen-reader-text">Recurrence Monthly Frequency</label>
			<select id="eventRecurrenceCustomMonthlyFreq" class="hidden" name="eventRecurrenceCustomMonthlyFreq">
				<option value="day_of_month">Monthly on day <?php esc_html_e( $monthly_custom->get_day_of_month() ); ?></option>
				<option value="week_of_month-<?php esc_attr_e( $monthly_custom->get_week_of_month() ); ?>">Monthly on <?php esc_html_e( $day_freq ); ?></option>
			</select>

			<div id="eventRecurrenceWeeklyDays" class="hidden">
				<?php foreach( $weekly_custom->get_repeat_on() as $day ): ?>
					<?php $checked = $weekly_custom->get_selected_day_of_week() === $day ? 'checked' : ''; ?>
					<label for="eventRecurrenceWeeklyDays-<?php esc_attr_e( strtolower( $day ) ); ?>">
						<span class="screen-reader-text">Repeat Every </span>
						<input type="checkbox" id="eventRecurrenceWeeklyDays-<?php esc_attr_e( strtolower( $day ) ); ?>" class="eventRecurrenceWeeklyDays" name="eventRecurrenceWeeklyDays" value="<?php esc_attr_e( $day ); ?>" <?php esc_attr_e( $checked ); ?> /> <?php esc_html_e( ucfirst( strtolower( $day ) ) ); ?>
					</label>
				<?php endforeach; ?>
			</div>

		</div>

		<h4 class="mega-collapsable-toggle" tabindex="0" role="button" aria-pressed="false">Ends<i class="icon-chevron-right" aria-hidden="true"></i></h4>

		<div class="megacal-ends-details-container mega-collapsable collapsed">

			<div class="megacal-custom-recurrence-section">
				<label for="eventRecurrenceEndNever"><input id="eventRecurrenceEndNever" type="radio" name="eventRecurrenceEnd" class="eventRecurrenceEnd" value="never" checked /><span class="screen-reader-text">Ends</span> Never</label>
			</div>
			
			<div class="megacal-custom-recurrence-section">	
				<label for="eventRecurrenceEndDateOp">
					<input id="eventRecurrenceEndDateOp" type="radio" name="eventRecurrenceEnd" class="eventRecurrenceEnd" value="date" /><span class="screen-reader-text">Ends</span> On
					<input id="eventRecurrenceEndDate" type="text" class="datepicker" name="eventRecurrenceEndDate" value="" />
				</label>
				<label for="eventRecurrenceEndDate" class="screen-reader-text">End Recurrence Date</label>
			</div>
	
			<div class="megacal-custom-recurrence-section">
				<label for="eventRecurrenceEndOccurrenceOp">
					<input id="eventRecurrenceEndOccurrenceOp" type="radio" name="eventRecurrenceEnd" class="eventRecurrenceEnd" value="occurrence" /><span class="screen-reader-text">Ends</span> After
					<input id="eventRecurrenceEndOccurrence" type="number" name="eventRecurrenceEndOccurrence" value="" />
					<span>Occurrences</span>
				</label>
				<label for="eventRecurrenceEndOccurrence" class="screen-reader-text">End Recurrence After Amount</label>
			</div>
		
		</div><!-- .mega-collapsable -->

	</div>
<?php endif; ?>

<?php if( !$this->megacal_is_pro_account() ): ?>
	<p class="small">Register for a pro account in order to create recurring events</p>
<?php endif; ?>

<?php if( false === $show_recurrence ): ?>
	<p class="small">To change a singular event to recurring, please recreate the event</p>
<?php endif; ?>