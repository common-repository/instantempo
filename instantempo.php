<?php
/*
Plugin Name: instantempo
Plugin URI: http://andreapernici.com/wordpress/instantempo/
Description: Automatically generate a widget to show the latest news about instantempo seo contest. Go to <a href="widgets.php">Aspetto -> Widget</a> for setup.
Version: 1.0.2
Author: Andrea Pernici
Author URI: http://www.andreapernici.com/

Copyright 2010 Andrea Pernici (andreapernici@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

$instantempo_version = "1.0.2";



function widget_instantempo_init()
{
	if ( !function_exists('register_sidebar_widget') )
		return;


	function widget_instantempo($args) {
		global $wpdb;
		global $wpdb_query;
		global $wp_rewrite;
		extract($args);


		$options = get_option('widget_instantempo');
		//dim
		$dim = $options['dim'];
		
		$iframe_width = '300';$iframe_height = '300';
		
		if ($dim == 1) {$iframe_width = '300';$iframe_height = '300';}
		else if ($dim == 2) {$iframe_width = '250';$iframe_height = '250';}
		else {$iframe_width = '200';$iframe_height = '200';}

		echo $before_widget;
		echo $before_title; echo $after_title; //echo $dim; 
		$site_base = get_bloginfo('url');


		echo <<<EOD
<iframe width="{$iframe_width}" height="{$iframe_height}" scrolling="no" frameborder="no" noresize="noresize"
allowtransparency="true"
src="http://instantempo.andreapernici.com/?dim={$dim}"></iframe>
EOD;

		echo $after_widget;
	}

	function widget_instantempo_control ()
	{
			$options = get_option('widget_instantempo');
			if ( !is_array($options) )
				$options = array(
				'dim' => '1',
			);

			if ( $_REQUEST['instantempo-submit'] )
			{

				// Remember to sanitize and format use input appropriately.
				$options['dim'] = strip_tags(stripslashes($_REQUEST['instantempo-dim']));

				update_option('widget_instantempo', $options);
			}

			$dim = htmlspecialchars($options['dim'], ENT_QUOTES);
			
			$selecteduno = $selecteddue = $selectedtre = '';
			if ($dim == 1) { $selecteduno='selected="selected"';}
			else if ($dim == 2) {$selecteddue='selected="selected"';}
			else {$selectedtre='selected="selected"';}

			//echo '<form id="form-instant-tempo" name="form-instant-tempo" action="">';
			echo '<p style="text-align:right;"><label for="instantempo-dim">' . __('Specifica la dimensione del tuo widget:') . ' <select style="width: 200px;" name="instantempo-dim" id="instantempo-dim">
      <option value="1"'. $selecteduno.'>300x300</option>
      <option value="2"'. $selecteddue.'>250x250</option>
      <option value="3"'. $selectedtre.'>200x200</option>
    </select></label></p>';

			echo '<input type="hidden" id="instantempo-submit" name="instantempo-submit" value="1" />';
			//echo '</form>';
	}

	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('instantempo', 'widgets'), 'widget_instantempo');

	// This registers our optional widget control form.
	register_widget_control(array('instantempo', 'widgets'), 'widget_instantempo_control', 450, 325);
}

add_action("widgets_init", "widget_instantempo_init");


?>