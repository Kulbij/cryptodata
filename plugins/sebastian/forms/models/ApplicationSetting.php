<?php namespace Sebastian\Forms\Models;

use Model;

class ApplicationSetting extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'sebastian_forms_application_settings';

    public $settingsFields = 'fields.yaml';

    public $belongsTo = [
    	'tempalte' => ['System\Models\MailTemplate',
            'key' => 'tempalte_cde',
            'otherKey' => 'code',
        ],
    ];
}
