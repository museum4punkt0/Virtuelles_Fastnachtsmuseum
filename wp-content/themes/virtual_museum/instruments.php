<div class="instrument_Container col-lg-8 setCenter">

  <?php if( have_rows('instrument_table') ): ?>

    <?php while( have_rows('instrument_table') ): the_row();
      // vars
      $instrument = get_sub_field('instrument');
      $name = get_sub_field('name');

      ?>

    <div class="icon_table col-lg-3 col-md-6">

      <?php if (!empty($instrument)):
        $url = $instrument['url'];
        $pth = pathinfo( $url, PATHINFO_EXTENSION);

          if  ($pth == 'svg'):?>
            <style type="text/css">
              .icon_table path{
                fill: <?php the_field('icon_color') ;?>;
              }
              .icon_table circle{
                stroke: <?php the_field('icon_color') ;?>;
              }
            </style>
            <?php
              echo file_get_contents($url);
              else: ?>

      <img src="<?php echo $url ?>" >

    <?php endif ?>
    <?php endif?>
      <p class="instrument_name"><?php echo $name ?></p>

      <div class="musicsheets">
        <div class="noteWrapper">
            <?php while (have_rows('sheets') ): the_row();
            //vars for the uploaded file
              $noteSheet = get_sub_field('pdf-sheets');
              $description = get_sub_field('sheet_description');?>

            <a href="<?php echo $noteSheet ?>"><?php echo $description ?></a>
          <?php endwhile; ?>
        </div>
      </div>

    </div>

  <?php endwhile; ?>
<?php endif?>
</div>
