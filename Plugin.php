<?php namespace GetRight\BackendCustomizer;

use System\Classes\PluginBase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Event;
use GetRight\BackendCustomizer\Models\Settings;
use Backend\Facades\Backend;
use Backend\Classes\Controller as BackendController;

/**
 * Backend Customizer Plugin.
 * Class Plugin
 * @package GetRight\BackendCustomizer
 */
class Plugin extends PluginBase
{

    /**
     * Register plugin details.
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => Lang::get('getright.backendcustomizer::lang.plugin.name'),
            'description' => Lang::get('getright.backendcustomizer::lang.plugin.description'),
            'author'      => 'getRight',
            'icon'        => 'icon-paint-brush',
            'iconSvg'     => 'plugins/getright/backendcustomizer/assets/images/backend-customizer-icon.svg',
            'homepage'    => 'https://www.getright.nl'
        ];
    }

    /**
     * Register a new item in the Settings menu.
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'          => Lang::get('getright.backendcustomizer::lang.plugin.menu_label'),
                'description'    => Lang::get('getright.backendcustomizer::lang.plugin.menu_description'),
                'category'       => Lang::get('getright.backendcustomizer::lang.plugin.menu_category'),
                'icon'           => 'icon-paint-brush',
                'class'          => 'GetRight\BackendCustomizer\Models\Settings',
                'order'          => 500,
                'keywords'       => 'backend customizer',
            ]
        ];
    }

    /**
     * Register permissions.
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'getright.backendcustomizer.access_settings' => [
                'label' => Lang::get('getright.backendcustomizer::lang.plugin.access_settings_label'),
                'tab'   => Lang::get('getright.backendcustomizer::lang.plugin.access_settings_tab')
            ]
        ];
    }

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager) {

            // If not empty Dashboard Icon, overwrite it
            if (!empty(Settings::get('october_dashboard_icon'))) {
                $manager->addMainMenuItems('October.Backend', [
                    'dashboard' => [
                        'icon' => Settings::get('october_dashboard_icon'),
                    ],
                ]);
            }

            // If not empty Settings Icon, overwrite it.
            if (!empty(Settings::get('october_settings_icon'))) {
                $manager->addMainMenuItems('October.System', [
                    'system' => [
                        'icon' => Settings::get('october_settings_icon'),
                    ],
                ]);
            }

            // If not empty Media Icon, overwrite it.
            if (!empty(Settings::get('october_media_icon'))) {
                $manager->addMainMenuItems('October.Cms', [
                    'media' => [
                        'icon' => Settings::get('october_media_icon'),
                    ],
                ]);
            }

            // If not empty Cms Icon, overwrite it.
            if (!empty(Settings::get('october_cms_icon'))) {
                $manager->addMainMenuItems('October.Cms', [
                    'cms' => [
                        'icon' => Settings::get('october_cms_icon'),
                    ],
                ]);
            }
        });



        BackendController::extend(function ($controller) {
            $setting = Settings::where('item', 'getright_backendcustomizer_settings')->first();

            if (!empty($setting->custom_css->getPath())) {
                $controller->addCss($setting->custom_css->getPath());
            }
        });
    }
}
