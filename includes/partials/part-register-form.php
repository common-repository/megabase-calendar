<?php
	if( !defined( 'ABSPATH' ) ) die( 'Not Allowed' );
?>

	<form id="megacal-register-form" method="POST">
	
		<?php wp_nonce_field( '_megacal_register_nonce', '_megacal_register_nonce' ); ?>

		<table class="form-table" role="presentation">
			<tbody>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-firstname"><span class="red">*</span>First Name</label>
					</th>
					<td>
						<input type="text" id="megacal-register-firstname" class="required" name="firstname" value="" placeholder="Hans" />
					</td>
				</tr>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-lastname"><span class="red">*</span>Last Name</label>
					</th>
					<td>
						<input type="text" id="megacal-register-lastname" class="required" name="lastname" value="" placeholder="Gruber" />
					</td>
				</tr>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-calendar-name"><span class="red">*</span>Company / Org Name</label>
						<p class="small">This, as well as your handle, will appear to other users when you share events.</p>
					</th>
					<td>
						<input type="text" id="megacal-register-calendar-name" class="required" name="calendarName" value="" placeholder="Acme Organization" />
					</td>
				</tr>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-handle"><span class="red">*</span>Handle</label>
						<p class="small">Please use all lowercase, and no spaces or special characters. This is not editable later and is how other users will identify you when sharing events</p>
					</th>
					<td>
						<input type="text" id="megacal-register-handle" class="required" name="handle" value="" placeholder="acmeorganization" />
						<button id="megacal-check-handle-button" class="button button-secondary" disabled>Check Handle</button>
						<?php wp_nonce_field( '_megacal_check_handle_nonce', '_megacal_check_handle_nonce' ); ?>
					</td>
				</tr>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-email"><span class="red">*</span>Email</label>
					</th>
					<td>
						<input type="email" id="megacal-register-email" class="required" name="email" value="" placeholder="email@example.com" />
					</td>
				</tr>
				<tr class="megacal_row">
					<th scope="row">
						<label for="megacal-register-phone">Phone</label>
					</th>
					<td>
						<input type="phone" id="megacal-register-phone" name="phone" value="" placeholder="555-555-5555" />
					</td>
				</tr>
				
			</tbody>
		</table>

		<button type="submit" class="button button-primary megacal-register-button" disabled>Get API Key</button>
		<p class="small">By signing up for the MegaCalendar API, you agree to our <a href="https://megabase.co/terms-of-service" target="_blank">Terms of Service</a> and <a href="https://megabase.co/privacy-policy/" target="_blank">Privacy Policy</a></p>

	</form>
	