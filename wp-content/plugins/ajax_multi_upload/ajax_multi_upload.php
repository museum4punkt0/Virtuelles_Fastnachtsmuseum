<?php
/*
Plugin Name: Ajax Multi Upload
Plugin URI: http://codecanyon.net/item/ajax-multi-upload-for-wordpress/144658?ref=QuanticaLabs
Description: Ajax Multi Upload is a lightweight plugin for WordPress. It can upload single or multiple file via ajax, resize image, create image thumbnail, be easy integrate with forms.
Author: QuanticaLabs
Author URI: http://codecanyon.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 3.2
*/
require_once("post-type-amu-submission.php");

function amu_load_textdomain()
{
	load_plugin_textdomain("amu", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'amu_load_textdomain');

function ajax_multi_upload_init()
{
	if(!get_option("amu_contact_form_installed"))
	{	
		$amu_contact_form_options = array(
			"email_subject" => __("Email Default Subject", 'amu'),
			"admin_name" => get_settings("admin_email"),
			"admin_email" => get_settings("admin_email"),
			"template" => "<html>
<head>
</head>
<body>
	<div><b>Title</b>: [title]</div>
	<div><b>Name</b>: [name]</div>
	<div><b>E-mail</b>: [email]</div>
	<div><b>Content</b>: [content]</div>
	<div><b>Uploaded files</b>: [files]</div>
</body>
</html>",
			"smtp_host" => "",
			"smtp_username" => "",
			"smtp_password" => "",
			"smtp_port" => "",
			"smtp_secure" => ""
		);
		add_option("amu_contact_form_options", $amu_contact_form_options);
		add_option("amu_contact_form_installed", 1);
	}
	//phpMailer
	add_action('phpmailer_init', 'amu_phpmailer_init');
	wp_enqueue_script('jquery');
}
add_action('init', 'ajax_multi_upload_init');

/* --- phpMailer config --- */
function amu_phpmailer_init(PHPMailer $mail) 
{
	$amu_contact_form_options = amu_stripslashes_deep(get_option("amu_contact_form_options"));
	$mail->CharSet='UTF-8';
	$smtp = $amu_contact_form_options["smtp_host"];
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		//$mail->SMTPDebug = 2;
		$mail->Host = $amu_contact_form_options["smtp_host"];
		$mail->Username = $amu_contact_form_options["smtp_username"];
		$mail->Password = $amu_contact_form_options["smtp_password"];
		if((int)$amu_contact_form_options["smtp_port"]>0)
			$mail->Port = (int)$amu_contact_form_options["smtp_port"];
		$mail->SMTPSecure = $amu_contact_form_options["smtp_secure"];
	}
}

function amu_admin_menu()
{	
	add_submenu_page("edit.php?post_type=amu_submission", __("Upload Submissions", 'amu'), __('Email template', 'amu'), 'administrator', 'amu_email_template', 'amu_email_template');
}
add_action('admin_menu', 'amu_admin_menu');

function amu_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

	return $value;
}

function amu_email_template()
{
	if(isset($_POST["action"]) && $_POST["action"]=="save")
	{
		$amu_contact_form_options = array(
			"email_subject" => $_POST["email_subject"],
			"admin_name" => $_POST["admin_name"],
			"admin_email" => $_POST["admin_email"],
			"template" => $_POST["template"],
			"smtp_host" => $_POST["smtp_host"],
			"smtp_username" => $_POST["smtp_username"],
			"smtp_password" => $_POST["smtp_password"],
			"smtp_port" => $_POST["smtp_port"],
			"smtp_secure" => $_POST["smtp_secure"]
		);
		update_option("amu_contact_form_options", $amu_contact_form_options);
	}
	$amu_contact_form_options = amu_stripslashes_deep(get_option("amu_contact_form_options"));
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php _e(' Contact Form Options', 'amu');?></h2>
	</div>
	<?php 
	if(isset($_POST["action"]) && $_POST["action"]=="save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php
					_e('Options saved', 'amu');
				?>
			</strong>
		</p>
	</div>
	<?php 
	}
	?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="amu_contact_form_settings">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php
						_e('Admin email config', 'amu');
						?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="admin_name"><?php _e('Name', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["admin_name"]); ?>" id="admin_name" name="admin_name">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="admin_email"><?php _e('Email', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["admin_email"]); ?>" id="admin_email" name="admin_email">
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php
						_e('Admin SMTP config (optional)', 'amu');
						?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_host"><?php _e('Host', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["smtp_host"]); ?>" id="smtp_host" name="smtp_host">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_username"><?php _e('Username', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["smtp_username"]); ?>" id="smtp_username" name="smtp_username">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_password"><?php _e('Password', 'amu'); ?></label>
					</th>
					<td>
						<input type="password" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["smtp_password"]); ?>" id="smtp_password" name="smtp_password">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_port"><?php _e('Port', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["smtp_port"]); ?>" id="smtp_port" name="smtp_port">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="smtp_secure"><?php _e('SMTP Secure', 'amu'); ?></label>
					</th>
					<td>
						<select id="smtp_secure" name="smtp_secure">
							<option value=""<?php echo ($amu_contact_form_options["smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
							<option value="ssl"<?php echo ($amu_contact_form_options["smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'amu'); ?></option>
							<option value="tls"<?php echo ($amu_contact_form_options["smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'amu'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<br />
					</th>
				</tr>
				<tr valign="top">
					<th colspan="2" scope="row" style="font-weight: bold;">
						<?php _e('Email config', 'amu'); ?>
					</th>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="email_subject"><?php _e('Email subject', 'amu'); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo esc_attr($amu_contact_form_options["email_subject"]); ?>" id="email_subject" name="email_subject">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="template"><?php _e('Template', 'amu'); ?></label>
					</th>
					<td>
						<?php _e("Available shortcodes:", 'amu'); ?>
						<br />
						<strong>[title] [name] [surname] [keywords] [email] [website] [content] [excerpt] [categories] [files]</strong>
						<?php wp_editor($amu_contact_form_options["template"], "template");?>
					</td>
				</tr>
			</tbody>
		</table>
		<p>
			<input type="hidden" name="action" value="save" />
			<input type="submit" value="Save Options" class="button-primary" name="Submit">
		</p>
	</form>
<?php
}

function ajax_multi_upload_shortcode($atts) 
{
	global $load_ajax_multi_upload;
	global $packed;
	global $post;
	extract(shortcode_atts(array(
		'path' => 'files/',
		'starton' => 'manually',
		'savedata' => 'true',
		'posttype' => 'amu_submission',
		'attachimages' => 'currentPost',
		'sendemail' => 'false',
		'buttoncaption' => 'Upload',
		'multi' => 'false',
		'afterupload' => 'link',
		'onprogress' => 'percentage',
		'thumbnails' => '',
		'thumbnailscrop' => '',
		'fileext' => '',
		'filedesc' => '',
		'method' => 'post',
		'thumbnailsafterupload' => '',
		'maxsize' => '',
		'hidebutton' => 'false',
		'button' => '',
		'bwidth' => '',
		'bheight' => '',
		'buttontext' => '',
		'queueid' => '',
		'data' => '',
		'removedata' => '',
		'filesmin' => '',
		'fileslimit' => '',
		'allowremove' => 'false',
		'sessionid' => '',
		'ajax' => 'false',
		'requiredfields' => '',
		'ajaxinfoid' => '',
		'ajaxloaderid' => '',
		'uploadscript' => 'upload.php',
		'wmode' => '',
		'packed' => 'false',
		'scriptsonly' => 'false'
	), $atts));
	
	$amu = "";
	//form submission code
	if(isset($_POST["amu_action"]) && ($_POST["amu_action"]=="submit" || ($_POST["action"]=="amu_submit" && (int)$_POST["ajax"]==1)))
	{
		if($_POST["requiredfields"]!="")
			$required_fields = explode(",", $_POST["requiredfields"]);
		$isOk = true;
		foreach($required_fields as $required_field)
		{
			if($_POST["amu_" . $required_field]=="")
			{
				$isOk = false;
				break;
			}
			//email validation
			if($required_field=="email" && $_POST["amu_" . $required_field]!="" && !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["amu_" . $required_field]))
			{
				$isOk = false;
				break;
			}
			//keywords validation
			if($required_field=="keywords" && count(array_map('trim', explode(",", $_POST["amu_" . $required_field])))>10)
			{
				$isOk = false;
				break;
			}
		}
		if($isOk)
		{
			if($_POST["savedata"]=="true")
			{
				$post = array(
				  'post_content'   => $_POST["amu_content"],
				  'post_excerpt'   => (!empty($_POST["amu_excerpt"]) ? $_POST["amu_excerpt"] : ''),
				  'post_status'    => 'pending', //publish
				  'post_title'     => ($_POST["amu_title"]=="" ? __("Default title", 'amu') : $_POST["amu_title"]),
				  'post_type'      => ($_POST["posttype"]!="" ? $_POST["posttype"] : "amu_submission")
				);
				
				$post_id = wp_insert_post($post);
				update_post_meta($post_id, "blog_categories", $_POST["amu_blog_categories"]);
				//update_post_meta($post_id, "keywords", $_POST["amu_keywords"]);
				//keywords/tags
				$keywordsExplode = array_map('trim', explode(",", $_POST["amu_keywords"]));
				foreach($keywordsExplode as $keyword)
				{
					$existing_tag = get_term_by("name", $keyword, 'post_tag');
					if($existing_tag!=false)
					{
						$term_id = (int)$existing_tag->term_id;
					}
					else
					{
						//create the tag
						$term_id= wp_insert_term(
							$keyword, // the term 
							'post_tag' // the taxonomy
						);
					}
					//set the tag
					wp_set_object_terms($post_id, $term_id, 'post_tag', true);
				}
				update_post_meta($post_id, "name", $_POST["amu_name"]);
				update_post_meta($post_id, "surname", $_POST["amu_surname"]);
				update_post_meta($post_id, "email", $_POST["amu_email"]);
				update_post_meta($post_id, "website", $_POST["amu_website"]);
				if($_POST["attachimages"]=="formSubmission")
				{
					$attachment_count = count($_POST["attach_id"]);
					if((int)$attachment_count)
					{
						$post_content = $_POST["amu_content"] . "<br />";
						for($i=0; $i<$attachment_count;$i++)
						{
							wp_update_post(array(
								'ID' => $_POST["attach_id"][$i],
								'post_parent' => $post_id
							));
							$post_content .= wp_get_attachment_image($_POST["attach_id"][$i], 'full');
						}
						wp_update_post(array(
							'ID' => $post_id,
							'post_content' => $post_content
						));
					}
				}
			}
			$message = "";
			$message .= __("The form has beeen send successfully!", 'amu');
			/*if(count($_POST["AMUFiles"]))
			{
				$message .= "<br />Uploaded files: ";
				for($i=0; $i<count($_POST["AMUFiles"]); $i++)
					$message .= "<br />" . $_POST["AMUFiles"][$i];
			}*/
			//sending email
			if($_POST["sendemail"]=="true")
			{
				$amu_contact_form_options = amu_stripslashes_deep(get_option("amu_contact_form_options"));

				$result = array();
				$result["isOk"] = true;
				
				$values = array(
					"title" => $_POST["amu_title"],
					"name" => $_POST["amu_name"],
					"surname" => $_POST["amu_surname"],
					"email" => $_POST["amu_email"],
					"website" => $_POST["amu_website"],
					"content" => $_POST["amu_content"],
					"excerpt" => $_POST["amu_excerpt"],
					"keywords" => $_POST["amu_keywords"]
				);
				if((bool)ini_get("magic_quotes_gpc")) 
					$values = array_map("stripslashes", $values);
				$values = array_map("htmlspecialchars", $values);
				
				if(preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $values["email"]))
					$headers[] = 'Reply-To: ' . $values["name"] . ' <' . $values["email"] . '>' . "\r\n";
				else
					$headers[] = 'Reply-To: ' . $amu_contact_form_options["admin_name"] . ' <' . $amu_contact_form_options["admin_email"] . '>' . "\r\n";
				$headers[] = 'From: ' . $amu_contact_form_options["admin_name"] . ' <' . $amu_contact_form_options["admin_email"] . '>' . "\r\n";
				$headers[] = 'Content-type: text/html';
				$categories_string = "";
				if(count($_POST["amu_blog_categories"]))
				{
					for($i=0; $i<count($_POST["amu_blog_categories"]); $i++)
					{
						$currentCategory = get_category($_POST["amu_blog_categories"][$i]);
						$categories_string .= "<br />" . $currentCategory->name;
					}
				}
				if(count($_POST["AMUFiles"]))
				{
					for($i=0; $i<count($_POST["AMUFiles"]); $i++)
						$uploaded_files .= "<br />" . $_POST["AMUFiles"][$i];
				}
				$subject = $amu_contact_form_options["email_subject"];
				$subject = str_replace("[title]", $values["title"], $subject);
				$subject = str_replace("[name]", $values["name"], $subject);
				$subject = str_replace("[surname]", $values["surname"], $subject);
				$subject = str_replace("[email]", $values["email"], $subject);
				$subject = str_replace("[website]", $values["website"], $subject);
				$subject = str_replace("[content]", $values["content"], $subject);
				$subject = str_replace("[excerpt]", $values["excerpt"], $subject);
				$subject = str_replace("[keywords]", $values["keywords"], $subject);
				$subject = str_replace("[categories]", $categories_string, $subject);
				$subject = str_replace("[files]", $uploaded_files, $subject);
				$body = $amu_contact_form_options["template"];
				$body = str_replace("[title]", $values["title"], $body);
				$body = str_replace("[name]", $values["name"], $body);
				$body = str_replace("[surname]", $values["surname"], $body);
				$body = str_replace("[email]", $values["email"], $body); 
				$body = str_replace("[website]", $values["website"], $body);
				$body = str_replace("[content]", $values["content"], $body);
				$body = str_replace("[excerpt]", $values["excerpt"], $body);
				$body = str_replace("[keywords]", $values["keywords"], $body);
				$body = str_replace("[categories]", $categories_string, $body);
				$body = str_replace("[files]", $uploaded_files, $body);

				if(wp_mail($amu_contact_form_options["admin_name"] . ' <' . $amu_contact_form_options["admin_email"] . '>', $subject, $body, $headers))
				{
					//$message .= __("<br />Email send successfully!", 'amu');
				}
				else
				{
					//$error .= __("Error when sending email!", 'amu');
					//$error .= $GLOBALS['phpmailer']->ErrorInfo;
				}

				if($message!="")
					$amu .= '<div class="amu_info amu_message" id="info" style="display: block;">' . $message . '</div>';
			}
		}
		else
		{
			$error = __("Please fill required fields:", 'amu');
			foreach($required_fields as $required_field)
			{
				if($_POST["amu_" . $required_field]=="")
				{
					//$error .= '<br />' . $required_field;
					$error .= $required_field . ",";
				}
				if($required_field=="email" && $_POST["amu_email"]!="" && !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["amu_" . $required_field]))
				{
					//$error .= '<br />Incorrect ' . $required_field;
					$error .= 'Incorrect ' . $required_field;
				}
				//keywords validation
				if($required_field=="keywords" && count(array_map('trim', explode(",", $_POST["amu_" . $required_field])))>10)
				{
					//$error .= '<br />Max number of keywords is 10';
					$error .= 'Max number of keywords is 10';
				}
			}
		}
		if($_POST["action"]=="amu_submit" && (int)$_POST["ajax"]==1)
		{
			$result = array();
			$result["message"] = $message;
			$result["error"] = $error;
			echo "amu_start" . json_encode($result) . "amu_end";
			exit();
		}
		if($error!="")
			$amu .= '<div class="amu_info amu_error" id="info" style="display: block;">' . $error . '</div>';
	}
	$current_user = wp_get_current_user();
	//ajax multi upload code
	$load_ajax_multi_upload = true;
	if($scriptsonly=="false")
	{
	$amu .= "<input class='AMU' uploadscript='" . plugins_url($uploadscript, __FILE__) . "' type='file' path='$path' starton='$starton' savedata='$savedata' posttype='$posttype' attachimages='$attachimages' requiredfields='$requiredfields' sendemail='$sendemail' onprogress='$onprogress'" . ($buttoncaption!='' ? " buttoncaption='$buttoncaption'":"") . " multi='$multi' afterupload='$afterupload' hidebutton='$hidebutton'" . ($thumbnails!='' ? " thumbnails='$thumbnails'":"") . ($thumbnailscrop!='' ? " thumbnailscrop='$thumbnailscrop'":"") . ($fileext!='' ? " fileext='$fileext'":"") . ($filedesc!='' ? " filedesc='$filedesc'":"") . " method='$method'" . ($thumbnailsafterupload!='' ? " thumbnailsafterupload='$thumbnailsafterupload'":"") . ($maxsize!='' ? " maxsize='$maxsize'":"") . ($button!='' ? " button='$button'":"") . ($bwidth!='' ? " bwidth='$bwidth'":"") . ($bheight!='' ? " bheight='$bheight'":"") . ($buttontext!='' ? " buttontext='$buttontext'":"") . ($queueid!='' ? " queueid='$queueid'":"") . ($data!='' ? " data='" . htmlspecialchars($data, ENT_QUOTES) . htmlspecialchars(",'postId':'" . $post->ID . "'", ENT_QUOTES) . htmlspecialchars(",'userId':'" . (int)$current_user->ID . "'", ENT_QUOTES) . ($savedata!='' ? htmlspecialchars(",'savedata':'" . $savedata . "'", ENT_QUOTES):"") . ($attachimages!='' ? htmlspecialchars(",'attachimages':'" . $attachimages . "'", ENT_QUOTES):"") . ($fileslimit!='' ? htmlspecialchars(",'fileslimit':'" . $fileslimit . "'", ENT_QUOTES):"") . "'":"data='" . htmlspecialchars("'postId':'" . $post->ID . "'", ENT_QUOTES) . htmlspecialchars(",'userId':'" . (int)$current_user->ID . "'", ENT_QUOTES) . ($savedata!='' ? htmlspecialchars(",'savedata':'" . $savedata . "'", ENT_QUOTES):"") . ($attachimages!='' ? htmlspecialchars(",'attachimages':'" . $attachimages . "'", ENT_QUOTES):"") . ($fileslimit!='' ? htmlspecialchars(",'fileslimit':'" . $fileslimit . "'", ENT_QUOTES):"") . "'") . ($removedata!='' ? " removedata='$removedata'":"") . ($fileslimit!='' ? " fileslimit='$fileslimit'":"") . ($filesmin!='' ? " filesmin='$filesmin'":"") . " ajax='$ajax'" . ($ajaxinfoid!='' ? " ajaxinfoid='$ajaxinfoid'":"") . ($ajaxloaderid!='' ? " ajaxloaderid='$ajaxloaderid'":"") . " allowremove='$allowremove'" . ($sessionid!='' ? " sessionid='$sessionid'":"") . ($wmode!='' ? " wmode='$wmode'":"") . " />";
	}
	return $amu;
}
add_shortcode('ajax_multi_upload', 'ajax_multi_upload_shortcode');
add_action("wp_ajax_amu_submit", "ajax_multi_upload_shortcode");
add_action("wp_ajax_nopriv_amu_submit", "ajax_multi_upload_shortcode");

//blog categories shortcode
function amu_blog_categories_dropdown_shortcode($atts)
{
	extract(shortcode_atts(array(
		'multiple' => 0,
		'hide_empty' => 0
	), $atts));
	$blog_categories = get_categories(array(
		'hide_empty' => $hide_empty
	));
	$output = '<select id="amu_blog_categories" name="amu_blog_categories[]"' . ((int)$multiple ? ' multiple="multiple"' : '') . '>';
	if(!(int)$multiple)
		$output .= '<option value="">' . __('-', 'amu') . '</option>';
	foreach($blog_categories as $blog_category)
	{
		$output .= '<option value="' . $blog_category->term_id . '">' . $blog_category->name . '</option>';
	}
	$output .= '</select>';
	return $output;
}
add_shortcode('amu_blog_categories_dropdown', 'amu_blog_categories_dropdown_shortcode');

//editor shortcode
function extended_editor_mce_buttons($buttons) 
{
	return array("link", "unlink");
}

function amu_content_editor_shortcode($atts)
{
	extract(shortcode_atts(array(
		'media_buttons' => 0,
		'tab_index' => 2,
		'extended' => 0
	), $atts));
	ob_start();
	add_filter("mce_buttons", "extended_editor_mce_buttons", 0);
	add_filter("wp_default_editor", create_function('', 'return "tinymce";'));
	the_editor($content, "amu_content", "", $media_buttons, $tab_index, $extended);
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('amu_content_editor', 'amu_content_editor_shortcode');
 
function ajax_multi_upload_footer() 
{
	global $load_ajax_multi_upload;
	global $packed;
	if (!$load_ajax_multi_upload)
		return;
	echo "
	<script type='text/javascript'>
		var amuurl = '" . plugins_url('', __FILE__) . "';
	</script>";
	//ajaxurl
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	if($packed=='false')
	{
		/*wp_register_script('upload.min', plugins_url('js/upload.min.js', __FILE__), array('jquery'));
		wp_register_script('swfobject', plugins_url('js/swfobject.js', __FILE__), array('jquery'));
		wp_register_script('myupload', plugins_url('js/myupload.js', __FILE__), array('jquery'));
		wp_print_scripts(array('upload.min', 'swfobject', 'myupload'));*/
		wp_enqueue_script('upload.min', plugins_url('js/upload.min.js', __FILE__), array('jquery'));
		wp_enqueue_script('swfobject', plugins_url('js/swfobject.js', __FILE__), array('jquery'));
		wp_enqueue_script('myupload', plugins_url('js/myupload.js', __FILE__), array('jquery'));
		wp_localize_script("myupload", "config", $params);
	}
	else
	{
		/*wp_register_script('upload.packed', plugins_url('js/upload.packed.js', __FILE__), array('jquery'));
		wp_print_scripts(array('upload.packed'));*/
		wp_enqueue_script('upload.packed', plugins_url('js/upload.packed.js', __FILE__), array('jquery'));
		wp_localize_script("upload.packed", "config", $params);
	}
	/*wp_register_style('ajax_multi_upload_style', plugins_url('style.css', __FILE__));
	wp_print_styles(array('ajax_multi_upload_style'));*/
	wp_enqueue_style('ajax_multi_upload_style', plugins_url('style.css', __FILE__));
}
add_action('wp_footer', 'ajax_multi_upload_footer');
?>