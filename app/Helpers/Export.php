<?php 

namespace WPP\Helpers;

use WPP\Model\Entity\Settings;

/**
 * Export plugin data
 * 
 * @package Helper
 * @since 1.0.0
 */
class Export 
{
    private array $data;

    public function __construct()
    {
        $this->data = [
            'pagarme_settings'   => $this->get_settings_data(),
            'override_templates' => $this->check_override_pagarme_templates(),
            'site_data'          => [
                'active_gateways'  => $this->get_site_gateways(),
                'active_plugins'   => $this->get_active_plugins(),
                'acrive_theme'     => $this->get_active_theme()
            ]
        ];
    }


    public function get_data(): array
    {
        return $this->data;
    }


    private function get_settings_data(): array
    {
        $gateways = $this->get_pagarme_gateways_data();
        $model = new Settings();
        
        return [
            'success_status'      => $model->get_success_status(),
            'payment_mode'        => $model->get_payment_mode(),
            'credit_installments' => $model->get_credit_installments(),
            'webhook_token'       => $model->get_webhook_token(),
            'erase_settings'      => $model->get_erase_settings(),
            'gateways'            => $gateways
        ];
    }


    private function get_pagarme_gateways_data(): array
    {
        return Gateways::pagarme_payment_methods();
    }


    private function check_override_pagarme_templates(): bool
    {
        return is_dir( get_template_directory() . "/pagarme-templates/" );
    }


    private function get_site_gateways(): array
    {
        return Gateways::get_all_payment_methods();
    }


    private function get_active_theme(): array
    {
        $theme = wp_get_theme();

        return [
            'name'    => $theme->name,
            'version' => $theme->version
        ];
    }


    private function get_active_plugins(): array
    {
        return wp_get_active_and_valid_plugins();
    }
}