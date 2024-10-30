<?php        
    // Die on direct access
    if( !defined( 'ABSPATH' ) )
        die( 'Not allowed' );

    // check user capabilities
    if ( !current_user_can( MEGACAL_PLUGIN_VISIBILITY_CAP ) )
        wp_die( 'Not allowed' );

    $examples = site_url( '/wp-content/plugins/megabase-calendar/assets/img/MegaCalendarListStylesCollage.png', 'https' );    

    $is_modal = get_query_var( 'is_modal', false );
    $copy_button_class = ($is_modal) ? 'button-secondary' : 'button-primary';

    $event_owners = $this->megacal_get_event_owner_filters();
    $categories = $this->megacal_get_my_category_list();

?>

<div id="megacal-events-settings-sc" class="admin-tab">
    <ul class="megacal-admin-tabs tabs">
        <li>
            <a href="#megacal-events-settings-calendar">Event List / Calendar</a>
        </li>
    </ul>

    <div id="megacal-events-settings-calendar" class="admin-tab megaFlexSection">
        <div class="leftArea">
            <h2 class="short-margin">Shortcode Options</h2>
            <p class="docs-link">
                <a href="https://megabase.co/help_docs/shortcode-usage/" target="_blank"><i class="fui-question-circle" aria-hidden="true"></i>Need Help?</a>
            </p>

            <?php if( empty( $connected ) ): ?>
                <p>You have not successfully connected your API key, please visit the <a href="<?php echo esc_url( site_url() ); ?>/wp-admin/admin.php?page=megacal-integration">settings page</a> to do so.</p>
            
            <?php else: ?>
            
                <ul class="optionList">
                    <li>
                        <label for="themeSelect">Website Theme</label>
                        <select name="themeSelect" id="themeSelect">
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </li>

                    <li>
                        <label for="defaultView">
                            Calendar or List View?
                            <span class="small">End-user can switch between views via tabs</span>
                        </label>
                        <select name="defaultView" id="defaultView">
                            <option value="list">List View</option>
                            <option value="cal">Calendar View</option>
                        </select>
                    </li>

                    <li>
                        <label for="listStyleSelect">
                            List Style
                        
                            <span class="small"><a href="https://megabase.co/help_docs/megacalendar-views-examples/" target="_blank">*New* - See Examples</a></span>

                        </label>

                        <select id="listStyleSelect" name="listStyleSelect">
                            <option value="full" <?php echo ( $settings['megacal_default_style'] == 'full' ) ? 'selected' : ''; ?>>Standard</option>
                            
                            <option value="simple"  <?php echo ( $settings['megacal_default_style'] == 'simple' ) ? 'selected' : ''; ?>>Tight</option>

                            <option value="compact"  <?php echo ( $settings['megacal_default_style'] == 'compact' ) ? 'selected' : ''; ?>>Text Only</option>
                        </select>
                    </li>
                    

                    <li>
                        <label for="showFilters">
                            Show Category Filters? 
                            <span class="small">Gives end user tabs to view specific categories.  Cannot be combined with user filter</span>
                        </label>
                        <input type="checkbox" name="showFilters" id="showFilters" />
                    </li>

                </ul>

                <h2>Copy/Paste this Shortcode onto any page</h2>

                <input type="text" readonly="readonly" class="shortcode" value='[megacal display="img" style="<?php echo esc_attr( $settings['megacal_default_style'] ); ?>"]' size="50" />
                
                <?php if( true === $is_modal ): ?>
                    <a href="#" class="insertShortcode button button-primary" data-target-class="shortcode">Insert Code</a>
                <?php endif; ?>

                <a href="#" class="copyToClipboard button <?php esc_attr_e( $copy_button_class ); ?>">Copy to Clipboard</a>
                
                <span class="copySuccess green hidden">Copied!</span>
                <span class="copyFail red hidden">Sorry, there was a problem please try again...</span>

                <h3 class="mega-collapsable-toggle" tabindex="0" role="button" aria-pressed="false"><i class="icon-chevron-right" aria-hidden="true"></i>Advanced</h3>

                <ul class="optionList mega-collapsable collapsed">                

                    <li>
                        <label for="filterCal">
                            Display Events from
                            <span class="small">For pro accounts only - display a particular calendar of events sent from another calendar</span>
                        </label>
                        <select id="filterCal" name="filterCal" <?php echo ( $this->megacal_is_pro_account() ) ? '' : 'disabled'; ?>>
                            <option value="0">All</option>

                            <?php foreach( $event_owners as $event_owner ): ?>
                                <option value="<?php esc_attr_e( $event_owner->get_id() ); ?>"><?php echo esc_html( $event_owner->get_calendar_name() ) . ' &mdash; ' . esc_html( $event_owner->get_handle() ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>

                    <li>
                        <label for="filterCat">
                            Pre-Select Category
                            <span class="small">Select a category here to pre-filter the calendar.</span>
                        </label>
                        <select id="filterCat" name="filterCat">
                            <option value="0">All</option>

                            <?php foreach( $categories as $cat ): ?>
                                <option value="<?php esc_attr_e( $cat->get_id() ); ?>"><?php esc_html_e( $cat->get_name() ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>

                    <li>
                        <label for="showDesc">Expanded Descriptions on List? </label>
                        <input type="checkbox" name="showDesc" id="showDesc" />
                    </li>

                    <li>
                        <label for="hideView">
                            Hide View Selector Buttons?
                            <span class="small">List/Calendar View Selector will be hidden from view</span>
                        </label>
                        <input type="checkbox" name="hideView" id="hideView" />
                    </li>

                    <li>
                        <label for="buttonPositions">Event Buttons Position</label>
                        <select name="buttonPositions" id="buttonPositions">
                            <option value="left">Left Aligned</option>
                            <option value="center">Center</option>
                            <option value="right">Right</option>
                        </select>
                    </li>

                    <li>
                        <label for="displyImgs">Display Images on Calendar? </label>
                        <input type="checkbox" checked="checked" name="displyImgs" id="displyImgs" />
                    </li>

                    <li>
                        <label for="imgHeight">Calendar Image Height <span class="small">(in px)</span></label>
                        <input type="number" name="imgHeight" id="imgHeight" value="20" />
                    </li>

                </ul>
            <?php endif; ?>
        </div>
        <div class="rightArea">                

                <img src="<?php echo $examples; ?>"  
                alt="MegaCalendar List Examples"
                class="listExamplesPic" />

        </div>

        
    </div>

</div><!-- /.wrap -->