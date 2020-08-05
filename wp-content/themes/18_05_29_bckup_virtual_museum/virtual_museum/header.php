<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package virtual_Museum
 */

?>
<!doctype html>
<!---------------Begin head------------------>
</head>
<html <?php language_attributes(); ?>>
<head>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC:400,700|Playfair+Display:400,700|Playfair+Display:400i,700i|Spectral:300,400,400i,700&amp;subset=latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!--<meta http-equiv="refresh" content="5" >-->
	<?php wp_head(); ?>
</head>
<!---------------------END head------------------->

<!----------------defining body------------------->
<body <?php body_class(); ?>>


<div id="page" class="site">

	<header id="masthead" class="site-header">
<div id="MenuWrapper">

			<div id="TopMenu"  class="main-navigation">
				<div class="col-lg-10 setCenter">
				<?php	if ( function_exists( 'the_custom_logo' ) ) {
					    the_custom_logo();
					} ?>
				<a id="burger">

<!--/////////////////////////////////////////BurgerIcon////////////////////////////////////-->
<svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" class="undefined">
	<defs class="undefined">
		<style class="burgersvg">
		.burger_line_1, .burger_line_2, .burger_circle, .burger_line_3 { fill: none;
			stroke: #8b7034; }
		.burger_line_1 { stroke-miterlimit: 10; }
		.burger_line_1,
		.burger_line_2,
		.burger_line_3 { stroke-width: 2px; }
		.burger_circle { stroke-width: 3px; }
	</style>
</defs>
<title class="burgermenuIcon"> burgermenu</title>
<g data-name="Ebene 2" class="undefined">
	<g data-name="Ebene 1" class="undefined">
		<line class="burger_line_1" x1="13" y1="17" x2="29" y2="17"/>
		<line class="burger_line_2" x1="13" y1="21" x2="29" y2="21"/>
		<line class="burger_line_3" x1="13" y1="25" x2="29" y2="25"/>
		<circle class="burger_circle" cx="21" cy="21" r="19.5"/>
	</g>
</g>
</svg>
<!--/////////////////////////////////////////EndBurgerIcon////////////////////////////////////-->

				 </a>
			 </div>


		 </div>
<!-------------------------------------- #dynamic Mega Dropdown site-navigation ---------------------->
<div id="TopDownMenu">
	<ul class="nav col-lg-10 setCenter">
		<?php wp_nav_menu( array( 'header-main-menu' => 'Header main Menu' ) ); ?>
	</ul>
</div>
<!-------------------------------------- #EndSite-navigation ---------------------->
</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
