<?php
//custom post type - amu submission
function theme_amu_submission_init()
{
	$labels = array(
		'name' => _x('Ajax Multi Upload Submissions', 'post type general name', 'amu'),
		'singular_name' => _x('Submission', 'post type singular name', 'amu'),
		'add_new' => _x('Add New', 'trainers', 'amu'),
		'add_new_item' => __('Add New Submission', 'amu'),
		'edit_item' => __('Edit Submission', 'amu'),
		'new_item' => __('New Submission', 'amu'),
		'all_items' => __('All Submissions', 'amu'),
		'view_item' => __('View Submission', 'amu'),
		'search_items' => __('Search Submissions', 'amu'),
		'not_found' =>  __('No submissions found', 'amu'),
		'not_found_in_trash' => __('No submissions found in Trash', 'amu'), 
		'parent_item_colon' => '',
		'menu_name' => __("Upload Submissions", 'amu')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes")  
	);
	register_post_type("amu_submission", $args);
}  
add_action("init", "theme_amu_submission_init"); 

//Adds a box
function theme_add_amu_submission_custom_box() 
{
	add_meta_box( 
        "amu_submission_config",
        __("Submitted data", 'amu'),
        "theme_inner_amu_submission_custom_box_main",
        "amu_submission", //amu_submission or post
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "theme_add_amu_submission_custom_box");
//backwards compatible (before WP 3.0)
//add_action("admin_init", "theme_add_custom_box", 1);

function theme_inner_amu_submission_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "amu_submission_noncename");
	
	//The actual fields for data entry
	$blog_categories = get_post_meta($post->ID, "blog_categories", true);
	$post_categories = get_categories(array(
		'hide_empty' => 0
	));
	$args = array(
		'post_type' => 'attachment',
		'numberposts' => null,
		'post_status' => null,
		'post_parent' => $post->ID
	); 
	$attachments = get_posts($args);
	
	echo '
	<table>';
		/*if(count($post_categories))
		{
			echo '
		<tr>
			<td>
				<label for="blog_categories">' . __('Blog categories', 'gymbase') . ':</label>
			</td>
			<td>
				<select id="blog_categories" name="blog_categories[]" multiple="multiple">';
					foreach($post_categories as $post_category)
						echo '<option value="' . $post_category->term_id . '"' . (is_array($blog_categories) && in_array($post_category->term_id, $blog_categories) ? ' selected="selected"' : '') . '>' . $post_category->name . '</option>';
			echo '
				</select>
			</td>
		</tr>';
		}*/
		/*echo '
		<tr>
			<td>
				<label for="keywords">' . __('Keywords', 'amu') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="keywords" name="keywords" value="' . esc_attr(get_post_meta($post->ID, "keywords", true)) . '" />
			</td>
		</tr>*/
		echo '
		<tr>
			<td>
				<label for="name">' . __('Name', 'amu') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="name" name="name" value="' . esc_attr(get_post_meta($post->ID, "name", true)) . '" />
			</td>
		</tr>';
		/*<tr>
			<td>
				<label for="surname">' . __('Surname', 'amu') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="surname" name="surname" value="' . esc_attr(get_post_meta($post->ID, "surname", true)) . '" />
			</td>
		</tr>*/
		echo '
		<tr>
			<td>
				<label for="email">' . __('Email', 'amu') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="email" name="email" value="' . esc_attr(get_post_meta($post->ID, "email", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="website">' . __('Website', 'amu') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="website" name="website" value="' . esc_attr(get_post_meta($post->ID, "website", true)) . '" />
			</td>
		</tr>';
		if ($attachments) 
		{
			echo '<tr>
				<td colspan="2">
					<label>' . __('Attachments', 'amu') . ':</label>
				</td>
			</tr>
			<tr><td colspan="2">';
			foreach ($attachments as $attachment) 
			{
				echo '<div style="float: left;margin-right: 10px;margin-bottom: 10px;">';
				the_attachment_link($attachment->ID, false);
				edit_post_link(__("Edit", 'amu'), '<p>', '</p>', $attachment->ID);
				echo '</div>';
			}
			echo '</td></tr>';
		}
	echo '</table>';
}

//When the post is saved, saves our custom data
function theme_save_amu_submission_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['amu_submission_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "blog_categories", $_POST["blog_categories"]);
	update_post_meta($post_id, "keywords", $_POST["keywords"]);
	update_post_meta($post_id, "name", $_POST["name"]);
	update_post_meta($post_id, "surname", $_POST["surname"]);
	update_post_meta($post_id, "email", $_POST["email"]);
	update_post_meta($post_id, "website", $_POST["website"]);
}
add_action("save_post", "theme_save_amu_submission_postdata");

/*function amu_submission_edit_columns($columns)
{
	$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => _x('Title', 'post type singular name', 'amu'),
			"amu_category" => __('Categories', 'amu'),
			"date" => __('Date', 'amu')
	);

	return $columns;
}
add_filter("manage_edit-amu_submission_columns", "amu_submission_edit_columns");

function manage_amu_submission_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "amu_category":
			echo get_the_term_list($post->ID, "blog_categories", '', ', ','');
			break;
	}
}
add_action("manage_amu_submission_posts_custom_column", "manage_amu_submission_posts_custom_column");*/
?>