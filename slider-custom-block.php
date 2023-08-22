<?php

/**
 * @package SliderCustomBlock
 */
/*
Plugin Name: Slider custom block Plugin
Description: Custom map with search
Version: 1.0.0
Author:Anton Holovyn  
Author URI: https://www.linkedin.com/in/anton-holovyn-8ab578206
Text Domain: slider-custom-block
 */

if (!defined('ABSPATH')) {
  die;
}





if (!class_exists('SliderCustomBlock')) {
  class SliderCustomBlock
  {
    //methods
    function __construct()
    {
      add_action('wp_enqueue_scripts', array($this, 'my_plugin_enqueue_assets'));
      add_action('init', array($this, 'init_action'));

      add_action('acf/update_field_group', array($this, 'acf_json_change_field_group'), 1);
      add_action('acf/trash_field_group', array($this, 'acf_json_change_field_group'), 1);
      add_action('acf/untrash_field_group', array($this, 'acf_json_change_field_group'), 1);
      add_filter('acf/settings/load_json', array($this, 'acf_json_load_point'));
    }
    // Enqueue styles and scripts
    public function my_plugin_enqueue_assets()
    {
      // Enqueue scripts
      wp_register_script('customSliderJs',  plugins_url('/libery/slick.min.js', __FILE__));
      wp_enqueue_script('customSliderJs');
      wp_enqueue_script('customSliderIndexJs', plugins_url('blocks/custom-slider/slider.js', __FILE__), ['jquery'], null, true);
    }


    public function init_action()
    {
      if (!class_exists('ACF')) {
        return false;
      }
      $this->register_acf_blocks();
    }

    public function register_acf_blocks()
    {
      $block_name_include = array(
        '/custom-slider',
      );
      foreach ($block_name_include as  $current_block) {
        // if (!is_admin()) {
        //   file_put_contents(dirname(__FILE__) . 'test.txt', dirname(__FILE__) . '/blocks/' . $current_block . '/block.json');
        //   // Runs only if this PHP code is in a file that displays outside the admin panels, like the theme template.
        // } else {
        //   // Runs only if this code is in a file that displays inside the admin panels, like a plugin file.
        // }
        register_block_type(dirname(__FILE__) . '/blocks/' . $current_block . '/block.json');
      }
    }

    public function acf_json_save_point()
    {
      return plugin_dir_path(__FILE__) . '/acf-json';
    }

    public function acf_json_load_point($paths)
    {
      unset($paths[0]);
      $paths[] = plugin_dir_path(__FILE__) . '/acf-json';
      return $paths;
    }

    public function acf_json_change_field_group($group)
    {
      $groups = array(
        'group_642bef531973d',
        'group_642bef531973d__trashed',
      );
      if (in_array($group['key'], $groups)) {
        add_filter('acf/settings/save_json', array($this, 'acf_json_save_point'));
      }
      return $group;
    }
  }

  new SliderCustomBlock;
}
