<?php
/*
Plugin Name: WP-Parsi navigation trees
Plugin URI: http://forum.wp-parsi.com/
Description: This plugin create dynamic expand/collapse able tree-widget navigation widget from WordPress Nav-Menu
Version: 2.0
Author: Morteza Geransayeh
Author URI: http://geransayeh.com
*/


///////////////////////////////////////// Style & JS  /////////////////////////////////////////

function wpp_wtn_sj(){
	wp_register_script('wpp-wtn-script', plugins_url('js/wp-parsi-navigation-trees.js', __FILE__), array('jquery'),'1.11.1', false);
	wp_enqueue_script('wpp-wtn-script');

	wp_register_style('wpp-wtn-stylesheet', plugins_url('css/wp-parsi-navigation-trees.css', __FILE__));
	wp_enqueue_style('wpp-wtn-stylesheet');
	
	if(get_locale()=="fa_IR"){
		wp_register_style('wpp-wtn-stylesheet-rtl', plugins_url('css/wp-parsi-navigation-trees-rtl.css', __FILE__));
		wp_enqueue_style('wpp-wtn-stylesheet-rtl');
	}
}
add_action( 'wp_enqueue_scripts', 'wpp_wtn_sj' );

///////////////////////////////////////// Main Class  /////////////////////////////////////////

//error_reporting(E_ALL);
add_action("widgets_init", array('Widget_Tree_Nav', 'register'));
register_activation_hook( __FILE__, array('Widget_Tree_Nav', 'activate'));
register_deactivation_hook( __FILE__, array('Widget_Tree_Nav', 'deactivate'));
class Widget_Tree_Nav {
	
	
	
	
  function activate(){
    $data = array( 'treev_option' => '');
    if ( ! get_option('widget_tree_nav')){
      add_option('widget_tree_nav' , $data);
    } else {
      update_option('widget_tree_nav' , $data);
    }
  }
  
  
  /////////////////////
  function deactivate(){
    delete_option('widget_tree_nav');
  }
  
  /////////////////////
function control(){
  $data = get_option('widget_tree_nav');


      global $wpdb, $table_prefix;
      $nav_menu_term_id = $wpdb->get_col("SELECT term_id FROM {$table_prefix}term_taxonomy WHERE taxonomy = 'nav_menu'");
      
      echo '<select name="widget_nav_option">';
      foreach($nav_menu_term_id as $n_m_term_id){
      	 $nav_menu_name    = $wpdb->get_col("SELECT name FROM {$table_prefix}terms WHERE term_id = $n_m_term_id");
      	 
      	 foreach($nav_menu_name as $n_m_name){
      	 	 if ($data['treev_option'] == $n_m_term_id){ $selected = ' selected="selected"'; } else {$selected = '';}
      	 	 $nav_dlist = "<option value=".$n_m_term_id."".$selected.">".$n_m_name."</option>";
      	 	 echo $nav_dlist;
      	 }//foreach child
      
      }//foreach
      echo '</select>';
  ?>
  
  <?php
   if (isset($_POST['widget_nav_option'])){
    $data['treev_option'] = attribute_escape($_POST['widget_nav_option']);
    update_option('widget_tree_nav', $data);
  }
}


  /////////////////////
  function widget($args){
  	$data = get_option('widget_tree_nav');
    echo '<div id="wb_tree">';
     wp_nav_menu( array ('menu' => $data['treev_option']) );
    echo '</div>';
  }
  
  /////////////////////
  function register(){
    register_sidebar_widget('WPP-Tree', array('Widget_Tree_Nav', 'widget'));
    register_widget_control('WPP-Tree', array('Widget_Tree_Nav', 'control'));
  }
}


?>