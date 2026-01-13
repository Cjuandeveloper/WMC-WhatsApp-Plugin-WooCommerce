<?php
/**
 * Plugin Name: WooCommerce WhatsApp
 * Description: Una herramienta para tiendas en línea que desean mejorar la interacción con sus clientes. Este plugin agrega un botón de WhatsApp que puedes colocar en las páginas de producto de WooCommerce mediante un shortcode.
 * Version: 1.0
 * Author: webmastercol
 * Author URI: https://webmastercol.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'settings.php';
    require_once plugin_dir_path( __FILE__ ) . 'functions.php';

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wmc_add_settings_link');
    function wmc_add_settings_link($links) {
        $settings_link = '<a href="admin.php?page=wmc-whatsapp-settings">' . __('Ajustes', 'woocommerce-whatsapp') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }
}