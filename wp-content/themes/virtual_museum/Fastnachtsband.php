<?php

/**
 * Template Name: Fastnachtband
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

  <?php if( get_field('bckgr-video') ):
    	$video = get_field('bckgr-video');
   endif ?>

<section class="ContentContainer" id="Thementitel">


  <div class="headerText centered">
    <h2 class="ContentTitle"><?php the_title(); ?></h2>

  </div>
  <div id="ScrollButton" class="headerScroll">
    <a href="#bigBoxWrapper"><span></span>Scroll</a>
  </div>

</section>

<div id="bigBoxWrapper">

  <div class="setCenter" id="iconContainer">
    <!--div id="selectionBox"></div-->
    <?php if( have_rows('image_table') ): ?>

      <?php while( have_rows('image_table') ): the_row();
        // vars
        $l++;
        $image = get_sub_field('image');
        $text = get_sub_field('description');

        ?>

     <div class="BigBoxImage <?php echo  'content' . $l . ' '?> <?php if(get_sub_field('mainfield') && !$done)  : echo 'current'; $done = true; endif?>">
        <?php
        if (!empty($image)):
          $url = $image['url'];
          $pth = pathinfo( $url, PATHINFO_EXTENSION);

            if  ($pth == 'svg'):?>
              <span class="SVG_icons">
              <?php echo file_get_contents($url); ?>
            </span>
            <?php else: ?>
        <img src="<?php echo ($image['url']) ?>">
        <?php endif ?>

        <p class="Icon_description"><?php echo $text ?></p>

      </div>
      <?php endif ?>
    <?php endwhile; ?>
  <?php endif ?>
  </div>
</div>

<div id="variableContentWrapper">
<!-------------------------------------------Begin variable Content------------------------------->
<?php if( have_rows('image_table') ):  ?>
<?php
  while( have_rows('image_table') ): the_row();
  // vars
    $i++;
    $content = get_sub_field('php_page');
    $post_id = get_sub_field('php_page', false, false);
    $site_store[$i] = $content;

//get the choice of the first content
    if(get_sub_field(mainfield) && !$currentsite):
      $currentsite = $content;
    endif;

endwhile;
endif ?>

<?php
//change currentsite with image_table-Menu with the BigBoxImage class
function show_post($PageID) {
  $id = $PageID;
  $p = get_page($id);
  echo apply_filters('the_content', $p->main);
}



while($j < count($site_store)):
    $j++;


  ?>
  <div class="<?php echo $site_store[$j]?><?php echo ' ' . 'content' . $j ;?>">
    <?php include $site_store[$j]
?>
  </div>
  <?php
endwhile;

?>


</div>
<!------------------------------------------ -End variable Content------------------------------->

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
?>
