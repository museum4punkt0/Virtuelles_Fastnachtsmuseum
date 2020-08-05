<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package virtual_Museum
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info col-lg-8 setCenter">


				<?php if( have_rows('social-media-links', 'option') ):  ?>
				<div class="social-media"><h3>Folge uns auf:</h3>

				<?php
				  while( have_rows('social-media-links', 'option') ): the_row();
				  // vars
				    $i++;
				    $sm_logo = get_sub_field('sm_logo');
				    $sm_link = get_sub_field('sm_link');
				    $sm_circle = get_sub_field('sm_circle_color');?>

							<div class="sm_logo_container">
								<a href="<?php echo $sm_link ?>">
									<img src="<?php echo $sm_logo ?>" class="<?php echo sm_logo_.$i ;?> sm_logo">
								</a>
							</div>
				<?php endwhile;?>
			<?php endif ?>
			</div>


			<div class="widget_area">
				<?php if ( is_active_sidebar( 'footer1' ) ) : ?>
					<div class='col-lg-6 widget'>
						<?php dynamic_sidebar( 'footer1' ); ?>
						<span class="vertical_line"></span>
					</div>

				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer2' ) ) : ?>
					<div class='col-lg-3 widget'>
						<?php dynamic_sidebar( 'footer2' ); ?>

					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer3' ) ) : ?>
					<div class='col-lg-3 widget'>
						<?php dynamic_sidebar( 'footer3' ); ?>

					</div>
				<?php endif; ?>

			</div>

		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
