<?php

/**
 * Template Name: Themenseite
 *
 * @package WordPress
 */

/**
 * The template for displaying custom Content pages
 *
 * The Template uses a onePage kind of presentation
 * Pictures can be added and the transition can be adjusted in the cms
 * text for description can be added.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package virtual_Museum
 */

get_header(); ?>

<!--*********************************************BeginContent************************************** -->
<main id="main" class="site-main">
<section class="ContentContainer" id="Thementitel">

<div class="headerText centered">
  <h2 class="ContentTitle"><?php the_title(); ?></h2>
  <p class="subtitle"><?php the_field('sub-title'); ?></p>
</div>


  <div id="ScrollButton" class="headerScroll">
    <a href="#"><span></span>Scroll</a>
  </div>
</section>



<?php if( have_rows('sectionrepeater') ): ?>

	<?php while( have_rows('sectionrepeater') ): the_row();
		// vars
		$image = get_sub_field('bild');
		$bildtext = get_sub_field('bildtext');
		$audio = get_sub_field('audio');
    $caption = get_sub_field('bildunterschrift');
		?>

<section class="ContentContainer" style="background-image: url(<?php echo $image ?>)">

		<div class="InfoWrapper"><div class="closeText">
<!--///////////////////////////closeIcon/////////////////////////////////////-->
<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42">
  <defs>
    <style>
      .cls-1, .cls-2, .cls-3 {
        fill: none;
        stroke: #8b7034;
      }

      .cls-1 {
        stroke-miterlimit: 10;

      }

      .cls-1, .cls-2 {
        stroke-width: 2px;

      }

      .cls-3 {
        stroke-width: 3px;

      }
    </style>
  </defs>
  <title>close</title>
  <g id="Ebene_2" data-name="Ebene 2">
    <g id="Ebene_1-2" data-name="Ebene 1">
      <circle class="cls-3" cx="21" cy="21" r="19.5"/>
      <line class="cls-1" x1="15.34" y1="26.66" x2="26.66" y2="15.34"/>
      <line class="cls-2" x1="15.34" y1="15.34" x2="26.66" y2="26.66"/>

    </g>
  </g>
</svg>

<!--///////////////////////////closeIcon/////////////////////////////////////-->


    </div>
    <div class="InfoText">

      <figure class="sm_image">
        <img class="" src="<?php echo $image ?>"/><figcaption><?php echo $caption ?></figcaption></figure>
       <p><?php echo $bildtext ?>  </p>

    </div>
  </div>

		<?php if( $audio ): ?>
      <div class="audio">
				<audio src="<?php echo $audio ?>"
      </div>
		<?php endif; ?>

</section>

	<?php endwhile; ?>



<?php endif; ?>
</main>



<!--*********************************************EndContent************************************** -->


<?php

get_footer();
