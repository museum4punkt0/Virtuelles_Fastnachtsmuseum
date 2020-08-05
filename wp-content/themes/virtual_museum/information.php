<div class= "information col-lg-8 setCenter">
  <h2>Werde in 3 Schritten Mitglied der virtuellen Fastnachtband!</h2>
<ul class="todo-list">
  <?php if( have_rows('to_do_list') ): ?>

    <?php while( have_rows('to_do_list') ): the_row();
      // vars
      $count++;
      $enum = get_sub_field('enumeration');
  ?>
  <li class="enumeration">
    <div class="counter"><p><?php echo $count .' '; ?></p></div><p class="enum_text"><?php echo $enum?></p>
  </li>
<?php endwhile ?>
<?php endif ?>
</div>
</ul>

<div class="InfoBlockWrapper">
<div class="col-lg-8 setCenter" >
<?php if( have_rows('info-textblock') ): ?>

<?php while( have_rows('info-textblock') ): the_row();
      // vars
      $header = get_sub_field('header');
      $infoText = get_sub_field('infotext');
  ?>

<div class="InfoTextGroup">
  <h2><?php echo $header ?></h2>

    <p class="info-textblock">
      <?php echo $infoText ?>
    </p>
    <?php endwhile ?>
    <?php endif ?>
    </div>
  </div>
</div>
