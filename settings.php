<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', 'wmc_create_menu');
function wmc_create_menu() {
    add_submenu_page(
        'woocommerce',
        __('Ajustes de WhatsApp', 'woocommerce-whatsapp'),
        __('WhatsApp', 'woocommerce-whatsapp'),
        'manage_options',
        'wmc-whatsapp-settings',
        'wmc_settings_page'
    );
}

add_action('admin_init', 'wmc_register_settings');
function wmc_register_settings() {
    register_setting('wmc_settings_group', 'wmc_enable_button');
    register_setting('wmc_settings_group', 'wmc_enable_button_in_archive');
    register_setting('wmc_settings_group', 'wmc_whatsapp_number');
    register_setting('wmc_settings_group', 'wmc_button_text');
    register_setting('wmc_settings_group', 'wmc_default_message');
    register_setting('wmc_settings_group', 'wmc_hide_add_to_cart');
    register_setting('wmc_settings_group', 'wmc_button_bg_color');
    register_setting('wmc_settings_group', 'wmc_button_hover_bg_color');
    register_setting('wmc_settings_group', 'wmc_button_text_color');
    register_setting('wmc_settings_group', 'wmc_button_hover_text_color');
    register_setting('wmc_settings_group', 'wmc_custom_button_size');
    register_setting('wmc_settings_group', 'wmc_show_whatsapp_icon');
}

function wmc_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Ajustes de WooCommerce WhatsApp', 'woocommerce-whatsapp'); ?></h1>
        <p><strong>Shortcode disponible:</strong> <code>[wmc_whatsapp_button]</code></p>

        <form method="post" action="options.php">
            <?php settings_fields('wmc_settings_group'); ?>
            <?php do_settings_sections('wmc_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th><?php _e('Habilitar en la página del producto', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="checkbox" name="wmc_enable_button" value="1" <?php checked(1, get_option('wmc_enable_button')); ?> /></td>
                </tr>
                <tr>
                    <th><?php _e('Habilitar en el archivo de los productos', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="checkbox" name="wmc_enable_button_in_archive" value="1" <?php checked(1, get_option('wmc_enable_button_in_archive')); ?> /></td>
                </tr>
                <tr>
                    <th><?php _e('Ocultar botón de añadir al carrito', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="checkbox" name="wmc_hide_add_to_cart" value="1" <?php checked(1, get_option('wmc_hide_add_to_cart')); ?> /></td>
                </tr>
                <tr>
                    <th><?php _e('Número de WhatsApp', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="text" name="wmc_whatsapp_number" value="<?php echo esc_attr( get_option('wmc_whatsapp_number') ); ?>" style="width: 100%;" /></td>
                </tr>
                <tr>
                    <th><?php _e('Texto del botón', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="text" name="wmc_button_text" value="<?php echo esc_attr( get_option('wmc_button_text', 'Compra x WhatsApp') ); ?>" style="width: 100%;" /></td>
                </tr>
                <tr>
                    <th><?php _e('Mensaje predeterminado', 'woocommerce-whatsapp'); ?></th>
                    <td><textarea name="wmc_default_message" style="width: 100%;"><?php echo esc_attr( get_option('wmc_default_message', 'Hola, estoy interesado en este producto.') ); ?></textarea></td>
                </tr>
                <tr>
                    <th><?php _e('Color de fondo del botón', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="color" name="wmc_button_bg_color" value="<?php echo esc_attr( get_option('wmc_button_bg_color', '#25D366') ); ?>" /></td>
                </tr>
                <tr>
                    <th><?php _e('Color de fondo del botón al pasar el cursor (hover)', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="color" name="wmc_button_hover_bg_color" value="<?php echo esc_attr( get_option('wmc_button_hover_bg_color', '#1ebe5b') ); ?>" /></td>
                </tr>
                <tr>
                    <th><?php _e('Color del texto del botón', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="color" name="wmc_button_text_color" value="<?php echo esc_attr( get_option('wmc_button_text_color', '#ffffff') ); ?>" /></td>
                </tr>
                <tr>
                    <th><?php _e('Color del texto del botón al pasar el cursor (hover)', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="color" name="wmc_button_hover_text_color" value="<?php echo esc_attr( get_option('wmc_button_hover_text_color', '#ffffff') ); ?>" /></td>
                </tr>
                <tr>
                    <th><?php _e('Tamaño del texto e ícono del botón (px)', 'woocommerce-whatsapp'); ?></th>
                    <td>
                        <input type="text" name="wmc_custom_button_size" placeholder="Ej: 13px" value="<?php echo esc_attr( get_option('wmc_custom_button_size', '13px') ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Mostrar ícono de WhatsApp en el botón', 'woocommerce-whatsapp'); ?></th>
                    <td><input type="checkbox" name="wmc_show_whatsapp_icon" value="1" <?php checked(1, get_option('wmc_show_whatsapp_icon')); ?> /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
