<?php
/**
 * Template Name: Startseite
 *
 * @package WordPress
 */

/**
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

				<?php if( have_rows('slider-content') ): 	$i = 0;?>

					<?php while( have_rows('slider-content') ): the_row();
						// vars
						$rowCount++;

					endwhile;
				endif;	?>


				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

					<ol class="carousel-indicators">
					<?php if( have_rows('slider-content') ): ?>
						<?php while( have_rows('slider-content') ): the_row();?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" <?php if($i === 0): ?> class="active" <?php endif; ?>></li>

						<?php $i++; endwhile;
					endif; ?>
					</ol>



							<div class="carousel-inner" role="listbox">
								<!-- Get Content for Slide-Items -->
								<?php if( have_rows('slider-content') ): $j = 0; ?>
									<?php while( have_rows('slider-content') ): the_row();
									$sliderPics = get_sub_field('slider-pics');
									$sliderTextbox = get_sub_field('slider-textbox');
									$sliderName = get_sub_field('slider-name');
									$textboxPosition = get_sub_field('textboxPosition');
									$sliderLink	= get_sub_field('slider-link');
									?>
								<div class="carousel-item <?php if($j === 0): echo active; endif; ?>" style="background-image: url('<?php echo $sliderPics ?>')">
									<div class="carousel-caption normalize-carousal-caption">
										<div class="sliderInfo
										<?php switch($textboxPosition){
											case "oben links":
												echo leftTop;
												break;

											case "oben rechts":
												echo rightTop;
												break;

											case "unten links":
												echo leftBottom;
												break;

											case "unten rechts":
												echo rightBottom;
												break;
											}?>"
											style="float:left;">

											<h3><?php echo $sliderName ?></h3>
											<span class="dividing_line"></span>
											<p><?php echo $sliderTextbox ?></p>
											<?php if($sliderLink):?>
											<form action="<?php echo $sliderLink ?>">
											 <button type="submit">mehr erfahren</button>
										 </form>
											<?php endif; ?>
										</div>
									</div>
								</div>
						<?php $j++; endwhile;
					endif;	?>

					<a class="carousel-control-prev custom-carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next custom-carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
</div>
<?php if( have_rows('index_topic_links') ):  ?>
<div class="col-lg-8 setCenter topicContainer">
	<h1>Themenbereiche der Fastnacht</h1>
<?php while( have_rows('index_topic_links') ): the_row();
	// vars
		$topicNumber++;
		$bgImage = get_sub_field('topic_background_image');
		$topic_description = get_sub_field('topic_description');
		$topic_link = get_sub_field('topic_link');
	?>
<div class="col-lg-3">
	<div class="topics">

		<a href="<?php echo $topic_link ?>" class="topic_link">
			<?php if(!$topic_link): ?>
				<span class="notAvailable"> bald verfügbar! </span>
			<?php endif;?>
	 <div class="topicBackground  <?php if(!$topic_link): echo grayscale; endif;?>"  style="background-image: url(<?php echo  $bgImage ?>)">
		 <span class="topic_number"><?php echo 0 . $topicNumber ?></span>
		<div class="topic_description">
			<p><?php echo $topic_description ?></p>
		</div>
	</div>
</a>
</div>
</div>
<?php endwhile;
endif; ?></div>




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
				//get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
