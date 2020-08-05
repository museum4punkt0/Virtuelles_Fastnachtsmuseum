<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package virtual_Museum
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="Slider">
			<!--------------------------------------------------Get The Slider fields -------------------------------------------------->

				<?php if( have_rows('slider-content') ): ?>

					<?php while( have_rows('slider-content') ): the_row();
						// vars
						$rowCount++;
						$sliderPics = get_sub_field('slider-pics');
						$sliderName = get_sub_field('slider-name');
						$sliderTextbox = get_sub_field('slider-textbox');
						$sliderLink	= get_sub_field('slider-link');

					endwhile;
				endif;	?>


				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

					<ol class="carousel-indicators">
					<?php if( have_rows('slider-content') ): ?>
						<?php while( have_rows('slider-content') ): the_row(); ?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php $i ?>" <?php if($i === 0): ?> class="active" <?php endif?>></li>
						<?php endwhile;
					endif; ?>
					</ol>

					<?php if( have_rows('slider-content') ): ?>
						<?php while( have_rows('slider-content') ): the_row(); ?>
							<div class="carousel-inner" role="listbox">
								<!-- Slide One - Set the background image for this slide in the line below -->
								<div class="carousel-item active" style="background-image: url('<?php $sliderPics ?>')">
									<div class="carousel-caption d-none d-md-block">
										<h3><?php $SliderName ?></h3>
										<p><?php $SliderTextbox ?></p>
									</div>
								</div>
						<?php endwhile;
					endif;	?>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
