<?php
/*
Plugin Name: Color Admin page
Description: An admin plugin to demonstrate sql queries
Author: Levente Sipos & Bence Nagy-Tóth
Version: 0.1
*/

add_action('admin_menu', 'test_plugin_setup_menu');
 
function test_plugin_setup_menu()
{
    add_menu_page( 'Admin Plugin Page', 'Admin Plugin', 'manage_options', 'test-plugin', 'test_init' );
}
 
function test_init()
{ 
    $plugin_path = dirname(__FILE__);
    
    require_once($plugin_path . DIRECTORY_SEPARATOR . "view.php");

    $view = new AdminPageView();
    echo $view->render('adminPageView');
}
?>

