<?php if( !defined( 'ABSPATH' ) ) die();

$total = $response->get_count();
$total_pages = ceil( $response->get_count() / MEGACAL_EVENT_LIST_RESULTS_PER_PAGE );
?>
<input type="hidden" class="megacal-list-total-pages" value="<?php esc_attr_e( $total_pages ); ?>" />