<?php
/*
Plugin Name: Feedburner Optin Form
Plugin URI: http://www.jimmyscode.com/wordpress/feedburner-optin-form/
Description: Display a Feedburner subscription form on your site.
Version: 0.2.8
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/
if (!defined('FBOIF_PLUGIN_NAME')) {
	// plugin constants
	define('FBOIF_PLUGIN_NAME', 'Feedburner Optin Form');
	define('FBOIF_VERSION', '0.2.8');
	define('FBOIF_SLUG', 'feedburner-optin-form');
	define('FBOIF_LOCAL', 'fb_optin_form');
	define('FBOIF_OPTION', 'fboif');
	define('FBOIF_OPTIONS_NAME', 'fboif_options');
	define('FBOIF_PERMISSIONS_LEVEL', 'manage_options');
	define('FBOIF_PATH', plugin_basename(dirname(__FILE__)));
	/* default values */
	define('FBOIF_DEFAULT_ENABLED', true);
	define('FBOIF_DEFAULT_UID', '');
	define('FBOIF_DEFAULT_STYLE', 'main');
	define('FBOIF_DEFAULT_SHOW', false);
	define('FBOIF_DEFAULT_AUTO_INSERT', false);
	define('FBOIF_DEFAULT_NONLOGGEDONLY', false);
	define('FBOIF_AVAILABLE_STYLES', 'main,sidebar');
	define('FBOIF_TITLE_TEXT', 'Like this Article? Subscribe to Our Feed!');
	define('FBOIF_HIDE_TITLE', false);
	define('FBOIF_HIDE_NAME', false);
	/* option array member names */
	define('FBOIF_DEFAULT_ENABLED_NAME', 'enabled');
	define('FBOIF_DEFAULT_UID_NAME', 'uid');
	define('FBOIF_DEFAULT_STYLE_NAME', 'style');
	define('FBOIF_DEFAULT_SHOW_NAME', 'show');
	define('FBOIF_DEFAULT_AUTO_INSERT_NAME', 'autoinsert');
	define('FBOIF_TITLE_TEXT_NAME', 'titletext');
	define('FBOIF_DEFAULT_NONLOGGEDONLY_NAME', 'nonloggedonly');
	define('FBOIF_HIDE_TITLE_NAME', 'includetitle');
	define('FBOIF_HIDE_NAME_NAME', 'hidename');
}
	// oh no you don't
	if (!defined('ABSPATH')) {
		wp_die(__('Do not access this file directly.', fboif_get_local()));
	}

	// localization to allow for translations
	add_action('init', 'fboif_translation_file');
	function fboif_translation_file() {
		$plugin_path = fboif_get_path() . '/translations';
		load_plugin_textdomain(fboif_get_local(), '', $plugin_path);
		register_fboif_styles();
	}
	// tell WP that we are going to use new options
	// also, register the admin CSS file for later inclusion
	add_action('admin_init', 'fboif_options_init');
	function fboif_options_init() {
		register_setting(FBOIF_OPTIONS_NAME, fboif_get_option(), 'fboif_validation');
		register_fboif_admin_style();
		register_fboif_admin_script();
	}
	// validation function
	function fboif_validation($input) {
		if (!empty($input)) {
			// validate all form fields
			$input[FBOIF_DEFAULT_UID_NAME] = sanitize_text_field($input[FBOIF_DEFAULT_UID_NAME]);
			$input[FBOIF_DEFAULT_STYLE_NAME] = sanitize_text_field($input[FBOIF_DEFAULT_STYLE_NAME]);
			$input[FBOIF_TITLE_TEXT_NAME] = wp_kses_post($input[FBOIF_TITLE_TEXT_NAME]);
			$input[FBOIF_DEFAULT_AUTO_INSERT_NAME] = (bool)$input[FBOIF_DEFAULT_AUTO_INSERT_NAME];
			$input[FBOIF_DEFAULT_ENABLED_NAME] = (bool)$input[FBOIF_DEFAULT_ENABLED_NAME];
			$input[FBOIF_DEFAULT_NONLOGGEDONLY_NAME] = (bool)$input[FBOIF_DEFAULT_NONLOGGEDONLY_NAME];
			$input[FBOIF_HIDE_TITLE_NAME] = (bool)$input[FBOIF_HIDE_TITLE_NAME];
			$input[FBOIF_HIDE_NAME_NAME] = (bool)$input[FBOIF_HIDE_NAME_NAME];
		}
		return $input;
	}
	// add Settings sub-menu
	add_action('admin_menu', 'fboif_plugin_menu');
	function fboif_plugin_menu() {
		add_options_page(FBOIF_PLUGIN_NAME, FBOIF_PLUGIN_NAME, FBOIF_PERMISSIONS_LEVEL, fboif_get_slug(), 'fboif_page');
	}
	// plugin settings page
	// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
	function fboif_page() {
		// check perms
		if (!current_user_can(FBOIF_PERMISSIONS_LEVEL)) {
			wp_die(__('You do not have sufficient permission to access this page', fboif_get_local()));
		}
		?>
		<div class="wrap">
			<h2 id="plugintitle"><img src="<?php echo fboif_getimagefilename('fb.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php echo FBOIF_PLUGIN_NAME; _e(' by ', fboif_get_local()); ?><a href="http://www.jimmyscode.com/">Jimmy Pe&ntilde;a</a></h2>
			<div><?php _e('You are running plugin version', fboif_get_local()); ?> <strong><?php echo FBOIF_VERSION; ?></strong>.</div>

			<?php /* http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971 */ ?>
			<?php $active_tab = (isset($_GET['tab']) ? $_GET['tab'] : 'settings'); ?>
			<h2 class="nav-tab-wrapper">
			  <a href="?page=<?php echo fboif_get_slug(); ?>&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', fboif_get_local()); ?></a>
				<a href="?page=<?php echo fboif_get_slug(); ?>&tab=parameters" class="nav-tab <?php echo $active_tab == 'parameters' ? 'nav-tab-active' : ''; ?>"><?php _e('Parameters', fboif_get_local()); ?></a>
				<a href="?page=<?php echo fboif_get_slug(); ?>&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', fboif_get_local()); ?></a>
			</h2>
			
			<form method="post" action="options.php">
				<?php settings_fields(FBOIF_OPTIONS_NAME); ?>
				<?php $options = fboif_getpluginoptions(); ?>
				<?php update_option(fboif_get_option(), $options); ?>
				<?php if ($active_tab == 'settings') { ?>
					<h3 id="settings"><img src="<?php echo fboif_getimagefilename('settings.png'); ?>" title="" alt="" height="61" width="64" align="absmiddle" /> <?php _e('Plugin Settings', fboif_get_local()); ?></h3>
					<table class="form-table" id="theme-options-wrap">
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', fboif_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_ENABLED_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', fboif_checkifset(FBOIF_DEFAULT_ENABLED_NAME, FBOIF_DEFAULT_ENABLED, $options)); ?> /></td>
						</tr>
						<?php fboif_explanationrow(__('Is plugin enabled? Uncheck this to turn it off temporarily.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter the default userid, if you do not pass a value to the plugin.', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_UID_NAME; ?>]"><?php _e('Default Feedburner userid', fboif_get_local()); ?></label></strong></th>
							<td><input type="text" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_UID_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_UID_NAME; ?>]" value="<?php echo fboif_checkifset(FBOIF_DEFAULT_UID_NAME, FBOIF_DEFAULT_UID, $options); ?>" /></td>
						</tr>
						<?php fboif_explanationrow(__('Enter the default Feedburner userid. This value will be used if you do not pass a value to the plugin via shortcode.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Select the style you would like to use as the default.', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_STYLE_NAME; ?>]"><?php _e('Default style', fboif_get_local()); ?></label></strong></th>
							<td><select id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_STYLE_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_STYLE_NAME; ?>]">
							<?php $designstyles = explode(",", FBOIF_AVAILABLE_STYLES);
								sort($designstyles);
								foreach($designstyles as $designstyle) {
									echo '<option value="' . $designstyle . '"' . selected($designstyle, fboif_checkifset(FBOIF_DEFAULT_STYLE_NAME, FBOIF_DEFAULT_STYLE, $options), false) . '>' . $designstyle . '</option>';
							} ?>
							</select></td>
						</tr>
						<?php fboif_explanationrow(__('Select the style you would like to use as the default.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Check this box to automatically insert the output at the end of blog posts. If you do not do this then you will need to manually insert shortcode or call the function in PHP.', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_AUTO_INSERT_NAME; ?>]"><?php _e('Auto insert form at the end of posts?', fboif_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_AUTO_INSERT_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_AUTO_INSERT_NAME; ?>]" value="1" <?php checked('1', fboif_checkifset(FBOIF_DEFAULT_AUTO_INSERT_NAME, FBOIF_DEFAULT_AUTO_INSERT, $options)); ?> /></td>
						</tr>
						<?php fboif_explanationrow(__('Check this box to automatically insert the output at the end of blog posts. If you don\'t do this then you will need to manually insert shortcode or call the function in PHP.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Hide name on the form?', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_NAME_NAME; ?>]"><?php _e('Hide name on the form?', fboif_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_NAME_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_NAME_NAME; ?>]" value="1" <?php checked('1', fboif_checkifset(FBOIF_HIDE_NAME_NAME, FBOIF_HIDE_NAME, $options)); ?> /></td>
						</tr>
						<?php fboif_explanationrow(__('Check this box to hide the name field on the form. If checked, only email address field will be displayed.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Hide title text above the form?', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_TITLE_NAME; ?>]"><?php _e('Hide title text above the form?', fboif_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_TITLE_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_HIDE_TITLE_NAME; ?>]" value="1" <?php checked('1', fboif_checkifset(FBOIF_HIDE_TITLE_NAME, FBOIF_HIDE_TITLE, $options)); ?> /></td>
						</tr>
						<?php fboif_explanationrow(__('Check this box to hide the title text above the form. If checked, no title will be shown.', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter the default title text that appears before the signup form.', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_TITLE_TEXT_NAME; ?>]"><?php _e('Default title text', fboif_get_local()); ?></label></strong></th>
							<td><input type="text" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_TITLE_TEXT_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_TITLE_TEXT_NAME; ?>]" value="<?php echo fboif_checkifset(FBOIF_TITLE_TEXT_NAME, FBOIF_TITLE_TEXT, $options); ?>" /></td>
						</tr>
						<?php fboif_explanationrow(__('Enter the default title text that appears before the signup form (\'main\' only).', fboif_get_local())); ?>
						<?php fboif_getlinebreak(); ?>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Show output to non-logged in users only?', fboif_get_local()); ?>" for="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_NONLOGGEDONLY_NAME; ?>]"><?php _e('Show output to non-logged in users only?', fboif_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_NONLOGGEDONLY_NAME; ?>]" name="<?php echo fboif_get_option(); ?>[<?php echo FBOIF_DEFAULT_NONLOGGEDONLY_NAME; ?>]" value="1" <?php checked('1', fboif_checkifset(FBOIF_DEFAULT_NONLOGGEDONLY_NAME, FBOIF_DEFAULT_NONLOGGEDONLY, $options)); ?> /></td>
						</tr>
						<?php fboif_explanationrow(__('Check this box to display the Feedburner signup form to non-logged-in users only.', fboif_get_local())); ?>
					</table>
					<?php submit_button(); ?>
				<?php } elseif ($active_tab == 'parameters') { ?>
					<h3 id="parameters"><img src="<?php echo fboif_getimagefilename('parameters.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Plugin Parameters and Default Values', fboif_get_local()); ?></h3>
					These are the parameters for using the shortcode, or calling the plugin from your PHP code.
			
					<?php echo fboif_parameters_table(fboif_get_local(), fboif_shortcode_defaults(), fboif_required_parameters()); ?>			

					<h3 id="examples"><img src="<?php echo fboif_getimagefilename('examples.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Shortcode and PHP Examples', fboif_get_local()); ?></h3>
					<h4><?php _e('Shortcode Format:', fboif_get_local()); ?></h4>
					<?php echo fboif_get_example_shortcode('fb-optin-form', fboif_shortcode_defaults(), fboif_get_local()); ?>

					<h4><?php _e('PHP Format:', fboif_get_local()); ?></h4>
					<?php echo fboif_get_example_php_code('fb-optin-form', 'get_fb_optin_form', fboif_shortcode_defaults()); ?>
					<?php _e('<small>Note: \'show\' is false by default; set it to <strong>true</strong> echo the output, or <strong>false</strong> to return the output to your PHP code.</small>', fboif_get_local()); ?>
				<?php } else { ?>
					<h3 id="support"><img src="<?php echo fboif_getimagefilename('support.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Support', fboif_get_local()); ?></h3>
					<div class="support">
						<?php echo fboif_getsupportinfo(fboif_get_slug(), fboif_get_local()); ?>
						<small><?php _e('Disclaimer: This plugin is not affiliated with or endorsed by Feedburner.', fboif_get_local()); ?></small>
					</div>
				<?php } ?>
			</form>
		</div>
		<?php }

	// shortcode and function
	add_shortcode('fb-optin-form', 'get_fb_optin_form');
	add_shortcode('feedburner-optin-form', 'get_fb_optin_form');
	function get_fb_optin_form($atts) {
		// get parameters
		extract(shortcode_atts(fboif_shortcode_defaults(), $atts));
		// plugin is enabled/disabled from settings page only
		$options = fboif_getpluginoptions();
		if (!empty($options)) {
			$enabled = (bool)$options[FBOIF_DEFAULT_ENABLED_NAME];
		} else {
			$enabled = FBOIF_DEFAULT_ENABLED;
		}

		// initialize (is this necessary?)
		$output = '';
		
		// ******************************
		// derive shortcode values from constants
		// ******************************
		if ($enabled) {
			$temp_uid = constant('FBOIF_DEFAULT_UID_NAME');
			$uid = $$temp_uid;
			$temp_style = constant('FBOIF_DEFAULT_STYLE_NAME');
			$style = $$temp_style;
			$temp_show = constant('FBOIF_DEFAULT_SHOW_NAME');
			$show = $$temp_show;
			$temp_tt = constant('FBOIF_TITLE_TEXT_NAME');
			$title_text = $$temp_tt;
			$temp_nlo = constant('FBOIF_DEFAULT_NONLOGGEDONLY_NAME');
			$nonloggedonly = $$temp_nlo;
			$temp_hidetitle = constant('FBOIF_HIDE_TITLE_NAME');
			$hidetitle = $$temp_hidetitle;
			$temp_hidename = constant('FBOIF_HIDE_NAME_NAME');
			$hidename = $$temp_hidename;
		}

		// ******************************
		// sanitize user input
		// ******************************
		if ($enabled) {
			$uid = sanitize_text_field($uid);
			$style = sanitize_text_field($style);
			if (!$style) {
				$style = FBOIF_DEFAULT_STYLE;
			}
			$show = (bool)$show;
			$title_text = wp_kses_post($title_text);
			$nonloggedonly = (bool)$nonloggedonly;
			$hidetitle = (bool)$hidetitle;
			$hidename = (bool)$hidename;

			// allow alternate parameter names for uid
			if (!empty($atts['userid'])) {
				$uid = sanitize_text_field($atts['userid']);
			}
		}
		// ******************************
		// check for parameters, then settings, then defaults
		// ******************************
		if ($enabled) {
			if ($uid === FBOIF_DEFAULT_UID) { // no userid passed to function, try settings page
				$uid = $options[FBOIF_DEFAULT_UID_NAME];
				if (!$uid) { // disable plugin because without the userid it's pointless
					$enabled = false;
					$output = '<!-- ' . FBOIF_PLUGIN_NAME . ': ';
					$output .= __('plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page.', fboif_get_local());
					$output .= ' -->';
				}
			}
			if ($enabled) { // same some cycles if the plugin was disabled above
				$title_text = fboif_setupvar($title_text, FBOIF_TITLE_TEXT, FBOIF_TITLE_TEXT_NAME, $options);
				$nonloggedonly = fboif_setupvar($nonloggedonly, FBOIF_DEFAULT_NONLOGGEDONLY, FBOIF_DEFAULT_NONLOGGEDONLY_NAME, $options);
				$hidetitle = fboif_setupvar($hidetitle, FBOIF_HIDE_TITLE, FBOIF_HIDE_TITLE_NAME, $options);
				$hidename = fboif_setupvar($hidename, FBOIF_HIDE_NAME, FBOIF_HIDE_NAME_NAME, $options);

				if ($style === FBOIF_DEFAULT_STYLE) {
					$style = $options[FBOIF_DEFAULT_STYLE_NAME];
					if ($style === false) {
						$style = FBOIF_DEFAULT_STYLE;
					}
				} else { // make sure it's one of the built-in style names
					$styles = explode(",", FBOIF_AVAILABLE_STYLES);
					if (!in_array($style, $styles)) { // use default
						$style = FBOIF_DEFAULT_STYLE;
					}
				}
			}
		} // end enabled check

		// ******************************
		// do some actual work
		// ******************************
		if ($enabled) {
			if (is_user_logged_in() && $nonloggedonly) {
				// user is logged on but we don't want to show it to logged in users
				$output = '<!-- ' . FBOIF_PLUGIN_NAME . ': ';
				$output .= __('Set to show to non-logged-in users only, and current user is logged in.', fboif_get_local());
				$output .= ' -->';
			} else {
				switch ($style) {
				case 'main':
					// enqueue main CSS
					fboif_main_style();
					$output = '<div id="optin-single">';
					if (!$hidetitle) {
						if ($title_text !== false) {
							$output .= '<h4>' . $title_text . '</h4>';
						}
					}
					break;
				case 'sidebar':
					// enqueue sidebar CSS
					fboif_sidebar_style();
					$output = '<div id="optin-sidebar">';
					break;
				}

				$output .= '<form onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri=' . $uid . '\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true" target="popupwindow" method="post" action="http://feedburner.google.com/fb/a/mailverify">';
				$output .= '<input type="hidden" name="uri" value="' . $uid . '">';
				$output .= '<input type="hidden" value="' . ((defined('WPLANG') && (strlen(WPLANG) > 0)) ? WPLANG : 'en_US') . '" name="loc">';
				if (!$hidename) {
					$output .= '<p><input type="text" id="name" name="name" onblur="if (\'\' === this.value) {this.value = \'' . __('Name', fboif_get_local()) . '\';}" onfocus="if (\'' . __('Name', fboif_get_local()) . '\' === this.value) {this.value = \'\';}" value="' . __('Name', fboif_get_local()) . '"></p>';
				}
				$output .= '<p><input type="text" id="email" name="email" onblur="if (\'\' === this.value) {this.value = \'' . __('Email Address', fboif_get_local()) . '\';}" onfocus="if (\'' . __('Email Address', fboif_get_local()) . '\' === this.value) {this.value = \'\';}" value="' . __('Email Address', fboif_get_local()) . '"></p>';
				$output .= '<p><input type="tel" id="phone" name="phone" onblur="if (\'\' === this.value) {this.value = \'' . __('Phone Number', fboif_get_local()) . '\';}" onfocus="if (\'' . __('Phone Number', fboif_get_local()) . '\' === this.value) {this.value = \'\';}" value="' . __('Phone Number', fboif_get_local()) . '"></p>';
				$output .= '<p><input type="submit" value="' . __('Subscribe Now', fboif_get_local()) . '" id="submit" name="submit"></p></form>';
				$output .= '</div>';
			}
		} else { // plugin disabled
			$output = '<!-- ' . FBOIF_PLUGIN_NAME . ': ' . __('plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page.', fboif_get_local()) . ' -->';
		}
		// do we want to return or echo output? default is 'return'
		if ($show) {
			echo $output;
		} else {
			return $output;
		}
	} // end shortcode function
	// auto insert at end of posts?
	add_action('the_content', 'fboif_insert_fboif');
	function fboif_insert_fboif($content) {
		if (is_single()) {
			$fboifoptions = fboif_getpluginoptions();
			$enabled = (bool)$fboifoptions[FBOIF_DEFAULT_ENABLED_NAME];
			
			if ($enabled) {
				if ($fboifoptions[FBOIF_DEFAULT_AUTO_INSERT_NAME]) {
					$content .= get_fb_optin_form($fboifoptions);
				}
			}
		}
		return $content;
	}
	// show admin messages to plugin user
	add_action('admin_notices', 'fboif_showAdminMessages');
	function fboif_showAdminMessages() {
		// http://wptheming.com/2011/08/admin-notices-in-wordpress/
		global $pagenow;
		if (current_user_can(FBOIF_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') { // we are on Settings menu
				if (isset($_GET['page'])) {
					if ($_GET['page'] == fboif_get_slug()) { // we are on this plugin's settings page
						$options = fboif_getpluginoptions();
						if (!empty($options)) {
							$enabled = (bool)$options[FBOIF_DEFAULT_ENABLED_NAME];
							$uid = $options[FBOIF_DEFAULT_UID_NAME];
							if (!$enabled) {
								echo '<div id="message" class="error">';
								echo FBOIF_PLUGIN_NAME . ' ' . __('is currently disabled.', fboif_get_local());
								echo '</div>';
							}
							if (($uid === FBOIF_DEFAULT_UID) || ($uid === false)) {
								echo '<div id="message" class="updated">';
								_e('WARNING: No userid specified. You will need to pass a userid to the plugin each time you use the shortcode or PHP function.', fboif_get_local());
								echo '</div>';
							}
						}
					}
				}
			} // end page check
		} // end privilege check
	} // end admin msgs function
	// enqueue admin CSS if we are on the plugin options page
	add_action('admin_head', 'insert_fboif_admin_css');
	function insert_fboif_admin_css() {
		global $pagenow;
		if (current_user_can(FBOIF_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') { // we are on Settings menu
				if (isset($_GET['page'])) {
					if ($_GET['page'] == fboif_get_slug()) { // we are on this plugin's settings page
						fboif_admin_styles();
					}
				}
			}
		}
	}
	
	// add helpful links to plugin page next to plugin name
	// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
	// http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fboif_plugin_settings_link');
	add_filter('plugin_row_meta', 'fboif_meta_links', 10, 2);
	
	function fboif_plugin_settings_link($links) {
		return fboif_settingslink($links, fboif_get_slug(), fboif_get_local());
	}
	function fboif_meta_links($links, $file) {
		if ($file == plugin_basename(__FILE__)) {
			$links = array_merge($links,
			array(
				sprintf(__('<a href="http://wordpress.org/support/plugin/%s">Support</a>', fboif_get_local()), fboif_get_slug()),
				sprintf(__('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', fboif_get_local()), fboif_get_slug()),
				sprintf(__('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a>', fboif_get_local()), fboif_get_slug())
			));
		}
		return $links;	
	}
	
	// enqueue/register the plugin CSS files
	function fboif_sidebar_style() {
		wp_enqueue_style('fboif_sidebar_style');
	}
	function fboif_main_style() {
		wp_enqueue_style('fboif_main_style');
	}
	function register_fboif_styles() {
		wp_register_style('fboif_sidebar_style', 
			plugins_url(fboif_get_path() . '/css/fboif-sidebar.css'), 
			array(), 
			FBOIF_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/fboif-sidebar.css')), 
			'all' );
		wp_register_style('fboif_main_style', 
			plugins_url(fboif_get_path() . '/css/fboif-main.css'), 
			array(), 
			FBOIF_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/fboif-main.css')), 
			'all' );
	}
	// enqueue/register the admin CSS file
	function fboif_admin_styles() {
		wp_enqueue_style('fboif_admin_style');
	}
	function register_fboif_admin_style() {
		wp_register_style('fboif_admin_style',
			plugins_url(fboif_get_path() . '/css/admin.css'),
			array(),
			FBOIF_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/admin.css')),
			'all');
	}
	// enqueue/register the admin JS file
	add_action('admin_enqueue_scripts', 'fboif_ed_buttons');
	function fboif_ed_buttons($hook) {
		if (($hook == 'post-new.php') || ($hook == 'post.php')) {
			wp_enqueue_script('fboif_add_editor_button');
		}
	}
	function register_fboif_admin_script() {
		wp_register_script('fboif_add_editor_button',
			plugins_url(fboif_get_path() . '/js/editor_button.js'), 
			array('quicktags'), 
			FBOIF_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/js/editor_button.js')), 
			true);
	}
	// when plugin is activated, create options array and populate with defaults
	register_activation_hook(__FILE__, 'fboif_activate');
	function fboif_activate() {
		$options = fboif_getpluginoptions();
		update_option(fboif_get_option(), $options);
		
		// delete option when plugin is uninstalled
		register_uninstall_hook(__FILE__, 'uninstall_fboif_plugin');
	}
	function uninstall_fboif_plugin() {
		delete_option(fboif_get_option());
	}
	// generic function that returns plugin options from DB
	// if option does not exist, returns plugin defaults
	function fboif_getpluginoptions() {
		return get_option(fboif_get_option(), 
			array(
				FBOIF_DEFAULT_ENABLED_NAME => FBOIF_DEFAULT_ENABLED, 
				FBOIF_DEFAULT_UID_NAME => FBOIF_DEFAULT_UID, 
				FBOIF_DEFAULT_STYLE_NAME => FBOIF_DEFAULT_STYLE, 
				FBOIF_DEFAULT_AUTO_INSERT_NAME => FBOIF_DEFAULT_AUTO_INSERT, 
				FBOIF_TITLE_TEXT_NAME => FBOIF_TITLE_TEXT, 
				FBOIF_DEFAULT_NONLOGGEDONLY_NAME => FBOIF_DEFAULT_NONLOGGEDONLY,
				FBOIF_HIDE_TITLE_NAME => FBOIF_HIDE_TITLE,
				FBOIF_HIDE_NAME_NAME => FBOIF_HIDE_NAME
			));
	}
	// function to return shortcode defaults
	function fboif_shortcode_defaults() {
		return array(
			FBOIF_DEFAULT_UID_NAME => FBOIF_DEFAULT_UID, 
			FBOIF_DEFAULT_STYLE_NAME => FBOIF_DEFAULT_STYLE, 
			FBOIF_DEFAULT_SHOW_NAME => FBOIF_DEFAULT_SHOW, 
			FBOIF_TITLE_TEXT_NAME => FBOIF_TITLE_TEXT, 
			FBOIF_DEFAULT_NONLOGGEDONLY_NAME => FBOIF_DEFAULT_NONLOGGEDONLY,
			FBOIF_HIDE_TITLE_NAME => FBOIF_HIDE_TITLE,
			FBOIF_HIDE_NAME_NAME => FBOIF_HIDE_NAME
			);
	}
	// function to return parameter status (required or not)
	function fboif_required_parameters() {
		return array(
			true, 
			false, 
			false, 
			false,
			false,
			false,
			false
		);
	}
	
	// encapsulate these and call them throughout the plugin instead of hardcoding the constants everywhere
	function fboif_get_slug() { return FBOIF_SLUG; }
	function fboif_get_local() { return FBOIF_LOCAL; }
	function fboif_get_option() { return FBOIF_OPTION; }
	function fboif_get_path() { return FBOIF_PATH; }
	
	function fboif_settingslink($linklist, $slugname = '', $localname = '') {
		$settings_link = sprintf( __('<a href="options-general.php?page=%s">Settings</a>', $localname), $slugname);
		array_unshift($linklist, $settings_link);
		return $linklist;
	}
	function fboif_setupvar($var, $defaultvalue, $defaultvarname, $optionsarr) {
		if ($var === $defaultvalue) {
			$var = $optionsarr[$defaultvarname];
			if ($var === false) {
				$var = $defaultvalue;
			}
		}
		return $var;
	}
	function fboif_getsupportinfo($slugname = '', $localname = '') {
		$output = __('Do you need help with this plugin? Check out the following resources:', $localname);
		$output .= '<ol>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/support/plugin/%s">Support Forum</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://www.jimmyscode.com/wordpress/%s">Plugin Homepage / Demo</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/developers/">Development</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/changelog/">Changelog</a><br />', $localname), $slugname) . '</li>';
		$output .= '</ol>';
		
		$output .= sprintf( __('If you like this plugin, please <a href="http://wordpress.org/support/view/plugin-reviews/%s/">rate it on WordPress.org</a>', $localname), $slugname);
		$output .= sprintf( __(' and click the <a href="http://wordpress.org/plugins/%s/#compatibility">Works</a> button. ', $localname), $slugname);
		$output .= '<br /><br /><br />';
		$output .= __('Your donations encourage further development and support. ', $localname);
		$output .= '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" title="Support this plugin" width="92" height="26" /></a>';
		$output .= '<br /><br />';
		return $output;
	}
	
	function fboif_parameters_table($localname = '', $sc_defaults, $reqparms) {
	  $output = '<table class="widefat">';
		$output .= '<thead><tr>';
		$output .= '<th title="' . __('The name of the parameter', $localname) . '"><strong>' . __('Parameter Name', $localname) . '</strong></th>';
		$output .= '<th title="' . __('Is this parameter required?', $localname) . '"><strong>' . __('Is Required?', $localname) . '</strong></th>';
		$output .= '<th title="' . __('What data type this parameter accepts', $localname) . '"><strong>' . __('Data Type', $localname) . '</strong></th>';
		$output .= '<th title="' . __('What, if any, is the default if no value is specified', $localname) . '"><strong>' . __('Default Value', $localname) . '</strong></th>';
		$output .= '</tr></thead>';
		$output .= '<tbody>';
		
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		$required = $reqparms;
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			$output .= '<tr>';
			$output .= '<td><strong>' . $plugin_defaults_keys[$i] . '</strong></td>';
			$output .= '<td>';
			
			if ($required[$i] === true) {
				$output .= '<strong>';
				$output .= __('Yes', $localname);
				$output .= '</strong>';
			} else {
				$output .= __('No', $localname);
			}
			
			$output .= '</td>';
			$output .= '<td>' . gettype($plugin_defaults_values[$i]) . '</td>';
			$output .= '<td>';
			
			if ($plugin_defaults_values[$i] === true) {
				$output .= '<strong>';
				$output .= __('true', $localname);
				$output .= '</strong>';
			} elseif ($plugin_defaults_values[$i] === false) {
				$output .= __('false', $localname);
			} elseif ($plugin_defaults_values[$i] === '') {
				$output .= '<em>';
				$output .= __('this value is blank by default', $localname);
				$output .= '</em>';
			} elseif (is_numeric($plugin_defaults_values[$i])) {
				$output .= $plugin_defaults_values[$i];
			} else { 
				$output .= '"' . $plugin_defaults_values[$i] . '"';
			} 
			$output .= '</td>';
			$output .= '</tr>';
		}
		$output .= '</tbody>';
		$output .= '</table>';
		
		return $output;
	}
	function fboif_get_example_shortcode($shortcodename = '', $sc_defaults, $localname = '') {
		$output = '<pre style="background:#FFF">[' . $shortcodename . ' ';
		
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			if ($plugin_defaults_keys[$i] !== 'show') {
				if (gettype($plugin_defaults_values[$i]) === 'string') {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=\'' . $plugin_defaults_values[$i] . '\'';
				} elseif (gettype($plugin_defaults_values[$i]) === 'boolean') {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=' . ($plugin_defaults_values[$i] == false ? 'false' : 'true');
				} else {
					$output .= '<strong>' . $plugin_defaults_keys[$i] . '</strong>=' . $plugin_defaults_values[$i];
				}
				if ($i < count($plugin_defaults_keys) - 2) {
					$output .= ' ';
				}
			}
		}
		$output .= ']</pre>';
		
		return $output;
	}
	
	function fboif_get_example_php_code($shortcodename = '', $internalfunctionname = '', $sc_defaults) {
		
		$plugin_defaults_keys = array_keys($sc_defaults);
		$plugin_defaults_values = array_values($sc_defaults);
		
		$output = '<pre style="background:#FFF">';
		$output .= 'if (shortcode_exists(\'' . $shortcodename . '\')) {<br />';
		$output .= '  $atts = array(<br />';
		for($i = 0; $i < count($plugin_defaults_keys); $i++) {
			$output .= '    \'' . $plugin_defaults_keys[$i] . '\' => ';
			if (gettype($plugin_defaults_values[$i]) === 'string') {
				$output .= '\'' . $plugin_defaults_values[$i] . '\'';
			} elseif (gettype($plugin_defaults_values[$i]) === 'boolean') {
				$output .= ($plugin_defaults_values[$i] == false ? 'false' : 'true');
			} else {
				$output .= $plugin_defaults_values[$i];
			}
			if ($i < count($plugin_defaults_keys) - 1) {
				$output .= ', <br />';
			}
		}
		$output .= '<br />  );<br />';
		$output .= '   echo ' . $internalfunctionname . '($atts);';
		$output .= '<br />}';
		$output .= '</pre>';
		return $output;	
	}
	function fboif_checkifset($optionname, $optiondefault, $optionsarr) {
		return (isset($optionsarr[$optionname]) ? $optionsarr[$optionname] : $optiondefault);
	}
	function fboif_getlinebreak() {
	  echo '<tr valign="top"><td colspan="2"></td></tr>';
	}
	function fboif_explanationrow($msg = '') {
		echo '<tr valign="top"><td></td><td><em>' . $msg . '</em></td></tr>';
	}
	function fboif_getimagefilename($fname = '') {
		return plugins_url(fboif_get_path() . '/images/' . $fname);
	}
?>