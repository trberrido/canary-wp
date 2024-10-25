<?php defined('ABSPATH') or die ('No script kiddies please !');

/**
 * custom option and settings
 */
add_action( 'admin_init', 'canary__options__init' );
function canary__options__init() {
	// Register a new setting for "wporg" page.
	$args = array(
		'type'			=> 'object',
		'show_in_rest'	=> array(
			'schema'		=> array(
				'type'			=> 'object',
				'properties'	=> array(
					'canary__http_auth__id'		=> array( 'type' => 'string' ),
					'canary__http_auth__psswd'	=> array( 'type' => 'string' )
				)
			)
		)
	);
	register_setting( 'canary__options', 'canary__options', $args );

	add_settings_section(
		'canary__section_options',
		'Options',
		'canary__section_usage__render',
		'canary__options'
	);

	add_settings_field(
		'canary__http_auth__id', //if
		'ID',				// title
		'canary__fields_render__text', // fn
		'canary__options', // option_group
		'canary__section_options', // section name
		array( 'label_for' => 'canary__http_auth__id' ) // $args for fn
	);

	add_settings_field(
		'canary__http_auth__psswd',
		'Password',
		'canary__fields_render__text',
		'canary__options',
		'canary__section_options',
		array( 'label_for' => 'canary__http_auth__psswd' )
	);

	add_settings_field(
		'canary__sitemarker',
		'Marker',
		'canary__fields_render__text',
		'canary__options',
		'canary__section_options',
		array(
			'label_for'		=> 'canary__sitemarker',
			'description'	=> 'Example: production, recette, etc.'
		)
	);
}

/**
 * canary section callback function.
 *
 * @param array $args  The settings array, defining title, id, callback.
 */
function canary__section_usage__render( $args ) {
	?>
	<div id="<?php echo esc_attr( $args['id'] ); ?>">
		<p>Add an ID and password if needed for HTTP authentication.</p>
		<p>One can also add optional string that will be used by canary front and back to differentiate between multiple instances, such as production and staging environments.</p>
	</div>
	<?php
}

/**
 * canary input text field callback function.
 * @param array $args
 */
function canary__fields_render__text( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'canary__options' );
	?>

	<input
		type="text"
		id="<?php echo esc_attr( $args['label_for'] ); ?>"
		name="canary__options[<?php echo esc_attr( $args['label_for'] ); ?>]"
		value="<?php echo ( isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '' ); ?>">

	<?php if ( isset( $args['description'] ) ) : ?>
		<p class="description"><?php echo $args['description']; ?></p>
	<?php endif; ?>

	<?php
}

/**
 * Register options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'canary__options_page' );
function canary__options_page() {
	add_menu_page(
		'Canary',
		'Canary',
		'manage_options',
		'canary',
		'canary__options_page_render',
		'dashicons-welcome-view-site'
	);
}

/**
 * Top level menu callback function
 */
function canary__options_page_render() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'canary_update_messages', 'canary_update_message', 'Settings Saved', 'updated' );
	}

	// show error/update messages
	settings_errors( 'canary_update_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "wporg"
			settings_fields( 'canary__options' );
			// output setting sections and their fields
			// (sections are registered for "wporg", each field is registered to a specific section)
			do_settings_sections( 'canary__options' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}