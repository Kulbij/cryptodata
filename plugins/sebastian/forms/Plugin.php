<?php namespace Sebastian\Forms;

use Backend;
use System\Classes\PluginBase;

/**
 * Forms Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Forms',
            'description' => 'No description provided yet...',
            'author'      => 'Sebastian',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Sebastian\Forms\Components\Application' => 'applicationForm',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'sebastian.forms.some_permission' => [
                'tab' => 'Forms',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'forms' => [
                'label'       => 'Forms',
                'url'         => Backend::url('sebastian/forms/applications'),
                'icon'        => 'icon-pencil',
                'permissions' => ['sebastian.forms.*'],
                'order'       => 500,

                'sideMenu' => [
                    'applications' => [
                        'label'       => 'Applications',
                        'url'         => Backend::url('sebastian/forms/applications'),
                        'icon'        => 'icon-address-book',
                        'order'       => 100,
                        'permissions' => ['sebastian.marketplace.applications_manage']
                    ],
                ],
            ],
        ];
    }
}
