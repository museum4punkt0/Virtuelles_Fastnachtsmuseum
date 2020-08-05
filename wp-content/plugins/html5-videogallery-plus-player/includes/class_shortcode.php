<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
 * Add [sp_html5video limit="-1"] shortcode
 *
 */
function sp_html5video_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"limit"    		=> '',
		"category" 		=> '',
		"grid"     		=> '',
		"post"     		=> '',
		"popup_fix"		=> 'false',
	), $atts));
	
	// Define limit
	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}
	if( $category ) { 
		$cat = $category; 
	} else {
		$cat = '';
	}
	
	if( $post ) { 
		$post_in = $post; 
	} else {
		$post_in = '';
	}
	
	if( $grid == '2' ) { 
		$video_grid = "6"; 
	} elseif ( $grid == '3' ) {
		$video_grid = "4";
	} elseif ( $grid == '4' ) {
		$video_grid = "3";
	} elseif ( $grid == '1' ) {
		$video_grid = "12";
	} else {
		$video_grid = "12"; 
	}
	$popup_fix = ($popup_fix == 'true') ? 'true' : 'false';

	// Popup Configuration
	$popup_conf = compact('popup_fix');
	
	wp_enqueue_script( 'wpos-magnific-popup-jquery' );
	 wp_enqueue_script( 'wp-html5video-public-js' );
	
	ob_start();

	// Create the Query
	$unique 		= wp_html5vp_get_unique();
	$post_type 		= 'sp_html5video';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
	
	$args = array ( 
								'post_type'      => $post_type,
								'posts_per_page' => $posts_per_page,
								'orderby'        => $orderby, 
								'order'          => $order,
								'post__in'       => !empty($post_in) ? array($post_in) : array(),
								'no_found_rows'  => 1
								) ;
						
						
			if($cat != ""){
            	$args['tax_query'] = array( array( 'taxonomy' => 'video-category', 'field' => 'tearm_id', 'terms' => $cat) );
            } 				
	
	//Get post type count
	
	$query = new WP_Query($args);
	$post_count = $query->post_count;
	$i = 1;
	global $post;
	?>
	<div class="wp-html5vp-video-row video-row video-row-clearfix" id="wp-html5vp-<?php echo $unique; ?>">
	<?php
	// Displays Custom post info
	if( $post_count > 0) :
	
		// Loop
		while ($query->have_posts()) : $query->the_post();
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id() );
		$wpvideo_video_mp4 = get_post_meta($post->ID, '_wpvideo_video_mp4', true);
		$wpvideo_video_wbbm = get_post_meta($post->ID, '_wpvideo_video_wbbm', true);
		$wpvideo_video_ogg = get_post_meta($post->ID, '_wpvideo_video_ogg', true);
		$youtube_link = get_post_meta($post->ID, '_wpvideo_video_yt', true);
		$vimeo_link = get_post_meta($post->ID, '_wpvideo_video_vm', true);
		$video_link = '';
		if($youtube_link != '') 
			{ $video_link = $youtube_link; } 
				else
					{ $video_link = $vimeo_link; }
		?>
		<div class="video-wrap html5video-medium-<?php echo $video_grid; ?> html5video-columns">
			<div class="video_frame">
				<div class="video_image_frame">
					<?php if($video_link != '') { ?>
					<a href="<?php echo $video_link; ?>" class="popup-youtube">
						<?php if( $feat_image ) { ?>
						<img src="<?php echo $feat_image; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
						<span class="video_icon"></span>
						</a>
						
					<?php } else { ?>
					
						<a href="#video-modal-<?php echo $unique.'-'.$i; ?>" class="popup-modal">
						<?php if( $feat_image ) { ?>
						<img src="<?php echo $feat_image; ?>" alt="<?php the_title(); ?>" />
						<?php } ?>
						<span class="video_icon"></span>
						</a>			
						
					<?php } ?>
					<div id="video-modal-<?php echo $unique.'-'.$i; ?>" class="mfp-hide white-popup-block wp-html5vp-popup-wrp">
						<video id="video_<?php echo get_the_ID(); ?>" class="wp-hvgp-video-frame video-js vjs-default-skin" controls preload="none" width="100%" poster="<?php echo $feat_image; ?>" data-setup="{}">
							<source src="<?php echo $wpvideo_video_mp4; ?>" type='video/mp4' />
							<source src="<?php echo $wpvideo_video_wbbm; ?>" type='video/webm' />
							<source src="<?php echo $wpvideo_video_ogg; ?>" type='video/ogg' />
						</video>
					</div>
						
				</div>
				<div class="video_title"><?php the_title(); ?></div>
			</div>
		</div>
		<?php
		$i++;
		endwhile;	
	endif;
	?>
		<div class="wp-html5vp-popup-conf"><?php echo json_encode( $popup_conf ); ?></div><!-- end of-popup-conf -->
	</div><!-- end .video-row -->
	<?php
	// Reset query to prevent conflicts
	wp_reset_query();
	
	?>
	
	<?php
	
	return ob_get_clean();

}
add_shortcode("sp_html5video", "sp_html5video_shortcode");