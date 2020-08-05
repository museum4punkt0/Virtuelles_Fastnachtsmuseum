<div class="galleryWrapper col-lg-8 setCenter">

<?php if( have_rows('media-library') ): ?>

  <?php while( have_rows('media-library') ): the_row();
    // vars
    $video = get_sub_field('video');
    $videotitle = get_sub_field('videotitle');
?>

  <div class="gallery-item col-lg-6">
    <?php echo $video ?>
    <div class="videotitle">
      <?php echo $videotitle ?>
    </div>
  </div>
<?php endwhile ?>
<?php endif ?>
</div>
