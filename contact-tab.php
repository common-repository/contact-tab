<?php
/*
Plugin Name: Contact Tab
Plugin URI: http://webwiki.co/contact-tab
Description: Contact side tab for WordPress with Captcha
Author: Sam Hagin
Version: 1.2
Author URI: http://webwiki.co
*/
//table, id, subject, from/reply to, message, date
global $shct_path, $options,$ctap_options;
$shct_path = plugins_url('/contact-tab/');

function ct_gen() {
	$contact_tab_settings = array(
		'admin_email' => get_option('admin_email'),
		'cc_email'    => '',
		'subject'     => get_option('blogname'),
	        'position'    => 'left', 
		'captcha'     => 'yes',
		'social'      => 'no',
		'facebook'    => '',
		'twitter'     => '',
		'linkedin'    => '',
		'google'      => '',
		'thx'         => 'Your message has been submitted',
                'red'         => 'no',
                'redurl'      => '',

        );
           add_option( 'contact_tab_settings', $contact_tab_settings);
}
 
function ct_ap() {	
	$contact_tab_ap = array(
		'tabcolor' => '3B5998',
		 'bgcolor' => '3B5998',
		     'txt' => '000',
		  'bcolor' => '2441ff', 
		  'tabtxt' => 'fff',
		    'etxt' => 'CC0000',
		    'stxt' => '009900',

	);

		add_option('contact_tab_ap', $contact_tab_ap);
}
function shct_load_scripts() {
global $shct_path;
wp_enqueue_script('jquery');
}

function shct_colorpicker() {
global $shct_path;
wp_enqueue_script('ctjscolor', $shct_path. 'jscolor/jscolor.js');
}

function sh_ad() { ?>
<!--Donate-->
<p style="margin-top:15px;">
                        <p style="font-style: italic; font-weight: bold;color: #26779a;">Need Help ? Check out the documentation for WP Float
at <a href="http://webwiki.co/plugins/contact-tab" target="_blank">WebWiki.Co</a><br
?>If you have found this plugin  useful, please consider making a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CMGALCCS6UUZN"
target="_blank" >donation</a>. Thanks.</p>
&nbsp;&nbsp;<span><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CMGALCCS6UUZN" title="PayPal Donate" target="_blank"><img
 src="<?php echo plugins_url(); ?>/contact-tab/images/paypal.png" /></a></span>

                        <span><a href="http://www.facebook.com/pages/WebWikiCo/220588208033178" title="Our Facebook page" target="_blank"><img
 src="<?php echo plugins_url(); ?>/contact-tab/images/facebook.png" /></a></span>
                        &nbsp;&nbsp;<span><a href="http://www.twitter.com/webhost123" title="Follow on Twitter"
target="_blank"><img  src="<?php echo plugins_url();
?>/contact-tab/images/twitter.png" /></a></span>
                        &nbsp;&nbsp;<span><a href="http://webwiki.co" title="WebWiki.Co" target="_blank"><img
 src="<?php echo plugins_url(); ?>/contact-tab/images/website.png" /></a></span>
                </p>
<!--End-->
<?php } 

function shct_options(){
	add_menu_page('Contact Tab', 'Contact Tab', 'manage_options', __FILE__, 'contact_tab_settings', plugins_url('/contact-tab.gif', __FILE__));
 	add_submenu_page(__FILE__, 'Appearance', 'Appearance', 'manage_options', 'contact-tab-ap', 'contact_tab_ap');
}

function ct_fixie8() {if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8")) {header("X-UA-Compatible: IE=7");}}

add_action('admin_menu', 'shct_options');
add_action('admin_init', 'shct_settings');
add_action('wp_enqueue_scripts', 'shct_load_scripts');
add_action('wp_head', 'shct_tab');
add_action('admin_enqueue_scripts','shct_colorpicker');
add_action('send_headers', 'ct_fixie8');
register_activation_hook(__FILE__, 'ct_gen');
register_activation_hook(__FILE__, 'ct_ap');


function shct_settings() {
	register_setting('contact_tab_settings', 'contact_tab_settings');
	register_setting('contact_tab_ap', 'contact_tab_ap');
}

function contact_tab_settings() {
if (!current_user_can('manage_options'))  {
                wp_die( __('You do not have sufficient permissions to access this page.') );

           }

sh_ad();
?>
<div class="wrap">

                <!-- Display Plugin Icon, Header, and Description -->
                <div class="icon32" id="icon-options-general"><br></div>
                <h2>Contact Tab</h2>
		<h3>General Settings</h3>
                <p></p>

                <!-- Beginning of the Plugin Options Form -->
                <form method="post" action="options.php">
                        <?php settings_fields('contact_tab_settings'); ?>
                        <?php $options = get_option('contact_tab_settings'); ?>
                        <!-- Table Structure Containing Form Controls -->
                        <table class="form-table">
 <tr valign="top">
        <th scope="row">Default Email:</th>
        <td><input type="text" name="contact_tab_settings[admin_email]" value="<?php echo $options['admin_email']; ?>" />
		<br /><span style="color:#666666;margin-left:2px;">Default contact email address</span></td>
        </tr>


 <tr valign="top">
        <th scope="row">Forward To:</th>
        <td><input type="text" name="contact_tab_settings[cc_email]" value="<?php echo $options['cc_email']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Additional email address 
to forward mail to</span></td>
        </tr>


<tr valign="top">
        <th scope="row">Email Subject:</th>
        <td><input type="text" name="contact_tab_settings[subject]" value="<?php echo $options['subject']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Subject for email sent</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Contact Tab Position:</th>
<td><select name="contact_tab_settings[position]">
                        <option value='left' <?php selected( $options['position'], 'left'); ?> >Left</option>
                        <option value='right' <?php selected( $options['position'], 'right'); ?> >Right</option>
	</select>
<br /><span style="color:#666666;margin-left:2px;">Position of Tab</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Show captcha:</th>
<td><select name="contact_tab_settings[captcha]">
                        <option value='yes' <?php selected( $options['captcha'], 'yes'); ?> >Yes</option>
                        <option value='no' <?php selected( $options['captcha'], 'no'); ?> >No</option>
        </select><br />
<span style="color:#666666;margin-left:2px;">Requires GD library and FreeType</span></td></tr>

<tr valign="top">
        <th scope="row">Show Social Networking Icons:</th>
<td><select name="contact_tab_settings[social]">
                        <option value='yes' <?php selected( $options['social'], 'yes'); ?> >Yes</option>
                        <option value='no' <?php selected( $options['social'], 'no'); ?> >No</option>
        </select><br />
<span style="color:#666666;margin-left:2px;">Show icons for Facebook, Twitter, LinkedIn & Google+, all links below should be entered without the preceeding http://</span></td></tr>

<tr valign="top">
        <th scope="row">Facebook:</th>
        <td><input type="text" name="contact_tab_settings[facebook]" value="<?php echo $options['facebook']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Facebook page or profile link</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Twitter:</th>
        <td><input type="text" name="contact_tab_settings[twitter]" value="<?php echo $options['twitter']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Twitter username</span></td>
        </tr>

<tr valign="top">
        <th scope="row">LinkedIn:</th>
        <td><input type="text" name="contact_tab_settings[linkedin]" value="<?php echo $options['linkedin']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">LinkedIn Profile link</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Google+:</th>
        <td><input type="text" name="contact_tab_settings[google]" value="<?php echo $options['google']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Google+ link</span></td>
        </tr>


<tr valign="top">
        <th scope="row">Redirect After Submit:</th>
<td><select name="contact_tab_settings[red]">
                        <option value='yes' <?php selected( $options['red'], 'yes'); ?> >Yes</option>
                        <option value='no' <?php selected( $options['red'], 'no'); ?> >No</option>
        </select><br />
<span style="color:#666666;margin-left:2px;">Option to redirect after form submit</span>

<tr valign="top">
        <th scope="row">Redirect URL:</th>
        <td><input type="text" name="contact_tab_settings[redurl]" value="<?php echo $options['redurl']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">URL to redirect to after successful submission of form</span></td>
        </tr>


<tr valign="top">
        <th scope="row">Thank you message:</th>
        <td><textarea rows="5" cols="50" name="contact_tab_settings[thx]"><?php echo $options['thx']; ?></textarea>
<br /><span style="color:#666666;margin-left:2px;">Message shown after form has been submitted</span></td>
<tr />

</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
}

function contact_tab_ap() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );

	} 

	?>

		<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
	<h2>Appearance</h2></div>
<form method="post" action="options.php">
                        <?php settings_fields('contact_tab_ap'); ?>
                        <?php $ctap_options = get_option('contact_tab_ap'); ?>
                        <!-- Table Structure Containing Form Controls -->
                        <table class="form-table">
 <tr valign="top">
        <th scope="row">Tab Color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[tabcolor]" value="<?php echo $ctap_options['tabcolor']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Tab color</span></td>
        </tr>

 <tr valign="top">
        <th scope="row">Background Color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[bgcolor]" value="<?php echo $ctap_options['bgcolor']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Background color for contact form</span></td>
        </tr>



 <tr valign="top">
        <th scope="row">Form Text Color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[txt]" value="<?php echo $ctap_options['txt']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Text color for form</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Send Button Color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[bcolor]" value="<?php echo $ctap_options['bcolor']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Color of send button</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Tab text color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[tabtxt]" value="<?php echo $ctap_options['tabtxt']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Text color for tab</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Error message text color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[etxt]" value="<?php echo $ctap_options['etxt']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Text color for error message</span></td>
        </tr>

<tr valign="top">
        <th scope="row">Success message text color:</th>
        <td><input class="ctcolor {adjust:false}" size="4" style="border: 0px" name="contact_tab_ap[stxt]" value="<?php echo $ctap_options['stxt']; ?>" />
                <br /><span style="color:#666666;margin-left:2px;">Text color for success message</span></td>
        </tr>


</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>

<?php } 


function shct_tab() { 
	$ctap_options = get_option('contact_tab_ap');	
	global $shct_path, $options;
	extract($ctap_options);
	extract($options);


if ($position == 'left')
require_once('left.php');
else if ($position == 'right')
require_once('right.php');

	}

	
$options = get_option('contact_tab_settings');
$ctap_options = get_option('contact_tab_ap');
