<?php

/*
  Plugin Name: Base Shortcode For Bootstrap
  Plugin URI: 
  Description: This plugin is shortcode for bootstrap
  Version: 1.0
  Author: Pinghai Wang
*/

if (!defined('ABSPATH'))
    die("Can't load this file directly");

define( 'BASE_SHORTCODE_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'BASE_SHORTCODE_PLUGIN_URL', plugins_url().'/base-shortcode-for-bootstrap/' );

load_plugin_textdomain('base_shortcode', false, basename(dirname(__FILE__)) . '/lang/');

include BASE_SHORTCODE_PLUGIN_PATH.'inc/shortcode-backend.class.php';
include BASE_SHORTCODE_PLUGIN_PATH.'inc/shortcode-frontend.class.php';
?>