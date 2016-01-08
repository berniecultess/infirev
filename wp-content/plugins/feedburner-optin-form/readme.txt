=== Feedburner Optin Form ===
Tags: rss, feedburner, optin, form, subscribers, email
Requires at least: 3.5
Tested up to: 3.9
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a Feedburner email subscription form on your posts or pages.

== Description ==

This plugin adds an email subscription form anywhere on your WordPress website for your Feedburner RSS feed. Add it to the end of posts to increase your subscriber count. This plugin is an implementation of the FeedBurner Optin form found <a href="http://www.wpsquare.com/add-feedburner-optin-form-wordpress-blog/">here</a>.

There are two different formats: a 'main' format for most applications, and a 'sidebar' format for putting the form into your sidebar or smaller areas.

Disclaimer: This plugin is not affiliated with or endorsed by Feedburner.

<h3>If you need help with this plugin</h3>

If this plugin breaks your site or just flat out does not work, please go to <a href="http://wordpress.org/plugins/feedburner-optin-form/#compatibility">Compatibility</a> and click "Broken" after verifying your WordPress version and the version of the plugin you are using.

Then, create a thread in the <a href="http://wordpress.org/support/plugin/feedburner-optin-form">Support</a> forum with a description of the issue. Make sure you are using the latest version of WordPress and the plugin before reporting issues, to be sure that the issue is with the current version and not with an older version where the issue may have already been fixed.

<strong>Please do not use the <a href="http://wordpress.org/support/view/plugin-reviews/feedburner-optin-form">Reviews</a> section to report issues or request new features.</strong>

= Features =

<ul>
<li>Display on any post or page</li>
<li>Completely self contained, includes CSS from blog post</li>
<li>CSS is only included on posts or pages where form is displayed</li>
<li>Automatically insert at the end of single posts</li>
<li>CSS and JS files automatically bust caches</li>
<li>Responsive CSS for mobile devices</li>
</ul>

= Shortcode =

To display the form on any post or page, use this shortcode:

[fb-optin-form]

Make sure you go to the plugin settings page after installing to set options. You may also pass the Feedburner userid through the shortcode.

<strong>If you use and enjoy this plugin, please rate it and click the "Works" button below so others know that it works with the latest version of WordPress.</strong>

Spanish translation courtesy of Andrew Kurtis @ <a rel="nofollow" href="http://www.webhostinghub.com/">WebHostingHub</a>

== Installation ==

1. Upload plugin file through the WordPress interface.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings &raquo; Feedburner Optin Form, configure plugin.
4. Insert shortcode on posts or pages, or use PHP function in functions.php or a plugin.

== Frequently Asked Questions ==

= How do I use the plugin? =

1. Use the shortcode to insert the form wherever you want:

`[fb-optin-form]`

You must set the userid on the plugin's Settings page.

2. Allow the plugin to auto-insert the form at the end of your blog posts. Or,

3. Call the plugin function from your PHP code:

`if (function_exists('get_fb_optin_form')) {
  $atts = array(
    'uid' => 'my_feedburner_userid',
    'show' => true
  );
  get_fb_optin_form($atts);
}`

You must pass your Feedburner userid to the plugin, either at runtime (in the shortcode) or on the plugin Settings page. The userid is the part at the end of the URL that identifies your feed. Ex: http://feeds2.feedburner.com/MyFeedburnerFeed

Then <strong>MyFeedburnerFeed</strong> is the userid you would use.

= What are the plugin defaults? =

The plugin arguments and default values may change over time. To get the latest list of arguments and defaults, look at the settings page after installing the plugin. That is where the latest list will always be located.

= I want to use the plugin in a widget. How? =

Add this line of code to your functions.php:

`add_filter('widget_text', 'do_shortcode');`

Or, install a plugin to do it for you: http://blogs.wcnickerson.ca/wordpress/plugins/widgetshortcodes/

Now, using the built-in text widget that comes with WordPress, insert the [fb-optin-form] shortcode into the text widget. See above for how to use the shortcode.

See http://digwp.com/2010/03/shortcodes-in-widgets/ for a detailed example.

<strong>Make sure you use the 'sidebar' option (not 'main').</strong>

= I don't want the post editor toolbar button. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_enqueue_scripts', 'fboif_ed_buttons');`

= I inserted the shortcode but don't see anything on the page. =

Clear your browser cache and also clear your cache plugin (if any). If you still don't see anything, check your webpage source for the following:

`<!-- Feedburner Optin Form: plugin is disabled. Check Settings page. -->`

This means you didn't pass a necessary setting to the plugin, so it disabled itself. You need to pass at least the Feedburner userid, either by entering it on the settings page or passing it to the plugin in the shortcode or PHP function. You should also check that the "enabled" checkbox on the plugin settings page is checked. If that box is not checked, the plugin will do nothing even if you pass it a userid.

= How can I style the output? =

Look in the plugin 'css' subfolder. There are two CSS files, one for 'main' format and one for 'sidebar' format. Depending on which one you are using, open the appropriate file to see which styles are being used, then override them in your local stylesheet.

Please do a google search for how to override CSS.

= I don't want the admin CSS. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_head', 'insert_fboif_admin_css');`

= I don't see the plugin toolbar button(s). =

This plugin adds one or more toolbar buttons to the HTML editor. You will not see them on the Visual editor.

The label on the toolbar button is "FB Form".

= I want to display both the sidebar and full-width versions of the form on the same page. =

There is a parameter called "style" which has two possible values: <strong>main</strong> and <strong>sidebar</strong>

Pass these values to the shortcode like this:

`[fb-optin-form style="sidebar"]`
`[fb-optin-form style="main"]`

'Main' is the default value but I always recommend specifying which one you want in case the default ever changes.

In this way, you can display the sidebar version in your sidebar as well as the main version (full width) at the bottom of your posts at the same time.

= I am getting the error message "The feed does not have subscriptions by email enabled" but I have enabled subscriptions by email. =

See http://wordpress.org/support/topic/change-the-font-size-4

Make sure you are using the Feedburner ID, <strong>not</strong> the full URL, in the plugin settings page. <strong>Only the Feedburner ID should be used</strong> -- the plugin will construct the necessary HTML to allow visitors to subscribe to your feed.

= I am using the shortcode but the parameters aren't working. =

On the plugin settings page, go to the "Parameters" tab. There is a list of possible parameters there along with the default values. Make sure you are spelling the parameters correctly.

The Parameters tab also contains sample shortcode and PHP code.

= The form does not display in my language. =

Make sure you have set the `WPLANG` constant in your wp-config.php. See http://codex.wordpress.org/Editing_wp-config.php#Language_and_Language_Directory or http://www.wpbeginner.com/wp-tutorials/how-to-install-wordpress-in-other-languages/

The plugin defaults to `en_US` if the `WPLANG` constant is not set.

== Screenshots ==

1. Plugin settings page
2. The 'sidebar' and 'main' layouts

== Changelog ==

= 0.2.8 =
- minor CSS update for submit button alignment

= 0.2.7 =
- updated .pot file and readme

= 0.2.6 =
- removed nofollow option (makes no sense here)
- added option to hide the name field, to only ask for email address
- switched sentiment of two options to solve minor bug
- fixed validation issue

= 0.2.5 =
- compressed CSS
- minor code optimizations

= 0.2.4 =
- permanent fix for Undefined Index issue
- plugin now checks and displays form in local language (use WPLANG in wp-config.php to define your language)
- admin CSS and page updates
- improved onblur and onfocus events for textboxes

= 0.2.3 =
- code fix

= 0.2.2 =
- minor code fix
- updated support tab

= 0.2.1 =
- if plugin is temporarily disabled (from plugin settings page) skip some code to save some cycles
- minor code fix

= 0.2.0 = 
- code fix

= 0.1.9 =
- option to display for non-logged-in users only
- code optimizations
- use 'uid' or 'userid' as the Feedburner userid parameter name
- plugin settings page is now tabbed
- responsive CSS for mobile devices

= 0.1.8 =
- added Spanish translation thanks to Andrew Kurtis @ WebHostingHub

= 0.1.7 =
- fix for wp_kses

= 0.1.6 =
- fix for wp_kses

= 0.1.5 =
- by request, sanitization method of title was changed
- some minor code optimizations
- verified compatibility with 3.9

= 0.1.4 =
- OK, I am going to stop playing with the plugin now. Version check rolled back (again)

= 0.1.3 =
- prepare strings for internationalization
- plugin now requires WP 3.5 and PHP 5.0 and above, gracefully deactivate otherwise
- minor code optimization

= 0.1.2 =
- minor plugin settings page update

= 0.1.1 =
- fixed typo that might throw errors in some browsers
- minor bug with parameter table on plugin settings page

= 0.1.0 =
- added submit button to top of plugin settings form
- updated CSS a bit

= 0.0.9 =
- heading over the form can now be customized
- CSS and JS files will automatically bust caches
- removed screen_icon() (deprecated)
- updated to WP 3.8.1
- documented the 'style' parameter

= 0.0.8 =
- refactored admin CSS
- added helpful links on plugin settings page and plugins page

= 0.0.7 =
fixed the fix I made in 0.0.5

= 0.0.6 =
fixed minor bug in shortcode

= 0.0.5 =
fixed uninstall routine, actually deletes options now

= 0.0.4 =
- updated the plugin settings page list of parameters to indicate whether they are required or not
- updated FAQ section of readme.txt

= 0.0.3 =
some security hardening added

= 0.0.2 =
updated admin code
fixed sidebar css

= 0.0.1 =
created

== Upgrade Notice ==

= 0.2.8 =
- minor CSS update for submit button alignment

= 0.2.7 =
- updated .pot file and readme

= 0.2.6 =
- removed nofollow option; added option to hide the name field, to only ask for email address; switched sentiment of two options to solve minor bug; fixed validation issue

= 0.2.5 =
- compressed CSS; minor code optimizations

= 0.2.4 =
- permanent fix for Undefined Index issue; plugin now checks and displays form in local language (use WPLANG in wp-config.php to define your language); admin CSS and page updates; improved onblur and onfocus events for textboxes

= 0.2.3 =
- code fix

= 0.2.2 =
- minor code fix; updated support tab

= 0.2.1 =
- added enabled checks; minor code fix

= 0.2.0 = 
- code fix

= 0.1.9 =
- option to display for non-logged-in users only; code optimizations; use 'uid' or 'userid' as the Feedburner userid parameter name; plugin settings page is now tabbed; responsive CSS for mobile devices

= 0.1.8 =
- added Spanish translation thanks to Andrew Kurtis @ WebHostingHub

= 0.1.7 =
- fix for wp_kses

= 0.1.6 =
- fix for wp_kses

= 0.1.5 =
- by request, sanitization method of title was changed, some minor code optimizations, verified compatibility with 3.9

= 0.1.4 =
- OK, I am going to stop playing with the plugin now. Version check rolled back (again)

= 0.1.3 =
- prepare strings for internationalization, plugin now requires WP 3.5 and PHP 5.0 and above (gracefully deactivate otherwise), minor code optimization

= 0.1.2 =
- minor plugin settings page update

= 0.1.1 =
- fixed typo that might throw errors in some browsers, minor bug with parameter table on plugin settings page

= 0.1.0 =
- added submit button to top of plugin settings form, updated CSS a bit

= 0.0.9 =
- heading over the form can now be customized, 
- CSS and JS files will automatically bust caches, 
- removed screen_icon() (deprecated), 
- updated to WP 3.8.1

= 0.0.8 =
- refactored admin CSS
- added helpful links on plugin settings page and plugins page

= 0.0.7 =
fixed the fix I made in 0.0.5

= 0.0.6 =
fixed minor bug in shortcode

= 0.0.5 =
fixed uninstall routine, actually deletes options now

= 0.0.4 =
- updated the plugin settings page list of parameters to indicate whether they are required or not
- updated FAQ section of readme.txt

= 0.0.3 =
some security hardening added

= 0.0.2 =
updated admin code
fixed sidebar css

= 0.0.1 =
created