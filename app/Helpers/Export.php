<?php 

namespace WPP\Helpers;

/**
 * Export plugin data
 * @package Helper
 * @since 1.0.0
 */
class Export 
{
    public function __construct()
    {
        $data = [
            'pagarme_settings'   => $this->get_settings_data(),
            'pagarme_orders'     => $this->get_pagarme_orders_quantity(),
            'override_templates' => $this->check_override_pagarme_templates(),
            'site_data'          => [
                'active_gateways'  => $this->get_active_gateways(),
                'active_plugins'   => $this->get_active_plugins(),
                'acrive_theme'     => $this->get_active_theme()
            ]
        ];

        $this->create_file( $data );
    }

    private function create_file( $data ): bool
    {
        return true;
    }

    public function get_export_file_url(): string
    {
        return true;
    }

    private function get_settings_data(): array
    {
        $gateways = $this->get_pagarme_gateways_data();
        return [];
    }

    private function get_pagarme_gateways_data(): array
    {
        return [];
    }

    private function check_override_pagarme_templates(): array
    {
        return [];
    }

    private function get_pagarme_orders_quantity(): array
    {
        return [];
    }

    private function get_active_gateways(): array
    {
        return [];
    }

    private function get_active_theme(): array
    {
        return [];
    }

    private function get_active_plugins(): array
    {
        return [];
    }
}