
<!--*********************************************BeginContent************************************** -->
<main id="main" class="site-main">
  <div class="galleryWrapper col-lg-8 setCenter">
    <?php if( have_rows('media-library') ):  ?>
    <?php
      while( have_rows('media-library') ): the_row();
      // vars
        $video = get_sub_field('video');
        $videotitle = get_sub_field('videotitle');
        $vdescr = get_sub_field('videodescription');
        $embedURL = $video;
        // use preg_match to find iframe src
        preg_match('/src="(.+?)"/', $video, $matches);
        $src = $matches[1];
      endwhile;
    endif;?>

    <div class="embed-container">
      <iframe name="IframeShow" src="<?php echo $src ?>" allow="autoplay; encrypted-media" allowfullscreen="" frameborder="0" width="640" height="360"></iframe>
    </div>

<div class="ThumbnailWrapper">
    <?php if( have_rows('media-library') ):  ?>
    <?php
      while( have_rows('media-library') ): the_row();
      // vars
        $video = get_sub_field('video');
        $videotitle = get_sub_field('videotitle');
        $embedURL = $video;

        // use preg_match to find iframe src
        preg_match('/src="(.+?)"/', $video, $matches);
        $src = $matches[1];
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match)) {
            $video_id = $match[1];
        }
        ?>
        <a class="videoThumbnail" href="<?php echo $src ?>" target="IframeShow">
        <div>
          <img src='http://img.youtube.com/vi/<?php echo $video_id; ?>/mqdefault.jpg'>
          <P><?php echo $videotitle ?></p>
        </div>
        </a>

    <?php endwhile;
    endif ?>
    </div>
  </div>
</main>
<!--*********************************************EndContent************************************** -->
