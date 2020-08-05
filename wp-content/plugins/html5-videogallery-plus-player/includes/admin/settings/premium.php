<?php
/**
 * Plugin Premium Offer Page
 *
 * @package Video gallery and Player
 * @since 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrap">
	
	<h2><?php _e( 'Video gallery and Player - Features', 'html5-videogallery-plus-player' ); ?></h2><br />

	<div class="wprps-notice">
		<a href="https://www.wponlinesupport.com/checkout/?edd_action=add_to_cart&download_id=15305&edd_options[price_id]=3&ref=wposthemeplugin" target="_blank">Upgrade</a> a plugin within a minute and unloack many features now!!!
	</div>

	<style>
		.wprps-notice{padding: 10px; color: #3c763d; background-color: #dff0d8; border:1px solid #d6e9c6; margin: 0 0 20px 0;}
		.wpos-plugin-pricing-table thead th h2{font-weight: 400; font-size: 2.4em; line-height:normal; margin:0px; color: #2ECC71;}
		.wpos-plugin-pricing-table thead th h2 + p{font-size: 1.25em; line-height: 1.4; color: #999; margin:5px 0 5px 0;}

		table.wpos-plugin-pricing-table{width:90%; text-align: left; border-spacing: 0; border-collapse: collapse; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}

		.wpos-plugin-pricing-table th, .wpos-plugin-pricing-table td{font-size:14px; line-height:normal; color:#444; vertical-align:middle; padding:12px;}

		.wpos-plugin-pricing-table colgroup:nth-child(1) { width: 31%; border: 0 none; }
		.wpos-plugin-pricing-table colgroup:nth-child(2) { width: 22%; border: 1px solid #ccc; }
		.wpos-plugin-pricing-table colgroup:nth-child(3) { width: 25%; border: 10px solid #2ECC71; }

		/* Tablehead */
		.wpos-plugin-pricing-table thead th {background-color: #fff; background:linear-gradient(to bottom, #ffffff 0%, #ffffff 100%); text-align: center; position: relative; border-bottom: 1px solid #ccc; padding: 1em 0 1em; font-weight:400; color:#999;}
		.wpos-plugin-pricing-table thead th:nth-child(1) {background: transparent;}
		.wpos-plugin-pricing-table thead th:nth-child(3) {padding:1em 0 3.5em 0;}		
		.wpos-plugin-pricing-table thead th p.promo {font-size: 14px; color: #fff; position: absolute; bottom:0; left: -17px; z-index: 1000; width: 100%; margin: 0; padding: .625em 17px .75em; background-color: #ca4a1f; box-shadow: 0 2px 4px rgba(0,0,0,.25); border-bottom: 1px solid #ca4a1f;}
		.wpos-plugin-pricing-table thead th p.promo:before {content: ""; position: absolute; display: block; width: 0px; height: 0px; border-style: solid; border-width: 0 7px 7px 0; border-color: transparent #900 transparent transparent; bottom: -7px; left: 0;}
		.wpos-plugin-pricing-table thead th p.promo:after {content: ""; position: absolute; display: block; width: 0px; height: 0px; border-style: solid; border-width: 7px 7px 0 0; border-color: #900 transparent transparent transparent; bottom: -7px; right: 0;}

		/* Tablebody */
		.wpos-plugin-pricing-table tbody th{background: #fff; border-left: 1px solid #ccc; font-weight: 600;}
		.wpos-plugin-pricing-table tbody th span{font-weight: normal; font-size: 87.5%; color: #999; display: block;}

		.wpos-plugin-pricing-table tbody td{background: #fff; text-align: center;}
		.wpos-plugin-pricing-table tbody td .dashicons{height: auto; width: auto; font-size:30px;}
		.wpos-plugin-pricing-table tbody td .dashicons-no-alt{color: #ca4a1f;}
		.wpos-plugin-pricing-table tbody td .dashicons-yes{color: #2ECC71;}

		.wpos-plugin-pricing-table tbody tr:nth-child(even) th,
		.wpos-plugin-pricing-table tbody tr:nth-child(even) td { background: #f5f5f5; border: 1px solid #ccc; border-width: 1px 0 1px 1px; }
		.wpos-plugin-pricing-table tbody tr:last-child td {border-bottom: 0 none;}

		/* Table Footer */
		.wpos-plugin-pricing-table tfoot th, .wpos-plugin-pricing-table tfoot td{text-align: center; border-top: 1px solid #ccc;}
		.wpos-plugin-pricing-table tfoot a{font-weight: 600; color: #fff; text-decoration: none; text-transform: uppercase; display: inline-block; padding: 1em 2em; background: #59c7fb; border-radius: .2em;}
	</style>

	<table class="wpos-plugin-pricing-table">
		<colgroup></colgroup>
		<colgroup></colgroup>
		<colgroup></colgroup>	
	    <thead>
	    	<tr>
	    		<th></th>
	    		<th>
	    			<h2>Free</h2>
	    			<p>$0 USD</p>
	    		</th>
	    		<th>
	    			<h2>Premium</h2>
	    			<p>$19 USD</p>
	    			<p class="promo">Our most valuable package!</p>
	    		</th>	    		
	    	</tr>
	    </thead>

	    <tfoot>
	    	<tr>
	    		<th></th>
	    		<td></td>
	    		<td><a href="https://www.wponlinesupport.com/checkout/?edd_action=add_to_cart&download_id=15305&edd_options[price_id]=3&ref=wposthemeplugin" target="_blank">Upgrade Now</a></td>
	    	</tr>
	    </tfoot>

	     <tbody>
	    	<tr>
	    		<th>Designs <span>Designs that make your website better</span></th>
	    		<td>1</td>
	    		<td>20+</td>
	    	</tr>
	    	<tr>
		    	<th>Shortcodes <span>Shortcode provide output to the front-end side</span></th>
		    	<td>1 (Grid)</td>
	    		<td>2 (Grid,  Slider )</td>
	    	</tr>
			<tr>
	    		<th>Shortcode Parameters <span>Add extra power to the shortcode</span></th>
	    		<td>5</td>
	    		<td>14+</td>
	    	</tr>
			<tr>
	    		<th>Center Mode <span>Display slider with center mode.</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
	    	<tr>
	    		<th>Shortcode Generator <span>Play with all shortcode parameters with preview panel. No documentation required!!</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
			<tr>
				<th>Option Show/Hide Title  <span>Display video title</span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr> 
			<tr>
	    		<th>Option Show/Hide Content <span>Display video short content.</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
			<tr>
	    		<th>Slider RTL Support <span>Slider supports for RTL website</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>			
			
	    	<tr>
	    		<th>Drag & Drop Slide Order Change <span>Arrange your desired slides with your desired order and display</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
			<tr>
				<th>Pagination Support  <span>Pagination support for grid shortcode</span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr>    	
			
			<tr>
				<th>Loop Control for slider  <span>Infinite scroll control </span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
			</tr>
			<tr>
	    		<th>Visual Composer Page Builder Supports <span>Use this plugin with Visual Composer easily</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>		
	    	
			<tr>
	    		<th>Display Videos for Particular Categories <span>Display only video with particular category</span></th>
	    			<td><i class="dashicons dashicons-yes"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
	    	<tr>
				<th>Exclude Videos <span>Do not display the videos you want</span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr>
			<tr>
				<th>Exclude Some Categories <span>Do not display the videos for particular categories</span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr>
			<tr>
				<th>Videos Order / Order By Parameters <span>Display videos according to date, title and etc</span></th>
				<td><i class="dashicons dashicons-no-alt"></i></td>
				<td><i class="dashicons dashicons-yes"></i></td>
			</tr>
			<tr>
	    		<th>Multiple Slider Parameters <span>Slider parameters like autoplay, number of slide, sider dots and etc.</span></th>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
			<tr>
	    		<th>Slider RTL Support <span>Slider supports for RTL website</span></th>
	    		<td><i class="dashicons dashicons-no-alt"></i></td>
	    		<td><i class="dashicons dashicons-yes"></i></td>
	    	</tr>
	    	<tr>
	    		<th>Support <span>Get support for plugin</span></th>
	    		<td>Limited</td>
	    		<td>1 Year</td>
	    	</tr>    	
	    </tbody>
	</table>
</div>