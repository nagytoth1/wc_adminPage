<?php
/*
Plugin Name: Color Admin Page
Description: Admin Page plugin to analyze the shopping activities of the users on the server.
Author: Levente Sipos & Bence Nagy-Tóth
Version: 0.2
*/

add_action('admin_menu', 'test_plugin_setup_menu');
 
function test_plugin_setup_menu()
{
    add_menu_page( 'Color Admin Page', 'Admin Plugin', 'manage_options', 'test-plugin', 'page_init' );
}
 
function page_init()
{ 
    $plugin_path = dirname(__FILE__);
    
    require_once($plugin_path . DIRECTORY_SEPARATOR . "ColorAdminPageView.php");

    $view = new ColorAdminPageView();
    echo $view->render('adminPageView');
}
?>

