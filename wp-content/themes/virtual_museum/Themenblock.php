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
  <!--div class="fixedWindow"-->
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
    $textboxPosition = get_sub_field('textboxposition');
    $animation = get_sub_field();
		?>

<section class="ContentContainer scroll_bckgr" style="background-image: url(<?php echo $image ?>)">
  <!--img class="backgroundImage" src="<//?php echo $image ?>"/-->
<!--------------------- Info Text Box for the Section ----------------------style="background-image: url(<//?php echo $image ?>)" --->
		<div class="InfoWrapper	<?php switch($textboxPosition){
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
        }?>"><div class="closeText">
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
				<audio src="<?php echo $audio['url'] ?>">
      </div>
		<?php endif; ?>

</section>

	<?php endwhile; ?>



<?php endif; ?>
<!--/div-->

<!--------------------------------------------Start dynamic Content Posts ----------------------->
<div id="primary" class="content-area">
    <div class="mainContentWrapper col-lg-8 setCenter">
      <?php
      while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', 'page' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile; // End of the loop.
      ?>
    </div>
</div><!-- #primary -->
<!--------------------------------------------Start dynamic Content Posts -------------------------->

</main>



<!--*********************************************EndContent************************************** -->


<?php

get_footer();
