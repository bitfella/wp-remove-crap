<?php

  /**
  * Performs theme cleanup
  */
  function theme_reset() {
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_print_styles', 'print_emoji_styles'); 

    /**
     * Disables admin bar on frontend when user is logged in
     */
    show_admin_bar(false);     
    
    /**
    * Removes wp-embed from footer
    */
    function deregister_theme_scripts() {
      wp_deregister_script('wp-embed');
    }
    add_action('wp_footer', 'deregister_theme_scripts');

    /**
    * Removes cache busting querystrings from static assets
    * I guess you can find a smarter way to handle this, can't you?
    */
    function remove_script_version($src) {
      $parts = explode('?', $src);
      return $parts[0];
    }
    add_filter('script_loader_src', 'remove_script_version', 15, 1);
    add_filter('style_loader_src', 'remove_script_version', 15, 1);

    /**
    * Removes crap from li in main menu
    */
    function wp_nav_menu_remove_attributes($menu) {
      return $menu = preg_replace('/ id=\"(.*)\" class=\"(.*)\"/iU', '', $menu);
    }
    add_filter('wp_nav_menu', 'wp_nav_menu_remove_attributes');
  }

  add_action('after_setup_theme', 'theme_reset');
