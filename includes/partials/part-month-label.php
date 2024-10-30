<?php
if( !defined( 'ABSPATH' ) ) die();
if( empty( $date ) ) return;

$previous_month = $month;

/**
 * Filter Hook: megacal_month_label_fmt
 * Filters the month label formatting on the Event lists - Must be a valid PHP date format
 * 
 * @param string $fmt The format - Default: 'F'
 * @param DateTime $date The date being formatted
 * @param string $previous_month The month processed on the previous event
 */
$month = $date->format( apply_filters( 'megacal_month_label_fmt', 'F', $date, $previous_month ) );

if( $month != $previous_month ):
?>

<li class="megacal-label-row">
	<h3 class="megacal-month-label"><?php esc_html_e( $month ); ?></h3>
</li>

<?php
endif;