<?php
/*
Plugin Name: Ultimate Mailing List
Plugin URI: http://infirev.com/
Description: Simple customizable plugin that displays a name/email/phone form where visitors can submit their information, managable in the WordPress admin.
Version: 1.0.0
Author: Bernie Cultess
Author URI: http://infirev.com/
License: GPL


Copyright 2015 Bernie Cultess  (email : )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

GNU General Public License: http://www.gnu.org/licenses/gpl.html

*/

// Plugin Activation
function ml2_install() {
    global $wpdb;
    //print_r($wpdb->prefix);
    $table = $wpdb->prefix."ml2";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        ml2_name VARCHAR(200) NOT NULL,
        ml2_email VARCHAR(200) NOT NULL,
        ml2_phone VARCHAR(200) NOT NULL,
	UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
	
}
register_activation_hook( __FILE__, 'ml2_install' );

// Plugin Deactivation
function ml2_uninstall() {
    global $wpdb;
}
register_deactivation_hook( __FILE__, 'ml2_uninstall' );

// Left Menu Button
function register_ml2_menu() {
	add_menu_page('Mail List', 'Mail List', 'add_users', dirname(__FILE__).'/index.php', '',   plugins_url('ml2-admin-icon.png', __FILE__), 58.122);
}
add_action('admin_menu', 'register_ml2_menu');

// Generate Subscribe Form 

function ml2subform($atts=array()){
	extract(shortcode_atts(array(
		"prepend" => '',  
        "showname" => true,
		"nametxt" => 'Name:',
		"nameholder" => 'Name...',
		"emailtxt" => 'Email:',
		"emailholder" => 'Email Address...',
		"phonetxt" => 'Phone Number:',
		"phoneholder" => 'Phone Number...',
		"showsubmit" => true,
		"submittxt" => 'Submit',
		"jsthanks" => false,
		"thankyou" => 'Thank you for subscribing to our mailing list'
    ), $atts));
	
	$return = '<script type="text/javascript" src="'. plugins_url("mail-subscribe-list-2.0/ml2-validate.js",dirname(__FILE__)).'"></script>';
	$return .= '<div id="ml2-errors"></div>';
	$return .= '<form class="ml2_subscribe" method="post" id="mailing-list"><input class="ml2_hiddenfield" name="ml2_subscribe" type="hidden" value="1"><input class="ml2_hiddenfield" name="showname" type="hidden" value="'.$showname.'"><input class="ml2_hiddenfield" name="jsthanks" type="hidden" value="'.$jsthanks.'">';
	
	if ($prepend) $return .= '<p class="prepend">'.$prepend.'</p>';
	
	
	if ($showname) $return .= '<p class="ml2_name"><label class="ml2_namelabel" for="ml2_name">'.$nametxt.'</label><input class="ml2_nameinput" placeholder="'.$nameholder.'" name="ml2_name" type="text" value=""></p>';
	$return .= '<p class="ml2_email"><label class="ml2_emaillabel" for="ml2_email">'.$emailtxt.'</label><input class="ml2_emailinput" name="ml2_email" placeholder="'.$emailholder.'" type="email" value=""></p>';
	$return .= '<p class="ml2_phone"><label class="ml2_phonelabel" for="ml2_phone">'.$phonetxt.'</label><input class="ml2_phoneinput" name="ml2_phone" placeholder="'.$phoneholder.'" type="tel" value=""></p>';
	if ($showsubmit) $return .= '<p class="ml2_submit"><input name="submit" class="btn ml2_submitbtn" type="submit" value="'.($submittxt?$submittxt:'Submit').'"></p>';
	$return .= '<p class="notinterested"><a href="http://bcultess.services4u.com/"><< Not Interested, But How Can I Support >></a></p>';
	$return .= '</form>';
	
	if ($_POST['ml2_subscribe'] && $thankyou) { 
		if ($jsthanks) {
			$return .= "<script>";
			$return .= "window.onload = function() { alert('".$thankyou."'); window.location.href='http://bcultess.acnibo.com'; }";
			$return .= "</script>";
			//$return .= "<script>";
			//$return .= "setTimeout(function(){window.location.href='http://bcultess.acnrep.com', 500 });";
			//$return .= "</script>";

		} else {
			$return .= '<p class="ml2_thankyou">'.$thankyou.'</p>'; 
		}
		//$return .= "<script type='text/javascript'></script>";
	}
	
 	return $return;
}
add_shortcode( 'ml2subform', 'ml2subform' );

// Ability to use the shortcode within the text widget, - Suggested by Joel Dare, Thank you.
add_filter('widget_text', 'do_shortcode', 11);

//////

// Lets create a Wordpress Widget

// Widget Controller

function ml2_subscribe_widget_control($args=array(), $params=array()) {
	
	if (isset($_POST['ml2_subscribe_submitted']) && current_user_can('edit_theme_options')) {
		update_option('ml2_subscribe_widget_title', $_POST['ml2_subscribe_widget_title']);
		update_option('ml2_subscribe_widget_prepend', $_POST['ml2_subscribe_widget_prepend']);
		update_option('ml2_subscribe_widget_jsthanks', $_POST['ml2_subscribe_widget_jsthanks']);
		update_option('ml2_subscribe_widget_thankyou', $_POST['ml2_subscribe_widget_thankyou']);
		update_option('ml2_subscribe_widget_showname', $_POST['ml2_subscribe_widget_showname']);
		update_option('ml2_subscribe_widget_nametxt', $_POST['ml2_subscribe_widget_nametxt']);
		update_option('ml2_subscribe_widget_nameholder', $_POST['ml2_subscribe_widget_nameholder']);
		update_option('ml2_subscribe_widget_emailtxt', $_POST['ml2_subscribe_widget_emailtxt']);
		update_option('ml2_subscribe_widget_emailholder', $_POST['ml2_subscribe_widget_emailholder']);
		update_option('ml2_subscribe_widget_phonetxt', $_POST['ml2_subscribe_widget_phonetxt']);
		update_option('ml2_subscribe_widget_phoneholder', $_POST['ml2_subscribe_widget_phoneholder']);
		update_option('ml2_subscribe_widget_showsubmit', $_POST['ml2_subscribe_widget_showsubmit']);
		update_option('ml2_subscribe_widget_submittxt', $_POST['ml2_subscribe_widget_submittxt']);
	}
	
	$ml2_subscribe_widget_title = get_option('ml2_subscribe_widget_title');
	$ml2_subscribe_widget_prepend = get_option('ml2_subscribe_widget_prepend');
	$ml2_subscribe_widget_jsthanks = get_option('ml2_subscribe_widget_jsthanks');
	$ml2_subscribe_widget_thankyou = get_option('ml2_subscribe_widget_thankyou');
	$ml2_subscribe_widget_showname = get_option('ml2_subscribe_widget_showname');
	$ml2_subscribe_widget_nametxt = get_option('ml2_subscribe_widget_nametxt');
	$ml2_subscribe_widget_nameholder = get_option('ml2_subscribe_widget_nameholder');
	$ml2_subscribe_widget_emailtxt = get_option('ml2_subscribe_widget_emailtxt');
	$ml2_subscribe_widget_emailholder = get_option('ml2_subscribe_widget_emailholder');
	$ml2_subscribe_widget_phonetxt = get_option('ml2_subscribe_widget_phonetxt');
	$ml2_subscribe_widget_phoneholder = get_option('ml2_subscribe_widget_phoneholder');
	$ml2_subscribe_widget_showsubmit = get_option('ml2_subscribe_widget_showsubmit');
	$ml2_subscribe_widget_submittxt = get_option('ml2_subscribe_widget_submittxt');
	?>

	Title:<br />
	<textarea class="widefat ml2_subscribe_widget_title" rows="5" name="ml2_subscribe_widget_title"><?php echo stripslashes($ml2_subscribe_widget_title); ?></textarea>
	<br /><br />

	Header Text:<br />
	<textarea class="widefat ml2_subscribe_widget_prepend" rows="5" name="ml2_subscribe_widget_prepend"><?php echo stripslashes($ml2_subscribe_widget_prepend); ?></textarea>
	<br /><br />
    
    Thank You Type 
	<select class="ml2_subscribe_widget_jsthanks" name="ml2_subscribe_widget_jsthanks">
    	<option <?php echo ($ml2_subscribe_widget_jsthanks?'selected="selected"':''); ?> value="1">JavaScript Alert</option>
        <option <?php echo (!$ml2_subscribe_widget_jsthanks?'selected="selected"':''); ?> value="0">Widget Header</option>
    </select>
	<br /><br />
    
    Thank You Message<br />
	<textarea class="widefat ml2_subscribe_widget_thankyou" rows="5" name="ml2_subscribe_widget_thankyou"><?php echo stripslashes($ml2_subscribe_widget_thankyou); ?></textarea>
	<br /><br />
    
    Show Name Field <input class="ml2_subscribe_widget_showname" name="ml2_subscribe_widget_showname" type="checkbox"<?php echo $ml2_subscribe_widget_showname?'checked="checked"':''; ?> />
	<br /><br />
    
    <div class="ml2_subscribe_nameoptions" style="display:none">
    
    Name Label text
	<input type="text" class="widefat ml2_subscribe_widget_nametxt" name="ml2_subscribe_widget_nametxt" value="<?php echo stripslashes($ml2_subscribe_widget_nametxt); ?>" />
	<br /><br />
    
    Name Placeholder Text
	<input type="text" class="widefat ml2_subscribe_widget_nameholder" name="ml2_subscribe_widget_nameholder" value="<?php echo stripslashes($ml2_subscribe_widget_nameholder); ?>" />
	<br /><br />
    
    </div>
    
    Email Label Text
	<input type="text" class="widefat ml2_subscribe_widget_emailtxt" name="ml2_subscribe_widget_emailtxt" value="<?php echo stripslashes($ml2_subscribe_widget_emailtxt); ?>" />
	<br /><br />
    
    Email Placeholder Text
	<input type="text" class="widefat ml2_subscribe_widget_emailholder" name="ml2_subscribe_widget_emailholder" value="<?php echo stripslashes($ml2_subscribe_widget_emailholder); ?>" />
	<br /><br />

    Phone Label Text
	<input type="text" class="widefat ml2_subscribe_widget_phonetxt" name="ml2_subscribe_widget_phonetxt" value="<?php echo stripslashes($ml2_subscribe_widget_phonetxt); ?>" />
	<br /><br />
    
    Phone Placeholder Text
	<input type="text" class="widefat ml2_subscribe_widget_phoneholder" name="ml2_subscribe_widget_phoneholder" value="<?php echo stripslashes($ml2_subscribe_widget_phoneholder); ?>" />
	<br /><br />
    
    Show Submit Button <input class="ml2_subscribe_widget_showsubmit" name="ml2_subscribe_widget_showsubmit" type="checkbox"<?php echo $ml2_subscribe_widget_showsubmit?'checked="checked"':''; ?> />
	<br /><br />
    
    <div class="ml2_subscribe_submitoptions" style="display:none">
    
    Submit Button Text
	<input type="text" class="widefat ml2_subscribe_widget_submittxt" name="ml2_subscribe_widget_submittxt" value="<?php echo stripslashes($ml2_subscribe_widget_submittxt); ?>" />
	<br /><br />
    
    </div>

	<input type="hidden" name="ml2_subscribe_submitted" value="1" />
    <script>
		function ml2_subscribe_nameoptions_check() {
			if (jQuery('.ml2_subscribe_widget_showname').is(':checked')) jQuery(".ml2_subscribe_nameoptions").fadeIn();
			else jQuery(".ml2_subscribe_nameoptions").fadeOut();
		}
		function ml2_subscribe_submitoptions_check() {
			if (jQuery('.ml2_subscribe_widget_showsubmit').is(':checked')) jQuery(".ml2_subscribe_submitoptions").fadeIn();
			else jQuery(".ml2_subscribe_submitoptions").fadeOut();
		}
		jQuery(document).ready(function(){
			ml2_subscribe_nameoptions_check();
			ml2_subscribe_submitoptions_check();
			jQuery(".ml2_subscribe_widget_showname").click(function(){ ml2_subscribe_nameoptions_check(); });
			jQuery(".ml2_subscribe_widget_showsubmit").click(function(){ ml2_subscribe_submitoptions_check(); });
		});
    </script>
	<?php
}

wp_register_widget_control(
	'ml2_subscribe_widget',
	'ml2_subscribe_widget',
	'ml2_subscribe_widget_control'
);

// Widget Display

function ml2_subscribe_widget_display($args=array(), $params=array()) {

	$ml2_subscribe_widget_title = get_option('ml2_subscribe_widget_title');
	$ml2_subscribe_widget_prepend = get_option('ml2_subscribe_widget_prepend');
	$ml2_subscribe_widget_jsthanks = get_option('ml2_subscribe_widget_jsthanks');
	$ml2_subscribe_widget_thankyou = get_option('ml2_subscribe_widget_thankyou');
	$ml2_subscribe_widget_showname = get_option('ml2_subscribe_widget_showname');
	$ml2_subscribe_widget_nametxt = get_option('ml2_subscribe_widget_nametxt');
	$ml2_subscribe_widget_nameholder = get_option('ml2_subscribe_widget_nameholder');
	$ml2_subscribe_widget_emailtxt = get_option('ml2_subscribe_widget_emailtxt');
	$ml2_subscribe_widget_emailholder = get_option('ml2_subscribe_widget_emailholder');
	$ml2_subscribe_widget_phonetxt = get_option('ml2_subscribe_widget_phonetxt');
	$ml2_subscribe_widget_phoneholder = get_option('ml2_subscribe_widget_phoneholder');
	$ml2_subscribe_widget_showsubmit = get_option('ml2_subscribe_widget_showsubmit');
	$ml2_subscribe_widget_submittxt = get_option('ml2_subscribe_widget_submittxt');

	//widget output
	echo stripslashes($args['before_widget']);

	echo stripslashes($args['before_title']);
	echo stripslashes($ml2_subscribe_widget_title);
	echo stripslashes($args['after_title']);

	echo '<div class="textwidget">';

	$argss = array(
		'prepend' => $ml2_subscribe_widget_prepend, 
		'showname' => $ml2_subscribe_widget_showname,
		'nametxt' => $ml2_subscribe_widget_nametxt, 
		'nameholder' => $ml2_subscribe_widget_nameholder, 
		'emailtxt' => $ml2_subscribe_widget_emailtxt,
		'emailholder' => $ml2_subscribe_widget_emailholder, 
		'phonetxt' => $ml2_subscribe_widget_phonetxt,
		'phoneholder' => $ml2_subscribe_widget_phoneholder, 
		'showsubmit' => $ml2_subscribe_widget_showsubmit,
		'submittxt' => $ml2_subscribe_widget_submittxt, 
		'jsthanks' => $ml2_subscribe_widget_jsthanks,
		'thankyou' => $ml2_subscribe_widget_thankyou
	);
	echo ml2subform($argss);

	echo '</div>';
  echo stripslashes($args['after_widget']);
}

wp_register_sidebar_widget(
    'ml2_subscribe_widget',
    'Subscribe Form',
    'ml2_subscribe_widget_display',
    array(
        'description' => 'Display Subscribe Form'
    )
);



/////////

// Handle form Post
if ($_POST['ml2_subscribe']) {
	$name = $_POST['ml2_name'];
	$email = $_POST['ml2_email'];
	$phone = $_POST['ml2_phone'];
	if (is_email($email)) {
		
		$exists = mysql_query("SELECT * FROM ".$wpdb->prefix."ml2 where ml2_email like '".$wpdb->escape($email)."' limit 1");
//		if(!$exists){
//			throw new Exception(mysql_error().".  Query was:\n\n".$wpdb."\n\nError number: ".mysql_errno());
//		}
		if (mysql_num_rows($exists) <1) {
			$wpdb->query("insert into ".$wpdb->prefix."ml2 (ml2_name, ml2_email, ml2_phone) values ('".$wpdb->escape($name)."', '".$wpdb->escape($email)."', '".$wpdb->escape($phone)."')");
		}

		$message = "Sir, $name has just filled out the form.\r\n";
		$message .= "Here is their information:\r\n";
		$message .= "\r\n";
		$message .= "$name\r\n$email\r\n$phone\r\n";
		$message .= "\r\n";
		$message .= "Thanks!\r\nAdmin";

		$headers = 'From: Business Interest <bcultess@acnrep.com>' . "\r\n" .
		    'Reply-To: Business Interest <bcultess@acnrep.com>' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail('Bernie Cultess <bcultess.acnibo@gmail.com>', 'Business Interest', $message, $headers);
	}
}

function plugin_get_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}

?>
