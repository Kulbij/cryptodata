<?php namespace Sebastian\Forms\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Sebastian\Forms\Models\ApplicationSetting;

/**
 * Application Settings Back-end Controller
 */
class ApplicationSettings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController'
    ];

    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Sebastian.Forms', 'forms', 'applications');
    }

    public function index()
    {
        $this->asExtension('FormController')->update();
    }

    public function formFindModelObject()
    {
        return ApplicationSetting::instance();
    }

    public function index_onSave()
    {
        return $this->asExtension('FormController')->update_onSave();
    }
}
