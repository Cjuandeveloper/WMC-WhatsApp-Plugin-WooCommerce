<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode('wmc_whatsapp_button', 'wmc_add_whatsapp_button_shortcode');

function wmc_add_whatsapp_button_shortcode($in_archive = false) {
    if ( get_option('wmc_enable_button') || ( $in_archive && get_option('wmc_enable_button_in_archive') ) ) {
        global $product;

        if ( ! $product ) {
            if ( is_singular('product') ) {
                $product_id = get_the_ID();
                $product = wc_get_product($product_id);
            } else {
                return '<p>El botón de WhatsApp solo se puede mostrar en páginas de productos.</p>';
            }
        }

        if ( ! $product ) {
            return '<p>Producto no encontrado.</p>';
        }

        $product_name             = $product->get_name();
        $product_url              = get_permalink($product->get_id());
        $whatsapp_number          = get_option('wmc_whatsapp_number');
        $button_text              = get_option('wmc_button_text', 'Compra x WhatsApp');
        $default_message          = get_option('wmc_default_message', 'Hola, estoy interesado en este producto.');
        $base_message             = "$default_message\n\n$product_name";

        $button_bg_color          = get_option('wmc_button_bg_color', '#25D366');
        $button_hover_bg_color    = get_option('wmc_button_hover_bg_color', '#1ebe5b');
        $button_text_color        = get_option('wmc_button_text_color', '#ffffff');
        $button_hover_text_color  = get_option('wmc_button_hover_text_color', '#ffffff');
        $custom_font_size         = get_option('wmc_custom_button_size', '13px');
        $show_icon                = get_option('wmc_show_whatsapp_icon', true);

        $button_style = "background-color: $button_bg_color; color: $button_text_color; width: 100%; padding: 18px 20px; border-radius: 5px; font-weight: bold; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; font-family: inherit;";
        $text_style   = "font-size: $custom_font_size; display: inline-block; line-height: 1.2;";
        $is_archive   = $in_archive || is_shop() || is_product_category() || is_product_tag();

        ob_start();
        ?>
        <div class="wmc-button-wrapper" style="text-align: center; <?= $is_archive ? 'margin:5px;' : 'margin:10px 0;'; ?>">
            <a href="#"
               class="wmc-whatsapp-button"
               data-base-message="<?php echo esc_attr($base_message); ?>"
               data-product-url="<?php echo esc_url($product_url); ?>"
               style="<?php echo esc_attr($button_style); ?>"
               target="_blank"
               rel="noopener">
               <span style="<?php echo esc_attr($text_style); ?>">
                   <?php echo esc_html($button_text); ?>
                   <?php if ( $show_icon ) : ?>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                           style="margin-left: 8px; vertical-align: middle; width: 1em; height: 1em;"
                           aria-hidden="true">
                        <path fill="currentColor" d="M16 0C7.164 0 0 7.164 0 16c0 2.82.738 5.543 2.137 7.956L.05 31.137l7.313-2.051A15.87 15.87 0 0 0 16 32c8.837 0 16-7.164 16-16S24.837 0 16 0zm0 29.333a13.28 13.28 0 0 1-6.813-1.87l-.487-.29-4.354 1.221 1.193-4.237-.317-.516A13.215 13.215 0 1 1 16 29.333zm7.46-9.247c-.413-.206-2.447-1.21-2.828-1.347-.38-.143-.655-.206-.93.206s-1.067 1.347-1.31 1.62c-.242.275-.482.31-.895.103-.413-.206-1.743-.64-3.32-2.04-1.228-1.094-2.057-2.443-2.296-2.856-.24-.413-.026-.634.18-.84.184-.183.413-.482.62-.723.206-.24.275-.413.413-.688.14-.275.07-.516-.035-.723-.104-.206-.93-2.236-1.274-3.065-.337-.82-.68-.708-.93-.723l-.79-.017a1.515 1.515 0 0 0-1.095.516c-.38.413-1.437 1.405-1.437 3.43s1.47 3.978 1.673 4.255c.206.275 2.895 4.41 7.02 6.19.98.423 1.743.674 2.338.862.98.312 1.87.267 2.573.162.784-.117 2.447-1 2.793-1.964.344-.964.344-1.79.24-1.964-.104-.174-.38-.275-.79-.48z"/>
                      </svg>
                   <?php endif; ?>
               </span>
            </a>
        </div>

        <style>
        @media screen and (min-width: 768px) {
            .wmc-button-wrapper {
                margin-bottom: 20px !important;
            }
        }
        .wmc-whatsapp-button:hover {
            background-color: <?php echo esc_attr($button_hover_bg_color); ?> !important;
            color: <?php echo esc_attr($button_hover_text_color); ?> !important;
        }
        </style>

        <script>
        window.addEventListener('load', function () {
            document.querySelectorAll('.wmc-whatsapp-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    const baseMessage = button.getAttribute('data-base-message');
                    const url = button.getAttribute('data-product-url');

                    function getVariationText() {
                        const selects = document.querySelectorAll('form.variations_form select');
                        let result = '';
                        selects.forEach(select => {
                            const value = select.options[select.selectedIndex]?.text || '';
                            if (value && value !== 'Elige una opción') {
                                result += `\n${value}`;
                            }
                        });
                        return result;
                    }

                    const variations = getVariationText();
                    const fullMessage = `${baseMessage}${variations}\n\n${url}`;
                    const encoded = encodeURI(fullMessage);
                    const phone = "<?php echo esc_js($whatsapp_number); ?>";
                    button.setAttribute('href', `https://wa.me/${phone}?text=${encoded}`);
                });
            });
        });
        </script>
        <?php
        return ob_get_clean();
    }
}

add_action('woocommerce_after_shop_loop_item', 'wmc_add_whatsapp_button_to_archive', 20);
function wmc_add_whatsapp_button_to_archive() {
    if ( get_option('wmc_enable_button_in_archive') ) {
        echo wmc_add_whatsapp_button_shortcode(true);
    }
}

add_action('woocommerce_before_single_product', 'wmc_maybe_hide_add_to_cart');
function wmc_maybe_hide_add_to_cart() {
    if ( get_option('wmc_hide_add_to_cart') ) {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
        remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
        remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
    }
}
