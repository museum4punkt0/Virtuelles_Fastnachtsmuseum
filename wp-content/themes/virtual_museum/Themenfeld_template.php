<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package virtual_Museum
 */

get_header(); ?>

<!--*********************************************BeginContent************************************** -->

<section class="ContentContainer" id="Thementitel">
<div class="headerText centered">
  <h2 id="title">Tanz und Musik</h2>
  <p>nutze Kopfhörer für das beste Erlebnis</p>
      <div class="audio">
  <audio id="Starttrack" preload="auto" loop src="/audio/mixed.mp3" type="audio/mp3">
  </audio>
</div>
</div>
  <div id="ScrollButton" class="headerScroll">
    <a href="#"><span></span>Scroll</a>
  </div>
</section>


<section id="one" class="Priest">
  <div id="lightbeamOverlay"></div>
  <div class="TextBlock">
    <p>
      Im christlichen Mittelalter erwartet die Kirche von jedem Menschen, dass er zu bestimmten Zeiten des Tages zur Ruhe kommt, sich besinnt, still ist  und betet.
    </p>

  </div>

    <img id="backgroundCandle" src="videos/candle_light.png">
    <div class="audio">
      <audio id="track-1" preload="auto" loop src="/audio/choir.mp3" type="audio/mp3">
		  </audio>
    </div>
    <figure id="priest">
      <img  src="imgs/church.jpg" />
      <figcaption>betender Mönch aus dem Jahre xy, von Maler z</figcaption>
    </figure>
</section>


<section  class="ContentContainer" id="two">
  <div class="TextBlock">
    <p>
      Narren ignorieren dieses Ideal eines gottgefälligen Daseins: Sie beten nicht, sind immer in Bewegung und stiften Unruhe. Auf Bildern des 15. und 16. Jahrhunderts,

der ersten Blütezeit der Narrenidee in Kunst und Literatur, erscheinen Narren daher stets als rastlos herumgaukelnde Gestalten. Oft werden sie von den Künstlern sogar in bewussten Kontrast zu vorbildlich lebenden, frommen Menschen gestellt, die andächtig beten und in sich selber ruhen. Diesen Gegensatz zwischen Weisheit und Verkehrtheit repräsentiert übrigens auch das Figurenpaar Herrscher und Hoffnarr. </p>

  </div>
  <div class="audio">
    <audio id="track-2" preload="auto" loop src="/audio/medieval_loop.mp3" type="audio/mp3">
    </audio>
  </div>
</section>

<section class="ContentContainer" id="three">


</section>

<section  class="ContentContainer" id="four">

</section>

<section  class="ContentContainer" id="five">

</section>

<section  class="ContentContainer" id="six">

</section>

<section  class="ContentContainer" id="seven">

</section>


<!--*********************************************EndContent************************************** -->
