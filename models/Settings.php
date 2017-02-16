<?php namespace GetRight\BackendCustomizer\Models;

use Model;

/**
 * Register settings fields.
 * Class Settings
 * @package GetRight\BackendCustomizer\Models
 */
class Settings extends Model
{
    /**
     * Implement the core settings model to store our settings.
     * @var array $implement
     */
    public $implement = ['System.Behaviors.SettingsModel'];

    /**
     * Define unique settings code used in database.
     * @var string $settingsCode
     */
    public $settingsCode = 'getright_backendcustomizer_settings';

    /**
     * Define file for your form fields.
     * @var string $settingsFields
     */
    public $settingsFields = 'fields.yaml';

    /**
     * Attach file upload custom css.
     * @var array $attachOne
     */
    public $attachOne = [
        'custom_css' => [
            'System\Models\File',
            'public' => true,
        ]
    ];
}