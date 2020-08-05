<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Class to create meta box
 * 
 * @package HTML5 Video gallery and Player
 * @since 1.1
 */ 


class sp_html5video_Admin {
	
	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'sp_html5video_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this,'sp_html5video_metabox_value') );
		
	}

	/**
	 * video Post Settings Metabox
	 * 
	 * @package HTML5 Video gallery and Player
	 * @since 1.1
	 */
	function sp_html5video_metabox() {
		add_meta_box( 'html5video-post-sett', __( 'Video Files/Links', 'html5-videogallery-plus-player' ), array($this, 'sp_html5video_sett_mb_content'), 'sp_html5video', 'normal', 'high' );
	}

	/**
	 * Video Post Settings Metabox HTML
	 * 
	 * @package HTML5 Video gallery and Player
	 * @since 1.1
	 */
	function sp_html5video_sett_mb_content() {
		global $post;

			$prefix = '_wpvideo_'; // Metabox prefix

			// Getting saved values
			$video_mp4 	= get_post_meta($post->ID, $prefix.'video_mp4', true);
			$video_wbbm = get_post_meta($post->ID, $prefix.'video_wbbm', true);
			$video_ogg 	= get_post_meta($post->ID, $prefix.'video_ogg', true);
			$video_yt 	= get_post_meta($post->ID, $prefix.'video_yt', true);
			$video_vm 	= get_post_meta($post->ID, $prefix.'video_vm', true);
			?>

			<table class="form-table wpnw-post-sett-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label><?php _e('HTML5 Player', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-mp4"><?php _e('video/mp4', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo esc_attr($video_mp4); ?>" class="large-text wpnw-more-link" id="link-for-mp4" name="<?php echo $prefix; ?>video_mp4" /><br/>
							<span class="description"><?php _e('ie http://videolink.mp4', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-webm"><?php _e('video/webm', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo esc_attr($video_wbbm); ?>" class="large-text wpnw-more-link" id="link-for-webm" name="<?php echo $prefix; ?>video_wbbm" /><br/>
							<span class="description"><?php _e('ie http://videolink.webm', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-ogg"><?php _e('video/ogg', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo esc_attr($video_ogg); ?>" class="large-text wpnw-more-link" id="link-for-ogg" name="<?php echo $prefix; ?>video_ogg" /><br/>
							<span class="description"><?php _e('ie http://videolink.ogg', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" colspan="2" style="padding-bottom:0px">
							OR
						</th>
						
					</tr>
					
					<tr valign="top">
						<th scope="row" colspan="2">
							<hr />
						</th>
					</tr>
					
					<tr valign="top">
						<th scope="row">
							<label><?php _e('YouTube Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-youtube"><?php _e('Enter YouTube Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo esc_attr($video_yt); ?>" class="large-text wpnw-more-link" id="link-for-youtube" name="<?php echo $prefix; ?>video_yt" /><br/>
							<span class="description"><?php _e('ie https://www.youtube.com/watch?v=07IRBn1oXrU', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" colspan="2" style="padding-bottom:0px">
							OR
						</th>
						
					</tr>
					<tr valign="top">
						<th scope="row" colspan="2">
							<hr />
						</th>
						
					</tr>
					
					<tr valign="top">
						<th scope="row">
							<label><?php _e('Vimeo Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="link-for-vimeo"><?php _e('Enter Vimeo Link', 'html5-videogallery-plus-player'); ?></label>
						</th>
						<td>
							<input type="url" value="<?php echo esc_attr($video_vm); ?>" class="large-text wpnw-more-link" id="link-for-vimeo" name="<?php echo $prefix; ?>video_vm" /><br/>
							<span class="description"><?php _e('ie https://vimeo.com/171807697', 'html5-videogallery-plus-player'); ?></span>
						</td>
					</tr>

				</tbody>
			</table><!-- end .wtwp-tstmnl-table -->
	<?php }

	/**
	 * Function to save metabox values
	 * 
	 * @package WP News and Five Widgets Pro
	 * @since 1.0.0
	 */
	function sp_html5video_metabox_value( $post_id ) {

		global $post_type;
		
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  'sp_html5video' ) )              				// Check if current post type is supported.
		{
		  return $post_id;
		}
		
		$prefix = '_wpvideo_'; // Taking metabox prefix
		
		// Taking variables
		$video_mp4 	= isset($_POST[$prefix.'video_mp4']) 	? stripslashes_deep(trim($_POST[$prefix.'video_mp4'])) 	: '';
		$video_wbbm = isset($_POST[$prefix.'video_wbbm']) 	? stripslashes_deep(trim($_POST[$prefix.'video_wbbm'])) : '';
		$video_ogg 	= isset($_POST[$prefix.'video_ogg'])	? stripslashes_deep(trim($_POST[$prefix.'video_ogg'])) 	: '';
		$video_yt 	= isset($_POST[$prefix.'video_yt']) 	? stripslashes_deep(trim($_POST[$prefix.'video_yt'])) 	: '';
		$video_vm 	= isset($_POST[$prefix.'video_vm']) 	? stripslashes_deep(trim($_POST[$prefix.'video_vm'])) 	: '';
		
		update_post_meta($post_id, $prefix.'video_mp4', $video_mp4);
		update_post_meta($post_id, $prefix.'video_wbbm', $video_wbbm);
		update_post_meta($post_id, $prefix.'video_ogg', $video_ogg);
		update_post_meta($post_id, $prefix.'video_yt', $video_yt);
		update_post_meta($post_id, $prefix.'video_vm', $video_vm);
	}



}

$html5video_admin = new sp_html5video_Admin();