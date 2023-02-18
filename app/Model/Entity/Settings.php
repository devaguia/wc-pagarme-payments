<?php

namespace WPP\Model\Entity;

use WPP\Model\Repository\Settings as Repository;

/**
 * Settings entity
 * @package Controller 
 * @since 1.0.0
 */
class Settings
{
    private string $secret_key;
    private string $public_key;
    private array $credit_installments;
    private string $success_status;
    private Repository $repository;
    private string $payment_mode;
    private string $webhook_token;


    public function __construct( $single = false )
    {
        $this->repository = new Repository;
        if ( ! $single ) $this->fill_propeties();
    }

    public function fill_propeties(): void
    {
        $fields = $this->repository->find();

        foreach ( $fields as $field ) {
            if ( ! isset( $field->key ) || ! isset( $field->value ) ) continue;
            
            switch ( $field->key ) {
                case 'secret_key':
                    $this->set_secret_key( $field->value );
                    break;
                
                case 'public_key':
                    $this->set_public_key( $field->value );
                    break;
            
                case 'credit_installments':
                    $this->set_credit_installments( unserialize( $field->value ) );
                    break;
        
                case 'success_status':
                    $this->set_success_status( $field->value );
                    break;

                case 'payment_mode':
                    $this->set_payment_mode( $field->value );
                    break;

                case 'webhook_token':
                    $this->set_webhook_token( $field->value );
                    break;
            }
        }
    }


    public function save()
    {
       return $this->repository->save( $this->get_fields() );
    }


    public function get_single( string $key )
    {
        $reult = $this->repository->find( $key );
        if ( is_array( $reult ) && isset( $reult[0] ) ) {
            return $reult[0];
        }
        return ;
    }


    public function save_single( string $key, string $value )
    {
        return $this->repository->save( [ $key => $value ] );
    }


    private function get_fields(): array
    {
        return [
            'secret_key'           => $this->get_secret_key(),
            'payment_mode'         => $this->get_payment_mode(),
            'public_key'           => $this->get_public_key(),
            'success_status'       => $this->get_success_status(),
            'webhook_token'        => $this->get_webhook_token()
        ];
    }

    public function get_secret_key(): string
    {
        return $this->secret_key;
    }


    public function set_secret_key( string $value ): void
    {
        $this->secret_key = $value;
    }


    public function get_public_key(): string
    {
        return $this->public_key;
    }


    public function set_public_key( string $value ): void
    {
        $this->public_key = $value;
    }


    public function get_credit_installments(): array
    {
        return $this->credit_installments;
    }


    public function set_credit_installments( array $value ): void
    {
        $this->credit_installments = $value;
    }


    public function get_success_status(): string
    {
        return $this->success_status;
    }


    public function set_success_status( string $value ): void
    {
        $this->success_status = $value;
    }


    public function get_payment_mode(): string
    {
        return $this->payment_mode;
    }


    public function set_payment_mode( string $value ): void
    {
        $this->payment_mode = $value;
    }

    public function get_webhook_token(): string
    {
        return $this->webhook_token;
    }


    public function set_webhook_token( string $value ): void
    {
        $this->webhook_token = $value;
    }
}